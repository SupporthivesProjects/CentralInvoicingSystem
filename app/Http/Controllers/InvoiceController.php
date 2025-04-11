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
        $invoiceAmount = session('invoice.invoice_amount');
    
        // Check if required sessions are available
        if (!$site_id || !$invoiceAmount) {
            return redirect()->route('product.selection')->with('error', 'Missing invoice session data. Please try again.');
        }
    
        try {
            $site = Website::findOrFail($site_id);

            $modelType = $site->businessModel?->model_type;

            if ($modelType == "ecommerce") {
    
                // Connect to dynamic DB
                DynamicDatabaseService::connect($site);
    
                $maxAllowedAmount = $invoiceAmount * 1.01;
    
                $products = DB::connection('dynamic')->table('products')
                    ->select('id', 'name', 'unit_price')
                    ->orderBy('unit_price', 'desc')
                    ->get();
    
                $selectedProducts = [];
                $total = 0;
                $foundExactMatch = false;
    
                // First: Try exact match
                foreach ($products as $product) {
                    if (($total + $product->unit_price) <= $invoiceAmount) {
                        $selectedProducts[] = $product;
                        $total += $product->unit_price;
    
                        if ($total == $invoiceAmount) {
                            $foundExactMatch = true;
                            break;
                        }
                    }
                }
    
                // Second: Try match within 1% margin
                if (!$foundExactMatch) {
                    $selectedProducts = [];
                    $total = 0;
    
                    foreach ($products as $product) {
                        if (($total + $product->unit_price) <= $maxAllowedAmount) {
                            $selectedProducts[] = $product;
                            $total += $product->unit_price;
    
                            if ($total >= $invoiceAmount) {
                                break;
                            }
                        }
                    }
                }
    
                return view('invoice.productSelection', ['selectedProducts' => $selectedProducts,'total' => $total,'customer' => session('customer'),'invoice' => session('invoice'),]);
            } else {
                return redirect()->route('product.selection')->with('error', 'Selected site is not eCommerce type.');
            }
    
        } catch (\Exception $e) {
            return redirect()->route('product.selection')->with('error', 'Database connection failed: ' . $e->getMessage());
        }
    }

    public function randomProducts(Request $request)
    {
        $site_id = $request->get('site_id');
        $invoiceAmount = floatval($request->get('invoice_amount'));

        // 1–2% tolerance
        $minTotal = $invoiceAmount;
        $maxTotal = $invoiceAmount * 1.02;

        $site = Website::findOrFail($site_id);

        DynamicDatabaseService::connect($site);

        $allProducts = DB::connection('dynamic')->table('products')
            ->select('id', 'name', 'unit_price')
            ->get();

        $bestMatch = null;
        $bestTotal = 0;

        // Try 10 random shuffles to increase chances
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

            // Break early if good match found
            if ($bestMatch) break;
        }

        if (!$bestMatch) {
        
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No matching combination found'
            ]);
        }

        $tableRows = view('invoice.product_rows', ['products' => $bestMatch])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total' => $bestTotal,
        ]);
    }

    
  
    public function filterProducts(Request $request)
    {
        $site_id = $request->get('site_id');
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
            ->select('id', 'name', 'unit_price');

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
        $products = $query->orderBy('name')->limit(5)->get();

        if ($products->isEmpty()) {
            return response()->json([
                'tableRows' => '<tr><td colspan="6" class="text-center text-muted"> No results found. Try randomizing or use a different keyword.</td></tr>'
            ]);
        }

        $tableRows = view('invoice.product_rows', ['products' => $products])->render();

        return response()->json([
            'tableRows' => $tableRows
        ]);
    }


        
}