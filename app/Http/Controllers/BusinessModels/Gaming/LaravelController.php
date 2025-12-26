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

class LaravelController extends Controller
{
    private $productTable;
    private $connectionType;
    private $bundleTable;

    public function __construct()
    {
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
    
        if ($site_id == 233) {
            $priceFrom = 10;
            $priceTo = 100;
        }
    
        $productCount = intval($request->get('product_count'));
        $searchQuery = $request->get('search_query');
    
        $minTotal = $invoiceAmount;
        $maxTotal = $invoiceAmount * 1.05;
    
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);
    
        $productsQuery = DB::connection($this->connectionType)
            ->table('products as p')
            ->join('game_sever_based_cost as c', 'p.id', '=', 'c.game_id')
            ->where('p.published', 1);
    
        if ($searchQuery) {
            $productsQuery->where(function($query) use ($searchQuery) {
                $query->where('p.name', 'like', '%' . $searchQuery . '%')
                    ->orWhere('p.game_currency', 'like', '%' . $searchQuery . '%')
                    ->orWhere('p.game_platform', 'like', '%' . $searchQuery . '%')
                    ->orWhere('p.game_server_region', 'like', '%' . $searchQuery . '%');
            });
        }
    
        $products = $productsQuery->select(
            'p.id',
            'p.name',
            'p.slug',
            'p.game_currency',
            'p.game_platform',
            'p.game_server_region',
            'p.game_need_to_capture',
            'c.id as bundle_id',
            'c.game_id',
            'c.costs',
        )->get();
    
        $allProducts = collect();
        $alreadyAdded = [];
    
        foreach ($products as $product) {
            $costs = json_decode($product->costs, true);
    
            if (isset($costs['bundles']) && is_array($costs['bundles'])) {
                foreach ($costs['bundles'] as $bundleAmount => $unitPrice) {
                    $unitPrice = floatval($unitPrice);
    
                    $uniqueKey = $product->id . '-' . $bundleAmount;
    
                    if (isset($alreadyAdded[$uniqueKey])) {
                        continue;
                    }
    
                    if ($priceFrom && $priceTo) {
                        if ($unitPrice < $priceFrom || $unitPrice > $priceTo) {
                            continue;
                        }
                    }
    
                    $alreadyAdded[$uniqueKey] = true;
    
                    $allProducts->push((object)[
                        'id' => $product->id,
                        'bundle_id' => $product->bundle_id,
                        'name' => $product->name,
                        'unit_price' => $unitPrice,
                        'slug' => $product->slug ?? Str::slug($product->name),
                        'source' => 'Random',
                        'can_edit_price' => 0,
                        'remaining_days' => 0,
                        'game_currency' => $product->game_currency,
                        'game_currency_amount' => $bundleAmount,
                        'game_platform' => $product->game_platform,
                        'game_region' => $product->game_server_region,
                        'game_need_to_capture' => $product->game_need_to_capture
                    ]);
                }
            }
        }
    
        if ($searchQuery && !$request->has('randomize')) {
            $results = $allProducts->sortBy('unit_price');
    
            if ($productCount > 0) {
                $results = $results->take($productCount);
            } else {
                $results = $results->take(60);
            }
    
            $totalPrice = $results->sum('unit_price');
            session(['current_amount' => $totalPrice]);
    
            $currency = DB::connection($this->connectionType)
                ->table('currencies')
                ->where('status', 1)
                ->first();
    
            $modelType = $site->businessModel->model_type;
    
            $tableRows = view("invoice.{$modelType}.random_product_rows", [
                'products' => $results,
                'currency' => $currency,
                'site' => $site
            ])->render();
    
            return response()->json([
                'tableRows' => $tableRows,
                'total' => $totalPrice,
                'currency' => $currency,
                'is_random' => false
            ]);
        }
    
        $allProducts = $allProducts->sortByDesc('unit_price')->shuffle()->take(60);
    
        $bestMatch = null;
        $bestTotal = 0;
    
        for ($i = 0; $i < 10; $i++) {
            $shuffled = $allProducts->shuffle();
            $selected = [];
            $currentTotal = 0;
    
            foreach ($shuffled as $product) {
                $price = floatval($product->unit_price);
    
                if (($currentTotal + $price) <= $maxTotal) {
                    $selected[] = $product;
                    $currentTotal += $price;
    
                    if ($productCount > 0) {
                        if (count($selected) == $productCount && $currentTotal >= $minTotal) {
                            $bestMatch = $selected;
                            $bestTotal = $currentTotal;
                            break 2;
                        }
                    } else {
                        if ($currentTotal >= $minTotal && $currentTotal <= $maxTotal) {
                            $bestMatch = $selected;
                            $bestTotal = $currentTotal;
                            break 2;
                        }
                    }
                }
            }
        }
    
        if (!$bestMatch) {
            session()->forget('selected_games');
            session()->forget('current_amount');
    
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No matching combination found, try again please'
            ]);
        }
    
        session()->forget('selected_games');
        $selected_games = [];
    
        foreach ($bestMatch as $game) {
            $selected_games[] = [
                'id' => $game->id,
                'unit_price' => $game->unit_price,
                'game_currency_amount' => $game->game_currency_amount,
                'game_currency' => $game->game_currency,
                'bundle' => 'Random',
            ];
        }
    
        session(['selected_games' => $selected_games]);
    
        $currency = DB::connection($this->connectionType)
            ->table('currencies')
            ->where('status', 1)
            ->first();
    
        $modelType = $site->businessModel->model_type;
        session(['current_amount' => $bestTotal]);
    
        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $bestMatch,
            'currency' => $currency,
            'site' => $site
        ])->render();
    
        return response()->json([
            'tableRows' => $tableRows,
            'total' => $bestTotal,
            'currency' => $currency,
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

        // Remove matching bundle (id + unit_price)
        $updatedGames = array_filter($selectedGames, function ($game) use ($id, $unitPrice) {
            return !($game['id'] == $id && floatval($game['unit_price']) == floatval($unitPrice));
        });

        $updatedGames = array_values($updatedGames);

        // Update session
        session(['selected_games' => $updatedGames]);
        //dd($updatedGames);

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
        DynamicDatabaseService::connect($site);

        $currency = DB::connection($this->connectionType)
            ->table('currencies')->where('status', 1)->first();

        $modelType = $site->businessModel->model_type;

        $productIds = array_column($updatedGames, 'id');

        $finalProducts = collect();

        foreach ($updatedGames as $sessionGame) {
            $product = DB::connection($this->connectionType)
                ->table('products as p')
                ->join('game_sever_based_cost as c', 'p.id', '=', 'c.game_id')
                ->where('p.id', $sessionGame['id'])
                ->select(
                    'p.id',
                    'p.name',
                    'p.slug',
                    'p.game_currency',
                    'p.game_platform',
                    'p.game_server_region',
                    'p.game_need_to_capture',
                    'c.costs',
                    'c.id as bundle_id',
                )
                ->first();

                //dd($product);
            if ($product) {
                $finalProducts->push((object)[
                    'id'             => $product->id,
                    'name'           => $product->name,
                    'bundle_id'      => $product->bundle_id,
                    'unit_price'     => floatval($sessionGame['unit_price']),
                    'slug' => $product->slug ?? Str::slug($product->name),
                    'source'         => 'Random',
                    'can_edit_price' => 0,
                    'remaining_days' => 0,
                    'game_currency'  => $product->game_currency,
                    'game_currency_amount' => $sessionGame['game_currency_amount'] ?? '',
                    'game_platform'  => $product->game_platform,
                    'game_region'    => $product->game_server_region,
                    'game_need_to_capture' => $product->game_need_to_capture
                ]);
            }
        }
        $bestTotal = $finalProducts->sum('unit_price');
        session(['current_amount' => $bestTotal]);
        //dd($finalProducts);

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $finalProducts,
            'currency' => $currency,
            'site'     => $site
        ])->render();

        $total = $finalProducts->sum('unit_price');

        return response()->json([
            'tableRows' => $tableRows,
            'total'     => $total,
            'currency'  => $currency
        ]);
    }


    public function filterProducts(Request $request)
    {
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $hasKeyword = $request->filled('keyword');
        $costSubquery = DB::connection($this->connectionType)
        ->table('game_sever_based_cost')
        ->select(
            'game_id',
            DB::raw('MAX(COALESCE(bundle_first_amount, avg_amount)) as bundle_first_amount')
        )
        ->groupBy('game_id');

        $products = DB::connection($this->connectionType)
            ->table('products as p')
            ->joinSub($costSubquery, 'c', function ($join) {
                $join->on('p.id', '=', 'c.game_id');
            })
            ->where('p.published', 1)
            ->when($hasKeyword, function ($query) use ($request) {
                $query->where('p.name', 'like', '%' . strtolower($request->keyword) . '%');
            })
            ->select(
                'p.id',
                'p.name',
                'p.slug',
                'p.game_currency',
                'p.game_platform',
                'p.game_server_region',
                'p.game_need_to_capture',
                'c.bundle_first_amount'
            )
            ->distinct()
            ->get();

        if ($products->isEmpty()) {
            return response()->json([
                'tableRows' => '<tr><td colspan="7" class="text-center text-muted">No results found. Try randomizing or use a different keyword.</td></tr>'
            ]);
        }

        $currency = DB::connection($this->connectionType)
            ->table('currencies')
            ->where('status', 1)
            ->first();

        $modelType = $site->businessModel->model_type;
        //dd(session('current_amount'));
        $tableRows = view("invoice.{$modelType}.add_product_rows", [
            'products' => $products,
            'currency' => $currency,
            'site'     => $site,
            'current_amount' => session('current_amount'),
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'currency'  => $currency,
            'is_random' => false
        ]);
    }

    public function addProducts(Request $request)
    {
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $selected = $request->input('selected_games');
        $existing = session('selected_games', []);

        // Normalize existing into an assoc array
        $existingAssoc = [];
        $seenKeys = [];

        // Merge existing session games with the new selected games
        foreach ($existing as $item) {
            $game_id = $item['id'];
            $bundle_amount = (float) $item['game_currency_amount'];
            $key = "{$game_id}-{$bundle_amount}-custom";

            // Only add unique keys from existing session data
            if (!in_array($key, $seenKeys)) {
                $existingAssoc[] = [
                    'id'                   => (int)$game_id,
                    'unit_price'           => (float) $item['unit_price'],
                    'game_currency_amount' => (string)$bundle_amount,
                    'bundle'               => 'custom',
                ];
                $seenKeys[] = $key;
            }
        }

        // Add the selected games to existing session data if they are not already added
        foreach ($selected as $gameData) {
            $game_id = $gameData['product_id'] ?? $gameData['id'];
            $bundle_amount = (float) $gameData['game_currency_amount'];

            // Create a unique key for the selected game based on game_id and bundle_amount
            $key = "{$game_id}-{$bundle_amount}-custom";

            // Only add the game if it's not already in the session data
            if (!in_array($key, $seenKeys)) {
                $existingAssoc[] = [
                    'id'                   => (int)$game_id,
                    'unit_price'           => (float) $gameData['unit_price'],
                    'game_currency_amount' => (string)$bundle_amount,
                    'bundle'               => 'custom',
                ];
                $seenKeys[] = $key;
            }
        }

        // Update session with merged data
        session(['selected_games' => $existingAssoc]);

        // Pass the updated games to getGameDetails function
        $finalProducts = $this->getGameDetails($existingAssoc);
        $bestTotal = $finalProducts->sum('unit_price');
        session(['current_amount' => $bestTotal]);
        //dd($finalProducts);


        $modelType = $site->businessModel->model_type;

        // Generate table row HTML
        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $finalProducts,
            'site'     => $site,
        ])->render();

        return response()->json([
            'success'   => true,
            'tableRows' => $tableRows,
            'total'     => $finalProducts->sum('unit_price'),
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
            $processedProducts[] = $productData;
        }

        $invoice_data['products'] = $processedProducts;
        $modelType = strtolower($site->businessModel->model_type);
        $siteWords = numberToWords($site->id);
        $viewPath  = "websites.{$modelType}.{$siteWords}";

        $this->updateProductPrice($products);

        InvoiceController::createInvoiceHistory($invoice_data, $processedProducts);
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


    protected function updateProductPrice($productDataArray)
    {
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);

        \Log::info("Starting updateProductPrice with site_id: {$site_id}");
        \Log::info("Product Data Array:", ['count' => count($productDataArray)]);

        $userPrices = [];
        $dbPrices = [];
        $updatedProducts = [];
        $blockedProducts = [];
        $errors = [];
        $debugData = []; // Add a debug array to collect all relevant information

        foreach ($productDataArray as $index => $data) {
            $debugData[$index] = [
                'input' => $data,
                'processing_steps' => []
            ];

            \Log::info("Processing product data: ", ['index' => $index, 'data' => $data]);

            if (
                !empty($data['game_currency_amount']) &&
                isset($data['bundle_id']) &&
                isset($data['unit_price'])
            ) {
                $targetAmount = $data['game_currency_amount'];
                $bundle_id = floatval($data['bundle_id']) ?? rand(100000, 999999);
                $unit_price = floatval($data['unit_price']);

                $debugData[$index]['processing_steps'][] = [
                    'step' => 'initial_params',
                    'targetAmount' => $targetAmount,
                    'bundle_id' => $bundle_id,
                    'unit_price' => $unit_price
                ];

                \Log::info("Product parameters:", [
                    'targetAmount' => $targetAmount,
                    'bundle_id' => $bundle_id,
                    'unit_price' => $unit_price
                ]);

                // Establish dynamic DB connection
                try {
                    DynamicDatabaseService::connect($site);
                    $debugData[$index]['processing_steps'][] = [
                        'step' => 'db_connection',
                        'status' => 'success',
                        'connection_type' => $this->connectionType
                    ];
                    \Log::info("DB Connection established for: {$this->connectionType}");
                } catch (\Exception $e) {
                    $debugData[$index]['processing_steps'][] = [
                        'step' => 'db_connection',
                        'status' => 'error',
                        'message' => $e->getMessage()
                    ];
                    \Log::error("DB Connection failed: " . $e->getMessage());
                    $errors[] = "Database connection failed: " . $e->getMessage();
                    continue;
                }

                // Fetch row from game_sever_based_cost using bundle_id
                try {
                    $costData = DB::connection($this->connectionType)
                        ->table('game_sever_based_cost')
                        ->where('id', $bundle_id)
                        ->first();

                    if (!$costData) {
                        $debugData[$index]['processing_steps'][] = [
                            'step' => 'fetch_cost_data',
                            'status' => 'error',
                            'message' => "Bundle ID {$bundle_id} not found"
                        ];
                        \Log::warning("Bundle ID {$bundle_id} not found");
                        $errors[] = "Bundle ID {$bundle_id} not found";
                        continue;
                    }

                    $debugData[$index]['processing_steps'][] = [
                        'step' => 'fetch_cost_data',
                        'status' => 'success',
                        'cost_data' => $costData
                    ];
                    \Log::info("Cost data found for bundle ID {$bundle_id}");

                } catch (\Exception $e) {
                    $debugData[$index]['processing_steps'][] = [
                        'step' => 'fetch_cost_data',
                        'status' => 'error',
                        'message' => $e->getMessage()
                    ];
                    \Log::error("Error fetching cost data: " . $e->getMessage());
                    $errors[] = "Error fetching cost data: " . $e->getMessage();
                    continue;
                }

                // Parse JSON costs
                try {
                    $costs = json_decode($costData->costs, true);
                    if (!isset($costs['bundles']) || !is_array($costs['bundles'])) {
                        $debugData[$index]['processing_steps'][] = [
                            'step' => 'parse_costs',
                            'status' => 'error',
                            'message' => "Invalid bundle structure for ID {$bundle_id}"
                        ];
                        \Log::warning("Invalid bundle structure for ID {$bundle_id}");
                        $errors[] = "Invalid bundle structure for ID {$bundle_id}";
                        continue;
                    }

                    $debugData[$index]['processing_steps'][] = [
                        'step' => 'parse_costs',
                        'status' => 'success',
                        'bundles_count' => count($costs['bundles']),
                        'bundles_keys' => array_keys($costs['bundles'])
                    ];
                    \Log::info("Costs parsed successfully for bundle ID {$bundle_id}", [
                        'bundles_count' => count($costs['bundles']),
                        'bundles_keys' => array_keys($costs['bundles'])
                    ]);

                } catch (\Exception $e) {
                    $debugData[$index]['processing_steps'][] = [
                        'step' => 'parse_costs',
                        'status' => 'error',
                        'message' => $e->getMessage()
                    ];
                    \Log::error("Error parsing costs: " . $e->getMessage());
                    $errors[] = "Error parsing costs: " . $e->getMessage();
                    continue;
                }

                // Find currency key
                $currencyKey = null;
                $keyFound = false;

                foreach ($costs['bundles'] as $key => $value) {
                    \Log::info("Comparing keys: ", ['json_key' => $key, 'target' => $targetAmount]);

                    if (strval($key) === strval($targetAmount)) {
                        $currencyKey = $key;
                        $keyFound = true;
                        break;
                    }
                }

                if (!$keyFound) {
                    $debugData[$index]['processing_steps'][] = [
                        'step' => 'find_currency_key',
                        'status' => 'error',
                        'target' => $targetAmount,
                        'available_keys' => array_keys($costs['bundles'])
                    ];
                    \Log::warning("No matching bundle key found for '{$targetAmount}' in bundle ID: {$bundle_id}", [
                        'available_keys' => array_keys($costs['bundles'])
                    ]);
                    $errors[] = "No matching bundle key found for '{$targetAmount}' in bundle ID: {$bundle_id}";
                    continue;
                }

                $debugData[$index]['processing_steps'][] = [
                    'step' => 'find_currency_key',
                    'status' => 'success',
                    'currency_key' => $currencyKey
                ];
                \Log::info("Currency key found: {$currencyKey}");

                $currentPrice = floatval($costs['bundles'][$currencyKey]);
                $dbPrices[$bundle_id] = $currentPrice;
                $userPrices[$bundle_id] = $unit_price;

                $debugData[$index]['processing_steps'][] = [
                    'step' => 'price_check',
                    'current_price' => $currentPrice,
                    'user_price' => $unit_price,
                    'difference' => abs($currentPrice - $unit_price)
                ];
                \Log::info("Price comparison:", [
                    'current_price' => $currentPrice,
                    'user_price' => $unit_price,
                    'difference' => abs($currentPrice - $unit_price)
                ]);

                // Skip if price hasn't changed
                if (abs($currentPrice - $unit_price) < 0.01) {
                    $debugData[$index]['processing_steps'][] = [
                        'step' => 'price_check',
                        'status' => 'skipped',
                        'reason' => 'Price difference too small'
                    ];
                    \Log::info("Skipping update - price difference too small");
                    continue;
                }

                // Check last price update history
                try {
                    $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                        ->where('product_id', $bundle_id)
                        ->where('bundle', (string)$currencyKey)
                        ->orderByDesc('last_price_changed')
                        ->first();

                    $debugData[$index]['processing_steps'][] = [
                        'step' => 'check_history',
                        'status' => 'success',
                        'last_update' => $lastUpdate ? [
                            'id' => $lastUpdate->id,
                            'last_changed' => $lastUpdate->last_price_changed,
                            'days_ago' => Carbon::parse($lastUpdate->last_price_changed)->diffInDays(now())
                        ] : null
                    ];

                    \Log::info("Last update check:", [
                        'found' => $lastUpdate ? true : false,
                        'last_update' => $lastUpdate ? $lastUpdate->toArray() : null
                    ]);

                } catch (\Exception $e) {
                    $debugData[$index]['processing_steps'][] = [
                        'step' => 'check_history',
                        'status' => 'error',
                        'message' => $e->getMessage()
                    ];
                    \Log::error("Error checking price history: " . $e->getMessage());
                    $errors[] = "Error checking price history: " . $e->getMessage();
                    continue;
                }

                // Only update if never updated OR 3+ months old
                if (!$lastUpdate || Carbon::parse($lastUpdate->last_price_changed)->diffInDays(now()) >= 90) {
                    $debugData[$index]['processing_steps'][] = [
                        'step' => 'update_allowed',
                        'status' => 'proceed'
                    ];
                    \Log::info("Update allowed - proceeding with update");

                    // THIS IS THE KEY CHANGE - Update the price in the JSON structure
                    try {
                        $costs['bundles'][$currencyKey] = strval($unit_price);

                        // Update the entire costs JSON in the database
                        $updated = DB::connection($this->connectionType)
                            ->table('game_sever_based_cost')
                            ->where('id', $bundle_id)
                            ->update(['costs' => json_encode($costs)]);

                        $debugData[$index]['processing_steps'][] = [
                            'step' => 'update_db',
                            'status' => $updated ? 'success' : 'error',
                            'rows_affected' => $updated
                        ];

                        \Log::info("Database update result:", [
                            'success' => $updated ? true : false,
                            'rows_affected' => $updated
                        ]);

                        if (!$updated) {
                            $errors[] = "Failed to update bundle ID {$bundle_id} - no rows affected";
                            continue;
                        }
                    } catch (\Exception $e) {
                        $debugData[$index]['processing_steps'][] = [
                            'step' => 'update_db',
                            'status' => 'exception',
                            'message' => $e->getMessage()
                        ];
                        \Log::error("Error updating database: " . $e->getMessage());
                        $errors[] = "Error updating database: " . $e->getMessage();
                        continue;
                    }

                    // Create price history record
                    try {
                        \Log::info("Creating price history with:", [
                            'site_id' => $site_id,
                            'product_id' => $bundle_id,
                            'bundle' => (string)$currencyKey,
                            'unit_price' => $unit_price
                        ]);

                        $historyRecord = ProductPriceHistory::create([
                            'site_id' => $site_id,
                            'product_id' => $bundle_id,
                            'bundle' => (string)$currencyKey,
                            'unit_price' => $unit_price,
                            'last_price_changed' => now(),
                        ]);

                        $debugData[$index]['processing_steps'][] = [
                            'step' => 'create_history',
                            'status' => 'success',
                            'history_id' => $historyRecord->id
                        ];

                        \Log::info("Price history created:", [
                            'id' => $historyRecord->id
                        ]);

                        $updatedProducts[] = [
                            'bundle_id' => $bundle_id,
                            'currency_key' => $currencyKey,
                            'old_price' => $currentPrice,
                            'new_price' => $unit_price
                        ];
                    } catch (\Exception $e) {
                        $debugData[$index]['processing_steps'][] = [
                            'step' => 'create_history',
                            'status' => 'error',
                            'message' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ];
                        \Log::error("Error creating price history: " . $e->getMessage() . "\n" . $e->getTraceAsString());
                        $errors[] = "Error creating price history: " . $e->getMessage();
                        // Don't continue here, we already updated the price in database
                    }
                } else {
                    $daysRemaining = 90 - Carbon::parse($lastUpdate->last_price_changed)->diffInDays(now());

                    $debugData[$index]['processing_steps'][] = [
                        'step' => 'update_blocked',
                        'status' => 'blocked',
                        'days_remaining' => $daysRemaining
                    ];

                    \Log::info("Update blocked - price changed too recently", [
                        'days_remaining' => $daysRemaining
                    ]);

                    $blockedProducts[] = [
                        'bundle_id' => $bundle_id,
                        'currency_key' => $currencyKey,
                        'current_price' => $currentPrice,
                        'requested_price' => $unit_price,
                        'days_remaining' => $daysRemaining
                    ];
                }
            } else {
                $debugData[$index]['processing_steps'][] = [
                    'step' => 'validate_input',
                    'status' => 'error',
                    'missing_fields' => [
                        'game_currency_amount' => empty($data['game_currency_amount']),
                        'bundle_id' => !isset($data['bundle_id']),
                        'unit_price' => !isset($data['unit_price'])
                    ]
                ];
                \Log::warning("Missing required fields in product data", [
                    'index' => $index,
                    'data' => $data
                ]);
            }
        }

        \Log::info("updateProductPrice finished", [
            'updated_count' => count($updatedProducts),
            'blocked_count' => count($blockedProducts),
            'errors_count' => count($errors)
        ]);

        // Save the debug data to a file for inspection
        \Storage::disk('local')->put('price_update_debug_' . now()->format('Y-m-d_H-i-s') . '.json', json_encode($debugData, JSON_PRETTY_PRINT));
        //dd($debugData);
        return [
            'db_prices' => $dbPrices,
            'user_prices' => $userPrices,
            'updated_products' => $updatedProducts,
            'blocked_products' => $blockedProducts,
            'errors' => $errors,
            'debug_data' => $debugData // Include debug data in the response
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
