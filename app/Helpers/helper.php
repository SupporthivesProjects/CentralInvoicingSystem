<?php
use App\Services\DynamicDatabaseService;
use App\Models\Website;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\BusinessModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use App\Models\InvoiceGenerationHistory;

if (!function_exists('myinvoices')) {
    function myinvoices()
    {
        if (!Auth::check()) {
            return 0;
        }

        return InvoiceGenerationHistory::where('created_by', Auth::id())->count();
    }
}


if (!function_exists('mywebsites')) {
    function mywebsites()
    {
        if (!Auth::check()) {
            return 0;
        }

        return Website::where('added_by', Auth::id())->count();
    }
}


if (!function_exists('getWebsiteCountByModel')) {
    function getWebsiteCountByModel($modelId)
    {
        return Website::where('business_model_id', $modelId)->count();
    }
}

if (!function_exists('getAllWebsites')) {
    function getAllWebsites()
    {
        return Website::count();
    }
}

if (!function_exists('getallModels')) {
    function getallModels()
    {
        return BusinessModel::all();
    }
}

if (!function_exists('getModelsCount')) {
    function getModelsCount()
    {
        return BusinessModel::count();
    }
}

if (!function_exists('userCount')) {
    function userCount()
    {
        return User::count();
    }
}

if (!function_exists('invoiceCount')) {
    function invoiceCount()
    {
        return InvoiceGenerationHistory::count();
    }
}

if (!function_exists('getUserById')) {
    function getUserById($userId)
    {
        return User::find($userId);
    }
}


if (!function_exists('currentUserName')) {
    function currentUserName()
    {
        return Auth::check() ? Auth::user()->name : 'Guest';
    }
}

if (!function_exists('numberToWords')) {
    function numberToWords($number)
    {
        $formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
        $words = $formatter->format($number);
        return strtolower(str_replace(' ', '', $words));
    }
}

if (!function_exists('generateInvoiceNumber')) {
    function generateInvoiceNumber($siteName)
    {
        $shortCode = strtoupper(implode('', array_map(
            fn($word) => strtoupper(substr($word, 0, 1)),
            preg_split('/\s+/', trim($siteName))
        )));

        $randomNumber = mt_rand(10000000, 99999999); // 8-digit number

        return 'INV' . $randomNumber . '-' . $shortCode;
    }
}

if (!function_exists('site_currency')) {
    function site_currency()
    {
        $site_id = session('customer.site_id');

        if (!$site_id) {
            return '$';
        }

        try {
            $site = \App\Models\Website::findOrFail($site_id);
            \App\Services\DynamicDatabaseService::connect($site);

            if ($site->technology === 'wordpress') {
                $currencyTable = $site->currency_table ?? 'wp_options';
            
                $currencyRow = DB::connection('dynamic')
                    ->table($currencyTable)
                    ->where('option_name', 'woocommerce_currency')
                    ->first();
            
                return $currencyRow?->option_value ?? '$';
            }
            
            $site_currency = DB::connection('dynamic')->table('business_settings')->where('type', 'system_default_currency')->first()
                ?? DB::connection('dynamic')->table('business_settings')->where('type', 'home_default_currency')->first();

            $currency = DB::connection('dynamic')->table('currencies')->where('id', $site_currency->value ?? null)->first();

            return $currency->symbol ?? '$';
        } catch (\Exception $e) {
            return '$';
        }
    }
}


if (!function_exists('site_currency_code')) {
    function site_currency_code()
    {
        $site_id = session('customer.site_id');
        if (!$site_id) {
            return 'USD';
        }
        try {
            $site = \App\Models\Website::findOrFail($site_id);
            \App\Services\DynamicDatabaseService::connect($site);
            $site_currency = DB::connection('dynamic')->table('business_settings')->where('type', 'system_default_currency')->first()
                ?? DB::connection('dynamic')->table('business_settings')->where('type', 'home_default_currency')->first();
            $currency = DB::connection('dynamic')->table('currencies')->where('id', $site_currency->value)->first();
            return $currency->code ?? 'USD';
        } catch (\Exception $e) {
            return 'USD';
        }
    }
}



if (!function_exists('admin_currency')) {
    function admin_currency()
    {
        try {
            $currency = \App\Models\Currency::where('status', 1)->first();
            return $currency ? $currency->symbol : '$';
        } catch (\Exception $e) {
            Log::error('Error fetching admin currency: ' . $e->getMessage());
            return '$';
        }
    }
}


if (!function_exists('currencies')) {
    function currencies()
    {
        try {
            $currencies = Currency::latest()->get();
            return $currencies ?: [];
        } catch (\Exception $e) {
            Log::error('Error fetching admin currency: ' . $e->getMessage());
            return '$';
        }
    }
}

if (!function_exists('base64EncodeImage')) {
    function base64EncodeImage($path)
    {
        if (!$path) return null;

        $fullPath = public_path($path);

        if (file_exists($fullPath)) {
            $imageData = file_get_contents($fullPath);
            $base64 = base64_encode($imageData);
            $mime = mime_content_type($fullPath);
            return "data:$mime;base64,$base64";
        }

        return null;
    }
}

if (!function_exists('getProductTable')) {
    function getProductTable($technology)
    {
        $tables = [
            'wordpress' => 'wordpress_products',
            'laravel' => 'products',
            'corephp' => 'corephp_products',
        ];

        return $tables[$technology] ?? 'products';
    }
}


if (!function_exists('getCategoryList')) {
    function getCategoryList($technology)
    {
        $siteId = session('customer.site_id');
        $site = Website::find($siteId);

        if (!$site) {
            return collect();
        }

        \App\Services\DynamicDatabaseService::connect($site);

        $categoryTable = $technology === 'wordpress' 
            ? ($site->category_table ?? 'categories') 
            : 'categories';

        if (!Schema::connection('dynamic')->hasTable($categoryTable)) {
            return collect();
        }

        $query = DB::connection('dynamic')->table($categoryTable);

        switch ($technology) {
            case 'wordpress':
                return $query->join($site->term_taxonomy_table . ' as tt', "$categoryTable.term_id", '=', 'tt.term_id')
                            ->where('tt.taxonomy', 'product_cat')
                            ->orderByDesc("$categoryTable.term_id")
                            ->select([
                                "$categoryTable.term_id as id",
                                "$categoryTable.name"
                            ])
                            ->get();
                            
            case 'laravel':
            case 'corephp':
                return $query->join($site->product_table, "$categoryTable.id", '=', "$site->product_table.category_id")
                                ->select("$categoryTable.id", "$categoryTable.name")
                                ->distinct()
                                ->get();

            default:
                return collect();
        }
    }
}



if (!function_exists('site_languages')) {
    function site_languages()
    {
        $site_id = session('customer.site_id');

        if (!$site_id) {
            return collect();
        }

        try {
            $site = \App\Models\Website::findOrFail($site_id);
            \App\Services\DynamicDatabaseService::connect($site);

            $languages = DB::connection('dynamic')
                ->table('languages')
                ->select('id', 'name')
                ->orderBy('name')
                ->get();

            return $languages;
        } catch (\Exception $e) {
            return collect(); // Return empty collection on failure
        }
    }
}

if (!function_exists('compact_number')) {
    function compact_number($num)
    {
        $num = (float)$num;

        if ($num >= 1_000_000_000_000) {
            return rtrim(rtrim(number_format($num / 1_000_000_000_000, 1), '0'), '.') . 'T';
        } elseif ($num >= 1_000_000_000) {
            return rtrim(rtrim(number_format($num / 1_000_000_000, 1), '0'), '.') . 'B';
        } elseif ($num >= 1_000_000) {
            return rtrim(rtrim(number_format($num / 1_000_000, 1), '0'), '.') . 'M';
        } elseif ($num >= 1000) {
            return rtrim(rtrim(number_format($num / 1000, 1), '0'), '.') . 'k';
        } else {
            return (string)$num;
        }
    }
}



