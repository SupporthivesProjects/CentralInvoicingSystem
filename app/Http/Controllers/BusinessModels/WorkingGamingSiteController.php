<?php

namespace App\Http\Controllers\BusinessModels;

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

class WorkingGamingSiteController extends Controller
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
    $productCount = intval($request->get('product_count')); // <-- Get product_count

    $minTotal = $invoiceAmount;
    $maxTotal = $invoiceAmount * 1.05;

    $site = Website::findOrFail($site_id);
    DynamicDatabaseService::connect($site);

    $products = DB::connection($this->connectionType)
        ->table('products as p')
        ->join('game_sever_based_cost as c', 'p.id', '=', 'c.game_id')
        ->where('p.published', 1)
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

    if (!$bestMatch) {
        return response()->json([
            'tableRows' => '',
            'total'     => 0,
            'message'   => 'No matching combination found, try again please'
        ]);
    }

    session()->forget('selected_games');
    $selected_games = [];

    foreach ($bestMatch as $game) {
        $selected_games[] = [
            'id' => $game->id,
            'unit_price' => $game->unit_price
        ];
    }

    session(['selected_games' => $selected_games]);

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

    $products = DB::connection($this->connectionType)
        ->table('products as p')
        ->join('game_sever_based_cost as c', 'p.id', '=', 'c.game_id')
        ->where('p.published', 1)
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

                // Price Filter
                if ($hasPriceRange && ($unitPrice < $priceFrom || $unitPrice > $priceTo)) {
                    continue;
                }

                // Keyword Filter
                if ($hasKeyword && !str_contains(strtolower($product->name), strtolower($request->keyword))) {
                    continue;
                }

                $alreadyAdded[$uniqueKey] = true;

                $allProducts->push((object)[
                    'id'                    => $product->id,
                    'name'                  => $product->name,
                    'unit_price'             => $unitPrice,
                    'slug'                  => Str::slug($product->name . '-' . $bundleAmount),
                    'source'                 => 'Custom',
                    'can_edit_price'         => 1,
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

    if ($allProducts->isEmpty()) {
        return response()->json([
            'tableRows' => '<tr><td colspan="7" class="text-center text-muted">No results found. Try randomizing or use a different keyword.</td></tr>'
        ]);
    }

    $currency = DB::connection($this->connectionType)
        ->table('currencies')
        ->where('status', 1)
        ->first();

    $modelType = $site->businessModel->model_type;
    $tableRows = view("invoice.{$modelType}.random_product_rows", [
        'products' => $allProducts,
        'currency' => $currency,
        'site'     => $site
    ])->render();

    return response()->json([
        'tableRows' => $tableRows,
        'currency'  => $currency,
        'is_random' => false
    ]);
}
public function addGames(Request $request)
{
    $site_id = session('customer.site_id');
    $site = Website::findOrFail($site_id);
    DynamicDatabaseService::connect($site);

    $priceFrom = $request->price_from;
    $priceTo = $request->price_to;
    $keyword = $request->keyword;

    $products = DB::connection($this->connectionType)
        ->table('products as p')
        ->join('game_sever_based_cost as c', 'p.id', '=', 'c.game_id')
        ->where('p.published', 1)
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

                // Apply price filter if provided
                if ($request->filled('price_from') && $request->filled('price_to')) {
                    if ($unitPrice < $priceFrom || $unitPrice > $priceTo) {
                        continue;
                    }
                }

                // Apply keyword filter if provided
                if ($request->filled('keyword') && !str_contains(strtolower($product->name), strtolower($keyword))) {
                    continue;
                }

                $alreadyAdded[$uniqueKey] = true;

                $allProducts->push((object)[
                    'id'                    => $product->id,
                    'name'                  => $product->name,
                    'unit_price'            => $unitPrice,
                    'slug'                  => Str::slug($product->name . '-' . $bundleAmount),
                    'source'                => 'Custom',
                    'can_edit_price'        => 1,
                    'remaining_days'        => 0,
                    'game_currency'         => $product->game_currency,
                    'game_currency_amount'  => $bundleAmount,
                    'game_platform'         => $product->game_platform,
                    'game_region'           => $product->game_server_region,
                    'game_need_to_capture'  => $product->game_need_to_capture
                ]);
            }
        }
    }

    if ($allProducts->isEmpty()) {
        return response()->json([
            'tableRows' => '<tr><td colspan="7" class="text-center text-muted">No games found. Try another keyword or adjust the price range.</td></tr>'
        ]);
    }

    $currency = DB::connection($this->connectionType)
        ->table('currencies')
        ->where('status', 1)
        ->first();

    $modelType = $site->businessModel->model_type;
    $tableRows = view("invoice.{$modelType}.add_product_rows", [
        'products' => $allProducts,
        'currency' => $currency,
        'site'     => $site
    ])->render();

    return response()->json([
        'tableRows' => $tableRows,
        'currency'  => $currency,
        'is_random' => false
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


}

