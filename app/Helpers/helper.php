<?php

use App\Models\Website;
use App\Models\BusinessModel;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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
 if(!function_exists('numberToWords')) {
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

