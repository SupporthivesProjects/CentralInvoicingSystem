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
    
        $basePercentage = 15;
        $urgencyChance = min(log($invoiceAmount + 1, 10) * $basePercentage, 100);
        $urgentAmount = $site->urgency_amount;
    
        $bestMatch = null;
        $bestDistance = PHP_FLOAT_MAX;
    
        if ($filterType === 'certified' && $certifiedProduct && $certifiedPrice > 0) {
            $bestScenario = null;
            $bestDistance = PHP_FLOAT_MAX;
            
            $basePages = ceil($invoiceAmount / $certifiedPrice);
            $pagesToTry = range(max(1, $basePages - 2), $basePages + 5);
            
            foreach ($pagesToTry as $pages) {
                $totalWithoutUrgency = $pages * $certifiedPrice;
                $distanceWithoutUrgency = abs($totalWithoutUrgency - $invoiceAmount);
                
                if ($distanceWithoutUrgency < $bestDistance) {
                    $bestDistance = $distanceWithoutUrgency;
                    $bestScenario = [
                        'pages' => $pages,
                        'total' => $totalWithoutUrgency,
                        'is_urgent' => false
                    ];
                }
                
                $totalWithUrgency = $pages * ($certifiedPrice + $urgentAmount);
                $distanceWithUrgency = abs($totalWithUrgency - $invoiceAmount);
                
                if ($distanceWithUrgency < $bestDistance) {
                    $bestDistance = $distanceWithUrgency;
                    $bestScenario = [
                        'pages' => $pages,
                        'total' => $totalWithUrgency,
                        'is_urgent' => true
                    ];
                }
            }
            
            if ($bestScenario) {
                $bestMatch = [[
                    'product' => $certifiedProduct,
                    'pages' => $bestScenario['pages'],
                    'total' => $bestScenario['total'],
                    'is_urgent' => $bestScenario['is_urgent'] && (rand(1, 100) <= $urgencyChance),
                    'base_price' => $certifiedPrice
                ]];
            }
        } elseif ($filterType === 'standard' && $standardProduct && $standardPrice > 0) {
            $bestScenario = null;
            $bestDistance = PHP_FLOAT_MAX;
            
            $basePages = ceil($invoiceAmount / $standardPrice);
            $pagesToTry = range(max(250, $basePages - 50), $basePages + 500);
            
            foreach ($pagesToTry as $pages) {
                if ($pages < 250) continue;
                
                $totalWithoutUrgency = $pages * $standardPrice;
                $distanceWithoutUrgency = abs($totalWithoutUrgency - $invoiceAmount);
                
                if ($distanceWithoutUrgency < $bestDistance) {
                    $bestDistance = $distanceWithoutUrgency;
                    $bestScenario = [
                        'pages' => $pages,
                        'total' => $totalWithoutUrgency,
                        'is_urgent' => false
                    ];
                }
                
                $totalWithUrgency = $pages * ($standardPrice + $urgentAmount);
                $distanceWithUrgency = abs($totalWithUrgency - $invoiceAmount);
                
                if ($distanceWithUrgency < $bestDistance) {
                    $bestDistance = $distanceWithUrgency;
                    $bestScenario = [
                        'pages' => $pages,
                        'total' => $totalWithUrgency,
                        'is_urgent' => true
                    ];
                }
            }
            
            if ($bestScenario) {
                $bestMatch = [[
                    'product' => $standardProduct,
                    'pages' => $bestScenario['pages'],
                    'total' => $bestScenario['total'],
                    'is_urgent' => $bestScenario['is_urgent'] && (rand(1, 100) <= $urgencyChance),
                    'base_price' => $standardPrice
                ]];
            }
        } elseif ($certifiedProduct && $standardProduct && $certifiedPrice > 0 && $standardPrice > 0) {
            $urgencyScenarios = [
                ['cert_urgent' => false, 'std_urgent' => false],
                ['cert_urgent' => true, 'std_urgent' => false],
                ['cert_urgent' => false, 'std_urgent' => true],
                ['cert_urgent' => true, 'std_urgent' => true],
            ];
            
            $ratios = [
                ['cert_ratio' => 0.3, 'std_ratio' => 0.7],
                ['cert_ratio' => 0.5, 'std_ratio' => 0.5],
                ['cert_ratio' => 0.7, 'std_ratio' => 0.3],
                ['cert_ratio' => 0.2, 'std_ratio' => 0.8],
                ['cert_ratio' => 0.8, 'std_ratio' => 0.2],
                ['cert_ratio' => 0.4, 'std_ratio' => 0.6],
                ['cert_ratio' => 0.6, 'std_ratio' => 0.4],
            ];
    
            $results = collect($urgencyScenarios)->map(function($urgencyScenario) use ($ratios, $certifiedPrice, $standardPrice, $urgentAmount, $invoiceAmount, $certifiedProduct, $standardProduct, $urgencyChance) {
                $certEffectivePrice = $certifiedPrice + ($urgencyScenario['cert_urgent'] ? $urgentAmount : 0);
                $stdEffectivePrice = $standardPrice + ($urgencyScenario['std_urgent'] ? $urgentAmount : 0);
                
                $localBest = null;
                $localDistance = PHP_FLOAT_MAX;
                
                foreach ($ratios as $ratio) {
                    $certAmount = $invoiceAmount * $ratio['cert_ratio'];
                    $stdAmount = $invoiceAmount * $ratio['std_ratio'];
    
                    $baseCertPages = ceil($certAmount / $certEffectivePrice);
                    $baseStdPages = max(250, ceil($stdAmount / $stdEffectivePrice));
                    
                    $certPagesToTry = range(max(1, $baseCertPages - 1), $baseCertPages + 2);
                    $stdPagesToTry = range(max(250, $baseStdPages - 50), $baseStdPages + 100);
                    
                    foreach ($certPagesToTry as $certPages) {
                        foreach ($stdPagesToTry as $stdPages) {
                            if ($stdPages < 250) continue;
                            
                            $certTotal = $certPages * $certEffectivePrice;
                            $stdTotal = $stdPages * $stdEffectivePrice;
                            $total = $certTotal + $stdTotal;
    
                            if ($total >= $invoiceAmount * 0.95) {
                                $distance = abs($total - $invoiceAmount);
                                $balanceScore = abs(($certTotal / $total) - 0.5);
    
                                if ($distance < $localDistance || ($distance === $localDistance && $balanceScore < 0.3)) {
                                    $localBest = [
                                        'match' => [
                                            [
                                                'product' => $certifiedProduct,
                                                'pages' => $certPages,
                                                'total' => $certTotal,
                                                'is_urgent' => $urgencyScenario['cert_urgent'] && (rand(1, 100) <= $urgencyChance),
                                                'base_price' => $certifiedPrice
                                            ],
                                            [
                                                'product' => $standardProduct,
                                                'pages' => $stdPages,
                                                'total' => $stdTotal,
                                                'is_urgent' => $urgencyScenario['std_urgent'] && (rand(1, 100) <= $urgencyChance),
                                                'base_price' => $standardPrice
                                            ]
                                        ],
                                        'distance' => $distance
                                    ];
                                    $localDistance = $distance;
                                }
                            }
                        }
                    }
                }
                
                return $localBest;
            })->filter()->sortBy('distance')->first();
    
            if ($results) {
                $bestMatch = $results['match'];
                $bestDistance = $results['distance'];
            }
        }
    
        if (!$bestMatch) {
            if ($certifiedProduct && $certifiedPrice > 0) {
                $bestScenario = null;
                $bestDistance = PHP_FLOAT_MAX;
                
                $basePages = ceil($invoiceAmount / $certifiedPrice);
                $pagesToTry = range(max(1, $basePages - 3), $basePages + 8);
                
                foreach ($pagesToTry as $pages) {
                    $totalWithoutUrgency = $pages * $certifiedPrice;
                    $distanceWithoutUrgency = abs($totalWithoutUrgency - $invoiceAmount);
                    
                    if ($distanceWithoutUrgency < $bestDistance) {
                        $bestDistance = $distanceWithoutUrgency;
                        $bestScenario = [
                            'product' => $certifiedProduct,
                            'pages' => $pages,
                            'total' => $totalWithoutUrgency,
                            'is_urgent' => false,
                            'base_price' => $certifiedPrice
                        ];
                    }
                    
                    $totalWithUrgency = $pages * ($certifiedPrice + $urgentAmount);
                    $distanceWithUrgency = abs($totalWithUrgency - $invoiceAmount);
                    
                    if ($distanceWithUrgency < $bestDistance) {
                        $bestDistance = $distanceWithUrgency;
                        $bestScenario = [
                            'product' => $certifiedProduct,
                            'pages' => $pages,
                            'total' => $totalWithUrgency,
                            'is_urgent' => true,
                            'base_price' => $certifiedPrice
                        ];
                    }
                }
                
                if ($bestScenario) {
                    $bestMatch = [[$bestScenario]];
                }
            }
    
            if ($standardProduct && $standardPrice > 0 && (!$bestMatch || $bestDistance > 50)) {
                $bestScenario = null;
                $currentBestDistance = $bestMatch ? $bestDistance : PHP_FLOAT_MAX;
                
                $basePages = max(250, ceil($invoiceAmount / $standardPrice));
                $pagesToTry = range(max(250, $basePages - 100), $basePages + 500);
                
                foreach ($pagesToTry as $pages) {
                    if ($pages < 250) continue;
                    
                    $totalWithoutUrgency = $pages * $standardPrice;
                    $distanceWithoutUrgency = abs($totalWithoutUrgency - $invoiceAmount);
                    
                    if ($distanceWithoutUrgency < $currentBestDistance) {
                        $currentBestDistance = $distanceWithoutUrgency;
                        $bestScenario = [
                            'product' => $standardProduct,
                            'pages' => $pages,
                            'total' => $totalWithoutUrgency,
                            'is_urgent' => false,
                            'base_price' => $standardPrice
                        ];
                    }
                    
                    $totalWithUrgency = $pages * ($standardPrice + $urgentAmount);
                    $distanceWithUrgency = abs($totalWithUrgency - $invoiceAmount);
                    
                    if ($distanceWithUrgency < $currentBestDistance) {
                        $currentBestDistance = $distanceWithUrgency;
                        $bestScenario = [
                            'product' => $standardProduct,
                            'pages' => $pages,
                            'total' => $totalWithUrgency,
                            'is_urgent' => true,
                            'base_price' => $standardPrice
                        ];
                    }
                }
                
                if ($bestScenario && $currentBestDistance < $bestDistance) {
                    $bestMatch = [[$bestScenario]];
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
    
        $selectedProducts = [];
        foreach ($bestMatch as $item) {
            $product = (object) $item['product'];
            
            $productName = strtolower(trim($product->name));
            $isWordBased = !($certifiedProduct && $productName === strtolower(trim($certifiedProduct['name'])));
            
            if ($isWordBased && $item['pages'] < 250) {
                continue;
            }
    
            $product->unit_price = floatval($item['base_price']);
            $product->urgent_amount = $urgentAmount;
            $product->is_urgent = $item['is_urgent'];
            $product->pages = $item['pages'];
    
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
    
            $product->line_total = $product->unit_price * $product->pages;
            if ($product->is_urgent) {
                $product->line_total += $product->urgent_amount * $product->pages;
            }
    
            if ($certifiedProduct && $productName === strtolower(trim($certifiedProduct['name']))) {
                $product->unit_type = 'pages';
                $product->product_url = $site->certified_translation_url ?? $site->site_link;
            } else {
                $product->unit_type = 'words';
                $product->product_url = $site->standard_translation_url ?? $site->site_link;
            }
    
            $selectedProducts[] = $product;
        }
    
        session()->forget('ready_products');
        session()->put('ready_products', collect($selectedProducts)->map(function ($product) {
            return [
                'id' => $product->id,
                'unit_price' => $product->unit_price,
                'pages' => $product->pages,
                'is_urgent' => $product->is_urgent,
                'urgent_amount' => $product->urgent_amount,
                'unit_type' => $product->unit_type,
                'product_url' => $product->product_url,
            ];
        })->toArray());
    
        $finalTotal = collect($selectedProducts)->sum('line_total');
    
        session(['current_amount' => $finalTotal]);
    
        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $selectedProducts,
            'site' => $site,
            'total' => $finalTotal
        ])->render();
    
        return response()->json([
            'tableRows' => $tableRows,
            'total' => $finalTotal
        ]);
    }


    public function updateProduct(Request $request)
    {
        $productId = $request->get('product_id');
        $pages = intval($request->get('pages'));
        $siteId = $request->get('site_id');

        if ($pages <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Pages must be greater than zero'
            ], 400);
        }

        $readyProducts = session('ready_products', []);
        foreach ($readyProducts as &$product) {
            if ($product['id'] == $productId) {
                $product['pages'] = $pages;
                break;
            }
        }

        session()->put('ready_products', $readyProducts);

        $totalAmount = 0;
        foreach ($readyProducts as $product) {
            $totalAmount += $product['unit_price'] * ($product['pages'] ?? 1);
        }

        session(['current_amount' => $totalAmount]);

        return response()->json([
            'success' => true,
            'total' => $totalAmount
        ]);
    }



    public function removeProduct(Request $request)
    {
        $productId = $request->get('product_id');
        $site_id = $request->get('site_id');
        $site = Website::findOrFail($site_id);
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
                'total' => 0,
                'currency' => null
            ]);
        }

        $consumerKey = $site->consumer_key;
        $consumerSecret = $site->consumer_secret;
        $siteUrl = $site->site_link;
        $auth = base64_encode($consumerKey . ':' . $consumerSecret);

        $productIds = collect($updatedProducts)->pluck('id')->all();
        $selectedProducts = [];

        foreach ($productIds as $id) {
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $auth,
                'Content-Type' => 'application/json',
                'User-Agent' => 'LaravelApp/1.0'
            ])->get("{$siteUrl}/wp-json/wc/v3/products/{$id}");

            if ($response->failed()) continue;

            $apiProduct = (object) $response->json();
            $sessionProduct = collect($updatedProducts)->firstWhere('id', $id);

            $apiProduct->unit_price = floatval($sessionProduct['unit_price']);
            $apiProduct->pages = intval($sessionProduct['pages']);
            $apiProduct->urgent_amount = floatval($sessionProduct['urgent_amount'] ?? $site->urgency_amount);
            $apiProduct->is_urgent = $sessionProduct['is_urgent'] ?? false;
            $apiProduct->line_total = $apiProduct->pages * $apiProduct->unit_price;

            if ($apiProduct->is_urgent) {
                $apiProduct->line_total += $apiProduct->urgent_amount * $apiProduct->pages;
            }

            $apiProduct->can_edit_price = 1;
            $apiProduct->remaining_days = 0;
            $apiProduct->unit_type = $sessionProduct['unit_type'] ?? 'words';

            $selectedProducts[] = $apiProduct;
        }

        $finalTotal = collect($selectedProducts)->sum('line_total');
        session(['current_amount' => $finalTotal]);

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $selectedProducts,
            'site' => $site,
            'total' => $finalTotal
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total' => $finalTotal
        ]);
    }


    public function clearProducts(Request $request)
    {
        // Forget the session data for products and current amount
        session()->forget('ready_products');
        session()->forget('current_amount');

        return response()->json([
            'success' => true,
            'message' => 'Randomized products filter has been cleared.', // Feedback for frontend
            'tableRows' => '', // Empty table content
            'currency' => null, // Reset currency (optional)
            'total' => 0 // Reset total
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
        $invoice_data['model_type']       = $site->businessModel->model_type;
        $invoice_data['site_id']          = $site->id;
        $invoice_data['currency']         = site_currency();
    
        $productsInput = $request->input('products', []);
        $productIds = array_keys($productsInput);
    
        $auth = base64_encode($site->consumer_key . ':' . $site->consumer_secret);
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
    
        $certifiedProduct = collect($productsInput)->first(function ($product) {
            return strtolower(trim($product['name'])) === 'certified translation';
        });
    
        $apiProducts = $apiProducts->map(function ($product) use ($productsInput, $certifiedProduct) {
            if (!isset($productsInput[$product->id])) return $product;
            $input = $productsInput[$product->id];
            $product->name          = $input['name'] ?? 'Unknown';
            $product->unit_price    = (float) ($input['price'] ?? $product->price ?? 0);
            $product->line_total    = (float) ($input['line_total'] ?? 0);
            $product->pages         = (int) ($input['pages'] ?? 1);
            $product->is_urgent     = isset($input['is_urgent']) ? 1 : 0;
            $product->urgent_amount = (float) ($input['urgent_amount'] ?? 0);
            $product->from_language = $input['from_language'] ?? null;
            $product->to_language   = $input['to_language'] ?? null;
            $product->selected      = isset($input['selected']) ? 1 : 0;
            $product->unit_type     = ($certifiedProduct && strtolower(trim($product->name)) === strtolower(trim($certifiedProduct['name'])))
                                    ? 'Pages'
                                    : 'Words';
            return $product;
        });
    
        $languages = site_languages()->pluck('name', 'id');
        $apiProducts = $apiProducts->transform(function ($product) use ($languages) {
            $product->from_language = $languages[$product->from_language] ?? $product->from_language;
            $product->to_language   = $languages[$product->to_language] ?? $product->to_language;
            return $product;
        });
    
        $invoice_data['products']    = $apiProducts;
        $invoice_data['product_ids'] = $productIds;
    
        $modelType     = strtolower($site->businessModel->model_type);
        $siteIdInWords = numberToWords($site->id);
        $viewPath      = "websites.{$modelType}.{$siteIdInWords}";
    
        if (!empty($productsInput)) {
            $this->updateProductPrice($productsInput);
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


    protected function updateProductPrice($productDataArray)
    {
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
        $auth = base64_encode($site->consumer_key . ':' . $site->consumer_secret);
        $siteUrl = rtrim($site->site_link, '/');

        foreach ($productDataArray as $item) {
            $data = is_string($item) ? json_decode($item, true) : $item;

            if (!empty($data['id']) && isset($data['price'])) {
                $product_id = intval($data['id']);
                $new_price = floatval($data['price']);

                $response = Http::withHeaders([
                    'Authorization' => 'Basic ' . $auth,
                    'Content-Type' => 'application/json',
                    'User-Agent' => 'LaravelApp/1.0'
                ])->get("{$siteUrl}/wp-json/wc/v3/products/{$product_id}");

                if (!$response->successful()) {
                    Log::error("Failed to fetch product ID {$product_id}: " . $response->body());
                    continue;
                }

                $product = (object) $response->json();
                $current_price = floatval($product->price);

                if ($current_price == $new_price) {
                    Log::info("No price change for product ID {$product_id}. Current price: {$current_price}");
                    continue;
                }

                // Check price history
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

                // Update price on WooCommerce
                $updateResponse = Http::withHeaders([
                    'Authorization' => 'Basic ' . $auth,
                    'Content-Type' => 'application/json',
                    'User-Agent' => 'LaravelApp/1.0'
                ])->put("{$siteUrl}/wp-json/wc/v3/products/{$product_id}", [
                    'regular_price' => strval($new_price)
                ]);

                if ($updateResponse->successful()) {
                    Log::info("Updated price for product ID {$product_id} from {$current_price} to {$new_price}");

                    // Save price history if needed
                    if ($shouldUpdateHistory) {
                        ProductPriceHistory::create([
                            'site_id' => $site_id,
                            'product_id' => $product_id,
                            'unit_price' => $new_price,
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

