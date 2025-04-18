<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductPriceHistory extends Model
{
    use HasFactory;

   
    protected $table = 'product_price_histories';

   
    public $timestamps = true;

    
    protected $fillable = [
        'site_id',
        'product_id',
        'unit_price',
        'last_price_changed',
    ];

    protected $dates = ['last_price_changed'];

   
}
