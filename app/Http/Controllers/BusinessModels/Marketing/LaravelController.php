<?php
namespace App\Http\Controllers\BusinessModels\Marketing;

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
        $this->productTable = getProductTable($site->technology);
        $this->connectionType = 'dynamic';
    }

    protected function generateSlug($categoryId)
    {
        static $categoryCache = [];

        $categorySlugs = [
            'seo packages' => 'seo',
            'ppc packages' => 'ppc',
            'orm packages' => 'orm',
            'social media packages' => 'social',
            'web design and development packages' => 'wdd',
            'email marketing packages' => 'em',
        ];

        if (!isset($categoryCache[$categoryId])) {
            $categoryCache[$categoryId] = DB::connection($this->connectionType)
                ->table('categories')
                ->where('id', $categoryId)
                ->value('name') ?? 'Unknown';
        }

        $name = $categoryCache[$categoryId];
        $normalized = preg_replace('/\s+/', ' ', trim($name));
        $normalizedLower = strtolower($normalized);

        return [
            'category_name' => $normalized,
            'slug' => $categorySlugs[$normalizedLower] ?? \Str::slug($normalized),
        ];
    }


    public function randomProducts(Request $request)
    {
        $site_id = $request->get('site_id');
        $invoiceAmount = floatval($request->get('invoice_amount'));
        $priceFrom = $request->get('price_from');
        $priceTo = $request->get('price_to');
        $categoryId = intval($request->get('category_id'));
        $noOfProducts = intval($request->get('noOfProducts'));

        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $query = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'subscription', 'category_id', 'name', 'unit_price', 'slug')
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
            session()->forget('last_used_combinations');
            session()->forget('randomize_step');
            session()->forget('randomize_invoice_amount');

            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No products found in this range or category.'
            ]);
        }

        // Reset step counter if invoice amount changed since last randomize
        $lastInvoiceAmount = session()->get('randomize_invoice_amount');
        if ($lastInvoiceAmount !== null && abs(floatval($lastInvoiceAmount) - $invoiceAmount) > 0.001) {
            session()->forget('randomize_step');
            session()->forget('last_used_combinations');
        }
        session()->put('randomize_invoice_amount', $invoiceAmount);

        $lastUsedCombinations = session()->get('last_used_combinations', []);

        // Step-based 2% tolerance: step 0 = 0%, step 1 = 2%, step 2 = 4% ... max step 14 = 28%
        $currentStep = intval(session()->get('randomize_step', 0));
        $maxStep = 14; // 15 steps: 0% to 28%

        $bestMatch = null;
        $foundAtStep = $currentStep;

        // Try from currentStep up to maxStep until a new (non-repeated) combo is found
        for ($step = $currentStep; $step <= $maxStep; $step++) {
            $tolerance = $step * 0.02; // 0%, 2%, 4%, ... 28%
            $searchTarget = $invoiceAmount * (1 + $tolerance);

            $candidate = $this->findBestProductCombination($products, $searchTarget, $noOfProducts, $lastUsedCombinations);

            if (!$candidate || empty($candidate['products'])) {
                continue;
            }

            $candidateKey = collect($candidate['products'])->pluck('id')->sort()->join('-');

            if (in_array($candidateKey, $lastUsedCombinations)) {
                continue; // This combo was recently used, try next step
            }

            $bestMatch = $candidate;
            $foundAtStep = $step;
            break;
        }

        if (!$bestMatch || empty($bestMatch['products'])) {
            // All steps exhausted — reset and try from step 0 ignoring history as last resort
            session()->forget('randomize_step');
            session()->forget('last_used_combinations');
            $bestMatch = $this->findBestProductCombination($products, $invoiceAmount, $noOfProducts, []);

            if (!$bestMatch || empty($bestMatch['products'])) {
                return response()->json([
                    'tableRows' => '',
                    'total' => 0,
                    'message' => 'No matching combination found, try again please'
                ]);
            }
            $foundAtStep = 0;
        }

        // Advance step for next click (cycle back to 0 after max)
        $nextStep = ($foundAtStep >= $maxStep) ? 0 : $foundAtStep + 1;
        session()->put('randomize_step', $nextStep);

        $bestMatch = collect($bestMatch['products']);
        $bestTotal = round($bestMatch->sum('unit_price'), 2);

        // Auto-calculate discount so invoice total stays at original invoiceAmount
        $discountAmount = round(max($bestTotal - $invoiceAmount, 0), 2);

        // Store combination key to avoid repeating in next clicks
        $combinationKey = $bestMatch->pluck('id')->sort()->join('-');
        $lastUsedCombinations[] = $combinationKey;
        $lastUsedCombinations = array_slice($lastUsedCombinations, -5);
        session()->put('last_used_combinations', $lastUsedCombinations);

        $bestMatch->each(function ($product) use ($site_id) {
            $data = $this->generateSlug($product->category_id);
            $product->category_name = $data['category_name'];
            $product->slug = $data['slug'];

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

        $productList = $bestMatch->map(function ($product) {
            return [
                'id' => $product->id,
                'unit_price' => $product->unit_price,
            ];
        })->toArray();

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
            'total' => $bestTotal,
            'discount_amount' => $discountAmount,
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
                    // Collect ALL valid candidates in this band, sorted closest to target first
                    $candidates = [];
                    foreach ($sortedIndices as $idx) {
                        $price = $priceMap[$idx];
                        if ($price >= $minTarget && $price <= $maxTarget) {
                            $candidates[] = ['idx' => $idx, 'diff' => abs($price - $target)];
                        }
                    }
                    usort($candidates, fn($a, $b) => $a['diff'] <=> $b['diff']);

                    foreach ($candidates as $candidate) {
                        $comboKey = (string)$products[$candidate['idx']]->id;
                        if (!empty($lastUsedCombinations) && in_array($comboKey, $lastUsedCombinations)) {
                            continue; // skip this specific product, try next closest
                        }
                        return ['products' => [$products[$candidate['idx']]], 'total' => $priceMap[$candidate['idx']]];
                    }
                    // All candidates in this band were used, try next band
                    continue;
                } else if ($count == 2) {
                    if ($percentage > 0 && rand(0, 1) == 1) {
                        continue;
                    }

                    // Collect ALL valid pairs in this band
                    $pairCandidates = [];
                    for ($i = 0; $i < $totalProducts - 1; $i++) {
                        for ($j = $i + 1; $j < $totalProducts; $j++) {
                            $idx1 = $sortedIndices[$i];
                            $idx2 = $sortedIndices[$j];

                            $price1 = $priceMap[$idx1];
                            $price2 = $priceMap[$idx2];

                            if ($price1 == $price2) continue;

                            $total = $price1 + $price2;

                            if ($total >= $minTarget && $total <= $maxTarget) {
                                $comboIds = [$products[$idx1]->id, $products[$idx2]->id];
                                sort($comboIds);
                                $pairCandidates[] = [
                                    'pair' => [$idx1, $idx2],
                                    'total' => $total,
                                    'diff' => abs($total - $target),
                                    'key' => implode('-', $comboIds),
                                ];
                            }
                        }
                    }
                    usort($pairCandidates, fn($a, $b) => $a['diff'] <=> $b['diff']);

                    foreach ($pairCandidates as $candidate) {
                        if (!empty($lastUsedCombinations) && in_array($candidate['key'], $lastUsedCombinations)) {
                            continue; // skip this pair, try next closest
                        }
                        return [
                            'products' => [$products[$candidate['pair'][0]], $products[$candidate['pair'][1]]],
                            'total' => $candidate['total']
                        ];
                    }
                    // All pairs in this band were used, try next band
                }
            }
        }

        $percentages = [0, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 22, 24, 26, 28, 30];

        foreach ($percentages as $percentage) {
            $minTarget = $target;
            $maxTarget = $target * (1 + $percentage / 100);
            $result = $this->tryFindExactCount($products, $priceMap, $sortedIndices, $minTarget, $maxTarget, $count, $totalProducts, $lastUsedCombinations);

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

    private function tryFindExactCount($products, $priceMap, $sortedIndices, $minTarget, $maxTarget, $count, $totalProducts, $lastUsedCombinations = [])
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
        $allCandidates = [];

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
                $comboIds = array_map(fn($idx) => $products[$idx]->id, $selectedIndices);
                sort($comboIds);
                $comboKey = implode('-', $comboIds);

                $allCandidates[] = [
                    'indices' => $selectedIndices,
                    'total' => $total,
                    'diff' => abs($total - $minTarget),
                    'key' => $comboKey,
                ];

                if ($total >= $minTarget && $total <= $minTarget * 1.02) {
                    break;
                }
            }
        }

        if (!empty($allCandidates)) {
            // Deduplicate
            $seen = [];
            $unique = [];
            foreach ($allCandidates as $c) {
                if (!isset($seen[$c['key']])) {
                    $seen[$c['key']] = true;
                    $unique[] = $c;
                }
            }
            usort($unique, fn($a, $b) => $a['diff'] <=> $b['diff']);

            // Return first non-used candidate
            foreach ($unique as $candidate) {
                if (!empty($lastUsedCombinations) && in_array($candidate['key'], $lastUsedCombinations)) {
                    continue;
                }
                $result = [];
                foreach ($candidate['indices'] as $idx) {
                    $result[] = $products[$idx];
                }
                return ['products' => $result, 'total' => $candidate['total']];
            }

            // All were used — return best anyway
            $best = $unique[0];
            $result = [];
            foreach ($best['indices'] as $idx) {
                $result[] = $products[$idx];
            }
            return ['products' => $result, 'total' => $best['total']];
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
        $exactMatch = null;
        foreach ($products as $idx => $product) {
            $price = floatval($product->unit_price);
            $priceMap[$idx] = $price;

            if (abs($price - $target) < 0.01 && $exactMatch === null) {
                $comboKey = (string)$product->id;
                if (empty($lastUsedCombinations) || !in_array($comboKey, $lastUsedCombinations)) {
                    $exactMatch = ['products' => [$product], 'total' => $price];
                }
            }
        }
        if ($exactMatch !== null) {
            return $exactMatch;
        }

        asort($priceMap);
        $sortedIndices = array_keys($priceMap);
        shuffle($sortedIndices);

        $percentages = [0, 2, 4, 6, 8, 10];

        foreach ($percentages as $percentage) {
            $currentMax = $target * (1 + $percentage / 100);
            $result = $this->tryFindFlexible($products, $priceMap, $sortedIndices, $target, $currentMax, $totalProducts, $lastUsedCombinations);

            if ($result !== null && $result['total'] >= $target) {
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

    private function tryFindFlexible($products, $priceMap, $sortedIndices, $minTarget, $maxTarget, $totalProducts, $lastUsedCombinations = [])
    {
        $allCandidates = [];

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
                    $resultIds = array_map(fn($i) => $products[$i]->id, $selected);
                    sort($resultIds);
                    $comboKey = implode('-', $resultIds);

                    $allCandidates[] = [
                        'indices' => $selected,
                        'total' => $total,
                        'diff' => $diff,
                        'key' => $comboKey,
                    ];
                }
            }

            if ($total >= $minTarget && $total <= $maxTarget) {
                $diff = abs($total - $minTarget);
                $resultIds = array_map(fn($i) => $products[$i]->id, $selected);
                sort($resultIds);
                $comboKey = implode('-', $resultIds);
                $allCandidates[] = [
                    'indices' => $selected,
                    'total' => $total,
                    'diff' => $diff,
                    'key' => $comboKey,
                ];
            }
        }

        if (empty($allCandidates)) {
            return null;
        }

        // Deduplicate by key
        $seen = [];
        $unique = [];
        foreach ($allCandidates as $c) {
            if (!isset($seen[$c['key']])) {
                $seen[$c['key']] = true;
                $unique[] = $c;
            }
        }

        // Sort by diff ascending (closest to target first)
        usort($unique, fn($a, $b) => $a['diff'] <=> $b['diff']);

        // Return first candidate not in lastUsedCombinations
        foreach ($unique as $candidate) {
            if (!empty($lastUsedCombinations) && in_array($candidate['key'], $lastUsedCombinations)) {
                continue;
            }
            $result = [];
            foreach ($candidate['indices'] as $idx) {
                $result[] = $products[$idx];
            }
            return ['products' => $result, 'total' => $candidate['total']];
        }

        // All candidates were used — return the best one anyway (unavoidable repeat)
        $best = $unique[0];
        $result = [];
        foreach ($best['indices'] as $idx) {
            $result[] = $products[$idx];
        }
        return ['products' => $result, 'total' => $best['total']];
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
            ->select('id', 'subscription', 'category_id', 'name', 'unit_price', 'slug')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $products = collect($productIds)->map(function ($id) use ($products) {
            return $products[$id];
        });

        $products = $products->map(function ($product) use ($readyProducts, $site_id) {
            $sessionProduct = collect($readyProducts)->firstWhere('id', $product->id);
            $product->unit_price = $sessionProduct['unit_price'] ?? $product->unit_price;

            $data = $this->generateSlug($product->category_id);
            $product->category_name = $data['category_name'];
            $product->slug = $data['slug'];

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
            ->select('id', 'subscription', 'category_id', 'name', 'unit_price', 'slug')
            ->whereIn('id', $productIds)
            ->get();

        $products = $products->map(function ($product) use ($updatedProducts, $site_id) {
            $sessionProduct = collect($updatedProducts)->firstWhere('id', $product->id);
            $product->unit_price = $sessionProduct['unit_price'] ?? $product->unit_price;

            $data = $this->generateSlug($product->category_id);
            $product->category_name = $data['category_name'];
            $product->slug = $data['slug'];

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
        $category_id = $request->get('category_id');
        $productId = $request->get('product_id');
        $subscription = $request->get('subscription');
        $productName = $request->get('product_name');
        $published = $request->get('published');
        $site_id = session('customer.site_id');

        if (!$site_id) {
            return response()->json(['error' => 'Site ID not found in session.']);
        }

        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        if ($productName !== null && trim($productName) !== '') {
            $currentProduct = DB::connection($this->connectionType)
                ->table($this->productTable)
                ->where('id', $productId)
                ->first();

            if (!$currentProduct) {
                return response()->json(['error' => 'Product not found.']);
            }

            $currentName = $currentProduct->name;
            $updateData = ['name' => trim($productName)];

            if ($published !== null) {
                $updateData['published'] = $published;
            }

            DB::connection($this->connectionType)
                ->table($this->productTable)
                ->where('name', $currentName)
                ->update($updateData);
        }

        if (!$subscription && !$category_id) {
            $readyProducts = session()->get('ready_products', []);
            $productIds = collect($readyProducts)->pluck('id')->toArray();

            $products = DB::connection($this->connectionType)->table($this->productTable)
                ->select('id', 'subscription', 'category_id', 'name', 'unit_price', 'slug', 'published')
                ->whereIn('id', $productIds)
                ->get()
                ->keyBy('id');

            $products = collect($productIds)->map(function ($id) use ($products) {
                return $products[$id];
            });

            $products = $products->map(function ($product) use ($readyProducts, $site_id) {
                $sessionProduct = collect($readyProducts)->firstWhere('id', $product->id);
                $product->subscription = $sessionProduct['subscription'] ?? $product->subscription;

                $data = $this->generateSlug($product->category_id);
                $product->category_name = $data['category_name'];
                $product->slug = $data['slug'];

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

            $totalAmount = collect($readyProducts)->sum('unit_price');
            session(['current_amount' => $totalAmount]);

            $modelType = $site->businessModel->model_type;
            $tableRows = view("invoice.{$modelType}.random_product_rows", [
                'products' => $products,
                'site' => $site,
                'total' => $totalAmount
            ])->render();

            return response()->json([
                'tableRows' => $tableRows,
                'total' => $totalAmount
            ]);
        }

        $readyProducts = session()->get('ready_products', []);

        $productIndex = null;
        foreach ($readyProducts as $index => $product) {
            if ($product['id'] == $productId) {
                $productIndex = $index;
                break;
            }
        }

        $currentProduct = DB::connection($this->connectionType)
            ->table($this->productTable)
            ->where('id', $productId)
            ->first();

        if (!$currentProduct) {
            return response()->json(['error' => 'Product not found.']);
        }

        $currentProductName = $currentProduct->name;

        $newProduct = DB::connection($this->connectionType)
            ->table($this->productTable)
            ->where('subscription', $subscription)
            ->where('category_id', $category_id)
            ->where('name', 'like', "%{$currentProductName}%")
            ->first();

        if (!$newProduct) {
            return response()->json(['error' => "The duration '{$subscription}' was not found in the same package."]);
        }

        if ($productIndex !== null) {
            $readyProducts[$productIndex] = [
                'id' => $newProduct->id,
                'subscription' => $newProduct->subscription,
                'unit_price' => $newProduct->unit_price,
            ];
        } else {
            $readyProducts[] = [
                'id' => $newProduct->id,
                'subscription' => $newProduct->subscription,
                'unit_price' => $newProduct->unit_price,
            ];
        }

        session()->put('ready_products', array_values($readyProducts));

        $productIds = collect($readyProducts)->pluck('id')->toArray();
        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'subscription', 'category_id', 'name', 'unit_price', 'slug', 'published')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $products = collect($productIds)->map(function ($id) use ($products) {
            return $products[$id];
        });

        $products = $products->map(function ($product) use ($readyProducts, $site_id) {
            $sessionProduct = collect($readyProducts)->firstWhere('id', $product->id);
            $product->subscription = $sessionProduct['subscription'] ?? $product->subscription;

            $data = $this->generateSlug($product->category_id);
            $product->category_name = $data['category_name'];
            $product->slug = $data['slug'];

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

        $totalAmount = collect($readyProducts)->sum('unit_price');
        session(['current_amount' => $totalAmount]);

        $modelType = $site->businessModel->model_type;
        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $products,
            'site' => $site,
            'total' => $totalAmount
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total' => $totalAmount
        ]);
    }


    public function clearProducts(Request $request)
    {
        session()->forget('ready_products');
        session()->forget('current_amount');
        session()->forget('last_used_combinations');
        session()->forget('randomize_step');
        session()->forget('randomize_invoice_amount');
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
        $search_type = $request->input('search_type');
        $keyword = $request->input('keyword');
        $sortUnitPrice = $request->input('sort_unit_price', 'asc');
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $hasPriceRange = $request->filled('price_from') && $request->filled('price_to');

        if (!$hasPriceRange) {
            return response()->json([
                'tableRows' => '<tr><td colspan="6" class="text-center text-muted">Please enter a keyword or price range to search.</td></tr>'
            ]);
        }

        $query = DB::connection($this->connectionType)
            ->table($this->productTable)
            ->select('products.id', 'products.subscription', 'products.category_id', 'products.name', 'products.unit_price', 'products.slug')
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

        $productIds = $products->pluck('id')->toArray();
        $categoryIds = $products->pluck('category_id')->unique()->toArray();

        $categories = DB::connection($this->connectionType)
            ->table('categories')
            ->whereIn('id', $categoryIds)
            ->pluck('name', 'id');

        $priceHistories = ProductPriceHistory::where('site_id', $site_id)
            ->whereIn('product_id', $productIds)
            ->orderByDesc('last_price_changed')
            ->get()
            ->groupBy('product_id');

        $products->each(function ($product) use ($categories, $priceHistories) {
            $data = $this->generateSlug($product->category_id);
            $product->category_name = $data['category_name'];
            $product->slug = $data['slug'];

            $lastUpdate = $priceHistories[$product->id][0] ?? null;
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
        $productIds = [];
        $customPrices = [];

        foreach ($productDataArray as $item) {
            $data = json_decode($item, true);
            if (!empty($data['product_id'])) {
                $productIds[] = $data['product_id'];
                $customPrices[$data['product_id']] = $data['unit_price'];
            }
        }

        $products = DB::connection($this->connectionType)
            ->table($this->productTable)
            ->whereIn('id', $productIds)
            ->select('id', 'subscription', 'category_id', 'name', 'unit_price')
            ->get()
            ->sortBy(function ($product) use ($productIds) {
                return array_search($product->id, $productIds);
            })
            ->values()
            ->map(function ($product) use ($customPrices) {
                $product->unit_price = $customPrices[$product->id] ?? $product->unit_price;

                $data = $this->generateSlug($product->category_id);
                $product->category_name = $data['category_name'];
                $product->slug = $data['slug'];

                return $product;
            });

        $invoice_data['products'] = $products;
        $invoice_data['product_ids'] = $productIds;

        $modelType = strtolower($site->businessModel->model_type);
        $siteIdInWords = numberToWords($site->id);
        $viewPath = "websites.{$modelType}.{$siteIdInWords}";

        $this->updateProductPrice($productDataArray);
        InvoiceController::createInvoiceHistory($invoice_data);

        $filename = $request->filled('invoice_file_name')
            ? $request->input('invoice_file_name') . '.pdf'
            : $invoice_data['invoice_number'] . '.pdf';

        try {
            return $this->generateWithApi2Pdf($site, $viewPath, $invoice_data, $filename);
        } catch (\Exception $e) {
            \Log::error('API2PDF failed: ' . $e->getMessage());
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