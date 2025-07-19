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
use Illuminate\Support\Facades\Http;





class HomeController extends Controller
{

    public function index(Request $request)
    {

        list($dates, $invoiceCounts, $priceChanges) = $this->getInvoiceChartData();
        list($invoicedates, $userInvoices) = $this->getUserInvoiceChartData();
        $businessmodels = Cache::rememberForever('businessmodels.all', function () {
            return BusinessModel::latest()->get();
        });

        $sites = Cache::rememberForever('websites.all', function () {
            return Website::latest()->get();
        });
        $currentHost = $request->getHost();
        if ($currentHost === '127.0.0.1') {
            $invoices = InvoiceGenerationHistory::orderBy('id', 'desc')->take(10)->get();
        } else {
            $invoices = Cache::remember('invoices.all', 300, function () {
                return InvoiceGenerationHistory::orderBy('id', 'desc')->get();
            });
        }
        
        return view('pages.dashboard', compact('invoices', 'dates', 'invoiceCounts','businessmodels','sites', 'priceChanges', 'invoicedates','userInvoices'));
    }

    
    public function getUserInvoiceChartData()
    {
        $startDate = now()->subDays(7)->startOfDay(); 
        $endDate = now()->endOfDay();
    
       
        $rawData = InvoiceGenerationHistory::selectRaw('DATE(created_at) as date, created_by, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date', 'created_by')
            ->orderBy('date')
            ->get();
    
       
        $invoicedates = collect();
        for ($i = 0; $i < 8; $i++) {
            $invoicedates->push(now()->subDays(7 - $i)->format('d-m-Y'));
        }
    
        $users = $rawData->pluck('created_by')->unique();
    
        $series = [];
    
        foreach ($users as $userId) {
            $user = User::find($userId);
            $userData = [];
    
            foreach ($invoicedates as $formattedDate) {
                $matching = $rawData->first(function ($item) use ($formattedDate, $userId) {
                    return $item->created_by == $userId &&
                        Carbon::parse($item->date)->format('d-m-Y') === $formattedDate;
                });
    
                $userData[] = $matching ? (int) $matching->count : 0;
            }
    
            $series[] = [
                'name' => $user?->name ?? "User $userId",
                'data' => $userData
            ];
        }
    
        return [$invoicedates, $series];
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
            $date = Carbon::now()->subDays($i)->format('d-m-Y');
            $dates[] = $date;
            $invoiceCounts[$date] = 0;
            $priceChangeCounts[$date] = 0;
        }

        foreach ($invoiceStats as $stat) {
            $formattedDate = Carbon::parse($stat->date)->format('d-m-Y');
            $invoiceCounts[$formattedDate] = $stat->count;
        }

        foreach ($priceHistory as $stat) {
            $formattedDate = Carbon::parse($stat->date)->format('d-m-Y');
            $priceChangeCounts[$formattedDate] = $stat->price_changes;
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
    

    public function fetchWooCommerceProducts()
    {
        $consumerKey = 'ck_cdde416de55f08fd2849000081ea380da09dbe07';
        $consumerSecret = 'cs_a4d86e30abca2386762d40339a6c112940ef4239';
        $siteUrl = 'https://gm3boot.jkt-mainos.com';
        $auth = base64_encode($consumerKey . ':' . $consumerSecret);

        $products = [];
        $page = 1;

        do {
            $response = Http::withHeaders([
                'Authorization' => 'Basic ' . $auth,
                'Content-Type' => 'application/json',
                'User-Agent' => 'LaravelApp/1.0'
            ])->get($siteUrl . '/wp-json/wc/v3/products', [
                'per_page' => 100,
                'page' => $page,
            ]);

            if ($response->failed()) {
                return response()->json(['error' => 'Failed to fetch products'], 500);
            }

            $productData = $response->json();

            foreach ($productData as $product) {
                $productEntry = [
                    'id' => $product['id'],
                    'name' => $product['name'],
                    'type' => $product['type'],
                    'price' => $product['price'] ?? null,
                    'variations' => [],
                ];

                if ($product['type'] === 'variable') {
                    $variationResponse = Http::withHeaders([
                        'Authorization' => 'Basic ' . $auth,
                        'Content-Type' => 'application/json',
                        'User-Agent' => 'LaravelApp/1.0'
                    ])->get($siteUrl . '/wp-json/wc/v3/products/' . $product['id'] . '/variations');

                    if ($variationResponse->successful()) {
                        $variations = $variationResponse->json();
                        foreach ($variations as $variation) {
                            $attrs = [];
                            foreach ($variation['attributes'] as $attribute) {
                                $attrs[$attribute['name']] = $attribute['option'];
                            }

                            $productEntry['variations'][] = [
                                'id' => $variation['id'],
                                'price' => $variation['price'],
                                'attributes' => $attrs,
                            ];
                        }
                    }
                }

                $products[] = $productEntry;
            }

            $page++;
        } while (!empty($productData));

        return response()->json($products);
    }

    
    
}
