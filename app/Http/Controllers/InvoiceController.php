<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BusinessModel;
use App\Models\Website;
use App\Models\Invoice;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class InvoiceController extends Controller
{

    public function getCustomerDetails($site_id_from_url)
    {
        try {
            // Check if site_id is passed via query string
            $site_id = request()->get('site_id', $site_id_from_url); // fallback to URL segment

            $site = Website::findOrFail($site_id);
            $sites = Website::all();

            return view('invoice.getCustomer', compact('site', 'sites'));
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Website not found!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    public function productSelection(){

        return view('invoice.productSelection');
    }
    
}

