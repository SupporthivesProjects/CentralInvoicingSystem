<?php

namespace App\Http\Controllers;
use App\Models\Website;
use App\Models\User;
use App\Models\BusinessModel;
use App\Models\Currency;
use App\Models\Profile;
use App\Models\ProductPriceHistory;
use App\Models\InvoiceGenerationHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
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
    
    public function invoiceReport(Request $request)
    {
        $query = InvoiceGenerationHistory::with(['website.businessModel'])
                                  ->select('invoice_generation_histories.*');
        
        if ($request->filled('business_model_id')) {
            $query->whereHas('website', function($q) use ($request) {
                $q->where('business_model_id', $request->business_model_id);
            });
        }
        
      
        if ($request->filled('site_id') && $request->site_id != 'all') {
            $query->where('site_id', $request->site_id);
        }

       
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('invoice_generation_histories.created_at', [$startDate, $endDate]);
        }
        
       
        $invoices = $query->get();

        if ($invoices->isEmpty()) {
            $invoices = collect(); 
        }
        
        if ($request->has('generate_pdf')) {
            $currentDate = \Carbon\Carbon::now()->format('Y-m-d h:i A');
            $pdf = PDF::loadView('reports.invoice_report', compact('invoices'));
            $filename = 'invoicegeneratereport-' . $currentDate . '.pdf';
            return $pdf->download($filename);
        }
        
       
        return view('reports.invoice_report', compact('invoices'));
    }
    

}
