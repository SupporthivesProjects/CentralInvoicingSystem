<?php
namespace App\Http\Controllers\BusinessModels\Calligraphy;

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

    private function getProductsWithPersonalizationPrices($productIds, $usedProductIds = [])
    {
        $options = DB::connection($this->connectionType)->table('personalization_options')
            ->whereIn('product_id', $productIds)
            ->get()
            ->groupBy('product_id');

        $result = [];
        foreach ($productIds as $productId) {
            if (isset($options[$productId])) {
                $available = $options[$productId]->first();
                if ($available) {
                    $result[$productId] = floatval($available->price);
                }
            }
        }
        return $result;
    }

    private function buildProductsFromPersonalization($products, $targetPerProduct = null)
    {
        $productIds = $products->pluck('id')->toArray();

        $options = DB::connection($this->connectionType)->table('personalization_options')
            ->whereIn('product_id', $productIds)
            ->get()
            ->groupBy('product_id');

        $enriched = collect();
        foreach ($products as $product) {
            $pid = $product->id;
            if (isset($options[$pid]) && $options[$pid]->isNotEmpty()) {
                $allOptions = $options[$pid];

                if ($targetPerProduct) {
                    $best = $allOptions->sortBy(fn($o) => abs(floatval($o->price) - $targetPerProduct))->first();
                } else {
                    $best = $allOptions->first();
                }

                $product->unit_price = floatval($best->price);
                $product->personalization_label = $best->label;
                $product->personalization_option_id = $best->id;
                $product->all_personalization_options = $allOptions->values();
                $enriched->push($product);
            }
        }
        return $enriched;
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
            ->select('id', 'category_id', 'name', 'slug')
            ->where('published', 1);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $rawProducts = $query->get();

        if ($rawProducts->isEmpty()) {
            session()->forget('ready_products');
            session()->forget('current_amount');
            session()->forget('last_used_combinations');

            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No products found in this range or category.'
            ]);
        }

        $targetPerProduct = $noOfProducts > 0 ? ($invoiceAmount / $noOfProducts) : $invoiceAmount;
        $products = $this->buildProductsFromPersonalization($rawProducts, $targetPerProduct);

        if ($priceFrom && $priceTo) {
            $products = $products->filter(function ($p) use ($priceFrom, $priceTo) {
                return $p->unit_price >= floatval($priceFrom) && $p->unit_price <= floatval($priceTo);
            })->values();
        }

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

        $urgencyFee = 35;
        $lastUsedCombinations = session()->get('last_used_combinations', []);
        $result = $this->findBestProductCombination($products, $invoiceAmount, $noOfProducts, $lastUsedCombinations);

        $bestMatch = collect($result['products']);
        $bestTotal = $bestMatch->sum('unit_price');
        $gap = $invoiceAmount - $bestTotal;
        // $autoUrgent = $bestTotal > 0
        //     && $invoiceAmount > 0
        //     && $gap > 0
        //     && ($gap / $invoiceAmount) <= 0.40
        //     && $gap <= ($bestMatch->count() * $urgencyFee)
        //     && ($bestTotal + ($bestMatch->count() * $urgencyFee)) >= $invoiceAmount;
        
        $autoUrgent = false;
        $combinationKey = $bestMatch->pluck('id')->sort()->join('-');
        $lastUsedCombinations[] = $combinationKey;
        $lastUsedCombinations = array_slice($lastUsedCombinations, -5);
        session()->put('last_used_combinations', $lastUsedCombinations);

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
                $product->remaining_days = (int) max(ceil($daysLeft), 0);
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
            'total' => $bestTotal,
            'urgency_fee' => $urgencyFee,
            'auto_urgent' => $autoUrgent,
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

        $percentages = [0, 2, 4, 6, 8, 10];

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

        $maxTotal = $target * 1.10;
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
        $site_id = $request->get('site_id');
        $productsData = $request->get('products');

        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $readyProducts = session()->get('ready_products', []);

        foreach ($productsData as $productData) {
            $productId = $productData['product_id'];
            $unitPrice = floatval($productData['unit_price']);
            $optionId = $productData['personalization_option_id'] ?? null;

            $exists = false;
            foreach ($readyProducts as &$item) {
                if ($item['id'] == $productId) {
                    $item['unit_price'] = $unitPrice;
                    $item['personalization_option_id'] = $optionId;
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {
                $readyProducts[] = [
                    'id' => $productId,
                    'unit_price' => $unitPrice,
                    'personalization_option_id' => $optionId,
                ];
            }
        }

        session()->put('ready_products', $readyProducts);

        $productIds = collect($readyProducts)->pluck('id')->reverse()->values()->toArray();

        $rawProducts = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'category_id', 'name', 'slug')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $products = collect($productIds)->map(function ($id) use ($rawProducts) {
            return $rawProducts[$id] ?? null;
        })->filter();

        $personalizationOptions = DB::connection($this->connectionType)->table('personalization_options')
            ->whereIn('product_id', $productIds)
            ->get()
            ->groupBy('product_id');

        $products = $products->map(function ($product) use ($readyProducts, $site_id, $personalizationOptions) {
            $sessionProduct = collect($readyProducts)->firstWhere('id', $product->id);

            $allOptions = isset($personalizationOptions[$product->id])
                ? $personalizationOptions[$product->id]->values()
                : collect();

            $savedOptionId = $sessionProduct['personalization_option_id'] ?? null;
            $option = $savedOptionId
                ? ($allOptions->firstWhere('id', $savedOptionId) ?? $allOptions->first())
                : $allOptions->first();

            $product->unit_price = $sessionProduct['unit_price'] ?? ($option ? floatval($option->price) : 0);
            $product->personalization_label = $option ? $option->label : null;
            $product->personalization_option_id = $option ? $option->id : null;
            $product->all_personalization_options = $allOptions;

            $product->category_name = DB::connection($this->connectionType)
                ->table('categories')
                ->where('id', $product->category_id)
                ->value('name') ?? 'unknown';

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
            'total' => collect($products)->sum('unit_price'),
            'urgency_fee' => 35,
            'auto_urgent' => false,
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

        $rawProducts = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'category_id', 'name', 'slug')
            ->whereIn('id', $productIds)
            ->get();

        $personalizationOptions = DB::connection($this->connectionType)->table('personalization_options')
            ->whereIn('product_id', $productIds)
            ->get()
            ->groupBy('product_id');

        $products = $rawProducts->map(function ($product) use ($updatedProducts, $site_id, $personalizationOptions) {
            $sessionProduct = collect($updatedProducts)->firstWhere('id', $product->id);

            $allOptions = isset($personalizationOptions[$product->id])
                ? $personalizationOptions[$product->id]->values()
                : collect();

            $savedOptionId = $sessionProduct['personalization_option_id'] ?? null;
            $option = $savedOptionId
                ? ($allOptions->firstWhere('id', $savedOptionId) ?? $allOptions->first())
                : $allOptions->first();

            $product->unit_price = $sessionProduct['unit_price'] ?? ($option ? floatval($option->price) : 0);
            $product->personalization_label = $option ? $option->label : null;
            $product->personalization_option_id = $option ? $option->id : null;
            $product->all_personalization_options = $allOptions;

            $product->category_name = DB::connection($this->connectionType)
                ->table('categories')
                ->where('id', $product->category_id)
                ->value('name') ?? 'unknown';

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
            'total' => collect($products)->sum('unit_price'),
            'urgency_fee' => 35,
            'auto_urgent' => false,
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

        $rawProducts = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'category_id', 'name', 'slug')
            ->whereIn('id', $productIds)
            ->get();

        $personalizationOptions = DB::connection($this->connectionType)->table('personalization_options')
            ->whereIn('product_id', $productIds)
            ->get()
            ->groupBy('product_id');

        $products = $rawProducts->map(function ($product) use ($readyProducts, $site_id, $personalizationOptions) {
            $sessionProduct = collect($readyProducts)->firstWhere('id', $product->id);

            $option = isset($personalizationOptions[$product->id]) ? $personalizationOptions[$product->id]->first() : null;
            $product->unit_price = $sessionProduct['unit_price'] ?? ($option ? floatval($option->price) : 0);
            $product->personalization_label = $option ? $option->label : null;
            $product->personalization_option_id = $option ? $option->id : null;
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
            'total' => $total,
            'urgency_fee' => 35,
            'auto_urgent' => false,
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
            ->select('products.id', 'products.category_id', 'products.name', 'products.slug')
            ->where('products.published', 1);
    
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
    
        $allProductIds = (clone $query)->pluck('products.id')->toArray();
    
        $personalizationOptions = DB::connection($this->connectionType)->table('personalization_options')
            ->whereIn('product_id', $allProductIds)
            ->get()
            ->groupBy('product_id');
    
        $filteredProductIds = collect($allProductIds)->filter(function ($id) use ($personalizationOptions, $request) {
            if (!isset($personalizationOptions[$id]) || $personalizationOptions[$id]->isEmpty()) {
                return false;
            }
            return $personalizationOptions[$id]->contains(function ($opt) use ($request) {
                $price = floatval($opt->price);
                return $price >= floatval($request->price_from) && $price <= floatval($request->price_to);
            });
        });
    
        $flatItems = [];
        foreach ($filteredProductIds as $id) {
            foreach ($personalizationOptions[$id] as $option) {
                $price = floatval($option->price);
                if ($price >= floatval($request->price_from) && $price <= floatval($request->price_to)) {
                    $flatItems[] = ['product_id' => $id, 'option' => $option];
                }
            }
        }
    
        $flatItems = collect($flatItems);
    
        if ($sortUnitPrice === 'desc') {
            $flatItems = $flatItems->sortByDesc(fn($item) => floatval($item['option']->price));
        } else {
            $flatItems = $flatItems->sortBy(fn($item) => floatval($item['option']->price));
        }
    
        $flatItems = $flatItems->values();
        $totalCount = $flatItems->count();
    
        $page = $request->input('page', 1);
        $perPage = 10;
        $offset = ($page - 1) * $perPage;
        $pagedItems = $flatItems->slice($offset, $perPage)->values();
    
        if ($pagedItems->isEmpty()) {
            return response()->json([
                'tableRows' => '<tr><td colspan="7" class="text-center text-muted"> No results found. Try randomizing or use a different keyword.</td></tr>'
            ]);
        }
    
        $pagedProductIds = $pagedItems->pluck('product_id')->unique()->toArray();
    
        $rawProducts = DB::connection($this->connectionType)
            ->table($this->productTable)
            ->select('products.id', 'products.category_id', 'products.name', 'products.slug')
            ->whereIn('products.id', $pagedProductIds)
            ->get()
            ->keyBy('id');
    
        $products = $pagedItems->map(function ($item) use ($rawProducts) {
            $product = clone ($rawProducts[$item['product_id']] ?? null);
            if (!$product) return null;
            $option = $item['option'];
            $product->unit_price = floatval($option->price);
            $product->personalization_label = $option->label;
            $product->personalization_option_id = $option->id;
            return $product;
        })->filter();
    
        $totalPages = ceil($totalCount / $perPage);
        $paginationPages = $this->smartPagination($page, $totalPages);
    
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
    
        $tableRows = view("invoice.{$modelType}.add_product_rows", ['products' => $products, 'site' => $site, 'random_amount' => $random_amount])->render();
        $paginationHtml = view("invoice.{$modelType}.pagination", ['totalPages' => $totalPages, 'paginationPages' => $paginationPages, 'currentPage' => $page])->render();
    
        return response()->json(['tableRows' => $tableRows, 'paginationHtml' => $paginationHtml, 'random_amount' => $random_amount, 'currentPage' => $page]);
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
                        'site_name'  => $request->input('remote_site_name') ?? '',
                        'email'      => $request->input('remote_company_email') ?? '',
                        'phone'      => $request->input('remote_company_mobile') ?? '',
                        'address'    => $request->input('remote_company_address') ?? '',
                        'updated_at' => now(),
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

        $personalizationOptions = DB::connection($this->connectionType)->table('personalization_options')
            ->whereIn('product_id', $productIds)
            ->get()
            ->groupBy('product_id');

        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->whereIn('id', $productIds)
            ->select('id', 'category_id', 'name', 'description')
            ->get()
            ->sortBy(function ($product) use ($productIds) {
                return array_search($product->id, $productIds);
            })
            ->values()
            ->map(function ($product) use ($customPrices, $personalizationOptions) {
                $option = isset($personalizationOptions[$product->id]) ? $personalizationOptions[$product->id]->first() : null;
                $storedPrice = $option ? floatval($option->price) : 0;
                $submittedPrice = isset($customPrices[$product->id]) ? floatval($customPrices[$product->id]) : $storedPrice;
                $product->unit_price = $submittedPrice;
                $product->original_unit_price = $storedPrice;
                $product->personalization_label = $option ? $option->label : null;
                $product->personalization_option_id = $option ? $option->id : null;
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
                $option_id = $data['personalization_option_id'] ?? null;
                $new_price = floatval($data['original_unit_price'] ?? $data['unit_price']);

                $query = DB::connection($this->connectionType)->table('personalization_options')
                    ->where('product_id', $product_id);

                if ($option_id) {
                    $query->where('id', $option_id);
                }

                $option = $query->first();

                if (!$option) continue;

                $current_price = floatval($option->price);

                if ($current_price == $new_price) continue;

                $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                    ->where('product_id', $product_id)
                    ->orderByDesc('last_price_changed')
                    ->first();

                if (!$lastUpdate) {
                    DB::connection($this->connectionType)->table('personalization_options')
                        ->where('id', $option->id)
                        ->update(['price' => $new_price]);

                    ProductPriceHistory::create([
                        'site_id' => $site_id,
                        'product_id' => $product_id,
                        'unit_price' => $new_price,
                        'last_price_changed' => now(),
                    ]);
                    continue;
                }

                if (Carbon::parse($lastUpdate->last_price_changed)->diffInMonths(now()) >= 3) {
                    DB::connection($this->connectionType)->table('personalization_options')
                        ->where('id', $option->id)
                        ->update(['price' => $new_price]);

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