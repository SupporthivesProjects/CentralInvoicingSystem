<?php
namespace App\Http\Controllers\BusinessModels\Ecommerce;

use App\Http\Controllers\Controller;
use App\Http\Controllers\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\BusinessModel;
use App\Models\Website;
use App\Models\Invoice;
use App\Models\ProductPriceHistory;
use App\Models\InvoiceGenerationHistory;
use App\Services\DynamicDatabaseService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\ViewNotFoundException;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;
use Api2Pdf\Api2Pdf;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Http;


class LaravelController extends Controller
{
    private $productTable;
    private $connectionType;

    public function __construct()
    {
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
        $this->productTable = getProductTable($site->technology) ?? 'products';
        $this->categoryTable = $site->category_table ?? 'categories';
        $this->connectionType = 'dynamic';
    }

    public function randomProducts(Request $request)
    {
        $site_id = $request->get('site_id');
        $invoiceAmount = floatval($request->get('invoice_amount'));
        $priceFrom = $request->get('price_from');
        $priceTo = $request->get('price_to');
        $categoryId = $request->get('category_id');
        $noOfProducts = intval($request->get('noOfProducts'));
    
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);
    
        $query = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'category_id', 'name', 'unit_price', 'slug')
            ->where('published', 1);
    
        if ($priceFrom && $priceTo) {
            $query->whereBetween('unit_price', [$priceFrom, $priceTo]);
        }
    
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
    
        $products = $query->get();
    
        if ($products->isEmpty()) {
            session()->forget('ready_products');
            session()->forget('current_amount');
    
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No products found in this range or category.'
            ]);
        }
    
        $bestMatch = $this->findBestProductCombination($products, $invoiceAmount, $noOfProducts);
    
        $bestMatch = collect($bestMatch['products']);
        $bestTotal = $bestMatch->sum('unit_price');
    
        $categoryIds = $bestMatch->pluck('category_id')->unique();
        $categories = DB::connection($this->connectionType)
            ->table('categories')
            ->whereIn('id', $categoryIds)
            ->pluck('name', 'id');
    
        $bestMatch->each(function ($product) use ($categories) {
            $product->category_name = $categories[$product->category_id] ?? 'unknown';
        });
    
        $productIds = $bestMatch->pluck('id')->unique();
        $priceHistories = ProductPriceHistory::where('site_id', $site_id)
            ->whereIn('product_id', $productIds)
            ->orderByDesc('last_price_changed')
            ->get()
            ->groupBy('product_id');
    
        $now = now();
        $bestMatch->each(function ($product) use ($priceHistories, $now) {
            $history = $priceHistories[$product->id][0] ?? null;
            if ($history) {
                $lastChanged = Carbon::parse($history->last_price_changed);
                $nextChange = $lastChanged->copy()->addMonths(3);
                $daysLeft = $now->diffInDays($nextChange, false);
                $product->remaining_days = max($daysLeft, 0);
                $product->can_edit_price = $now->greaterThanOrEqualTo($nextChange) ? 1 : 0;
            } else {
                $product->remaining_days = 0;
                $product->can_edit_price = 1;
            }
        });
    
        $productList = $bestMatch->map(fn($p) => ['id' => $p->id, 'unit_price' => $p->unit_price])->toArray();
        session()->forget('ready_products');
        session()->put('ready_products', $productList);
        session(['current_amount' => $bestTotal]);
    
        $modelType = $site->businessModel->model_type;
        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $bestMatch,
            'site' => $site,
            'total' => $bestTotal
        ])->render();
    
        return response()->json([
            'tableRows' => $tableRows,
            'total' => $bestTotal
        ]);
    }
    
    private function findBestProductCombination($products, $targetAmount, $requiredCount = null)
    {
        $productArray = $products->values()->all();
        $productCount = count($productArray);
    
        if ($requiredCount) {
            return $this->findExactCountOptimized($productArray, $targetAmount, $requiredCount, $productCount);
        } else {
            return $this->findFlexibleOptimized($productArray, $targetAmount, $productCount);
        }
    }
    
    private function findExactCountOptimized($products, $target, $count, $totalProducts)
    {
        if ($totalProducts < $count) {
            return ['products' => $products, 'total' => array_sum(array_column($products, 'unit_price'))];
        }
    
        $priceMap = [];
        foreach ($products as $idx => $product) {
            $price = floatval($product->unit_price);
            $priceMap[$idx] = $price;
        }
    
        asort($priceMap);
        $sortedIndices = array_keys($priceMap);
    
        $bestMatch = null;
        $bestTotal = PHP_INT_MAX;
        $attempts = min(100, $totalProducts);
    
        for ($i = 0; $i < $attempts; $i++) {
            $selectedIndices = [];
            $usedIndices = [];
            $availableIndices = $sortedIndices;
            
            shuffle($availableIndices);
            
            foreach ($availableIndices as $idx) {
                if (count($selectedIndices) >= $count) {
                    break;
                }
                if (!in_array($idx, $usedIndices)) {
                    $selectedIndices[] = $idx;
                    $usedIndices[] = $idx;
                }
            }
    
            if (count($selectedIndices) < $count) {
                continue;
            }
    
            $total = 0;
            foreach ($selectedIndices as $idx) {
                $total += $priceMap[$idx];
            }
    
            if ($total >= $target && $total < $bestTotal) {
                $bestMatch = $selectedIndices;
                $bestTotal = $total;
            }
        }
    
        if (!$bestMatch) {
            $avgPrice = $target / $count;
            $remaining = $target;
            $selected = [];
            $usedIndices = [];
    
            for ($i = 0; $i < $count; $i++) {
                $remainingSlots = $count - $i;
                $idealPrice = $remaining / $remainingSlots;
                $closestIdx = null;
                $closestDiff = PHP_INT_MAX;
    
                foreach ($sortedIndices as $idx) {
                    if (in_array($idx, $usedIndices)) continue;
                    
                    $diff = abs($priceMap[$idx] - $idealPrice);
                    if ($diff < $closestDiff) {
                        $closestDiff = $diff;
                        $closestIdx = $idx;
                    }
                }
    
                if ($closestIdx !== null) {
                    $selected[] = $closestIdx;
                    $usedIndices[] = $closestIdx;
                    $remaining -= $priceMap[$closestIdx];
                }
            }
    
            if (count($selected) == $count) {
                $total = 0;
                foreach ($selected as $idx) {
                    $total += $priceMap[$idx];
                }
                
                if ($total >= $target) {
                    $bestMatch = $selected;
                    $bestTotal = $total;
                }
            }
        }
    
        if (!$bestMatch) {
            $highPriceIndices = array_slice(array_reverse($sortedIndices), 0, $count);
            $bestMatch = $highPriceIndices;
            $bestTotal = 0;
            foreach ($bestMatch as $idx) {
                $bestTotal += $priceMap[$idx];
            }
        }
    
        $result = [];
        foreach ($bestMatch as $idx) {
            $result[] = $products[$idx];
        }
    
        return ['products' => $result, 'total' => $bestTotal];
    }
    
    private function findFlexibleOptimized($products, $target, $totalProducts)
    {
        $priceMap = [];
        foreach ($products as $idx => $product) {
            $price = floatval($product->unit_price);
            $priceMap[$idx] = $price;
            
            if ($price >= $target && abs($price - $target) < 0.01) {
                return ['products' => [$product], 'total' => $price];
            }
        }
    
        asort($priceMap);
        $sortedIndices = array_keys($priceMap);
    
        $bestMatch = null;
        $bestTotal = 0;
        $bestDiff = PHP_INT_MAX;
    
        for ($attempt = 0; $attempt < 50; $attempt++) {
            $startIdx = rand(0, max(0, $totalProducts - 20));
            $subset = array_slice($sortedIndices, $startIdx, 20);
            shuffle($subset);
            
            $selected = [];
            $total = 0;
            $usedIndices = [];
    
            foreach ($subset as $idx) {
                if (in_array($idx, $usedIndices)) continue;
                
                $price = $priceMap[$idx];
                
                if ($total + $price > $target * 1.15) continue;
    
                $selected[] = $idx;
                $usedIndices[] = $idx;
                $total += $price;
    
                if ($total >= $target && abs($total - $target) < 0.01) {
                    $result = [];
                    foreach ($selected as $i) {
                        $result[] = $products[$i];
                    }
                    return ['products' => $result, 'total' => $total];
                }
            }
    
            if ($total >= $target) {
                $diff = abs($target - $total);
                if ($diff < $bestDiff) {
                    $bestMatch = $selected;
                    $bestTotal = $total;
                    $bestDiff = $diff;
                }
            }
        }
    
        if (!$bestMatch || $bestTotal < $target) {
            $maxTotal = $target * 1.15;
            
            for ($attempt = 0; $attempt < 50; $attempt++) {
                $startIdx = rand(0, max(0, $totalProducts - 25));
                $subset = array_slice($sortedIndices, $startIdx, 25);
                shuffle($subset);
                
                $selected = [];
                $total = 0;
                $usedIndices = [];
    
                foreach ($subset as $idx) {
                    if (in_array($idx, $usedIndices)) continue;
                    
                    $price = $priceMap[$idx];
                    
                    if ($total + $price > $maxTotal) continue;
    
                    $selected[] = $idx;
                    $usedIndices[] = $idx;
                    $total += $price;
                }
    
                if ($total >= $target && $total <= $maxTotal) {
                    $diff = $total - $target;
                    if (!$bestMatch || $diff < $bestDiff) {
                        $bestMatch = $selected;
                        $bestTotal = $total;
                        $bestDiff = $diff;
                    }
                }
            }
        }
    
        if (!$bestMatch || $bestTotal < $target) {
            arsort($priceMap);
            $highestPriceIndices = array_keys($priceMap);
            
            $selected = [];
            $total = 0;
            
            foreach ($highestPriceIndices as $idx) {
                $selected[] = $idx;
                $total += $priceMap[$idx];
                
                if ($total >= $target) {
                    $bestMatch = $selected;
                    $bestTotal = $total;
                    break;
                }
            }
        }
    
        if (!$bestMatch) {
            $bestMatch = [$sortedIndices[count($sortedIndices) - 1]];
            $bestTotal = $priceMap[$sortedIndices[count($sortedIndices) - 1]];
        }
    
        $result = [];
        foreach ($bestMatch as $idx) {
            $result[] = $products[$idx];
        }
        return ['products' => $result, 'total' => $bestTotal];
    }
    

    public function addProducts(Request $request)
    {
        $site_id = $request->get('site_id');
        $productsData = $request->get('products');

        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $readyProducts = session()->get('ready_products', []);

        foreach ($productsData as $productData) {
            $productId = $productData['product_id'];
            $unitPrice = floatval($productData['unit_price']);

            $exists = false;
            foreach ($readyProducts as &$item) {
                if ($item['id'] == $productId) {
                    $item['unit_price'] = $unitPrice;
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {
                $readyProducts[] = [
                    'id' => $productId,
                    'unit_price' => $unitPrice,
                ];
            }
        }

        session()->put('ready_products', $readyProducts);

        $productIds = collect($readyProducts)->pluck('id')->reverse()->values()->toArray();

        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'category_id', 'name', 'unit_price', 'slug')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $products = collect($productIds)->map(function ($id) use ($products) {
            return $products[$id];
        });

        $products = $products->map(function ($product) use ($readyProducts, $site_id) {
            $sessionProduct = collect($readyProducts)->firstWhere('id', $product->id);
            $product->unit_price = $sessionProduct['unit_price'] ?? $product->unit_price;
            $product->category_name = DB::connection($this->connectionType)->table('categories')->where('id', $product->category_id)->value('name') ?? 'unknown';

            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();

            if ($lastUpdate) {
                $lastPriceChanged = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = round(max($remainingDays, 0));
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
            }

            return $product;
        });
        $modelType = $site->businessModel->model_type;
        session(['current_amount' => collect($products)->sum('unit_price')]);

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $products,
            'site' => $site,
            'total' => collect($products)->sum('unit_price')
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total' => collect($products)->sum('unit_price')
        ]);
    }


    public function removeProduct(Request $request)
    {
        $productId = $request->get('product_id');
        $site_id = $request->get('site_id');
        $site = Website::findOrFail($site_id);

        $readyProducts = session('ready_products', []);

        $updatedProducts = collect($readyProducts)->filter(function ($product) use ($productId) {
            return $product['id'] != $productId;
        })->values()->toArray();

        session()->put('ready_products', $updatedProducts);
        if (empty($updatedProducts)) {
            
            session()->forget('current_amount');

            return response()->json([
                'tableRows' => '',
                'currency' => null,
            ]);
        }

        DynamicDatabaseService::connect($site);

        $productIds = array_column($updatedProducts, 'id');

        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'category_id', 'name', 'unit_price', 'slug')
            ->whereIn('id', $productIds)
            ->get();

        $products = $products->map(function ($product) use ($updatedProducts, $site_id) {
            $sessionProduct = collect($updatedProducts)->firstWhere('id', $product->id);
            $product->unit_price = $sessionProduct['unit_price'] ?? $product->unit_price;
            $product->category_name = DB::connection($this->connectionType)->table('categories')->where('id', $product->category_id)->value('name') ?? 'unknown';

            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();

            if ($lastUpdate) {
                $lastPriceChanged = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = round(max($remainingDays, 0));
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
            }

            return $product;
        });

        $modelType = $site->businessModel->model_type;
        session(['current_amount' => collect($products)->sum('unit_price')]);
        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $products,
            'site' => $site,
            'total' => collect($products)->sum('unit_price')
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total' => collect($products)->sum('unit_price')
        ]);
    }

    public function updateProduct(Request $request)
    {
        $productId = $request->get('product_id');
        $quantity = $request->get('quantity');
        $site_id = $request->get('site_id');

        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $readyProducts = session()->get('ready_products', []);

        foreach ($readyProducts as &$product) {
            if ($product['id'] == $productId) {
                $product['quantity'] = $quantity;
                break;
            }
        }
        session()->put('ready_products', $readyProducts);

        $productIds = collect($readyProducts)->pluck('id')->toArray();

        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'category_id', 'name', 'unit_price', 'slug')
            ->whereIn('id', $productIds)
            ->get();

        $products = $products->map(function ($product) use ($readyProducts, $site_id) {
            $sessionProduct = collect($readyProducts)->firstWhere('id', $product->id);
            $product->unit_price = $sessionProduct['unit_price'] ?? $product->unit_price;
            $product->quantity = $sessionProduct['quantity'] ?? 1;
            $product->category_name = DB::connection($this->connectionType)->table('categories')->where('id', $product->category_id)->value('name') ?? 'unknown';

            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();

            if ($lastUpdate) {
                $lastPriceChanged = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = round(max($remainingDays, 0));
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
            }

            return $product;
        });

        $modelType = $site->businessModel->model_type;

        $total = $products->sum(function ($product) {
            return $product->unit_price * ($product->quantity ?? 1);
        });

        session(['current_amount' => $total]);

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $products,
            'site' => $site,
            'total' => $total
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total' => $total
        ]);
    }


    public function clearProducts(Request $request)
    {
        session()->forget('ready_products');
        session()->forget('current_amount');
        return response()->json([
            'success' => true,
            'tableRows' => '',
            'currency' => null,
            'total' => 0
        ]);
    }

    public function filterProducts(Request $request)
    {
        $site_id = session('customer.site_id');
        $hasPriceRange = $request->filled('price_from') && $request->filled('price_to');
        $search_type = $request->input('search_type');
        $keyword = $request->input('keyword');
        $sortUnitPrice = $request->input('sort_unit_price', 'asc');
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        if (!$hasPriceRange) {
            return response()->json([
                'tableRows' => '<tr><td colspan="6" class="text-center text-muted">Please enter a price range to search.</td></tr>'
            ]);
        }

        $query = DB::connection($this->connectionType)
            ->table($this->productTable)
            ->select('products.id', 'products.category_id', 'products.name', 'products.unit_price', 'products.slug')
            ->where('products.published', 1);

        if ($hasPriceRange) {
            $query->whereBetween('unit_price', [
                (float) $request->price_from,
                (float) $request->price_to
            ]);
        }
        if (in_array($sortUnitPrice, ['asc', 'desc'])) {
            $query->orderBy('unit_price', $sortUnitPrice);
        }

        if (!empty($keyword)) {
            $normalizedSearch = strtolower(str_replace(['-', '_', ' '], '', $keyword));

            $query->where(function ($q) use ($normalizedSearch) {
                $q->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(products.name, '-', ''), '_', ''), ' ', '')) LIKE ?", ["%{$normalizedSearch}%"]);

                $q->orWhereIn('products.category_id', function ($sub) use ($normalizedSearch) {
                    $sub->select('id')
                        ->from('categories')
                        ->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(name, '-', ''), '_', ''), ' ', '')) LIKE ?", ["%{$normalizedSearch}%"]);
                });
            });
        }

        $readyProducts = session('ready_products', []);
        $readyProductIds = collect($readyProducts)->pluck('id')->toArray();

        if (count($readyProductIds) > 0) {
            $query->whereNotIn('products.id', $readyProductIds);
        }

        $totalCount = $query->count();
        $page = $request->input('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $products = $query->skip($offset)->take($perPage)->get();
        $totalPages = ceil($totalCount / $perPage);
        $paginationPages = $this->smartPagination($page, $totalPages);

        if ($products->isEmpty()) {
            return response()->json([
                'tableRows' => '<tr><td colspan="7" class="text-center text-muted"> No results found. Try randomizing or use a different keyword.</td></tr>'
            ]);
        }

        $products = collect($products);
        $products->each(function ($product) {
            $product->category_name = DB::connection($this->connectionType)->table('categories')->where('id', $product->category_id)->value('name') ?? 'unknown';
        });


        $products->each(function ($product) use ($site_id) {
            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();

            if ($lastUpdate) {
                $lastPriceChanged = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = round(max($remainingDays, 0));
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
            }
        });

        $modelType = $site->businessModel->model_type;
        $random_amount = session('current_amount', 0);

        $tableRows = view( "invoice.{$modelType}.add_product_rows", ['products' => $products, 'site' => $site,'random_amount' => $random_amount])->render();
        $paginationHtml = view("invoice.{$modelType}.pagination", ['totalPages' => $totalPages,'paginationPages' => $paginationPages, 'currentPage' => $page ])->render();

        return response()->json([ 'tableRows' => $tableRows,'paginationHtml' => $paginationHtml, 'random_amount' => $random_amount ,'currentPage' => $page ]);

    }

    private function smartPagination($currentPage, $totalPages)
    {
        $pages = [];
        $pages[] = 1;

        if ($currentPage > 4) {
            $pages[] = '...';
        }

        $start = max(2, $currentPage - 3);
        $end = min($totalPages - 1, $currentPage + 3);

        for ($i = $start; $i <= $end; $i++) {
            $pages[] = $i;
        }

        if ($currentPage < $totalPages - 3) {
            $pages[] = '...';
        }

        if ($totalPages > 1) {
            $pages[] = $totalPages;
        }

        return array_values(array_unique($pages));
    }



    public function generateInvoice(Request $request)
    {
        $site_id = $request->input('site_id');
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $invoice_data['site'] = $site;
        $invoice_data['site_id'] = $site->id;
        $invoice_data['invoice_number'] = $request->input('invoice_number');
        $invoice_data['invoice_date'] = Carbon::parse($request->input('invoice_date'))->format('F d, Y');
        $invoice_data['customer_name'] = $request->input('customer_name');
        $invoice_data['customer_mobile'] = $request->input('customer_mobile');
        $invoice_data['customer_email'] = $request->input('customer_email');
        $invoice_data['invoice_amount'] = $request->input('invoice_amount');
        $invoice_data['current_amount'] = $request->input('current_amount');
        $invoice_data['discount_amount'] = $request->input('discount_amount');
        $invoice_data['currency'] = site_currency();
        $invoice_data['invoice_template'] = $site->invoice_template;
        $invoice_data['model_type'] = $site->businessModel->model_type;

        $company_detail_type = $request->input('company_detail_type');

        if ($company_detail_type === 'remote') {

            $invoice_data['site_name']          = $request->input('remote_site_name') ?? '';
            $invoice_data['company_name']       = $request->input('remote_company_name') ?? '';
            $invoice_data['company_email']      = $request->input('remote_company_email') ?? '';
            $invoice_data['company_mobile']     = $request->input('remote_company_mobile') ?? '';
            $invoice_data['company_address']    = $request->input('remote_company_address') ?? '';
            $invoice_data['registration_number'] = $request->input('remote_registration_number') ?? '';
            $invoice_data['license_number']      = $request->input('remote_license_number') ?? '';
        
            $remote_database = DB::connection($this->connectionType)->table('general_settings')->orderByDesc('updated_at')->first();
        
            if ($remote_database) {
                DB::connection($this->connectionType)->table('general_settings')->where('id', $remote_database->id)
                    ->update([
                        'site_name'            => $request->input('remote_site_name') ?? '',
                        //'company_name'        => $request->input('remote_company_name') ?? '',
                        'email'                => $request->input('remote_company_email') ?? '',
                        'phone'                => $request->input('remote_company_mobile') ?? '',
                        'address'              => $request->input('remote_company_address') ?? '',
                       // 'registration_number'  => $request->input('remote_registration_number') ?? '',
                       // 'license_number'       => $request->input('remote_license_number') ?? '',
                        'updated_at'           => now(),
                    ]);
            }
        
        } else {
        
            $invoice_data['site_name']          = $request->input('local_site_name') ?? '';
            $invoice_data['company_name']       = $request->input('local_company_name') ?? '';
            $invoice_data['company_email']      = $request->input('local_company_email') ?? '';
            $invoice_data['company_mobile']     = $request->input('local_company_mobile') ?? '';
            $invoice_data['company_address']    = $request->input('local_company_address') ?? '';
            $invoice_data['registration_number'] = $request->input('registration_number') ?? '';
            $invoice_data['license_number']      = $request->input('license_number') ?? '';
        
            $site->site_name          = $invoice_data['site_name'];
            $site->company_name       = $invoice_data['company_name'];
            $site->company_email      = $invoice_data['company_email'];
            $site->company_mobile     = $invoice_data['company_mobile'];
            $site->company_address    = $invoice_data['company_address'];
            $site->registration_number = $invoice_data['registration_number'];
            $site->license_number      = $invoice_data['license_number'];
        
            $site->save();
        }

        $invoice_data['invoice_header_image'] = base64EncodeImage($site->invoice_header_image);
        $invoice_data['invoice_footer_image'] = base64EncodeImage($site->invoice_footer_image);
        $invoice_data['invoice_signature'] = base64EncodeImage($site->invoice_signature);
        $invoice_data['company_logo'] = base64EncodeImage($site->company_logo);
        $invoice_data['invoice_image1'] = base64EncodeImage($site->invoice_image1);
        $invoice_data['invoice_image2'] = base64EncodeImage($site->invoice_image2);
        $invoice_data['invoice_image3'] = base64EncodeImage($site->invoice_image3);
        $invoice_data['invoice_image4'] = base64EncodeImage($site->invoice_image4);
        $invoice_data['invoice_image5'] = base64EncodeImage($site->invoice_image5);
        $invoice_data['invoice_image6'] = base64EncodeImage($site->invoice_image6);
        $invoice_data['invoice_image7'] = base64EncodeImage($site->invoice_image7);
        $invoice_data['invoice_image8'] = base64EncodeImage($site->invoice_image8);
        $invoice_data['invoice_image9'] = base64EncodeImage($site->invoice_image9);

        $productDataArray = $request->input('product_data', []);
        $productIds = [];
        $customPrices = [];

        foreach ($productDataArray as $item) {
            $data = json_decode($item, true);
            if (!empty($data['product_id'])) {
                $productIds[] = $data['product_id'];
                $customPrices[$data['product_id']] = $data['unit_price'];
            }
        }

        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->whereIn('id', $productIds)
            ->select('id', 'category_id', 'name', 'description', 'unit_price')
            ->get()
            ->sortBy(function ($product) use ($productIds) {
                return array_search($product->id, $productIds);
            })
            ->values()
            ->map(function ($product) use ($customPrices) {
                $product->unit_price = $customPrices[$product->id] ?? $product->unit_price;
                return $product;
            });

        $products->each(function ($product) {
            $product->category_name = DB::connection($this->connectionType)
                ->table('categories')
                ->where('id', $product->category_id)
                ->value('name') ?? 'unknown';
        });

        $invoice_data['products'] = $products;
        $invoice_data['product_ids'] = $productIds;

        $this->updateProductPrice($productDataArray);
        InvoiceController::createInvoiceHistory($invoice_data);

        $modelType = strtolower($site->businessModel->model_type);
        $siteIdInWords = numberToWords($site->id);
        $viewPath = "websites.{$modelType}.{$siteIdInWords}";

        $filename = $request->filled('invoice_file_name')
            ? $request->input('invoice_file_name') . '.pdf'
            : $invoice_data['invoice_number'] . '.pdf';
    
            $filename = $request->filled('invoice_file_name')
            ? $request->input('invoice_file_name') . '.pdf'
            : $invoice_data['invoice_number'] . '.pdf';
            
            try {
                return $this->generateWithApi2Pdf($site, $viewPath, $invoice_data, $filename);

            } catch (\Exception $e) {
                // Fallback to Dompdf if API2PDF fails
                return $this->generateWithDompdf($site, $viewPath, $invoice_data, $filename);
            }
    
    }

    protected function generateWithApi2Pdf($site, $viewPath, $invoice_data, $filename)
    {
        $html = View::make($viewPath, $invoice_data)->render();

        $response = Http::withHeaders([
            'Authorization' => env('API2PDF_KEY')
        ])->post('https://v2.api2pdf.com/chrome/html', [
            'html' => $html,
            'fileName' => $filename,
            'options' => [
                'format' => $site->pdf_size ?? 'A4',
                'landscape' => ($site->pdf_orientation ?? 'portrait') === 'landscape',
                'marginTop' => '0mm',
                'marginBottom' => '0mm',
                'marginLeft' => '0mm',
                'marginRight' => '0mm',
                'disableSmartShrinking' => true,
                'zoom' => 1,
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

    protected function generateWithDompdf($site, $viewPath, $invoice_data, $filename)
    {
        $pdf = \PDF::loadView($viewPath, $invoice_data)->setPaper($site->pdf_size ?? 'A4', $site->pdf_orientation ?? 'portrait');
        return $pdf->download($filename);
    }

    protected function updateProductPrice(array $productDataArray)
    {
        $site_id = session('customer.site_id');

        foreach ($productDataArray as $item) {
            $data = json_decode($item, true);

            if (!empty($data['product_id']) && isset($data['unit_price'])) {
                $product_id = $data['product_id'];
                $new_price = floatval($data['unit_price']);

                $product = DB::connection($this->connectionType)
                    ->table($this->productTable)
                    ->where('id', $product_id)
                    ->first();

                if (!$product) continue;

                $current_price = floatval($product->unit_price);


                if ($current_price == $new_price) continue;


                $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                    ->where('product_id', $product_id)
                    ->orderByDesc('last_price_changed')
                    ->first();

                if (!$lastUpdate) {
                    DB::connection($this->connectionType)
                        ->table($this->productTable)
                        ->where('id', $product_id)
                        ->update(['unit_price' => $new_price]);

                    ProductPriceHistory::create([
                        'site_id' => $site_id,
                        'product_id' => $product_id,
                        'unit_price' => $new_price,
                        'last_price_changed' => now(),
                    ]);
                    continue;
                }

                if (Carbon::parse($lastUpdate->last_price_changed)->diffInMonths(now()) >= 3) {
                    DB::connection($this->connectionType)
                        ->table($this->productTable)
                        ->where('id', $product_id)
                        ->update(['unit_price' => $new_price]);

                    ProductPriceHistory::create([
                        'site_id' => $site_id,
                        'product_id' => $product_id,
                        'unit_price' => $new_price,
                        'last_price_changed' => now(),
                    ]);
                }
            }
        }
    }


}
