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

    const TOLERANCE_STEP    = 1;
    const MAX_TOLERANCE     = 30;
    const MAX_ATTEMPTS      = 25;
    const HISTORY_LIMIT     = 2;

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

    private function fetchAllVariationsParallel(array $wpProducts, string $base, string $consumerKey, string $consumerSecret, $priceFrom = null, $priceTo = null): \Illuminate\Support\Collection
    {
        $allProducts = collect();
        $mh = curl_multi_init();
        $handles = [];

        foreach ($wpProducts as $index => $product) {
            $url = $base . '/' . $product['id'] . '/variations?per_page=100&status=publish';
            $ch  = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_multi_add_handle($mh, $ch);
            $handles[$index] = ['handle' => $ch, 'product' => $product];
        }

        $running = null;
        do {
            curl_multi_exec($mh, $running);
            curl_multi_select($mh);
        } while ($running > 0);

        foreach ($handles as $index => $data) {
            $ch      = $data['handle'];
            $product = $data['product'];

            $varBody = curl_multi_getcontent($ch);
            $varCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_multi_remove_handle($mh, $ch);
            curl_close($ch);

            if ($varCode !== 200 || !$varBody) continue;

            $variations = json_decode($varBody, true);
            if (empty($variations)) continue;

            foreach ($variations as $var) {
                if (($var['status'] ?? 'publish') !== 'publish') continue;
                if (($var['stock_status'] ?? 'instock') === 'outofstock') continue;

                $unitPrice = floatval($var['price'] ?? 0);
                if ($unitPrice <= 0) continue;

                if ($priceFrom && $priceTo && ($unitPrice < floatval($priceFrom) || $unitPrice > floatval($priceTo))) continue;

                $attrs        = collect($var['attributes'])->pluck('option', 'name')->toArray();
                $bundleAmount = $attrs['Amount'] ?? '0';

                $allProducts->push((object)[
                    'id'                   => $product['id'],
                    'bundle_id'            => $var['id'],
                    'name'                 => $product['name'],
                    'unit_price'           => $unitPrice,
                    'slug'                 => Str::slug($product['name']),
                    'source'               => 'Random',
                    'can_edit_price'       => 0,
                    'remaining_days'       => 0,
                    'game_currency'        => $product['sku'] ?? '',
                    'game_currency_amount' => $bundleAmount,
                    'game_platform'        => $attrs['Platform'] ?? '',
                    'game_region'          => null,
                    'game_need_to_capture' => null,
                ]);
            }
        }

        curl_multi_close($mh);

        return $allProducts;
    }

    private function findBestCombination(\Illuminate\Support\Collection $allProducts, float $invoiceAmount, int $productCount, array $lastCombinations): ?array
    {
        for ($tolerance = 0; $tolerance <= self::MAX_TOLERANCE; $tolerance += self::TOLERANCE_STEP) {

            $maxTotal = $invoiceAmount * (1 + ($tolerance / 100));
            $minTotal = $invoiceAmount;

            for ($attempt = 0; $attempt < self::MAX_ATTEMPTS; $attempt++) {
                $shuffled = $allProducts->shuffle();
                $sel      = [];
                $cur      = 0.0;
                $usedKeys = [];

                foreach ($shuffled as $p) {
                    $key = $p->id . '-' . $p->bundle_id;
                    if (isset($usedKeys[$key])) continue;

                    $price = floatval($p->unit_price);

                    if ($cur + $price > $maxTotal) continue;

                    $sel[]          = $p;
                    $cur           += $price;
                    $usedKeys[$key] = true;

                    if ($productCount > 0 && count($sel) === $productCount) break;
                }

                if (empty($sel)) continue;

                if ($productCount > 0) {
                    $reachedTarget = (count($sel) === $productCount && $cur >= $minTotal && $cur <= $maxTotal);
                } else {
                    $reachedTarget = ($cur >= $minTotal && $cur <= $maxTotal);
                }

                if (!$reachedTarget) continue;

                $fingerprint = collect($sel)->pluck('bundle_id')->sort()->values()->implode('-');

                if (in_array($fingerprint, $lastCombinations)) continue;

                return [
                    'match'       => $sel,
                    'total'       => $cur,
                    'tolerance'   => $tolerance,
                    'fingerprint' => $fingerprint,
                ];
            }
        }

        return null;
    }

    public function randomProducts(Request $request)
    {
        Session::forget('selected_products');

        $site_id       = $request->get('site_id');
        $invoiceAmount = floatval($request->get('invoice_amount'));
        $priceFrom     = $request->get('price_from');
        $priceTo       = $request->get('price_to');
        $productCount  = intval($request->get('product_count'));
        $searchQuery   = $request->get('search_query');

        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $consumerKey    = $site->consumer_key;
        $consumerSecret = $site->consumer_secret;
        $base           = rtrim($site->site_link, '/') . '/wp-json/wc/v3/products';

        $response = Http::withBasicAuth($consumerKey, $consumerSecret)
            ->get($base, [
                'type'     => 'variable',
                'per_page' => 100,
                'search'   => $searchQuery,
                'status'   => 'publish'
            ]);

        if ($response->failed()) {
            return response()->json(['tableRows' => '', 'total' => 0, 'message' => 'Failed to fetch products']);
        }

        $allProducts = $this->fetchAllVariationsParallel(
            $response->json(),
            $base,
            $consumerKey,
            $consumerSecret,
            $priceFrom,
            $priceTo
        );

        if ($allProducts->isEmpty()) {
            return response()->json(['tableRows' => '', 'total' => 0, 'message' => 'No products available']);
        }

        $modelType        = $site->businessModel->model_type;
        $currency         = site_currency();
        $lastCombinations = session('last_combinations', []);

        $result = $this->findBestCombination($allProducts, $invoiceAmount, $productCount, $lastCombinations);

        if (!$result) {
            session()->forget('ready_products');
            session()->forget('current_amount');

            return response()->json([
                'tableRows' => '',
                'total'     => 0,
                'message'   => 'No matching combination found, try again please'
            ]);
        }

        $bestMatch      = $result['match'];
        $bestTotal      = $result['total'];
        $discountAmount = round($bestTotal - $invoiceAmount, 2);
        $discountPct    = $result['tolerance'];
        $fingerprint    = $result['fingerprint'];

        $lastCombinations[] = $fingerprint;
        if (count($lastCombinations) > self::HISTORY_LIMIT) {
            array_shift($lastCombinations);
        }
        session(['last_combinations' => $lastCombinations]);

        session()->forget('selected_games');

        $selected_games = array_map(function ($g) {
            return [
                'id'                   => $g->id,
                'name'                 => $g->name,
                'unit_price'           => $g->unit_price,
                'game_currency_amount' => $g->game_currency_amount,
                'game_currency'        => $g->game_currency,
                'bundle_id'            => $g->bundle_id,
                'slug'                 => $g->slug,
                'source'               => 'Random',
                'game_platform'        => $g->game_platform,
                'game_region'          => $g->game_region,
                'game_need_to_capture' => $g->game_need_to_capture,
                'can_edit_price'       => 0,
                'remaining_days'       => 0,
                'bundle'               => 'Random',
            ];
        }, $bestMatch);

        session(['selected_games' => $selected_games, 'current_amount' => $bestTotal]);

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products'        => $bestMatch,
            'currency'        => $currency,
            'site'            => $site,
            'discount_pct'    => $discountPct,
            'discount_amount' => $discountAmount,
        ])->render();

        return response()->json([
            'tableRows'       => $tableRows,
            'total'           => $bestTotal,
            'invoice_amount'  => $invoiceAmount,
            'discount_amount' => $discountAmount,
            'currency'        => $currency,
            'discount_pct'    => $discountPct,
            'is_random'       => $searchQuery ? false : true
        ]);
    }

    public function removeProduct(Request $request)
    {
        $id        = $request->get('product_id');
        $unitPrice = $request->get('unit_price');
        $site_id   = $request->get('site_id');

        $selectedGames = session('selected_games', []);

        $updatedGames = array_values(array_filter($selectedGames, function ($game) use ($id, $unitPrice) {
            return !($game['id'] == $id && floatval($game['unit_price']) == floatval($unitPrice));
        }));

        session(['selected_games' => $updatedGames]);

        if (empty($updatedGames)) {
            session()->forget('current_amount');
            return response()->json([
                'tableRows' => '',
                'total'     => 0,
                'currency'  => null,
                'message'   => 'No products remaining'
            ]);
        }

        $site      = Website::findOrFail($site_id);
        $modelType = $site->businessModel->model_type;

        $finalProducts = collect($updatedGames)->map(function ($sessionGame) {
            return (object)[
                'id'                   => $sessionGame['id'],
                'name'                 => $sessionGame['name'] ?? 'Product',
                'bundle_id'            => $sessionGame['bundle_id'] ?? null,
                'unit_price'           => floatval($sessionGame['unit_price']),
                'slug'                 => $sessionGame['slug'] ?? Str::slug($sessionGame['name'] ?? 'product'),
                'source'               => $sessionGame['source'] ?? 'Random',
                'can_edit_price'       => $sessionGame['can_edit_price'] ?? 0,
                'remaining_days'       => $sessionGame['remaining_days'] ?? 0,
                'game_currency'        => $sessionGame['game_currency'] ?? '',
                'game_currency_amount' => $sessionGame['game_currency_amount'] ?? '',
                'game_platform'        => $sessionGame['game_platform'] ?? '',
                'game_region'          => $sessionGame['game_region'] ?? '',
                'game_need_to_capture' => $sessionGame['game_need_to_capture'] ?? '{}'
            ];
        });

        $total = $finalProducts->sum('unit_price');
        session(['current_amount' => $total]);

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
        $site    = Website::findOrFail($site_id);

        $hasKeyword = $request->filled('keyword');
        $keyword    = strtolower($request->keyword);

        $wp_api_url      = rtrim($site->site_link, '/') . '/wp-json/wc/v3/products';
        $consumer_key    = $site->consumer_key;
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

        $response  = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $products = collect();

        if ($http_code == 200 && $response) {
            $wp_products  = json_decode($response, true);
            $mh           = curl_multi_init();
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
                $ch            = $data['handle'];
                $p             = $data['product'];
                $var_response  = curl_multi_getcontent($ch);
                $var_http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

                if ($var_http_code == 200 && $var_response) {
                    $variations = json_decode($var_response, true);

                    if (!empty($variations)) {
                        foreach ($variations as $var) {
                            if (($var['status'] ?? 'publish') !== 'publish') continue;
                            if (($var['stock_status'] ?? 'instock') === 'outofstock') continue;

                            $price = floatval($var['price'] ?? 0);
                            if ($price <= 0) continue;

                            $attrs               = collect($var['attributes'])->pluck('option', 'name')->toArray();
                            $game_currency_amount = !empty($attrs) ? array_values($attrs)[0] : '0';

                            $products->push((object)[
                                'id'                   => $p['id'],
                                'name'                 => $p['name'],
                                'slug'                 => $p['slug'],
                                'game_currency'        => $p['sku'] ?? '',
                                'game_platform'        => $p['categories'][0]['name'] ?? '',
                                'game_server_region'   => '',
                                'game_need_to_capture' => '',
                                'bundle_first_amount'  => $price,
                                'game_currency_amount' => $game_currency_amount,
                                'bundle_id'            => $var['id'],
                            ]);
                        }
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
            'products'       => $products,
            'currency'       => site_currency(),
            'site'           => $site,
            'current_amount' => session('current_amount'),
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'currency'  => site_currency(),
            'is_random' => false
        ]);
    }

    public function addProducts(Request $request)
    {
        $site_id = session('customer.site_id');
        $site    = Website::findOrFail($site_id);

        $woocommerceBaseUrl = rtrim($site->site_link, '/') . '/wp-json/wc/v3/products/';
        $consumerKey        = $site->consumer_key;
        $consumerSecret     = $site->consumer_secret;

        $selected  = $request->input('selected_games');
        $existing  = session('selected_games', []);

        $existingAssoc = [];
        $seenKeys      = [];

        foreach ($existing as $item) {
            $game_id       = $item['id'];
            $bundle_amount = $item['game_currency_amount'] ?? '0';
            $source        = strtolower($item['source'] ?? ($item['bundle'] ?? 'random'));
            $key           = "{$game_id}-{$bundle_amount}-{$source}";

            if (!in_array($key, $seenKeys)) {
                if ($source === 'random') {
                    $existingAssoc[] = [
                        'id'                   => (int) $game_id,
                        'name'                 => $item['name'] ?? 'Product',
                        'unit_price'           => (float) $item['unit_price'],
                        'game_currency_amount' => $item['game_currency_amount'] ?? '0',
                        'game_currency'        => $item['game_currency'] ?? '',
                        'bundle_id'            => $item['bundle_id'] ?? null,
                        'source'               => 'Random',
                        'can_edit_price'       => 0,
                        'remaining_days'       => 0,
                        'slug'                 => $item['slug'] ?? '',
                        'game_platform'        => $item['game_platform'] ?? '',
                        'game_region'          => $item['game_region'] ?? '',
                        'game_need_to_capture' => $item['game_need_to_capture'] ?? '{}',
                    ];
                } else {
                    $existingAssoc[] = [
                        'id'                   => (int) $game_id,
                        'unit_price'           => (float) $item['unit_price'],
                        'game_currency_amount' => $bundle_amount,
                        'bundle_id'            => $item['bundle_id'] ?? null,
                        'source'               => 'Custom',
                        'can_edit_price'       => $item['can_edit_price'] ?? 1,
                        'remaining_days'       => $item['remaining_days'] ?? 1,
                        'name'                 => $item['name'] ?? 'Unknown',
                        'slug'                 => $item['slug'] ?? '',
                        'game_currency'        => $item['game_currency'] ?? '',
                        'game_platform'        => $item['game_platform'] ?? '',
                        'game_region'          => $item['game_region'] ?? '',
                        'game_need_to_capture' => $item['game_need_to_capture'] ?? '{}',
                    ];
                }
                $seenKeys[] = $key;
            }
        }

        foreach ($selected as $gameData) {
            $game_id        = $gameData['product_id'] ?? $gameData['id'];
            $bundle_amount  = $gameData['game_currency_amount'] ?? '0';
            $numeric_amount = preg_replace('/\D/', '', $bundle_amount);
            $key            = "{$game_id}-{$numeric_amount}-custom";

            if (!in_array($key, $seenKeys)) {
                $productResponse = Http::withBasicAuth($consumerKey, $consumerSecret)
                    ->get($woocommerceBaseUrl . $game_id);

                if ($productResponse->successful()) {
                    $product  = $productResponse->json();
                    $meta     = collect($product['meta_data'] ?? []);
                    $getMeta  = fn($key) => $meta->firstWhere('key', $key)['value'] ?? null;

                    $existingAssoc[] = [
                        'id'                   => (int) $game_id,
                        'unit_price'           => (float) $gameData['unit_price'],
                        'game_currency_amount' => $bundle_amount,
                        'bundle_id'            => $getMeta('bundle_id'),
                        'source'               => 'Custom',
                        'can_edit_price'       => 1,
                        'remaining_days'       => 1,
                        'name'                 => $product['name'] ?? 'Unknown',
                        'slug'                 => $product['slug'] ?? '',
                        'game_currency'        => $product['sku'] ?? '',
                        'game_platform'        => $product['categories'][0]['name'] ?? '',
                        'game_region'          => $getMeta('game_region') ?? '',
                        'game_need_to_capture' => $getMeta('game_need_to_capture') ?? '{}',
                    ];
                    $seenKeys[] = $key;
                }
            }
        }

        session(['selected_games' => $existingAssoc]);

        $finalProducts = collect($existingAssoc)->map(fn($item) => (object) $item);
        $bestTotal     = $finalProducts->sum('unit_price');

        session(['current_amount' => $bestTotal]);

        $modelType = $site->businessModel->model_type;

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $finalProducts,
            'site'     => $site,
        ])->render();

        return response()->json([
            'success'   => true,
            'tableRows' => $tableRows,
            'total'     => $bestTotal,
            'is_random' => false,
            'products'  => $finalProducts,
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

            $site->site_name           = $invoice_data['site_name'];
            $site->company_name        = $invoice_data['company_name'];
            $site->company_email       = $invoice_data['company_email'];
            $site->company_mobile      = $invoice_data['company_mobile'];
            $site->company_address     = $invoice_data['company_address'];
            $site->registration_number = $invoice_data['registration_number'];
            $site->license_number      = $invoice_data['license_number'];
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

        $selected_Products = $request->input('products', []);
        $processedProducts = [];

        foreach ($selected_Products as $productId => $product) {
            $processedProducts[] = [
                'id'                   => (int) $productId,
                'bundle_id'            => (int) ($product['bundle_id'] ?? 0),
                'old_price'            => (float) ($product['original_price'] ?? 0),
                'unit_price'           => (float) ($product['unit_price'] ?? 0),
                'game_currency_amount' => $product['game_currency_amount'] ?? null,
            ];
        }

        $invoice_data['products'] = $selected_Products;

        $modelType = strtolower($site->businessModel->model_type);
        $siteWords = numberToWords($site->id);
        $viewPath  = "websites.{$modelType}.{$siteWords}";

        $this->updateProductPrice($processedProducts);

        InvoiceController::createInvoiceHistory($invoice_data, $selected_Products);

        if ($request->filled('invoice_file_name')) {
            $filename = $request->input('invoice_file_name') . '.pdf';
        } else {
            $filename = $invoice_data['invoice_number'] . '.pdf';
        }

        try {
            return $this->generateWithApi2Pdf($viewPath, $invoice_data, $filename);
        } catch (\Exception $e) {
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
            'html'     => $html,
            'fileName' => $filename,
            'options'  => [
                'format'    => 'A4',
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

    protected function updateProductPrice(array $productDataArray)
    {
        $site_id = session('customer.site_id');
        $site    = Website::findOrFail($site_id);

        $updatedProducts = [];
        $errors          = [];

        $consumerKey    = $site->consumer_key;
        $consumerSecret = $site->consumer_secret;
        $base           = rtrim($site->site_link, '/') . '/wp-json/wc/v3/products';

        foreach ($productDataArray as $data) {
            if (!isset($data['bundle_id'], $data['unit_price'])) {
                \Log::warning('Missing required fields', ['data' => $data]);
                continue;
            }

            $product_id   = isset($data['id']) ? (int) $data['id'] : 0;
            $variation_id = (int) $data['bundle_id'];
            $unit_price   = (float) $data['unit_price'];

            if ($product_id <= 0 || $variation_id <= 0) {
                \Log::warning('Invalid product or variation ID', [
                    'product_id'   => $product_id,
                    'variation_id' => $variation_id
                ]);
                continue;
            }

            try {
                $endpoint = $base . '/' . $product_id . '/variations/' . $variation_id;

                $verifyResponse = Http::withBasicAuth($consumerKey, $consumerSecret)
                    ->timeout(30)
                    ->get($endpoint);

                if ($verifyResponse->failed()) {
                    $errors[] = "Variation {$variation_id} does not exist for product {$product_id}";
                    continue;
                }

                $currentData  = $verifyResponse->json();
                $currentPrice = (float) ($currentData['price'] ?? 0);

                if (abs($currentPrice - $unit_price) < 0.01) {
                    continue;
                }

                $updateResponse = Http::withBasicAuth($consumerKey, $consumerSecret)
                    ->timeout(30)
                    ->put($endpoint, [
                        'regular_price' => number_format($unit_price, 2, '.', ''),
                        'sale_price'    => number_format($unit_price, 2, '.', '')
                    ]);

                if ($updateResponse->failed()) {
                    $errors[] = "Product {$product_id}, Variation {$variation_id}: Status {$updateResponse->status()}";
                    continue;
                }

                ProductPriceHistory::create([
                    'site_id'            => $site_id,
                    'product_id'         => $product_id,
                    'bundle'             => (string) $variation_id,
                    'old_price'          => $currentPrice,
                    'unit_price'         => $unit_price,
                    'last_price_changed' => now(),
                ]);

                $updatedProducts[] = [
                    'product_id'   => $product_id,
                    'variation_id' => $variation_id,
                    'old_price'    => $currentPrice,
                    'new_price'    => $unit_price
                ];

            } catch (\Exception $e) {
                $errors[] = "Exception: Variation {$variation_id} - {$e->getMessage()}";
            }
        }

        return [
            'updated_products' => $updatedProducts,
            'errors'           => $errors
        ];
    }

    private function getGameDetails(array $sessongames)
    {
        $site_id = session('customer.site_id');
        $site    = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $ids = collect($sessongames)->pluck('id')->unique();

        $productsData = DB::connection($this->connectionType)
            ->table('products')
            ->whereIn('id', $ids)
            ->select('id', 'name', 'slug', 'game_currency', 'game_platform', 'game_server_region', 'game_need_to_capture')
            ->get()
            ->keyBy('id');

        $finalProducts = collect($sessongames)->map(function ($game) use ($productsData) {
            $product = $productsData[$game['id']] ?? null;

            return (object)[
                'id'                   => $game['id'],
                'unit_price'           => $game['unit_price'],
                'game_currency_amount' => $game['game_currency_amount'],
                'bundle_id'            => rand(1000, 9999),
                'source'               => 'Custom',
                'can_edit_price'       => 1,
                'remaining_days'       => 1,
                'name'                 => $product->name ?? 'Unknown',
                'slug'                 => $product->slug ?? null,
                'game_currency'        => $product->game_currency ?? null,
                'game_platform'        => $product->game_platform ?? null,
                'game_region'          => $product->game_server_region ?? null,
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
            'success'   => true,
            'tableRows' => '',
            'currency'  => null,
            'total'     => 0
        ]);
    }

    public function updateProduct(Request $request)
    {
        $current_amount = $request->get('current_amount');
        session(['current_amount' => $current_amount]);

        return response()->json([
            'success'        => true,
            'current_amount' => $current_amount,
        ]);
    }
}