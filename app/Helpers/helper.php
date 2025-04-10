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