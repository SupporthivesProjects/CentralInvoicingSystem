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
        
        list($dates, $invoiceCounts, $priceChanges) = $this->getInvoiceChartData();
        $invoices = InvoiceGenerationHistory::latest()->get();
        $businessmodels = BusinessModel::latest()->get();
        $sites = Website::latest()->get();
        return view('pages.dashboard', compact('invoices', 'dates', 'invoiceCounts','businessmodels','sites', 'priceChanges'));
    }
    
    private function getInvoiceChartData()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7)->startOfDay();
        $today = Carbon::now()->endOfDay();
    
        // Fetch price change stats
        $priceHistory = ProductPriceHistory::select(
            DB::raw('DATE(last_price_changed) as date'),
            DB::raw('COUNT(*) as price_changes')
        )
        ->whereBetween('last_price_changed', [$sevenDaysAgo, $today])
        ->groupBy('date')
        ->orderBy('date', 'asc')
        ->get();
    
        // Fetch invoice stats
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
        $priceChangeCounts = [];
        $invoiceCounts = [];
    
        for ($i = 7; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[] = $date;
            $invoiceCounts[$date] = 0;  // Default to 0 if no invoices
            $priceChangeCounts[$date] = 0;  // Default to 0 if no price changes
        }
    
        // Populate invoice counts for each date
        foreach ($invoiceStats as $stat) {
            $invoiceCounts[$stat->date] = $stat->count;
        }
    
        // Populate price change counts for each date
        foreach ($priceHistory as $stat) {
            $priceChangeCounts[$stat->date] = $stat->price_changes;
        }
    
        // Convert to indexed arrays
        $invoiceCounts = array_values($invoiceCounts);
        $priceChanges = array_values($priceChangeCounts);
    
        return [$dates, $invoiceCounts, $priceChanges];
    }

    
    public function internalSearch(Request $request)
    {
        $keyword = $request->get('keyword', '');
        $type = $request->get('type', '');
    
        if (empty($keyword) || empty($type)) {
            return response()->json([]);
        }
    
        $output = [];
    
        switch ($type) {
            case 'websites':
                $results = Website::where('site_name', 'like', '%' . $keyword . '%')->limit(10)->get();
                foreach ($results as $row) {
                    $output[] = [
                        'name' => $row->site_name,
                        'url' => route('site.connect.db', $row->id), 
                        'icon' => 'bx-globe',
                    ];
                }
                break;
    
            case 'business_models':
                $results = BusinessModel::where('name', 'like', '%' . $keyword . '%')->limit(10)->get();
                foreach ($results as $row) {
                    $output[] = [
                        'name' => $row->name,
                        'url' => route('businessmodel.websites', $row->id), 
                        'icon' => 'bx-briefcase',
                    ];
                }
                break;
    
            default:
                return response()->json([]);
        }
    
        return response()->json($output);
    }
    
}
