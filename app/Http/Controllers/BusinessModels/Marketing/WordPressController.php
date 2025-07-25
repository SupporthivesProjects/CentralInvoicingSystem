<?php
namespace App\Http\Controllers\BusinessModels\Marketing;

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


class WordPressController extends Controller
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

    protected function generateSlug($categoryId)
    {
        $categorySlugs = [
            'SEO Packages' => 'seo',
            'PPC Packages' => 'ppc',
            'ORM Packages' => 'orm',
            'Social Media Packages' => 'social',
            'Web Design And Development Packages' => 'wwd',
            'Email Marketing Packages' => 'em',
        ];

        $name = DB::connection($this->connectionType)
            ->table('categories')
            ->where('id', $categoryId)
            ->value('name') ?? 'unknown';

        $normalized = preg_replace('/\s+/', ' ', trim($name));

        return [
            'category_name' => $normalized,
            'slug' => $categorySlugs[$normalized] ?? \Str::slug($normalized),
        ];
    }


 
    public function randomProducts(Request $request)
    {
    }
    
    public function addProducts(Request $request)
    {
        
    }
    
    
    public function removeProduct(Request $request)
    {
       
    }
    
    public function updateProduct(Request $request)
    {
       
    }
    public function clearProducts(Request $request)
    {
       
    }

    public function filterProducts(Request $request)
    {
       
    }

    public function generateInvoice(Request $request){

    }

    
    protected function updateProductPrice(array $productDataArray)
    {
       
    }
}
