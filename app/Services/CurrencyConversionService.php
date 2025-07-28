<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Http;

class CurrencyConversionService
{
    protected $baseCurrency = 'USD'; 
    protected $apiKey = 'b2cffeb030066f64de32555f'; 

    public function updateCurrencyRates()
    {
        $response = Http::get("https://open.er-api.com/v6/latest/{$this->baseCurrency}");
    
        if ($response->successful() && isset($response['rates'])) {
            $rates = $response['rates'];
    
            foreach ($rates as $code => $rate) {
                $currency = Currency::where('code', $code)->first();
    
                if ($currency) {
                    $currency->update([
                        'exchange_rate' => $rate,
                        'status' => 1
                    ]);
                }
            }
    
            return true;
        }
    
        return false;
    }
    
}


?>