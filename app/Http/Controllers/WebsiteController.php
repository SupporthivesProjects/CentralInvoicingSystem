<?php
namespace App\Http\Controllers;

use App\Models\BusinessModel;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Http;

class WebsiteController extends Controller
{

    protected $productTable = null;
    protected $connectionType = null;

    public function __construct()
    {
        $site_id = session('customer.site_id');

        if ($site_id) {
            $site = Website::find($site_id);

            if ($site) {
                $this->productTable = getProductTable($site->technology);
                $this->connectionType = 'dynamic';
            }
        }
    }


    public function gameSiteAPI($site_id)
    {
        $site           = Website::findOrFail($site_id);
        $consumerKey    = $site->consumer_key;
        $consumerSecret = $site->consumer_secret;
        $baseUrl        = rtrim($site->site_link, '/') . '/wp-json/wc/v3/products';
        $url            = $baseUrl . '?per_page=100&status=publish&type=variable';

        $response = Http::withBasicAuth($consumerKey, $consumerSecret)->get($url);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to fetch products'], 500);
        }

        $products = $response->json();

        $mh      = curl_multi_init();
        $handles = [];

        foreach ($products as $index => $product) {
            $varUrl = $baseUrl . '/' . $product['id'] . '/variations?per_page=100&status=publish';
            $ch     = curl_init();
            curl_setopt($ch, CURLOPT_URL, $varUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERPWD, $consumerKey . ':' . $consumerSecret);
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_multi_add_handle($mh, $ch);
            $handles[$index] = ['handle' => $ch, 'product' => $product];
        }

        $running = null;
        do {
            curl_multi_exec($mh, $running);
            curl_multi_select($mh, 5.0);
        } while ($running > 0);

        $variationsMap = [];
        foreach ($handles as $index => $data) {
            $ch      = $data['handle'];
            $product = $data['product'];
            $body    = curl_multi_getcontent($ch);
            $code    = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_multi_remove_handle($mh, $ch);
            curl_close($ch);
            $variationsMap[$product['id']] = ($code === 200 && $body) ? json_decode($body, true) : [];
        }
        curl_multi_close($mh);

        $html = '<!DOCTYPE html>
        <html>
        <head>
            <title>Product Debug - Site ' . $site_id . '</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                pre  { font-size: 11px; max-height: 300px; overflow: auto; background: #f8f9fa; padding: 8px; border-radius:4px; }
                .meta-table { font-size: 12px; }
                .var-table  { font-size: 12px; }
                .badge      { font-size: 11px; }
                .copy-btn   { cursor: pointer; font-size: 11px; }
                .rate-badge { background: #198754; color: white; padding: 2px 6px; border-radius: 4px; font-size: 11px; }
            </style>
        </head>
        <body class="p-3">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <h4 class="mb-0">🎮 Product Debug Panel</h4>
                    <small class="text-muted">
                        Site: <strong>' . $site->site_name . '</strong> |
                        URL: <a href="' . $site->site_link . '" target="_blank">' . $site->site_link . '</a> |
                        Site ID: <strong>' . $site_id . '</strong> |
                        Total: <strong>' . count($products) . ' products</strong>
                    </small>
                </div>
            </div>';

        foreach ($products as $product) {
            $variations = $variationsMap[$product['id']] ?? [];
            $varCount   = count($variations);

            // --- ATTRIBUTES ---
            $attributes = '';
            foreach ($product['attributes'] ?? [] as $attr) {
                $attributes .= '<tr>
                    <td>' . $attr['name'] . '</td>
                    <td>' . ($attr['variation'] ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-secondary">No</span>') . '</td>
                    <td>' . implode(', ', $attr['options'] ?? []) . '</td>
                </tr>';
            }

            // --- META DATA ---
            $metaRows     = '';
            $rateMetaRows = '';
            foreach ($product['meta_data'] ?? [] as $meta) {
                if (empty($meta['value']) || str_starts_with($meta['key'], '_')) continue;
                $value = is_array($meta['value'])
                    ? '<pre>' . json_encode($meta['value'], JSON_PRETTY_PRINT) . '</pre>'
                    : htmlspecialchars($meta['value']);
                $metaRows .= '<tr><td>' . htmlspecialchars($meta['key']) . '</td><td>' . $value . '</td></tr>';

                $keyLower = strtolower($meta['key']);
                if (str_contains($keyLower, 'rate')    ||
                    str_contains($keyLower, 'price')   ||
                    str_contains($keyLower, 'amount')  ||
                    str_contains($keyLower, 'factor')  ||
                    str_contains($keyLower, 'convert') ||
                    str_contains($keyLower, 'custom')) {
                    $rateMetaRows .= '<tr class="table-warning">
                        <td><strong>' . htmlspecialchars($meta['key']) . '</strong></td>
                        <td>' . $value . '</td>
                    </tr>';
                }
            }

            // --- VARIATIONS ---
            $varRows = '';
            foreach ($variations as $var) {
                $varAttrs = collect($var['attributes'])->pluck('option', 'name')->toArray();
                $varRows .= '<tr>
                    <td>' . $var['id'] . '</td>
                    <td>' . ($var['sku'] ?? '-') . '</td>
                    <td><strong>' . ($var['price'] ?? '-') . '</strong></td>
                    <td>' . ($var['regular_price'] ?? '-') . '</td>
                    <td>' . ($var['sale_price'] ?? '-') . '</td>
                    <td>' . ($var['stock_status'] ?? '-') . '</td>
                    <td>' . ($var['status'] ?? '-') . '</td>
                    <td><pre>' . json_encode($varAttrs, JSON_PRETTY_PRINT) . '</pre></td>
                    <td>' . ($var['name'] ?? '-') . '</td>
                </tr>';
            }

            // --- RATE ANALYSIS ---
            $rateRows = '';
            foreach ($variations as $var) {
                $price = floatval($var['price'] ?? 0);
                if ($price <= 0) continue;

                $varAttrs = collect($var['attributes'])->pluck('option', 'name')->toArray();
                $amount   = $varAttrs['Amount'] ?? null;
                if (!$amount) continue;

                $lastChar    = strtoupper(substr(trim($amount), -1));
                $hasSuffix   = in_array($lastChar, ['M', 'K', 'G', 'B']);
                $numericPart = $hasSuffix ? substr($amount, 0, -1) : $amount;
                $numericPart = str_replace(',', '', $numericPart);
                $suffix      = $hasSuffix ? $lastChar : '';

                $numericAmount = floatval($numericPart);
                if ($numericAmount <= 0) continue;

                $multiplier = match($suffix) {
                    'K'     => 1000,
                    'M'     => 1000000,
                    'B'     => 1000000000,
                    default => 1,
                };

                $actualAmount = $numericAmount * $multiplier;
                $ratePerUnit  = $actualAmount / $price;
                $platform     = $varAttrs['Platform'] ?? $varAttrs['Server'] ?? '-';

                $rateRows .= '<tr>
                    <td>' . $var['id'] . '</td>
                    <td>' . $platform . '</td>
                    <td>' . $amount . '</td>
                    <td><strong>' . $price . '</strong></td>
                    <td><span class="rate-badge">' . number_format($ratePerUnit, 2) . ' per €1</span></td>
                    <td>' . number_format($actualAmount) . '</td>
                </tr>';
            }

            // --- COPY TEXT (for sharing/debugging) ---
            $copyText = '=== ' . $product['name'] . ' ===
    ID: ' . $product['id'] . '
    Slug: ' . $product['slug'] . '
    SKU: ' . ($product['sku'] ?? '-') . '
    Type: ' . $product['type'] . '

    ATTRIBUTES:
    ' . implode("\n", array_map(fn($a) => '  - ' . $a['name'] . ': ' . implode(', ', $a['options'] ?? []), $product['attributes'] ?? [])) . '

    META (non-private):
    ' . implode("\n", array_filter(array_map(function($m) {
        if (empty($m['value']) || str_starts_with($m['key'], '_')) return null;
        $val = is_array($m['value']) ? json_encode($m['value']) : $m['value'];
        return '  - ' . $m['key'] . ': ' . $val;
    }, $product['meta_data'] ?? []))) . '

    VARIATIONS (' . $varCount . '):
    ' . implode("\n", array_map(function($var) {
        $attrs = collect($var['attributes'])->pluck('option', 'name')->toArray();
        return '  - ID:' . $var['id'] . ' | Price:' . ($var['price'] ?? '-') . ' | Attrs:' . json_encode($attrs) . ' | Name:' . ($var['name'] ?? '-');
    }, $variations));

            $html .= '
            <div class="card mb-3 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center py-2">
                    <strong>' . htmlspecialchars($product['name']) . '</strong>
                    <div class="d-flex gap-1 flex-wrap justify-content-end">
                        <span class="badge bg-secondary">ID: ' . $product['id'] . '</span>
                        <span class="badge bg-info text-dark">Slug: ' . $product['slug'] . '</span>
                        <span class="badge bg-dark">SKU: ' . ($product['sku'] ?? '-') . '</span>
                        <span class="badge bg-primary">Type: ' . $product['type'] . '</span>
                        <span class="badge bg-warning text-dark">Status: ' . $product['status'] . '</span>
                        <span class="badge bg-success">Variations: ' . $varCount . '</span>
                        <span class="badge bg-danger">Price: ' . ($product['price'] ?? '-') . '</span>
                        <button class="btn btn-sm btn-outline-secondary py-0"
                            data-bs-toggle="collapse"
                            data-bs-target="#product-' . $product['id'] . '">
                            + Details
                        </button>
                    </div>
                </div>

                <div class="collapse" id="product-' . $product['id'] . '">
                    <div class="card-body">

                        <ul class="nav nav-tabs mb-3">
                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#attrs-' . $product['id'] . '">Attributes</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#meta-' . $product['id'] . '">Meta Data</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#vars-' . $product['id'] . '">Variations (' . $varCount . ')</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#rate-' . $product['id'] . '">💰 Rate Analysis</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#raw-' . $product['id'] . '">Raw JSON</button>
                            </li>
                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#copy-' . $product['id'] . '">📋 Copy Text</button>
                            </li>
                        </ul>

                        <div class="tab-content">

                            <div class="tab-pane fade show active" id="attrs-' . $product['id'] . '">
                                <table class="table table-bordered table-sm meta-table">
                                    <thead class="table-light"><tr><th>Name</th><th>Variation</th><th>Values</th></tr></thead>
                                    <tbody>' . ($attributes ?: '<tr><td colspan="3" class="text-muted">No attributes</td></tr>') . '</tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade" id="meta-' . $product['id'] . '">
                                ' . ($rateMetaRows ? '<h6 class="text-warning">⚠️ Rate-Related Keys Found</h6>
                                <table class="table table-bordered table-sm meta-table mb-3">
                                    <thead class="table-light"><tr><th>Key</th><th>Value</th></tr></thead>
                                    <tbody>' . $rateMetaRows . '</tbody>
                                </table>
                                <h6>All Meta</h6>' : '') . '
                                <table class="table table-bordered table-sm meta-table">
                                    <thead class="table-light"><tr><th>Key</th><th>Value</th></tr></thead>
                                    <tbody>' . ($metaRows ?: '<tr><td colspan="2" class="text-muted">No meta data</td></tr>') . '</tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade" id="vars-' . $product['id'] . '">
                                <div style="overflow-x:auto">
                                    <table class="table table-bordered table-sm var-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Var ID</th><th>SKU</th><th>Price</th><th>Regular</th>
                                                <th>Sale</th><th>Stock</th><th>Status</th><th>Attributes</th><th>Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>' . ($varRows ?: '<tr><td colspan="9" class="text-muted">No variations</td></tr>') . '</tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="rate-' . $product['id'] . '">
                                ' . ($rateMetaRows ? '<div class="alert alert-warning py-2">⚠️ Rate-related meta keys found — check Meta Data tab</div>' : '') . '
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Var ID</th><th>Platform/Server</th><th>Amount</th>
                                            <th>Price (€)</th><th>Rate</th><th>Actual Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>' . ($rateRows ?: '<tr><td colspan="6" class="text-muted">Could not calculate — Amount attribute may be missing or 0</td></tr>') . '</tbody>
                                </table>
                            </div>

                            <div class="tab-pane fade" id="raw-' . $product['id'] . '">
                                <pre>' . json_encode($product, JSON_PRETTY_PRINT) . '</pre>
                            </div>

                            <div class="tab-pane fade" id="copy-' . $product['id'] . '">
                                <button class="btn btn-sm btn-success mb-2 copy-btn"
                                    onclick="navigator.clipboard.writeText(document.getElementById(\'copytext-' . $product['id'] . '\').innerText).then(() => alert(\'Copied!\'))">
                                    📋 Copy to Clipboard
                                </button>
                                <pre id="copytext-' . $product['id'] . '">' . htmlspecialchars($copyText) . '</pre>
                            </div>

                        </div>
                    </div>
                </div>
            </div>';
        }

        $html .= '
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        </body>
        </html>';

        return response($html)->header('Content-Type', 'text/html');
    }



    public function addBusinessModel()
    {

        return view('business.addmodel');
    }

    public function editBusinessModel($id)
    {
        $businessmodel = BusinessModel::findOrFail($id);
        return view('business.editmodel', compact('businessmodel'));
    }

    public function updateBusinessModel(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon_class' => 'nullable|string|max:255',
            'model_type' => 'nullable|string|max:255',
        ]);

        $model = BusinessModel::findOrFail($id);
        $oldFolder = strtolower(str_replace(' ', '', $model->model_type));
        $oldPath = resource_path("views/invoice/$oldFolder");

        $newFolder = strtolower(str_replace(' ', '', $request->model_type));
        $newPath = resource_path("views/invoice/$newFolder");

        if ($oldFolder !== $newFolder && File::exists($oldPath)) {
            File::move($oldPath, $newPath);
        } elseif (!File::exists($newPath)) {
            File::makeDirectory($newPath, 0755, true);
        }

        $model->update($request->all());

        return redirect()->route('businessmodels')->with('success', 'Business model updated!');
    }

    public function deleteBusinessModel($id)
    {
        try {
            $businessModel = BusinessModel::findOrFail($id);
            $model_type = strtolower(str_replace(' ', '', $businessModel->model_type));
            $deletingPath = resource_path("views/invoice/$model_type/");
            $trashPath = resource_path("views/invoice/trash/$model_type/");

            if (File::exists($deletingPath)) {
                if (!File::exists($trashPath)) {
                    File::makeDirectory($trashPath, 0755, true);
                }
                $files = File::allFiles($deletingPath);
                foreach ($files as $file) {
                    File::move($file->getPathname(), $trashPath . $file->getFilename());
                }
            }
            $businessModel->delete();

            return response()->json([
                'success' => true,
                'message' => 'Business Model Deleted Successfully!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting business model: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong! Please try again.'
            ], 500);
        }
    }

 public function createBusinessModel(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'icon_class' => 'nullable|string|max:255',
                'model_type' => 'nullable|string|max:255',
            ]);

            $model_type = strtolower(str_replace(' ', '', $request->model_type));
            $folderPath = resource_path("views/invoice/$model_type");

            if (!File::exists($folderPath)) {
                File::makeDirectory($folderPath, 0755, true);
            }
            BusinessModel::create([
                'name' => $request->name,
                'icon_class' => $request->icon_class,
                'model_type' => $model_type,
            ]);

            return redirect()->back()->with('success', 'Business Model Added Successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong! Please try again.');
        }
    }



    public function addwebsite()
    {
        $businessModels = BusinessModel::all();
        $technologies = ['html', 'wordpress', 'corephp', 'laravel', 'django', 'other'];
        return view('business.addwebsite', compact('businessModels','technologies'));
    }

    public function editwebsite($id)
    {
        $website = Website::findOrFail($id);
        $businessModels = BusinessModel::all();
        $technologies = ['html', 'wordpress', 'corephp', 'laravel', 'django', 'other'];

        return view('business.editwebsite', compact('website','businessModels','technologies'));
    }


    public function updateWebsite(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'site_connectivity'    => 'nullable|in:db,api',
            'business_model_id'    => 'required|exists:business_models,id',
            'technology'           => 'required|in:html,wordpress,corephp,laravel,django,other',
            'site_name'            => 'nullable|string|max:255',
            'site_description'     => 'nullable|string|max:500',
            'db_host'              => 'required|string|max:255',
            'db_port'              => 'required|numeric',
            'db_name'              => 'required|string|max:255',
            'db_username'          => 'required|string|max:255',
            'db_password'          => 'required|string|max:255',
            'product_table'        => 'required|string|max:255',
            'product_price_table'  => 'required|string|max:255',
            'currency_table'       => 'required|string|max:255',
            'bundle_table'         => 'required|string|max:255',
            'general_settings'     => 'required|string|max:255',
            'category_table'       => 'required|string|max:255',
            'tags_table'           => 'required|string|max:255',
            'term_taxonomy_table'  => 'required|string|max:255',
            'consumer_key'         => 'nullable|string|max:1000',
            'consumer_secret'      => 'nullable|string|max:1000',
            'site_link'            => 'nullable|url|max:255',
            'std_trans_url'        => 'nullable|string|max:255',
            'cert_trans_url'       => 'nullable|string|max:255',
            'urgency_amount'          => 'nullable|numeric|min:0|max:99999999.9999',
            'urgency_24h_per_page'    => 'nullable|numeric|min:0|max:99999999.9999',
            'urgency_12h_per_page'    => 'nullable|numeric|min:0|max:99999999.9999',
            'urgency_24h_per_word'    => 'nullable|numeric|min:0|max:99999999.9999',
            'urgency_12h_per_word'    => 'nullable|numeric|min:0|max:99999999.9999',
            'urgency_36_48h_per_page' => 'nullable|numeric|min:0|max:99999999.9999',
            'urgency_36_48h_per_word' => 'nullable|numeric|min:0|max:99999999.9999',
            'company_name'         => 'nullable|string|max:255',
            'company_email'        => 'nullable|email|max:255',
            'company_mobile'       => 'nullable|string|max:20',
            'company_address'      => 'nullable|string|max:1000',
            'registration_number'  => 'nullable|string|max:255',
            'license_number'       => 'nullable|string|max:255',
            'bank_name'            => 'nullable|string|max:255',
            'bank_code'            => 'nullable|string|max:255',
            'pdf_size'             => 'required|in:A4,A5,Letter,Legal',
            'pdf_orientation'      => 'required|in:portrait,landscape',
            'site_status'          => 'nullable|in:live,tdown,pdown',
            'company_logo'         => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            'invoice_header_image' => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            'invoice_footer_image' => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            'invoice_signature'    => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            'invoice_template'     => 'nullable|file|mimes:html,htm,php|max:5120',
            'invoice_image1'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            'invoice_image2'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            'invoice_image3'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            'invoice_image4'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            'invoice_image5'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            'invoice_image6'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            'invoice_image7'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            'invoice_image8'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            'invoice_image9'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
        ], [
            '*.max'   => 'Each uploaded file must not exceed 5MB.',
            '*.mimes' => 'Only jpeg, jpg, png, html, htm, or php file types are allowed.',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            return redirect()->back()->with('error', $errors[0] ?? 'Validation failed.');
        }

        try {
            $website = Website::findOrFail($id);

            $modelType     = strtolower($website->businessModel->model_type);
            $siteId        = $website->id;
            $siteIdInWords = numberToWords($siteId);
            $baseUploadPath = public_path("uploads/websites/{$modelType}/{$siteId}/");

            $uploadFile = function ($field, $subfolder, $prefix = null) use ($request, $website, $baseUploadPath, $modelType, $siteId) {
                if ($request->hasFile($field)) {
                    $file     = $request->file($field);
                    $prefix   = $prefix ?? $field;
                    $filename = $prefix . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path     = $baseUploadPath . $subfolder;
                    if (!file_exists($path)) mkdir($path, 0755, true);
                    $file->move($path, $filename);
                    $website->$field = "uploads/websites/{$modelType}/{$siteId}/{$subfolder}/{$filename}";
                }
            };

            $uploadFile('company_logo', 'logos', 'logo');
            $uploadFile('invoice_header_image', 'headers', 'header');
            $uploadFile('invoice_footer_image', 'footers', 'footer');
            $uploadFile('invoice_signature', 'signitures', 'signiture');
            $uploadFile('invoice_image1', 'images1', 'image1');
            $uploadFile('invoice_image2', 'images2', 'image2');
            $uploadFile('invoice_image3', 'images3', 'image3');
            $uploadFile('invoice_image4', 'images4', 'image4');
            $uploadFile('invoice_image5', 'images5', 'image5');
            $uploadFile('invoice_image6', 'images6', 'image6');
            $uploadFile('invoice_image7', 'images7', 'image7');
            $uploadFile('invoice_image8', 'images8', 'image8');
            $uploadFile('invoice_image9', 'images9', 'image9');

            if ($request->hasFile('invoice_template')) {
                $oldTemplatePath = resource_path("views/websites/{$modelType}/{$siteIdInWords}.blade.php");
                if (file_exists($oldTemplatePath)) unlink($oldTemplatePath);
                $file     = $request->file('invoice_template');
                $viewPath = resource_path("views/websites/{$modelType}/");
                if (!file_exists($viewPath)) mkdir($viewPath, 0755, true);
                $file->move($viewPath, "{$siteIdInWords}.blade.php");
                $website->invoice_template = "views/websites/{$modelType}/{$siteIdInWords}.blade.php";
            }

            $website->update([
                'business_model_id'    => $request->business_model_id,
                'technology'           => $request->technology,
                'site_name'            => $request->site_name,
                'site_description'     => $request->site_description,
                'db_host'              => $request->db_host,
                'db_port'              => $request->db_port,
                'db_name'              => $request->db_name,
                'db_username'          => $request->db_username,
                'db_password'          => $request->db_password,
                'product_table'        => $request->product_table,
                'product_price_table'  => $request->product_price_table,
                'currency_table'       => $request->currency_table,
                'bundle_table'         => $request->bundle_table,
                'general_settings'     => $request->general_settings,
                'category_table'       => $request->category_table,
                'tags_table'           => $request->tags_table,
                'term_taxonomy_table'  => $request->term_taxonomy_table,
                'consumer_key'         => $request->consumer_key,
                'consumer_secret'      => $request->consumer_secret,
                'site_link'            => rtrim($request->site_link, '/') . '/',
                'std_trans_url'        => $request->std_trans_url,
                'cert_trans_url'       => $request->cert_trans_url,
                'urgency_amount'       => $request->filled('urgency_amount') ? $request->urgency_amount : null,
                'urgency_24h_per_page' => $request->filled('urgency_24h_per_page') ? $request->urgency_24h_per_page : null,
                'urgency_12h_per_page' => $request->filled('urgency_12h_per_page') ? $request->urgency_12h_per_page : null,
                'urgency_24h_per_word' => $request->filled('urgency_24h_per_word') ? $request->urgency_24h_per_word : null,
                'urgency_12h_per_word' => $request->filled('urgency_12h_per_word') ? $request->urgency_12h_per_word : null,
                'urgency_36_48h_per_page' => $request->filled('urgency_36_48h_per_page') ? $request->urgency_36_48h_per_page : null,
                'urgency_36_48h_per_word' => $request->filled('urgency_36_48h_per_word') ? $request->urgency_36_48h_per_word : null,
                'company_name'         => $request->company_name,
                'company_email'        => $request->company_email,
                'company_mobile'       => $request->company_mobile,
                'company_address'      => $request->company_address,
                'registration_number'  => $request->registration_number,
                'license_number'       => $request->license_number,
                'site_status'          => $request->site_status,
                'bank_name'            => $request->bank_name,
                'bank_code'            => $request->bank_code,
                'pdf_size'             => $request->pdf_size,
                'pdf_orientation'      => $request->pdf_orientation,
                'updated_at'           => now(),
            ]);

            $website->save();

            return redirect()->back()->with('success', 'Website updated successfully!');

        } catch (\Exception $e) {
            Log::error('Website Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    public function createWebsite(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'site_connectivity'    => 'nullable|in:db,api',
                'business_model_id'    => 'required|exists:business_models,id',
                'technology'           => 'required|in:html,wordpress,corephp,laravel,django,other',
                'site_name'            => 'nullable|string|max:255',
                'site_description'     => 'nullable|string|max:500',
                'db_host'              => 'required|string|max:255',
                'db_port'              => 'required|numeric',
                'db_name'              => 'required|string|max:255',
                'db_username'          => 'required|string|max:255',
                'db_password'          => 'required|string|max:255',
                'site_link'            => 'nullable|url|max:255',
                'std_trans_url'        => 'nullable|string|max:255',
                'cert_trans_url'       => 'nullable|string|max:255',
                'urgency_amount'          => 'nullable|numeric|min:0|max:99999999.9999',
                'urgency_24h_per_page'    => 'nullable|numeric|min:0|max:99999999.9999',
                'urgency_12h_per_page'    => 'nullable|numeric|min:0|max:99999999.9999',
                'urgency_24h_per_word'    => 'nullable|numeric|min:0|max:99999999.9999',
                'urgency_12h_per_word'    => 'nullable|numeric|min:0|max:99999999.9999',
                'urgency_36_48h_per_page' => 'nullable|numeric|min:0|max:99999999.9999',
                'urgency_36_48h_per_word' => 'nullable|numeric|min:0|max:99999999.9999',
                'company_name'         => 'nullable|string|max:255',
                'company_email'        => 'nullable|email|max:255',
                'consumer_key'         => 'nullable|string|max:1000',
                'consumer_secret'      => 'nullable|string|max:1000',
                'company_mobile'       => 'nullable|string|max:20',
                'company_address'      => 'nullable|string|max:1000',
                'registration_number'  => 'nullable|string|max:255',
                'license_number'       => 'nullable|string|max:255',
                'bank_name'            => 'nullable|string|max:255',
                'bank_code'            => 'nullable|string|max:255',
                'pdf_size'             => 'required|in:A4,A5,Letter,Legal',
                'pdf_orientation'      => 'required|in:portrait,landscape',
                'site_status'          => 'required|in:live,tdown,pdown',
                'added_by'             => 'nullable|exists:users,id',
                'company_logo'         => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
                'invoice_header_image' => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
                'invoice_footer_image' => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
                'invoice_signature'    => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
                'invoice_template'     => 'nullable|file|mimes:html,htm,php|max:5120',
                'invoice_image1'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
                'invoice_image2'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
                'invoice_image3'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
                'invoice_image4'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
                'invoice_image5'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
                'invoice_image6'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
                'invoice_image7'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
                'invoice_image8'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
                'invoice_image9'       => 'nullable|file|mimes:jpeg,png,jpg|max:5120',
            ], [
                '*.max'   => 'Each uploaded file must not exceed 5MB.',
                '*.mimes' => 'Only jpeg, jpg, png, html, htm, or php file types are allowed.',
            ]);

            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                return redirect()->back()->with('error', $errors[0] ?? 'Validation failed.');
            }

            $exists = Website::where('db_host', $request->db_host)->where('db_password', $request->db_password)->exists();
            if ($exists) {
                return redirect()->back()->withInput()->with('error', 'A website with the same host and password already exists.');
            }

            $website = Website::create([
                'business_model_id'    => $request->business_model_id,
                'technology'           => $request->technology,
                'site_name'            => $request->site_name,
                'site_description'     => $request->site_description,
                'db_host'              => $request->db_host,
                'db_port'              => $request->db_port,
                'db_name'              => $request->db_name,
                'db_username'          => $request->db_username,
                'db_password'          => $request->db_password,
                'site_link'            => rtrim($request->site_link, '/') . '/',
                'std_trans_url'        => $request->std_trans_url,
                'cert_trans_url'       => $request->cert_trans_url,
                'urgency_amount'       => $request->filled('urgency_amount') ? $request->urgency_amount : null,
                'urgency_24h_per_page' => $request->filled('urgency_24h_per_page') ? $request->urgency_24h_per_page : null,
                'urgency_12h_per_page' => $request->filled('urgency_12h_per_page') ? $request->urgency_12h_per_page : null,
                'urgency_24h_per_word' => $request->filled('urgency_24h_per_word') ? $request->urgency_24h_per_word : null,
                'urgency_12h_per_word' => $request->filled('urgency_12h_per_word') ? $request->urgency_12h_per_word : null,
                'urgency_36_48h_per_page' => $request->filled('urgency_36_48h_per_page') ? $request->urgency_36_48h_per_page : null,
                'urgency_36_48h_per_word' => $request->filled('urgency_36_48h_per_word') ? $request->urgency_36_48h_per_word : null,
                'company_name'         => $request->company_name,
                'consumer_key'         => $request->consumer_key,
                'consumer_secret'      => $request->consumer_secret,
                'company_email'        => $request->company_email,
                'company_mobile'       => $request->company_mobile, 
                'company_address'      => $request->company_address,
                'registration_number'  => $request->registration_number,
                'license_number'       => $request->license_number,
                'bank_name'            => $request->bank_name,
                'bank_code'            => $request->bank_code,
                'pdf_size'             => $request->pdf_size,
                'pdf_orientation'      => $request->pdf_orientation,
                'site_status'          => $request->site_status,
                'added_by'             => auth()->id(),
            ]);

            $modelType      = strtolower($website->businessModel->model_type);
            $siteId         = $website->id;
            $siteIdInWords  = numberToWords($siteId);
            $baseUploadPath = public_path("uploads/websites/{$modelType}/{$siteId}/");

            $uploadFile = function ($field, $subfolder, $prefix = null) use ($request, $website, $baseUploadPath, $modelType, $siteId) {
                if ($request->hasFile($field)) {
                    $file     = $request->file($field);
                    $prefix   = $prefix ?? $field;
                    $filename = $prefix . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path     = $baseUploadPath . $subfolder;
                    if (!file_exists($path)) mkdir($path, 0755, true);
                    $file->move($path, $filename);
                    $website->$field = "uploads/websites/{$modelType}/{$siteId}/{$subfolder}/{$filename}";
                }
            };

            $uploadFile('company_logo', 'logos', 'logo');
            $uploadFile('invoice_header_image', 'headers', 'header');
            $uploadFile('invoice_footer_image', 'footers', 'footer');
            $uploadFile('invoice_signature', 'signitures', 'signiture');
            $uploadFile('invoice_image1', 'images1', 'image1');
            $uploadFile('invoice_image2', 'images2', 'image2');
            $uploadFile('invoice_image3', 'images3', 'image3');
            $uploadFile('invoice_image4', 'images4', 'image4');
            $uploadFile('invoice_image5', 'images5', 'image5');
            $uploadFile('invoice_image6', 'images6', 'image6');
            $uploadFile('invoice_image7', 'images7', 'image7');
            $uploadFile('invoice_image8', 'images8', 'image8');
            $uploadFile('invoice_image9', 'images9', 'image9');

            if ($request->hasFile('invoice_template')) {
                $oldTemplatePath = resource_path("views/websites/{$modelType}/{$siteIdInWords}.blade.php");
                if (file_exists($oldTemplatePath)) unlink($oldTemplatePath);
                $file     = $request->file('invoice_template');
                $viewPath = resource_path("views/websites/{$modelType}/");
                if (!file_exists($viewPath)) mkdir($viewPath, 0755, true);
                $file->move($viewPath, "{$siteIdInWords}.blade.php");
                $website->invoice_template = "views/websites/{$modelType}/{$siteIdInWords}.blade.php";
            }

            $website->save();

            return redirect()->route('website.edit', $website->id)->with('success', 'Website added successfully.');

        } catch (\Exception $e) {
            Log::error('Website creation error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Something went wrong. Please try again.');
        }
    }


    public function deleteWebsite($id)
    {
        try {
            $website = Website::findOrFail($id);
            $website->delete();

            return response()->json([
                'success' => true,
                'message' => 'Website deleted successfully!'
            ]);
        } catch (\Exception $e) {
            Log::error('Error deleting website: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong while deleting the website.'
            ], 500);
        }
    }

    public function updateStatusAjax(Request $request, $id)
    {
        $request->validate([
            'site_status' => 'required|in:live,tdown,pdown',
        ]);

        $website = Website::find($id);

        if (!$website) {
            return response()->json(['success' => false, 'message' => 'Website not found.'], 404);
        }

        $website->site_status = $request->site_status;
        $website->save();

        return response()->json(['success' => true, 'message' => 'Site status updated successfully.']);
    }


    public function connectedwebsites(Request $request)
    {
        try {
            $query = Website::query();

            if ($request->has('status') && in_array($request->status, ['live', 'tdown', 'pdown'])) {
                $query->where('site_status', $request->status);
            }

            $websites = $query->get();

            return view('business.websites', compact('websites'));
        } catch (\Exception $e) {
            Log::error('Error fetching connected websites: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while fetching connected websites.');
        }
    }



    public function businessmodels(Request $request){
        try {
            $businessModels = BusinessModel::all();
            return view('business.models', compact('businessModels'));
        } catch (\Exception $e) {
            Log::error('Error fetching business models: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while fetching business models.');
        }
    }

    public function websitesByBusinessModel($id)
    {
        try {
            $businessModel = BusinessModel::findOrFail($id);
            $websites = Website::where('business_model_id', $id)->get();

            return view('business.modelwebsites', compact('businessModel', 'websites'));

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Specific error if BusinessModel not found
            return redirect()->back()->with('error', 'Business Model not found.');
        } catch (\Exception $e) {
            // Any other unexpected error
            \Log::error('Error fetching websites by business model: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }



    public function checkRemoteDbConnectivity(Request $request)
    {
        try {


            Config::set('database.connections.' . $this->connectionType, [
                'driver' => 'mysql',
                'host' => $request->db_host,
                'port' => $request->db_port ?? '3306',
                'database' => $request->db_name,
                'username' => $request->db_username,
                'password' => $request->db_password,
                'charset' => 'utf8mb4',
                'collation' => 'utf8mb4_unicode_ci',
                'prefix' => '',
                'strict' => true,
                'engine' => null,
            ]);


            $connection = DB::connection($this->connectionType);


            $pdo = $connection->getPdo();


            if ($pdo) {
                return response()->json([
                    'success' => true,
                    'message' => 'Remote DB connection successful!',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Could not establish connection to the database.',
            ]);

        } catch (\Exception $e) {
            \Log::error('Error while connecting to remote DB', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error occurred while connecting to the DB: ' . $e->getMessage(),
            ]);
        }
    }

    public function updateWebsiteAjax(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:websites,id',
            'bank_name' => 'nullable|string|max:255',
            'bank_code' => 'nullable|string|max:50',
        ]);

        $website = Website::findOrFail($request->id);

        if ($request->has('bank_name')) {
            $website->bank_name = $request->bank_name;
        }

        if ($request->has('bank_code')) {
            $website->bank_code = $request->bank_code;
        }

        $website->save();

        return response()->json(['success' => true, 'message' => 'Website updated successfully.']);
    }



}
