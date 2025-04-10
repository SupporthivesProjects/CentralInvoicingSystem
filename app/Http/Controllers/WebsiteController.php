<?php
namespace App\Http\Controllers;

use App\Models\BusinessModel;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
   
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
        ]); 

        $model = BusinessModel::findOrFail($id);
        $model->update($request->all());

        return redirect()->route('businessmodels')->with('success', 'Business model updated!');
    }

    public function deleteBusinessModel($id)
    {
        try {
            $businessModel = BusinessModel::findOrFail($id);
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
            ]);

            // Create the BusinessModel
            BusinessModel::create([
                'name' => $request->name,
                'icon_class' => $request->icon_class
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
        return view('business.addwebsite', compact('businessModels'));
    }

    public function editwebsite($id)
    {
        $website = Website::findOrFail($id);
        $businessModels = BusinessModel::all();
        return view('business.editwebsite', compact('website', 'businessModels'));
    }

    public function updateWebsite(Request $request, $id)
    {
        $request->validate([
                'business_model_id' => 'required|exists:business_models,id',
                'site_name' => 'required|string|max:255',
                'site_description' => 'nullable|string|max:500',
                'db_host' => 'required|string|max:255',
                'db_port' => 'required|numeric',
                'db_name' => 'required|string|max:255',
                'db_username' => 'required|string|max:255',
                'db_password' => 'required|string|max:255',
                'site_link' => 'nullable|url|max:255',
                'remark' => 'nullable|string|max:1000',
                'company_name' => 'nullable|string|max:255',
                'company_email' => 'nullable|email|max:255',
                'company_mobile' => 'nullable|string|max:20',
                'company_address' => 'nullable|string|max:1000',

                'company_logo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_header_image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_footer_image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_signature' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_template' => 'nullable|file|mimes:html|max:2048',
        ]);

        try {
            $website = Website::findOrFail($id);

             // File upload handling
                $uploadPathBase = public_path("websites/{$website->id}/");

                // Helper to upload file
                $uploadFile = function ($field, $subfolder) use ($request, $uploadPathBase, $website) {
                    if ($request->hasFile($field)) {
                        $file = $request->file($field);
                        $filename = $field . '_' . time() . '.' . $file->getClientOriginalExtension();
                        $path = $uploadPathBase . $subfolder;

                        if (!file_exists($path)) {
                            mkdir($path, 0755, true);
                        }

                        $file->move($path, $filename);
                        $website->$field = "websites/{$website->id}/{$subfolder}/{$filename}";
                    }
                };

                $uploadFile('company_logo', 'companylogos');
                $uploadFile('invoice_header_image', 'invoice_headers');
                $uploadFile('invoice_footer_image', 'invoice_footers');
                $uploadFile('invoice_signature', 'invoice_signatures');
                $uploadFile('invoice_template', 'invoice_templates'); // Allow only HTML in validation

                // Update fields
                $website->update([
                    'business_model_id' => $request->business_model_id,
                    'site_name' => $request->site_name,
                    'site_description' => $request->site_description,
                    'db_host' => $request->db_host,
                    'db_port' => $request->db_port,
                    'db_name' => $request->db_name,
                    'db_username' => $request->db_username,
                    'db_password' => $request->db_password,
                    'site_link' => $request->site_link,
                    'remark' => $request->remark,
                    'company_name' => $request->company_name,
                    'company_email' => $request->company_email,
                    'company_mobile' => $request->company_mobile,
                    'company_address' => $request->company_address,
                ]);

                // Save uploaded paths
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
                'business_model_id' => 'required|exists:business_models,id',
                'site_name' => 'required|string|max:255',
                'site_description' => 'nullable|string|max:500',
                'db_host' => 'required|string|max:255',
                'db_port' => 'required|numeric',
                'db_name' => 'required|string|max:255',
                'db_username' => 'required|string|max:255',
                'db_password' => 'required|string|max:255',
                'site_link' => 'nullable|url|max:255',
                'remark' => 'nullable|string|max:1000',
                'company_name' => 'nullable|string|max:255',
                'company_email' => 'nullable|email|max:255',
                'company_mobile' => 'nullable|string|max:20',
                'company_address' => 'nullable|string|max:1000',

                'company_logo' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_header_image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_footer_image' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_signature' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
                'invoice_template' => 'nullable|file|mimes:html|max:2048',
            ]
            );
            $errors = $validator->errors()->all();
            $firstError = $errors[0] ?? 'Validation failed.';
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', $firstError);
            }
    
            // First, create the website record without files
            $website = Website::create([
                'business_model_id' => $request->business_model_id,
                'site_name' => $request->site_name,
                'site_description' => $request->site_description,
                'db_host' => $request->db_host,
                'db_port' => $request->db_port,
                'db_name' => $request->db_name,
                'db_username' => $request->db_username,
                'db_password' => $request->db_password,
                'site_link' => $request->site_link,
                'remark' => $request->remark,
                'company_name' => $request->company_name,
                'company_email' => $request->company_email,
                'company_mobile' => $request->company_mobile,
                'company_address' => $request->company_address,
            ]);

            // File upload path base
            $uploadPathBase = public_path("websites/{$website->id}/");

            // Helper function for file upload
            $uploadFile = function ($field, $subfolder) use ($request, $uploadPathBase, $website) {
                if ($request->hasFile($field)) {
                    $file = $request->file($field);
                    $filename = $field . '_' . time() . '.' . $file->getClientOriginalExtension();
                    $path = $uploadPathBase . $subfolder;

                    if (!file_exists($path)) {
                        mkdir($path, 0755, true);
                    }

                    $file->move($path, $filename);
                    $website->$field = "websites/{$website->id}/{$subfolder}/{$filename}";
                }
            };

            // Upload each file
            $uploadFile('company_logo', 'companylogos');
            $uploadFile('invoice_header_image', 'invoice_headers');
            $uploadFile('invoice_footer_image', 'invoice_footers');
            $uploadFile('invoice_signature', 'invoice_signatures');
            $uploadFile('invoice_template', 'invoice_templates');

            // Save the uploaded paths
            $website->save();
    
            return redirect()->route('website.edit', $website->id)->with('success', 'Website added successfully.');
            
        } catch (\Exception $e) {
            Log::error('Website creation error: ' . $e->getMessage());
    
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