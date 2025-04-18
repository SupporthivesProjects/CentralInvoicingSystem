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


class EcommerceController extends Controller
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
        $site_id = $request->get('site_id');
        $invoiceAmount = floatval($request->get('invoice_amount'));
    
        $priceFrom = $request->get('price_from');
        $priceTo = $request->get('price_to');
    
        $minTotal = $invoiceAmount;
        $maxTotal = $invoiceAmount * 1.05;
    
        $site = Website::findOrFail($site_id);
        $productstable = getProductTable($site->technology);
        DynamicDatabaseService::connect($site);
        $minProductPrice = DB::connection($this->connectionType)->table($this->productTable)->min('unit_price'); 
        $maxProductPrice = DB::connection($this->connectionType)->table($this->productTable)->max('unit_price');
    
        $allProducts = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'name', 'unit_price','slug')
            ->where('published', 1)
            ->when($priceFrom && $priceTo, function ($query) use ($priceFrom, $priceTo) {
                return $query->whereBetween('unit_price', [$priceFrom, $priceTo]);
            })
            ->limit(20) 
            ->inRandomOrder() 
            ->get();
        
        $allProducts = $allProducts->shuffle()->take(30);
    
        $bestMatch = null;
        $bestTotal = 0;
    
        for ($i = 0; $i < 10; $i++) {
            $shuffled = $allProducts->shuffle();
            $selected = [];
            $currentTotal = 0;
    
            foreach ($shuffled as $product) {
                $price = floatval($product->unit_price);
    
                if (($currentTotal + $price) <= $maxTotal) {
                // if (($currentTotal + $price) <= $maxTotal && count($selected) < 10) {
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
    
        $currency = DB::connection($this->connectionType)->table('currencies')->where('status', 1)->first();
    
        $modelType = $site->businessModel->model_type;
        $tableRows = view("invoice.{$modelType}.product_rows", ['products' => $bestMatch, 'currency' => $currency,'site' => $site,'minProductPrice'=> $minProductPrice,'maxProductPrice'=> $maxProductPrice])->render();
        
        return response()->json([
            'tableRows' => $tableRows,
            'total' => $bestTotal,
            'currency' => $currency,
            'minProductPrice' => $minProductPrice,
            'maxProductPrice' => $maxProductPrice
        ]);
    }
    

    public function filterProducts(Request $request)
    {
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
        $productstable = getProductTable($site->technology);
        DynamicDatabaseService::connect($site);
        $minProductPrice = DB::connection($this->connectionType)->table($this->productTable)->min('unit_price'); 
        $maxProductPrice = DB::connection($this->connectionType)->table($this->productTable)->max('unit_price');

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
        
        $modelType = $site->businessModel->model_type;
        $tableRows = view("invoice.{$modelType}.product_rows", ['products' => $products, 'currency' => $currency,'site' => $site,'minProductPrice'=> $minProductPrice,'maxProductPrice'=> $maxProductPrice])->render();
        
        return response()->json([
            'tableRows' => $tableRows,
            'currency' => $currency,
            'minProductPrice' => $minProductPrice,
            'maxProductPrice' => $maxProductPrice
        ]);
    }

 
    public function resolveModelController($modelType, $method, Request $request)
    {
        $controllerClass = "App\\Http\\Controllers\\BusinessModels\\" . ucfirst($modelType) . "Controller";
        if (!class_exists($controllerClass)) {
            return response()->json(['error' => 'Invalid model type'], 400);
        }

        $controller = new $controllerClass();
        if (!method_exists($controller, $method)) {
            return response()->json(['error' => 'Method not found'], 400);
        }

        return $controller->$method($request);
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
