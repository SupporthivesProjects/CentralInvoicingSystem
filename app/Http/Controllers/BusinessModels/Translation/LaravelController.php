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
                $query->where('name', 'like', '%Standard%')
                    ->orWhere('name', 'like', '%Certified%');
            })
            ->get();

        if ($translationProducts->isEmpty()) {
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'Translation products not found in the database'
            ]);
        }

        $certifiedTranslation = $translationProducts->first(function ($item) {
            return Str::contains(Str::lower(trim($item->name)), 'certified translation');
        });

        $standardTranslation = $translationProducts->first(function ($item) {
            return Str::contains(Str::lower(trim($item->name)), 'standard professional translation');
        }) ?? $translationProducts->first(function ($item) {
            return Str::contains(Str::lower(trim($item->name)), 'standard translation');
        });

        $certifiedPrice = $certifiedTranslation ? floatval($certifiedTranslation->unit_price) : null;
        $standardPrice = $standardTranslation ? floatval($standardTranslation->unit_price) : null;

        $bestMatch = null;
        $bestTotal = PHP_FLOAT_MAX;
        $bestDistance = PHP_FLOAT_MAX;

        if ($filterType === 'certified' && $certifiedTranslation && $certifiedPrice) {
            $certPages = ceil($invoiceAmount / $certifiedPrice);
            $total = $certPages * $certifiedPrice;
            $bestTotal = $total;
            $bestMatch = [
                [
                    'product' => $certifiedTranslation,
                    'pages' => $certPages,
                    'total' => $total
                ]
            ];
        } elseif ($filterType === 'standard' && $standardTranslation && $standardPrice) {
            $stdPages = ceil($invoiceAmount / $standardPrice);
            $total = $stdPages * $standardPrice;
            $bestTotal = $total;
            $bestMatch = [
                [
                    'product' => $standardTranslation,
                    'pages' => $stdPages,
                    'total' => $total
                ]
            ];
        } else {
            if ($certifiedTranslation && $standardTranslation && $certifiedPrice && $standardPrice) {
                $ratios = [
                    ['cert_ratio' => 0.3, 'std_ratio' => 0.7],
                    ['cert_ratio' => 0.5, 'std_ratio' => 0.5],
                    ['cert_ratio' => 0.7, 'std_ratio' => 0.3],
                    ['cert_ratio' => 0.2, 'std_ratio' => 0.8],
                    ['cert_ratio' => 0.8, 'std_ratio' => 0.2],
                    ['cert_ratio' => 0.4, 'std_ratio' => 0.6],
                    ['cert_ratio' => 0.6, 'std_ratio' => 0.4],
                ];

                foreach ($ratios as $ratio) {
                    $certAmount = $invoiceAmount * $ratio['cert_ratio'];
                    $stdAmount = $invoiceAmount * $ratio['std_ratio'];
                    $certPages = max(1, ceil($certAmount / $certifiedPrice));
                    $stdPages = max(1, ceil($stdAmount / $standardPrice));
                    $total = ($certPages * $certifiedPrice) + ($stdPages * $standardPrice);

                    if ($total >= $invoiceAmount) {
                        $distance = $total - $invoiceAmount;
                        $certValue = $certPages * $certifiedPrice;
                        $stdValue = $stdPages * $standardPrice;
                        $balanceScore = abs(($certValue / $total) - 0.5);

                        if ($distance < $bestDistance || ($distance == $bestDistance && $balanceScore < 0.3)) {
                            $bestDistance = $distance;
                            $bestTotal = $total;
                            $bestMatch = [
                                [
                                    'product' => $certifiedTranslation,
                                    'pages' => $certPages,
                                    'total' => $certPages * $certifiedPrice
                                ],
                                [
                                    'product' => $standardTranslation,
                                    'pages' => $stdPages,
                                    'total' => $stdPages * $standardPrice
                                ]
                            ];
                        }
                    }
                }

                if (!$bestMatch) {
                    $maxCertPages = min(20, ceil($invoiceAmount / ($certifiedPrice * 2)));

                    for ($certPages = 2; $certPages <= $maxCertPages; $certPages++) {
                        $certTotal = $certPages * $certifiedPrice;

                        if ($certTotal < $invoiceAmount) {
                            $remainingAmount = $invoiceAmount - $certTotal;
                            $stdPages = ceil($remainingAmount / $standardPrice);
                            $total = $certTotal + ($stdPages * $standardPrice);

                            if ($total >= $invoiceAmount) {
                                $distance = $total - $invoiceAmount;

                                if ($distance < $bestDistance) {
                                    $bestDistance = $distance;
                                    $bestTotal = $total;
                                    $bestMatch = [
                                        [
                                            'product' => $certifiedTranslation,
                                            'pages' => $certPages,
                                            'total' => $certTotal
                                        ],
                                        [
                                            'product' => $standardTranslation,
                                            'pages' => $stdPages,
                                            'total' => $stdPages * $standardPrice
                                        ]
                                    ];
                                }
                            }
                        }
                    }
                }
            }

            if (!$bestMatch && $certifiedTranslation && $certifiedPrice) {
                $certPages = ceil($invoiceAmount / $certifiedPrice);
                $total = $certPages * $certifiedPrice;

                if ($total >= $invoiceAmount) {
                    $bestTotal = $total;
                    $bestMatch = [
                        [
                            'product' => $certifiedTranslation,
                            'pages' => $certPages,
                            'total' => $total
                        ]
                    ];
                }
            }

            if (!$bestMatch && $standardTranslation && $standardPrice) {
                $stdPages = ceil($invoiceAmount / $standardPrice);
                $total = $stdPages * $standardPrice;
                $bestTotal = $total;
                $bestMatch = [
                    [
                        'product' => $standardTranslation,
                        'pages' => $stdPages,
                        'total' => $total
                    ]
                ];
            }
        }

        if (!$bestMatch) {
            return response()->json([
                'tableRows' => '',
                'total' => 0,
                'message' => 'No matching combination found, try again please'
            ]);
        }

        $selectedProducts = [];
        foreach ($bestMatch as $item) {
            $product = $item['product'];
            $pages = $item['pages'];

            if ($pages <= 0) {
                continue;
            }

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

            $product->pages = $pages;
            $product->line_total = $pages * floatval($product->unit_price);
            $product->urgent_amount = 24.24;
            $product->is_urgent = rand(1, 100) <= 30;

            if ($product->is_urgent) {
                $product->line_total += $product->urgent_amount;
            }

            $product->unit_type = (Str::contains(Str::lower($product->name), 'certified translation')) ? 'pages' : 'words';

            $selectedProducts[] = $product;
        }

        $productList = collect($selectedProducts)->map(function ($product) {
            return [
                'id' => $product->id,
                'unit_price' => $product->unit_price,
                'pages' => $product->pages,
                'is_urgent' => $product->is_urgent,
                'urgent_amount' => $product->urgent_amount,
                'unit_type' => $product->unit_type,
            ];
        })->toArray();

        $finalTotal = collect($selectedProducts)->sum('line_total');

        session()->forget('ready_products');
        session()->put('ready_products', $productList);
        session(['current_amount' => $finalTotal]);

        $modelType = $site->businessModel->model_type;
        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $selectedProducts,
            'site' => $site,
            'total' => $bestTotal
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total' => $finalTotal
        ]);
    }


    public function updateProduct(Request $request)
    {
        $productId = $request->get('product_id');
        $pages = intval($request->get('pages'));
        $siteId = $request->get('site_id');

        if ($pages <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Pages must be greater than zero'
            ], 400);
        }

        // Update the product pages in session
        $readyProducts = session('ready_products', []);
        foreach ($readyProducts as &$product) {
            if ($product['id'] == $productId) {
                $product['pages'] = $pages;
                break;
            }
        }

        session()->put('ready_products', $readyProducts);

        // Recalculate the current amount
        $totalAmount = 0;
        foreach ($readyProducts as $product) {
            $totalAmount += $product['unit_price'] * ($product['pages'] ?? 1);
        }

        session(['current_amount' => $totalAmount]);

        return response()->json([
            'success' => true,
            'total' => $totalAmount
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
            session(['current_amount' => 0]);
            return response()->json([
                'tableRows' => '',
                'total' => 0,
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

            $pages = $sessionProduct['pages'] ?? 1;
            $unit_price = floatval($sessionProduct['unit_price']);

            $product->unit_price = $unit_price;
            $product->pages = $pages;
            $product->line_total = $unit_price * $pages;
            $product->urgent_amount = 24.24;

            $product->category_name = DB::connection($this->connectionType)->table('categories')
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

            $product->unit_type = (Str::contains(Str::lower($product->name), 'certified translation')) ? 'pages' : 'words';

            return $product;
        });

        $currentAmount = $products->sum(function ($product) {
            return floatval($product->unit_price) * intval($product->pages ?? 1);
        });

        session(['current_amount' => $currentAmount]);

        $modelType = $site->businessModel->model_type;

        $tableRows = view("invoice.{$modelType}.random_product_rows", [
            'products' => $products,
            'site' => $site,
            'total' => $currentAmount
        ])->render();

        return response()->json([
            'tableRows' => $tableRows,
            'total' => $currentAmount
        ]);
    }




    public function clearProducts(Request $request)
    {
        // Forget the session data for products and current amount
        session()->forget('ready_products');
        session()->forget('current_amount');

        return response()->json([
            'success' => true,
            'message' => 'Randomized products filter has been cleared.', // Feedback for frontend
            'tableRows' => '', // Empty table content
            'currency' => null, // Reset currency (optional)
            'total' => 0 // Reset total
        ]);
    }


    public function filterProducts(Request $request)
    {
        $site_id = session('customer.site_id');
        $hasPriceRange = $request->filled('price_from') && $request->filled('price_to');
        $search_type = $request->input('search_type');
        $keyword = $request->input('keyword');
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

        return response()->json([ 'tableRows' => $tableRows,'paginationHtml' => $paginationHtml, 'random_amount' => $random_amount]);

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

        $company_detail_type = $request->input('company_detail_type');

        if ($company_detail_type === 'remote') {

            $site_name    = $request->input('remote_site_name') ?? '';
            $company_name    = $request->input('remote_company_name') ?? '';
            $company_email   = $request->input('remote_company_email') ?? '';
            $company_mobile  = $request->input('remote_company_mobile') ?? '';
            $company_address = $request->input('remote_company_address') ?? '';
            $remote_database = DB::connection($this->connectionType)->table('general_settings')->orderByDesc('updated_at')->first();

            if ($remote_database) {
                DB::connection($this->connectionType)->table('general_settings') ->where('id', $remote_database->id)
                    ->update([
                        'site_name'    => $request->input('remote_site_name') ?? '',
                        //'company_name' => $request->input('remote_company_name') ?? '',
                        'email'        => $request->input('remote_company_email') ?? '',
                        'phone'        => $request->input('remote_company_mobile') ?? '',
                        'address'      => $request->input('remote_company_address') ?? '',
                        'updated_at'   => now(),
                    ]);
            }

        } else{

            $site_name    = $request->input('local_site_name') ?? '';
            $company_name    = $request->input('local_company_name') ?? '';
            $company_email   = $request->input('local_company_email') ?? '';
            $company_mobile  = $request->input('local_company_mobile') ?? '';
            $company_address = $request->input('local_company_address') ?? '';
            $site->site_name       = $site_name;
            $site->company_name    = $company_name;
            $site->company_email   = $company_email;
            $site->company_mobile  = $company_mobile;
            $site->company_address = $company_address;
            $site->save();
        }

        $invoice_data = [
            'site' => $site,
            'site_name' => $site_name,
            'invoice_number' => $request->input('invoice_number'),
            'invoice_date' => $request->input('invoice_date'),
            'customer_name' => $request->input('customer_name'),
            'customer_mobile' => $request->input('customer_mobile'),
            'customer_email' => $request->input('customer_email'),
            'company_email' => $request->input('company_email'),
            'invoice_amount' => $request->input('invoice_amount'),
            'current_amount' => $request->input('current_amount'),
            'discount_amount' => $request->input('discount_amount'),
            'company_name'         => $company_name,
            'company_email'        => $company_email,
            'company_mobile'       => $company_mobile,
            'company_address'      => $company_address,
            'invoice_header_image' => base64EncodeImage($site->invoice_header_image),
            'invoice_footer_image' => base64EncodeImage($site->invoice_footer_image),
            'invoice_signature' => base64EncodeImage($site->invoice_signature),
            'company_logo' => base64EncodeImage($site->company_logo),
            'invoice_image1' => base64EncodeImage($site->invoice_image1),
            'invoice_image2' => base64EncodeImage($site->invoice_image2),
            'invoice_image3' => base64EncodeImage($site->invoice_image3),
            'invoice_image4'       => base64EncodeImage($site->invoice_image4),
            'invoice_image5'       => base64EncodeImage($site->invoice_image5),
            'invoice_image6'       => base64EncodeImage($site->invoice_image6),
            'invoice_image7'       => base64EncodeImage($site->invoice_image7),
            'invoice_image8'       => base64EncodeImage($site->invoice_image8),
            'invoice_image9'       => base64EncodeImage($site->invoice_image9),
            'invoice_template' => $site->invoice_template,
            'model_type' => $site->businessModel->model_type,
            'site_id' => $site->id,
            'currency' => site_currency(),
        ];

        $productsInput = $request->input('products', []);
        DynamicDatabaseService::connect($site);

        $productIds = array_keys($productsInput);
        //dd($productsInput);

        $products = DB::connection($this->connectionType)->table($this->productTable)
            ->whereIn('id', $productIds)
            ->select('id', 'category_id', 'name', 'unit_price')
            ->get()
            ->sortBy(function ($product) use ($productIds) {
                return array_search($product->id, $productIds);
            })
            ->values()
            ->map(function ($product) use ($productsInput) {
                $input = $productsInput[$product->id];

                $product->name = $input['name'] ?? 'Unknown';
                $product->unit_price = (float) ($input['price'] ?? $product->unit_price);
                $product->line_total = (float) ($input['line_total'] ?? 0);
                $product->pages = (int) ($input['pages'] ?? 1);
                $product->is_urgent = isset($input['is_urgent']) ? 1 : 0;
                $product->urgent_amount = (float) ($input['urgent_amount'] ?? 0);
                $product->from_language = $input['from_language'] ?? null;
                $product->to_language = $input['to_language'] ?? null;
                $product->selected = isset($input['selected']) ? 1 : 0;
                $product->unit_type = (Str::contains(Str::lower($product->name), 'certified translation')) ? 'pages' : 'words';

                return $product;
            });

        // ✅ Replace language IDs with language names using site_languages()
        $languages = site_languages()->pluck('name', 'id');

        $products->transform(function ($product) use ($languages) {
            $product->from_language = $languages[$product->from_language] ?? $product->from_language;
            $product->to_language = $languages[$product->to_language] ?? $product->to_language;
            return $product;
        });

        //dd($products);

        $invoice_data['products'] = $products;
        $invoice_data['product_ids'] = $productIds;
        //dd($productIds);

        $modelType = strtolower($site->businessModel->model_type);
        $siteIdInWords = numberToWords($site->id);
        $viewPath = "websites.{$modelType}.{$siteIdInWords}";

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
            // Fallback to Dompdf if API2PDF fails
            return $this->generateWithDompdf($site, $viewPath, $invoice_data, $filename);
        }
    }

    protected function generateWithDompdf($site, $viewPath, $invoice_data, $filename)
    {
        $pdf = \PDF::loadView($viewPath, $invoice_data)->setPaper('A4', 'portrait');
        return $pdf->download($filename);
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




    protected function updateProductPrice($productDataArray)
    {
        $site_id = session('customer.site_id');

        foreach ($productDataArray as $item) {
            // Check if item is already an array or needs decoding
            $data = is_string($item) ? json_decode($item, true) : $item;

            if (!empty($data['id']) && isset($data['price'])) {
                $product_id = intval($data['id']);
                $new_price = floatval($data['price']);

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
