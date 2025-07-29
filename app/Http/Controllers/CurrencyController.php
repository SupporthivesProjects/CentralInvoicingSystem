<?php

namespace App\Http\Controllers;
use App\Http\Controllers\CurrencyController;
use App\Models\Currency;
use App\Models\Website;
use App\Models\BusinessModel;
use App\Services\CurrencyConversionService;
use Illuminate\Http\Request;
use App\Models\CurrencyRate;


class CurrencyController extends Controller
{
    protected $currencyService;

    public function __construct(CurrencyConversionService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    public function updateRatesAjax(Request $request)
    {
        $updatedCurrencies = $this->currencyService->updateCurrencyRates();

        $currencies = Currency::all();
        $html = view('currency.currency_rows', compact('currencies'))->render();

        return response()->json([
            'success' => true,
            'updated' => $updatedCurrencies,
            'html' => $html
        ]);
    }


    public function manageRates()
    {
        $rates = CurrencyRate::with(['fromCurrency', 'toCurrency'])->get();
        $currencies = Currency::orderBy('code')->get();

        return view('currency.manage_rates', compact('rates', 'currencies'));
    }

    
    
    public function ajaxUpdate(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|exists:currency_rates,id',
            'rate' => 'required|numeric|min:0'
        ]);

    
        CurrencyRate::where('id', $data['id'])->update([
            'rate' => $data['rate'],
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Rate updated successfully.'
        ]);
    }
    

    public function ajaxAdd(Request $request)
    {
        $data = $request->validate([
            'from_currency_id' => 'required|exists:currencies,id',
            'to_currency_id' => 'required|exists:currencies,id|different:from_currency_id',
            'rate' => 'required|numeric|min:0'
        ]);
    
        $exists = CurrencyRate::where('from_currency_id', $data['from_currency_id'])
            ->where('to_currency_id', $data['to_currency_id'])
            ->exists();
    
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'This currency pair already exists.'
            ]);
        }
    
        $rate = CurrencyRate::create($data)->load(['fromCurrency', 'toCurrency']);
    
        return response()->json([
            'success' => true,
            'message' => 'Rate added successfully.',
            'rate' => [
                'id' => $rate->id,
                'from_currency' => $rate->fromCurrency->code,
                'to_currency' => $rate->toCurrency->code,
                'rate' => $rate->rate
            ]
        ]);
    }
    


    
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
                'currency_id' => 'required|exists:currencies,id',
                'name' => 'required|string|max:255',
                'symbol' => 'required|string|max:255',
                'exchange_rate' => 'required|numeric',
                'code' => 'required|string|max:255',
                'status' => 'required|in:0,1',
            ]);
        
            $currency = Currency::find($request->currency_id);
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
