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
use Illuminate\Support\Facades\Schema;


class LaravelController extends Controller
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

    public function randomProducts(Request $request)
    {
        $site_id = $request->get('site_id');
        $invoiceAmount = floatval($request->get('invoice_amount'));
        $priceFrom = $request->get('price_from');
        $priceTo = $request->get('price_to');
        $categoryName = $request->get('category_name');
        $noOfProducts = $request->get('noOfProducts') ? intval($request->get('noOfProducts')) : null;
    
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);
    
        $siteCurrency = site_currency_code();
    
        $query = DB::connection($this->connectionType)
            ->table($this->productTable . ' as p')
            ->leftJoin('conversion_rates as cr', function ($join) use ($siteCurrency) {
                $join->on('p.card_currency', '=', 'cr.from_currency')
                    ->where('cr.to_currency', '=', $siteCurrency);
            })
            ->select(
                'p.id',
                'p.name',
                'p.slug',
                'p.category_id',
                'p.card_currency',
                DB::raw('ROUND(p.rrp * IFNULL(cr.rate, 1), 2) as rrp'),
                'p.discount',
                DB::raw('ROUND(p.unit_price * IFNULL(cr.rate, 1), 2) as unit_price'),
                'p.current_stock',
                DB::raw('ROUND(1 / IFNULL(cr.rate, 1), 5) as reverse_rate')
            )
            ->where('p.published', 1);
    
        $subQuery = DB::connection($this->connectionType)->table(DB::raw("({$query->toSql()}) as derived"))->mergeBindings($query);
    
        if ($priceFrom && $priceTo) {
            $subQuery->whereBetween('unit_price', [$priceFrom, $priceTo]);
        }
    
        if (!empty($categoryName)) {
            $normalized = strtolower(str_replace(['-', '_', ' ', ','], '', $categoryName));
            $subQuery->whereIn('category_id', function ($sub) use ($normalized) {
                $sub->select('id')
                    ->from('categories')
                    ->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(REPLACE(tags, '-', ''), '_', ''), ' ', ''), ',', '')) LIKE ?", ["%{$normalized}%"]);
            });
        }
    
        $bestMatch = null;
        $bestTotal = 0;
    
        if (mt_rand(1, 100) <= 40) {
            $checkSingleProductQuery = clone $subQuery;
            $matchingProducts = $checkSingleProductQuery->where('unit_price', $invoiceAmount)->get();
    
            if ($matchingProducts->isNotEmpty()) {
                $randomProduct = $matchingProducts->shuffle()->first();
                $bestMatch = collect([$randomProduct]);
                $bestTotal = $invoiceAmount;
            }
        }
    
        if (!$bestMatch) {
            $minTotal = ($categoryName || $noOfProducts) ? $invoiceAmount * 0.6 : $invoiceAmount;
            $maxTotal = $invoiceAmount * 1.10;
            
            if ($noOfProducts) {
                $maxTotal = max($maxTotal, $invoiceAmount * 1.5);
                $fetchLimit = $noOfProducts * 50;
                $products = $subQuery->limit($fetchLimit)->get();
            } else {
                $maxTotal = max($maxTotal, $invoiceAmount * 1.2);
                $fetchLimit = 500;
                $products = $subQuery->orderByDesc('unit_price')->limit($fetchLimit)->get();
            }
    
            $products = $products->filter(fn($p) => $p->unit_price <= $maxTotal);
    
            if ($products->isEmpty()) {
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
    
            if ($noOfProducts) {
                $minAcceptableCount = max(1, floor($noOfProducts * 0.8));
                $maxAcceptableCount = ceil($noOfProducts * 1.2);
                $result = $this->findBestProductCombinationWithCount($products, $invoiceAmount, $noOfProducts, $minAcceptableCount, $maxAcceptableCount, $minTotal, $maxTotal, $lastUsedCombinations);
            } else {
                $result = $this->findBestProductCombinationFlexible($products, $invoiceAmount, $minTotal, $maxTotal, $lastUsedCombinations);
            }
    
            if ($result && !empty($result['products'])) {
                $bestMatch = collect($result['products']);
                $bestTotal = $result['total'];
    
                $combinationKey = $bestMatch->pluck('id')->sort()->join('-');
                $lastUsedCombinations[] = $combinationKey;
                $lastUsedCombinations = array_slice($lastUsedCombinations, -5);
                session()->put('last_used_combinations', $lastUsedCombinations);
            }
        }
    
        if (!$bestMatch) {
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No matching combination found, try again please'
            ]);
        }
    
        $categoryIds = $bestMatch->pluck('category_id')->unique();
    
        $categories = DB::connection($this->connectionType)
            ->table('categories')
            ->whereIn('id', $categoryIds)
            ->select('id', 'name', 'slug')
            ->get()
            ->keyBy('id');
    
        $siteLink = $site->site_link;
    
        $bestMatch->each(function ($product) use ($categories, $siteLink) {
            $category = $categories[$product->category_id] ?? null;
            $product->category_name = $category->name ?? 'unknown';
            $product->slug = $category ? 'search?category=' . $category->slug : $siteLink;
        });
    
        $productIds = $bestMatch->pluck('id')->unique();
        $priceHistories = ProductPriceHistory::where('site_id', $site_id)
            ->whereIn('product_id', $productIds)
            ->orderByDesc('last_price_changed')
            ->get()
            ->groupBy('product_id');
    
        $bestMatch->each(function ($product) use ($priceHistories) {
            $history = $priceHistories->get($product->id, collect())->first();
            if ($history) {
                $lastChanged = Carbon::parse($history->last_price_changed);
                $nextChange = $lastChanged->copy()->addMonths(3);
                $daysLeft = now()->diffInDays($nextChange, false);
                $product->remaining_days = max(round($daysLeft), 0);
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextChange) ? 1 : 0;
            } else {
                $product->remaining_days = 0;
                $product->can_edit_price = 1;
            }
        });
    
        $productList = $bestMatch->map(fn($p) => [
            'id'         => $p->id,
            'unit_price' => $p->unit_price,
            'name'       => $p->name,
            'slug'       => $p->slug ?? '',
        ])->toArray();

        session()->forget('ready_products');
        session()->put('ready_products', $productList);
        session(['current_amount' => $bestTotal]);
    
        $modelType = $site->businessModel->model_type;
        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $bestMatch,
            'site'     => $site,
            'total'    => $bestTotal
        ])->render();
    
        return response()->json([
            'tableRows' => $tableRows,
            'total'     => $bestTotal
        ]);
    }
    
    private function findBestProductCombinationWithCount($products, $targetAmount, $noOfProducts, $minAcceptableCount, $maxAcceptableCount, $minTotal, $maxTotal, $lastUsedCombinations = [])
    {
        $productArray = $products->shuffle()->values()->all();
        $productCount = count($productArray);
    
        $priceMap = [];
        foreach ($productArray as $idx => $product) {
            $priceMap[$idx] = floatval($product->unit_price);
        }
    
        asort($priceMap);
        $sortedIndices = array_keys($priceMap);
        shuffle($sortedIndices);
    
        if ($noOfProducts <= 2) {
            $percentages = [0, 2, 5, 8, 10, 15, 20, 25, 30, 35, 40, 50];
            shuffle($percentages);
    
            foreach ($percentages as $percentage) {
                $currentMax = $targetAmount * (1 + $percentage / 100);
    
                if ($noOfProducts == 1) {
                    $bestIdx = null;
                    $bestDiff = PHP_INT_MAX;
    
                    foreach ($sortedIndices as $idx) {
                        $price = $priceMap[$idx];
                        if ($price >= $minTotal && $price <= $currentMax) {
                            $diff = abs($price - $targetAmount);
                            if ($diff < $bestDiff) {
                                $bestDiff = $diff;
                                $bestIdx = $idx;
                            }
                        }
                    }
    
                    if ($bestIdx !== null) {
                        if (!empty($lastUsedCombinations)) {
                            $currentCombo = (string)$productArray[$bestIdx]->id;
                            if (in_array($currentCombo, $lastUsedCombinations)) {
                                continue;
                            }
                        }
    
                        return ['products' => [$productArray[$bestIdx]], 'total' => $priceMap[$bestIdx]];
                    }
                } else if ($noOfProducts == 2) {
                    if ($percentage > 0 && rand(0, 1) == 1) {
                        continue;
                    }
    
                    $bestPair = null;
                    $bestTotal = 0;
                    $bestDiff = PHP_INT_MAX;
    
                    for ($i = 0; $i < $productCount - 1; $i++) {
                        for ($j = $i + 1; $j < $productCount; $j++) {
                            $idx1 = $sortedIndices[$i];
                            $idx2 = $sortedIndices[$j];
    
                            $price1 = $priceMap[$idx1];
                            $price2 = $priceMap[$idx2];
    
                            if ($price1 == $price2) continue;
    
                            $total = $price1 + $price2;
    
                            if ($total >= $minTotal && $total <= $currentMax) {
                                $diff = abs($total - $targetAmount);
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
                            $comboIds = array_map(fn($i) => $productArray[$i]->id, $bestPair);
                            sort($comboIds);
                            $currentCombo = implode('-', $comboIds);
                            if (in_array($currentCombo, $lastUsedCombinations)) {
                                continue;
                            }
                        }
    
                        return [
                            'products' => [$productArray[$bestPair[0]], $productArray[$bestPair[1]]],
                            'total'    => $bestTotal
                        ];
                    }
                }
            }
        }
    
        $percentages = [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];
    
        foreach ($percentages as $percentage) {
            $currentMax = $targetAmount * (1 + $percentage / 100);
            $result = $this->tryFindWithCountConstraint($productArray, $priceMap, $sortedIndices, $targetAmount, $noOfProducts, $minAcceptableCount, $maxAcceptableCount, $minTotal, $currentMax, $productCount);
    
            if ($result !== null) {
                return $result;
            }
        }
    
        $bestMatch = null;
        $bestTotal = 0;
        $bestScore = PHP_INT_MAX;
    
        for ($attempt = 0; $attempt < 100; $attempt++) {
            $shuffledIndices = $sortedIndices;
            shuffle($shuffledIndices);
    
            $selected = [];
            $usedPrices = [];
            $total = 0;
    
            $startIdx = rand(0, max(0, $productCount - 30));
            $searchWindow = array_slice($shuffledIndices, $startIdx, min(30, $productCount));
    
            foreach ($searchWindow as $idx) {
                $maxCount = ceil($noOfProducts * 1.2);
                if (count($selected) >= $maxCount) break;
    
                $price = $priceMap[$idx];
                if (isset($usedPrices[$price])) continue;
    
                if ($total + $price <= $maxTotal) {
                    $selected[] = $idx;
                    $usedPrices[$price] = true;
                    $total += $price;
                }
    
                if (count($selected) >= $noOfProducts && $total >= $minTotal) {
                    break;
                }
            }
    
            $actualCount = count($selected);
    
            if ($actualCount >= $minAcceptableCount && $actualCount <= $maxAcceptableCount) {
                $distance = abs($targetAmount - $total);
                $countDiff = abs($noOfProducts - $actualCount);
                $score = $distance + ($countDiff * ($targetAmount * 0.1));
    
                if ($score < $bestScore) {
                    $bestMatch = $selected;
                    $bestTotal = $total;
                    $bestScore = $score;
    
                    if ($actualCount == $noOfProducts && $distance <= $targetAmount * 0.05) {
                        break;
                    }
                }
            }
        }
    
        if ($bestMatch) {
            $result = [];
            foreach ($bestMatch as $idx) {
                $result[] = $productArray[$idx];
            }
            return ['products' => $result, 'total' => $bestTotal];
        }
    
        return null;
    }
    
    private function tryFindWithCountConstraint($products, $priceMap, $sortedIndices, $targetAmount, $noOfProducts, $minAcceptableCount, $maxAcceptableCount, $minTotal, $maxTotal, $totalProducts)
    {
        $avgPrice = $targetAmount / $noOfProducts;
    
        $midPoint = 0;
        foreach ($sortedIndices as $pos => $idx) {
            if ($priceMap[$idx] >= $avgPrice) {
                $midPoint = max(0, $pos - intval($noOfProducts / 2));
                break;
            }
        }
    
        $windowSize = min($noOfProducts * 4, $totalProducts - $midPoint);
        $searchWindow = array_slice($sortedIndices, $midPoint, $windowSize);
    
        if (count($searchWindow) < $noOfProducts) {
            $searchWindow = $sortedIndices;
        }
    
        $attempts = min(50, count($searchWindow) * 2);
        $bestMatch = null;
        $bestTotal = 0;
        $bestScore = PHP_INT_MAX;
    
        for ($i = 0; $i < $attempts; $i++) {
            $windowCopy = $searchWindow;
            shuffle($searchWindow);
            $candidatePool = array_slice($searchWindow, 0, min(count($searchWindow), $noOfProducts * 3));
    
            $selectedIndices = [];
            $seenPrices = [];
            $total = 0;
    
            foreach ($candidatePool as $idx) {
                $maxCount = ceil($noOfProducts * 1.2);
                if (count($selectedIndices) >= $maxCount) break;
    
                $price = $priceMap[$idx];
                if (!isset($seenPrices[$price])) {
                    if ($total + $price <= $maxTotal) {
                        $selectedIndices[] = $idx;
                        $seenPrices[$price] = true;
                        $total += $price;
                    }
                }
    
                if (count($selectedIndices) >= $noOfProducts && $total >= $minTotal) {
                    break;
                }
            }
    
            $actualCount = count($selectedIndices);
    
            if ($actualCount >= $minAcceptableCount && $actualCount <= $maxAcceptableCount && $total >= $minTotal) {
                $distance = abs($targetAmount - $total);
                $countDiff = abs($noOfProducts - $actualCount);
                $score = $distance + ($countDiff * ($targetAmount * 0.1));
    
                if ($score < $bestScore) {
                    $bestMatch = $selectedIndices;
                    $bestTotal = $total;
                    $bestScore = $score;
    
                    if ($actualCount == $noOfProducts && $distance <= $targetAmount * 0.05) {
                        break;
                    }
                }
            }
        }
    
        if ($bestMatch) {
            $result = [];
            foreach ($bestMatch as $idx) {
                $result[] = $products[$idx];
            }
            return ['products' => $result, 'total' => $bestTotal];
        }
    
        return null;
    }
    
    private function findBestProductCombinationFlexible($products, $targetAmount, $minTotal, $maxTotal, $lastUsedCombinations = [])
    {
        $productArray = $products->shuffle()->values()->all();
        $productCount = count($productArray);
    
        $priceMap = [];
        foreach ($productArray as $idx => $product) {
            $price = floatval($product->unit_price);
            $priceMap[$idx] = $price;
    
            if (abs($price - $targetAmount) < 0.01) {
                return ['products' => [$product], 'total' => $price];
            }
        }
    
        asort($priceMap);
        $sortedIndices = array_keys($priceMap);
        shuffle($sortedIndices);
    
        $percentages = [0, 2, 4, 6, 8, 10];
    
        foreach ($percentages as $percentage) {
            $currentMax = $targetAmount * (1 + $percentage / 100);
            $currentMax = min($currentMax, $maxTotal);
            $result = $this->tryFindFlexibleWithRange($productArray, $priceMap, $sortedIndices, $minTotal, $currentMax, $productCount);
    
            if ($result !== null && $result['total'] >= $minTotal) {
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
    
        $bestMatch = null;
        $bestTotal = 0;
    
        for ($attempt = 0; $attempt < 20; $attempt++) {
            $shuffledIndices = $sortedIndices;
            shuffle($shuffledIndices);
            $startIdx = rand(0, max(0, $productCount - 30));
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
    
            if ($total >= $minTotal && $total <= $maxTotal && $total > $bestTotal) {
                $bestMatch = $selected;
                $bestTotal = $total;
            }
        }
    
        if ($bestMatch && $bestTotal >= $minTotal) {
            $result = [];
            foreach ($bestMatch as $idx) {
                $result[] = $productArray[$idx];
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
    
            if ($total >= $minTotal) {
                break;
            }
        }
    
        if ($total >= $minTotal && $total <= $maxTotal) {
            $result = [];
            foreach ($selected as $idx) {
                $result[] = $productArray[$idx];
            }
            return ['products' => $result, 'total' => $total];
        }
    
        if (!$bestMatch) {
            $bestMatch = [$sortedIndices[count($sortedIndices) - 1]];
            $bestTotal = $priceMap[$sortedIndices[count($sortedIndices) - 1]];
        }
    
        $result = [];
        foreach ($bestMatch as $idx) {
            $result[] = $productArray[$idx];
        }
        return ['products' => $result, 'total' => $bestTotal];
    }
    
    private function tryFindFlexibleWithRange($products, $priceMap, $sortedIndices, $minTarget, $maxTarget, $totalProducts)
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
                    'id'         => $productId,
                    'unit_price' => $unitPrice,
                    'name'       => '',
                    'slug'       => '',
                ];
            }
        }

        session()->put('ready_products', $readyProducts);

        $productIds = collect($readyProducts)->pluck('id')->reverse()->values()->toArray();

        $siteCurrency = site_currency_code();
        $dbProducts = DB::connection($this->connectionType)
            ->table($this->productTable . ' as p')
            ->leftJoin('conversion_rates as cr', function ($join) use ($siteCurrency) {
                $join->on('p.card_currency', '=', 'cr.from_currency')
                    ->where('cr.to_currency', '=', $siteCurrency);
            })
            ->select(
                'p.id',
                'p.name',
                'p.slug',
                'p.category_id',
                'p.card_currency',
                DB::raw('ROUND(p.rrp * IFNULL(cr.rate, 1), 2) as rrp'),
                'p.discount',
                DB::raw('ROUND(p.unit_price * IFNULL(cr.rate, 1), 2) as unit_price'),
                'p.current_stock',
                DB::raw('ROUND(1 / IFNULL(cr.rate, 1), 5) as reverse_rate')
            )
            ->whereIn('p.id', $productIds)
            ->get()
            ->keyBy('id');

        $categoryIds = $dbProducts->pluck('category_id')->unique();
        $categories = DB::connection($this->connectionType)
            ->table('categories')
            ->whereIn('id', $categoryIds)
            ->select('id', 'name', 'slug')
            ->get()
            ->keyBy('id');

        $siteLink = $site->site_link;

        $products = collect($productIds)->map(function ($id) use ($dbProducts) {
            return $dbProducts[$id] ?? null;
        })->filter();

        $updatedSession = $readyProducts;

        $products = $products->map(function ($product) use ($readyProducts, $site_id, $categories, $siteLink, &$updatedSession) {
            $sessionProduct = collect($readyProducts)->firstWhere('id', $product->id);
            $product->unit_price = $sessionProduct['unit_price'] ?? $product->unit_price;

            $category = $categories[$product->category_id] ?? null;
            $product->category_name = $category->name ?? 'unknown';
            $product->slug = $category ? 'search?category=' . $category->slug : $siteLink;

            foreach ($updatedSession as &$sp) {
                if ($sp['id'] == $product->id) {
                    $sp['name'] = $product->name;
                    $sp['slug'] = $product->slug;
                    break;
                }
            }

            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();

            if ($lastUpdate) {
                $lastPriceChanged    = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays       = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = max(round($remainingDays), 0);
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
            }

            return $product;
        });

        session()->put('ready_products', $updatedSession);

        $modelType = $site->businessModel->model_type;
        $total = collect($products)->sum('unit_price');
        session(['current_amount' => $total]);

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $products,
            'site'     => $site,
            'total'    => $total
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total'     => $total
        ]);
    }


    public function removeProduct(Request $request)
    {
        $productId = $request->get('product_id');
        $site_id   = $request->get('site_id');
        $site      = Website::findOrFail($site_id);

        $readyProducts = session('ready_products', []);

        $updatedProducts = collect($readyProducts)->reject(function ($product) use ($productId) {
            return (string) $product['id'] === (string) $productId;
        })->values()->toArray();

        session()->put('ready_products', $updatedProducts);

        if (empty($updatedProducts)) {
            session()->forget('current_amount');
            return response()->json([
                'tableRows' => '',
                'total'     => 0,
            ]);
        }

        DynamicDatabaseService::connect($site);

        $productIds   = array_column($updatedProducts, 'id');
        $siteCurrency = site_currency_code();

        $dbProducts = DB::connection($this->connectionType)
            ->table($this->productTable . ' as p')
            ->leftJoin('conversion_rates as cr', function ($join) use ($siteCurrency) {
                $join->on('p.card_currency', '=', 'cr.from_currency')
                    ->where('cr.to_currency', '=', $siteCurrency);
            })
            ->select(
                'p.id',
                'p.name',
                'p.slug',
                'p.category_id',
                'p.card_currency',
                DB::raw('ROUND(p.rrp * IFNULL(cr.rate, 1), 2) as rrp'),
                'p.discount',
                DB::raw('ROUND(p.unit_price * IFNULL(cr.rate, 1), 2) as unit_price'),
                'p.current_stock',
                DB::raw('ROUND(1 / IFNULL(cr.rate, 1), 5) as reverse_rate')
            )
            ->whereIn('p.id', $productIds)
            ->get()
            ->keyBy('id');

        $categoryIds = $dbProducts->pluck('category_id')->unique();
        $categories  = DB::connection($this->connectionType)
            ->table('categories')
            ->whereIn('id', $categoryIds)
            ->select('id', 'name', 'slug')
            ->get()
            ->keyBy('id');

        $siteLink = $site->site_link;

        $products = collect($updatedProducts)->map(function ($item) use ($dbProducts, $site_id, $categories, $siteLink) {
            $dbProduct = $dbProducts[$item['id']] ?? null;

            if (!$dbProduct) {
                $product = (object) [
                    'id'             => $item['id'],
                    'name'           => $item['name'] ?? '',
                    'slug'           => $item['slug'] ?? '',
                    'category_id'    => null,
                    'card_currency'  => null,
                    'rrp'            => $item['unit_price'],
                    'discount'       => 0,
                    'unit_price'     => $item['unit_price'],
                    'current_stock'  => null,
                    'reverse_rate'   => 1,
                    'category_name'  => 'unknown',
                    'remaining_days' => 0,
                    'can_edit_price' => 1,
                ];
                return $product;
            }

            $dbProduct->unit_price = $item['unit_price'];

            $category = $categories[$dbProduct->category_id] ?? null;
            $dbProduct->category_name = $category->name ?? 'unknown';
            $dbProduct->slug = $category ? 'search?category=' . $category->slug : $siteLink;

            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $dbProduct->id)
                ->orderByDesc('last_price_changed')
                ->first();

            if ($lastUpdate) {
                $lastPriceChanged    = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays       = now()->diffInDays($nextPriceChangeDate, false);
                $dbProduct->remaining_days = max(round($remainingDays), 0);
                $dbProduct->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
            } else {
                $dbProduct->can_edit_price = 1;
                $dbProduct->remaining_days = 0;
            }

            return $dbProduct;
        });

        $modelType = $site->businessModel->model_type;
        $total = collect($products)->sum('unit_price');
        session(['current_amount' => $total]);

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $products,
            'site'     => $site,
            'total'    => $total
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total'     => $total
        ]);
    }

    public function updateProduct(Request $request)
    {
        $productId = $request->get('product_id');
        $quantity  = $request->get('quantity');
        $site_id   = $request->get('site_id');

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

        $productIds   = collect($readyProducts)->pluck('id')->toArray();
        $siteCurrency = site_currency_code();

        $dbProducts = DB::connection($this->connectionType)
            ->table($this->productTable . ' as p')
            ->leftJoin('conversion_rates as cr', function ($join) use ($siteCurrency) {
                $join->on('p.card_currency', '=', 'cr.from_currency')
                    ->where('cr.to_currency', '=', $siteCurrency);
            })
            ->select(
                'p.id',
                'p.name',
                'p.slug',
                'p.category_id',
                'p.card_currency',
                DB::raw('ROUND(p.rrp * IFNULL(cr.rate, 1), 2) as rrp'),
                'p.discount',
                DB::raw('ROUND(p.unit_price * IFNULL(cr.rate, 1), 2) as unit_price'),
                'p.current_stock',
                DB::raw('ROUND(1 / IFNULL(cr.rate, 1), 5) as reverse_rate')
            )
            ->whereIn('p.id', $productIds)
            ->get()
            ->keyBy('id');

        $categoryIds = $dbProducts->pluck('category_id')->unique();
        $categories  = DB::connection($this->connectionType)
            ->table('categories')
            ->whereIn('id', $categoryIds)
            ->select('id', 'name', 'slug')
            ->get()
            ->keyBy('id');

        $siteLink = $site->site_link;

        $products = collect($readyProducts)->map(function ($item) use ($dbProducts, $site_id, $categories, $siteLink) {
            $product = $dbProducts[$item['id']] ?? null;

            if (!$product) {
                return null;
            }

            $product->unit_price = $item['unit_price'];
            $product->quantity   = $item['quantity'] ?? 1;

            $category = $categories[$product->category_id] ?? null;
            $product->category_name = $category->name ?? 'unknown';
            $product->slug = $category ? 'search?category=' . $category->slug : $siteLink;

            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();

            if ($lastUpdate) {
                $lastPriceChanged    = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays       = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = max(round($remainingDays), 0);
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
            }

            return $product;
        })->filter();

        $modelType = $site->businessModel->model_type;

        $total = $products->sum(function ($product) {
            return $product->unit_price * ($product->quantity ?? 1);
        });

        session(['current_amount' => $total]);

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $products,
            'site'     => $site,
            'total'    => $total
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total'     => $total
        ]);
    }


    public function clearProducts(Request $request)
    {
        session()->forget('ready_products');
        session()->forget('current_amount');
        return response()->json([
            'success'   => true,
            'tableRows' => '',
            'currency'  => null,
            'total'     => 0
        ]);
    }

    public function filterProducts(Request $request)
    {
        $site_id       = session('customer.site_id');
        $hasPriceRange = $request->filled('price_from') && $request->filled('price_to');
        $keyword       = $request->input('keyword');
        $sortUnitPrice = $request->input('sort_unit_price', 'asc');
        $site          = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        if (!$hasPriceRange) {
            return response()->json([
                'tableRows' => '<tr><td colspan="6" class="text-center text-muted">Please enter a price range to search.</td></tr>'
            ]);
        }

        $siteCurrency = site_currency_code();

        $query = DB::connection($this->connectionType)
            ->table($this->productTable . ' as p')
            ->leftJoin('categories as c', 'p.category_id', '=', 'c.id')
            ->leftJoin('conversion_rates as cr', function ($join) use ($siteCurrency) {
                $join->on('p.card_currency', '=', 'cr.from_currency')
                    ->where('cr.to_currency', '=', $siteCurrency);
            })
            ->select(
                'p.id',
                'p.name',
                'p.slug',
                'p.category_id',
                'p.card_currency',
                DB::raw('ROUND(p.rrp * IFNULL(cr.rate, 1), 2) as rrp'),
                'p.discount',
                DB::raw('ROUND(p.unit_price * IFNULL(cr.rate, 1), 2) as unit_price'),
                'p.current_stock',
                DB::raw('ROUND(1 / IFNULL(cr.rate, 1), 5) as reverse_rate'),
                'c.name as category_name'
            )
            ->where('p.published', 1);

        $subQuery = DB::connection($this->connectionType)
            ->table(DB::raw("({$query->toSql()}) as derived"))
            ->mergeBindings($query);

        if ($hasPriceRange) {
            $subQuery->whereBetween('unit_price', [
                (float) $request->price_from,
                (float) $request->price_to
            ]);
        }

        if (in_array($sortUnitPrice, ['asc', 'desc'])) {
            $subQuery->orderBy('unit_price', $sortUnitPrice);
        }

        if (!empty($keyword)) {
            $normalizedSearch = strtolower(str_replace(['-', '_', ' ', ','], '', $keyword));

            $subQuery->where(function ($q) use ($normalizedSearch) {
                $q->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(REPLACE(name, '-', ''), '_', ''), ' ', ''), ',', '')) LIKE ?", ["%{$normalizedSearch}%"])
                    ->orWhereRaw("LOWER(REPLACE(REPLACE(REPLACE(REPLACE(slug, '-', ''), '_', ''), ' ', ''), ',', '')) LIKE ?", ["%{$normalizedSearch}%"])
                    ->orWhereIn('category_id', function ($sub) use ($normalizedSearch) {
                        $sub->select('id')
                            ->from('categories')
                            ->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(REPLACE(tags, '-', ''), '_', ''), ' ', ''), ',', '')) LIKE ?", ["%{$normalizedSearch}%"]);
                    });
            });
        }

        $readyProducts   = session('ready_products', []);
        $readyProductIds = collect($readyProducts)->pluck('id')->toArray();

        if (count($readyProductIds) > 0) {
            $subQuery->whereNotIn('id', $readyProductIds);
        }

        $totalCount = $subQuery->count();
        $page       = $request->input('page', 1);
        $perPage    = 10;
        $offset     = ($page - 1) * $perPage;
        $products   = $subQuery->skip($offset)->take($perPage)->get();
        $totalPages = ceil($totalCount / $perPage);
        $paginationPages = $this->smartPagination($page, $totalPages);

        if ($products->isEmpty()) {
            return response()->json([
                'tableRows' => '<tr><td colspan="7" class="text-center text-muted"> No results found. Try randomizing or use a different keyword.</td></tr>'
            ]);
        }

        $productIds  = $products->pluck('id')->toArray();
        $categoryIds = $products->pluck('category_id')->unique()->toArray();

        $priceHistories = ProductPriceHistory::where('site_id', $site_id)
            ->whereIn('product_id', $productIds)
            ->orderByDesc('last_price_changed')
            ->get()
            ->keyBy('product_id');

        $categories = DB::connection($this->connectionType)
            ->table('categories')
            ->whereIn('id', $categoryIds)
            ->select('id', 'name', 'slug')
            ->get()
            ->keyBy('id');

        foreach ($products as $product) {
            $category = $categories->get($product->category_id);
            $product->category_name = $category->name ?? 'unknown';
            $product->slug = $category ? 'search?category=' . $category->slug : $site->site_link;

            $history = $priceHistories->get($product->id);
            if ($history) {
                $lastPriceChanged    = Carbon::parse($history->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays       = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = max(round($remainingDays), 0);
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
            }
        }

        $modelType     = $site->businessModel->model_type;
        $random_amount = session('current_amount', 0);

        $tableRows = view("invoice.{$modelType}.add_product_rows", [
            'products'      => $products,
            'site'          => $site,
            'random_amount' => $random_amount
        ])->render();

        $paginationHtml = view("invoice.{$modelType}.pagination", [
            'totalPages'      => $totalPages,
            'paginationPages' => $paginationPages,
            'currentPage'     => $page
        ])->render();

        return response()->json([
            'tableRows'      => $tableRows,
            'paginationHtml' => $paginationHtml,
            'random_amount'  => $random_amount,
            'currentPage'    => $page
        ]);
    }


    private function smartPagination($currentPage, $totalPages)
    {
        $pages   = [];
        $pages[] = 1;

        if ($currentPage > 4) {
            $pages[] = '...';
        }

        $start = max(2, $currentPage - 3);
        $end   = min($totalPages - 1, $currentPage + 3);

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

    public function getProduct(Request $request)
    {
        $productId = $request->input('product_id');
        $rrp       = $request->input('rrp');
        $site_id   = session('customer.site_id');
        $site      = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        if ($site->businessModel && strtolower(trim($site->businessModel->model_type)) !== 'giftcard' && strtolower(trim($site->technology)) !== 'laravel') {
            return response()->json(['success' => true]);
        }

        if (!$productId || !$rrp) {
            return response()->json(['success' => false], 400);
        }

        $product = DB::connection($this->connectionType)
            ->table($this->productTable)
            ->where('id', $productId)
            ->first();

        if (!$product) {
            return response()->json(['success' => false], 404);
        }

        $siteCurrency = site_currency_code();

        $rate = ($product->card_currency === $siteCurrency)
            ? 1
            : DB::connection($this->connectionType)
                ->table('conversion_rates')
                ->where('from_currency', $siteCurrency)
                ->where('to_currency', $product->card_currency)
                ->value('rate') ?? 1;

        $convertedAmount = round($rrp * $rate, 2);

        $match   = [];
        $nameRRP = null;
        if (preg_match('/([A-Z]{3})\s*(\d+(\.\d+)?)/i', $product->name, $match)) {
            $nameRRP = (float)$match[2];
        }

        $hasMismatch = is_null($nameRRP) || abs($nameRRP - $convertedAmount) > 0.01;

        return response()->json([
            'convertedAmount' => $convertedAmount,
            'success'         => !$hasMismatch
        ]);
    }


    public function generateInvoice(Request $request)
    {
        $site_id = $request->input('site_id');
        $site    = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);
    
        $invoice_data['site']             = $site;
        $invoice_data['invoice_number']   = $request->input('invoice_number');
        $invoice_data['invoice_date']     = Carbon::parse($request->input('invoice_date'))->format('F d, Y');
        $invoice_data['customer_name']    = $request->input('customer_name');
        $invoice_data['customer_mobile']  = $request->input('customer_mobile');
        $invoice_data['customer_email']   = $request->input('customer_email');
        $invoice_data['invoice_amount']   = $request->input('invoice_amount');
        $invoice_data['current_amount']   = $request->input('current_amount');
        $invoice_data['discount_amount']  = $request->input('discount_amount');
        $invoice_data['company_name']     = $site->company_name;
        $invoice_data['company_email']    = $site->company_email;
        $invoice_data['company_mobile']   = $site->company_mobile;
        $invoice_data['company_address']  = $site->company_address;
        $invoice_data['invoice_template'] = $site->invoice_template;
        $invoice_data['model_type']       = $site->businessModel->model_type;
        $invoice_data['site_id']          = $site->id;
    
        $company_detail_type = $request->input('company_detail_type');
    
        if ($company_detail_type === 'remote') {
            $invoice_data['site_name']           = $request->input('remote_site_name') ?? '';
            $invoice_data['company_name']        = $request->input('remote_company_name') ?? '';
            $invoice_data['company_email']       = $request->input('remote_company_email') ?? '';
            $invoice_data['company_mobile']      = $request->input('remote_company_mobile') ?? '';
            $invoice_data['company_address']     = $request->input('remote_company_address') ?? '';
            $invoice_data['registration_number'] = $request->input('remote_registration_number') ?? '';
            $invoice_data['license_number']      = $request->input('remote_license_number') ?? '';
    
            $remote_database = DB::connection($this->connectionType)->table('general_settings')->orderByDesc('updated_at')->first();
    
            if ($remote_database) {
                DB::connection($this->connectionType)->table('general_settings')->where('id', $remote_database->id)
                    ->update([
                        'site_name'  => $request->input('remote_site_name') ?? '',
                        'email'      => $request->input('remote_company_email') ?? '',
                        'phone'      => $request->input('remote_company_mobile') ?? '',
                        'address'    => $request->input('remote_company_address') ?? '',
                        'updated_at' => now(),
                    ]);
            }
        } else {
            $invoice_data['site_name']           = $request->input('local_site_name') ?? '';
            $invoice_data['company_name']        = $request->input('local_company_name') ?? '';
            $invoice_data['company_email']       = $request->input('local_company_email') ?? '';
            $invoice_data['company_mobile']      = $request->input('local_company_mobile') ?? '';
            $invoice_data['company_address']     = $request->input('local_company_address') ?? '';
            $invoice_data['registration_number'] = $request->input('registration_number') ?? '';
            $invoice_data['license_number']      = $request->input('license_number') ?? '';
    
            $site->site_name           = $invoice_data['site_name'];
            $site->company_name        = $invoice_data['company_name'];
            $site->company_email       = $invoice_data['company_email'];
            $site->company_mobile      = $invoice_data['company_mobile'];
            $site->company_address     = $invoice_data['company_address'];
            $site->registration_number = $invoice_data['registration_number'];
            $site->license_number      = $invoice_data['license_number'];
    
            $site->save();
        }
    
        $invoice_data['invoice_header_image'] = base64EncodeImage($site->invoice_header_image);
        $invoice_data['invoice_footer_image'] = base64EncodeImage($site->invoice_footer_image);
        $invoice_data['invoice_signature']    = base64EncodeImage($site->invoice_signature);
        $invoice_data['company_logo']         = base64EncodeImage($site->company_logo);
        $invoice_data['invoice_image1']       = base64EncodeImage($site->invoice_image1);
        $invoice_data['invoice_image2']       = base64EncodeImage($site->invoice_image2);
        $invoice_data['invoice_image3']       = base64EncodeImage($site->invoice_image3);
        $invoice_data['invoice_image4']       = base64EncodeImage($site->invoice_image4);
        $invoice_data['invoice_image5']       = base64EncodeImage($site->invoice_image5);
        $invoice_data['invoice_image6']       = base64EncodeImage($site->invoice_image6);
        $invoice_data['invoice_image7']       = base64EncodeImage($site->invoice_image7);
        $invoice_data['invoice_image8']       = base64EncodeImage($site->invoice_image8);
        $invoice_data['invoice_image9']       = base64EncodeImage($site->invoice_image9);
    
        $productDataArray = $request->input('product_data', []);
        $productIds       = [];
        $customPrices     = [];
    
        foreach ($productDataArray as $item) {
            $data = json_decode($item, true);
            if (!empty($data['product_id'])) {
                $productIds[] = $data['product_id'];
                $customPrices[$data['product_id']] = [
                    'product_name'  => $data['product_name'],
                    'unit_rrp'      => $data['unit_rrp'],
                    'unit_discount' => $data['unit_discount'],
                    'unit_price'    => $data['unit_price'],
                ];
            }
        }
    
        $siteCurrency = site_currency_code();
    
        $products = DB::connection($this->connectionType)
            ->table($this->productTable . ' as p')
            ->leftJoin('conversion_rates as cr', function ($join) use ($siteCurrency) {
                $join->on('p.card_currency', '=', 'cr.from_currency')
                     ->where('cr.to_currency', '=', $siteCurrency);
            })
            ->whereIn('p.id', $productIds)
            ->select(
                'p.id',
                'p.name',
                'p.slug',
                'p.category_id',
                'p.card_currency',
                DB::raw('ROUND(p.rrp * IFNULL(cr.rate, 1), 2) as rrp'),
                'p.discount',
                DB::raw('ROUND(p.unit_price * IFNULL(cr.rate, 1), 2) as unit_price'),
                'p.current_stock',
                DB::raw('ROUND(1 / IFNULL(cr.rate, 1), 5) as reverse_rate')
            )
            ->get()
            ->sortBy(fn($product) => array_search($product->id, $productIds))
            ->values()
            ->map(function ($product) use ($customPrices) {
                if (isset($customPrices[$product->id])) {
                    $product->name      = $customPrices[$product->id]['product_name'];
                    $product->rrp       = $customPrices[$product->id]['unit_rrp'];
                    $product->discount  = $customPrices[$product->id]['unit_discount'];
                    $product->unit_price = $customPrices[$product->id]['unit_price'];
                }
                return $product;
            });
    
        $products->each(function ($product) {
            $product->category_name = DB::connection($this->connectionType)
                ->table('categories')
                ->where('id', $product->category_id)
                ->value('name') ?? 'unknown';
        });
    
        $invoice_data['currency']    = site_currency();
        $invoice_data['products']    = $products;
        $invoice_data['product_ids'] = $productIds;
    
        $modelType     = strtolower($site->businessModel->model_type);
        $siteIdInWords = numberToWords($site->id);
        $viewPath      = "websites.{$modelType}.{$siteIdInWords}";
    
        $this->updateProductPrice($productDataArray);
        InvoiceController::createInvoiceHistory($invoice_data);
    
        $filename = $request->filled('invoice_file_name')
            ? $request->input('invoice_file_name') . '.pdf'
            : $invoice_data['invoice_number'] . '.pdf';

        try {
            return $this->generateWithApi2Pdf($site, $viewPath, $invoice_data, $filename);
        } catch (\Exception $e) {
            return $this->generateWithDompdf($site, $viewPath, $invoice_data, $filename);
        }
    }

    protected function generateWithApi2Pdf($site, $viewPath, $invoice_data, $filename)
    {
        $html = View::make($viewPath, $invoice_data)->render();

        $response = Http::withHeaders([
            'Authorization' => env('API2PDF_KEY')
        ])->post('https://v2.api2pdf.com/chrome/html', [
            'html'     => $html,
            'fileName' => $filename,
            'options'  => [
                'format'                => $site->pdf_size ?? 'A4',
                'landscape'             => ($site->pdf_orientation ?? 'portrait') === 'landscape',
                'marginTop'             => '0mm',
                'marginBottom'          => '0mm',
                'marginLeft'            => '0mm',
                'marginRight'           => '0mm',
                'disableSmartShrinking' => true,
                'zoom'                  => 1,
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

            if (empty($data['product_id']) || !isset($data['unit_price'])) {
                Log::info('Invalid item data', ['item' => $item]);
                continue;
            }

            $product_id = $data['product_id'];

            $product = DB::connection($this->connectionType)
                ->table($this->productTable)
                ->where('id', $product_id)
                ->first();

            if (!$product) {
                Log::info('Product not found', ['product_id' => $product_id]);
                continue;
            }

            $siteCurrency = site_currency_code();

            $rate = DB::connection($this->connectionType)
                ->table('conversion_rates')
                ->where('from_currency', $product->card_currency)
                ->where('to_currency', $siteCurrency)
                ->value('rate') ?: 1;

            $current_name     = $product->name ?? '';
            $new_name         = $data['product_name'] ?? $current_name;

            $current_price    = floatval($product->unit_price);
            $current_rrp      = floatval($product->rrp ?? 0);
            $current_discount = floatval($product->discount ?? 0);

            $siteRRP      = floatval($data['unit_rrp'] ?? 0);
            $new_discount = floatval($data['unit_discount'] ?? 0);
            // $new_rrp      = round($siteRRP / $rate, 2);
            $new_rrp = ($rate != 0) ? round($siteRRP / $rate, 2) : round($siteRRP, 2);

            $discountChanged = abs($current_discount - $new_discount) > 0.01;
            $rrpChanged      = abs($current_rrp - $new_rrp) > 0.01;

            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product_id)
                ->orderByDesc('last_price_changed')
                ->first();

            $canUpdatePrice = !$lastUpdate || Carbon::parse($lastUpdate->last_price_changed)->diffInMonths(now()) >= 3;

            if (!$rrpChanged && !$discountChanged) {
                DB::connection($this->connectionType)
                    ->table($this->productTable)
                    ->where('id', $product_id)
                    ->update(['name' => $new_name]);

                Log::info('Product name updated (cosmetic only)', [
                    'product_id' => $product_id,
                    'old_name'   => $current_name,
                    'new_name'   => $new_name
                ]);
                continue;
            }

            if (!$canUpdatePrice) {
                Log::warning('Price update blocked by 90-day lock', [
                    'product_id'     => $product_id,
                    'last_update'    => $lastUpdate->last_price_changed ?? 'none',
                    'days_remaining' => $lastUpdate ? now()->diffInDays(Carbon::parse($lastUpdate->last_price_changed)->addMonths(3)) : 0
                ]);
                continue;
            }

            if ($rrpChanged && !$discountChanged) {
                $new_price = $current_discount > 0 && $new_rrp > 0
                    ? round($new_rrp * (1 - $current_discount / 100), 2)
                    : $new_rrp;

                DB::connection($this->connectionType)->table($this->productTable)->where('id', $product_id)->update([
                    'name'       => $new_name,
                    'rrp'        => $new_rrp,
                    'unit_price' => $new_price,
                ]);

                ProductPriceHistory::create([
                    'site_id'            => $site_id,
                    'product_id'         => $product_id,
                    'unit_price'         => $new_price,
                    'last_price_changed' => now(),
                ]);

                Log::info('Product RRP and price updated', [
                    'product_id' => $product_id,
                    'old_rrp'    => $current_rrp,
                    'new_rrp'    => $new_rrp,
                    'old_price'  => $current_price,
                    'new_price'  => $new_price,
                    'discount'   => $current_discount
                ]);

            } elseif ($discountChanged && !$rrpChanged) {
                $new_price = $new_discount > 0 && $current_rrp > 0
                    ? round($current_rrp * (1 - $new_discount / 100), 2)
                    : $current_rrp;

                DB::connection($this->connectionType)->table($this->productTable)->where('id', $product_id)->update([
                    'name'       => $new_name,
                    'discount'   => $new_discount,
                    'unit_price' => $new_price,
                ]);

                ProductPriceHistory::create([
                    'site_id'            => $site_id,
                    'product_id'         => $product_id,
                    'unit_price'         => $new_price,
                    'last_price_changed' => now(),
                ]);

                Log::info('Product discount and price updated', [
                    'product_id'   => $product_id,
                    'old_discount' => $current_discount,
                    'new_discount' => $new_discount,
                    'old_price'    => $current_price,
                    'new_price'    => $new_price,
                    'rrp'          => $current_rrp
                ]);

            } elseif ($rrpChanged && $discountChanged) {
                $new_price = $new_discount > 0 && $new_rrp > 0
                    ? round($new_rrp * (1 - $new_discount / 100), 2)
                    : $new_rrp;

                DB::connection($this->connectionType)->table($this->productTable)->where('id', $product_id)->update([
                    'name'       => $new_name,
                    'rrp'        => $new_rrp,
                    'discount'   => $new_discount,
                    'unit_price' => $new_price,
                ]);

                ProductPriceHistory::create([
                    'site_id'            => $site_id,
                    'product_id'         => $product_id,
                    'unit_price'         => $new_price,
                    'last_price_changed' => now(),
                ]);

                Log::info('Product RRP, discount, and price updated', [
                    'product_id'   => $product_id,
                    'old_rrp'      => $current_rrp,
                    'new_rrp'      => $new_rrp,
                    'old_discount' => $current_discount,
                    'new_discount' => $new_discount,
                    'old_price'    => $current_price,
                    'new_price'    => $new_price
                ]);
            }
        }
    }
}