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
        $noOfProducts = intval($request->get('noOfProducts'));

        $site = Website::findOrFail($site_id);
        DynamicDatabaseService::connect($site);

        $query = DB::connection($this->connectionType)
            ->table($this->productTable)
            ->select('id', 'name', 'slug', 'category_id', 'card_currency', 'rrp', 'discount', 'unit_price', 'current_stock')
            ->where('published', 1);

        if ($priceFrom && $priceTo) {
            $query->whereBetween('unit_price', [$priceFrom, $priceTo]);
        }

        if (!empty($categoryName)) {
            $normalized = strtolower(str_replace(['-', '_', ' ', ','], '', $categoryName));
            $query->whereIn('category_id', function ($sub) use ($normalized) {
                $sub->select('id')
                    ->from('categories')
                    ->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(REPLACE(tags, '-', ''), '_', ''), ' ', ''), ',', '')) LIKE ?", ["%{$normalized}%"]);
            });
        }

        $products = $query->orderByDesc('unit_price')->get();

        if ($products->isEmpty()) {
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No products found in this range or category.'
            ]);
        }

        $bestMatch = null;
        $bestTotal = 0;
        $bestDistance = PHP_INT_MAX;

        // Step 1: First try to find EXACT match combinations (sum = invoiceAmount)
        for ($attempt = 0; $attempt < 50; $attempt++) {
            $shuffled = $products->shuffle();
            $selected = [];
            $currentTotal = 0;

            foreach ($shuffled as $product) {
                $price = floatval($product->unit_price);

                // If specific number of products required, stop when reached
                if ($noOfProducts && count($selected) >= $noOfProducts) break;

                // If adding this product would exceed invoice amount, skip it
                if ($currentTotal + $price > $invoiceAmount) continue;

                $selected[] = $product;
                $currentTotal += $price;

                // Check if we hit exact match
                if ($currentTotal == $invoiceAmount) {
                    // If no specific count required, or if we have exact count
                    if (!$noOfProducts || count($selected) == $noOfProducts) {
                        $bestMatch = $selected;
                        $bestTotal = $currentTotal;
                        break 2; // Break both loops - found perfect match
                    }
                }

                // If we have required number of products, stop adding more
                if ($noOfProducts && count($selected) == $noOfProducts) break;
            }

            // If we found exact match with any number of products (when no specific count)
            if (!$noOfProducts && $currentTotal == $invoiceAmount && count($selected) > 0) {
                $bestMatch = $selected;
                $bestTotal = $currentTotal;
                break;
            }
        }

        // Step 2: If no exact match found, find closest higher amount
        if (!$bestMatch) {
            $maxTotal = $invoiceAmount * 1.15; // Allow up to 15% higher

            for ($attempt = 0; $attempt < 50; $attempt++) {
                $shuffled = $products->shuffle();
                $selected = [];
                $currentTotal = 0;

                foreach ($shuffled as $product) {
                    $price = floatval($product->unit_price);

                    // If specific number of products required, stop when reached
                    if ($noOfProducts && count($selected) >= $noOfProducts) break;

                    // If adding this product would exceed max allowed, skip it
                    if ($currentTotal + $price > $maxTotal) continue;

                    $selected[] = $product;
                    $currentTotal += $price;

                    // If we have required number of products, stop adding more
                    if ($noOfProducts && count($selected) == $noOfProducts) break;
                }

                // Evaluate this combination
                if ($noOfProducts) {
                    // Must have exact number of products and total >= invoice amount
                    if (count($selected) == $noOfProducts && $currentTotal >= $invoiceAmount) {
                        $distance = $currentTotal - $invoiceAmount;
                        if ($distance < $bestDistance) {
                            $bestMatch = $selected;
                            $bestTotal = $currentTotal;
                            $bestDistance = $distance;
                        }
                    }
                } else {
                    // Any number of products, but total must be >= invoice amount
                    if ($currentTotal >= $invoiceAmount && $currentTotal <= $maxTotal) {
                        $distance = $currentTotal - $invoiceAmount;
                        if ($distance < $bestDistance) {
                            $bestMatch = $selected;
                            $bestTotal = $currentTotal;
                            $bestDistance = $distance;
                        }
                    }
                }
            }
        }

        // Step 3: Final fallback - if still no match, try original logic with more flexibility
        if (!$bestMatch) {
            $minTotal = $invoiceAmount * 0.8; // Allow 20% lower as last resort
            $maxTotal = $invoiceAmount * 1.20; // Allow 20% higher

            for ($attempt = 0; $attempt < 30; $attempt++) {
                $shuffled = $products->shuffle();
                $selected = [];
                $currentTotal = 0;

                foreach ($shuffled as $product) {
                    $price = floatval($product->unit_price);
                    if ($noOfProducts && count($selected) >= $noOfProducts) break;

                    if ($currentTotal + $price <= $maxTotal) {
                        $selected[] = $product;
                        $currentTotal += $price;
                    }

                    if ($noOfProducts && count($selected) == $noOfProducts) break;
                }

                if ($noOfProducts && count($selected) == $noOfProducts) {
                    if ($currentTotal >= $minTotal) {
                        $distance = abs($invoiceAmount - $currentTotal);
                        if ($distance < $bestDistance) {
                            $bestMatch = $selected;
                            $bestTotal = $currentTotal;
                            $bestDistance = $distance;
                        }
                    }
                } elseif (!$noOfProducts && $currentTotal >= $minTotal && $currentTotal <= $maxTotal) {
                    if ($currentTotal > $bestTotal) {
                        $bestMatch = $selected;
                        $bestTotal = $currentTotal;
                    }
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

        // Get category information
        $categoryIds = $bestMatch->pluck('category_id')->unique();
        $categories = DB::connection($this->connectionType)
            ->table('categories')
            ->whereIn('id', $categoryIds)
            ->pluck('name', 'id');

        $bestMatch->each(function ($product) use ($categories) {
            $product->category_name = $categories[$product->category_id] ?? 'unknown';
        });

        // Get price history information
        $productIds = $bestMatch->pluck('id')->unique();
        $priceHistories = ProductPriceHistory::where('site_id', $site_id)
            ->whereIn('product_id', $productIds)
            ->orderByDesc('last_price_changed')
            ->get()
            ->groupBy('product_id');

        $bestMatch->each(function ($product) use ($priceHistories) {
            $history = $priceHistories[$product->id][0] ?? null;
            if ($history) {
                $lastChanged = Carbon::parse($history->last_price_changed);
                $nextChange = $lastChanged->copy()->addMonths(3);
                $daysLeft = now()->diffInDays($nextChange, false);
                $product->remaining_days = max($daysLeft, 0);
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextChange) ? 1 : 0;
            } else {
                $product->remaining_days = 0;
                $product->can_edit_price = 1;
            }
        });

        // Store in session
        $productList = $bestMatch->map(fn($p) => ['id' => $p->id, 'unit_price' => $p->unit_price])->toArray();
        session()->forget('ready_products');
        session()->put('ready_products', $productList);
        session(['current_amount' => $bestTotal]);

        // Render view
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


    public function addProducts(Request $request)
    {
        $site_id = $request->get('site_id');
        $productsData = $request->get('products');

        $site = Website::findOrFail($site_id);
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
                    'id' => $productId,
                    'unit_price' => $unitPrice,
                ];
            }
        }

        session()->put('ready_products', $readyProducts);

        $productIds = collect($readyProducts)->pluck('id')->reverse()->values()->toArray();

        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'name', 'slug', 'category_id', 'card_currency', 'rrp', 'discount', 'unit_price', 'current_stock')
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
            return response()->json([
                'tableRows' => '',
                'currency' => null,
            ]);
        }

        DynamicDatabaseService::connect($site);

        $productIds = array_column($updatedProducts, 'id');

        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->select('id', 'name', 'slug', 'category_id', 'card_currency', 'rrp', 'discount', 'unit_price', 'current_stock')
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
            ->select('id', 'name', 'slug', 'category_id', 'card_currency', 'rrp', 'discount', 'unit_price', 'current_stock')
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
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'products.id',
                'products.name',
                'products.slug',
                'products.category_id',
                'products.card_currency',
                'products.rrp',
                'products.discount',
                'products.unit_price',
                'products.current_stock',
                'categories.name as category_name'
            )
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
            $normalizedSearch = strtolower(str_replace(['-', '_', ' ', ','], '', $keyword));

            $query->where(function ($q) use ($normalizedSearch) {
                $q->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(REPLACE(products.name, '-', ''), '_', ''), ' ', ''), ',', '')) LIKE ?", ["%{$normalizedSearch}%"])
                    ->orWhereRaw("LOWER(REPLACE(REPLACE(REPLACE(REPLACE(products.slug, '-', ''), '_', ''), ' ', ''), ',', '')) LIKE ?", ["%{$normalizedSearch}%"])
                    ->orWhereIn('products.category_id', function ($sub) use ($normalizedSearch) {
                        $sub->select('id')
                            ->from('categories')
                            ->whereRaw("LOWER(REPLACE(REPLACE(REPLACE(REPLACE(tags, '-', ''), '_', ''), ' ', ''), ',', '')) LIKE ?", ["%{$normalizedSearch}%"]);
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
        $priceHistories = ProductPriceHistory::where('site_id', $site_id)
            ->whereIn('product_id', $productIds)
            ->orderByDesc('last_price_changed')
            ->get()
            ->keyBy('product_id');

        foreach ($products as $product) {
            $history = $priceHistories->get($product->id);
            if ($history) {
                $lastPriceChanged = Carbon::parse($history->last_price_changed);
                $nextPriceChangeDate = $lastPriceChanged->copy()->addMonths(3);
                $remainingDays = now()->diffInDays($nextPriceChangeDate, false);
                $product->remaining_days = round(max($remainingDays, 0));
                $product->can_edit_price = now()->greaterThanOrEqualTo($nextPriceChangeDate) ? 1 : 0;
            } else {
                $product->can_edit_price = 1;
                $product->remaining_days = 0;
            }
        }

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
        $invoice_data['invoice_template'] = $site->invoice_template;
        $invoice_data['model_type'] = $site->businessModel->model_type;
        $invoice_data['site_id'] = $site->id;

        $company_detail_type = $request->input('company_detail_type');

        if ($company_detail_type === 'remote') {

            $invoice_data['site_name']    = $request->input('remote_site_name') ?? '';
            $invoice_data['company_name']    = $request->input('remote_company_name') ?? '';
            $invoice_data['company_email']   = $request->input('remote_company_email') ?? '';
            $invoice_data['company_mobile']  = $request->input('remote_company_mobile') ?? '';
            $invoice_data['company_address'] = $request->input('remote_company_address') ?? '';
            $remote_database = DB::connection($this->connectionType)->table('general_settings')->orderByDesc('updated_at')->first();

            if ($remote_database) {
                DB::connection($this->connectionType)->table('general_settings')->where('id', $remote_database->id)
                    ->update([
                        'site_name'    => $request->input('remote_site_name') ?? '',
                        //'company_name' => $request->input('remote_company_name') ?? '',
                        'email'        => $request->input('remote_company_email') ?? '',
                        'phone'        => $request->input('remote_company_mobile') ?? '',
                        'address'      => $request->input('remote_company_address') ?? '',
                        'updated_at'   => now(),
                    ]);
            }
        } else {

            $invoice_data['site_name']    = $request->input('local_site_name') ?? '';
            $invoice_data['company_name']    = $request->input('local_company_name') ?? '';
            $invoice_data['company_email']   = $request->input('local_company_email') ?? '';
            $invoice_data['company_mobile']  = $request->input('local_company_mobile') ?? '';
            $invoice_data['company_address'] = $request->input('local_company_address') ?? '';
            $site->site_name       = $invoice_data['site_name'];
            $site->company_name    = $invoice_data['company_name'];
            $site->company_email   = $invoice_data['company_email'];
            $site->company_mobile  = $invoice_data['company_mobile'];
            $site->company_address = $invoice_data['company_address'];
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
                $customPrices[$data['product_id']] = [
                    'product_name' => $data['product_name'],
                    'unit_rrp' => $data['unit_rrp'],
                    'unit_discount' => $data['unit_discount'],
                    'unit_price' => $data['unit_price'],
                ];
            }
        }

        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->whereIn('id', $productIds)
            ->select('id', 'name', 'slug', 'category_id', 'card_currency', 'rrp', 'discount', 'unit_price', 'current_stock')
            ->get()
            ->sortBy(fn($product) => array_search($product->id, $productIds))
            ->values()
            ->map(function ($product) use ($customPrices) {
                $product->name = $customPrices[$product->id]['product_name'];
                $product->rrp = $customPrices[$product->id]['unit_rrp'];
                $product->discount = $customPrices[$product->id]['unit_discount'];
                $product->unit_price = $customPrices[$product->id]['unit_price'];
                return $product;
            });

        $products->each(function ($product) {
            $product->category_name = DB::connection($this->connectionType)
                ->table('categories')
                ->where('id', $product->category_id)
                ->value('name') ?? 'unknown';
        });

        $invoice_data['currency'] =  site_currency();
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

            Log::info('Processing item', ['raw_data' => $data]);

            if (!empty($data['product_id']) && isset($data['unit_price'])) {
                $product_id   = $data['product_id'];
                $new_name     = $data['product_name'];
                $new_price    = floatval($data['unit_price']);
                $new_rrp      = isset($data['unit_rrp']) ? floatval($data['unit_rrp']) : null;
                $new_discount = isset($data['unit_discount']) ? floatval($data['unit_discount']) : null;

                $product = DB::connection($this->connectionType)
                    ->table($this->productTable)
                    ->where('id', $product_id)
                    ->first();

                if (! $product) {
                    Log::info('Product not found', ['product_id' => $product_id]);
                    continue;
                }

                $current_name     = $product->name;
                $current_price    = floatval($product->unit_price);
                $current_rrp      = isset($product->rrp) ? floatval($product->rrp) : null;
                $current_discount = isset($product->discount) ? floatval($product->discount) : null;

                $updateData = [];

                if ($current_name !== $new_name) {
                    $updateData['name'] = $new_name;
                }

                if ($current_price !== $new_price) {
                    $updateData['unit_price'] = $new_price;
                }

                if ($new_rrp !== null && $current_rrp !== $new_rrp) {
                    $updateData['rrp'] = $new_rrp;
                }

                if ($new_discount !== null && $current_discount !== $new_discount) {
                    $updateData['discount'] = $new_discount;
                }

                Log::info('Prepared update data', [
                    'product_id' => $product_id,
                    'update_data' => $updateData
                ]);

                if (empty($updateData)) {
                    Log::info('No changes detected', ['product_id' => $product_id]);
                    continue;
                }

                $lastUpdate = ProductPriceHistory::where('site_id', $site_id)
                    ->where('product_id', $product_id)
                    ->orderByDesc('last_price_changed')
                    ->first();

                $shouldUpdate = false;

                if (! $lastUpdate) {
                    $shouldUpdate = true;
                } else {
                    $monthsSinceLast = Carbon::parse($lastUpdate->last_price_changed)->diffInMonths(now());
                    if ($monthsSinceLast >= 3) {
                        $shouldUpdate = true;
                    }
                }

                Log::info('Update decision', [
                    'product_id' => $product_id,
                    'should_update' => $shouldUpdate
                ]);

                if ($shouldUpdate) {
                    DB::connection($this->connectionType)->enableQueryLog();

                    $affected = DB::connection($this->connectionType)
                        ->table($this->productTable)
                        ->where('id', $product_id)
                        ->update($updateData);

                    $queryLog = DB::connection($this->connectionType)->getQueryLog();

                    Log::info('Update executed', [
                        'product_id' => $product_id,
                        'affected_rows' => $affected,
                        'query_log' => $queryLog
                    ]);

                    ProductPriceHistory::create([
                        'site_id'            => $site_id,
                        'product_id'         => $product_id,
                        'unit_price'         => $new_price,
                        'last_price_changed' => now(),
                    ]);

                    Log::info('Price history inserted', [
                        'product_id' => $product_id
                    ]);
                }
            } else {
                Log::info('Invalid item data', ['item' => $item]);
            }
        }
    }
}