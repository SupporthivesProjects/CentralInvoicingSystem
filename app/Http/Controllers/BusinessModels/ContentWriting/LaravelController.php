<?php
namespace App\Http\Controllers\BusinessModels\ContentWriting;

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

    public function randomProducts(Request $request)
    {
        set_time_limit(300);
        $site_id = $request->get('site_id');
        $invoiceAmount = floatval($request->get('invoice_amount'));
        $priceFrom = $request->get('price_from');
        $priceTo = $request->get('price_to');
        $keyword = $request->get('keyword');
        $noOfProducts = intval($request->get('noOfProducts'));

        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $query = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'name', 'slug', 'default_wc', 'default_price', 'extra_word', 'ta_standard', 'ta_express', 'q_standard', 'q_premium', 'q_expert', 'img_price')
            ->where('published', 1);

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('slug', 'LIKE', '%' . $keyword . '%');
            });
        }

        $allProducts = $query->orderByDesc('default_price')->get();
        $turnaroundOptions = ['ta_standard', 'ta_express'];
        $qualityOptions = ['q_standard', 'q_premium', 'q_expert'];

        $allProducts = collect($allProducts);
        $allProducts->each(function ($product) use ($turnaroundOptions, $qualityOptions) {
            $product->turnaround = $turnaroundOptions[array_rand($turnaroundOptions)];
            $product->quality = $qualityOptions[array_rand($qualityOptions)];
            $product->imagecount = rand(1, 15);
            $product->quantity = 1;

            $qlty_factor = match ($product->quality) {
                'q_premium' => 0.1,
                'q_expert' => 0.25,
                default => 0,
            };

            $wc_price = 0;
            $img_total = max(0, ($product->imagecount - 1) * $product->img_price);
            $ta_total = $product->turnaround === 'ta_express' ? 25 : 0;

            $base_total = $product->default_price + $wc_price + $img_total + $ta_total;
            $product->unit_price = ($base_total + ($base_total * $qlty_factor));
            $product->wordcount = $product->default_wc;
        });

        $allProducts = $allProducts->filter(function ($product) use ($priceFrom, $priceTo) {
            return $product->unit_price >= $priceFrom && $product->unit_price <= $priceTo;
        })->values();

        $minTotal = ($noOfProducts || $keyword) ? ($invoiceAmount * 0.8) : $invoiceAmount;
        $maxTotal = $invoiceAmount * 1.05;
        $bestMatch = null;
        $bestTotal = 0;
        $bestDistance = null;

        for ($i = 0; $i < 20; $i++) {
            $shuffled = $allProducts->shuffle();

            if ($noOfProducts) {
                $selected = $shuffled->take($noOfProducts);
                $currentTotal = 0;
                $finalProducts = [];

                foreach ($selected as $product) {
                    $clone = clone $product;
                    $clone->imagecount = rand(1, 15);
                    $clone->turnaround = $turnaroundOptions[array_rand($turnaroundOptions)];
                    $clone->quality = $qualityOptions[array_rand($qualityOptions)];
                    $clone->quantity = 1;

                    $qlty_factor = match ($clone->quality) {
                        'q_premium' => 0.1,
                        'q_expert' => 0.25,
                        default => 0,
                    };

                    $img_total = max(0, ($clone->imagecount - 1) * $clone->img_price);
                    $ta_total = $clone->turnaround === 'ta_express' ? 25 : 0;
                    $base_total = $clone->default_price + $img_total + $ta_total;
                    $adjusted_base = $base_total + ($base_total * $qlty_factor);

                    $clone->wordcount = $clone->default_wc;
                    $clone->unit_price = $adjusted_base;
                    $finalProducts[] = $clone;
                    $currentTotal += $clone->unit_price;
                }

                $remaining = $invoiceAmount - $currentTotal;
                $remaining = max(0, $remaining);

                while ($remaining > 0.1) {
                    foreach ($finalProducts as $product) {
                        if ($remaining <= 0.1) break;

                        $qlty_factor = match ($product->quality) {
                            'q_premium' => 0.1,
                            'q_expert' => 0.25,
                            default => 0,
                        };

                        $effectiveWordPrice = $product->extra_word * (1 + $qlty_factor);
                        if ($effectiveWordPrice <= 0) continue;

                        $gap = $remaining;
                        $increment = $gap >= 1000 ? 500 : 25;

                        $cost = ($increment / 25) * $effectiveWordPrice;

                        if ($remaining >= $cost) {
                            $product->wordcount += $increment;
                            $product->unit_price += $cost;
                            $remaining -= $cost;
                        }
                    }
                }

                $currentTotal = array_sum(array_map(fn($p) => $p->unit_price, $finalProducts));
                $distance = abs($invoiceAmount - $currentTotal);

                if ($bestMatch === null || $distance < $bestDistance) {
                    $bestMatch = $finalProducts;
                    $bestTotal = $currentTotal;
                    $bestDistance = $distance;
                    if ($currentTotal >= ($minTotal)) break;
                }
            } else {
                $selected = [];
                $currentTotal = 0;
                $finalProducts = [];

                foreach ($shuffled as $product) {
                    if ($currentTotal + $product->unit_price <= $maxTotal) {
                        $clone = clone $product;
                        $finalProducts[] = $clone;
                        $currentTotal += $clone->unit_price;
                    }
                }

                $remaining = $invoiceAmount - $currentTotal;
                $remaining = max(0, $remaining);

                while ($remaining > 0.1) {
                    foreach ($finalProducts as $product) {
                        if ($remaining <= 0.1) break;

                        $qlty_factor = match ($product->quality) {
                            'q_premium' => 0.1,
                            'q_expert' => 0.25,
                            default => 0,
                        };

                        $effectiveWordPrice = $product->extra_word * (1 + $qlty_factor);
                        if ($effectiveWordPrice <= 0) continue;

                        $gap = $remaining;
                        $increment = $gap >= 1000 ? 500 : 25;

                        $cost = ($increment / 25) * $effectiveWordPrice;

                        if ($remaining >= $cost) {
                            $product->wordcount += $increment;
                            $product->unit_price += $cost;
                            $remaining -= $cost;
                        }
                    }
                }

                $currentTotal = array_sum(array_map(fn($p) => $p->unit_price, $finalProducts));
                $distance = abs($invoiceAmount - $currentTotal);

                if ($bestMatch === null || $distance < $bestDistance) {
                    $bestMatch = $finalProducts;
                    $bestTotal = $currentTotal;
                    $bestDistance = $distance;
                    if ($currentTotal >= ($invoiceAmount * 0.99)) break;
                }
            }
        }

        if (!$bestMatch) {
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No matching combination found, try again please'
            ]);
        }

        $bestMatch = collect($bestMatch);
        $bestMatch->each(function ($product) use ($site_id) {
            $product->can_edit_price = 1;
            $product->remaining_days = 0;
            $product->project_title = null;
            $product->reference_link = null;
            $product->subject = null;
            $product->preferred_voice = null;
            $product->preferred_writing_style = null;
            $product->brand_name = null;
            $product->audience = null;
            $product->note = null;
            $product->param_status = !empty($product->project_title) && !empty($product->note) && !empty($product->subject);
        });

        $productList = $bestMatch->map(function ($product) {
            return [
                'id' => $product->id,
                'wordcount' => $product->wordcount,
                'imagecount' => $product->imagecount,
                'quantity' => $product->quantity,
                'turnaround' => $product->turnaround,
                'quality' => $product->quality,
                'unit_price' => $product->unit_price,
                'project_title' => null,
                'reference_link' => null,
                'subject' => null,
                'preferred_voice' => null,
                'preferred_writing_style' => null,
                'brand_name' => null,
                'audience' => null,
                'note' => null
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
            'total' => $bestTotal
        ]);
    }

    public function randomProduct(Request $request)
    {
        set_time_limit(270);
        $productId = $request->input('product_id');
        $invoiceAmount = floatval(session('invoice.invoice_amount'));
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $product = DB::connection($this->connectionType)
            ->table($this->productTable)
            ->select('id', 'name', 'slug', 'default_wc', 'default_price', 'extra_word', 'ta_standard', 'ta_express', 'q_standard', 'q_premium', 'q_expert', 'img_price')
            ->where('published', 1)
            ->where('id', $productId)
            ->first();

        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found'], 404);
        }

        $readyProducts = session('ready_products', []);
        $targetProduct = collect($readyProducts)->firstWhere('id', $productId);
        $turnaround = $targetProduct['turnaround'] ?? 'ta_standard';
        $quality = $targetProduct['quality'] ?? 'q_standard';
        $otherProducts = collect($readyProducts)->filter(fn($p) => $p['id'] != $product->id)->values();

        $imageCount = rand(7, 15);
        $wordCount = $product->default_wc;

        $qlty_factor = match ($quality) {
            'q_premium' => 0.1,
            'q_expert' => 0.25,
            default => 0,
        };

        $remainingAmount = $invoiceAmount;
        foreach ($otherProducts as $item) {
            $remainingAmount -= $item['unit_price'];
        }

        $maxWordCount = 300000;
        $minWordCount = $product->default_wc;
        $maxImageCount = 15;
        $minImageCount = 1;

        $maxIterations = 700;
        $iterations = 0;
        $bestMatch = null;
        $smallestDiff = PHP_INT_MAX;

        while ($iterations++ < $maxIterations) {
            $wc_price = max(0, ($wordCount - $product->default_wc) * ($product->extra_word / 25));
            $img_total = max(0, ($imageCount - 1) * $product->img_price);
            $ta_total = $turnaround === 'ta_express' ? 25 : 0;

            $base_total = $product->default_price + $wc_price + $img_total + $ta_total;
            $unit_price = $base_total + ($base_total * $qlty_factor);
            $diff = $remainingAmount - $unit_price;

            if (abs($diff) < $smallestDiff) {
                $smallestDiff = abs($diff);
                $bestMatch = [
                    'wordCount' => $wordCount,
                    'imageCount' => $imageCount,
                    'quality' => $quality,
                    'turnaround' => $turnaround,
                    'unit_price' => $unit_price,
                ];
            }

            if (round($unit_price, 2) === round($remainingAmount, 2)) {
                break;
            }

            if (abs($diff) < 0.01) {
                if ($diff > 0 && $wordCount < $maxWordCount) {
                    $wordCount++;
                    continue;
                } elseif ($diff < 0 && $wordCount > $minWordCount) {
                    $wordCount--;
                    continue;
                } else {
                    break;
                }
            }

            if ($diff > 0) {
                $turnaroundOptions = ['ta_standard', 'ta_express'];
                $qualityOptions = ['q_standard', 'q_premium', 'q_expert'];
                $turnaround = $turnaroundOptions[array_rand($turnaroundOptions)];
                $quality = $qualityOptions[array_rand($qualityOptions)];
                $qlty_factor = match ($quality) {
                    'q_premium' => 0.1,
                    'q_expert' => 0.25,
                    default => 0,
                };

                if ($diff > 1000) {
                    $wordCount += 500;
                } elseif ($diff > 750) {
                    $wordCount += 300;
                } elseif ($diff > 500) {
                    $wordCount += 200;
                } elseif ($diff > 300) {
                    $wordCount += 150;
                } elseif ($diff > 200) {
                    $wordCount += 100;
                } elseif ($diff > 100) {
                    $wordCount += 50;
                } elseif ($diff > 25) {
                    $wordCount += 10;
                } else {
                    $wordCount += 1;
                }

                if ($wordCount > $maxWordCount) {
                    break;
                }
            } else {
                if ($wordCount > $minWordCount) {
                    if ($diff < -25) {
                        $wordCount -= 10;
                    } else {
                        $wordCount -= 1;
                    }
                } elseif ($imageCount > $minImageCount) {
                    $imageCount--;
                } elseif ($quality === 'q_expert') {
                    $quality = 'q_premium';
                    $qlty_factor = 0.10;
                } elseif ($quality === 'q_premium') {
                    $quality = 'q_standard';
                    $qlty_factor = 0.00;
                } elseif ($turnaround === 'ta_express') {
                    $turnaround = 'ta_standard';
                } else {
                    break;
                }
            }
        }

        if ($bestMatch) {
            $wordCount = $bestMatch['wordCount'];
            $imageCount = $bestMatch['imageCount'];
            $quality = $bestMatch['quality'];
            $turnaround = $bestMatch['turnaround'];
            $unit_price = $bestMatch['unit_price'];
        } else {
            return response()->json(['status' => false, 'message' => 'Unable to match invoice amount.']);
        }

        $updatedProduct = [
            'id' => $product->id,
            'wordcount' => $wordCount,
            'imagecount' => $imageCount,
            'quantity' => 1,
            'turnaround' => $turnaround,
            'quality' => $quality,
            'unit_price' => $unit_price,
            'project_title' => $targetProduct['project_title'] ?? null,
            'reference_link' => $targetProduct['reference_link'] ?? null,
            'subject' => $targetProduct['subject'] ?? null,
            'preferred_voice' => $targetProduct['preferred_voice'] ?? null,
            'preferred_writing_style' => $targetProduct['preferred_writing_style'] ?? null,
            'brand_name' => $targetProduct['brand_name'] ?? null,
            'audience' => $targetProduct['audience'] ?? null,
            'note' => $targetProduct['note'] ?? null
        ];

        $foundIndex = collect($readyProducts)->search(fn($p) => $p['id'] == $productId);
        if ($foundIndex !== false) {
            $readyProducts[$foundIndex] = $updatedProduct;
        } else {
            $readyProducts[] = $updatedProduct;
        }

        session()->put('ready_products', $readyProducts);
        $productIds = collect($readyProducts)->pluck('id')->toArray();

        $productsFromDb = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'name', 'slug', 'default_wc', 'default_price', 'extra_word', 'ta_standard', 'ta_express', 'q_standard', 'q_premium', 'q_expert', 'img_price')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $recalculatedProducts = collect($readyProducts)->map(function ($sessionProduct) use ($productsFromDb) {
            $product = $productsFromDb->get($sessionProduct['id']);
            if (!$product) return null;

            $product->turnaround = $sessionProduct['turnaround'] ?? 'ta_standard';
            $product->quality = $sessionProduct['quality'] ?? 'q_standard';
            $product->unit_price = $sessionProduct['unit_price'] ?? 0.00;
            $product->wordcount = $sessionProduct['wordcount'] ?? 1;
            $product->imagecount = $sessionProduct['imagecount'] ?? $sessionProduct['image_count'] ?? 1;
            $product->quantity = $sessionProduct['quantity'] ?? 1;

            $product->can_edit_price = 1;
            $product->remaining_days = 0;
            $product->project_title = $sessionProduct['project_title'] ?? null;
            $product->reference_link = $sessionProduct['reference_link'] ?? null;
            $product->subject = $sessionProduct['subject'] ?? null;
            $product->preferred_voice = $sessionProduct['preferred_voice'] ?? null;
            $product->preferred_writing_style = $sessionProduct['preferred_writing_style'] ?? null;
            $product->brand_name = $sessionProduct['brand_name'] ?? null;
            $product->audience = $sessionProduct['audience'] ?? null;
            $product->note = $sessionProduct['note'] ?? null;

            $product->param_status = !empty($product->project_title) && !empty($product->note) && !empty($product->subject);
            return $product;
        })->filter()->values();

        $modelType = $site->businessModel->model_type;
        $totalAmount = $recalculatedProducts->sum('unit_price');
        session(['current_amount' => $totalAmount]);

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $recalculatedProducts,
            'site' => $site,
            'total' => $totalAmount
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total' => $totalAmount
        ]);
    }



    public function randomProduct_old(Request $request)
    {
        set_time_limit(270);
        $productId = $request->input('product_id');
        $invoiceAmount = floatval(session('invoice.invoice_amount'));
        $site_id = session('customer.site_id');
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $product = DB::connection($this->connectionType)
            ->table($this->productTable)
            ->select('id', 'name', 'slug', 'default_wc', 'default_price', 'extra_word', 'ta_standard', 'ta_express', 'q_standard', 'q_premium', 'q_expert', 'img_price')
            ->where('published', 1)
            ->where('id', $productId)
            ->first();

        if (!$product) {
            return response()->json(['status' => false, 'message' => 'Product not found'], 404);
        }

        $readyProducts = session('ready_products', []);
        $targetProduct = collect($readyProducts)->firstWhere('id', $productId);
        $turnaround = $targetProduct['turnaround'] ?? 'ta_standard';
        $quality = $targetProduct['quality'] ?? 'q_standard';
        $otherProducts = collect($readyProducts)->filter(fn($p) => $p['id'] != $product->id)->values();

        $imageCount = rand(7, 15);
        $wordCount = $product->default_wc;

        $qlty_factor = match ($quality) {
            'q_premium' => 0.1,
            'q_expert' => 0.25,
            default => 0,
        };

        $remainingAmount = $invoiceAmount;
        foreach ($otherProducts as $item) {
            $remainingAmount -= $item['unit_price'];
        }

        $maxWordCount = 300000;
        $minWordCount = $product->default_wc;
        $maxImageCount = 15;
        $minImageCount = 1;

        $maxIterations = 700;
        $iterations = 0;
        $bestMatch = null;
        $smallestDiff = PHP_INT_MAX;

        while ($iterations++ < $maxIterations) {
            $wc_price = max(0, (($wordCount - $product->default_wc) / 25) * $product->extra_word);
            $img_total = max(0, ($imageCount - 1) * $product->img_price);
            $ta_total = $turnaround === 'ta_express' ? 25 : 0;

            $base_total = $product->default_price + $wc_price + $img_total + $ta_total;
            $unit_price = $base_total + ($base_total * $qlty_factor);
            $diff = $remainingAmount - $unit_price;

            if (abs($diff) < $smallestDiff) {
                $smallestDiff = abs($diff);
                $bestMatch = [
                    'wordCount' => $wordCount,
                    'imageCount' => $imageCount,
                    'quality' => $quality,
                    'turnaround' => $turnaround,
                    'unit_price' => $unit_price,
                ];
            }

            if (abs($diff) < 0.01) {
                break;
            }

            if ($diff > 0) {

                $turnaroundOptions = ['ta_standard', 'ta_express'];
                $qualityOptions = ['q_standard', 'q_premium', 'q_expert'];
                $turnaround = $turnaroundOptions[array_rand($turnaroundOptions)];
                $quality = $qualityOptions[array_rand($qualityOptions)];

                $increment = 25;
                if ($diff > 1000) {
                    $increment = 500;
                } elseif ($diff > 750) {
                    $increment = 300;
                } elseif ($diff > 500) {
                    $increment = 200;
                } elseif ($diff > 300) {
                    $increment = 150;
                } elseif ($diff > 200) {
                    $increment = 100;
                } elseif ($diff > 100) {
                    $increment = 50;
                }

                if ($wordCount + $increment <= $maxWordCount) {
                    $wordCount += $increment;
                } else {
                    break;
                }
            } else {
                if ($wordCount - 25 >= $minWordCount) {
                    $nextWordCount25 = $wordCount - 25;
                    $priceWith25 = $product->default_price + max(0, (($nextWordCount25 - $product->default_wc) / 25) * $product->extra_word) + $img_total + $ta_total;
                    $priceWith25 += $priceWith25 * $qlty_factor;

                    if ($priceWith25 < $remainingAmount) {
                        $nextWordCount5 = $wordCount - 5;
                        if ($nextWordCount5 >= $minWordCount) {
                            $priceWith5 = $product->default_price + max(0, (($nextWordCount5 - $product->default_wc) / 25) * $product->extra_word) + $img_total + $ta_total;
                            $priceWith5 += $priceWith5 * $qlty_factor;

                            if ($priceWith5 >= $remainingAmount && abs($remainingAmount - $priceWith5) < abs($diff)) {
                                $wordCount = $nextWordCount5;
                                continue;
                            } else {
                                break;
                            }
                        } else {
                            break;
                        }
                    } else {
                        $wordCount = $nextWordCount25;
                        continue;
                    }
                }

                if ($imageCount > $minImageCount) {
                    $imageCount--;
                    continue;
                }

                if ($quality === 'q_expert') {
                    $quality = 'q_premium';
                    $qlty_factor = 0.10;
                    continue;
                } elseif ($quality === 'q_premium') {
                    $quality = 'q_standard';
                    $qlty_factor = 0.00;
                    continue;
                }

                if ($turnaround === 'ta_express') {
                    $turnaround = 'ta_standard';
                    continue;
                }

                break;
            }
        }

        if ($bestMatch) {
            $wordCount = $bestMatch['wordCount'];
            $imageCount = $bestMatch['imageCount'];
            $quality = $bestMatch['quality'];
            $turnaround = $bestMatch['turnaround'];
            $unit_price = $bestMatch['unit_price'];
        }

        $updatedProduct = [
            'id' => $product->id,
            'wordcount' => $wordCount,
            'imagecount' => $imageCount,
            'quantity' => 1,
            'turnaround' => $turnaround,
            'quality' => $quality,
            'unit_price' => $unit_price,
            'project_title' => $targetProduct['project_title'] ?? null,
            'reference_link' => $targetProduct['reference_link'] ?? null,
            'subject' => $targetProduct['subject'] ?? null,
            'preferred_voice' => $targetProduct['preferred_voice'] ?? null,
            'preferred_writing_style' => $targetProduct['preferred_writing_style'] ?? null,
            'brand_name' => $targetProduct['brand_name'] ?? null,
            'audience' => $targetProduct['audience'] ?? null,
            'note' => $targetProduct['note'] ?? null
        ];

        $foundIndex = collect($readyProducts)->search(fn($p) => $p['id'] == $productId);
        if ($foundIndex !== false) {
            $readyProducts[$foundIndex] = $updatedProduct;
        } else {
            $readyProducts[] = $updatedProduct;
        }

        session()->put('ready_products', $readyProducts);
        $productIds = collect($readyProducts)->pluck('id')->toArray();

        $productsFromDb = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'name', 'slug', 'default_wc', 'default_price', 'extra_word', 'ta_standard', 'ta_express', 'q_standard', 'q_premium', 'q_expert', 'img_price')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $recalculatedProducts = collect($readyProducts)->map(function ($sessionProduct) use ($productsFromDb) {
            $product = $productsFromDb->get($sessionProduct['id']);
            if (!$product) {
                return null;
            }

            $product->turnaround = $sessionProduct['turnaround'] ?? 'ta_standard';
            $product->quality = $sessionProduct['quality'] ?? 'q_standard';
            $product->unit_price = $sessionProduct['unit_price'] ?? 0.00;
            $product->wordcount = $sessionProduct['wordcount'] ?? 1;
            $product->imagecount = $sessionProduct['imagecount'] ?? $sessionProduct['image_count'] ?? 1;
            $product->quantity = $sessionProduct['quantity'] ?? 1;

            $product->can_edit_price = 1;
            $product->remaining_days = 0;
            $product->project_title = $sessionProduct['project_title'] ?? null;
            $product->reference_link = $sessionProduct['reference_link'] ?? null;
            $product->subject = $sessionProduct['subject'] ?? null;
            $product->preferred_voice = $sessionProduct['preferred_voice'] ?? null;
            $product->preferred_writing_style = $sessionProduct['preferred_writing_style'] ?? null;
            $product->brand_name = $sessionProduct['brand_name'] ?? null;
            $product->audience = $sessionProduct['audience'] ?? null;
            $product->note = $sessionProduct['note'] ?? null;

            $product->param_status = !empty($product->project_title) && !empty($product->note) && !empty($product->subject);

            return $product;
        })->filter()->values();

        $modelType = $site->businessModel->model_type;
        $totalAmount = $recalculatedProducts->sum('unit_price');
        session(['current_amount' => $totalAmount]);

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $recalculatedProducts,
            'site' => $site,
            'total' => $totalAmount
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total' => $totalAmount
        ]);
    }



    public function addProducts(Request $request)
    {
        $site_id = session('customer.site_id');
        $productsData = $request->get('products');
        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $readyProducts = session()->get('ready_products', []);
        foreach ($productsData as $productData) {
            $productId = $productData['product_id'];
            $unitPrice = floatval($productData['unit_price']);
            $wordcount = intval($productData['word_count']);
            $turnaround = $productData['turnaround'];
            $imageCount = intval($productData['image_count']);
            $quality = $productData['quality'];

            $exists = false;
            foreach ($readyProducts as &$item) {
                if ($item['id'] == $productId) {
                    $item['unit_price'] = $unitPrice;
                    $item['turnaround'] = $turnaround;
                    $item['imagecount'] = $imageCount;
                    $item['quality'] = $quality;
                    $item['wordcount'] = $wordcount;
                    $item['quantity'] = 1;
                    $item['project_title'] = null;
                    $item['reference_link'] = null;
                    $item['subject'] = null;
                    $item['preferred_voice'] = null;
                    $item['preferred_writing_style'] = null;
                    $item['brand_name'] = null;
                    $item['audience'] = null;
                    $item['note'] = null;
                    $exists = true;
                    break;
                }
            }

            if (!$exists) {

                array_unshift($readyProducts, [
                    'id' => $productId,
                    'unit_price' => $unitPrice,
                    'turnaround' => $turnaround,
                    'imagecount' => $imageCount,
                    'quality' => $quality,
                    'wordcount' => $wordcount,
                    'quantity' => 1,
                    'project_title' => null,
                    'reference_link' => null,
                    'subject' => null,
                    'preferred_voice' => null,
                    'preferred_writing_style' => null,
                    'brand_name' => null,
                    'audience' => null,
                    'note' => null
                ]);
            }
        }

        session()->put('ready_products', $readyProducts);
        $recalculatedProducts = session('ready_products', []);

        $productIds = collect($recalculatedProducts)->pluck('id')->toArray();

        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'name', 'slug', 'default_wc', 'default_price', 'extra_word', 'ta_standard', 'ta_express', 'q_standard', 'q_premium', 'q_expert', 'img_price')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $recalculatedProducts = collect($recalculatedProducts)->map(function ($sessionProduct) use ($products) {
            $product = $products->get($sessionProduct['id']);
            if (!$product) {
                return null;
            }

            $product->turnaround = $sessionProduct['turnaround'] ?? 'ta_standard';
            $product->quality = $sessionProduct['quality'] ?? 'q_standard';
            $product->unit_price = $sessionProduct['unit_price'] ?? 0.00;
            $product->wordcount = $sessionProduct['wordcount'] ?? 1;
            $product->imagecount = $sessionProduct['imagecount'] ?? $sessionProduct['image_count'] ?? 1;
            $product->quantity = $sessionProduct['quantity'] ?? 1;

            $product->can_edit_price = 1;
            $product->remaining_days = 0;
            $product->project_title = $sessionProduct['project_title'] ?? null;
            $product->reference_link = $sessionProduct['reference_link'] ?? null;
            $product->subject = $sessionProduct['subject'] ?? null;
            $product->preferred_voice = $sessionProduct['preferred_voice'] ?? null;
            $product->preferred_writing_style = $sessionProduct['preferred_writing_style'] ?? null;
            $product->brand_name = $sessionProduct['brand_name'] ?? null;
            $product->audience = $sessionProduct['audience'] ?? null;
            $product->note = $sessionProduct['note'] ?? null;

            $product->param_status = !empty($product->project_title) && !empty($product->note) && !empty($product->subject);

            return $product;
        })->filter()->values();

        $modelType = $site->businessModel->model_type;
        session(['current_amount' => collect($recalculatedProducts)->sum('unit_price')]);

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $recalculatedProducts,
            'site' => $site,
            'total' => collect($recalculatedProducts)->sum('unit_price')
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total' => collect($recalculatedProducts)->sum('unit_price')
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
                'total' => 0,
            ]);
        }

        DynamicDatabaseService::connect($site);
        $productIds = array_column($updatedProducts, 'id');

        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'name', 'slug', 'default_wc', 'default_price', 'extra_word', 'ta_standard', 'ta_express', 'q_standard', 'q_premium', 'q_expert', 'img_price')
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $recalculatedProducts = collect($updatedProducts)->map(function ($sessionProduct) use ($products) {
            $product = $products->get($sessionProduct['id']);
            if (!$product) {
                return null;
            }

            $wordCount = $sessionProduct['wordcount'] ?? 1;
            $imageCount = $sessionProduct['imagecount'] ?? 1;
            $quantity = $sessionProduct['quantity'] ?? 1;
            $quality = $sessionProduct['quality'] ?? 'q_standard';
            $turnaround = $sessionProduct['turnaround'] ?? 'ta_standard';

            $product->turnaround = $turnaround;
            $product->quality = $quality;

            $qlty_factor = match ($product->quality) {
                'q_premium' => 0.1,
                'q_expert' => 0.25,
                default => 0,
            };

            $wc_price = max(0, (($wordCount - $product->default_wc) / 25) * $product->extra_word);
            $img_total = max(0, ($imageCount - 1) * $product->img_price);
            $ta_total = $product->turnaround === 'ta_express' ? 25 : 0;

            $base_total = $product->default_price + $wc_price + $img_total + $ta_total;
            $unit_price = ($base_total + ($base_total * $qlty_factor)) * $quantity;

            $product->unit_price = $unit_price;
            $product->wordcount = $wordCount;
            $product->imagecount = $imageCount;
            $product->quantity = $quantity;

            $product->can_edit_price = 1;
            $product->remaining_days = 0;
            $product->project_title = $sessionProduct['project_title'] ?? null;
            $product->reference_link = $sessionProduct['reference_link'] ?? null;
            $product->subject = $sessionProduct['subject'] ?? null;
            $product->preferred_voice = $sessionProduct['preferred_voice'] ?? null;
            $product->preferred_writing_style = $sessionProduct['preferred_writing_style'] ?? null;
            $product->brand_name = $sessionProduct['brand_name'] ?? null;
            $product->audience = $sessionProduct['audience'] ?? null;
            $product->note = $sessionProduct['note'] ?? null;
            $product->param_status = !empty($product->project_title) && !empty($product->note) && !empty($product->subject);

            return $product;
        })->filter()->values();

        $total = $recalculatedProducts->sum('unit_price');
        session(['current_amount' => $total]);

        $modelType = $site->businessModel->model_type;

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $recalculatedProducts,
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
        $keyword = $request->input('keyword');
        $hasPriceRange = $request->filled('price_from') && $request->filled('price_to');
        $sortUnitPrice = $request->input('sort_unit_price', 'asc');

        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        if (!$hasPriceRange) {
            return response()->json([
                'tableRows' => '<tr><td colspan="9" class="text-center text-muted">Please enter a price range to search.</td></tr>'
            ]);
        }

        $query = DB::connection($this->connectionType)
            ->table($this->productTable)
            ->select('id', 'name', 'slug', 'default_wc', 'default_price', 'extra_word', 'ta_standard', 'ta_express', 'q_standard', 'q_premium', 'q_expert', 'img_price')
            ->where('products.published', 1);

        if (!empty($keyword)) {
            $normalizedSearch = strtolower(str_replace(['-', '_', ' '], '', $keyword));
            $query->where(function ($q) use ($normalizedSearch) {
                $q->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(products.name, '-', ''), '_', ''), ' ', '')) LIKE ?", ["%{$normalizedSearch}%"]);
            });
        }

        $readyProducts = session('ready_products', []);
        $readyProductIds = collect($readyProducts)->pluck('id')->toArray();

        if (count($readyProductIds) > 0) {
            $query->whereNotIn('id', $readyProductIds);
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
                'tableRows' => '<tr><td colspan="9" class="text-center text-muted"> No results found. Try randomizing or use a different keyword.</td></tr>'
            ]);
        }

        $turnaround  = 'ta_standard';
        $quality     = 'q_standard';

        $products = collect($products);

        $products->each(function ($product) use ($turnaround, $quality) {
            $product->turnaround = $turnaround;
            $product->quality = $quality;
            $wc = $product->default_wc;
            $img = 1;
            $qty = 1;

            $default_wc = $product->default_wc;
            $default_price = $product->default_price;
            $extra_word = $product->extra_word;
            $ta_standard = $product->ta_standard;
            $ta_express = $product->ta_express;
            $img_price = $product->img_price;

            $q_standard = $product->q_standard;
            $q_premium = $product->q_premium;
            $q_expert = $product->q_expert;

            $wc_price = 0;
            if ($wc > $default_wc) {
                $wc_diff = $wc - $default_wc;
                $wc_price = ($wc_diff / 25) * $extra_word;
            }

            $img_total = ($img > 1) ? ($img - 1) * $img_price : 0;

            $ta_total = ($turnaround == 'ta_express') ? 25 : 0;

            $qlty_factor = match ($quality) {
                'q_premium' => 0.1,
                'q_expert' => 0.25,
                default => 0,
            };

            $total = $default_price + $wc_price + $img_total + $ta_total;
            $final_total = ($total + ($total * $qlty_factor)) * $qty;

            $product->unit_price = $final_total;
        });

        $products->each(function ($product) use ($site_id) {

            $product->can_edit_price = 1;
            $product->remaining_days = 0;
            $product->project_title = null;
            $product->reference_link = null;
            $product->subject = null;
            $product->preferred_voice = null;
            $product->preferred_writing_style = null;
            $product->brand_name = null;
            $product->audience = null;
            $product->note = null;
            $product->param_status = !empty($product->project_title) && !empty($product->note) && !empty($product->subject);
        });

        if ($hasPriceRange) {
            $priceFrom = (float) $request->get('price_from');
            $priceTo = (float) $request->get('price_to');

            $products = $products->filter(function ($product) use ($priceFrom, $priceTo) {
                return $product->unit_price >= $priceFrom && $product->unit_price <= $priceTo;
            });

            $products = $products->values();
        }


        if (in_array($sortUnitPrice, ['asc', 'desc'])) {
            $products = $sortUnitPrice === 'asc'
                ? $products->sortBy('unit_price')->values()
                : $products->sortByDesc('unit_price')->values();
        }


        $modelType = $site->businessModel->model_type;
        $random_amount = session('current_amount', 0);

        $tableRows = view("invoice.{$modelType}.add_product_rows", ['products' => $products, 'site' => $site, 'random_amount' => $random_amount])->render();
        $paginationHtml = view("invoice.{$modelType}.pagination", ['totalPages' => $totalPages, 'paginationPages' => $paginationPages, 'currentPage' => $page])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'paginationHtml' => $paginationHtml,
            'random_amount' => $random_amount,
            'currentPage' => $page
        ]);
    }

    public function updateProduct(Request $request)
    {
        $siteId = session('customer.site_id');
        $productId = $request->get('product_id');
        $readyProducts = session('ready_products', []);
        $oldProduct = collect($readyProducts)->firstWhere('id', $productId) ?? [];

        $wordCount = intval($request->get('wordcount', $oldProduct['wordcount'] ?? 1));
        $imageCount = intval($request->get('imagecount', $oldProduct['imagecount'] ?? 1));
        $quantity = intval($request->get('quantity', $oldProduct['quantity'] ?? 1));
        $turnaround = $request->get('turnaround', $oldProduct['turnaround'] ?? 'ta_standard');
        $quality = $request->get('quality', $oldProduct['quality'] ?? 'q_standard');

        $projectTitle = $request->get('project_title', $oldProduct['project_title'] ?? null);
        $referenceLink = $request->get('reference_link', $oldProduct['reference_link'] ?? null);
        $subject = $request->get('subject', $oldProduct['subject'] ?? null);
        $preferredVoice = $request->get('preferred_voice', $oldProduct['preferred_voice'] ?? null);
        $preferredWritingStyle = $request->get('preferred_writing_style', $oldProduct['preferred_writing_style'] ?? null);
        $brandName = $request->get('brand_name', $oldProduct['brand_name'] ?? null);
        $audience = $request->get('audience', $oldProduct['audience'] ?? null);
        $note = $request->get('note', $oldProduct['note'] ?? null);

        if(!$siteId){
            return response()->json(['success' => false, 'message' => 'Missing site Id.']);
        }
        $site = Website::findOrFail($siteId);
        DynamicDatabaseService::connect($site);

        $product = DB::connection($this->connectionType)
            ->table($this->productTable)
            ->where('id', $productId)
            ->first();

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.']);
        }

        $qlty_factor = match ($quality) {
            'q_premium' => 0.1,
            'q_expert' => 0.25,
            default => 0,
        };

        $wc_price = max(0, (($wordCount - $product->default_wc) / 25) * $product->extra_word);
        $img_total = max(0, ($imageCount - 1) * $product->img_price);
        $ta_total = $turnaround === 'ta_express' ? 25 : 0;

        $base_total = $product->default_price + $wc_price + $img_total + $ta_total;
        $unit_price = ($base_total + ($base_total * $qlty_factor)) * $quantity;

        if ($request->get('request_type') !== 'customize') {
            $readyProducts = session('ready_products', []);

            foreach ($readyProducts as &$p) {
                if ($p['id'] == $productId) {
                    $p['wordcount'] = $wordCount;
                    $p['imagecount'] = $imageCount;
                    $p['quantity'] = $quantity;
                    $p['turnaround'] = $turnaround;
                    $p['quality'] = $quality;
                    $p['unit_price'] = $unit_price;

                    $p['project_title'] = $projectTitle;
                    $p['reference_link'] = $referenceLink;
                    $p['subject'] = $subject;
                    $p['preferred_voice'] = $preferredVoice;
                    $p['preferred_writing_style'] = $preferredWritingStyle;
                    $p['brand_name'] = $brandName;
                    $p['audience'] = $audience;
                    $p['note'] = $note;
                    break;
                }
            }

            session()->put([
                'ready_products' => $readyProducts,
                'current_amount' => collect($readyProducts)->sum('unit_price'),
            ]);

        }


        return response()->json([
            'success' => true,
            'product_id' => $productId,
            'wordcount' => $wordCount,
            'imagecount' => $imageCount,
            'quantity' => $quantity,
            'turnaround' => $turnaround,
            'quality' => $quality,
            'unit_price' => $unit_price,
            'project_title' => $projectTitle,
            'reference_link' => $referenceLink,
            'subject' => $subject,
            'preferred_voice' => $preferredVoice,
            'preferred_writing_style' => $preferredWritingStyle,
            'brand_name' => $brandName,
            'audience' => $audience,
            'note' => $note,
            'param_status' => !empty($projectTitle) && !empty($note) && !empty($subject)
        ]);

    }



    public function getProduct(Request $request)
    {
        $productId = $request->input('product_id');

        $readyProducts = session('ready_products', []);

        $productData = null;
        foreach ($readyProducts as $product) {
            if ($product['id'] == $productId) {
                $productData = $product;
                break;
            }
        }

        if (!$productData) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in session'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'product' => $productData,
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

        $invoice_data['site'] = $site;
        $invoice_data['invoice_number'] = $request->input('invoice_number');
        $invoice_data['invoice_date'] = Carbon::parse($request->input('invoice_date'))->format('F d, Y');
        $invoice_data['customer_name'] = $request->input('customer_name');
        $invoice_data['customer_mobile'] = $request->input('customer_mobile');
        $invoice_data['customer_email'] = $request->input('customer_email');
        $invoice_data['invoice_amount'] = $request->input('invoice_amount');
        $invoice_data['current_amount'] = $request->input('current_amount');
        $invoice_data['discount_amount'] = $request->input('discount_amount');
        $invoice_data['company_name'] = $site->company_name;
        $invoice_data['company_email'] = $site->company_email;
        $invoice_data['company_mobile'] = $site->company_mobile;
        $invoice_data['company_address'] = $site->company_address;
        $invoice_data['invoice_header_image'] = base64EncodeImage($site->invoice_header_image);
        $invoice_data['invoice_footer_image'] = base64EncodeImage($site->invoice_footer_image);
        $invoice_data['invoice_signature'] = base64EncodeImage($site->invoice_signature);
        $invoice_data['company_logo'] = base64EncodeImage($site->company_logo);
        $invoice_data['invoice_image1'] = base64EncodeImage($site->invoice_image1);
        $invoice_data['invoice_image2'] = base64EncodeImage($site->invoice_image2);
        $invoice_data['invoice_image3'] = base64EncodeImage($site->invoice_image3);
        $invoice_data['invoice_template'] = $site->invoice_template;
        $invoice_data['model_type'] = $site->businessModel->model_type;
        $invoice_data['site_id'] = $site->id;

        DynamicDatabaseService::connect($site);

        $readyProducts = session('ready_products', []);
        $productDataArray = $request->input('product_data', []);
        //dd($productDataArray);
        foreach ($productDataArray as $productJson) {
            $product = json_decode($productJson, true);
            $productId = $product['product_id'];
            $unitPrice = $product['unit_price'];
            foreach ($readyProducts as $index => $readyProduct) {
                if (isset($readyProduct['id']) && $readyProduct['id'] == $productId) {
                    $readyProducts[$index]['unit_price'] = $unitPrice;
                    break;
                }
            }
        }

        session(['ready_products' => $readyProducts]);

        $readyProducts = session('ready_products', []);

        $productIds = array_column($readyProducts, 'id');
        $readyProductsById = collect($readyProducts)->keyBy('id');

        $products = DB::connection($this->connectionType)->table($this->productTable)
        ->whereIn('id', $productIds)
        ->select('id', 'name', 'slug')
        ->get()
        ->sortBy(function ($product) use ($productIds) {
            return array_search($product->id, $productIds);
        })
        ->values()
        ->map(function ($product) use ($readyProductsById) {
            $sessionData = $readyProductsById->get($product->id);

            if ($sessionData) {
                $turnaroundCode = $sessionData['turnaround'] ?? 'ta_standard';
                $qualityCode = $sessionData['quality'] ?? 'q_standard';
                $product->unit_price = $sessionData['unit_price'] ?? null;
                $product->wordcount = $sessionData['wordcount'] ?? null;
                $product->imagecount = $sessionData['imagecount'] ?? 1;
                $product->quantity = $sessionData['quantity'] ?? 1;
                $product->turnaround = match ($turnaroundCode) { 'ta_standard' => 'Standard', 'ta_express' => 'Express' };
                $product->quality = match ($qualityCode) { 'q_standard' => 'Standard', 'q_premium' => 'Premium', 'q_expert' => 'Expert' };
                $product->delivery = match ($turnaroundCode) { 'ta_standard' => '5-7 Days', 'ta_express' => '2-3 Days' };
                $product->project_title = $sessionData['project_title'] ?? null;
                $product->reference_link = $sessionData['reference_link'] ?? null;
                $product->subject = $sessionData['subject'] ?? null;
                $product->preferred_voice = $sessionData['preferred_voice'] ?? null;
                $product->preferred_writing_style = $sessionData['preferred_writing_style'] ?? null;
                $product->brand_name = $sessionData['brand_name'] ?? null;
                $product->audience = $sessionData['audience'] ?? null;
                $product->note = $sessionData['note'] ?? null;
            }

            return $product;
        });


        $invoice_data['currency'] =  site_currency();

        $invoice_data['products'] = $products;
        $invoice_data['product_ids'] = $productIds;
        $modelType = strtolower($site->businessModel->model_type);
        $siteIdInWords = numberToWords($site->id);
        $viewPath = "websites.{$modelType}.{$siteIdInWords}";
        InvoiceController::createInvoiceHistory($invoice_data);
        if ($request->filled('invoice_file_name')) {
            $filename = $request->input('invoice_file_name') . '.pdf';
        } else {
            $filename = $invoice_data['invoice_number'] . '.pdf';
        }

        try {
            return $this->generateWithApi2Pdf($viewPath, $invoice_data, $filename);

        } catch (\Exception $e) {
            // Fallback to Dompdf if API2PDF fails
            return $this->generateWithDompdf($viewPath, $invoice_data, $filename);
        }
    }

    protected function generateWithApi2Pdf($viewPath, $invoice_data, $filename)
    {
        $html = View::make($viewPath, $invoice_data)->render();

        $response = Http::withHeaders([
            'Authorization' => env('API2PDF_KEY')
        ])->post('https://v2.api2pdf.com/chrome/html', [
            'html' => $html,
            'fileName' => $filename,
            'options' => [
                'format' => 'A4',
                'landscape' => false
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

    protected function generateWithDompdf($viewPath, $invoice_data, $filename)
    {
        $pdf = \PDF::loadView($viewPath, $invoice_data)->setPaper('A4', 'portrait');
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
