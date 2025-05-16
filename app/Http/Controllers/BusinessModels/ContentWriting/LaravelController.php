<?php
namespace App\Http\Controllers\BusinessModels\ContentWriting;

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
use Yajra\DataTables\Facades\DataTables;


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
        $keyword = $request->get('keyword');
        $noOfProducts = intval($request->get('noOfProducts'));
    
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);
    
        $query = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'name', 'slug', 'default_wc', 'default_price', 'extra_word', 'ta_standard', 'ta_express', 'q_standard', 'q_premium', 'q_expert', 'img_price')
            ->where('published', 1);
    
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('slug', 'LIKE', '%' . $keyword . '%');
            });
        }
    
        $allProducts = $query->orderByDesc('default_price')->get();
        $turnaroundOptions = ['ta_standard', 'ta_express'];
        $qualityOptions = ['q_standard', 'q_premium', 'q_expert'];
    
        $wordCount = 1;
        $imageCount = 1;
        $quantity = 1;
    
        $allProducts = collect($allProducts);
        $allProducts->each(function ($product) use ($wordCount, $imageCount, $quantity, $qualityOptions, $turnaroundOptions) {
            $product->turnaround = $turnaroundOptions[array_rand($turnaroundOptions)];
            $product->quality = $qualityOptions[array_rand($qualityOptions)];
    
            $qlty_factor = match ($product->quality) {
                'q_premium' => $product->q_premium,
                'q_expert' => $product->q_expert,
                default => $product->q_standard,
            };
    
            $wc_price = max(0, (($wordCount - $product->default_wc) / 25) * $product->extra_word);
            $img_total = max(0, ($imageCount - 1) * $product->img_price);
            $ta_total = $product->turnaround === 'ta_express' ? 25 : 0;
    
            $base_total = $product->default_price + $wc_price + $img_total + $ta_total;
            $product->unit_price = ($base_total + ($base_total * $qlty_factor)) * $quantity;
    
            $product->wordcount = $wordCount;
            $product->imagecount = $imageCount;
            $product->quantity = $quantity;
        });
    
        $minTotal = ($noOfProducts || $keyword) ? ($invoiceAmount * 0.6) : $invoiceAmount;
        $maxTotal = $invoiceAmount * 1.10;
        $bestMatch = null;
        $bestTotal = 0;
        $bestDistance = null;
    
        for ($i = 0; $i < 20; $i++) {
            $shuffled = $allProducts->shuffle();
            $selected = [];
            $currentTotal = 0;
    
            foreach ($shuffled as $product) {
                if ($noOfProducts) {
                    if (count($selected) >= $noOfProducts) break;
    
                    if ($currentTotal + $product->unit_price <= $invoiceAmount) {
                        $selected[] = $product;
                        $currentTotal += $product->unit_price;
                    }
                } else {
                    if ($currentTotal + $product->unit_price <= $maxTotal) {
                        $selected[] = $product;
                        $currentTotal += $product->unit_price;
    
                        if ($currentTotal >= $minTotal && $currentTotal <= $maxTotal && $currentTotal > $bestTotal) {
                            $bestMatch = $selected;
                            $bestTotal = $currentTotal;
                        }
                    }
                }
            }
    
            if ($noOfProducts && count($selected) === $noOfProducts) {
                $distance = abs($invoiceAmount - $currentTotal);
                if ($bestMatch === null || $distance < $bestDistance) {
                    $bestMatch = $selected;
                    $bestTotal = $currentTotal;
                    $bestDistance = $distance;
                    if ($currentTotal >= ($invoiceAmount * 0.9)) break;
                }
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
    
            $product->project_title = null;
            $product->reference_link = null;
            $product->subject = null;
            $product->preferred_voice = null;
            $product->preferred_writing_style = null;
            $product->brand_name = null;
            $product->audience = null;
            $product->note = null;
            $product->param_status = false;
        });
    
        $productList = $bestMatch->map(function ($product) {
            return [
                'id' => $product->id,
                'wordcount' => $product->wordcount,
                'imagecount' => $product->imagecount,
                'quantity' => $product->quantity,
                'turnaround' => $product->turnaround,
                'quality' => $product->quality,
                'unit_price' => $product->unit_price,
                'project_title' => null,
                'reference_link' => null,
                'subject' => null,
                'preferred_voice' => null,
                'preferred_writing_style' => null,
                'brand_name' => null,
                'audience' => null,
                'note' => null
            ];
        })->toArray();
    
        session()->forget('ready_products');
        session()->put('ready_products', $productList);
        session(['current_amount' => $bestTotal]);
    
        $modelType = $site->businessModel->model_type;
        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $bestMatch,
            'site' => $site,
            'total' => $bestTotal
        ])->render();
    
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
            ->select('id', 'category_id', 'name', 'unit_price', 'slug')
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
            ->select('id', 'category_id', 'name', 'unit_price', 'slug')
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
        $keyword = $request->input('keyword');
        $hasPriceRange = $request->filled('price_from') && $request->filled('price_to');
    
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);
    
        if (!$hasPriceRange) {
            return response()->json([
                'tableRows' => '<tr><td colspan="9" class="text-center text-muted">Please enter a price range to search.</td></tr>'
            ]);
        }
    
        $query = DB::connection($this->connectionType)
            ->table($this->productTable)
            ->select('id', 'name', 'slug', 'default_wc', 'default_price', 'extra_word', 'ta_standard', 'ta_express', 'q_standard', 'q_premium', 'q_expert', 'img_price')
            ->where('products.published', 1);
    
        if (!empty($keyword)) {
            $normalizedSearch = strtolower(str_replace(['-', '_', ' '], '', $keyword));
            $query->where(function ($q) use ($normalizedSearch) {
                $q->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(products.name, '-', ''), '_', ''), ' ', '')) LIKE ?", ["%{$normalizedSearch}%"]);
            });
        }
    
        $readyProducts = session('ready_products', []);
        $readyProductIds = collect($readyProducts)->pluck('id')->toArray();
    
        if (count($readyProductIds) > 0) {
            $query->whereNotIn('id', $readyProductIds);
        }
    
        $totalCount = $query->count();
        $page = $request->input('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $products = $query->skip($offset)->take($perPage)->get();
        $totalPages = ceil($totalCount / $perPage);
        $paginationPages = $this->smartPagination($page, $totalPages);
    
        if ($products->isEmpty()) {
            return response()->json([
                'tableRows' => '<tr><td colspan="9" class="text-center text-muted"> No results found. Try randomizing or use a different keyword.</td></tr>'
            ]);
        }
    
        $turnaround  = 'ta_standard';
        $quality     = 'q_standard';
    
        $products = collect($products);
    
        $products->each(function ($product) use ($turnaround, $quality) {
            $product->turnaround = $turnaround;
            $product->quality = $quality;
            $wc = $product->default_wc;
            $img = 1;
            $qty = 1;
    
            $default_wc = $product->default_wc;
            $default_price = $product->default_price;
            $extra_word = $product->extra_word;
            $ta_standard = $product->ta_standard;
            $ta_express = $product->ta_express;
            $img_price = $product->img_price;
    
            $q_standard = $product->q_standard;
            $q_premium = $product->q_premium;
            $q_expert = $product->q_expert;
    
            $wc_price = 0;
            if ($wc > $default_wc) {
                $wc_diff = $wc - $default_wc;
                $wc_price = ($wc_diff / 25) * $extra_word;
            }
    
            $img_total = ($img > 1) ? ($img - 1) * $img_price : 0;
    
            $ta_total = ($turnaround == 'ta_express') ? 25 : 0;
    
            $qlty_factor = 0;
            if ($quality == 'q_premium') {
                $qlty_factor = $product->q_premium;
            } elseif ($quality == 'q_expert') {
                $qlty_factor = $product->q_expert;
            } else {
                $qlty_factor = $product->q_standard;
            }
    
            $total = $default_price + $wc_price + $img_total + $ta_total;
            $final_total = ($total + ($total * $qlty_factor)) * $qty;
    
            $product->unit_price = $final_total;
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
            $product->project_title = null;
            $product->reference_link = null;
            $product->subject = null;
            $product->preferred_voice = null;
            $product->preferred_writing_style = null;
            $product->brand_name = null;
            $product->audience = null;
            $product->note = null;
            $product->param_status = false;
        });
    
        $modelType = $site->businessModel->model_type;
        $random_amount = session('current_amount', 0);
    
        $tableRows = view("invoice.{$modelType}.add_product_rows", ['products' => $products, 'site' => $site, 'random_amount' => $random_amount])->render();
        $paginationHtml = view("invoice.{$modelType}.pagination", ['totalPages' => $totalPages, 'paginationPages' => $paginationPages, 'currentPage' => $page])->render();
    
        return response()->json([
            'tableRows' => $tableRows,
            'paginationHtml' => $paginationHtml,
            'random_amount' => $random_amount
        ]);
    }
    
    public function updateProduct(Request $request)
    {
        $site_id     = session('customer.site_id');
        $product_id   = (int) $request->input('product_id');
        $wordCount   = (int) $request->input('wordcount', 0);
        $imageCount  = (int) $request->input('imagecount', 1);
        $quantity    = (int) $request->input('quantity', 1);
        $turnaround  = $request->input('turnaround', 'ta_standard');
        $quality     = $request->input('quality', 'standard');
        $unit_price  = $request->input('unit_price');
        
    
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        
    }
    

    private function smartPagination($currentPage, $totalPages)
    {
        $pages = [];
        $pages[] = 1;

        if ($currentPage > 4) {
            $pages[] = '...';
        }

        $start = max(2, $currentPage - 3);
        $end = min($totalPages - 1, $currentPage + 3);

        for ($i = $start; $i <= $end; $i++) {
            $pages[] = $i;
        }

        if ($currentPage < $totalPages - 3) {
            $pages[] = '...';
        }

        if ($totalPages > 1) {
            $pages[] = $totalPages;
        }

        return array_values(array_unique($pages));
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
            ->select('id', 'category_id', 'name', 'unit_price') 
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
        
       
        $invoice_data['currency'] =  site_currency();
    
        $invoice_data['products'] = $products;
        $invoice_data['product_ids'] = $productIds;
    
        $modelType = strtolower($site->businessModel->model_type);
        $siteIdInWords = numberToWords($site->id);
        $viewPath = "websites.{$modelType}.{$siteIdInWords}";
    
      
        try {

            $this->updateProductPrice($productDataArray);
            InvoiceController::createInvoiceHistory($invoice_data);
            $pdf = PDF::loadView($viewPath, $invoice_data);
            $pdf->setPaper('A4', 'portrait');
            if ($request->filled('invoice_file_name')) {
                $filename = $request->input('invoice_file_name') . '.pdf';
            } else {
                $filename = $invoice_data['invoice_number'] . '.pdf';
            }            
            
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
