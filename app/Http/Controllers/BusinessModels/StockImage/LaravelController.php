<?php
namespace App\Http\Controllers\BusinessModels\StockImage;

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


class LaravelController extends Controller
{
    private $productTable;
    private $connectionType;

    public function __construct()
    {
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
        $this->productTable = "pricing_packs";
        $this->connectionType = 'dynamic';
    }

    public function randomProducts(Request $request)
    {
        $site_id = $request->get('site_id');
        $invoiceAmount = floatval($request->get('invoice_amount'));

        // ─── Configurable Settings ─────────────────────────────────────────
        $percentageStep = 5;   // Each step increases by this % (e.g. 0% → 5% → 10% ...)
        $maxPercentage  = 30;  // Maximum % above invoice amount to search
        // ──────────────────────────────────────────────────────────────────

        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);
        session()->forget('ready_products');

        $allProducts = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'name', 'credits', 'price')->get();

        $filteredProducts = collect();
        $matchedAtPercentage = 0;

        // Step-by-step percentage increase until product found or max reached
        for ($pct = 0; $pct <= $maxPercentage; $pct += $percentageStep) {
            $minPrice = $invoiceAmount;
            $maxPrice = $invoiceAmount * (1 + $pct / 100);

            $filteredProducts = $allProducts->filter(function ($product) use ($minPrice, $maxPrice) {
                return $product->price >= $minPrice && $product->price <= $maxPrice;
            })->sortBy('price'); // Pick cheapest first to minimize discount

            if ($filteredProducts->isNotEmpty()) {
                $matchedAtPercentage = $pct;
                break;
            }
        }

        if ($filteredProducts->isEmpty()) {
            session()->forget('ready_products');
            session()->forget('current_amount');
            return response()->json([
                'tableRows' => '
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">
                            No products found within ' . $maxPercentage . '% of invoice amount 
                            (<strong>' . site_currency() . number_format($invoiceAmount, 2) . '</strong>).<br>
                            <button class="btn btn-primary btn-sm mt-2" 
                                data-bs-toggle="modal" 
                                data-bs-target="#addmoreproducts" 
                                onclick="customizeProducts(\'onload\')">
                                Add Custom Pack
                            </button>
                        </td>
                    </tr>',
                'success' => false,
                'total'   => 0
            ], 200);
        }

        // Take the cheapest matching product (sorted above)
        $randomProducts = $filteredProducts->take(1);

        $readyProducts = $randomProducts->values()->toArray();
        session()->put('ready_products', $readyProducts);

        $modelType = $site->businessModel->model_type;
        $total = collect($readyProducts)->sum('price');
        session(['current_amount' => $total]);

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => collect($readyProducts),
            'site'     => $site,
            'total'    => $total
        ])->render();

        return response()->json([
            'tableRows'          => $tableRows,
            'total'              => $total,
            'matchedAtPercentage' => $matchedAtPercentage  // optional, useful for JS feedback
        ]);
    }

    public function addProducts(Request $request)
    {
        $site_id = $request->get('site_id');
        $productsData = $request->get('products');

        $site = Website::findOrFail($site_id);
        $productstable = "pricing_packs";
        DynamicDatabaseService::connect($site);

        // Clear existing ready_products session - only new products will be there
        $readyProducts = [];

        foreach ($productsData as $productData) {
            $productId = $productData['product_id'];
            $unitPrice = floatval($productData['unit_price']); // Changed from 'price' to 'unit_price'
            //dd($unitPrice);

            // Handle custom pack (ID = 0) separately
            if ($productId == '0') {
                // Add custom pack to ready products
                $readyProducts[] = [
                    'id' => $productId,
                    'price' => $unitPrice,
                    'is_custom' => true
                ];
            } else {
                // Handle regular products
                // Get current product price
                $currentProduct = DB::connection($this->connectionType)
                    ->table($this->productTable)
                    ->where('id', $productId)
                    ->first();

                // If price changed, update price history
                if ($currentProduct && $currentProduct->price != $unitPrice) {
                    ProductPriceHistory::create([
                        'site_id' => $site_id,
                        'product_id' => $productId,
                        'price' => $unitPrice,
                        'last_price_changed' => now()
                    ]);

                    // Update product price in database
                    DB::connection($this->connectionType)
                        ->table($this->productTable)
                        ->where('id', $productId)
                        ->update(['price' => $unitPrice]);
                }

                // Add to ready products
                $readyProducts[] = [
                    'id' => $productId,
                    'price' => $unitPrice,
                ];
            }
        }

        // Replace session data completely
        session()->put('ready_products', $readyProducts);

        // Separate custom and regular products
        $customProducts = collect($readyProducts)->where('is_custom', true);
        $regularProductIds = collect($readyProducts)->where('is_custom', '!=', true)->pluck('id')->reverse()->values()->toArray();

        $products = collect();

        // Fetch regular products from database
        if (!empty($regularProductIds)) {
            $dbProducts = DB::connection($this->connectionType)->table($this->productTable)
                ->select('id', 'name', 'price', 'credits')
                ->whereIn('id', $regularProductIds)
                ->get()
                ->keyBy('id');

            $regularProducts = collect($regularProductIds)->map(function ($id) use ($dbProducts) {
                return $dbProducts[$id];
            });

            $products = $products->concat($regularProducts);
        }

        // Add custom products
        foreach ($customProducts as $customProduct) {
            $customPrice = $customProduct['price'];
            $calculation = round(($customPrice / 5.75) * 10) / 10;
            $calculation_2 = round($calculation * 2) / 2;
            $calculatedCredits = (float)number_format($calculation_2, 1, '.', '');
            //dd($calculation, $calculatedCredits);

            $customProductObj = (object)[
                'id' => 0,
                'name' => 'Custom Pack',
                'price' => $customPrice,
                'credits' => (string)$calculatedCredits,
                'is_custom' => true
            ];
            $products->push($customProductObj);
        }

        $products = $products->map(function ($product) use ($readyProducts, $site_id) {
            // Skip custom products from additional processing
            if (isset($product->is_custom) && $product->is_custom) {
                return $product;
            }

            $sessionProduct = collect($readyProducts)->firstWhere('id', $product->id);
            $product->price = $sessionProduct['price'] ?? $product->price;

            // if ($product->category_id) {
            //     $product->category_name = DB::connection($this->connectionType)->table('categories')->where('id', $product->category_id)->value('name') ?? 'unknown';
            // } else {
            //     $product->category_name = 'unknown';
            // }

            return $product;
        });

        $modelType = $site->businessModel->model_type;
        session(['current_amount' => collect($products)->sum('price')]);

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $products,
            'site' => $site,
            'total' => collect($products)->sum('price')
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total' => collect($products)->sum('price')
        ]);
    }


    public function removeProduct(Request $request)
    {
        $productId = $request->get('product_id');
        $site_id = $request->get('site_id');
        $site = Website::findOrFail($site_id);

        // Get ready products from session and remove matching product
        $readyProducts = session('ready_products', []);

        // Fix: Handle both object and array formats in session data
        $readyProducts = array_filter($readyProducts, function($product) use ($productId) {
            // Handle both object and array formats
            $id = is_array($product) ? $product['id'] : $product->id;
            return $id != $productId;
        });

        // Store filtered products back in session
        session()->put('ready_products', array_values($readyProducts));

        // If no products left, return empty response
        if (empty($readyProducts)) {
            session()->forget('current_amount');
            return response()->json([
                'tableRows' => '<tr><td colspan="6" class="text-center text-muted">All products removed. Please add random or custom products.<br><button class="btn btn-info mt-2 ms-2" data-bs-toggle="modal" data-bs-target="#addmoreproducts" onclick="customizeProducts(\'onload\')">Add Custom Pack</button></td></tr>',
                'total' => 0
            ]);
        }

        DynamicDatabaseService::connect($site);

        // Separate custom products from regular products
        $customProducts = [];
        $regularProductIds = [];

        foreach ($readyProducts as $product) {
            $productData = is_array($product) ? $product : (array)$product;

            // If product ID is 0 or negative, it's a custom product
            if ($productData['id'] <= 0) {
                $customProducts[] = (object)$productData;
            } else {
                $regularProductIds[] = $productData['id'];
            }
        }

        // Get regular products from database
        $regularProducts = collect();
        if (!empty($regularProductIds)) {
            $regularProducts = DB::connection($this->connectionType)
                ->table($this->productTable)
                ->select('id', 'name', 'price', 'credits')
                ->whereIn('id', $regularProductIds)
                ->get();
        }

        // Process regular products with price history
        $regularProducts = $regularProducts->map(function ($product) use ($readyProducts, $site_id) {
            // Get price from session
            $sessionProduct = collect($readyProducts)->first(function($item) use ($product) {
                $id = is_array($item) ? $item['id'] : $item->id;
                return $id == $product->id;
            });

            $sessionData = is_array($sessionProduct) ? $sessionProduct : (array)$sessionProduct;
            $product->price = $sessionData['price'] ?? $product->price;

            // Check price edit permissions
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

        // Process custom products (they can always be edited)
        $customProducts = collect($customProducts)->map(function($product) {
            $product->can_edit_price = 1;
            $product->remaining_days = 0;
            return $product;
        });

        // Combine both types of products
        $products = $regularProducts->merge($customProducts);

        $modelType = $site->businessModel->model_type;
        $total = $products->sum('price');

        // Update session amount
        session(['current_amount' => $total]);

        // Render updated table rows
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

        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'category_id', 'name', 'price', 'slug')
            ->whereIn('id', $productIds)
            ->get();

        $products = $products->map(function ($product) use ($readyProducts, $site_id) {
            $sessionProduct = collect($readyProducts)->firstWhere('id', $product->id);
            $product->price = $sessionProduct['price'] ?? $product->price;
            $product->quantity = $sessionProduct['quantity'] ?? 1;
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

        $total = $products->sum(function ($product) {
            return $product->price * ($product->quantity ?? 1);
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
        $search_type = $request->input('search_type');
        $keyword = $request->input('keyword');
        $sortUnitPrice = $request->input('sort_price', 'asc');
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);



        $query = DB::connection($this->connectionType)
            ->table($this->productTable)
            ->select('id', 'name', 'price', 'credits');



        $readyProducts = session('ready_products', []);
        $readyProductIds = collect($readyProducts)->pluck('id')->toArray();

        if (count($readyProductIds) > 0) {
            $query->whereNotIn('id', $readyProductIds);
        }


        $products = $query->get();
        if ($products->isEmpty()) {
            return response()->json([
                'tableRows' => '<tr><td colspan="7" class="text-center text-muted"> No results found. Try randomizing or use a different keyword. <br><button class="btn btn-primary mt-2" onclick="addCustomPacks()">Add Custom Packs</button></td></tr>'
            ]);
        }

        $products = collect($products);


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

        $tableRows = view( "invoice.{$modelType}.add_product_rows", ['products' => $products, 'site' => $site,'random_amount' => $random_amount])->render();


        return response()->json([ 'tableRows' => $tableRows, 'random_amount' => $random_amount]);

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
        $invoice_data['invoice_number'] = $request->input('invoice_number');
        $invoice_data['invoice_date'] = $request->input('invoice_date');
        $invoice_data['customer_name'] = $request->input('customer_name');
        $invoice_data['customer_mobile'] = $request->input('customer_mobile');
        $invoice_data['customer_email'] = $request->input('customer_email');
        $invoice_data['company_email'] = $request->input('company_email');
        $invoice_data['invoice_amount'] = $request->input('invoice_amount');
        $invoice_data['current_amount'] = $request->input('current_amount');
        $invoice_data['discount_amount'] = $request->input('discount_amount');
        $company_detail_type = $request->input('company_detail_type');

        if ($company_detail_type === 'remote') {

            $invoice_data['site_name']          = $request->input('remote_site_name') ?? '';
            $invoice_data['company_name']       = $request->input('remote_company_name') ?? '';
            $invoice_data['company_email']      = $request->input('remote_company_email') ?? '';
            $invoice_data['company_mobile']     = $request->input('remote_company_mobile') ?? '';
            $invoice_data['company_address']    = $request->input('remote_company_address') ?? '';
            $invoice_data['registration_number'] = $request->input('remote_registration_number') ?? '';
            $invoice_data['license_number']      = $request->input('remote_license_number') ?? '';
        
            $remote_database = DB::connection($this->connectionType)->table('general_settings')->orderByDesc('updated_at')->first();
        
            if ($remote_database) {
                DB::connection($this->connectionType)->table('general_settings')->where('id', $remote_database->id)
                    ->update([
                        'site_name'            => $request->input('remote_site_name') ?? '',
                        //'company_name'        => $request->input('remote_company_name') ?? '',
                        'email'                => $request->input('remote_company_email') ?? '',
                        'phone'                => $request->input('remote_company_mobile') ?? '',
                        'address'              => $request->input('remote_company_address') ?? '',
                       // 'registration_number'  => $request->input('remote_registration_number') ?? '',
                       // 'license_number'       => $request->input('remote_license_number') ?? '',
                        'updated_at'           => now(),
                    ]);
            }
        
        } else {
        
            $invoice_data['site_name']          = $request->input('local_site_name') ?? '';
            $invoice_data['company_name']       = $request->input('local_company_name') ?? '';
            $invoice_data['company_email']      = $request->input('local_company_email') ?? '';
            $invoice_data['company_mobile']     = $request->input('local_company_mobile') ?? '';
            $invoice_data['company_address']    = $request->input('local_company_address') ?? '';
            $invoice_data['registration_number'] = $request->input('registration_number') ?? '';
            $invoice_data['license_number']      = $request->input('license_number') ?? '';
        
            $site->site_name          = $invoice_data['site_name'];
            $site->company_name       = $invoice_data['company_name'];
            $site->company_email      = $invoice_data['company_email'];
            $site->company_mobile     = $invoice_data['company_mobile'];
            $site->company_address    = $invoice_data['company_address'];
            $site->registration_number = $invoice_data['registration_number'];
            $site->license_number      = $invoice_data['license_number'];
        
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
        $invoice_data['invoice_template'] = $site->invoice_template;
        $invoice_data['model_type'] = $site->businessModel->model_type;
        $invoice_data['site_id'] = $site->id;



        $productDataArray = $request->input('product_data', []);


        $productIds = [];
        $customPrices = [];
        $customPacks = [];

        //dd($productDataArray);
        foreach ($productDataArray as $item) {
        $data = json_decode($item, true);

        if (isset($data['product_id'])) {
            if ($data['product_id'] == 0) {
                // Handle custom pack
                $customPacks[] = (object)[
                    'id' => '0',
                    'name' => 'Custom Pack',
                    'price' => floatval($data['price']),
                    'credits' => round(floatval($data['price']) / 5.75)
                ];
            } else {
                // Handle regular products
                $productIds[] = $data['product_id'];
                $customPrices[$data['product_id']] = $data['price'];
            }
        }
    }


        //dd($customPacks);

        $products = collect();

        // Fetch regular products from database
        if (!empty($productIds)) {
            $dbProducts = DB::connection($this->connectionType)->table($this->productTable)
                ->whereIn('id', $productIds)
                ->select('id', 'name', 'price', 'credits')
                ->get()
                ->sortBy(function ($product) use ($productIds) {
                    return array_search($product->id, $productIds);
                })
                ->values()
                ->map(function ($product) use ($customPrices) {
                    $product->price = $customPrices[$product->id] ?? $product->price;
                    return $product;
                });

            $products = $products->concat($dbProducts);
        }

        // Add custom packs to products collection
        foreach ($customPacks as $customPack) {
            $products->push($customPack);
        }

        $invoice_data['currency'] = site_currency();
        $invoice_data['products'] = $products;
        $invoice_data['product_ids'] = $products->pluck('id')->toArray();

        $modelType = strtolower($site->businessModel->model_type);
        $siteIdInWords = numberToWords($site->id);
        $viewPath = "websites.{$modelType}.{$siteIdInWords}";

        $this->updateProductPrice($productDataArray);
            InvoiceController::createInvoiceHistory($invoice_data);
        if ($request->filled('invoice_file_name')) {
            $filename = $request->input('invoice_file_name') . '.pdf';
        } else {
            $filename = $invoice_data['invoice_number'] . '.pdf';
        }

        try {
            return $this->generateWithApi2Pdf($site, $viewPath, $invoice_data, $filename);

        } catch (\Exception $e) {
            // Fallback to Dompdf if API2PDF fails
            return $this->generateWithDompdf($site, $viewPath, $invoice_data, $filename);
        }
    }

    protected function generateWithDompdf($site, $viewPath, $invoice_data, $filename)
    {
        $pdf = \PDF::loadView($viewPath, $invoice_data)->setPaper('A4', 'portrait');
        return $pdf->download($filename);
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
                'marginTop' => '0mm',
                'marginBottom' => '0mm',
                'marginLeft' => '0mm',
                'marginRight' => '0mm',
                'disableSmartShrinking' => true,
                'zoom' => 1,
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




    protected function updateProductPrice(array $productDataArray)
    {
        $site_id = session('customer.site_id');

        foreach ($productDataArray as $item) {
            $data = json_decode($item, true);

            if (!empty($data['product_id']) && isset($data['price'])) {
                $product_id = $data['product_id'];
                $new_price = floatval($data['price']);

                $product = DB::connection($this->connectionType)
                    ->table($this->productTable)
                    ->where('id', $product_id)
                    ->first();

                if (!$product) continue;

                $current_price = floatval($product->price);


                if ($current_price == $new_price) continue;


                $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                    ->where('product_id', $product_id)
                    ->orderByDesc('last_price_changed')
                    ->first();

                if (!$lastUpdate) {
                    DB::connection($this->connectionType)
                        ->table($this->productTable)
                        ->where('id', $product_id)
                        ->update(['price' => $new_price]);

                    ProductPriceHistory::create([
                        'site_id' => $site_id,
                        'product_id' => $product_id,
                        'price' => $new_price,
                        'last_price_changed' => now(),
                    ]);
                    continue;
                }

                if (Carbon::parse($lastUpdate->last_price_changed)->diffInMonths(now()) >= 3) {
                    DB::connection($this->connectionType)
                        ->table($this->productTable)
                        ->where('id', $product_id)
                        ->update(['price' => $new_price]);

                    ProductPriceHistory::create([
                        'site_id' => $site_id,
                        'product_id' => $product_id,
                        'price' => $new_price,
                        'last_price_changed' => now(),
                    ]);
                }
            }
        }
    }



}
