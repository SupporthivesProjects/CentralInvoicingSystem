<?php
namespace App\Http\Controllers\BusinessModels\Translation;

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
        $this->productTable = getProductTable($site->technology);
        $this->connectionType = 'dynamic';
    }

    private function getAvailableUrgencyOptions($site)
    {
        $options = [];

        if (!empty($site->urgency_amount) && floatval($site->urgency_amount) > 0) {
            $options['flat'] = [
                'label' => 'Urgent',
                'rate'  => floatval($site->urgency_amount),
                'key'   => 'flat',
            ];
        }

        return $options;
    }

    private function computeUrgencyAmount($site, $urgencyType = null)
    {
        if (empty($urgencyType) || $urgencyType === 'none') {
            return 0;
        }

        if ($urgencyType === 'flat') {
            return floatval($site->urgency_amount ?? 0);
        }

        return 0;
    }

    public function randomProducts(Request $request)
    {
        $site_id = $request->get('site_id');
        $invoiceAmount = floatval($request->get('invoice_amount'));
        $filterType = $request->get('filter_type');

        if (!$invoiceAmount || $invoiceAmount <= 0) {
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'Please provide a valid invoice amount'
            ]);
        }

        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $translationProducts = DB::connection($this->connectionType)
            ->table($this->productTable)
            ->select('id', 'category_id', 'name', 'unit_price', 'slug')
            ->where('published', 1)
            ->where(function ($query) {
                $query->where('name', 'like', '%translation%')
                      ->where(function($q) {
                          $q->where('name', 'like', '%Standard%')
                            ->orWhere('name', 'like', '%Certified%')
                            ->orWhere('name', 'like', '%Business%');
                      });
            })
            ->get();

        if ($translationProducts->isEmpty()) {
            session()->forget('ready_products');
            session()->forget('current_amount');
            session()->forget('last_translation_params');
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'Translation products not found in the database'
            ]);
        }

        $certifiedTranslation = $translationProducts->first(function ($item) {
            $name = Str::lower(trim($item->name));
            return Str::contains($name, 'certified') && Str::contains($name, 'translation');
        });

        $standardTranslation = $translationProducts->first(function ($item) {
            $name = Str::lower(trim($item->name));
            return (Str::contains($name, 'standard') || Str::contains($name, 'business'))
                   && Str::contains($name, 'translation')
                   && !Str::contains($name, 'certified');
        });

        $certifiedPrice = $certifiedTranslation ? floatval($certifiedTranslation->unit_price) : null;
        $standardPrice  = $standardTranslation  ? floatval($standardTranslation->unit_price)  : null;

        $lastParamsRaw = session()->get('last_translation_params', []);
        $lastParams = [
            'certified_pages'   => $lastParamsRaw['certified_pages']   ?? null,
            'standard_words'    => $lastParamsRaw['standard_words']    ?? null,
            'certified_urgency' => $lastParamsRaw['certified_urgency'] ?? null,
            'standard_urgency'  => $lastParamsRaw['standard_urgency']  ?? null,
        ];

        $urgencyOptions = $this->getAvailableUrgencyOptions($site);
        $hasUrgency     = !empty($urgencyOptions);

        $bestMatch        = null;
        $selectedProducts = null;
        $finalTotal       = 0;
        $maxAttempts      = 5;

        for ($attempt = 0; $attempt < $maxAttempts; $attempt++) {

            $preSelectedUrgency = [
                'certified' => $hasUrgency && rand(0, 1) === 1,
                'standard'  => $hasUrgency && rand(0, 1) === 1,
            ];

            $urgentCost = 0;
            if ($preSelectedUrgency['certified']) {
                $urgentCost += $this->computeUrgencyAmount($site, 'flat');
            }
            if ($preSelectedUrgency['standard']) {
                $urgentCost += $this->computeUrgencyAmount($site, 'flat');
            }

            $adjustedInvoiceAmount = $invoiceAmount - $urgentCost;

            $result = $this->findBestTranslationCombination(
                $certifiedTranslation,
                $standardTranslation,
                $certifiedPrice,
                $standardPrice,
                $adjustedInvoiceAmount,
                $filterType,
                $lastParams
            );

            if (!$result) {
                continue;
            }

            $tempProducts = [];
            $currentParams = [
                'certified_pages'   => null,
                'standard_words'    => null,
                'certified_urgency' => null,
                'standard_urgency'  => null,
            ];

            foreach ($result['products'] as $item) {
                $product  = clone $item['product'];
                $quantity = $item['quantity'];

                if ($quantity <= 0) {
                    continue;
                }

                $productName = Str::lower($product->name);
                $isWordBased = !Str::contains($productName, 'certified');

                if ($isWordBased && $quantity < 250) {
                    continue;
                }

                $isCertified = Str::contains($productName, 'certified');
                $urgencyType = 'none';
                $urgencyAdd  = 0;

                if ($isCertified && $preSelectedUrgency['certified']) {
                    $urgencyType = 'flat';
                    $urgencyAdd  = $this->computeUrgencyAmount($site, 'flat');
                } elseif (!$isCertified && $preSelectedUrgency['standard']) {
                    $urgencyType = 'flat';
                    $urgencyAdd  = $this->computeUrgencyAmount($site, 'flat');
                }

                $product->pages           = $quantity;
                $product->unit_type       = $isCertified ? 'pages' : 'words';
                $product->urgency_type    = $urgencyType;
                $product->urgency_add     = $urgencyAdd;
                $product->urgency_options = $urgencyOptions;
                $product->line_total      = ($quantity * floatval($product->unit_price)) + $urgencyAdd;

                if ($isCertified) {
                    $product->product_url               = $site->certified_translation_url ?? $site->site_link;
                    $currentParams['certified_pages']   = $quantity;
                    $currentParams['certified_urgency'] = $urgencyType;
                } else {
                    $product->product_url              = $site->standard_translation_url ?? $site->site_link;
                    $currentParams['standard_words']   = $quantity;
                    $currentParams['standard_urgency'] = $urgencyType;
                }

                $tempProducts[] = $product;
            }

            if (empty($tempProducts)) {
                continue;
            }

            $attemptTotal = collect($tempProducts)->sum('line_total');

            $isDifferent = false;

            if ($currentParams['certified_pages'] !== null &&
                $lastParams['certified_pages'] !== null &&
                $currentParams['certified_pages'] == $lastParams['certified_pages']) {
                $isDifferent = false;
            } elseif ($currentParams['standard_words'] !== null &&
                      $lastParams['standard_words'] !== null &&
                      $currentParams['standard_words'] == $lastParams['standard_words']) {
                $isDifferent = false;
            } elseif ($currentParams['certified_urgency'] !== null &&
                      $lastParams['certified_urgency'] !== null &&
                      $currentParams['certified_urgency'] == $lastParams['certified_urgency'] &&
                      $currentParams['standard_urgency'] !== null &&
                      $lastParams['standard_urgency'] !== null &&
                      $currentParams['standard_urgency'] == $lastParams['standard_urgency']) {
                $isDifferent = false;
            } else {
                $isDifferent = true;
            }

            if ($isDifferent) {
                $bestMatch        = $result;
                $selectedProducts = $tempProducts;
                $finalTotal       = $attemptTotal;

                session()->put('last_translation_params', $currentParams);
                break;
            }
        }

        if (!$selectedProducts) {
            session()->forget('ready_products');
            session()->forget('current_amount');

            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No matching combination found, try again please'
            ]);
        }

        foreach ($selectedProducts as $product) {
            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();

            if ($lastUpdate) {
                $lastPriceChanged    = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays       = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = round(max($remainingDays, 0));
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
            }
        }

        $productList = collect($selectedProducts)->map(function ($product) {
            return [
                'id'           => $product->id,
                'unit_price'   => $product->unit_price,
                'pages'        => $product->pages,
                'urgency_type' => $product->urgency_type,
                'urgency_add'  => $product->urgency_add,
                'unit_type'    => $product->unit_type,
                'product_url'  => $product->product_url,
            ];
        })->toArray();

        session()->forget('ready_products');
        session()->put('ready_products', $productList);
        session(['current_amount' => $finalTotal]);

        $modelType = $site->businessModel->model_type;
        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $selectedProducts,
            'site'     => $site,
            'total'    => $finalTotal
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total'     => $finalTotal
        ]);
    }


    private function findBestTranslationCombination(
        $certifiedTranslation,
        $standardTranslation,
        $certifiedPrice,
        $standardPrice,
        $invoiceAmount,
        $filterType,
        $lastParams
    ) {
        $minWords      = 250;
        $wordIncrement = 50;

        if ($filterType === 'certified' && $certifiedTranslation && $certifiedPrice) {
            $result = $this->findCertifiedOnlyCombination($certifiedTranslation, $certifiedPrice, $invoiceAmount, $lastParams);
            return ['products' => $result, 'total' => $result[0]['total']];
        }

        if ($filterType === 'standard' && $standardTranslation && $standardPrice) {
            $result = $this->findStandardOnlyCombination($standardTranslation, $standardPrice, $invoiceAmount, $minWords, $wordIncrement, $lastParams);
            return ['products' => $result, 'total' => $result[0]['total']];
        }

        if (!$certifiedTranslation || !$standardTranslation || !$certifiedPrice || !$standardPrice) {
            if ($certifiedTranslation && $certifiedPrice) {
                $result = $this->findCertifiedOnlyCombination($certifiedTranslation, $certifiedPrice, $invoiceAmount, $lastParams);
                return ['products' => $result, 'total' => $result[0]['total']];
            }
            if ($standardTranslation && $standardPrice) {
                $result = $this->findStandardOnlyCombination($standardTranslation, $standardPrice, $invoiceAmount, $minWords, $wordIncrement, $lastParams);
                return ['products' => $result, 'total' => $result[0]['total']];
            }
            return null;
        }

        $targetBase           = $invoiceAmount;
        $tolerancePercentages = [0, 1, 2, 3, 4, 5, 6, 8, 10];
        shuffle($tolerancePercentages);

        foreach ($tolerancePercentages as $percentage) {
            $maxTarget = $targetBase * (1 + $percentage / 100);

            $strategies = [
                fn() => $this->strategyCertifiedFirst($certifiedTranslation, $standardTranslation, $certifiedPrice, $standardPrice, $targetBase, $maxTarget, $minWords, $wordIncrement, $lastParams),
                fn() => $this->strategyStandardFirst($certifiedTranslation, $standardTranslation, $certifiedPrice, $standardPrice, $targetBase, $maxTarget, $minWords, $wordIncrement, $lastParams),
                fn() => $this->strategyBalanced($certifiedTranslation, $standardTranslation, $certifiedPrice, $standardPrice, $targetBase, $maxTarget, $minWords, $wordIncrement, $lastParams)
            ];

            shuffle($strategies);

            foreach ($strategies as $strategy) {
                $result = $strategy();

                if ($result && $result['total'] >= $targetBase && $result['total'] <= $maxTarget) {
                    if (!$filterType && count($result['match']) == 2) {
                        return ['products' => $result['match'], 'total' => $result['total']];
                    } elseif ($filterType) {
                        return ['products' => $result['match'], 'total' => $result['total']];
                    }
                }
            }
        }

        $fallbackStrategies = [
            fn() => $this->strategyCertifiedFirst($certifiedTranslation, $standardTranslation, $certifiedPrice, $standardPrice, $targetBase, $invoiceAmount * 1.15, $minWords, $wordIncrement, $lastParams),
            fn() => $this->strategyStandardFirst($certifiedTranslation, $standardTranslation, $certifiedPrice, $standardPrice, $targetBase, $invoiceAmount * 1.15, $minWords, $wordIncrement, $lastParams),
        ];

        foreach ($fallbackStrategies as $fallback) {
            $result = $fallback();
            if ($result && isset($result['match'])) {
                if (!$filterType && count($result['match']) == 2) {
                    return ['products' => $result['match'], 'total' => $result['total']];
                } elseif ($filterType) {
                    return ['products' => $result['match'], 'total' => $result['total']];
                }
            }
        }

        $lastResort = $this->strategyBalanced($certifiedTranslation, $standardTranslation, $certifiedPrice, $standardPrice, $targetBase, $invoiceAmount * 1.20, $minWords, $wordIncrement, $lastParams);
        if ($lastResort && isset($lastResort['match'])) {
            if (!$filterType && count($lastResort['match']) == 2) {
                return ['products' => $lastResort['match'], 'total' => $lastResort['total']];
            } elseif ($filterType) {
                return ['products' => $lastResort['match'], 'total' => $lastResort['total']];
            }
        }

        if (!$filterType) {
            $randomChoice = rand(0, 1);
            if ($randomChoice === 0) {
                $certResult = $this->findCertifiedOnlyCombination($certifiedTranslation, $certifiedPrice, $invoiceAmount, $lastParams);
                return ['products' => $certResult, 'total' => $certResult[0]['total']];
            } else {
                $stdResult = $this->findStandardOnlyCombination($standardTranslation, $standardPrice, $invoiceAmount, $minWords, $wordIncrement, $lastParams);
                return ['products' => $stdResult, 'total' => $stdResult[0]['total']];
            }
        }

        $certResult = $this->findCertifiedOnlyCombination($certifiedTranslation, $certifiedPrice, $invoiceAmount, $lastParams);
        return ['products' => $certResult, 'total' => $certResult[0]['total']];
    }

    private function strategyCertifiedFirst($certTranslation, $stdTranslation, $certPrice, $stdPrice, $targetBase, $maxTarget, $minWords, $wordIncrement, $lastParams)
    {
        $maxCertPages = min(15, ceil($maxTarget / $certPrice));
        $bestResult   = null;
        $bestDistance = PHP_FLOAT_MAX;

        $pageRange = range(1, $maxCertPages);

        if ($lastParams['certified_pages'] !== null) {
            $pageRange = array_diff($pageRange, [$lastParams['certified_pages']]);
        }

        $pageRange = array_values($pageRange);
        shuffle($pageRange);

        foreach ($pageRange as $certPages) {
            $certTotal = $certPages * $certPrice;

            if ($certTotal > $maxTarget) {
                continue;
            }

            $remainingAmount = $targetBase - $certTotal;

            if ($remainingAmount <= 0) {
                continue;
            }

            $minRequiredWords = max($minWords, ceil($remainingAmount / $stdPrice));
            $maxWords         = min(2000, ceil(($maxTarget - $certTotal) / $stdPrice));

            if ($minRequiredWords > $maxWords) {
                continue;
            }

            $step = min($wordIncrement, $maxWords - $minRequiredWords);
            if ($step <= 0) {
                $step = 1;
            }

            $wordRange = range($minRequiredWords, $maxWords, $step);

            if ($lastParams['standard_words'] !== null) {
                $wordRange = array_filter($wordRange, fn($w) => $w != $lastParams['standard_words']);
            }

            $wordRange    = array_values($wordRange);
            shuffle($wordRange);
            $sampledWords = array_slice($wordRange, 0, min(20, count($wordRange)));

            foreach ($sampledWords as $words) {
                if ($words < $minWords) continue;

                $stdTotal = $words * $stdPrice;
                $total    = $certTotal + $stdTotal;

                if ($total >= $targetBase && $total <= $maxTarget) {
                    $distance = abs($total - $targetBase);

                    if ($distance < $bestDistance) {
                        $bestDistance = $distance;
                        $bestResult   = [
                            'match' => [
                                ['product' => $certTranslation, 'quantity' => $certPages, 'total' => $certTotal],
                                ['product' => $stdTranslation,  'quantity' => $words,     'total' => $stdTotal]
                            ],
                            'total'    => $total,
                            'distance' => $distance
                        ];

                        if ($distance <= $targetBase * 0.005) {
                            return $bestResult;
                        }
                    }
                }
            }
        }

        return $bestResult;
    }

    private function strategyStandardFirst($certTranslation, $stdTranslation, $certPrice, $stdPrice, $targetBase, $maxTarget, $minWords, $wordIncrement, $lastParams)
    {
        $maxWords     = min(3000, ceil($maxTarget / $stdPrice));
        $bestResult   = null;
        $bestDistance = PHP_FLOAT_MAX;

        if ($minWords > $maxWords) {
            return null;
        }

        $step = min($wordIncrement, $maxWords - $minWords);
        if ($step <= 0) {
            $step = 1;
        }

        $wordRange = range($minWords, $maxWords, $step);

        if ($lastParams['standard_words'] !== null) {
            $wordRange = array_filter($wordRange, fn($w) => $w != $lastParams['standard_words']);
        }

        $wordRange    = array_values($wordRange);
        shuffle($wordRange);
        $sampledWords = array_slice($wordRange, 0, min(60, count($wordRange)));

        foreach ($sampledWords as $words) {
            if ($words < $minWords) continue;

            $stdTotal = $words * $stdPrice;

            if ($stdTotal > $maxTarget) {
                continue;
            }

            if ($stdTotal >= $targetBase) {
                continue;
            }

            $remainingAmount = $targetBase - $stdTotal;

            if ($remainingAmount >= $certPrice) {
                $certPages = max(1, ceil($remainingAmount / $certPrice));

                if ($lastParams['certified_pages'] !== null && $certPages == $lastParams['certified_pages']) {
                    $certPages = $certPages + 1;
                }

                $certTotal = $certPages * $certPrice;
                $total     = $stdTotal + $certTotal;

                if ($total >= $targetBase && $total <= $maxTarget) {
                    $distance = abs($total - $targetBase);

                    if ($distance < $bestDistance) {
                        $bestDistance = $distance;
                        $bestResult   = [
                            'match' => [
                                ['product' => $certTranslation, 'quantity' => $certPages, 'total' => $certTotal],
                                ['product' => $stdTranslation,  'quantity' => $words,     'total' => $stdTotal]
                            ],
                            'total'    => $total,
                            'distance' => $distance
                        ];

                        if ($distance <= $targetBase * 0.005) {
                            return $bestResult;
                        }
                    }
                }
            }
        }

        return $bestResult;
    }

    private function strategyBalanced($certTranslation, $stdTranslation, $certPrice, $stdPrice, $targetBase, $maxTarget, $minWords, $wordIncrement, $lastParams)
    {
        $bestResult   = null;
        $bestDistance = PHP_FLOAT_MAX;

        $ratios = [
            ['cert' => 0.5, 'std' => 0.5],
            ['cert' => 0.4, 'std' => 0.6],
            ['cert' => 0.6, 'std' => 0.4],
            ['cert' => 0.3, 'std' => 0.7],
            ['cert' => 0.7, 'std' => 0.3]
        ];

        shuffle($ratios);

        foreach ($ratios as $ratio) {
            $certBudget = $targetBase * $ratio['cert'];
            $stdBudget  = $targetBase * $ratio['std'];

            $certPages = max(1, round($certBudget / $certPrice));

            if ($lastParams['certified_pages'] !== null && $certPages == $lastParams['certified_pages']) {
                $certPages = $certPages + rand(-1, 1);
                $certPages = max(1, $certPages);
            }

            $certTotal = $certPages * $certPrice;

            $words = max($minWords, round($stdBudget / $stdPrice));
            $words = ceil($words / $wordIncrement) * $wordIncrement;

            if ($lastParams['standard_words'] !== null && $words == $lastParams['standard_words']) {
                $words = $words + (rand(0, 1) ? $wordIncrement : -$wordIncrement);
                $words = max($minWords, $words);
            }

            $stdTotal = $words * $stdPrice;
            $total    = $certTotal + $stdTotal;

            if ($total >= $targetBase && $total <= $maxTarget) {
                $distance = abs($total - $targetBase);

                if ($distance < $bestDistance) {
                    $bestDistance = $distance;
                    $bestResult   = [
                        'match' => [
                            ['product' => $certTranslation, 'quantity' => $certPages, 'total' => $certTotal],
                            ['product' => $stdTranslation,  'quantity' => $words,     'total' => $stdTotal]
                        ],
                        'total'    => $total,
                        'distance' => $distance
                    ];
                }
            }

            if ($total < $targetBase) {
                $deficit         = $targetBase - $total;
                $additionalWords = max($wordIncrement, ceil($deficit / $stdPrice / $wordIncrement) * $wordIncrement);
                $words          += $additionalWords;
                $stdTotal        = $words * $stdPrice;
                $total           = $certTotal + $stdTotal;

                if ($total >= $targetBase && $total <= $maxTarget) {
                    $distance = abs($total - $targetBase);
                    if ($distance < $bestDistance) {
                        $bestDistance = $distance;
                        $bestResult   = [
                            'match' => [
                                ['product' => $certTranslation, 'quantity' => $certPages, 'total' => $certTotal],
                                ['product' => $stdTranslation,  'quantity' => $words,     'total' => $stdTotal]
                            ],
                            'total'    => $total,
                            'distance' => $distance
                        ];
                    }
                }
            }
        }

        return $bestResult;
    }

    private function findCertifiedOnlyCombination($certTranslation, $certPrice, $invoiceAmount, $lastParams)
    {
        $certPages = max(1, round($invoiceAmount / $certPrice));

        if ($lastParams['certified_pages'] !== null && $certPages == $lastParams['certified_pages']) {
            $certPages = $certPages + rand(-2, 2);
            $certPages = max(1, $certPages);
        }

        $total = $certPages * $certPrice;

        return [
            ['product' => $certTranslation, 'quantity' => $certPages, 'total' => $total]
        ];
    }

    private function findStandardOnlyCombination($stdTranslation, $stdPrice, $invoiceAmount, $minWords, $wordIncrement, $lastParams)
    {
        $words = max($minWords, round($invoiceAmount / $stdPrice));
        $words = round($words / $wordIncrement) * $wordIncrement;

        if ($lastParams['standard_words'] !== null && $words == $lastParams['standard_words']) {
            $words = $words + (rand(0, 1) ? $wordIncrement * 2 : -$wordIncrement * 2);
            $words = max($minWords, $words);
        }

        $total = $words * $stdPrice;

        return [
            ['product' => $stdTranslation, 'quantity' => $words, 'total' => $total]
        ];
    }


    public function updateProduct(Request $request)
    {
        $productId   = $request->get('product_id');
        $pages       = intval($request->get('pages'));
        $siteId      = $request->get('site_id');
        $urgencyType = $request->get('urgency_type', 'none');

        if ($pages <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Pages must be greater than zero'
            ], 400);
        }

        $site = Website::findOrFail($siteId);

        $readyProducts = session('ready_products', []);
        foreach ($readyProducts as &$product) {
            if ($product['id'] == $productId) {
                $product['pages']        = $pages;
                $product['urgency_type'] = $urgencyType;
                $product['urgency_add']  = $this->computeUrgencyAmount($site, $urgencyType);
                break;
            }
        }

        session()->put('ready_products', $readyProducts);

        $totalAmount = 0;
        foreach ($readyProducts as $product) {
            $totalAmount += ($product['unit_price'] * ($product['pages'] ?? 1)) + ($product['urgency_add'] ?? 0);
        }

        session(['current_amount' => $totalAmount]);

        return response()->json([
            'success' => true,
            'total'   => $totalAmount
        ]);
    }


    public function addProducts(Request $request)
    {
        $site_id      = $request->get('site_id');
        $productsData = $request->get('products');

        $site          = Website::findOrFail($site_id);
        $productstable = getProductTable($site->technology);
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
                    'id'           => $productId,
                    'unit_price'   => $unitPrice,
                    'urgency_type' => 'none',
                    'urgency_add'  => 0,
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
            $sessionProduct      = collect($readyProducts)->firstWhere('id', $product->id);
            $product->unit_price = $sessionProduct['unit_price'] ?? $product->unit_price;
            $product->category_name = DB::connection($this->connectionType)->table('categories')->where('id', $product->category_id)->value('name') ?? 'unknown';

            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();

            if ($lastUpdate) {
                $lastPriceChanged    = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays       = now()->diffInDays($nextPriceChangeDate, false);
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
            'site'     => $site,
            'total'    => collect($products)->sum('unit_price')
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total'     => collect($products)->sum('unit_price')
        ]);
    }


    public function removeProduct(Request $request)
    {
        $productId = $request->get('product_id');
        $site_id   = $request->get('site_id');
        $site      = Website::findOrFail($site_id);

        $readyProducts = session('ready_products', []);

        $updatedProducts = collect($readyProducts)->filter(function ($product) use ($productId) {
            return $product['id'] != $productId;
        })->values()->toArray();

        session()->put('ready_products', $updatedProducts);

        if (empty($updatedProducts)) {
            session()->forget('current_amount');
            return response()->json([
                'tableRows' => '',
                'total'     => 0,
                'currency'  => null,
            ]);
        }

        DynamicDatabaseService::connect($site);

        $productIds = array_column($updatedProducts, 'id');

        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'category_id', 'name', 'unit_price', 'slug')
            ->whereIn('id', $productIds)
            ->get();

        $urgencyOptions = $this->getAvailableUrgencyOptions($site);

        $products = $products->map(function ($product) use ($updatedProducts, $site_id, $site, $urgencyOptions) {
            $sessionProduct = collect($updatedProducts)->firstWhere('id', $product->id);

            $pages       = $sessionProduct['pages'] ?? 1;
            $unit_price  = floatval($sessionProduct['unit_price']);
            $urgencyType = $sessionProduct['urgency_type'] ?? 'none';
            $urgencyAdd  = $this->computeUrgencyAmount($site, $urgencyType);

            $product->unit_price      = $unit_price;
            $product->pages           = $pages;
            $product->line_total      = ($unit_price * $pages) + $urgencyAdd;
            $product->urgency_type    = $urgencyType;
            $product->urgency_add     = $urgencyAdd;
            $product->urgency_options = $urgencyOptions;
            $product->unit_type       = Str::contains(Str::lower($product->name), 'certified translation') ? 'pages' : 'words';

            $product->category_name = DB::connection($this->connectionType)->table('categories')
                ->where('id', $product->category_id)
                ->value('name') ?? 'unknown';

            $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                ->where('product_id', $product->id)
                ->orderByDesc('last_price_changed')
                ->first();

            if ($lastUpdate) {
                $lastPriceChanged    = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays       = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = round(max($remainingDays, 0));
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
            }

            return $product;
        });

        $currentAmount = $products->sum('line_total');

        session(['current_amount' => $currentAmount]);

        $modelType = $site->businessModel->model_type;

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $products,
            'site'     => $site,
            'total'    => $currentAmount
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total'     => $currentAmount
        ]);
    }


    public function clearProducts(Request $request)
    {
        session()->forget('ready_products');
        session()->forget('current_amount');

        return response()->json([
            'success'   => true,
            'message'   => 'Randomized products filter has been cleared.',
            'tableRows' => '',
            'currency'  => null,
            'total'     => 0
        ]);
    }


    public function filterProducts(Request $request)
    {
        $site_id       = session('customer.site_id');
        $hasPriceRange = $request->filled('price_from') && $request->filled('price_to');
        $search_type   = $request->input('search_type');
        $keyword       = $request->input('keyword');
        $site          = Website::findOrFail($site_id);
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

        $readyProducts   = session('ready_products', []);
        $readyProductIds = collect($readyProducts)->pluck('id')->toArray();

        if (count($readyProductIds) > 0) {
            $query->whereNotIn('products.id', $readyProductIds);
        }

        $totalCount      = $query->count();
        $page            = $request->input('page', 1);
        $perPage         = 10;
        $offset          = ($page - 1) * $perPage;
        $products        = $query->skip($offset)->take($perPage)->get();
        $totalPages      = ceil($totalCount / $perPage);
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
                $lastPriceChanged    = Carbon::parse($lastUpdate->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays       = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = round(max($remainingDays, 0));
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
            }
        });

        $modelType     = $site->businessModel->model_type;
        $random_amount = session('current_amount', 0);

        $tableRows      = view("invoice.{$modelType}.add_product_rows", ['products' => $products, 'site' => $site, 'random_amount' => $random_amount])->render();
        $paginationHtml = view("invoice.{$modelType}.pagination", ['totalPages' => $totalPages, 'paginationPages' => $paginationPages, 'currentPage' => $page])->render();

        return response()->json(['tableRows' => $tableRows, 'paginationHtml' => $paginationHtml, 'random_amount' => $random_amount]);
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


    public function generateInvoice(Request $request)
    {
        $site_id = $request->input('site_id');
        $site    = Website::findOrFail($site_id);

        DynamicDatabaseService::connect($site);

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

        $invoice_data['site']            = $site;
        $invoice_data['invoice_number']  = $request->input('invoice_number');
        $invoice_data['invoice_date']    = $request->input('invoice_date');
        $invoice_data['customer_name']   = $request->input('customer_name');
        $invoice_data['customer_mobile'] = $request->input('customer_mobile');
        $invoice_data['customer_email']  = $request->input('customer_email');
        $invoice_data['invoice_amount']  = $request->input('invoice_amount');
        $invoice_data['current_amount']  = $request->input('current_amount');
        $invoice_data['discount_amount'] = $request->input('discount_amount');

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

        $invoice_data['invoice_template'] = $site->invoice_template;
        $invoice_data['model_type']       = $site->businessModel->model_type;
        $invoice_data['site_id']          = $site->id;
        $invoice_data['currency']         = site_currency();

        $productsInput = $request->input('products', []);
        DynamicDatabaseService::connect($site);

        $productIds = array_keys($productsInput);

        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->whereIn('id', $productIds)
            ->select('id', 'category_id', 'name', 'unit_price')
            ->get()
            ->sortBy(function ($product) use ($productIds) {
                return array_search($product->id, $productIds);
            })
            ->values()
            ->map(function ($product) use ($productsInput, $site) {
                $input = $productsInput[$product->id];

                $urgencyType = $input['urgency_type'] ?? 'none';
                $urgencyAdd  = $this->computeUrgencyAmount($site, $urgencyType);

                $product->name          = $input['name'] ?? 'Unknown';
                $product->unit_price    = (float) ($input['price'] ?? $product->unit_price);
                $product->pages         = (int) ($input['pages'] ?? 1);
                $product->urgency_type  = $urgencyType;
                $product->urgency_add   = $urgencyAdd;
                $product->is_urgent     = ($urgencyType !== 'none') ? 1 : 0;
                $product->urgent_amount = $urgencyAdd;
                $product->line_total    = ($product->unit_price * $product->pages) + $urgencyAdd;
                $product->from_language = $input['from_language'] ?? null;
                $product->to_language   = $input['to_language'] ?? null;
                $product->selected      = isset($input['selected']) ? 1 : 0;
                $product->unit_type     = Str::contains(Str::lower($product->name), 'certified translation') ? 'pages' : 'words';

                return $product;
            });

        $languages = site_languages()->pluck('name', 'id');

        $products->transform(function ($product) use ($languages) {
            $product->from_language = $languages[$product->from_language] ?? $product->from_language;
            $product->to_language   = $languages[$product->to_language]   ?? $product->to_language;
            return $product;
        });

        $invoice_data['products']    = $products;
        $invoice_data['product_ids'] = $productIds;

        $modelType     = strtolower($site->businessModel->model_type);
        $siteIdInWords = numberToWords($site->id);
        $viewPath      = "websites.{$modelType}.{$siteIdInWords}";

        if (!empty($productsInput)) {
            $this->updateProductPrice($productsInput);
        }

        InvoiceController::createInvoiceHistory($invoice_data);

        if ($request->filled('invoice_file_name')) {
            $filename = $request->input('invoice_file_name') . '.pdf';
        } else {
            $filename = $invoice_data['invoice_number'] . '.pdf';
        }

        try {
            return $this->generateWithApi2Pdf($site, $viewPath, $invoice_data, $filename);
        } catch (\Exception $e) {
            return $this->generateWithDompdf($site, $viewPath, $invoice_data, $filename);
        }
    }


    protected function generateWithDompdf($site, $viewPath, $invoice_data, $filename)
    {
        $pdf = PDF::loadView($viewPath, $invoice_data)->setPaper('A4', 'portrait');
        return $pdf->download($filename);
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


    protected function updateProductPrice($productDataArray)
    {
        $site_id = session('customer.site_id');

        foreach ($productDataArray as $item) {
            $data = is_string($item) ? json_decode($item, true) : $item;

            if (!empty($data['id']) && isset($data['price'])) {
                $product_id = intval($data['id']);
                $new_price  = floatval($data['price']);

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
                        'site_id'            => $site_id,
                        'product_id'         => $product_id,
                        'unit_price'         => $new_price,
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
                        'site_id'            => $site_id,
                        'product_id'         => $product_id,
                        'unit_price'         => $new_price,
                        'last_price_changed' => now(),
                    ]);
                }
            }
        }
    }
}