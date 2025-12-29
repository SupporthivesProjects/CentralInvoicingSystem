<?php
namespace App\Http\Controllers\BusinessModels\GiftCard;

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


class WordPressController extends Controller
{
   
    private $productTable;
    private $productPriceTable;
    private $tagsTable;
    private $categoryTable;
    private $termTaxonomyTable;
    private $connectionType;
    private $site;

    public function __construct()
    {
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
        $this->productTable = $site->product_table ?? 'wp_posts';
        $this->productPriceTable = $site->product_price_table ?? 'wp_wc_product_meta_lookup';
        $this->tagsTable = $site->tags_table ?? 'wp_term_relationships';
        $this->termTaxonomyTable = $site->term_taxonomy_table ?? 'wp_term_taxonomy';
        $this->categoryTable = $site->category_table ?? 'wp_terms';
        $this->connectionType = 'dynamic';
    }

    public function randomProducts(Request $request)
    {
        $site_id = $request->get('site_id') ?? session('customer.site_id');
        $invoiceAmount = floatval($request->get('invoice_amount'));
        $priceFrom = $request->get('price_from');
        $priceTo = $request->get('price_to');
        $noOfProducts = intval($request->get('noOfProducts'));
        $categoryId = $request->get('category_name');
    
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);
        $connection = $this->connectionType;
    
        $postsTable = $this->productTable;
        $priceTable = $this->productPriceTable;
    
        $query = DB::connection($connection)
            ->table($postsTable)
            ->join($priceTable, "$postsTable.ID", '=', "$priceTable.product_id")
            ->select(
                "$postsTable.ID as id",
                "$priceTable.product_id as variation_id",
                "$postsTable.post_title as name",
                "$postsTable.post_excerpt as description",
                "$postsTable.post_name as slug",
                "$priceTable.min_price as unit_price"
            )
            ->where("$postsTable.post_status", 'publish')
            ->where("$postsTable.post_type", 'product')
            ->where("$priceTable.min_price", '>', 0);
    
        if ($priceFrom && $priceTo) {
            $query->whereBetween("$priceTable.min_price", [$priceFrom, $priceTo]);
        }
    
        if (!empty($categoryId)) {
            $query->join($this->tagsTable . ' as tr', "$postsTable.ID", '=', 'tr.object_id')
                  ->join($this->termTaxonomyTable . ' as tt', 'tr.term_taxonomy_id', '=', 'tt.term_taxonomy_id')
                  ->where('tt.taxonomy', 'product_cat')
                  ->where('tt.term_id', $categoryId);
        }
    
        $fetchLimit = $noOfProducts ? ($noOfProducts * 50) : 500;
        $allProducts = $query->orderByDesc("$priceTable.min_price")->limit($fetchLimit)->get();
    
        if ($allProducts->isEmpty()) {
            session()->forget('ready_products');
            session()->forget('current_amount');
            session()->forget('last_used_combinations');
    
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No products found in this range or category.'
            ]);
        }
    
        $lastUsedCombinations = session()->get('last_used_combinations', []);
    
        $bestMatch = $this->findBestProductCombination($allProducts, $invoiceAmount, $noOfProducts, $lastUsedCombinations);
    
        if (!$bestMatch || empty($bestMatch['products'])) {
            session()->forget('ready_products');
            session()->forget('current_amount');
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No matching combination found, try again please'
            ]);
        }
    
        $bestMatch = collect($bestMatch['products']);
        $bestTotal = $bestMatch->sum('unit_price');
    
        $combinationKey = $bestMatch->pluck('id')->sort()->join('-');
        $lastUsedCombinations[] = $combinationKey;
        $lastUsedCombinations = array_slice($lastUsedCombinations, -5);
        session()->put('last_used_combinations', $lastUsedCombinations);
    
        $bestMatch->each(function ($product) use ($site_id) {
            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();
    
            if ($lastUpdate) {
                $lastChanged = Carbon::parse($lastUpdate->last_price_changed);
                $nextChange = $lastChanged->copy()->addMonths(3);
                $daysLeft = now()->diffInDays($nextChange, false);
                $product->remaining_days = max($daysLeft, 0);
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextChange) ? 1 : 0;
            } else {
                $product->remaining_days = 0;
                $product->can_edit_price = 1;
            }
    
            $product->rrp = $product->unit_price;
            $product->discount = 0;
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
    
    private function findBestProductCombination($products, $targetAmount, $requiredCount = null, $lastUsedCombinations = [])
    {
        $productArray = $products->shuffle()->values()->all();
        $productCount = count($productArray);
    
        if ($requiredCount) {
            return $this->findExactCountOptimized($productArray, $targetAmount, $requiredCount, $productCount, $lastUsedCombinations);
        } else {
            return $this->findFlexibleOptimized($productArray, $targetAmount, $productCount, $lastUsedCombinations);
        }
    }
    
    private function findExactCountOptimized($products, $target, $count, $totalProducts, $lastUsedCombinations = [])
    {
        shuffle($products);
    
        if ($totalProducts < $count) {
            return ['products' => $products, 'total' => array_sum(array_column($products, 'unit_price'))];
        }
    
        $priceMap = [];
        foreach ($products as $idx => $product) {
            $priceMap[$idx] = floatval($product->unit_price);
        }
    
        asort($priceMap);
        $sortedIndices = array_keys($priceMap);
        shuffle($sortedIndices);
    
        if ($count <= 2) {
            $percentages = [0, 2, 5, 8, 10, 15, 20, 25, 30, 35, 40, 50];
            shuffle($percentages);
    
            foreach ($percentages as $percentage) {
                $minTarget = $target;
                $maxTarget = $target * (1 + $percentage / 100);
    
                if ($count == 1) {
                    $bestIdx = null;
                    $bestDiff = PHP_INT_MAX;
    
                    foreach ($sortedIndices as $idx) {
                        $price = $priceMap[$idx];
                        if ($price >= $minTarget && $price <= $maxTarget) {
                            $diff = abs($price - $target);
                            if ($diff < $bestDiff) {
                                $bestDiff = $diff;
                                $bestIdx = $idx;
                            }
                        }
                    }
    
                    if ($bestIdx !== null) {
                        if (!empty($lastUsedCombinations)) {
                            $currentCombo = (string)$products[$bestIdx]->id;
                            if (in_array($currentCombo, $lastUsedCombinations)) {
                                continue;
                            }
                        }
    
                        return ['products' => [$products[$bestIdx]], 'total' => $priceMap[$bestIdx]];
                    }
                } else if ($count == 2) {
                    if ($percentage > 0 && rand(0, 1) == 1) {
                        continue;
                    }
                    $bestPair = null;
                    $bestTotal = 0;
                    $bestDiff = PHP_INT_MAX;
    
                    for ($i = 0; $i < $totalProducts - 1; $i++) {
                        for ($j = $i + 1; $j < $totalProducts; $j++) {
                            $idx1 = $sortedIndices[$i];
                            $idx2 = $sortedIndices[$j];
    
                            $price1 = $priceMap[$idx1];
                            $price2 = $priceMap[$idx2];
    
                            if ($price1 == $price2) continue;
    
                            $total = $price1 + $price2;
    
                            if ($total >= $minTarget && $total <= $maxTarget) {
                                $diff = abs($total - $target);
                                if ($diff < $bestDiff) {
                                    $bestDiff = $diff;
                                    $bestPair = [$idx1, $idx2];
                                    $bestTotal = $total;
                                }
                            }
                        }
                    }
    
                    if ($bestPair !== null) {
                        if (!empty($lastUsedCombinations)) {
                            $comboIds = array_map(fn($i) => $products[$i]->id, $bestPair);
                            sort($comboIds);
                            $currentCombo = implode('-', $comboIds);
                            if (in_array($currentCombo, $lastUsedCombinations)) {
                                continue;
                            }
                        }
    
                        return [
                            'products' => [$products[$bestPair[0]], $products[$bestPair[1]]],
                            'total' => $bestTotal
                        ];
                    }
                }
            }
        }
    
        $percentages = [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
    
        foreach ($percentages as $percentage) {
            $minTarget = $target;
            $maxTarget = $target * (1 + $percentage / 100);
            $result = $this->tryFindExactCount($products, $priceMap, $sortedIndices, $minTarget, $maxTarget, $count, $totalProducts);
    
            if ($result !== null && $result['total'] >= $target && count($result['products']) === $count) {
                return $result;
            }
        }
    
        $avgPrice = $target / $count;
        $maxTotal = $target * 1.20;
        $bestMatch = null;
        $bestTotal = 0;
        $bestDiff = PHP_INT_MAX;
    
        for ($attempt = 0; $attempt < 200; $attempt++) {
            $shuffledIndices = $sortedIndices;
            shuffle($sortedIndices);
    
            $selected = [];
            $usedPrices = [];
            $total = 0;
    
            $startIdx = rand(0, max(0, $totalProducts - $count * 3));
            $searchWindow = array_slice($shuffledIndices, $startIdx, min($count * 5, $totalProducts));
    
            foreach ($searchWindow as $idx) {
                if (count($selected) >= $count) break;
    
                $price = $priceMap[$idx];
                if (isset($usedPrices[$price])) continue;
    
                if ($total + $price <= $maxTotal) {
                    $selected[] = $idx;
                    $usedPrices[$price] = true;
                    $total += $price;
                }
            }
    
            if (count($selected) === $count && $total >= $target && $total <= $maxTotal) {
                $diff = abs($total - $target);
                if ($diff < $bestDiff) {
                    $bestMatch = $selected;
                    $bestTotal = $total;
                    $bestDiff = $diff;
    
                    if ($diff <= $target * 0.02) {
                        break;
                    }
                }
            }
        }
    
        if ($bestMatch && count($bestMatch) === $count && $bestTotal >= $target) {
            $result = [];
            foreach ($bestMatch as $idx) {
                $result[] = $products[$idx];
            }
            return ['products' => $result, 'total' => $bestTotal];
        }
    
        $selected = [];
        $usedPrices = [];
        $remaining = $target;
    
        for ($i = 0; $i < $count; $i++) {
            $remainingSlots = $count - $i;
            $idealPrice = $remaining / $remainingSlots;
            $closestIdx = null;
            $closestDiff = PHP_INT_MAX;
    
            foreach ($sortedIndices as $idx) {
                if (in_array($idx, $selected)) continue;
    
                $price = $priceMap[$idx];
                if (isset($usedPrices[$price])) continue;
    
                $diff = abs($price - $idealPrice);
                if ($diff < $closestDiff) {
                    $closestDiff = $diff;
                    $closestIdx = $idx;
                }
            }
    
            if ($closestIdx !== null) {
                $selected[] = $closestIdx;
                $usedPrices[$priceMap[$closestIdx]] = true;
                $remaining -= $priceMap[$closestIdx];
            }
        }
    
        if (count($selected) === $count) {
            $total = array_sum(array_map(fn($idx) => $priceMap[$idx], $selected));
    
            if ($total < $target) {
                $reverseIndices = array_reverse($sortedIndices);
    
                foreach ($reverseIndices as $replaceIdx) {
                    if (in_array($replaceIdx, $selected)) continue;
    
                    $replacePrice = $priceMap[$replaceIdx];
                    if (isset($usedPrices[$replacePrice])) continue;
    
                    for ($i = 0; $i < $count; $i++) {
                        $currentIdx = $selected[$i];
                        $currentPrice = $priceMap[$currentIdx];
    
                        $newTotal = $total - $currentPrice + $replacePrice;
    
                        if ($newTotal >= $target && $newTotal <= $maxTotal) {
                            $selected[$i] = $replaceIdx;
                            unset($usedPrices[$currentPrice]);
                            $usedPrices[$replacePrice] = true;
                            $total = $newTotal;
                            break 2;
                        }
                    }
                }
            }
        }
    
        $result = [];
        foreach ($selected as $idx) {
            $result[] = $products[$idx];
        }
    
        return ['products' => $result, 'total' => array_sum(array_column($result, 'unit_price'))];
    }
    
    private function tryFindExactCount($products, $priceMap, $sortedIndices, $minTarget, $maxTarget, $count, $totalProducts)
    {
        $avgPrice = ($minTarget + $maxTarget) / 2 / $count;
    
        $midPoint = 0;
        foreach ($sortedIndices as $pos => $idx) {
            if ($priceMap[$idx] >= $avgPrice) {
                $midPoint = max(0, $pos - intval($count / 2));
                break;
            }
        }
    
        $windowSize = min($count * 4, $totalProducts - $midPoint);
        $searchWindow = array_slice($sortedIndices, $midPoint, $windowSize);
    
        if (count($searchWindow) < $count) {
            $searchWindow = $sortedIndices;
        }
    
        $attempts = min(100, count($searchWindow) * 3);
        $bestMatch = null;
        $bestTotal = 0;
        $bestDiff = PHP_INT_MAX;
    
        for ($i = 0; $i < $attempts; $i++) {
            $windowCopy = $searchWindow;
            shuffle($searchWindow);
            $candidatePool = array_slice($searchWindow, 0, min(count($searchWindow), $count * 3));
    
            $selectedIndices = [];
            $seenPrices = [];
    
            foreach ($candidatePool as $idx) {
                if (count($selectedIndices) >= $count) break;
    
                $price = $priceMap[$idx];
                if (!isset($seenPrices[$price])) {
                    $selectedIndices[] = $idx;
                    $seenPrices[$price] = true;
                }
            }
    
            if (count($selectedIndices) !== $count) {
                continue;
            }
    
            $total = array_sum(array_map(fn($idx) => $priceMap[$idx], $selectedIndices));
    
            if ($total >= $minTarget && $total <= $maxTarget) {
                $diff = abs($total - $minTarget);
                if ($diff < $bestDiff) {
                    $bestMatch = $selectedIndices;
                    $bestTotal = $total;
                    $bestDiff = $diff;
    
                    if ($total >= $minTarget && $total <= $minTarget * 1.02) {
                        break;
                    }
                }
            }
        }
    
        if ($bestMatch && count($bestMatch) === $count) {
            $result = [];
            foreach ($bestMatch as $idx) {
                $result[] = $products[$idx];
            }
            return ['products' => $result, 'total' => $bestTotal];
        }
    
        $result = $this->greedySelection($products, $priceMap, $sortedIndices, $minTarget, $maxTarget, $count, $searchWindow);
        if ($result !== null && count($result['products']) === $count) {
            return $result;
        }
    
        return null;
    }
    
    private function greedySelection($products, $priceMap, $sortedIndices, $minTarget, $maxTarget, $count, $searchWindow)
    {
        $windowSize = min(count($searchWindow), $count * 5);
        $expandedWindow = array_slice($sortedIndices, 0, max($windowSize, $count * 2));
    
        $remaining = $minTarget;
        $selected = [];
        $usedIndices = [];
        $usedPrices = [];
    
        for ($i = 0; $i < $count; $i++) {
            $remainingSlots = $count - $i;
            $idealPrice = $remaining / $remainingSlots;
            $closestIdx = null;
            $closestDiff = PHP_INT_MAX;
    
            foreach ($expandedWindow as $idx) {
                if (in_array($idx, $usedIndices)) continue;
    
                $price = $priceMap[$idx];
                if (isset($usedPrices[$price])) continue;
    
                $diff = abs($price - $idealPrice);
                if ($diff < $closestDiff) {
                    $closestDiff = $diff;
                    $closestIdx = $idx;
                }
            }
    
            if ($closestIdx !== null) {
                $selected[] = $closestIdx;
                $usedIndices[] = $closestIdx;
                $usedPrices[$priceMap[$closestIdx]] = true;
                $remaining -= $priceMap[$closestIdx];
            } else {
                break;
            }
        }
    
        if (count($selected) === $count) {
            $total = array_sum(array_map(fn($idx) => $priceMap[$idx], $selected));
    
            if ($total >= $minTarget && $total <= $maxTarget) {
                $result = [];
                foreach ($selected as $idx) {
                    $result[] = $products[$idx];
                }
                return ['products' => $result, 'total' => $total];
            }
        }
    
        return null;
    }
    
    private function findFlexibleOptimized($products, $target, $totalProducts, $lastUsedCombinations = [])
    {
        $priceMap = [];
        foreach ($products as $idx => $product) {
            $price = floatval($product->unit_price);
            $priceMap[$idx] = $price;
    
            if (abs($price - $target) < 0.01) {
                return ['products' => [$product], 'total' => $price];
            }
        }
    
        asort($priceMap);
        $sortedIndices = array_keys($priceMap);
        shuffle($sortedIndices);
    
        $percentages = [0, 2, 4, 6, 8, 10, 12, 14, 16];
    
        foreach ($percentages as $percentage) {
            $currentMax = $target * (1 + $percentage / 100);
            $result = $this->tryFindFlexible($products, $priceMap, $sortedIndices, $target, $currentMax, $totalProducts);
    
            if ($result !== null && $result['total'] >= $target) {
                if (!empty($lastUsedCombinations)) {
                    $resultIds = array_map(fn($p) => $p->id, $result['products']);
                    sort($resultIds);
                    $currentCombo = implode('-', $resultIds);
                    if (in_array($currentCombo, $lastUsedCombinations)) {
                        continue;
                    }
                }
    
                return $result;
            }
        }
    
        $maxTotal = $target * 1.15;
        $bestMatch = null;
        $bestTotal = 0;
    
        for ($attempt = 0; $attempt < 20; $attempt++) {
            $shuffledIndices = $sortedIndices;
            shuffle($shuffledIndices);
            $startIdx = rand(0, max(0, $totalProducts - 30));
            $subset = array_slice($sortedIndices, $startIdx, 30);
            shuffle($subset);
    
            $selected = [];
            $total = 0;
            $usedPrices = [];
    
            foreach ($subset as $idx) {
                $price = $priceMap[$idx];
    
                if (isset($usedPrices[$price])) continue;
                if ($total + $price > $maxTotal) continue;
    
                $selected[] = $idx;
                $usedPrices[$price] = true;
                $total += $price;
            }
    
            if ($total >= $target && $total <= $maxTotal && $total > $bestTotal) {
                $bestMatch = $selected;
                $bestTotal = $total;
            }
        }
    
        if ($bestMatch && $bestTotal >= $target) {
            $result = [];
            foreach ($bestMatch as $idx) {
                $result[] = $products[$idx];
            }
            return ['products' => $result, 'total' => $bestTotal];
        }
    
        $selected = [];
        $usedPrices = [];
        $total = 0;
    
        foreach (array_reverse($sortedIndices) as $idx) {
            $price = $priceMap[$idx];
    
            if (isset($usedPrices[$price])) continue;
            if ($total + $price > $maxTotal) continue;
    
            $selected[] = $idx;
            $usedPrices[$price] = true;
            $total += $price;
    
            if ($total >= $target) {
                break;
            }
        }
    
        if ($total >= $target && $total <= $maxTotal) {
            $result = [];
            foreach ($selected as $idx) {
                $result[] = $products[$idx];
            }
            return ['products' => $result, 'total' => $total];
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
    
    private function tryFindFlexible($products, $priceMap, $sortedIndices, $minTarget, $maxTarget, $totalProducts)
    {
        $bestMatch = null;
        $bestTotal = 0;
        $bestDiff = PHP_INT_MAX;
    
        for ($attempt = 0; $attempt < 25; $attempt++) {
            $startIdx = rand(0, max(0, $totalProducts - 25));
            $subset = array_slice($sortedIndices, $startIdx, 25);
            shuffle($subset);
    
            $selected = [];
            $total = 0;
            $usedPrices = [];
    
            foreach ($subset as $idx) {
                $price = $priceMap[$idx];
    
                if (isset($usedPrices[$price])) continue;
                if ($total + $price > $maxTarget) continue;
    
                $selected[] = $idx;
                $usedPrices[$price] = true;
                $total += $price;
    
                if ($total >= $minTarget && $total <= $maxTarget) {
                    $diff = abs($total - $minTarget);
                    if ($diff < $bestDiff) {
                        $bestMatch = $selected;
                        $bestTotal = $total;
                        $bestDiff = $diff;
                    }
                }
            }
    
            if ($total >= $minTarget && $total <= $maxTarget) {
                $diff = abs($total - $minTarget);
                if ($diff < $bestDiff) {
                    $bestMatch = $selected;
                    $bestTotal = $total;
                    $bestDiff = $diff;
                }
            }
        }
    
        if ($bestMatch && $bestTotal >= $minTarget) {
            $result = [];
            foreach ($bestMatch as $idx) {
                $result[] = $products[$idx];
            }
            return ['products' => $result, 'total' => $bestTotal];
        }
    
        return null;
    }
    


    public function addProducts(Request $request)
    {
        $site_id = $request->get('site_id') ?? session('customer.site_id');
        $productsData = $request->get('products', []);
    
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);
    
        $postsTable = $this->productTable;
        $priceTable = $this->productPriceTable;
        $connection = $this->connectionType;
    
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
    
        $products = DB::connection($connection)
            ->table($postsTable)
            ->join($priceTable, "$postsTable.ID", '=', "$priceTable.product_id")
            ->select(
                "$postsTable.ID as id",
                "$priceTable.product_id as variation_id",
                "$postsTable.post_title as name",
                "$postsTable.post_excerpt as description",
                "$postsTable.post_name as slug",
                "$priceTable.min_price as unit_price"
            )
            ->whereIn("$postsTable.ID", $productIds)
            ->where("$postsTable.post_status", 'publish')
            ->where("$postsTable.post_type", 'product')
            ->get()
            ->keyBy('id');
    
        $products = collect($productIds)->map(function ($id) use ($products) {
            return $products[$id] ?? null;
        })->filter();
    
        $products = $products->map(function ($product) use ($readyProducts, $site_id) {
            $sessionProduct = collect($readyProducts)->firstWhere('id', $product->id);
    
            $product->unit_price = $sessionProduct['unit_price'] ?? $product->unit_price;
            $product->category_name = '-';
    
            $lastUpdate = DB::table('product_price_histories')
                ->where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();
    
            if ($lastUpdate) {
                $lastPriceChanged = Carbon::parse($lastUpdate->last_price_changed);
                $nextChange = $lastPriceChanged->copy()->addMonths(3);
                $remaining = now()->diffInDays($nextChange, false);
                $product->remaining_days = round(max($remaining, 0));
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextChange) ? 1 : 0;
                $product->rrp = $product->unit_price;
                $product->discount = 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
                $product->rrp = $product->unit_price;
                $product->discount = 0;
            }
    
            return $product;
        });
    
        $total = $products->sum('unit_price');
        session(['current_amount' => $total]);
    
        $modelType = $site->businessModel->model_type;
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
    

    

    public function removeProduct(Request $request)
    {
        $productId = $request->get('product_id');
        $site_id = $request->get('site_id');
        $site = Website::findOrFail($site_id);
    
        $postsTable = $this->productTable;
        $priceTable = $this->productPriceTable;
        $connection = $this->connectionType;
    
        $readyProducts = session('ready_products', []);
    
        $updatedProducts = collect($readyProducts)->reject(fn($product) => $product['id'] == $productId)->values()->toArray();
        session()->put('ready_products', $updatedProducts);
    
        if (empty($updatedProducts)) {
            session()->forget('current_amount');
            return response()->json([
                'tableRows' => '',
                'total' => 0,
            ]);
        }
    
        DynamicDatabaseService::connect($site);
    
        $productIds = array_column($updatedProducts, 'id');
    
        $products = DB::connection($connection)
            ->table($postsTable)
            ->join($priceTable, "$postsTable.ID", '=', "$priceTable.product_id")
            ->select(
                "$postsTable.ID as id",
                "$priceTable.product_id as variation_id",
                "$postsTable.post_title as name",
                "$postsTable.post_excerpt as description",
                "$postsTable.post_name as slug",
                "$priceTable.min_price as unit_price"
            )
            ->whereIn("$postsTable.ID", $productIds)
            ->where("$postsTable.post_status", 'publish')
            ->where("$postsTable.post_type", 'product')
            ->get()
            ->keyBy('id');
    
        $products = collect($productIds)->map(fn($id) => $products[$id] ?? null)->filter();
    
        $products = $products->map(function ($product) use ($updatedProducts, $site_id) {
            $sessionProduct = collect($updatedProducts)->firstWhere('id', $product->id);
    
            $product->unit_price = $sessionProduct['unit_price'] ?? $product->unit_price;
            $product->category_name = '-';
    
            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();
    
            if ($lastUpdate) {
                $nextDate = Carbon::parse($lastUpdate->last_price_changed)->addMonths(3);
                $remaining = now()->diffInDays($nextDate, false);
                $product->remaining_days = max($remaining, 0);
                $product->can_edit_price = now()->gte($nextDate) ? 1 : 0;
                $product->rrp = $product->unit_price;
                $product->discount = 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
                $product->rrp = $product->unit_price;
                $product->discount = 0;
            }
    
            return $product;
        });
    
        $total = $products->sum('unit_price');
        session(['current_amount' => $total]);
    
        $modelType = $site->businessModel->model_type;
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

        $postsTable = $this->productTable;
        $priceTable = $this->productPriceTable;
        $connection = $this->connectionType;

        $products = DB::connection($connection)
            ->table($postsTable)
            ->join($priceTable, "$postsTable.ID", '=', "$priceTable.product_id")
            ->whereIn("$postsTable.ID", $productIds)
            ->select([
                "$postsTable.ID as id",
                "$priceTable.product_id as variation_id",
                "$postsTable.post_title as name",
                "$postsTable.post_excerpt as description",
                "$postsTable.post_name as slug",
                "$priceTable.min_price as unit_price"
            ])
            ->get();

        $products = $products->map(function ($product) use ($readyProducts, $site_id) {
            $sessionProduct = collect($readyProducts)->firstWhere('id', $product->id);
            $product->unit_price = $sessionProduct['unit_price'] ?? $product->unit_price;
            $product->quantity = $sessionProduct['quantity'] ?? 1;
            $product->category_name = '-';

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
                $product->rrp = $product->unit_price;
                $product->discount = 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
                $product->rrp = $product->unit_price;
                $product->discount = 0;
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
        $keyword = $request->input('keyword');
        $sortUnitPrice = $request->input('sort_unit_price', 'asc');

        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        if (!$hasPriceRange) {
            return response()->json([
                'tableRows' => '<tr><td colspan="6" class="text-center text-muted">Please enter a price range to search.</td></tr>'
            ]);
        }

        $postsTable = $this->productTable;
        $priceTable = $this->productPriceTable;
        $connection = $this->connectionType;

        $query = DB::connection($connection)
            ->table($postsTable)
            ->join($priceTable, "$postsTable.ID", '=', "$priceTable.product_id")
            ->select([
                "$postsTable.ID as id",
                "$priceTable.product_id as variation_id",
                "$postsTable.post_title as name",
                "$postsTable.post_excerpt as description",
                "$postsTable.post_name as slug",
                "$priceTable.min_price as unit_price"
            ])
            ->where("$postsTable.post_status", 'publish')
            ->where("$postsTable.post_type", 'product')
            ->where("$priceTable.min_price", '>', 0);

        $query->whereBetween("$priceTable.min_price", [
            (float) $request->price_from,
            (float) $request->price_to
        ]);

        if (in_array($sortUnitPrice, ['asc', 'desc'])) {
            $query->orderBy("$priceTable.min_price", $sortUnitPrice);
        }

        if (!empty($keyword)) {
            $normalizedSearch = strtolower(str_replace(['-', '_', ' '], '', $keyword));
            $query->whereRaw("LOWER(REPLACE(REPLACE(REPLACE($postsTable.post_title, '-', ''), '_', ''), ' ', '')) LIKE ?", ["%{$normalizedSearch}%"]);
        }

        $readyProducts = session('ready_products', []);
        $readyProductIds = collect($readyProducts)->pluck('id')->toArray();

        if (!empty($readyProductIds)) {
            $query->whereNotIn("$postsTable.ID", $readyProductIds);
        }

        $totalCount = $query->count();
        $page = $request->input('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;

        $products = $query->skip($offset)->take($perPage)->get();

        if ($products->isEmpty()) {
            return response()->json([
                'tableRows' => '<tr><td colspan="7" class="text-center text-muted">No results found. Try randomizing or use a different keyword.</td></tr>'
            ]);
        }

        $products = $products->map(function ($product) use ($site_id) {
            $product->category_name = '-';

            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();

            if ($lastUpdate) {
                $lastPriceChanged = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = max($remainingDays, 0);
                $product->can_edit_price = now()->gte($nextPriceChangeDate) ? 1 : 0;
                $product->rrp = $product->unit_price;
                $product->discount = 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
                $product->rrp = $product->unit_price;
                $product->discount = 0;
            }

            return $product;
        });

        $totalPages = ceil($totalCount / $perPage);
        $paginationPages = $this->smartPagination($page, $totalPages);
        $modelType = $site->businessModel->model_type;
        $random_amount = session('current_amount', 0);

        $tableRows = view("invoice.{$modelType}.add_product_rows", [
            'products' => $products,
            'site' => $site,
            'random_amount' => $random_amount
        ])->render();

        $paginationHtml = view("invoice.{$modelType}.pagination", [
            'totalPages' => $totalPages,
            'paginationPages' => $paginationPages,
            'currentPage' => $page
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'paginationHtml' => $paginationHtml,
            'random_amount' => $random_amount,
            'currentPage' => $page
        ]);
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

    $postsTable = $this->productTable;
    $priceTable = $this->productPriceTable;
    $connection = $this->connectionType;

    $products = DB::connection($connection)
        ->table($postsTable)
        ->join($priceTable, "$postsTable.ID", '=', "$priceTable.product_id")
        ->whereIn("$postsTable.ID", $productIds)
        ->select([
            "$postsTable.ID as id",
            "$priceTable.product_id as variation_id",
            "$postsTable.post_title as name",
            "$postsTable.post_excerpt as description",
            "$postsTable.post_name as slug",
            "$priceTable.min_price as unit_price"
        ])
        ->get()
        ->sortBy(function ($product) use ($productIds) {
            return array_search($product->id, $productIds);
        })
        ->values()
        ->map(function ($product) use ($customPrices) {
            $product->unit_price = $customPrices[$product->id] ?? $product->unit_price;
            $product->category_name = '-';
            $product->rrp = $product->unit_price;
            $product->discount = 0;
            return $product;
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
        $site = Website::findOrFail($site_id);
        $postsTable = $this->productTable;
        $priceTable = $this->productPriceTable;
        $connection = $this->connectionType;
    
        $updatedProducts = [];
        $errors = [];
    
        $consumerKey = $site->consumer_key;
        $consumerSecret = $site->consumer_secret;
        $baseUrl = rtrim($site->site_link, '/');
        $endpoint = $baseUrl . '/wp-json/wc/v3/products';
    
        if (!$consumerKey || !$consumerSecret) {
            \Log::error('API_CRED_MISSING', ['site_id' => $site_id]);
            throw new \Exception('WooCommerce API credentials not configured');
        }
    
        foreach ($productDataArray as $item) {
            $data = json_decode($item, true);
    
            if (!isset($data['product_id'], $data['unit_price'])) {
                $errors[] = ['reason' => 'Missing product_id or unit_price'];
                continue;
            }
    
            $product_id = (int) $data['product_id'];
            $unit_price = floatval($data['unit_price']);
    
            if ($product_id <= 0) {
                \Log::error('INVALID_PRODUCT_ID', ['product_id' => $product_id]);
                $errors[] = ['product_id' => $product_id, 'reason' => 'Invalid product ID'];
                continue;
            }
    
            try {
                $product = DB::connection($connection)
                    ->table($postsTable)
                    ->join($priceTable, "$postsTable.ID", '=', "$priceTable.product_id")
                    ->select(
                        "$postsTable.ID as id",
                        "$postsTable.post_parent as parent_id",
                        "$postsTable.post_type as post_type",
                        "$postsTable.post_title as name",
                        "$priceTable.min_price as current_price"
                    )
                    ->where("$postsTable.ID", $product_id)
                    ->where("$postsTable.post_status", 'publish')
                    ->first();
    
                if (!$product) {
                    \Log::error('PRODUCT_NOT_FOUND', ['product_id' => $product_id]);
                    $errors[] = ['product_id' => $product_id, 'reason' => 'Product not found'];
                    continue;
                }
    
                $current_price = floatval($product->current_price);
    
                if (abs($current_price - $unit_price) < 0.01) {
                    continue;
                }
    
                $api_product_id = $product->parent_id > 0 ? $product->parent_id : $product->id;
                $variation_id = $product->post_type === 'product_variation' ? $product->id : 0;
    
                $variationEndpoint = $endpoint . '/' . $api_product_id;
    
                if ($variation_id > 0) {
                    $variationEndpoint .= '/variations/' . $variation_id;
                }
    
                $updatePayload = [
                    'regular_price' => (string) number_format($unit_price, 2, '.', ''),
                    'sale_price' => ''
                ];
    
                $updateResponse = Http::withBasicAuth($consumerKey, $consumerSecret)
                    ->timeout(30)
                    ->retry(2, 100)
                    ->put($variationEndpoint, $updatePayload);
    
                if ($updateResponse->failed()) {
                    $statusCode = $updateResponse->status();
                    \Log::error('UPDATE_FAILED', [
                        'product_id' => $api_product_id,
                        'variation_id' => $variation_id,
                        'status' => $statusCode
                    ]);
                    $errors[] = ['product_id' => $product_id, 'reason' => 'API update failed'];
                    continue;
                }
    
                $updated = $updateResponse->json();
                $verifiedPrice = (float) ($updated['regular_price'] ?? $updated['price'] ?? 0);
    
                if (abs($verifiedPrice - $unit_price) > 0.01) {
                    \Log::error('PRICE_VERIFY_FAIL', [
                        'product_id' => $api_product_id,
                        'variation_id' => $variation_id,
                        'expected' => $unit_price,
                        'actual' => $verifiedPrice
                    ]);
                    $errors[] = ['product_id' => $product_id, 'reason' => 'Price mismatch'];
                    continue;
                }
    
                ProductPriceHistory::create([
                    'site_id' => $site_id,
                    'product_id' => $api_product_id,
                    'variation_id' => $variation_id,
                    'unit_price' => $unit_price,
                    'last_price_changed' => now(),
                ]);
    
                $updatedProducts[] = [
                    'product_id' => $api_product_id,
                    'variation_id' => $variation_id,
                    'old_price' => $current_price,
                    'new_price' => $unit_price
                ];
    
            } catch (\Exception $e) {
                \Log::error('UPDATE_EXCEPTION', [
                    'product_id' => $product_id,
                    'error' => $e->getMessage()
                ]);
                $errors[] = ['product_id' => $product_id, 'error' => $e->getMessage()];
            }
        }
    
        return [
            'success' => count($errors) === 0,
            'updated_products' => $updatedProducts,
            'errors' => $errors,
            'summary' => [
                'updated' => count($updatedProducts),
                'failed' => count($errors)
            ]
        ];
    }
}