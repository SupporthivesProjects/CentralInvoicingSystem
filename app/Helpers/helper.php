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
        $site_id = request()->get('site_id') ?? session('site_id');
        if (!$site_id) {
            return '$';
        }
        try {
            $site = \App\Models\Website::findOrFail($site_id);
            \App\Services\DynamicDatabaseService::connect($site);

            $currency = DB::connection('dynamic')->table('currencies')->where('status', 1)->first();
            return $currency->symbol ?? '$';
        } catch (\Exception $e) {
            Log::error('Error fetching site currency: ' . $e->getMessage());
            return '$';
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





