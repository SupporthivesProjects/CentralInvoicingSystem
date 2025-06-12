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
            $site_currency = DB::connection('dynamic')->table('business_settings')->where('type', 'system_default_currency')->first()
                ?? DB::connection('dynamic')->table('business_settings')->where('type', 'home_default_currency')->first();
            $currency = DB::connection('dynamic')->table('currencies')->where('id', $site_currency->value)->first();
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
        if (!Schema::connection('dynamic')->hasTable('categories')) {
            return collect();
        }

        $categories = [
            'wordpress' => DB::connection('dynamic')->table('categories')->select('id', 'name')->get(),
            'laravel'   => DB::connection('dynamic')->table('categories')->select('id', 'name')->get(),
            'corephp'   => DB::connection('dynamic')->table('categories')->select('id', 'name')->get(),
        ];

        return $categories[$technology] ?? collect();
    }
}





