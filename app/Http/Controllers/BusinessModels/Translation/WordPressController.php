<?php
namespace App\Http\Controllers\BusinessModels\Translation;

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
    private $connectionType;

    public function __construct()
    {
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
        $this->productTable = getProductTable($site->technology);
        $this->connectionType = 'dynamic';
    }

    private function getAvailableUrgencyOptions($site, $unitType)
    {
        $options = [];

        if ($unitType === 'pages') {
            if (!empty($site->urgency_12h_per_page) && floatval($site->urgency_12h_per_page) > 0) {
                $options['12h_per_page'] = [
                    'label' => '12 Hours',
                    'rate'  => floatval($site->urgency_12h_per_page),
                    'key'   => '12h_per_page',
                ];
            }
            if (!empty($site->urgency_24h_per_page) && floatval($site->urgency_24h_per_page) > 0) {
                $options['24h_per_page'] = [
                    'label' => '24 Hours',
                    'rate'  => floatval($site->urgency_24h_per_page),
                    'key'   => '24h_per_page',
                ];
            }
            if (!empty($site->urgency_36_48h_per_page) && floatval($site->urgency_36_48h_per_page) > 0) {
                $options['36_48h_per_page'] = [
                    'label' => '36-48 Hours',
                    'rate'  => floatval($site->urgency_36_48h_per_page),
                    'key'   => '36_48h_per_page',
                ];
            }
        } else {
            if (!empty($site->urgency_12h_per_word) && floatval($site->urgency_12h_per_word) > 0) {
                $options['12h_per_word'] = [
                    'label' => '12 Hours',
                    'rate'  => floatval($site->urgency_12h_per_word),
                    'key'   => '12h_per_word',
                ];
            }
            if (!empty($site->urgency_24h_per_word) && floatval($site->urgency_24h_per_word) > 0) {
                $options['24h_per_word'] = [
                    'label' => '24 Hours',
                    'rate'  => floatval($site->urgency_24h_per_word),
                    'key'   => '24h_per_word',
                ];
            }
            if (!empty($site->urgency_36_48h_per_word) && floatval($site->urgency_36_48h_per_word) > 0) {
                $options['36_48h_per_word'] = [
                    'label' => '36-48 Hours',
                    'rate'  => floatval($site->urgency_36_48h_per_word),
                    'key'   => '36_48h_per_word',
                ];
            }
        }

        return $options;
    }

    private function computeUrgencyAmount($site, $unitType, $quantity, $urgencyType = null)
    {
        if (empty($urgencyType) || $urgencyType === 'none') {
            return 0;
        }

        if ($unitType === 'pages') {
            if ($urgencyType === '12h_per_page') {
                return floatval($site->urgency_12h_per_page ?? 0) * $quantity;
            }
            if ($urgencyType === '24h_per_page') {
                return floatval($site->urgency_24h_per_page ?? 0) * $quantity;
            }
            if ($urgencyType === '36_48h_per_page') {
                return floatval($site->urgency_36_48h_per_page ?? 0) * $quantity;
            }
        } else {
            if ($urgencyType === '12h_per_word') {
                return floatval($site->urgency_12h_per_word ?? 0) * $quantity;
            }
            if ($urgencyType === '24h_per_word') {
                return floatval($site->urgency_24h_per_word ?? 0) * $quantity;
            }
            if ($urgencyType === '36_48h_per_word') {
                return floatval($site->urgency_36_48h_per_word ?? 0) * $quantity;
            }
        }

        return 0;
    }

    public function randomProducts(Request $request)
    {
        $site_id = $request->get('site_id');
        $invoiceAmount = floatval($request->get('invoice_amount'));
        $filterType = $request->get('filter_type');

        if (!$invoiceAmount || $invoiceAmount <= 0) {
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'Please provide a valid invoice amount'
            ]);
        }

        $site = Website::findOrFail($site_id);
        $modelType = $site->businessModel->model_type;

        $auth = base64_encode($site->consumer_key . ':' . $site->consumer_secret);
        $siteUrl = rtrim($site->site_link, '/');

        $products = [];
        $page = 1;

        do {
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $auth,
                'Content-Type' => 'application/json',
                'User-Agent' => 'LaravelApp/1.0'
            ])->get("$siteUrl/wp-json/wc/v3/products", [
                'per_page' => 100,
                'page' => $page,
                'status' => 'publish'
            ]);

            if ($response->failed()) break;

            $data = $response->json();
            $products = array_merge($products, $data);
            $page++;
        } while (!empty($data));

        if (empty($products)) {
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No products found from API.'
            ]);
        }

        $certifiedProduct = collect($products)->first(function ($product) {
            return strtolower(trim($product['name'])) === 'certified translation';
        });

        $standardProduct = collect($products)->first(function ($product) {
            $name = strtolower(trim($product['name']));
            return str_contains($name, 'standard professional translation') ||
                str_contains($name, 'standard translation') ||
                str_contains($name, 'business translation');
        });

        $certifiedPrice = $certifiedProduct ? floatval($certifiedProduct['price'] ?? 0) : 0;
        $standardPrice = $standardProduct ? floatval($standardProduct['price'] ?? 0) : 0;

        if ($certifiedPrice <= 0 && $standardPrice <= 0) {
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No valid products with prices found.'
            ]);
        }

        $certUrgencyOptions = $this->getAvailableUrgencyOptions($site, 'pages');
        $stdUrgencyOptions  = $this->getAvailableUrgencyOptions($site, 'words');
        $hasUrgency         = !empty($certUrgencyOptions) || !empty($stdUrgencyOptions);

        $lastParamsRaw = session()->get('last_wp_translation_params', []);
        $lastParams = [
            'certified_pages'   => $lastParamsRaw['certified_pages']   ?? null,
            'standard_words'    => $lastParamsRaw['standard_words']    ?? null,
            'certified_urgency' => $lastParamsRaw['certified_urgency'] ?? null,
            'standard_urgency'  => $lastParamsRaw['standard_urgency']  ?? null,
        ];

        $selectedProducts = null;
        $finalTotal       = 0;
        $maxAttempts      = 5;

        for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {

            // Randomly pre-select urgency per product (same as LaravelController)
            // $preSelectedUrgency = [
            //     'certified' => $hasUrgency && rand(0, 1) === 1,
            //     'standard'  => $hasUrgency && rand(0, 1) === 1,
            // ];

            // ~25% chance each
            $preSelectedUrgency = [
                'certified' => $hasUrgency && rand(0, 3) === 0,
                'standard'  => $hasUrgency && rand(0, 3) === 0,
            ];
            // Deduct urgency cost from invoice amount first
            $urgentCost = 0;
            if ($preSelectedUrgency['certified'] && $certifiedProduct && !empty($certUrgencyOptions)) {
                $keys        = array_keys($certUrgencyOptions);
                $randomKey   = $keys[array_rand($keys)];
                $urgentCost += $this->computeUrgencyAmount($site, 'pages', 1, $randomKey);
            }
            if ($preSelectedUrgency['standard'] && $standardProduct && !empty($stdUrgencyOptions)) {
                $keys        = array_keys($stdUrgencyOptions);
                $randomKey   = $keys[array_rand($keys)];
                $urgentCost += $this->computeUrgencyAmount($site, 'words', 1, $randomKey);
            }

            $adjustedAmount = $invoiceAmount - $urgentCost;
            if ($adjustedAmount <= 0) continue;

            // Find best page/word combination for adjusted amount
            $bestMatch    = null;
            $bestDistance = PHP_FLOAT_MAX;

            if ($filterType === 'certified' && $certifiedProduct && $certifiedPrice > 0) {

                $basePages  = ceil($adjustedAmount / $certifiedPrice);
                $pagesToTry = range(max(1, $basePages - 2), $basePages + 5);
                foreach ($pagesToTry as $pages) {
                    $total    = $pages * $certifiedPrice;
                    $distance = abs($total - $adjustedAmount);
                    if ($distance < $bestDistance) {
                        $bestDistance = $distance;
                        $bestMatch    = [['product' => $certifiedProduct, 'pages' => $pages,
                                          'base_price' => $certifiedPrice]];
                    }
                }

            } elseif ($filterType === 'standard' && $standardProduct && $standardPrice > 0) {

                $basePages  = ceil($adjustedAmount / $standardPrice);
                $pagesToTry = range(max(250, $basePages - 50), $basePages + 500);
                foreach ($pagesToTry as $pages) {
                    if ($pages < 250) continue;
                    $total    = $pages * $standardPrice;
                    $distance = abs($total - $adjustedAmount);
                    if ($distance < $bestDistance) {
                        $bestDistance = $distance;
                        $bestMatch    = [['product' => $standardProduct, 'pages' => $pages,
                                          'base_price' => $standardPrice]];
                    }
                }

            } elseif ($certifiedProduct && $standardProduct && $certifiedPrice > 0 && $standardPrice > 0) {

                $ratios = [
                    ['cert_ratio' => 0.3, 'std_ratio' => 0.7],
                    ['cert_ratio' => 0.5, 'std_ratio' => 0.5],
                    ['cert_ratio' => 0.7, 'std_ratio' => 0.3],
                    ['cert_ratio' => 0.2, 'std_ratio' => 0.8],
                    ['cert_ratio' => 0.8, 'std_ratio' => 0.2],
                    ['cert_ratio' => 0.4, 'std_ratio' => 0.6],
                    ['cert_ratio' => 0.6, 'std_ratio' => 0.4],
                ];

                foreach ($ratios as $ratio) {
                    $certAmount     = $adjustedAmount * $ratio['cert_ratio'];
                    $stdAmount      = $adjustedAmount * $ratio['std_ratio'];
                    $baseCertPages  = ceil($certAmount / max($certifiedPrice, 0.01));
                    $baseStdPages   = max(250, ceil($stdAmount / max($standardPrice, 0.01)));
                    $certPagesToTry = range(max(1, $baseCertPages - 1), $baseCertPages + 2);
                    $stdPagesToTry  = range(max(250, $baseStdPages - 50), $baseStdPages + 100);

                    foreach ($certPagesToTry as $certPages) {
                        foreach ($stdPagesToTry as $stdPages) {
                            if ($stdPages < 250) continue;
                            $total    = ($certPages * $certifiedPrice) + ($stdPages * $standardPrice);
                            if ($total < $adjustedAmount * 0.95) continue;
                            $distance     = abs($total - $adjustedAmount);
                            $balanceScore = abs((($certPages * $certifiedPrice) / max($total, 0.01)) - 0.5);
                            if ($distance < $bestDistance || ($distance === $bestDistance && $balanceScore < 0.3)) {
                                $bestDistance = $distance;
                                $bestMatch    = [
                                    ['product' => $certifiedProduct, 'pages' => $certPages, 'base_price' => $certifiedPrice],
                                    ['product' => $standardProduct,  'pages' => $stdPages,  'base_price' => $standardPrice],
                                ];
                            }
                        }
                    }
                }

            } else {
                // Fallback: whichever product exists
                if ($certifiedProduct && $certifiedPrice > 0) {
                    $basePages  = ceil($adjustedAmount / $certifiedPrice);
                    $pagesToTry = range(max(1, $basePages - 3), $basePages + 8);
                    foreach ($pagesToTry as $pages) {
                        $distance = abs(($pages * $certifiedPrice) - $adjustedAmount);
                        if ($distance < $bestDistance) {
                            $bestDistance = $distance;
                            $bestMatch    = [['product' => $certifiedProduct, 'pages' => $pages,
                                              'base_price' => $certifiedPrice]];
                        }
                    }
                } elseif ($standardProduct && $standardPrice > 0) {
                    $basePages  = max(250, ceil($adjustedAmount / $standardPrice));
                    $pagesToTry = range(max(250, $basePages - 100), $basePages + 500);
                    foreach ($pagesToTry as $pages) {
                        if ($pages < 250) continue;
                        $distance = abs(($pages * $standardPrice) - $adjustedAmount);
                        if ($distance < $bestDistance) {
                            $bestDistance = $distance;
                            $bestMatch    = [['product' => $standardProduct, 'pages' => $pages,
                                              'base_price' => $standardPrice]];
                        }
                    }
                }
            }

            if (!$bestMatch) continue;

            // Build products with urgency applied
            $tempProducts  = [];
            $currentParams = [
                'certified_pages'   => null,
                'standard_words'    => null,
                'certified_urgency' => null,
                'standard_urgency'  => null,
            ];

            foreach ($bestMatch as $item) {
                $product     = (object) $item['product'];
                $pages       = $item['pages'];
                $basePrice   = $item['base_price'];
                $productName = strtolower(trim($product->name));
                $isCertified = ($certifiedProduct && $productName === strtolower(trim($certifiedProduct['name'])));
                $isWordBased = !$isCertified;

                if ($isWordBased && $pages < 250) continue;

                $unitType           = $isCertified ? 'pages' : 'words';
                $availableUrgency   = $isCertified ? $certUrgencyOptions : $stdUrgencyOptions;
                $shouldApplyUrgency = $isCertified ? $preSelectedUrgency['certified'] : $preSelectedUrgency['standard'];
                $urgencyType        = 'none';
                $urgencyAdd         = 0;

                if ($shouldApplyUrgency && !empty($availableUrgency)) {
                    $keys        = array_keys($availableUrgency);
                    $urgencyType = $keys[array_rand($keys)];
                    $urgencyAdd  = $this->computeUrgencyAmount($site, $unitType, $pages, $urgencyType);
                }

                $product->unit_price      = $basePrice;
                $product->pages           = $pages;
                $product->unit_type       = $unitType;
                $product->urgency_type    = $urgencyType;
                $product->urgency_add     = $urgencyAdd;
                $product->urgency_options = $availableUrgency;
                $product->line_total      = ($basePrice * $pages) + $urgencyAdd;
                if ($isCertified) {
                    $product->product_url               = $site->certified_translation_url ?? $site->site_link;
                    $currentParams['certified_pages']   = $pages;
                    $currentParams['certified_urgency'] = $urgencyType;
                } else {
                    $product->product_url              = $site->standard_translation_url ?? $site->site_link;
                    $currentParams['standard_words']   = $pages;
                    $currentParams['standard_urgency'] = $urgencyType;
                }

                $tempProducts[] = $product;
            }

            if (empty($tempProducts)) continue;

            // Deduplicate: skip if same as last result
            $isDifferent = true;
            if ($currentParams['certified_pages'] !== null &&
                $lastParams['certified_pages'] !== null &&
                $currentParams['certified_pages'] == $lastParams['certified_pages'] &&
                $currentParams['certified_urgency'] == $lastParams['certified_urgency']) {
                $isDifferent = false;
            } elseif ($currentParams['standard_words'] !== null &&
                      $lastParams['standard_words'] !== null &&
                      $currentParams['standard_words'] == $lastParams['standard_words'] &&
                      $currentParams['standard_urgency'] == $lastParams['standard_urgency']) {
                $isDifferent = false;
            }

            if ($isDifferent) {
                $selectedProducts = $tempProducts;
                $finalTotal       = collect($tempProducts)->sum('line_total');
                session()->put('last_wp_translation_params', $currentParams);
                break;
            }
        }

        if (!$selectedProducts) {
            return response()->json([
                'tableRows' => '',
                'total'     => 0,
                'message'   => 'No matching combination found, try again please'
            ]);
        }

        // Enrich with price history (can_edit_price / remaining_days)
        foreach ($selectedProducts as $product) {
            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();

            if ($lastUpdate) {
                $lastPriceChanged    = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays       = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = round(max($remainingDays, 0));
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
            }
        }

        session()->forget('ready_products');
        session()->put('ready_products', collect($selectedProducts)->map(function ($product) {
            return [
                'id'           => $product->id,
                'unit_price'   => $product->unit_price,
                'pages'        => $product->pages,
                'urgency_type' => $product->urgency_type,
                'urgency_add'  => $product->urgency_add,
                'unit_type'    => $product->unit_type,
                'product_url'  => $product->product_url,
            ];
        })->toArray());

        $finalTotal = collect($selectedProducts)->sum('line_total');

        session(['current_amount' => $finalTotal]);

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $selectedProducts,
            'site'     => $site,
            'total'    => $finalTotal
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total'     => $finalTotal
        ]);
    }


    public function updateProduct(Request $request)
    {
        $productId   = $request->get('product_id');
        $pages       = intval($request->get('pages'));
        $siteId      = $request->get('site_id');
        $urgencyType = $request->get('urgency_type', 'none');

        if ($pages <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Pages must be greater than zero'
            ], 400);
        }

        $site = Website::findOrFail($siteId);

        $readyProducts = session('ready_products', []);
        foreach ($readyProducts as &$product) {
            if ($product['id'] == $productId) {
                $product['pages']        = $pages;
                $product['urgency_type'] = $urgencyType;
                $product['urgency_add']  = $this->computeUrgencyAmount($site, $product['unit_type'] ?? 'pages', $pages, $urgencyType);
                break;
            }
        }

        session()->put('ready_products', $readyProducts);

        $totalAmount = 0;
        foreach ($readyProducts as $product) {
            $totalAmount += ($product['unit_price'] * ($product['pages'] ?? 1)) + ($product['urgency_add'] ?? 0);
        }

        session(['current_amount' => $totalAmount]);

        return response()->json([
            'success' => true,
            'total'   => $totalAmount
        ]);
    }


    public function removeProduct(Request $request)
    {
        $productId = $request->get('product_id');
        $site_id   = $request->get('site_id');
        $site      = Website::findOrFail($site_id);
        $modelType = $site->businessModel->model_type;

        $readyProducts = session('ready_products', []);

        $updatedProducts = collect($readyProducts)->filter(function ($product) use ($productId) {
            return $product['id'] != $productId;
        })->values()->toArray();

        session()->put('ready_products', $updatedProducts);

        if (empty($updatedProducts)) {
            session()->forget('current_amount');
            return response()->json([
                'tableRows' => '',
                'total'     => 0,
                'currency'  => null
            ]);
        }

        $consumerKey    = $site->consumer_key;
        $consumerSecret = $site->consumer_secret;
        $siteUrl        = $site->site_link;
        $auth           = base64_encode($consumerKey . ':' . $consumerSecret);

        $productIds       = collect($updatedProducts)->pluck('id')->all();
        $selectedProducts = [];

        foreach ($productIds as $id) {
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $auth,
                'Content-Type'  => 'application/json',
                'User-Agent'    => 'LaravelApp/1.0'
            ])->get("{$siteUrl}/wp-json/wc/v3/products/{$id}");

            if ($response->failed()) continue;

            $apiProduct     = (object) $response->json();
            $sessionProduct = collect($updatedProducts)->firstWhere('id', $id);

            $unitType    = $sessionProduct['unit_type']    ?? 'words';
            $urgencyType = $sessionProduct['urgency_type'] ?? 'none';
            $pages       = intval($sessionProduct['pages']);
            $unitPrice   = floatval($sessionProduct['unit_price']);

            $urgencyAdd = $this->computeUrgencyAmount($site, $unitType, $pages, $urgencyType);

            $apiProduct->unit_price      = $unitPrice;
            $apiProduct->pages           = $pages;
            $apiProduct->urgency_type    = $urgencyType;
            $apiProduct->urgency_add     = $urgencyAdd;
            $apiProduct->line_total      = ($pages * $unitPrice) + $urgencyAdd;
            $apiProduct->can_edit_price  = 1;
            $apiProduct->remaining_days  = 0;
            $apiProduct->unit_type       = $unitType;
            $apiProduct->urgency_options = $this->getAvailableUrgencyOptions($site, $unitType);

            $selectedProducts[] = $apiProduct;
        }

        $finalTotal = collect($selectedProducts)->sum('line_total');
        session(['current_amount' => $finalTotal]);

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $selectedProducts,
            'site'     => $site,
            'total'    => $finalTotal
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total'     => $finalTotal
        ]);
    }


    public function clearProducts(Request $request)
    {
        session()->forget('ready_products');
        session()->forget('current_amount');

        return response()->json([
            'success'   => true,
            'message'   => 'Randomized products filter has been cleared.',
            'tableRows' => '',
            'currency'  => null,
            'total'     => 0
        ]);
    }


    public function filterProducts(Request $request)
    {

    }


    public function addProducts(Request $request)
    {

    }

    private function smartPagination($currentPage, $totalPages)
    {
        $pages   = [];
        $pages[] = 1;

        if ($currentPage > 4) {
            $pages[] = '...';
        }

        $start = max(2, $currentPage - 3);
        $end   = min($totalPages - 1, $currentPage + 3);

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
        $site    = Website::findOrFail($site_id);
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

            $remote_database = DB::connection($this->connectionType)->table('general_settings')->orderByDesc('updated_at')->first();
            if ($remote_database) {
                DB::connection($this->connectionType)->table('general_settings')->where('id', $remote_database->id)
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
            $invoice_data['registration_number'] = $request->input('registration_number') ?? '';
            $invoice_data['license_number']      = $request->input('license_number') ?? '';

            $site->site_name           = $invoice_data['site_name'];
            $site->company_name        = $invoice_data['company_name'];
            $site->company_email       = $invoice_data['company_email'];
            $site->company_mobile      = $invoice_data['company_mobile'];
            $site->company_address     = $invoice_data['company_address'];
            $site->registration_number = $invoice_data['registration_number'];
            $site->license_number      = $invoice_data['license_number'];
            $site->save();
        }

        $invoice_data['site']            = $site;
        $invoice_data['invoice_number']  = $request->input('invoice_number');
        $invoice_data['invoice_date']    = $request->input('invoice_date');
        $invoice_data['customer_name']   = $request->input('customer_name');
        $invoice_data['customer_mobile'] = $request->input('customer_mobile');
        $invoice_data['customer_email']  = $request->input('customer_email');
        $invoice_data['invoice_amount']  = $request->input('invoice_amount');
        $invoice_data['current_amount']  = $request->input('current_amount');
        $invoice_data['discount_amount'] = $request->input('discount_amount');

        $invoice_data['invoice_header_image'] = base64EncodeImage($site->invoice_header_image);
        $invoice_data['invoice_footer_image'] = base64EncodeImage($site->invoice_footer_image);
        $invoice_data['invoice_signature']    = base64EncodeImage($site->invoice_signature);
        $invoice_data['company_logo']         = base64EncodeImage($site->company_logo);
        $invoice_data['invoice_image1']       = base64EncodeImage($site->invoice_image1);
        $invoice_data['invoice_image2']       = base64EncodeImage($site->invoice_image2);
        $invoice_data['invoice_image3']       = base64EncodeImage($site->invoice_image3);
        $invoice_data['invoice_image4']       = base64EncodeImage($site->invoice_image4);
        $invoice_data['invoice_image5']       = base64EncodeImage($site->invoice_image5);
        $invoice_data['invoice_image6']       = base64EncodeImage($site->invoice_image6);
        $invoice_data['invoice_image7']       = base64EncodeImage($site->invoice_image7);
        $invoice_data['invoice_image8']       = base64EncodeImage($site->invoice_image8);
        $invoice_data['invoice_image9']       = base64EncodeImage($site->invoice_image9);

        $invoice_data['invoice_template'] = $site->invoice_template;
        $invoice_data['model_type']       = $site->businessModel->model_type;
        $invoice_data['site_id']          = $site->id;
        $invoice_data['currency']         = site_currency();

        $productsInput = $request->input('products', []);
        $productIds    = array_keys($productsInput);

        $auth    = base64_encode($site->consumer_key . ':' . $site->consumer_secret);
        $siteUrl = rtrim($site->site_link, '/');

        $apiProducts = collect();
        foreach ($productIds as $id) {
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $auth,
                'Content-Type'  => 'application/json',
                'User-Agent'    => 'LaravelApp/1.0'
            ])->get("{$siteUrl}/wp-json/wc/v3/products/{$id}");

            if ($response->successful()) {
                $apiProducts->push((object) $response->json());
            }
        }

        $certifiedProductInput = collect($productsInput)->first(function ($product) {
            return strtolower(trim($product['name'])) === 'certified translation';
        });

        $apiProducts = $apiProducts->map(function ($product) use ($productsInput, $certifiedProductInput, $site) {
            if (!isset($productsInput[$product->id])) return $product;
            $input = $productsInput[$product->id];

            $unitType    = ($certifiedProductInput && strtolower(trim($product->name)) === strtolower(trim($certifiedProductInput['name'])))
                           ? 'pages'
                           : 'words';
            $urgencyType = $input['urgency_type'] ?? 'none';
            $pages       = (int) ($input['pages'] ?? 1);
            $unitPrice   = (float) ($input['price'] ?? $product->price ?? 0);
            $urgencyAdd  = $this->computeUrgencyAmount($site, $unitType, $pages, $urgencyType);

            $product->name          = $input['name'] ?? 'Unknown';
            $product->unit_price    = $unitPrice;
            $product->pages         = $pages;
            $product->urgency_type  = $urgencyType;
            $product->urgency_add   = $urgencyAdd;
            $product->is_urgent     = ($urgencyType !== 'none') ? 1 : 0;
            $product->urgent_amount = $urgencyAdd;
            $product->line_total    = ($unitPrice * $pages) + $urgencyAdd;
            $product->from_language = $input['from_language'] ?? null;
            $product->to_language   = $input['to_language'] ?? null;
            $product->selected      = isset($input['selected']) ? 1 : 0;
            $product->unit_type     = $unitType;

            return $product;
        });

        $languages   = site_languages()->pluck('name', 'id');
        $apiProducts = $apiProducts->transform(function ($product) use ($languages) {
            $product->from_language = $languages[$product->from_language] ?? $product->from_language;
            $product->to_language   = $languages[$product->to_language]   ?? $product->to_language;
            return $product;
        });

        $invoice_data['products']    = $apiProducts;
        $invoice_data['product_ids'] = $productIds;

        $modelType     = strtolower($site->businessModel->model_type);
        $siteIdInWords = numberToWords($site->id);
        $viewPath      = "websites.{$modelType}.{$siteIdInWords}";

        if (!empty($productsInput)) {
            $this->updateProductPrice($productsInput, $site);
        }

        InvoiceController::createInvoiceHistory($invoice_data);

        $filename = $request->filled('invoice_file_name')
            ? $request->input('invoice_file_name') . '.pdf'
            : $invoice_data['invoice_number'] . '.pdf';

        try {
            return $this->generateWithApi2Pdf($site, $viewPath, $invoice_data, $filename);
        } catch (\Exception $e) {
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
            'html'     => $html,
            'fileName' => $filename,
            'options'  => [
                'format'                => $site->pdf_size ?? 'A4',
                'landscape'             => ($site->pdf_orientation ?? 'portrait') === 'landscape',
                'marginTop'             => '0mm',
                'marginBottom'          => '0mm',
                'marginLeft'            => '0mm',
                'marginRight'           => '0mm',
                'disableSmartShrinking' => true,
                'zoom'                  => 1,
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


    protected function updateProductPrice($productDataArray, $site = null)
    {
        $site_id = $site ? $site->id : session('customer.site_id');
        $site    = $site ?? Website::findOrFail($site_id);
        $auth    = base64_encode($site->consumer_key . ':' . $site->consumer_secret);
        $siteUrl = rtrim($site->site_link, '/');

        foreach ($productDataArray as $item) {
            $data = is_string($item) ? json_decode($item, true) : $item;

            if (!empty($data['id']) && isset($data['price'])) {
                $product_id     = intval($data['id']);
                $new_price      = floatval($data['price']);
                $can_edit_price = intval($data['can_edit_price'] ?? 1);

                if ($can_edit_price == 0) {
                    Log::info("Price edit not allowed for product ID {$product_id}, skipping.");
                    continue;
                }

                $response = Http::withHeaders([
                    'Authorization' => 'Basic ' . $auth,
                    'Content-Type'  => 'application/json',
                    'User-Agent'    => 'LaravelApp/1.0'
                ])->get("{$siteUrl}/wp-json/wc/v3/products/{$product_id}");

                if (!$response->successful()) {
                    Log::error("Failed to fetch product ID {$product_id}: " . $response->body());
                    continue;
                }

                $product       = (object) $response->json();
                $current_price = floatval($product->regular_price ?? $product->price);

                if ($current_price == $new_price) {
                    Log::info("No price change for product ID {$product_id}. Current price: {$current_price}");
                    continue;
                }

                $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                    ->where('product_id', $product_id)
                    ->orderByDesc('last_price_changed')
                    ->first();

                $shouldUpdateHistory = false;

                if (!$lastUpdate) {
                    $shouldUpdateHistory = true;
                } elseif (Carbon::parse($lastUpdate->last_price_changed)->diffInMonths(now()) >= 3) {
                    $shouldUpdateHistory = true;
                }

                $updateResponse = Http::withHeaders([
                    'Authorization' => 'Basic ' . $auth,
                    'Content-Type'  => 'application/json',
                    'User-Agent'    => 'LaravelApp/1.0'
                ])->put("{$siteUrl}/wp-json/wc/v3/products/{$product_id}", [
                    'regular_price' => strval($new_price),
                    'sale_price'    => '',
                ]);

                if ($updateResponse->successful()) {
                    Log::info("Updated price for product ID {$product_id} from {$current_price} to {$new_price}");


                    $productName = strtolower(trim($product->name));

                    $isCertified = $productName === 'certified translation';

                    $isStandard = str_contains($productName, 'standard professional translation') ||
                                str_contains($productName, 'standard translation') ||
                                str_contains($productName, 'business translation');

                                
                    if ($isCertified) {
                        $site->urgency_12h_per_page = $new_price;
                        $site->urgency_24h_per_page = round($new_price / 2, 4);
                    } elseif ($isStandard) {
                        $site->urgency_12h_per_word = $new_price;
                        $site->urgency_24h_per_word = round($new_price / 2, 4);
                    }

                    $site->save();


                    if ($shouldUpdateHistory) {
                        ProductPriceHistory::create([
                            'site_id'            => $site_id,
                            'product_id'         => $product_id,
                            'unit_price'         => $new_price,
                            'last_price_changed' => now(),
                        ]);
                    }
                } else {
                    Log::error("Failed to update price for product ID {$product_id}: " . $updateResponse->body());
                }
            }
        }
    }
}