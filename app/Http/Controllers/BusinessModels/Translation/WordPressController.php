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

        $certifiedPrice = $certifiedProduct['price'] ?? null;
        $standardPrice = $standardProduct['price'] ?? null;

        $certifiedPrice = $certifiedPrice !== null ? floatval($certifiedPrice) : null;
        $standardPrice = $standardPrice !== null ? floatval($standardPrice) : null;

        $bestMatch = null;
        $bestTotal = PHP_FLOAT_MAX;
        $bestDistance = PHP_FLOAT_MAX;

        if ($filterType === 'certified' && $certifiedProduct && $certifiedPrice) {
            $pages = ceil($invoiceAmount / $certifiedPrice);
            $total = $pages * $certifiedPrice;
            $bestMatch = [[
                'product' => $certifiedProduct,
                'pages' => $pages,
                'total' => $total
            ]];
        } elseif ($filterType === 'standard' && $standardProduct && $standardPrice) {
            $pages = ceil($invoiceAmount / $standardPrice);
            $total = $pages * $standardPrice;
            $bestMatch = [[
                'product' => $standardProduct,
                'pages' => $pages,
                'total' => $total
            ]];
        } elseif ($certifiedProduct && $standardProduct && $certifiedPrice && $standardPrice) {

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
                $certAmount = $invoiceAmount * $ratio['cert_ratio'];
                $stdAmount = $invoiceAmount * $ratio['std_ratio'];

                $certPages = max(1, ceil($certAmount / $certifiedPrice));
                $stdPages = max(1, ceil($stdAmount / $standardPrice));

                $certTotal = $certPages * $certifiedPrice;
                $stdTotal = $stdPages * $standardPrice;
                $total = $certTotal + $stdTotal;

                if ($total >= $invoiceAmount) {
                    $distance = $total - $invoiceAmount;
                    $balanceScore = abs(($certTotal / $total) - 0.5);

                    if ($distance < $bestDistance || ($distance === $bestDistance && $balanceScore < 0.3)) {
                        $bestMatch = [
                            [
                                'product' => $certifiedProduct,
                                'pages' => $certPages,
                                'total' => $certTotal
                            ],
                            [
                                'product' => $standardProduct,
                                'pages' => $stdPages,
                                'total' => $stdTotal
                            ]
                        ];
                        $bestDistance = $distance;
                        $bestTotal = $total;
                    }
                }
            }
        }

        if (!$bestMatch && $certifiedProduct && $certifiedPrice) {
            $pages = ceil($invoiceAmount / $certifiedPrice);
            $total = $pages * $certifiedPrice;

            $bestMatch = [[
                'product' => $certifiedProduct,
                'pages' => $pages,
                'total' => $total
            ]];
        }

        if (!$bestMatch && $standardProduct && $standardPrice) {
            $pages = ceil($invoiceAmount / $standardPrice);
            $total = $pages * $standardPrice;

            $bestMatch = [[
                'product' => $standardProduct,
                'pages' => $pages,
                'total' => $total
            ]];
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
            $pages = $item['pages'];

            if ($pages <= 0) continue;

            $product->unit_price = floatval($product->price);
            $product->pages = $pages;
            $product->urgent_amount = 99.75;
            $product->is_urgent = rand(1, 100) <= 10;
            $product->line_total = $product->unit_price * $product->pages;

            if ($product->is_urgent) {
                $product->line_total += $product->urgent_amount;
            }

            $product->can_edit_price = 1;
            $product->remaining_days = 0;
            $productName = strtolower(trim($product->name));

            if ($certifiedProduct && $productName === strtolower(trim($certifiedProduct['name']))) {
                $product->unit_type = 'pages';
            } else {
                $product->unit_type = 'words';
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
    
        $certifiedProduct = collect($updatedProducts)->first(function ($product) {
            return strtolower(trim($product['name'])) === 'certified translation';
        });
    
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
            $apiProduct->urgent_amount = floatval($sessionProduct['urgent_amount'] ?? 99.75);
            $apiProduct->is_urgent = $sessionProduct['is_urgent'] ?? false;
            $apiProduct->line_total = $apiProduct->pages * $apiProduct->unit_price;
    
            if ($apiProduct->is_urgent) {
                $apiProduct->line_total += $apiProduct->urgent_amount;
            }
    
            $apiProduct->can_edit_price = 1;
            $apiProduct->remaining_days = 0;
    
            $productName = strtolower(trim($apiProduct->name));
            if ($certifiedProduct && $productName === strtolower(trim($certifiedProduct['name']))) {
                $apiProduct->unit_type = 'pages';
            } else {
                $apiProduct->unit_type = 'words';
            }
    
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
            $site_name       = $request->input('remote_site_name') ?? '';
            $company_name    = $request->input('remote_company_name') ?? '';
            $company_email   = $request->input('remote_company_email') ?? '';
            $company_mobile  = $request->input('remote_company_mobile') ?? '';
            $company_address = $request->input('remote_company_address') ?? '';
            $remote_database = DB::connection($this->connectionType)->table('general_settings')->orderByDesc('updated_at')->first();
    
            if ($remote_database) {
                DB::connection($this->connectionType)->table('general_settings')->where('id', $remote_database->id)
                    ->update([
                        'site_name'    => $site_name,
                        'email'        => $company_email,
                        'phone'        => $company_mobile,
                        'address'      => $company_address,
                        'updated_at'   => now(),
                    ]);
            }
        } else {
            $site_name       = $request->input('local_site_name') ?? '';
            $company_name    = $request->input('local_company_name') ?? '';
            $company_email   = $request->input('local_company_email') ?? '';
            $company_mobile  = $request->input('local_company_mobile') ?? '';
            $company_address = $request->input('local_company_address') ?? '';
    
            $site->site_name       = $site_name;
            $site->company_name    = $company_name;
            $site->company_email   = $company_email;
            $site->company_mobile  = $company_mobile;
            $site->company_address = $company_address;
            $site->save();
        }
    
        $invoice_data = [
            'site' => $site,
            'site_name' => $site_name,
            'invoice_number' => $request->input('invoice_number'),
            'invoice_date' => $request->input('invoice_date'),
            'customer_name' => $request->input('customer_name'),
            'customer_mobile' => $request->input('customer_mobile'),
            'customer_email' => $request->input('customer_email'),
            'company_email' => $request->input('company_email'),
            'invoice_amount' => $request->input('invoice_amount'),
            'current_amount' => $request->input('current_amount'),
            'discount_amount' => $request->input('discount_amount'),
            'company_name' => $company_name,
            'company_email' => $company_email,
            'company_mobile' => $company_mobile,
            'company_address' => $company_address,
            'invoice_header_image' => base64EncodeImage($site->invoice_header_image),
            'invoice_footer_image' => base64EncodeImage($site->invoice_footer_image),
            'invoice_signature' => base64EncodeImage($site->invoice_signature),
            'company_logo' => base64EncodeImage($site->company_logo),
            'invoice_image1' => base64EncodeImage($site->invoice_image1),
            'invoice_image2' => base64EncodeImage($site->invoice_image2),
            'invoice_image3' => base64EncodeImage($site->invoice_image3),
            'invoice_image4' => base64EncodeImage($site->invoice_image4),
            'invoice_image5' => base64EncodeImage($site->invoice_image5),
            'invoice_image6' => base64EncodeImage($site->invoice_image6),
            'invoice_image7' => base64EncodeImage($site->invoice_image7),
            'invoice_image8' => base64EncodeImage($site->invoice_image8),
            'invoice_image9' => base64EncodeImage($site->invoice_image9),
            'invoice_template' => $site->invoice_template,
            'model_type' => $site->businessModel->model_type,
            'site_id' => $site->id,
            'currency' => site_currency(),
        ];
    
        $productsInput = $request->input('products', []);
        dd( $productsInput);
        $productIds = array_keys($productsInput);
    
        $auth = base64_encode($site->consumer_key . ':' . $site->consumer_secret);
        $siteUrl = rtrim($site->site_link, '/');
    
        $apiProducts = collect();
        foreach ($productIds as $id) {
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $auth,
                'Content-Type' => 'application/json',
                'User-Agent' => 'LaravelApp/1.0'
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
    
            $product->name = $input['name'] ?? 'Unknown';
            $product->unit_price = (float) ($input['price'] ?? $product->price ?? 0);
            $product->line_total = (float) ($input['line_total'] ?? 0);
            $product->pages = (int) ($input['pages'] ?? 1);
            $product->is_urgent = isset($input['is_urgent']) ? 1 : 0;
            $product->urgent_amount = (float) ($input['urgent_amount'] ?? 0);
            $product->from_language = $input['from_language'] ?? null;
            $product->to_language = $input['to_language'] ?? null;
            $product->selected = isset($input['selected']) ? 1 : 0;
    
            if ($certifiedProduct && strtolower(trim($product->name)) === strtolower(trim($certifiedProduct['name']))) {
                $product->unit_type = 'Pages';
            } else {
                $product->unit_type = 'Words';
            }
    
            return $product;
        });
    
        $languages = site_languages()->pluck('name', 'id');
        $apiProducts = $apiProducts->transform(function ($product) use ($languages) {
            $product->from_language = $languages[$product->from_language] ?? $product->from_language;
            $product->to_language = $languages[$product->to_language] ?? $product->to_language;
            return $product;
        });
        $invoice_data['products'] = $apiProducts;
        $invoice_data['product_ids'] = $productIds;
    
        $modelType = strtolower($site->businessModel->model_type);
        $siteIdInWords = numberToWords($site->id);
        $viewPath = "websites.{$modelType}.{$siteIdInWords}";
    
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
    
                $updateResponse = Http::withHeaders([
                    'Authorization' => 'Basic ' . $auth,
                    'Content-Type' => 'application/json',
                    'User-Agent' => 'LaravelApp/1.0'
                ])->put("{$siteUrl}/wp-json/wc/v3/products/{$product_id}", [
                    'regular_price' => strval($new_price)
                ]);
    
                if ($updateResponse->successful()) {
                    Log::info("Updated price for product ID {$product_id} from {$current_price} to {$new_price}");
                } else {
                    Log::error("Failed to update price for product ID {$product_id}: " . $updateResponse->body());
                }
            }
        }
    }
    
}

