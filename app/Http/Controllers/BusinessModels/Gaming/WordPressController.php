<?php

namespace App\Http\Controllers\BusinessModels\Gaming;

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
use Api2Pdf\Api2Pdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Http;

class WordPressController extends Controller
{
    private $productTable;
    private $connectionType;
    private $bundleTable;

    public function __construct()
    {
        ini_set('max_execution_time', 300);
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
        $this->productTable = getProductTable($site->technology);
        $this->connectionType = 'dynamic';
        $this->bundleTable = 'game_sever_based_cost';
    }

    public function getPriceRange(Request $request)
    {
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);
        $min_unit_price = DB::connection($this->connectionType)->table($this->productTable)->where('published', 1)->min('unit_price');
        $max_unit_price = DB::connection($this->connectionType)->table($this->productTable)->where('published', 1)->max('unit_price');
        return response()->json(['minProductPrice' => $min_unit_price, 'maxProductPrice' => $max_unit_price]);
    }

    public function randomProducts(Request $request)
    {
        Session::forget('selected_products');

        $site_id = $request->get('site_id');
        $invoiceAmount = floatval($request->get('invoice_amount'));
        $priceFrom = $request->get('price_from');
        $priceTo = $request->get('price_to');
        $productCount = intval($request->get('product_count'));
        $searchQuery = $request->get('search_query');

        $minTotal = $invoiceAmount;
        $maxTotal = $invoiceAmount * 1.05;

        $site = Website::findOrFail($site_id);

        $consumerKey = $site->consumer_key;
        $consumerSecret = $site->consumer_secret;
        $base = rtrim($site->site_link, '/') . '/wp-json/wc/v3/products';

        $response = Http::withBasicAuth($consumerKey, $consumerSecret)
            ->get($base, ['type' => 'variable', 'per_page' => 100, 'search' => $searchQuery]);

        if ($response->failed()) {
            return response()->json(['tableRows' => '', 'total' => 0, 'message' => 'Failed to fetch products']);
        }

        $allProducts = collect();
        $targetUnitPrice = $productCount > 0 ? ($invoiceAmount / $productCount) : $invoiceAmount;

        foreach ($response->json() as $product) {
            // Fetch variations manually
            $variationRes = Http::withBasicAuth($consumerKey, $consumerSecret)
                ->get($base . '/' . $product['id'] . '/variations');

            if ($variationRes->failed()) continue;

            $variations = [];

            foreach ($variationRes->json() as $var) {
                $attrs = collect($var['attributes'])->pluck('option', 'name')->toArray();
                $bundleAmount = preg_replace('/\D/', '', $attrs['Amount'] ?? '0');
                $unitPrice = floatval($var['price']);

                if ($priceFrom && $priceTo && ($unitPrice < $priceFrom || $unitPrice > $priceTo)) continue;

                $variations[] = (object)[
                    'id' => $product['id'],
                    'bundle_id' => $var['id'],
                    'name' => $product['name'],
                    'unit_price' => $unitPrice,
                    'slug' => Str::slug($product['name']),
                    'source' => 'Random',
                    'can_edit_price' => 0,
                    'remaining_days' => 0,
                    'game_currency' => $product['sku'] ?? '',
                    'game_currency_amount' => $bundleAmount,
                    'game_platform' => $attrs['Platform'] ?? '',
                    'game_region' => null,
                    'game_need_to_capture' => null,
                ];
            }

            if (!empty($variations)) {
                // Pick variation closest to target price
                $selectedVariation = collect($variations)->sortBy(function ($v) use ($targetUnitPrice) {
                    return abs($v->unit_price - $targetUnitPrice);
                })->first();

                $allProducts->push($selectedVariation);
            }
        }

        if ($searchQuery && !$request->has('randomize')) {
            $results = $allProducts->sortBy('unit_price');
            $results = $productCount > 0 ? $results->take($productCount) : $results->take(60);
            $totalPrice = $results->sum('unit_price');

            session(['current_amount' => $totalPrice]);
            $currency = DB::connection($this->connectionType)->table('currencies')->where('status', 1)->first();
            $modelType = $site->businessModel->model_type;
            $tableRows = view("invoice.{$modelType}.random_product_rows", compact('results', 'currency', 'site'))->render();

            return response()->json([
                'tableRows' => $tableRows,
                'total' => $totalPrice,
                'currency' => $currency,
                'is_random' => false
            ]);
        }

        $bestMatch = null;
        $bestTotal = 0;

        for ($i = 0; $i < 10; $i++) {
            $shuffled = $allProducts->shuffle();
            $sel = [];
            $cur = 0;

            foreach ($shuffled as $p) {
                $price = floatval($p->unit_price);
                if ($cur + $price <= $maxTotal) {
                    $sel[] = $p;
                    $cur += $price;

                    if ($productCount > 0) {
                        if (count($sel) == $productCount && $cur >= $minTotal) {
                            $bestMatch = $sel;
                            $bestTotal = $cur;
                            break 2;
                        }
                    } else {
                        if ($cur >= $minTotal && $cur <= $maxTotal) {
                            $bestMatch = $sel;
                            $bestTotal = $cur;
                            break 2;
                        }
                    }
                }
            }
        }

        if (!$bestMatch) {
            session()->forget('ready_products');
            session()->forget('current_amount');
            
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No matching combination found, try again please'
            ]);
        }

        session()->forget('selected_games');

        $selected_games = array_map(function ($g) {
            return [
                'id' => $g->id,
                'name' => $g->name,
                'unit_price' => $g->unit_price,
                'game_currency_amount' => $g->game_currency_amount,
                'game_currency' => $g->game_currency,
                'bundle' => 'Random'
            ];
        }, $bestMatch);

        session(['selected_games' => $selected_games, 'current_amount' => $bestTotal]);

        $modelType = $site->businessModel->model_type;

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $bestMatch,
            'currency' => site_currency(),
            'site' => $site
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total' => $bestTotal,
            'currency' => site_currency(),
            'is_random' => true
        ]);
    }


    public function removeProduct(Request $request)
    {
        $id = $request->get('product_id');
        $unitPrice = $request->get('unit_price');
        $site_id = $request->get('site_id');

        $selectedGames = session('selected_games', []);
        //dd($selectedGames);
        // Remove matching product (id + unit_price)
        $updatedGames = array_filter($selectedGames, function ($game) use ($id, $unitPrice) {
            return !($game['id'] == $id && floatval($game['unit_price']) == floatval($unitPrice));
        });

        $updatedGames = array_values($updatedGames);

        // Update session
        session(['selected_games' => $updatedGames]);

        // If no products remaining
        if (empty($updatedGames)) {
            session()->forget('current_amount');
            return response()->json([
                'tableRows' => '',
                'total'     => 0,
                'currency'  => null,
                'message'   => 'No products remaining'
            ]);
        }

        $site = Website::findOrFail($site_id);

        // Get currency - this might be different for WP vs Laravel sites
        //$currency = $this->getCurrencyForSite($site);

        // Get business model type for view template
        $modelType = $site->businessModel->model_type;

        // Build products collection from session data for table display (as objects for Blade compatibility)
        $finalProducts = collect();
        //dd($updatedGames);
        foreach ($updatedGames as $sessionGame) {
            $finalProducts->push((object)[
                'id'                   => $sessionGame['id'],
                'name'                 => $sessionGame['name'] ?? 'Product',
                'bundle_id'            => $sessionGame['bundle_id'] ?? null,
                'unit_price'           => floatval($sessionGame['unit_price']),
                'slug'                 => $sessionGame['slug']?? Str::slug($sessionGame['name'] ?? 'product'),
                'source'               => $sessionGame['source'] ?? 'Random',
                'can_edit_price'       => $sessionGame['can_edit_price'] ?? 0,
                'remaining_days'       => $sessionGame['remaining_days'] ?? 0,
                'game_currency'        => $sessionGame['game_currency'] ?? '',
                'game_currency_amount' => $sessionGame['game_currency_amount'] ?? '',
                'game_platform'        => $sessionGame['game_platform'] ?? '',
                'game_region'          => $sessionGame['game_region'] ?? '',
                'game_need_to_capture' => $sessionGame['game_need_to_capture'] ?? '{}' // Ensure it's a JSON string for the template
            ]);
        }

        $total = $finalProducts->sum('unit_price');
        session(['current_amount' => $total]);

        // Render table rows using the same view template
        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $finalProducts,
            'currency' => site_currency(),
            'site'     => $site
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total'     => $total,
            'currency'  => site_currency(),
        ]);
    }

    public function filterProducts(Request $request)
    {
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
    
        $hasKeyword = $request->filled('keyword');
        $keyword = strtolower($request->keyword);
    
        $wp_api_url = rtrim($site->site_link, '/') . '/wp-json/wc/v3/products';
        $consumer_key = $site->consumer_key;
        $consumer_secret = $site->consumer_secret;
    
        $api_url = $wp_api_url . '?per_page=100&status=publish&type=variable';
        if ($hasKeyword) {
            $api_url .= '&search=' . urlencode($keyword);
        }
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $consumer_key . ':' . $consumer_secret);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        $products = collect();
        
        if ($http_code == 200 && $response) {
            $wp_products = json_decode($response, true);
            
            $mh = curl_multi_init();
            $curl_handles = [];
            
            foreach ($wp_products as $index => $p) {
                $variation_url = $wp_api_url . '/' . $p['id'] . '/variations?per_page=100';
                
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $variation_url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_USERPWD, $consumer_key . ':' . $consumer_secret);
                curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                curl_setopt($ch, CURLOPT_TIMEOUT, 30);
                
                curl_multi_add_handle($mh, $ch);
                $curl_handles[$index] = ['handle' => $ch, 'product' => $p];
            }
            
            $running = null;
            do {
                curl_multi_exec($mh, $running);
                curl_multi_select($mh);
            } while ($running > 0);
            
            foreach ($curl_handles as $index => $data) {
                $ch = $data['handle'];
                $p = $data['product'];
                
                $var_response = curl_multi_getcontent($ch);
                $var_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                
                $maxPrice = 0;
                
                if ($var_http_code == 200 && $var_response) {
                    $variations = json_decode($var_response, true);
                    
                    if (!empty($variations)) {
                        foreach ($variations as $var) {
                            $price = floatval($var['price'] ?? 0);
                            if ($price > $maxPrice) {
                                $maxPrice = $price;
                            }
                        }
                        
                        $products->push((object)[
                            'id' => $p['id'],
                            'name' => $p['name'],
                            'slug' => $p['slug'],
                            'game_currency' => $p['sku'] ?? '',
                            'game_platform' => $p['categories'][0]['name'] ?? '',
                            'game_server_region' => '',
                            'game_need_to_capture' => '',
                            'bundle_first_amount' => $maxPrice
                        ]);
                    }
                }
                
                curl_multi_remove_handle($mh, $ch);
                curl_close($ch);
            }
            
            curl_multi_close($mh);
        }
    
        if ($products->isEmpty()) {
            return response()->json([
                'tableRows' => '<tr><td colspan="7" class="text-center text-muted">No results found. Try randomizing or use a different keyword.</td></tr>'
            ]);
        }
    
        $modelType = $site->businessModel->model_type;
        $tableRows = view("invoice.{$modelType}.add_product_rows", [
            'products' => $products,
            'currency' => site_currency(),
            'site' => $site,
            'current_amount' => session('current_amount'),
        ])->render();
    
        return response()->json([
            'tableRows' => $tableRows,
            'currency' => site_currency(),
            'is_random' => false
        ]);
    }

    public function addProducts(Request $request)
    {
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);

        $woocommerceBaseUrl = rtrim($site->site_link, '/') . '/wp-json/wc/v3/products/';
        $consumerKey = $site->consumer_key;
        $consumerSecret = $site->consumer_secret;

        $selected = $request->input('selected_games');
        $existing = session('selected_games', []);

        $existingAssoc = [];
        $seenKeys = [];

        // Keep existing products in session (normalize all data structures)
        foreach ($existing as $item) {
            $game_id = $item['id'];
            $bundle_amount = (float) ($item['game_currency_amount'] ?? 0);

            // Normalize source to lowercase to avoid key mismatch
            $source = strtolower($item['source'] ?? ($item['bundle'] ?? 'random'));
            $key = "{$game_id}-{$bundle_amount}-{$source}";

            if (!in_array($key, $seenKeys)) {
                // Normalize the data structure for both Random and Custom products
                if ($source === 'random') {
                    $existingAssoc[] = [
                        'id' => (int) $game_id,
                        'name' => $item['name'] ?? 'Product',
                        'unit_price' => (float) $item['unit_price'],
                        'game_currency_amount' => (string) $bundle_amount,
                        'game_currency' => $item['game_currency'] ?? '',
                        'bundle_id' => $item['bundle_id'] ?? null,
                        'source' => 'Random',
                        'can_edit_price' => 0,
                        'remaining_days' => 0,
                        'slug' => $item['slug'] ?? '',
                        'game_platform' => $item['game_platform'] ?? '',
                        'game_region' => $item['game_region'] ?? '',
                        'game_need_to_capture' => $item['game_need_to_capture'] ?? '{}',
                    ];
                } else {
                    $existingAssoc[] = [
                        'id' => (int) $game_id,
                        'unit_price' => (float) $item['unit_price'],
                        'game_currency_amount' => (string) $bundle_amount,
                        'bundle_id' => $item['bundle_id'] ?? null,
                        'source' => 'Custom',
                        'can_edit_price' => $item['can_edit_price'] ?? 1,
                        'remaining_days' => $item['remaining_days'] ?? 1,
                        'name' => $item['name'] ?? 'Unknown',
                        'slug' => $item['slug'] ?? '',
                        'game_currency' => $item['game_currency'] ?? '',
                        'game_platform' => $item['game_platform'] ?? '',
                        'game_region' => $item['game_region'] ?? '',
                        'game_need_to_capture' => $item['game_need_to_capture'] ?? '{}',
                    ];
                }
                $seenKeys[] = $key;
            }
        }

        // Fetch and add new products with complete data
        foreach ($selected as $gameData) {
            $game_id = $gameData['product_id'] ?? $gameData['id'];
            $bundle_amount = (float) $gameData['game_currency_amount'];
            $key = "{$game_id}-{$bundle_amount}-custom";

            if (!in_array($key, $seenKeys)) {
                // Fetch product details from WooCommerce
                $productResponse = Http::withBasicAuth($consumerKey, $consumerSecret)
                    ->get($woocommerceBaseUrl . $game_id);

                if ($productResponse->successful()) {
                    $product = $productResponse->json();
                    $meta = collect($product['meta_data'] ?? []);
                    $getMeta = fn($key) => $meta->firstWhere('key', $key)['value'] ?? null;

                    $existingAssoc[] = [
                        'id' => (int) $game_id,
                        'unit_price' => (float) $gameData['unit_price'],
                        'game_currency_amount' => (string) $bundle_amount,
                        'bundle_id' => $getMeta('bundle_id'),
                        'source' => 'Custom',
                        'can_edit_price' => 1,
                        'remaining_days' => 1,
                        'name' => $product['name'] ?? 'Unknown',
                        'slug' => $product['slug'] ?? '',
                        'game_currency' => $product['sku'] ?? '',
                        'game_platform' => $product['categories'][0]['name'] ?? '',
                        'game_region' => $getMeta('game_region') ?? '',
                        'game_need_to_capture' => $getMeta('game_need_to_capture') ?? '{}',
                    ];
                    $seenKeys[] = $key;
                }
            }
        }

        // Update session with complete product data
        session(['selected_games' => $existingAssoc]);

        // Build display products (same as session data now)
        $finalProducts = collect($existingAssoc)->map(function ($item) {
            return (object) $item;
        });

        $bestTotal = $finalProducts->sum('unit_price');
        session(['current_amount' => $bestTotal]);

        $modelType = $site->businessModel->model_type;

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $finalProducts,
            'site'     => $site,
        ])->render();

        return response()->json([
            'success' => true,
            'tableRows' => $tableRows,
            'total' => $bestTotal,
            'is_random' => false,
            'products' => $finalProducts,
        ]);
    }




   public function generateInvoice(Request $request)
    {
        $site = Website::findOrFail($request->input('site_id'));
        DynamicDatabaseService::connect($site);

        $company_detail_type = $request->input('company_detail_type');

        if ($company_detail_type === 'remote') {

            $invoice_data['site_name']           = $request->input('remote_site_name') ?? '';
            $invoice_data['company_name']        = $request->input('remote_company_name') ?? '';
            $invoice_data['company_email']       = $request->input('remote_company_email') ?? '';
            $invoice_data['company_mobile']      = $request->input('remote_company_mobile') ?? '';
            $invoice_data['company_address']     = $request->input('remote_company_address') ?? '';
            $invoice_data['registration_number'] = $request->input('remote_registration_number') ?? '';
            $invoice_data['license_number']      = $request->input('remote_license_number') ?? '';
        
            $remote_database = DB::connection($this->connectionType)
                ->table('general_settings')
                ->orderByDesc('updated_at')
                ->first();
        
            if ($remote_database) {
                DB::connection($this->connectionType)
                    ->table('general_settings')
                    ->where('id', $remote_database->id)
                    ->update([
                        'site_name'  => $invoice_data['site_name'],
                        'email'      => $invoice_data['company_email'],
                        'phone'      => $invoice_data['company_mobile'],
                        'address'    => $invoice_data['company_address'],
                        'updated_at' => now(),
                    ]);
            }
        
        } else {
        
            $invoice_data['site_name']           = $request->input('local_site_name') ?? '';
            $invoice_data['company_name']        = $request->input('local_company_name') ?? '';
            $invoice_data['company_email']       = $request->input('local_company_email') ?? '';
            $invoice_data['company_mobile']      = $request->input('local_company_mobile') ?? '';
            $invoice_data['company_address']     = $request->input('local_company_address') ?? '';
            $invoice_data['registration_number'] = $request->input('local_registration_number') ?? '';
            $invoice_data['license_number']      = $request->input('local_license_number') ?? '';
        
            $site->site_name            = $invoice_data['site_name'];
            $site->company_name         = $invoice_data['company_name'];
            $site->company_email        = $invoice_data['company_email'];
            $site->company_mobile       = $invoice_data['company_mobile'];
            $site->company_address      = $invoice_data['company_address'];
            $site->registration_number  = $invoice_data['registration_number'];
            $site->license_number       = $invoice_data['license_number'];
            $site->save();
        }
        
        $invoice_data = array_merge($invoice_data, [
            'site'                 => $site,
            'invoice_number'       => $request->input('invoice_number'),
            'invoice_date'         => $request->input('invoice_date'),
            'customer_name'        => $request->input('customer_name'),
            'customer_mobile'      => $request->input('customer_mobile'),
            'customer_email'       => $request->input('customer_email'),
            'currency'             => site_currency(),
            'product_ids'          => [],
            'invoice_amount'       => $request->input('invoice_amount'),
            'current_amount'       => $request->input('current_amount'),
            'discount_amount'      => $request->input('discount_amount'),
            'invoice_header_image' => base64EncodeImage($site->invoice_header_image),
            'invoice_footer_image' => base64EncodeImage($site->invoice_footer_image),
            'invoice_signature'    => base64EncodeImage($site->invoice_signature),
            'company_logo'         => base64EncodeImage($site->company_logo),
            'invoice_image1'       => base64EncodeImage($site->invoice_image1),
            'invoice_image2'       => base64EncodeImage($site->invoice_image2),
            'invoice_image3'       => base64EncodeImage($site->invoice_image3),
            'invoice_image4'       => base64EncodeImage($site->invoice_image4),
            'invoice_image5'       => base64EncodeImage($site->invoice_image5),
            'invoice_image6'       => base64EncodeImage($site->invoice_image6),
            'invoice_image7'       => base64EncodeImage($site->invoice_image7),
            'invoice_image8'       => base64EncodeImage($site->invoice_image8),
            'invoice_image9'       => base64EncodeImage($site->invoice_image9),
            'invoice_template'     => $site->invoice_template,
            'model_type'           => $site->businessModel->model_type,
            'site_id'              => $site->id,
        ]);

        $products = $request->input('products', []);
        $processedProducts = [];

        foreach ($products as $productId => $productData) {
            $productData['product_id'] = $productId;
            $processedProducts[] = $productData;
        }
        $invoice_data['products'] = $processedProducts;
        $modelType = strtolower($site->businessModel->model_type);
        $siteWords = numberToWords($site->id);
        $viewPath  = "websites.{$modelType}.{$siteWords}";

        $this->updateProductPrice($processedProducts);

        InvoiceController::createInvoiceHistory($invoice_data, $processedProducts);
        if ($request->filled('invoice_file_name')) {
            $filename = $request->input('invoice_file_name') . '.pdf';
        } else {
            $filename = $invoice_data['invoice_number'] . '.pdf';
        }

        try {
            return $this->generateWithApi2Pdf($viewPath, $invoice_data, $filename);
        } catch (\Exception $e) {
            // Fallback to Dompdf if API2PDF fails
            return $this->generateWithDompdf($viewPath, $invoice_data, $filename);
        }
    }

    protected function generateWithDompdf($viewPath, $invoice_data, $filename)
    {
        $pdf = \PDF::loadView($viewPath, $invoice_data)->setPaper('A4', 'portrait');
        return $pdf->download($filename);
    }

    protected function generateWithApi2Pdf($viewPath, $invoice_data, $filename)
    {
        $html = View::make($viewPath, $invoice_data)->render();

        $response = Http::withHeaders([
            'Authorization' => env('API2PDF_KEY')
        ])->post('https://v2.api2pdf.com/chrome/html', [
            'html' => $html,
            'fileName' => $filename,
            'options' => [
                'format' => 'A4',
                'landscape' => false
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


    protected function updateProductPrice($productDataArray)
    {
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);

        $updatedProducts = [];
        $errors = [];

        $wooBaseUrl = rtrim($site->site_link, '/') . '/wp-json/wc/v3';
        $wooConsumerKey = $site->consumer_key;
        $wooConsumerSecret = $site->consumer_secret;

        foreach ($productDataArray as $data) {
            if (empty($data['game_currency_amount']) || !isset($data['unit_price']) || !isset($data['product_id'])) {
                \Log::warning("Missing required data for product update", $data);
                continue;
            }

            $variationId = !empty($data['bundle_id']) && is_numeric($data['bundle_id'])
                ? intval($data['bundle_id'])
                : null;

            if (!$variationId) {
                \Log::warning("Invalid or missing bundle_id for product {$data['product_id']}", $data);
                continue;
            }

            $product_id = intval($data['product_id']);
            $unit_price = number_format(floatval($data['unit_price']), 2, '.', '');

            try {
                $productResponse = Http::timeout(30)
                    ->withBasicAuth($wooConsumerKey, $wooConsumerSecret)
                    ->get("{$wooBaseUrl}/products/{$product_id}/variations/{$variationId}");

                if ($productResponse->status() === 404) {
                    \Log::warning("Variation not found: Product ID {$product_id}, Variation ID {$variationId}");
                    $errors[] = "Variation {$variationId} not found for product {$product_id}";
                    continue;
                }

                if ($productResponse->status() === 401) {
                    \Log::error("Authentication failed - check WooCommerce API credentials");
                    $errors[] = "Authentication failed for product {$product_id}";
                    continue;
                }

                if ($productResponse->failed()) {
                    $errorMsg = "Failed to fetch variation {$variationId}: HTTP {$productResponse->status()} - " . $productResponse->body();
                    \Log::error($errorMsg);
                    $errors[] = $errorMsg;
                    continue;
                }

                $productData = $productResponse->json();

                $currentPrice = isset($productData['regular_price']) && $productData['regular_price'] !== ''
                    ? number_format(floatval($productData['regular_price']), 2, '.', '')
                    : '0.00';

                \Log::info("Price comparison for variation {$variationId}: Current={$currentPrice}, New={$unit_price}");

                if ($currentPrice !== $unit_price) {
                    $lastHistory = ProductPriceHistory::where('site_id', $site_id)
                        ->where('product_id', $product_id)
                        ->where('bundle', $variationId)
                        ->orderBy('last_price_changed', 'desc')
                        ->first();

                    $shouldUpdate = false;

                    if (!$lastHistory) {
                        $shouldUpdate = true;
                    } else {
                        $threeMonthsAgo = now()->subMonths(3);
                        if ($lastHistory->last_price_changed < $threeMonthsAgo) {
                            $shouldUpdate = true;
                        } else {
                            \Log::info("Skipping update: last update for variation {$variationId} was within 3 months");
                        }
                    }

                    if ($shouldUpdate) {
                        $updateData = [
                            'regular_price' => $unit_price,
                        ];

                        if (
                            isset($productData['sale_price']) && $productData['sale_price'] !== '' &&
                            floatval($productData['sale_price']) > floatval($unit_price)
                        ) {
                            $updateData['sale_price'] = '';
                        }

                        $updateResponse = Http::timeout(30)
                            ->withBasicAuth($wooConsumerKey, $wooConsumerSecret)
                            ->put("{$wooBaseUrl}/products/{$product_id}/variations/{$variationId}", $updateData);

                        if ($updateResponse->failed()) {
                            $errorMsg = "WooCommerce update failed for variation {$variationId}: HTTP {$updateResponse->status()} - " . $updateResponse->body();
                            \Log::error($errorMsg);
                            $errors[] = $errorMsg;
                            continue;
                        }

                        \Log::info("Successfully updated variation {$variationId} price from {$currentPrice} to {$unit_price}");

                        ProductPriceHistory::create([
                            'site_id' => $site_id,
                            'product_id' => $product_id,
                            'bundle' => $variationId,
                            'unit_price' => floatval($unit_price),
                            'last_price_changed' => now(),
                        ]);

                        $updatedProducts[] = [
                            'variation_id' => $variationId,
                            'product_id' => $product_id,
                            'old_price' => $currentPrice,
                            'new_price' => $unit_price
                        ];
                    }
                } else {
                    \Log::info("No price change needed for variation {$variationId}");
                }
            } catch (\Exception $e) {
                $errorMsg = "Exception for product ID {$product_id}, variation {$variationId}: " . $e->getMessage();
                \Log::error($errorMsg);
                $errors[] = $errorMsg;
                continue;
            }
        }

        \Log::info("Price update summary", [
            'updated_count' => count($updatedProducts),
            'error_count' => count($errors),
            'updated_products' => $updatedProducts
        ]);

        return [
            'updated' => $updatedProducts,
            'errors' => $errors,
            'summary' => [
                'total_processed' => count($productDataArray),
                'updated_count' => count($updatedProducts),
                'error_count' => count($errors)
            ]
        ];
    }



    private function getGameDetails(array $sessongames)
    {
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);
        // Extract unique product IDs from session data
        $ids = collect($sessongames)->pluck('id')->unique();

        // Fetch product details from the database
        $productsData = DB::connection($this->connectionType)
            ->table('products')
            ->whereIn('id', $ids)
            ->select(
                'id',
                'name',
                'slug',
                'game_currency',
                'game_platform',
                'game_server_region',
                'game_need_to_capture'
            )
            ->get()
            ->keyBy('id');

        // Combine session data with DB data
        $finalProducts = collect($sessongames)->map(function ($game) use ($productsData) {
            $product = $productsData[$game['id']] ?? null;

            return (object)[
                'id' => $game['id'],
                'unit_price' => $game['unit_price'],
                'game_currency_amount' => $game['game_currency_amount'],
                //'bundle' => $game['bundle'],
                'bundle_id' => rand(1000, 9999),
                'source' => 'Custom',
                'can_edit_price' => 1,
                'remaining_days' => 1,
                'name' => $product->name ?? 'Unknown',
                'slug' => $product->slug ?? null,
                'game_currency' => $product->game_currency ?? null,
                'game_platform' => $product->game_platform ?? null,
                'game_region' => $product->game_server_region ?? null,
                'game_need_to_capture' => $product->game_need_to_capture ?? null,
            ];
        });


        return $finalProducts;
    }

    public function clearProducts(Request $request)
    {
        session()->forget('selected_games');
        session()->forget('current_amount');
        return response()->json([
            'success' => true,
            'tableRows' => '',
            'currency' => null,
            'total' => 0
        ]);
    }

    public function updateProduct(Request $request)
    {
        $current_amount = $request->get('current_amount');


        session(['current_amount' => $current_amount]);

        return response()->json([
            'success' => true,
            'current_amount' => $current_amount,
        ]);
    }
}
