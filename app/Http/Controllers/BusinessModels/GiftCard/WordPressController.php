<?php
namespace App\Http\Controllers\BusinessModels\GiftCard;

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
use Api2Pdf\Api2Pdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Http;


class WordPressController extends Controller
{
   
    private $productTable;
    private $productPriceTable;
    private $tagsTable;
    private $categoryTable;
    private $termTaxonomyTable;
    private $connectionType;
    private $site;

    public function __construct()
    {
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
        $this->productTable = $site->product_table ?? 'wp_posts';
        $this->productPriceTable = $site->product_price_table ?? 'wp_wc_product_meta_lookup';
        $this->tagsTable = $site->tags_table ?? 'wp_term_relationships';
        $this->termTaxonomyTable = $site->term_taxonomy_table ?? 'wp_term_taxonomy';
        $this->categoryTable = $site->category_table ?? 'wp_terms';
        $this->connectionType = 'dynamic';
    }

    public function randomProducts(Request $request)
    {
        $site_id = $request->get('site_id') ?? session('customer.site_id');
        $invoiceAmount = floatval($request->get('invoice_amount'));
        $priceFrom = $request->get('price_from');
        $priceTo = $request->get('price_to');
        $noOfProducts = intval($request->get('noOfProducts'));
        $categoryId = $request->get('category_name');

        $site = Website::findOrFail($site_id);
        $connection = $this->connectionType;

        DynamicDatabaseService::connect($site);

        $postsTable = $this->productTable;
        $priceTable = $this->productPriceTable;

        $query = DB::connection($connection)
            ->table($postsTable)
            ->join($priceTable, "$postsTable.ID", '=', "$priceTable.product_id")
            ->select(
                "$postsTable.ID as id",
                "$postsTable.post_title as name",
                "$postsTable.post_excerpt as description",
                "$postsTable.post_name as slug",
                "$priceTable.max_price as unit_price"
            )
            ->where("$postsTable.post_status", 'publish')
            ->where("$postsTable.post_type", 'product')
            ->where("$priceTable.max_price", '>', 0);

        if ($priceFrom && $priceTo) {
            $query->whereBetween("$priceTable.max_price", [$priceFrom, $priceTo]);
        }

        if (!empty($categoryId)) {
            $query->join($this->tagsTable . ' as tr', "$postsTable.ID", '=', 'tr.object_id')
                  ->join($this->termTaxonomyTable . ' as tt', 'tr.term_taxonomy_id', '=', 'tt.term_taxonomy_id')
                  ->where('tt.taxonomy', 'product_cat') 
                  ->where('tt.term_id', $categoryId); 
        }        


        $fetchLimit = $noOfProducts ? ($noOfProducts * 5) : 200;
        $minTotal = $invoiceAmount;
        $maxTotal = $invoiceAmount * 1.05;
        $iteration = $noOfProducts ? 30 : 20;

        $allProducts = $query->orderByDesc("$priceTable.max_price")->limit($fetchLimit)->get();if ($noOfProducts) {
            $targetAvg = $invoiceAmount / $noOfProducts;
            $allProducts = $allProducts->sortBy(function ($product) use ($targetAvg) {
                return abs($product->unit_price - $targetAvg);
            });
        }
        
        $bestMatch = null;
        $bestTotal = 0;
        $bestDistance = null;
        
        for ($i = 0; $i < $iteration; $i++) {
            $shuffled = $allProducts->shuffle();
            $selected = [];
            $currentTotal = 0;
        
            foreach ($shuffled as $product) {
                $price = floatval($product->unit_price);
        
                if ($noOfProducts && count($selected) >= $noOfProducts) break;
        
                if ($noOfProducts) {
                    $selected[] = $product;
                    $currentTotal += $price;
                } elseif ($currentTotal + $price <= $maxTotal) {
                    $selected[] = $product;
                    $currentTotal += $price;
                }
            }
        
            if ($noOfProducts && count($selected) == $noOfProducts) {
                $distance = abs($invoiceAmount - $currentTotal);
                if ($bestMatch === null || $distance < $bestDistance) {
                    $bestMatch = $selected;
                    $bestTotal = $currentTotal;
                    $bestDistance = $distance;
                    if ($distance < 0.01) break;
                }
            } elseif (!$noOfProducts && $currentTotal >= $minTotal && $currentTotal <= $maxTotal) {
                if ($currentTotal > $bestTotal) {
                    $bestMatch = $selected;
                    $bestTotal = $currentTotal;
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

        collect($bestMatch)->each(function ($product) use ($site_id) {
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
                $product->rrp = $product->unit_price;
                $product->discount = 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
                $product->rrp = $product->unit_price;
                $product->discount = 0;
            }
        });

        $productList = collect($bestMatch)->map(function ($product) {
            return [
                'id' => $product->id,
                'unit_price' => $product->unit_price,
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
        $site_id = $request->get('site_id') ?? session('customer.site_id');
        $productsData = $request->get('products', []);
    
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);
    
        $postsTable = $this->productTable;
        $priceTable = $this->productPriceTable;
        $connection = $this->connectionType;
    
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
    
        $products = DB::connection($connection)
            ->table($postsTable)
            ->join($priceTable, "$postsTable.ID", '=', "$priceTable.product_id")
            ->select(
                "$postsTable.ID as id",
                "$postsTable.post_title as name",
                "$postsTable.post_excerpt as description",
                "$postsTable.post_name as slug",
                "$priceTable.max_price as unit_price"
            )
            ->whereIn("$postsTable.ID", $productIds)
            ->where("$postsTable.post_status", 'publish')
            ->where("$postsTable.post_type", 'product')
            ->get()
            ->keyBy('id');
    
        $products = collect($productIds)->map(function ($id) use ($products) {
            return $products[$id] ?? null;
        })->filter();
    
        $products = $products->map(function ($product) use ($readyProducts, $site_id) {
            $sessionProduct = collect($readyProducts)->firstWhere('id', $product->id);
    
            $product->unit_price = $sessionProduct['unit_price'] ?? $product->unit_price;
            $product->category_name = '-';
    
            $lastUpdate = DB::table('product_price_histories')
                ->where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();
    
            if ($lastUpdate) {
                $lastPriceChanged = Carbon::parse($lastUpdate->last_price_changed);
                $nextChange = $lastPriceChanged->copy()->addMonths(3);
                $remaining = now()->diffInDays($nextChange, false);
                $product->remaining_days = round(max($remaining, 0));
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextChange) ? 1 : 0;
                $product->rrp = $product->unit_price;
                $product->discount = 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
                $product->rrp = $product->unit_price;
                $product->discount = 0;
            }
    
            return $product;
        });
    
        $total = $products->sum('unit_price');
        session(['current_amount' => $total]);
    
        $modelType = $site->businessModel->model_type;
        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $products,
            'site' => $site,
            'total' => $total
        ])->render();
    
        return response()->json([
            'tableRows' => $tableRows,
            'total' => $total
        ]);
    }
    

    

    public function removeProduct(Request $request)
    {
        $productId = $request->get('product_id');
        $site_id = $request->get('site_id');
        $site = Website::findOrFail($site_id);
    
        $postsTable = $this->productTable;
        $priceTable = $this->productPriceTable;
        $connection = $this->connectionType;
    
        $readyProducts = session('ready_products', []);
    
        $updatedProducts = collect($readyProducts)->reject(fn($product) => $product['id'] == $productId)->values()->toArray();
        session()->put('ready_products', $updatedProducts);
    
        if (empty($updatedProducts)) {
            return response()->json([
                'tableRows' => '',
                'total' => 0,
            ]);
        }
    
        DynamicDatabaseService::connect($site);
    
        $productIds = array_column($updatedProducts, 'id');
    
        $products = DB::connection($connection)
            ->table($postsTable)
            ->join($priceTable, "$postsTable.ID", '=', "$priceTable.product_id")
            ->select(
                "$postsTable.ID as id",
                "$postsTable.post_title as name",
                "$postsTable.post_excerpt as description",
                "$postsTable.post_name as slug",
                "$priceTable.max_price as unit_price"
            )
            ->whereIn("$postsTable.ID", $productIds)
            ->where("$postsTable.post_status", 'publish')
            ->where("$postsTable.post_type", 'product')
            ->get()
            ->keyBy('id');
    
        $products = collect($productIds)->map(fn($id) => $products[$id] ?? null)->filter();
    
        $products = $products->map(function ($product) use ($updatedProducts, $site_id) {
            $sessionProduct = collect($updatedProducts)->firstWhere('id', $product->id);
    
            $product->unit_price = $sessionProduct['unit_price'] ?? $product->unit_price;
            $product->category_name = '-';
    
            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();
    
            if ($lastUpdate) {
                $nextDate = Carbon::parse($lastUpdate->last_price_changed)->addMonths(3);
                $remaining = now()->diffInDays($nextDate, false);
                $product->remaining_days = max($remaining, 0);
                $product->can_edit_price = now()->gte($nextDate) ? 1 : 0;
                $product->rrp = $product->unit_price;
                $product->discount = 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
                $product->rrp = $product->unit_price;
                $product->discount = 0;
            }
    
            return $product;
        });
    
        $total = $products->sum('unit_price');
        session(['current_amount' => $total]);
    
        $modelType = $site->businessModel->model_type;
        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $products,
            'site' => $site,
            'total' => $total
        ])->render();
    
        return response()->json([
            'tableRows' => $tableRows,
            'total' => $total
        ]);
    }
    
    

    public function updateProduct(Request $request)
    {
        $productId = $request->get('product_id');
        $quantity = $request->get('quantity');
        $site_id = $request->get('site_id');

        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $readyProducts = session()->get('ready_products', []);

        foreach ($readyProducts as &$product) {
            if ($product['id'] == $productId) {
                $product['quantity'] = $quantity;
                break;
            }
        }
        session()->put('ready_products', $readyProducts);

        $productIds = collect($readyProducts)->pluck('id')->toArray();

        $postsTable = $this->productTable;
        $priceTable = $this->productPriceTable;
        $connection = $this->connectionType;

        $products = DB::connection($connection)
            ->table($postsTable)
            ->join($priceTable, "$postsTable.ID", '=', "$priceTable.product_id")
            ->whereIn("$postsTable.ID", $productIds)
            ->select([
                "$postsTable.ID as id",
                "$postsTable.post_title as name",
                "$postsTable.post_excerpt as description",
                "$postsTable.post_name as slug",
                "$priceTable.max_price as unit_price"
            ])
            ->get();

        $products = $products->map(function ($product) use ($readyProducts, $site_id) {
            $sessionProduct = collect($readyProducts)->firstWhere('id', $product->id);
            $product->unit_price = $sessionProduct['unit_price'] ?? $product->unit_price;
            $product->quantity = $sessionProduct['quantity'] ?? 1;
            $product->category_name = '-';

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
                $product->rrp = $product->unit_price;
                $product->discount = 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
                $product->rrp = $product->unit_price;
                $product->discount = 0;
            }

            return $product;
        });

        $modelType = $site->businessModel->model_type;

        $total = $products->sum(function ($product) {
            return $product->unit_price * ($product->quantity ?? 1);
        });

        session(['current_amount' => $total]);

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $products,
            'site' => $site,
            'total' => $total
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total' => $total
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
        $hasPriceRange = $request->filled('price_from') && $request->filled('price_to');
        $keyword = $request->input('keyword');
        $sortUnitPrice = $request->input('sort_unit_price', 'asc');

        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        if (!$hasPriceRange) {
            return response()->json([
                'tableRows' => '<tr><td colspan="6" class="text-center text-muted">Please enter a price range to search.</td></tr>'
            ]);
        }

        $postsTable = $this->productTable;
        $priceTable = $this->productPriceTable;
        $connection = $this->connectionType;

        $query = DB::connection($connection)
            ->table($postsTable)
            ->join($priceTable, "$postsTable.ID", '=', "$priceTable.product_id")
            ->select([
                "$postsTable.ID as id",
                "$postsTable.post_title as name",
                "$postsTable.post_excerpt as description",
                "$postsTable.post_name as slug",
                "$priceTable.max_price as unit_price"
            ])
            ->where("$postsTable.post_status", 'publish')
            ->where("$postsTable.post_type", 'product')
            ->where("$priceTable.max_price", '>', 0);

        $query->whereBetween("$priceTable.max_price", [
            (float) $request->price_from,
            (float) $request->price_to
        ]);

        if (in_array($sortUnitPrice, ['asc', 'desc'])) {
            $query->orderBy("$priceTable.max_price", $sortUnitPrice);
        }

        if (!empty($keyword)) {
            $normalizedSearch = strtolower(str_replace(['-', '_', ' '], '', $keyword));
            $query->whereRaw("LOWER(REPLACE(REPLACE(REPLACE($postsTable.post_title, '-', ''), '_', ''), ' ', '')) LIKE ?", ["%{$normalizedSearch}%"]);
        }

        $readyProducts = session('ready_products', []);
        $readyProductIds = collect($readyProducts)->pluck('id')->toArray();

        if (!empty($readyProductIds)) {
            $query->whereNotIn("$postsTable.ID", $readyProductIds);
        }

        $totalCount = $query->count();
        $page = $request->input('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $products = $query->skip($offset)->take($perPage)->get();

        if ($products->isEmpty()) {
            return response()->json([
                'tableRows' => '<tr><td colspan="7" class="text-center text-muted">No results found. Try randomizing or use a different keyword.</td></tr>'
            ]);
        }

        $products = $products->map(function ($product) use ($site_id) {
            $product->category_name = '-';

            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();

            if ($lastUpdate) {
                $lastPriceChanged = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = max($remainingDays, 0);
                $product->can_edit_price = now()->gte($nextPriceChangeDate) ? 1 : 0;
                $product->rrp = $product->unit_price;
                $product->discount = 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
                $product->rrp = $product->unit_price;
                $product->discount = 0;
            }

            return $product;
        });

        $totalPages = ceil($totalCount / $perPage);
        $paginationPages = $this->smartPagination($page, $totalPages);
        $modelType = $site->businessModel->model_type;
        $random_amount = session('current_amount', 0);

        $tableRows = view("invoice.{$modelType}.add_product_rows", [
            'products' => $products,
            'site' => $site,
            'random_amount' => $random_amount
        ])->render();

        $paginationHtml = view("invoice.{$modelType}.pagination", [
            'totalPages' => $totalPages,
            'paginationPages' => $paginationPages,
            'currentPage' => $page
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'paginationHtml' => $paginationHtml,
            'random_amount' => $random_amount,
            'currentPage' => $page
        ]);
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
        DynamicDatabaseService::connect($site);
    
        $invoice_data['site'] = $site;
        $invoice_data['site_id'] = $site->id;
        $invoice_data['invoice_number'] = $request->input('invoice_number');
        $invoice_data['invoice_date'] = Carbon::parse($request->input('invoice_date'))->format('F d, Y');
        $invoice_data['customer_name'] = $request->input('customer_name');
        $invoice_data['customer_mobile'] = $request->input('customer_mobile');
        $invoice_data['customer_email'] = $request->input('customer_email');
        $invoice_data['invoice_amount'] = $request->input('invoice_amount');
        $invoice_data['current_amount'] = $request->input('current_amount');
        $invoice_data['discount_amount'] = $request->input('discount_amount');
        $invoice_data['currency'] = site_currency();
        $invoice_data['invoice_template'] = $site->invoice_template;
        $invoice_data['model_type'] = $site->businessModel->model_type;
    
        $company_detail_type = $request->input('company_detail_type');
    
        if ($company_detail_type === 'remote') {

            $invoice_data['site_name']    = $request->input('remote_site_name') ?? '';
            $invoice_data['company_name']    = $request->input('remote_company_name') ?? '';
            $invoice_data['company_email']   = $request->input('remote_company_email') ?? '';
            $invoice_data['company_mobile']  = $request->input('remote_company_mobile') ?? '';
            $invoice_data['company_address'] = $request->input('remote_company_address') ?? '';
            $remote_database = DB::connection($this->connectionType)->table('general_settings')->orderByDesc('updated_at')->first();

            if ($remote_database) {
                DB::connection($this->connectionType)->table('general_settings') ->where('id', $remote_database->id)
                    ->update([
                        'site_name'    => $request->input('remote_site_name') ?? '',
                        //'company_name' => $request->input('remote_company_name') ?? '',
                        'email'        => $request->input('remote_company_email') ?? '',
                        'phone'        => $request->input('remote_company_mobile') ?? '',
                        'address'      => $request->input('remote_company_address') ?? '',
                        'updated_at'   => now(),
                    ]);
            }

        } else{

            $invoice_data['site_name']    = $request->input('local_site_name') ?? '';
            $invoice_data['company_name']    = $request->input('local_company_name') ?? '';
            $invoice_data['company_email']   = $request->input('local_company_email') ?? '';
            $invoice_data['company_mobile']  = $request->input('local_company_mobile') ?? '';
            $invoice_data['company_address'] = $request->input('local_company_address') ?? '';
            $site->site_name       = $invoice_data['site_name'];
            $site->company_name    = $invoice_data['company_name'];
            $site->company_email   = $invoice_data['company_email'];
            $site->company_mobile  = $invoice_data['company_mobile'];
            $site->company_address = $invoice_data['company_address'];
            $site->save();
        }
        
        $invoice_data['invoice_header_image'] = base64EncodeImage($site->invoice_header_image);
        $invoice_data['invoice_footer_image'] = base64EncodeImage($site->invoice_footer_image);
        $invoice_data['invoice_signature'] = base64EncodeImage($site->invoice_signature);
        $invoice_data['company_logo'] = base64EncodeImage($site->company_logo);
        $invoice_data['invoice_image1'] = base64EncodeImage($site->invoice_image1);
        $invoice_data['invoice_image2'] = base64EncodeImage($site->invoice_image2);
        $invoice_data['invoice_image3'] = base64EncodeImage($site->invoice_image3);
        $invoice_data['invoice_image4'] = base64EncodeImage($site->invoice_image4);
        $invoice_data['invoice_image5'] = base64EncodeImage($site->invoice_image5);
        $invoice_data['invoice_image6'] = base64EncodeImage($site->invoice_image6);
        $invoice_data['invoice_image7'] = base64EncodeImage($site->invoice_image7);
        $invoice_data['invoice_image8'] = base64EncodeImage($site->invoice_image8);
        $invoice_data['invoice_image9'] = base64EncodeImage($site->invoice_image9);
    
        $productDataArray = $request->input('product_data', []);
        $productIds = [];
        $customPrices = [];
    
        foreach ($productDataArray as $item) {
            $data = json_decode($item, true);
            if (!empty($data['product_id'])) {
                $productIds[] = $data['product_id'];
                $customPrices[$data['product_id']] = $data['unit_price'];
            }
        }

    $postsTable = $this->productTable;
    $priceTable = $this->productPriceTable;
    $connection = $this->connectionType;

    $products = DB::connection($connection)
        ->table($postsTable)
        ->join($priceTable, "$postsTable.ID", '=', "$priceTable.product_id")
        ->whereIn("$postsTable.ID", $productIds)
        ->select([
            "$postsTable.ID as id",
            "$postsTable.post_title as name",
            "$postsTable.post_excerpt as description",
            "$postsTable.post_name as slug",
            "$priceTable.max_price as unit_price"
        ])
        ->get()
        ->sortBy(function ($product) use ($productIds) {
            return array_search($product->id, $productIds);
        })
        ->values()
        ->map(function ($product) use ($customPrices) {
            $product->unit_price = $customPrices[$product->id] ?? $product->unit_price;
            $product->category_name = '-';
            $product->rrp = $product->unit_price;
            $product->discount = 0;
            return $product;
        });

        $invoice_data['products'] = $products;
        $invoice_data['product_ids'] = $productIds;
    
        $this->updateProductPrice($productDataArray);
        InvoiceController::createInvoiceHistory($invoice_data);
    
        $modelType = strtolower($site->businessModel->model_type);
        $siteIdInWords = numberToWords($site->id);
        $viewPath = "websites.{$modelType}.{$siteIdInWords}";
    
        $filename = $request->filled('invoice_file_name')
            ? $request->input('invoice_file_name') . '.pdf'
            : $invoice_data['invoice_number'] . '.pdf';
    
            $filename = $request->filled('invoice_file_name')
            ? $request->input('invoice_file_name') . '.pdf'
            : $invoice_data['invoice_number'] . '.pdf';
            
            try {
                return $this->generateWithApi2Pdf($site, $viewPath, $invoice_data, $filename);

            } catch (\Exception $e) {
                // Fallback to Dompdf if API2PDF fails
                return $this->generateWithDompdf($site, $viewPath, $invoice_data, $filename);
            }
    
    }

    protected function generateWithApi2Pdf($site, $viewPath, $invoice_data, $filename)
    {
        $html = View::make($viewPath, $invoice_data)->render();

        $response = Http::withHeaders([
            'Authorization' => env('API2PDF_KEY')
        ])->post('https://v2.api2pdf.com/chrome/html', [
            'html' => $html,
            'fileName' => $filename,
            'options' => [
                'format' => $site->pdf_size ?? 'A4',
                'landscape' => ($site->pdf_orientation ?? 'portrait') === 'landscape',
            ]
        ]);

        if ($response->failed()) {
            $error = $response->json('message') ?? $response->body();
            throw new \Exception('API2PDF failed: ' . $error);
        }

        $pdfUrl = $response->json('pdf');

        if (empty($pdfUrl)) {
            throw new \Exception('API2PDF did not return a PDF URL.');
        }

        return response()->streamDownload(function () use ($pdfUrl) {
            $pdfResponse = Http::timeout(60)->get($pdfUrl);

            if ($pdfResponse->failed()) {
                throw new \Exception("Failed to download PDF file from Api2Pdf.");
            }

            echo $pdfResponse->body();
        }, $filename);
    }

    protected function generateWithDompdf($site, $viewPath, $invoice_data, $filename)
    {
        $pdf = \PDF::loadView($viewPath, $invoice_data)->setPaper($site->pdf_size ?? 'A4', $site->pdf_orientation ?? 'portrait');
        return $pdf->download($filename);
    }

    protected function updateProductPrice(array $productDataArray)
    {
        $site_id = session('customer.site_id');
        $postsTable = $this->productTable;      
        $priceTable = $this->productPriceTable; 
        $connection = $this->connectionType;
        
        foreach ($productDataArray as $item) {
            $data = json_decode($item, true);
        
            if (!empty($data['product_id']) && isset($data['unit_price'])) {
                $product_id   = $data['product_id'];
                $new_name     = $data['product_name'];
                $new_price    = floatval($data['unit_price']);
            
                $product = DB::connection($connection)
                    ->table($postsTable)
                    ->join($priceTable, "$postsTable.ID", '=', "$priceTable.product_id")
                    ->where("$postsTable.ID", $product_id)
                    ->select([
                        "$postsTable.ID as id",
                        "$postsTable.post_title as name",
                        "$priceTable.max_price as unit_price"
                    ])
                    ->first();
        
                if (! $product) {
                    continue;
                }
        
                $current_name     = $product->name;
                $current_price    = floatval($product->unit_price);
               
                $updatePostData  = [];
                $updatePriceData = [];
        
                if ($current_name !== $new_name) {
                    $updatePostData['post_title'] = $new_name;
                }
        
                if ($current_price !== $new_price) {
                    $updatePriceData['max_price'] = $new_price;
                }
        
                if (empty($updatePostData) && empty($updatePriceData)) {
                    continue;
                }
        
                $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                                   ->where('product_id', $product_id)
                                   ->orderByDesc('last_price_changed')
                                   ->first();
        
                $shouldUpdate = false;
        
                if (! $lastUpdate) {
                    $shouldUpdate = true;
                } else {
                    $monthsSinceLast = Carbon::parse($lastUpdate->last_price_changed)->diffInMonths(now());
                    if ($monthsSinceLast >= 3) {
                        $shouldUpdate = true;
                    }
                }
        
                if ($shouldUpdate) {
                    if (!empty($updatePostData)) {
                        DB::connection($connection)
                            ->table($postsTable)
                            ->where('ID', $product_id)
                            ->update($updatePostData);
                    }
        
                    if (!empty($updatePriceData)) {
                        DB::connection($connection)
                            ->table($priceTable)
                            ->where('product_id', $product_id)
                            ->update($updatePriceData);
                    }
        
                    ProductPriceHistory::create([
                        'site_id'            => $site_id,
                        'product_id'         => $product_id,
                        'unit_price'         => $new_price,
                        'last_price_changed' => now(),
                    ]);
                }
            }
        }
        
    }
    


}
