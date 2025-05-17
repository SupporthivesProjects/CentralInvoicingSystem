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
use Illuminate\Support\Facades\Cache;



class HomeController extends Controller
{
   
    public function index(Request $request)
    {

        list($dates, $invoiceCounts, $priceChanges) = $this->getInvoiceChartData();
        $businessmodels = Cache::rememberForever('businessmodels.all', function () {
            return BusinessModel::latest()->get();
        });
        
        $sites = Cache::rememberForever('websites.all', function () {
            return Website::latest()->get();
        });
        
        $invoices = Cache::remember('invoices.all', 300, function () {
            return InvoiceGenerationHistory::latest()->get();
        });
        return view('pages.dashboard', compact('invoices', 'dates', 'invoiceCounts','businessmodels','sites', 'priceChanges'));
    }
    
    private function getInvoiceChartData()
    {
        $sevenDaysAgo = Carbon::now()->subDays(7)->startOfDay();
        $today = Carbon::now()->endOfDay();
    
        $cacheKeyPriceHistory = 'price_history_' . $sevenDaysAgo . '_' . $today;
        $cacheKeyInvoiceStats = 'invoice_stats_' . $sevenDaysAgo . '_' . $today;

        $priceHistory = Cache::remember($cacheKeyPriceHistory, 300, function () use ($sevenDaysAgo, $today) {
            return ProductPriceHistory::select(
                DB::raw('DATE(last_price_changed) as date'),
                DB::raw('COUNT(*) as price_changes')
            )
            ->whereBetween('last_price_changed', [$sevenDaysAgo, $today])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        });

        $invoiceStats = Cache::remember($cacheKeyInvoiceStats, 300, function () use ($sevenDaysAgo, $today) {
            return InvoiceGenerationHistory::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(invoice_amount) as total_sales'),
                DB::raw('SUM(discount_amount) as discount_amount')
            )
            ->whereBetween('created_at', [$sevenDaysAgo, $today])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        });

        $dates = [];
        $priceChangeCounts = [];
        $invoiceCounts = [];
    
        for ($i = 7; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[] = $date;
            $invoiceCounts[$date] = 0;  
            $priceChangeCounts[$date] = 0;  
        }
    
       
        foreach ($invoiceStats as $stat) {
            $invoiceCounts[$stat->date] = $stat->count;
        }
    
       
        foreach ($priceHistory as $stat) {
            $priceChangeCounts[$stat->date] = $stat->price_changes;
        }
    
       
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
                $normalizedKeyword = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($keyword));

                $results = Website::whereRaw("REPLACE(LOWER(site_name), '-', '') LIKE ?", ['%' . $normalizedKeyword . '%'])
                    ->orWhereRaw("REPLACE(LOWER(bank_name), '-', '') LIKE ?", ['%' . $normalizedKeyword . '%'])
                    ->orWhereRaw("REPLACE(LOWER(bank_code), '-', '') LIKE ?", ['%' . $normalizedKeyword . '%'])
                    ->limit(10)
                    ->get();
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

    public function searchResult(Request $request)
    {
        $keyword = $request->input('keyword', '');
        $type = $request->input('type', '');
    
        if (empty($keyword) || $type !== 'websites') {
            return response()->json([]);
        }
    
        $normalizedKeyword = preg_replace('/[^a-zA-Z0-9]/', '', strtolower($keyword));
    
        $websites = Website::whereRaw("REPLACE(LOWER(site_name), '-', '') LIKE ?", ['%' . $normalizedKeyword . '%'])
            ->orWhereRaw("REPLACE(LOWER(bank_name), '-', '') LIKE ?", ['%' . $normalizedKeyword . '%'])
            ->orWhereRaw("REPLACE(LOWER(bank_code), '-', '') LIKE ?", ['%' . $normalizedKeyword . '%'])
            ->get();
    
        return view('business.searchresult', compact('websites'));
    }
    
    
    
}
