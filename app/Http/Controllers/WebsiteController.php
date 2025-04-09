<?php
namespace App\Http\Controllers;

use App\Models\BusinessModel;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
   
    public function addbusinessmodel()
    {
        return view('business.addmodel');
    }

    // Store Business Model
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
            ]);
            $errors = $validator->errors()->all();
            $firstError = $errors[0] ?? 'Validation failed.';
            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', $firstError);
            }
    
            Website::create($request->all());
    
            return redirect()->back()->with('success', 'Website added successfully.');
        } catch (\Exception $e) {
            Log::error('Website creation error: ' . $e->getMessage());
    
            return redirect()->back()
                ->withInput()
                ->with('error', 'Something went wrong. Please try again.');
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
}
