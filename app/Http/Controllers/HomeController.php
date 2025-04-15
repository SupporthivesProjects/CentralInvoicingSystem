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


class HomeController extends Controller
{
   
    public function index(Request $request)
    {
        
        list($dates, $invoiceCounts, $totalSales, $discountAmounts) = $this->getInvoiceStats();
        $invoices = InvoiceGenerationHistory::latest()->get();
    
        return view('pages.dashboard', compact('invoices', 'dates', 'invoiceCounts', 'totalSales', 'discountAmounts'));
    }
    
    private function getInvoiceStats()
    {
       
        $sevenDaysAgo = Carbon::now()->subDays(6)->startOfDay();
        $today = Carbon::now()->endOfDay();
    
        
        $invoiceStats = InvoiceGenerationHistory::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(invoice_amount) as total_sales'),
                DB::raw('SUM(discount_amount) as discount_amount')
            )
            ->whereBetween('created_at', [$sevenDaysAgo, $today])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
    
        $dates = [];
        $invoiceCounts = [];
        $totalSales = [];
        $discountAmounts = [];
    
        for ($i = 6; $i >= 0; $i--) {
            $dates[] = Carbon::now()->subDays($i)->format('Y-m-d');
            $invoiceCounts[] = 0;
            $totalSales[] = 0;
            $discountAmounts[] = 0;
        }
    
        foreach ($invoiceStats as $stat) {
            $index = array_search($stat->date, $dates);
            if ($index !== false) {
                $invoiceCounts[$index] = $stat->count;
                $totalSales[$index] = $stat->total_sales;
                $discountAmounts[$index] = $stat->discount_amount;
            }
        }
    
        return [$dates, $invoiceCounts, $totalSales, $discountAmounts];
    }
    
    
    
    
}
