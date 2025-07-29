<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CurrencyRate;

class Currency extends Model
{
    protected $fillable = [
        'name', 'symbol', 'exchange_rate', 'status', 'code'
    ];


    public function ratesFrom()
    {
        return $this->hasMany(CurrencyRate::class, 'from_currency_id');
    }

    public function ratesTo()
    {
        return $this->hasMany(CurrencyRate::class, 'to_currency_id');
    }
}
