<?php
namespace App\Http\Controllers;

use App\Models\BusinessModel;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class WebsiteController extends Controller
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
            // Validate input
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

            // Redirect with success message
            return redirect()->back()->with('success', 'Business Model Added Successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors are automatically redirected back with errors, so just rethrow
            throw $e;
        } catch (\Exception $e) {
            // Handle any other unexpected exception
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
        return view('business.editwebsite', compact('website', 'businessModels','technologies'));
    }

    public function updateWebsite(Request $request, $id)
    {
        $request->validate([
                'business_model_id' => 'required|exists:business_models,id',
                'technology' => 'required|in:html,wordpress,corephp,laravel,django,other',
                'site_name' => 'required|string|max:255',
                'site_description' => 'nullable|string|max:500',
                'db_host' => 'required|string|max:255',
                'db_port' => 'required|numeric',
                'db_name' => 'required|string|max:255',
                'db_username' => 'required|string|max:255',
                'db_password' => 'required|string|max:255',
                'site_link' => 'nullable|url|max:255',
                'company_name' => 'nullable|string|max:255',
                'company_email' => 'nullable|email|max:255',
                'company_mobile' => 'nullable|string|max:20',
                'company_address' => 'nullable|string|max:1000',
                'company_logo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_header_image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_footer_image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_signature' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_template' => 'nullable|file|mimes:html,htm,php|max:2048',
                'invoice_image1' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_image2' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_image3' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $website = Website::findOrFail($id);
            
            $modelType = strtolower($website->businessModel->model_type);
            $siteId = $website->id;
            $siteIdInWords = numberToWords($siteId); 

            $baseUploadPath = public_path("uploads/websites/{$modelType}/{$siteId}/");

            // Upload helper function
            $uploadFile = function ($field, $subfolder, $prefix = null) use ($request, $website, $baseUploadPath, $modelType, $siteId) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $prefix = $prefix ?? $field;
                    $filename = $prefix . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $baseUploadPath . $subfolder;

                    if (!file_exists($path)) {
                        mkdir($path, 0755, true);
                    }

                    $file->move($path, $filename);

                    $website->$field = "uploads/websites/{$modelType}/{$siteId}/{$subfolder}/{$filename}";
                }
            };

            // Upload each field
            $uploadFile('company_logo', 'logos', 'logo');
            $uploadFile('invoice_header_image', 'headers', 'header');
            $uploadFile('invoice_footer_image', 'footers', 'footer');
            $uploadFile('invoice_signature', 'signitures', 'signiture');
            $uploadFile('invoice_image1', 'images1', 'logo');
            $uploadFile('invoice_image2', 'images2', 'logo');
            $uploadFile('invoice_image3', 'images3', 'logo');

            // Special case for invoice_template (blade file)
            if ($request->hasFile('invoice_template')) {
                $oldTemplatePath = resource_path("views/websites/{$modelType}/{$siteIdInWords}.blade.php");
                if (file_exists($oldTemplatePath)) {
                    unlink($oldTemplatePath);
                }
                $file = $request->file('invoice_template');
                $viewPath = resource_path("views/websites/{$modelType}/");

                if (!file_exists($viewPath)) {
                    mkdir($viewPath, 0755, true);
                }

                $file->move($viewPath, "{$siteIdInWords}.blade.php");
                $website->invoice_template = "views/websites/{$modelType}/{$siteIdInWords}.blade.php";
            }

                // Update fields
                $website->update([
                    'business_model_id' => $request->business_model_id,
                    'technology' => $request->technology,
                    'site_name' => $request->site_name,
                    'site_description' => $request->site_description,
                    'db_host' => $request->db_host,
                    'db_port' => $request->db_port,
                    'db_name' => $request->db_name,
                    'db_username' => $request->db_username,
                    'db_password' => $request->db_password,
                    'site_link' => $request->site_link,
                    'company_name' => $request->company_name,
                    'company_email' => $request->company_email,
                    'company_mobile' => $request->company_mobile,
                    'company_address' => $request->company_address,
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
            // Validation rules, including newly added invoice images
            $validator = Validator::make($request->all(), [
                'business_model_id' => 'required|exists:business_models,id',
                'technology' => 'required|in:html,wordpress,corephp,laravel,django,other',
                'site_name' => 'required|string|max:255',
                'site_description' => 'nullable|string|max:500',
                'db_host' => 'required|string|max:255',
                'db_port' => 'required|numeric',
                'db_name' => 'required|string|max:255',
                'db_username' => 'required|string|max:255',
                'db_password' => 'required|string|max:255',
                'site_link' => 'nullable|url|max:255',
                'company_name' => 'nullable|string|max:255',
                'company_email' => 'nullable|email|max:255',
                'company_mobile' => 'nullable|string|max:20',
                'company_address' => 'nullable|string|max:1000',

                'company_logo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_header_image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_footer_image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_signature' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_template' => 'nullable|file|mimes:html,htm,php|max:2048',
                'invoice_image1' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_image2' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_image3' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            ]);

            // Handling validation failure
            if ($validator->fails()) {
                $errors = $validator->errors()->all();
                $firstError = $errors[0] ?? 'Validation failed.';
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', $firstError);
            }

            // First, create the website record without files
            $website = Website::create([
                'business_model_id' => $request->business_model_id,
                'technology' => $request->technology,
                'site_name' => $request->site_name,
                'site_description' => $request->site_description,
                'db_host' => $request->db_host,
                'db_port' => $request->db_port,
                'db_name' => $request->db_name,
                'db_username' => $request->db_username,
                'db_password' => $request->db_password,
                'site_link' => $request->site_link,
                'company_name' => $request->company_name,
                'company_email' => $request->company_email,
                'company_mobile' => $request->company_mobile,
                'company_address' => $request->company_address,
            ]);

            // Fetch the website model and business model type
            $modelType = strtolower($website->businessModel->model_type);
            $siteId = $website->id;
            $siteIdInWords = numberToWords($siteId); // Convert site ID to words

            // Set base upload path
            $baseUploadPath = public_path("uploads/websites/{$modelType}/{$siteId}/");

            // File upload helper function
            $uploadFile = function ($field, $subfolder, $prefix = null) use ($request, $website, $baseUploadPath, $modelType, $siteId) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $prefix = $prefix ?? $field;
                    $filename = $prefix . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $baseUploadPath . $subfolder;

                    if (!file_exists($path)) {
                        mkdir($path, 0755, true);
                    }

                    $file->move($path, $filename);
                    $website->$field = "uploads/websites/{$modelType}/{$siteId}/{$subfolder}/{$filename}";
                }
            };

            // Upload each file
            $uploadFile('company_logo', 'logos', 'logo');
            $uploadFile('invoice_header_image', 'headers', 'header');
            $uploadFile('invoice_footer_image', 'footers', 'footer');
            $uploadFile('invoice_signature', 'signitures', 'signiture');
            $uploadFile('invoice_image1', 'images1', 'image1'); // New image field
            $uploadFile('invoice_image2', 'images2', 'image2'); // New image field
            $uploadFile('invoice_image3', 'images3', 'image3'); // New image field

            // Special case for invoice_template (blade file)
            if ($request->hasFile('invoice_template')) {
                $oldTemplatePath = resource_path("views/websites/{$modelType}/{$siteIdInWords}.blade.php");
                if (file_exists($oldTemplatePath)) {
                    unlink($oldTemplatePath);
                }
                $file = $request->file('invoice_template');
                $viewPath = resource_path("views/websites/{$modelType}/");

                if (!file_exists($viewPath)) {
                    mkdir($viewPath, 0755, true);
                }

                $file->move($viewPath, "{$siteIdInWords}.blade.php");
                $website->invoice_template = "views/websites/{$modelType}/{$siteIdInWords}.blade.php";
            }

            
            $website->save();

            // Redirect to website edit page with success message
            return redirect()->route('website.edit', $website->id)->with('success', 'Website added successfully.');

        } catch (\Exception $e) {
            // Log any exception that occurs
            Log::error('Website creation error: ' . $e->getMessage());

            // Redirect back with error message
            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again.');
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


    public function connectedwebsites(Request $request){
        try {
            $websites = Website::all();
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
    
}