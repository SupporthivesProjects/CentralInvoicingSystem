<?php
namespace App\Http\Controllers;

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



class InvoiceController extends Controller
{

    public function getCustomerDetails($site_id_from_url)
    {
        try {
            $site_id = request()->get('site_id', $site_id_from_url);
            $site = Website::findOrFail($site_id);
            $sites = Website::all();

            return view('invoice.getCustomer', compact('site', 'sites'));

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
            'invoice_number' => 'required|numeric|min:1',
            'invoice_amount' => 'required|numeric|min:1',
            'customer_email' => 'nullable|email',
            'customer_mobile' => 'nullable',
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
        
        
        return redirect()->route('product.selection')->with('success', 'Customer details saved successfully! You can now select products.');
    }


    public function productSelection()
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
    
            return view('invoice.productSelection', [
                'currency' => $currency,
                'customer' => session('customer'),
                'invoice' => session('invoice'),
                'site' => $site,
            ]);
    
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Database connection failed: ' . $e->getMessage());
        }
    }
    

    
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
        
            // Initialize variables for best match tracking
            $bestMatch = null;
            $bestTotal = 0;
        
            // Try up to 10 random shuffles to improve the chances of finding a suitable match
            for ($i = 0; $i < 10; $i++) {
                // Shuffle the products randomly each time
                $shuffled = $allProducts->shuffle();
                $selected = [];
                $currentTotal = 0;
        
                foreach ($shuffled as $product) {
                    $price = floatval($product->unit_price);
        
                    // Check if adding this product exceeds the maximum allowed total
                    if (($currentTotal + $price) <= $maxTotal) {
                        $product->source = 'Random';  // Tag the product as 'Random'
                        $selected[] = $product;
                        $currentTotal += $price;
        
                        // Check if the current total is within the desired range
                        if ($currentTotal >= $minTotal && $currentTotal <= $maxTotal) {
                            $bestMatch = $selected;  // Store the best match
                            $bestTotal = $currentTotal;  // Store the total of the best match
                            break;  // Exit the loop if a good match is found
                        }
                    }
                }
        
                // If a valid match was found, break out of the outer loop early
                if ($bestMatch) {
                    break;
                }
            }
        
            // If no valid combination was found, return a message and empty table rows
            if (!$bestMatch) {
                return response()->json([
                    'tableRows' => '',
                    'total' => 0,
                    'message' => 'No matching combination found'
                ]);
            }
        
            // Fetch the currency details for the site
            $currency = DB::connection('dynamic')->table('currencies')->where('status', 1)->first();
        
            // Generate the HTML for the product rows using Blade view
            $tableRows = view('invoice.product_rows', ['products' => $bestMatch, 'currency' => $currency])->render();
        
            // Return the result as a JSON response
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

        $query = DB::connection('dynamic')->table('products')->select('id', 'name', 'unit_price')->where('published', 1); 
    
        if ($hasKeyword) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        if ($hasPriceRange) {
            $query->whereBetween('unit_price', [
                (float) $request->price_from,
                (float) $request->price_to
            ]);
        }
        
        // Add LIMIT to top 10 matches
        $products = $query->orderBy('name')->limit(10)->get();

        if ($products->isEmpty()) {
            return response()->json([
                'tableRows' => '<tr><td colspan="6" class="text-center text-muted"> No results found. Try randomizing or use a different keyword.</td></tr>'
            ]);
        }

        $currency = DB::connection('dynamic')->table('currencies')->where('status', 1)->first();

        $tableRows = view('invoice.product_rows', ['products' => $products,'currency' => $currency,  ])->render();

        return response()->json(['tableRows' => $tableRows,'currency' => $currency,  ]);
    }

    public function generateInvoice(Request $request)
    {
        // Get product IDs and customer data
        $productIds = $request->input('product_ids', []);
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
        
        // Connect to dynamic database
        DynamicDatabaseService::connect($site);

        // Get customer data from session
        $session_customer = session('customer');
        $session_invoice = session('invoice');

        // Get product details from the dynamic database
        $products = DB::connection('dynamic')->table('products')->whereIn('id', $productIds)->get();
        $currency = DB::connection('dynamic')->table('currencies')->where('status', 1)->first();

        // Validate if products and customer data exist
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
        ];
        // Store invoice data in session
        session([
            'invoice_products' => $products,
            'invoice_customer' => $customer,
        ]);

        // Generate the invoice PDF
        $pdf = PDF::loadView('invoice_templates.invoice_pdf', compact('products', 'customer','site','currency'));

        // Return the generated PDF as a download
        return $pdf->download('invoice_' . now()->format('Ymd_His') . '.pdf');
    }

        
}