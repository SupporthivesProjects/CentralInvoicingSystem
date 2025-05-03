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
    $productCount = intval($request->get('product_count')); // Number of products input
    $searchQuery = $request->get('search_query'); // New parameter for search functionality

    $minTotal = $invoiceAmount;
    $maxTotal = $invoiceAmount * 1.05;

    $site = Website::findOrFail($site_id);
    DynamicDatabaseService::connect($site);

    // Start base query
    $productsQuery = DB::connection($this->connectionType)
        ->table('products as p')
        ->join('game_sever_based_cost as c', 'p.id', '=', 'c.game_id')
        ->where('p.published', 1);

    // Apply search if provided
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
                'c.costs'
            )
            ->get();

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
                        'id'                    => $product->id,
                        'name'                  => $product->name,
                        'unit_price'             => $unitPrice,
                        'slug'                  => Str::slug($product->name . '-' . $bundleAmount),
                        'source'                 => 'Random',
                        'can_edit_price'         => 0,
                        'remaining_days'         => 0,
                        'game_currency'          => $product->game_currency,
                        'game_currency_amount'   => $bundleAmount,
                        'game_platform'          => $product->game_platform,
                        'game_region'            => $product->game_server_region,
                        'game_need_to_capture'   => $product->game_need_to_capture
                    ]);
                }
            }
        }

    // If we're in search mode and not randomizing, return the search results directly
    if ($searchQuery && !$request->has('randomize')) {
        $results = $allProducts->sortBy('unit_price');

        // Limit by product count if specified
        if ($productCount > 0) {
            $results = $results->take($productCount);
        } else {
            $results = $results->take(60); // Default limit
        }

        // Get the total price
        $totalPrice = $results->sum('unit_price');

        // Return the search results
        $currency = DB::connection($this->connectionType)
            ->table('currencies')
            ->where('status', 1)
            ->first();

        $modelType = $site->businessModel->model_type;

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $results,
            'currency' => $currency,
            'site'     => $site
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total'     => $totalPrice,
            'currency'  => $currency,
            'is_random' => false
        ]);
    }

    // For random mode or randomize button
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

                // If product_count is provided, check both conditions
                if ($productCount > 0) {
                    if (count($selected) == $productCount && $currentTotal >= $minTotal) {
                        $bestMatch = $selected;
                        $bestTotal = $currentTotal;
                        break 2; // break foreach + for loop both
                    }
                } else {
                    // if no product_count, run as usual
                    if ($currentTotal >= $minTotal && $currentTotal <= $maxTotal) {
                        $bestMatch = $selected;
                        $bestTotal = $currentTotal;
                        break 2;
                    }
                }
            }
        }
    }
    //dd($bestMatch);

    if (!$bestMatch) {
        return response()->json([
            'tableRows' => '',
            'total'     => 0,
            'message'   => 'No matching combination found, try again please'
        ]);
    }

    session()->forget('selected_games');
    $selected_games = [];
    //dd($bestMatch);

    foreach ($bestMatch as $game) {
        $selected_games[] = [
            'id' => $game->id,
            'unit_price' => $game->unit_price,
            'game_currency_amount' => $game->game_currency_amount,
            'game_currency' => $game->game_currency,
            'bundle' => 'defined',
        ];
    }

    session(['selected_games' => $selected_games]);
    //dd($in_session);

    $currency = DB::connection($this->connectionType)
        ->table('currencies')
        ->where('status', 1)
        ->first();

    $modelType = $site->businessModel->model_type;

    $tableRows = view("invoice.{$modelType}.random_product_rows", [
        'products' => $bestMatch,
        'currency' => $currency,
        'site'     => $site
    ])->render();

    return response()->json([
        'tableRows' => $tableRows,
        'total'     => $bestTotal,
        'currency'  => $currency,
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

    if (empty($updatedGames)) {
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
                'c.costs'
            )
            ->first();

        if ($product) {
            $finalProducts->push((object)[
                'id'             => $product->id,
                'name'           => $product->name,
                'unit_price'     => floatval($sessionGame['unit_price']),
                'slug'           => Str::slug($product->name . '-' . ($sessionGame['game_currency_amount'] ?? '')),
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
    $hasPriceRange = $request->filled('price_from') && $request->filled('price_to');

    if (!$hasKeyword && !$hasPriceRange) {
        return response()->json([
            'tableRows' => '<tr><td colspan="7" class="text-center text-muted">Please enter a keyword or price range to search.</td></tr>'
        ]);
    }

    $priceFrom = $request->price_from;
    $priceTo = $request->price_to;

    // ✅ Subquery to get max(bundle_first_amount) per product
    $costSubquery = DB::connection($this->connectionType)
        ->table('game_sever_based_cost')
        ->select('game_id', DB::raw('MAX(bundle_first_amount) as bundle_first_amount'))
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
        ->when($hasPriceRange, function ($query) use ($priceFrom, $priceTo) {
            $query->whereBetween(DB::raw('CAST(c.bundle_first_amount AS DECIMAL(10,2))'), [$priceFrom, $priceTo]);
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
    $tableRows = view("invoice.{$modelType}.add_product_rows", [
        'products' => $products,
        'currency' => $currency,
        'site'     => $site
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

        // 1️⃣ Build base invoice info
        $invoice_data = [
            'site'                 => $site,
            'invoice_number'       => $request->input('invoice_number'),
            'invoice_date'         => $request->input('invoice_date'),
            'customer_name'        => $request->input('customer_name'),
            'customer_mobile'      => $request->input('customer_mobile'),
            'customer_email'       => $request->input('customer_email'),
            'company_email'        => $request->input('company_email'),
            'currency'             => site_currency(),
            'product_ids'          => [],
            'invoice_amount'       => $request->input('invoice_amount'),
            'current_amount'       => $request->input('current_amount'),
            'discount_amount'      => $request->input('discount_amount'),
            'company_name'         => $site->company_name,
            'company_email'        => $site->company_email,
            'company_mobile'       => $site->company_mobile,
            'company_address'      => $site->company_address,
            'invoice_header_image' => base64EncodeImage($site->invoice_header_image),
            'invoice_footer_image' => base64EncodeImage($site->invoice_footer_image),
            'invoice_signature'    => base64EncodeImage($site->invoice_signature),
            'company_logo'         => base64EncodeImage($site->company_logo),
            'invoice_image1'       => base64EncodeImage($site->invoice_image1),
            'invoice_image2'       => base64EncodeImage($site->invoice_image2),
            'invoice_image3'       => base64EncodeImage($site->invoice_image3),
            'invoice_template'     => $site->invoice_template,
            'model_type'           => $site->businessModel->model_type,
            'site_id'              => $site->id,
        ];

        // Retrieve the products array from the form
        $products = $request->input('products', []);
        //dd($products);

        // Process products - remove any debugging echo statements
        $processedProducts = [];
        foreach ($products as $productId => $productData) {
            // Skip if selected check was implemented and not selected
            // if (isset($productData['selected']) && $productData['selected'] !== "1") {
            //    continue;
            // }

            // Add product to processed array with all necessary data
            $processedProducts[] = $productData;
        }

        // Add products to the invoice data
        //dd($processedProducts);
        $invoice_data['products'] = $processedProducts;
        //dd($invoice_data['products']);

        // Determine view
        $modelType = strtolower($site->businessModel->model_type);
        $siteWords = numberToWords($site->id);
        $viewPath  = "websites.{$modelType}.{$siteWords}";

        // Generate and return PDF
        try {
            InvoiceController::createInvoiceHistory($invoice_data, $processedProducts);
            $pdf = PDF::loadView($viewPath, $invoice_data)->setPaper('A4', 'portrait');
            $filename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $invoice_data['invoice_number']) . '.pdf';
            return $pdf->download($filename);
        } catch (\Illuminate\View\ViewNotFoundException $e) {
            abort(500, 'Please set up or upload your invoice template.');
        } catch (\Exception $e) {
            // Add better error handling
            \Log::error('PDF generation error: ' . $e->getMessage());
            abort(500, 'Error generating invoice: ' . $e->getMessage());
        }
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
                'bundle' => $game['bundle'],
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
}
