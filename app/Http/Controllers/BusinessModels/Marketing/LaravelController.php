<?php
namespace App\Http\Controllers\BusinessModels\Marketing;

use App\Http\Controllers\Controller;
use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\BusinessModel;
use App\Models\Website;
use App\Models\Invoice;
use App\Models\ProductPriceHistory;
use App\Models\InvoiceGenerationHistory;
use App\Services\DynamicDatabaseService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\ViewNotFoundException;
use Carbon\Carbon;


class LaravelController extends Controller
{
    private $productTable;
    private $connectionType;

    public function __construct()
    {
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
        $this->productTable = getProductTable($site->technology);
        $this->connectionType = 'dynamic';
    }

 
    public function randomProducts(Request $request)
    {
        $site_id = $request->get('site_id');
        $invoiceAmount = floatval($request->get('invoice_amount'));
    
        $priceFrom = $request->get('price_from');
        $priceTo = $request->get('price_to');
    
        $randomizeKeywordInput = trim($request->get('randomizeKeywordInput'));
        $noOfProducts = intval($request->get('noOfProducts'));

        if($randomizeKeywordInput ||  $noOfProducts){
            $minTotal = $invoiceAmount * 0.5; 
        }else{
            $minTotal = $invoiceAmount* 0.05; 
        }
        $maxTotal = $invoiceAmount * 1.10;
    
        $site = Website::findOrFail($site_id);
        $productstable = getProductTable($site->technology);
        DynamicDatabaseService::connect($site);
        
        $keyword = strtolower(str_replace('-', '', trim($randomizeKeywordInput)));

        $allProducts = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id','subscription','category_id', 'name', 'unit_price','slug')
            ->when($randomizeKeywordInput, function ($query) use ($keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->whereRaw("REPLACE(LOWER(name), '-', '') LIKE ?", ["%{$keyword}%"])
                      ->orWhereIn('category_id', function ($sub) use ($keyword) {
                          $sub->select('id')
                              ->from('categories')
                              ->whereRaw("REPLACE(LOWER(name), '-', '') LIKE ?", ["%{$keyword}%"]);
                      });
                });
            })
            ->when($priceFrom && $priceTo, function ($query) use ($priceFrom, $priceTo) {
                return $query->whereBetween('unit_price', [$priceFrom, $priceTo]);
            })
            ->orderByDesc('unit_price')
            ->get()
            ->shuffle();

        $bestMatch = null;
        $bestTotal = 0;
        $selectedCategories = [];
    
        for ($i = 0; $i < 10; $i++) {
            $shuffled = $allProducts;
            $selected = [];
            $currentTotal = 0;
    
            foreach ($shuffled as $product) {

                if ($noOfProducts && count($selected) >= $noOfProducts) {
                    break;
                }
                $price = floatval($product->unit_price);
                
                if (in_array($product->category_id, $selectedCategories) && count($selected) > 0) {
                    continue;
                }

                if (($currentTotal + $price) <= $maxTotal) {
                    $selected[] = $product;
                    $currentTotal += $price;
    
                    if ($currentTotal >= $minTotal && $currentTotal <= $maxTotal) {
                        if ($currentTotal > $bestTotal) {
                            $bestMatch = $selected;
                            $bestTotal = $currentTotal;
                        }
                    }
                }
            }
    
            if ($bestMatch) {
                break;
            }
        }
    
        if (!$bestMatch) {
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No matching combination found, try again please'
            ]);
        }

        
         $bestMatch = collect($bestMatch); 
         $bestMatch->each(function ($product) {
             $product->category_name = DB::connection($this->connectionType)->table('categories')->where('id', $product->category_id)->value('name') ?? 'unknown';
         
         });
 
         $bestMatch->each(function ($product) use ($site_id) {
             $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                                              ->where('product_id', $product->id)
                                              ->orderByDesc('last_price_changed')
                                              ->first();
         
             if ($lastUpdate) {
 
                 $lastPriceChanged = Carbon::parse($lastUpdate->last_price_changed);
                 $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                 $remainingDays = now()->diffInDays($nextPriceChangeDate, false);
                 $product->remaining_days = round(max($remainingDays, 0));
                 $product->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
 
             } else {
                 $product->can_edit_price = 1;
                 $product->remaining_days = 0;
             }
         });
        
         $productList = $bestMatch->map(function ($product) {
            return [
                'id' => $product->id,
                'unit_price' => $product->unit_price,
            ];
        })->toArray();
        
        session()->forget('ready_products'); 
        session()->put('ready_products', $productList);
        session(['current_amount' => $bestTotal]);
        $modelType = $site->businessModel->model_type;
        $tableRows = view("invoice.{$modelType}.random_product_rows", ['products' => $bestMatch,'site' => $site,  'total' => $bestTotal])->render();
        
        return response()->json([
            'tableRows' => $tableRows,
            'total' => $bestTotal
        ]);
    }
    
    public function addProducts(Request $request)
    {
        $site_id = $request->get('site_id');
        $productsData = $request->get('products');
    
        $site = Website::findOrFail($site_id);
        $productstable = getProductTable($site->technology);
        DynamicDatabaseService::connect($site);
    
        $readyProducts = session()->get('ready_products', []);
    
        foreach ($productsData as $productData) {
            $productId = $productData['product_id'];
            $unitPrice = floatval($productData['unit_price']);
    
            $exists = false;
            foreach ($readyProducts as &$item) {
                if ($item['id'] == $productId) {
                    $item['unit_price'] = $unitPrice;
                    $exists = true;
                    break;
                }
            }
    
            if (!$exists) {
                $readyProducts[] = [
                    'id' => $productId,
                    'unit_price' => $unitPrice,
                ];
            }
        }
    
        session()->put('ready_products', $readyProducts);
    
        $productIds = collect($readyProducts)->pluck('id')->reverse()->values()->toArray();

        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id','subscription', 'category_id', 'name', 'unit_price', 'slug')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $products = collect($productIds)->map(function ($id) use ($products) {
            return $products[$id];
        });
    
        $products = $products->map(function ($product) use ($readyProducts, $site_id) {
            $sessionProduct = collect($readyProducts)->firstWhere('id', $product->id);
            $product->unit_price = $sessionProduct['unit_price'] ?? $product->unit_price;
            $product->category_name = DB::connection($this->connectionType)->table('categories')->where('id', $product->category_id)->value('name') ?? 'unknown';
    
            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();
    
            if ($lastUpdate) {
                $lastPriceChanged = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = round(max($remainingDays, 0));
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
            }
    
            return $product;
        });
    
        $modelType = $site->businessModel->model_type;
        session(['current_amount' => collect($products)->sum('unit_price')]);
    
        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $products,
            'site' => $site,
            'total' => collect($products)->sum('unit_price')
        ])->render();
    
        return response()->json([
            'tableRows' => $tableRows,
            'total' => collect($products)->sum('unit_price')
        ]);
    }
    
    
    public function removeProduct(Request $request)
    {
        $productId = $request->get('product_id');
        $site_id = $request->get('site_id');
        $site = Website::findOrFail($site_id);

        $readyProducts = session('ready_products', []);

        $updatedProducts = collect($readyProducts)->filter(function ($product) use ($productId) {
            return $product['id'] != $productId;
        })->values()->toArray();

        session()->put('ready_products', $updatedProducts);
        if (empty($updatedProducts)) {
            return response()->json([
                'tableRows' => '',
                'currency' => null,
            ]);
        }

        DynamicDatabaseService::connect($site);

        $productIds = array_column($updatedProducts, 'id');

        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id','subscription','category_id', 'name', 'unit_price', 'slug')
            ->whereIn('id', $productIds)
            ->get();

        $products = $products->map(function ($product) use ($updatedProducts, $site_id) {
            $sessionProduct = collect($updatedProducts)->firstWhere('id', $product->id);
            $product->unit_price = $sessionProduct['unit_price'] ?? $product->unit_price;
            $product->category_name = DB::connection($this->connectionType)->table('categories')->where('id', $product->category_id)->value('name') ?? 'unknown';

            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();

            if ($lastUpdate) {
                $lastPriceChanged = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = round(max($remainingDays, 0));
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
            }

            return $product;
        });

        $modelType = $site->businessModel->model_type;
        session(['current_amount' => collect($products)->sum('unit_price')]);
        $no_of_products = count($products);
        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $products,
            'site' => $site,
            'total' => collect($products)->sum('unit_price')
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total' => collect($products)->sum('unit_price')
        ]);
    }
    
    public function updateProduct(Request $request)
    {   
        $category_id = $request->get('category_id');
        $productId = $request->get('product_id'); 
        $subscription = $request->get('subscription');
        $site_id = session('customer.site_id');

        if (!$site_id) {
            return response()->json(['error' => 'Site ID not found in session.']);
        }

        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $readyProducts = session()->get('ready_products', []);

        $readyProducts = array_filter($readyProducts, function ($product) use ($productId) {
            return $product['id'] != $productId;
        });

        $newProduct = DB::connection($this->connectionType)->table($this->productTable)->where('subscription', $subscription)->where('category_id', $category_id) ->first();

        if (!$newProduct) {
            return response()->json(['error' => "The duration '{$subscription}' was not found in the same package."]);
        }

        $readyProducts[] = [
            'id' => $newProduct->id,
            'subscription' => $newProduct->subscription,
            'unit_price' => $newProduct->unit_price,
        ];

        session()->put('ready_products', array_values($readyProducts)); 

        $productIds = collect($readyProducts)->pluck('id')->reverse()->values()->toArray();
        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'subscription', 'category_id', 'name', 'unit_price', 'slug')
            ->whereIn('id', $productIds)
            ->orderByRaw('FIELD(id, ' . implode(',', $productIds) . ')') 
            ->get()
            ->keyBy('id');
    
    
        $products = collect($productIds)->map(function ($id) use ($products) {
            return $products[$id];
        });
    
        $products = $products->map(function ($product) use ($readyProducts, $site_id) {
            $sessionProduct = collect($readyProducts)->firstWhere('id', $product->id);
            $product->subscription = $sessionProduct['subscription'] ?? $product->subscription;

            $categoryName = DB::connection($this->connectionType)->table('categories')->where('id', $product->category_id)->value('name');
            $product->category_name = $categoryName ?: 'unknown';

            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();
    
            if ($lastUpdate) {
                $lastPriceChanged = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = round(max($remainingDays, 0));
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
            }
    
            return $product;
        });
    
        $totalAmount = collect($readyProducts)->sum('unit_price');
        session(['current_amount' => $totalAmount]);
    
        $modelType = $site->businessModel->model_type;
        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $products,
            'site' => $site,
            'total' => $totalAmount
        ])->render();
    
        return response()->json([
            'tableRows' => $tableRows,
            'total' => $totalAmount
        ]);
    }
    

    public function clearProducts(Request $request)
    {
        session()->forget('ready_products');
        session()->forget('current_amount');
        return response()->json([
            'success' => true,
            'tableRows' => '',
            'currency' => null,
            'total' => 0
        ]);
    }

    public function filterProducts(Request $request)
    {
        $site_id = session('customer.site_id');
        $search_type = $request->input('search_type');
        $site = Website::findOrFail($site_id);
        $productstable = getProductTable($site->technology);
        DynamicDatabaseService::connect($site);
    
        $hasPriceRange = $request->filled('price_from') && $request->filled('price_to');
    
        if (!$hasPriceRange) {
            return response()->json([
                'tableRows' => '<tr><td colspan="6" class="text-center text-muted">Please enter a keyword or price range to search.</td></tr>'
            ]);
        }
    
        $query = DB::connection($this->connectionType)
        ->table($this->productTable)
        ->select('products.id', 'products.subscription','products.category_id', 'products.name', 'products.unit_price', 'products.slug')
        ->where('products.published', 1);
    
        if ($hasPriceRange) {
            $query->whereBetween('unit_price', [
                (float) $request->price_from,
                (float) $request->price_to
            ]);
        }
    
        $readyProducts = session('ready_products', []);
        $readyProductIds = collect($readyProducts)->pluck('id')->toArray();
    
        if (count($readyProductIds) > 0) {
            $query->whereNotIn('products.id', $readyProductIds);
        }
        if($search_type == 'onload'){
            $products = $query->inRandomOrder()->limit(20)->get();
        }else{
            $products = $query->orderBy('unit_price')->get();
        }
        
        if ($products->isEmpty()) {
            return response()->json([
                'tableRows' => '<tr><td colspan="7" class="text-center text-muted"> No results found. Try randomizing or use a different keyword.</td></tr>'
            ]);
        }

        $products = collect($products);
        $products->each(function ($product) {
            $product->category_name = DB::connection($this->connectionType)->table('categories')->where('id', $product->category_id)->value('name') ?? 'unknown';
        });
    
        $products->each(function ($product) use ($site_id) {
            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();
    
            if ($lastUpdate) {
                $lastPriceChanged = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = round(max($remainingDays, 0));
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
            }
        });
    
        $modelType = $site->businessModel->model_type;
        $random_amount = session('current_amount', 0);
        $tableRows = view("invoice.{$modelType}.add_product_rows", 
        ['products' => $products,
         'site' => $site, 
         'random_amount' => $random_amount
         ])->render();
    
        return response()->json([
            'tableRows' => $tableRows,
            'random_amount' => $random_amount
        ]);
    }
    


    public function generateInvoice(Request $request)
    {
        $site_id = $request->input('site_id');
        $site = Website::findOrFail($site_id);

        $invoice_data['site'] = $site;
        $invoice_data['invoice_number'] = $request->input('invoice_number');
        $invoice_data['invoice_date'] = $request->input('invoice_date');
        $invoice_data['customer_name'] = $request->input('customer_name');
        $invoice_data['customer_mobile'] = $request->input('customer_mobile');
        $invoice_data['customer_email'] = $request->input('customer_email');
        $invoice_data['company_email'] = $request->input('company_email');
        $invoice_data['invoice_amount'] = $request->input('invoice_amount');
        $invoice_data['current_amount'] = $request->input('current_amount');
        $invoice_data['discount_amount'] = $request->input('discount_amount');
        $invoice_data['company_name'] = $site->company_name;
        $invoice_data['company_email'] = $site->company_email;
        $invoice_data['company_mobile'] = $site->company_mobile;
        $invoice_data['company_address'] = $site->company_address;
        $invoice_data['invoice_header_image'] = base64EncodeImage($site->invoice_header_image);
        $invoice_data['invoice_footer_image'] = base64EncodeImage($site->invoice_footer_image);
        $invoice_data['invoice_signature'] = base64EncodeImage($site->invoice_signature);
        $invoice_data['company_logo'] = base64EncodeImage($site->company_logo);
        $invoice_data['invoice_image1'] = base64EncodeImage($site->invoice_image1);
        $invoice_data['invoice_image2'] = base64EncodeImage($site->invoice_image2);
        $invoice_data['invoice_image3'] = base64EncodeImage($site->invoice_image3);
        $invoice_data['invoice_template'] = $site->invoice_template;
        $invoice_data['model_type'] = $site->businessModel->model_type;
        $invoice_data['site_id'] = $site->id;
    
        $productDataArray = $request->input('product_data', []);
        DynamicDatabaseService::connect($site);
    
        $productIds = [];
        $customPrices = [];
    
        foreach ($productDataArray as $item) {
            $data = json_decode($item, true);
            if (!empty($data['product_id'])) {
                $productIds[] = $data['product_id'];
                $customPrices[$data['product_id']] = $data['unit_price'];
            }
        }
    
        
        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->whereIn('id', $productIds)
            ->select('id','subscription', 'category_id', 'name', 'unit_price') 
            ->get()
            ->sortBy(function ($product) use ($productIds) {
                return array_search($product->id, $productIds);
            })
            ->values()
            ->map(function ($product) use ($customPrices) {
                $product->unit_price = $customPrices[$product->id] ?? $product->unit_price;
                return $product;
            });
            
        $products->each(function ($product) {
            $product->category_name = DB::connection($this->connectionType)->table('categories')->where('id', $product->category_id)->value('name') ?? 'unknown';
        });
        
       
        $invoice_data['currency'] = site_currency();
    
        $invoice_data['products'] = $products;
        $invoice_data['product_ids'] = $productIds;
    
        $modelType = strtolower($site->businessModel->model_type);
        $siteIdInWords = numberToWords($site->id);
        $viewPath = "websites.{$modelType}.{$siteIdInWords}";
    
      
        try {

            $this->updateProductPrice($productDataArray); //product price update checking

            InvoiceController::createInvoiceHistory($invoice_data);
            $pdf = PDF::loadView($viewPath, $invoice_data);
            $pdf->setPaper('A4', 'portrait');
            $filename = $invoice_data['invoice_number'] . '.pdf';
            return $pdf->download($filename);
        } catch (\Illuminate\View\ViewNotFoundException $e) {
            abort(500, 'Please set up or upload your invoice template.');
        }
    }

    
    protected function updateProductPrice(array $productDataArray)
    {
        $site_id = session('customer.site_id');
    
        foreach ($productDataArray as $item) {
            $data = json_decode($item, true);
    
            if (!empty($data['product_id']) && isset($data['unit_price'])) {
                $product_id = $data['product_id'];
                $new_price = floatval($data['unit_price']);
    
                $product = DB::connection($this->connectionType)
                    ->table($this->productTable)
                    ->where('id', $product_id)
                    ->first();
    
                if (!$product) continue;
    
                $current_price = floatval($product->unit_price);
    
               
                if ($current_price == $new_price) continue;
    
               
                $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                    ->where('product_id', $product_id)
                    ->orderByDesc('last_price_changed')
                    ->first();
    
                // If no history, create once and update
                if (!$lastUpdate) {
                    DB::connection($this->connectionType)
                        ->table($this->productTable)
                        ->where('id', $product_id)
                        ->update(['unit_price' => $new_price]);
    
                    ProductPriceHistory::create([
                        'site_id' => $site_id,
                        'product_id' => $product_id,
                        'unit_price' => $new_price,
                        'last_price_changed' => now(),
                    ]);
                    continue;
                }
             
                // If history exists, only allow update if 3+ months passed
                if (Carbon::parse($lastUpdate->last_price_changed)->diffInMonths(now()) >= 3) {
                    DB::connection($this->connectionType)
                        ->table($this->productTable)
                        ->where('id', $product_id)
                        ->update(['unit_price' => $new_price]);
    
                    ProductPriceHistory::create([
                        'site_id' => $site_id,
                        'product_id' => $product_id,
                        'unit_price' => $new_price,
                        'last_price_changed' => now(),
                    ]);
                }
            }
        }
    }
}
