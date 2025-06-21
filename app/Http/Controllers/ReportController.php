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
use Api2Pdf\Api2Pdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Http;

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
            $filename = 'invoicegeneratereport-' . $currentDate . '.pdf';
            $viewPath = 'reports.invoice_report';
        
            try {
                return $this->generateWithApi2Pdf($viewPath, $invoices, $filename);
            } catch (\Exception $e) {
                return $this->generateWithDompdf($viewPath, $invoices, $filename);
            }
        }
        
        return view('reports.invoice_report', compact('invoices'));
        
    }



    protected function generateWithApi2Pdf($viewPath, $invoice_data, $filename)
    {
        $html = View::make($viewPath, ['invoices' => $invoice_data])->render();
    
        $response = Http::withHeaders([
            'Authorization' => env('API2PDF_KEY')
        ])->post('https://v2.api2pdf.com/chrome/html', [
            'html' => $html,
            'fileName' => $filename,
            'options' => [
                'format' => 'A4',
                'landscape' => false
            ]
        ]);
    
        if ($response->failed()) {
            $error = $response->json('message') ?? $response->body();
            throw new \Exception('API2PDF failed: ' . $error);
        }
    
        $pdfUrl = $response->json('pdf');
    
        if (empty($pdfUrl)) {
            throw new \Exception('API2PDF did not return a PDF URL.');
        }
    
        return response()->streamDownload(function () use ($pdfUrl) {
            $pdfResponse = Http::timeout(60)->get($pdfUrl);
    
            if ($pdfResponse->failed()) {
                throw new \Exception("Failed to download PDF file from Api2Pdf.");
            }
    
            echo $pdfResponse->body();
        }, $filename);
    }
    

    protected function generateWithDompdf($viewPath, $invoice_data, $filename)
    {
        $pdf = \PDF::loadView($viewPath, ['invoices' => $invoice_data])->setPaper('A4', 'portrait');
        return $pdf->download($filename);
    }

    

}
