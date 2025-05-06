<?php

namespace App\Http\Controllers\BusinessModels;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BusinessModels\Marketing\LaravelController;
use App\Http\Controllers\BusinessModels\Marketing\WordPressController;
use App\Http\Controllers\BusinessModels\Marketing\CorePHPController;
use Illuminate\Http\Request;
use App\Models\Website;

class MarketingController extends Controller
{
    private $technology;

    public function __construct()
    {
        $site_id = session('customer.site_id');
        if (!$site_id) {
            return redirect()->back()->with('error', 'Site ID is missing.');
        }
        $site = Website::findOrFail($site_id);
        $this->technology = $site->technology;
    }

    public function randomProducts(Request $request)
    {
        return $this->resolveByTechnology($request, 'randomProducts');
    }

    public function addProducts(Request $request)
    {
        return $this->resolveByTechnology($request, 'addProducts');
    }

    public function removeProduct(Request $request)
    {
        return $this->resolveByTechnology($request, 'removeProduct');
    }

    public function updateProduct(Request $request)
    {
        return $this->resolveByTechnology($request, 'updateProduct');
    }

    public function clearProducts(Request $request)
    {
        return $this->resolveByTechnology($request, 'clearProducts');
    }

    public function filterProducts(Request $request)
    {
        return $this->resolveByTechnology($request, 'filterProducts');
    }

    public function generateInvoice(Request $request)
    {
        return $this->resolveByTechnology($request, 'generateInvoice');
    }

    protected function resolveByTechnology(Request $request, $method)
    {

        switch ($this->technology) {
            case 'laravel':
                return $this->resolveLaravelMethod($request, $method);
            case 'wordpress':
                return $this->resolveWordPressMethod($request, $method);
            case 'corephp':
                return $this->resolveCorePHPMethod($request, $method);
            default:
                return $this->resolveLaravelMethod($request, $method);
        }
    }

    protected function resolveLaravelMethod(Request $request, $method)
    {
        $controller = app(LaravelController::class);
        return $controller->$method($request);
    }

    protected function resolveWordPressMethod(Request $request, $method)
    {
        $controller = app(WordPressController::class);
        return $controller->$method($request);
    }

    protected function resolveCorePHPMethod(Request $request, $method)
    {
        $controller = app(CorePHPController::class);
        return $controller->$method($request);
    }
}
