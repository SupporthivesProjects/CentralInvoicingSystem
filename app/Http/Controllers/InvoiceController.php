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
use App\Http\Controllers\BusinessModels\GamingSiteController;
use App\Http\Controllers\BusinessModels\GiftCardController;
use App\Http\Controllers\BusinessModels\StockImageController;
use App\Http\Controllers\BusinessModels\TranslationController;





class InvoiceController extends Controller
{

    protected $productTable = null;
    protected $connectionType = null;

    public function __construct()
    {
        $site_id = session('customer.site_id');

        if ($site_id) {
            $site = Website::find($site_id);

            if ($site) {
                $this->productTable = getProductTable($site->technology);
                $this->connectionType = 'dynamic';
            }
        }
    }

    public function getCustomerDetails($site_id_from_url)
    {
        try {
            $site_id = request()->get('site_id', $site_id_from_url);
            $site = Website::findOrFail($site_id);
            $sites = Website::all();

            session()->put('customer.site_id', $site->id);

            return view('invoice.getCustomer', [
                'site' => $site,
                'sites' => $sites,
                'customer' => session('customer'),
                'invoice' => session('invoice'),
            ]);

        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Website not found!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }


    public function saveCustomerDetails(Request $request)
    {
        $validated = $request->validate([
            'hidden_site_id' => 'required|exists:websites,id',
            'customer_name' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'invoice_amount' => 'required|numeric|min:1',
            'customer_email' => 'nullable|email',
            'customer_mobile' => 'nullable|string|max:15',
        ]);


        session([
            'customer' => [
                'site_id' => $request->hidden_site_id,
                'site_name' => $request->site_name,
                'customer_name' => $request->customer_name,
                'customer_mobile' => $request->customer_mobile,
                'customer_email' => $request->customer_email,
            ],
            'invoice' => [
                'invoice_amount' => $request->invoice_amount,
                'invoice_date' => $request->invoice_date,
                'invoice_number' => $request->invoice_number,
            ],
            'products' => []
        ]);

        if (!$request->invoice_amount) {

            return redirect()->back()->with(['error','Invoice amount is required.']);
        }

        if (!session('invoice.invoice_amount')) {
            session()->put('invoice.invoice_amount', $request->invoice_amount);
        }

        return redirect()->route('product.selection')->with('success', 'Database connection established for the selected website.');
    }


    public function productSelection(Request $request)
    {
        $invoice_id = $request->query('invoice_id');

        if ($invoice_id) {
            $invoiceHistory = InvoiceGenerationHistory::where('id', $invoice_id)->first();

            if ($invoiceHistory) {
                session([
                    'customer' => [
                        'site_id' => $invoiceHistory->site_id,
                        'site_name' => $invoiceHistory->website->site_name,
                    ],
                    'invoice' => [
                        'invoice_amount' => $invoiceHistory->invoice_amount,
                        'invoice_number' => $invoiceHistory->invoice_number,
                    ],
                    'products' => []
                ]);
            }
        }
        $new_site_id = $request->query('new_site_id');

        if ($new_site_id && session('customer.site_id') != $new_site_id) {
            $site = Website::findOrFail($new_site_id);
            $customer = session('customer');
            $customer['site_id'] = $new_site_id;
            $customer['site_name'] = $site->site_name;
            session()->put('customer', $customer);

            session()->flash('success', 'Website has been changed');
        }

        $site_id = session('customer.site_id');

        if (!$site_id) {
            return redirect()->back()
                ->with('error', 'Missing invoice session data. Please try again.');
        }

        try {
            $site = Website::findOrFail($site_id);

            DynamicDatabaseService::connect($site);
            DB::connection($this->connectionType)->getPdo();

            try {
                $min_unit_price = DB::connection($this->connectionType)->table($this->productTable)->where('published', 1)->min('unit_price') ?? 10;
                $max_unit_price = DB::connection($this->connectionType)->table($this->productTable)->where('published', 1)->max('unit_price') ?? 1000;
            } catch (\Exception $e) {
                $min_unit_price = 10;
                $max_unit_price = 1000;
            }

            $modelType = $site->businessModel->model_type;
            $sites = Website::all();

            return view("invoice.{$modelType}.productSelection", [
                'customer' => session('customer'),
                'invoice' => session('invoice'),
                'site' => $site,
                'sites' => $sites,
                'min_unit_price' => $min_unit_price,
                'max_unit_price' => $max_unit_price
            ]);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Database connection failed: ' . $e->getMessage());
        }
    }



    public function updateInvoiceAmount(Request $request)
    {
        $validated = $request->validate([

            'invoice_amount' => 'nullable|numeric|min:1',
            'invoice_date' => 'nullable|date',
            'customer_name' => 'nullable|string|max:255',
            'customer_email' => 'nullable|email',
            'customer_mobile' => 'nullable|string|max:15',
        ]);

        session()->put('invoice.invoice_amount', $request->invoice_amount);
        session()->put('invoice.invoice_date', $request->invoice_date);
        session()->put('customer.customer_name', $request->customer_name);
        session()->put('customer.customer_mobile', $request->customer_mobile);
        session()->put('customer.customer_email', $request->customer_email);

        return response()->json([
            'success' => true,
            'message' => 'Customer details updated successfully!',
            'updated' => [
                'invoice_amount' => $request->invoice_amount,
                'invoice_date' => $request->invoice_date,
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_mobile' => $request->customer_mobile,
            ],
        ]);
    }


    public function randomProducts(Request $request)
    {
        $site = Website::findOrFail(session('customer.site_id'));
        $modelType = strtolower($site->businessModel->model_type);
        return $this->resolveModelController($modelType, 'randomProducts', $request);
    }

    public function filterProducts(Request $request)
    {
        $site = Website::findOrFail(session('customer.site_id'));
        $modelType = strtolower($site->businessModel->model_type);
        return $this->resolveModelController($modelType, 'filterProducts', $request);
    }

    public function addProducts(Request $request)
    {
        $site = Website::findOrFail(session('customer.site_id'));
        $modelType = strtolower($site->businessModel->model_type);
        return $this->resolveModelController($modelType, 'addProducts', $request);
    }

    public function removeProduct(Request $request)
    {
        $site = Website::findOrFail(session('customer.site_id'));
        $modelType = strtolower($site->businessModel->model_type);
        return $this->resolveModelController($modelType, 'removeProduct', $request);
    }

    public function updateProduct(Request $request)
    {
        $site = Website::findOrFail(session('customer.site_id'));
        $modelType = strtolower($site->businessModel->model_type);
        return $this->resolveModelController($modelType, 'updateProduct', $request);
    }

    public function getProduct(Request $request)
    {
        $site = Website::findOrFail(session('customer.site_id'));
        $modelType = strtolower($site->businessModel->model_type);
        return $this->resolveModelController($modelType, 'getProduct', $request);
    }

    public function clearProducts(Request $request)
    {
        $site = Website::findOrFail(session('customer.site_id'));
        $modelType = strtolower($site->businessModel->model_type);
        return $this->resolveModelController($modelType, 'clearProducts', $request);
    }

    public function generateInvoice(Request $request)
    {
        $site = Website::findOrFail(session('customer.site_id'));
        $modelType = strtolower($site->businessModel->model_type);
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
            case 'stock_image':
                return app(StockImageController::class)->$method($request);
            case 'translation':
                return app(TranslationController::class)->$method($request);
            default:
                return redirect()->back()->with('error', 'Invalid business model type, please contact developer.');
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


    public function generateInvoiceNumber(Request $request)
    {
        $siteName = $request->input('site_name');
        $newInvoiceNumber = generateInvoiceNumber($siteName);
        session(['invoice_number' => $newInvoiceNumber]);
        return response()->json(['success' => true,'new_invoice_number' => $newInvoiceNumber]);
    }



}
