<?php
namespace App\Http\Controllers;
use App\Models\InvoiceGenerationHistory;;
use Illuminate\Http\Request;
use App\Models\BusinessModel;
use App\Models\Website;
use App\Models\Invoice;
use App\Models\ProductPriceHistory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\DynamicDatabaseService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

use App\Http\Controllers\BusinessModels\EcommerceController;
use App\Http\Controllers\BusinessModels\ContentWritingController;
use App\Http\Controllers\BusinessModels\MarketingController;
use App\Http\Controllers\BusinessModels\GamingController;
use App\Http\Controllers\BusinessModels\GiftCardController;
use App\Http\Controllers\BusinessModels\ImageStockController;
use App\Http\Controllers\BusinessModels\TranslationController;





class InvoiceController extends Controller
{

    public function getCustomerDetails($site_id_from_url)
    {
        try {
            $site_id = request()->get('site_id', $site_id_from_url);
            $site = Website::findOrFail($site_id);
            $sites = Website::all();

            $invoiceNumber = generateInvoiceNumber($site->site_name);
            $transactionNumber = rand(100000, 999999);

            return view('invoice.getCustomer', compact('invoiceNumber','site', 'sites'));

        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Website not found!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function saveCustomerDetails(Request $request)
    {
        $validated = $request->validate([
            'site_id' => 'required|exists:websites,id',
            'customer_name' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'invoice_number' => 'required|string|min:1',
            'invoice_amount' => 'required|numeric|min:1',
            'customer_email' => 'nullable|email',
            'customer_mobile' => 'nullable|string|max:15',
        ]);
        
        
        session([
            'customer' => [
                'site_id' => $request->site_id,
                'site_name' => $request->site_name,
                'customer_name' => $request->customer_name,
                'customer_mobile' => $request->customer_mobile,
                'customer_email' => $request->customer_email,
            ],
            'invoice' => [
                'invoice_number' => $request->invoice_number,
                'invoice_amount' => $request->invoice_amount,
                'invoice_date' => $request->invoice_date,
            ],
            'products' => []
        ]);        
        
        
        return redirect()->route('product.selection')->with('success', 'Database connection established for the selected website.');
    }


    public function productSelection(Request $request)
    {
        $site_id = session('customer.site_id');
    
        if (!$site_id) {
            return redirect()->back()
                ->with('error', 'Missing invoice session data. Please try again.');
        }
    
        try {
            $site = Website::findOrFail($site_id);
            
            DynamicDatabaseService::connect($site);
            DB::connection('dynamic')->getPdo(); 
    
            $currency = DB::connection('dynamic')
                ->table('currencies')
                ->where('status', 1)
                ->first();

                $modelType = $site->businessModel->model_type;

                return view("invoice.{$modelType}.productSelection", [
                    'currency' => $currency,
                    'customer' => session('customer'),
                    'invoice' => session('invoice'),
                    'site' => $site
                ]);
                
    
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Database connection failed: ' . $e->getMessage());
        }
    }

    public function randomProducts(Request $request)
    {
        $site = Website::findOrFail(session('customer.site_id'));
        $modelType = $site->businessModel->model_type;
        $modelType = strtolower($modelType); 
        return $this->resolveModelController($modelType, 'randomProducts', $request);
    }
    
    public function filterProducts(Request $request)
    {
        $site = Website::findOrFail(session('customer.site_id'));
        $modelType = $site->businessModel->model_type;
        $modelType = strtolower($modelType); 
        return $this->resolveModelController($modelType, 'filterProducts', $request);
    }
    
    public function generateInvoice(Request $request)
    {  
        $site = Website::findOrFail(session('customer.site_id'));
        $modelType = $site->businessModel->model_type;
        $modelType = strtolower($modelType); 
    
        return $this->resolveModelController($modelType, 'generateInvoice', $request);
    }
    
    private function resolveModelController($modelType, $method, $request)
    {
        switch ($modelType) {
            case 'ecommerce':
                return app(EcommerceController::class)->$method($request);
            case 'contentwriting':
                return app(ContentWritingController::class)->$method($request);
            case 'marketing':
                return app(MarketingController::class)->$method($request);
            case 'gaming':
                return app(GamingSiteController::class)->$method($request);
            case 'giftcard':
                return app(GiftCardController::class)->$method($request);
            case 'imagestock':
                return app(ImageStockController::class)->$method($request);
            case 'translation':
                return app(TranslationController::class)->$method($request);
            default:
            return redirect()->back()->with('error', 'Invalid business model type');
        }
    }

    public static function createInvoiceHistory($invoice_data)
    {
        InvoiceGenerationHistory::create([
            'model_type'      => $invoice_data['model_type'],
            'site_id'         => $invoice_data['site_id'],
            'currency'        => $invoice_data['currency'],
            'invoice_number'  => $invoice_data['invoice_number'],
            'product_ids'     => json_encode($invoice_data['product_ids']),
            'current_amount'  => $invoice_data['current_amount'],
            'discount_amount' => $invoice_data['discount_amount'],
            'invoice_amount'  => $invoice_data['invoice_amount'],
        ]);
    }
    
            
}