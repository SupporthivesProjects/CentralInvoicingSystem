<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CurrencyController;
use App\Models\Currency;
use App\Models\Website;
use App\Models\BusinessModel;

use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::orderByRaw('status = 1 DESC')->get();
        return view('currency.index', compact('currencies'));

    }

    public function add(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'symbol' => 'required|string|max:255',
                'exchange_rate' => 'required|numeric',
                'code' => 'required|string|max:10',
                'status' => 'required|in:0,1',
            ]);

            if ($request->status == 1) {
                Currency::where('status', 1)->update(['status' => 0]);
            }

            Currency::create([
                'name' => $request->name,
                'symbol' => $request->symbol,
                'exchange_rate' => $request->exchange_rate,
                'status' => $request->status,
                'code' => $request->code,
            ]);

            return redirect()->back()->with('success', 'Currency added successfully!');
        }

        public function getCurrency($id)
        {
            $currency = Currency::find($id);
            if (!$currency) {
                return response()->json(['success' => false, 'message' => 'Currency not found'], 404);
            }
            return response()->json($currency);
        }
        public function edit(Request $request)
        {
            $request->validate([
                'id' => 'required|exists:currencies,id',
                'name' => 'required|string|max:255',
                'symbol' => 'required|string|max:255',
                'exchange_rate' => 'required|numeric',
                'code' => 'required|string|max:255',
                'status' => 'required|in:0,1',
            ]);

            if ($request->status == 1) {
                Currency::where('status', 1)->update(['status' => 0]);
            }

            $currency = Currency::find($request->id);
            if (!$currency) {
                return redirect()->back()->with('error', 'Currency not found.');
            }

            $currency->update([
                'name' => $request->name,
                'symbol' => $request->symbol,
                'exchange_rate' => $request->exchange_rate,
                'status' => $request->status,
                'code' => $request->code,
            ]);

            return redirect()->back()->with('success', 'Currency updated successfully!');
        }

        public function delete($id)
        {
            $currency = Currency::find($id);
        
            if (!$currency) {
                return response()->json(['success' => false, 'message' => 'Currency not found'], 404);
            }
            if ($currency->status == 1) {
                $usdCurrency = Currency::where('code', 'USD')->first();
                
                if ($usdCurrency) {
                    $usdCurrency->status = 1;
                    $usdCurrency->save();
                }
            }
        
            $currency->delete();
            return response()->json(['success' => true, 'message' => 'Currency deleted successfully']);
        }
        
        

}
