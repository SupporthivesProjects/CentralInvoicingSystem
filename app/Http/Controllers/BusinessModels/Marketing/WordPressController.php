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
        static $categoryCache = [];
        
        $categorySlugs = [
            'seo packages' => 'seo',
            'ppc packages' => 'ppc',
            'orm packages' => 'orm',
            'social media packages' => 'social',
            'web design and development packages' => 'wdd',
            'email marketing packages' => 'em',
        ];

        if (!isset($categoryCache[$categoryId])) {
            $categoryCache[$categoryId] = DB::connection($this->connectionType)
                ->table('categories')
                ->where('id', $categoryId)
                ->value('name') ?? 'Unknown';
        }

        $name = $categoryCache[$categoryId];
        $normalized = preg_replace('/\s+/', ' ', trim($name));
        $normalizedLower = strtolower($normalized);

        return [
            'category_name' => $normalized,
            'slug' => $categorySlugs[$normalizedLower] ?? \Str::slug($normalized),
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
