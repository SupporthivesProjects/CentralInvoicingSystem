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

class GamingSiteController extends Controller
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

        foreach ($products as $product) {
            $costs = json_decode($product->costs, true);

            if (isset($costs['bundles']) && is_array($costs['bundles'])) {
                foreach ($costs['bundles'] as $bundleAmount => $unitPrice) {
                    $unitPrice = floatval($unitPrice);

                    if ($priceFrom && $priceTo) {
                        if ($unitPrice < $priceFrom || $unitPrice > $priceTo) {
                            continue;
                        }
                    }

                    $allProducts->push((object)[
                        'id'             => $product->id,
                        // 'name'           => $product->name . ' - ' . $bundleAmount,
                        'name'           => $product->name,
                        'unit_price'     => $unitPrice,
                        'slug'           => Str::slug($product->name . '-' . $bundleAmount),
                        'source'         => 'Random',
                        'can_edit_price' => 0,
                        'remaining_days' => 0,
                        'game_currency'  => $product->game_currency,
                        'game_currency_amount' => $bundleAmount,
                        'game_platform'  => $product->game_platform,
                        'game_region'    => $product->game_server_region,
                        'game_need_to_capture' => $product->game_need_to_capture
                    ]);
                }
            }
        }

        $allProducts = $allProducts->sortByDesc('unit_price')->shuffle()->take(60);
        //dd($allProducts);

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

                    if ($currentTotal >= $minTotal && $currentTotal <= $maxTotal) {
                        $bestMatch = $selected;
                        $bestTotal = $currentTotal;
                        break;
                    }
                }
            }

            if ($bestMatch) break;
        }

        if (!$bestMatch) {
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No matching combination found, try again please'
            ]);
        }

        $currency = DB::connection($this->connectionType)
            ->table('currencies')->where('status', 1)->first();

        $modelType = $site->businessModel->model_type;
        $tableRows = view("invoice.{$modelType}.product_rows", [
            'products' => $bestMatch,
            'currency' => $currency,
            'site'     => $site
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total'     => $bestTotal,
            'currency'  => $currency
        ]);
    }



    public function filterProducts(Request $request)
    {
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
        $productstable = getProductTable($site->technology);
        DynamicDatabaseService::connect($site);

        $hasKeyword = $request->filled('keyword');
        $hasPriceRange = $request->filled('price_from') && $request->filled('price_to');

        if (!$hasKeyword && !$hasPriceRange) {
            return response()->json([
                'tableRows' => '<tr><td colspan="6" class="text-center text-muted">Please enter a keyword or price range to search.</td></tr>'
            ]);
        }

        $query = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'name', 'unit_price','slug')
            ->where('published', 1);


        if ($hasKeyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        if ($hasPriceRange) {
            $query->whereBetween('unit_price', [
                (float) $request->price_from,
                (float) $request->price_to
            ]);
        }

        $products = $query->orderBy('name')->limit(15)->get();

        if ($products->isEmpty()) {
            return response()->json([
                'tableRows' => '<tr><td colspan="7" class="text-center text-muted"> No results found. Try randomizing or use a different keyword.</td></tr>'
            ]);
        }

        $currency = DB::connection($this->connectionType)->table('currencies')->where('status', 1)->first();

        $products = collect($products);
        $products->each(function ($product) {
            $product->source = 'Custom';
        });

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
        $tableRows = view("invoice.{$modelType}.product_rows", ['products' => $products, 'currency' => $currency,'site' => $site])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'currency' => $currency
        ]);
    }

    public function generateInvoice(Request $request)
    {
        $site_id = $request->input('site_id');
        $site = Website::findOrFail($site_id);

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
        $invoice_data['company_name'] = $site->company_name;
        $invoice_data['company_email'] = $site->company_email;
        $invoice_data['company_mobile'] = $site->company_mobile;
        $invoice_data['company_address'] = $site->company_address;
        $invoice_data['invoice_header_image'] = base64EncodeImage($site->invoice_header_image);
        $invoice_data['invoice_footer_image'] = base64EncodeImage($site->invoice_footer_image);
        $invoice_data['invoice_signature'] = base64EncodeImage($site->invoice_signature);
        $invoice_data['company_logo'] = base64EncodeImage($site->company_logo);
        $invoice_data['invoice_image1'] = base64EncodeImage($site->invoice_image1);
        $invoice_data['invoice_image2'] = base64EncodeImage($site->invoice_image2);
        $invoice_data['invoice_image3'] = base64EncodeImage($site->invoice_image3);
        $invoice_data['invoice_template'] = $site->invoice_template;
        $invoice_data['model_type'] = $site->businessModel->model_type;
        $invoice_data['site_id'] = $site->id;

        $productDataArray = $request->input('product_data', []);
        DynamicDatabaseService::connect($site);

        $productIds = [];
        $customPrices = [];

        foreach ($productDataArray as $item) {
            $data = json_decode($item, true);
            if (!empty($data['product_id'])) {
                $productIds[] = $data['product_id'];
                $customPrices[$data['product_id']] = $data['unit_price'];
            }
        }


        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->whereIn('id', $productIds)
            ->select('id', 'name', 'unit_price')
            ->get()
            ->sortBy(function ($product) use ($productIds) {
                return array_search($product->id, $productIds);
            })
            ->values()
            ->map(function ($product) use ($customPrices) {
                $product->unit_price = $customPrices[$product->id] ?? $product->unit_price;
                return $product;
            });



        $currency = DB::connection($this->connectionType)->table('currencies')->where('status', 1)->first();
        $invoice_data['currency'] = $currency ? $currency->symbol : "$";

        $invoice_data['products'] = $products;
        $invoice_data['product_ids'] = $productIds;

        $modelType = strtolower($site->businessModel->model_type);
        $siteIdInWords = numberToWords($site->id);
        $viewPath = "websites.{$modelType}.{$siteIdInWords}";


        try {

            $this->updateProductPrice($productDataArray); //product price update checking

            InvoiceController::createInvoiceHistory($invoice_data);
            $pdf = PDF::loadView($viewPath, $invoice_data);
            $pdf->setPaper('A4', 'portrait');
            $filename = $invoice_data['invoice_number'] . '.pdf';
            return $pdf->download($filename);
        } catch (\Illuminate\View\ViewNotFoundException $e) {
            abort(500, 'Please set up or upload your invoice template.');
        }
    }


}

