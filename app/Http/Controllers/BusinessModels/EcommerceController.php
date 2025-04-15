<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers\BusinessModels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusinessModel;
use App\Models\Website;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\DynamicDatabaseService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Mpdf\Mpdf; //not used
use Illuminate\View\ViewException; // optional
use Illuminate\View\ViewNotFoundException;
use Carbon\Carbon;

class EcommerceController extends Controller
{

    public function randomProducts(Request $request)
    {
        $site_id = $request->get('site_id');
        $invoiceAmount = floatval($request->get('invoice_amount'));

        // Get price range from request
        $priceFrom = $request->get('price_from');
        $priceTo = $request->get('price_to');

        // 1–2% tolerance range for the invoice amount
        $minTotal = $invoiceAmount;
        $maxTotal = $invoiceAmount * 1.02;

        // Find the website data based on site_id
        $site = Website::findOrFail($site_id);

        // Connect to the dynamic database for the selected site
        DynamicDatabaseService::connect($site);

        // Fetch products that are published
        $allProducts = DB::connection('dynamic')->table('products')
            ->select('id', 'name', 'unit_price')
            ->where('published', 1)
            ->when($priceFrom && $priceTo, function ($query) use ($priceFrom, $priceTo) {
                return $query->whereBetween('unit_price', [$priceFrom, $priceTo]);
            })
            ->get();

        $bestMatch = null;
        $bestTotal = 0;

        // Try up to 10 random shuffles to improve the chances of finding a suitable match
        for ($i = 0; $i < 10; $i++) {
            $shuffled = $allProducts->shuffle();
            $selected = [];
            $currentTotal = 0;

            foreach ($shuffled as $product) {
                $price = floatval($product->unit_price);

                if (($currentTotal + $price) <= $maxTotal) {
                    $product->source = 'Random';
                    $selected[] = $product;
                    $currentTotal += $price;

                    if ($currentTotal >= $minTotal && $currentTotal <= $maxTotal) {
                        $bestMatch = $selected;
                        $bestTotal = $currentTotal;
                        break;
                    }
                }
            }

            if ($bestMatch) {
                break;
            }
        }

        if (!$bestMatch) {
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No matching combination found, try again please'
            ]);
        }

        $currency = DB::connection('dynamic')->table('currencies')->where('status', 1)->first();

        $modelType = $site->businessModel->model_type;
        $tableRows = view("invoice.{$modelType}.product_rows", ['products' => $bestMatch, 'currency' => $currency])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total' => $bestTotal,
            'currency' => $currency
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
                'tableRows' => '<tr><td colspan="6" class="text-center text-muted">Please enter a keyword or price range to search.</td></tr>'
            ]);
        }

        $query = DB::connection('dynamic')->table('products')
            ->select('id', 'name', 'unit_price')
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

        $currency = DB::connection('dynamic')->table('currencies')->where('status', 1)->first();
        
        $modelType = $site->businessModel->model_type;
        $tableRows = view("invoice.{$modelType}.product_rows", ['products' => $products, 'currency' => $currency])->render();
        
        return response()->json([
            'tableRows' => $tableRows,
            'currency' => $currency
        ]);
    }

    public function generateInvoice(Request $request)
    {
        $productDataArray = $request->input('product_data', []);
        $discount_amount = $request->input('discount_amount', 0);
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);

        DynamicDatabaseService::connect($site);

        $session_customer = session('customer');
        $session_invoice = session('invoice');

        $productIds = [];
        $customPrices = [];

        foreach ($productDataArray as $item) {
            $data = json_decode($item, true);
            if (!empty($data['product_id'])) {
                $productIds[] = $data['product_id'];
                $customPrices[$data['product_id']] = $data['unit_price'];
            }
        }

        $products = DB::connection('dynamic')->table('products')
            ->whereIn('id', $productIds)
            ->get()
            ->map(function ($product) use ($customPrices) {
                $product->unit_price = $customPrices[$product->id] ?? $product->unit_price;
                return $product;
            });

        $currency = DB::connection('dynamic')->table('currencies')->where('status', 1)->first();

        if (!$products || !$session_customer) {
            return redirect()->back()->with('error', 'No invoice data found.');
        }

        $customer = [
            'site_id'         => $session_customer['site_id'] ?? null,
            'site_name'       => $session_customer['site_name'] ?? null,
            'customer_name'   => $session_customer['customer_name'] ?? null,
            'customer_mobile' => $session_customer['customer_mobile'] ?? null,
            'customer_email'  => $session_customer['customer_email'] ?? null,
            'invoice_number'  => $session_invoice['invoice_number'] ?? null,
            'invoice_amount'  => $session_invoice['invoice_amount'] ?? null,
            'invoice_date'    => $session_invoice['invoice_date'] ?? null,
            'discount_amount' => $discount_amount,
        ];

        session([
            'invoice_products' => $products,
            'invoice_customer' => $customer,
        ]);

        $modelType = strtolower($site->businessModel->model_type);
        $siteIdInWords = numberToWords($site->id);
        $viewPath = "websites.{$modelType}.{$siteIdInWords}";

        try {

            $pdf = PDF::loadView($viewPath, compact('products', 'customer', 'site', 'currency'));
            $pdf->setPaper('A4', 'portrait'); 
            $filename = 'invoice_' . now()->format('Ymd_His') . '.pdf';
            return $pdf->download($filename);
    
        } catch (\Illuminate\View\ViewNotFoundException $e) {
            abort(500, 'Please set up or upload your invoice template.');
        }
    }


}
