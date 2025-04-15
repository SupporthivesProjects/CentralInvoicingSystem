<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceGenerationHistory extends Model
{
    protected $table = 'invoice_generation_histories';

    protected $fillable = [
        'model_type',
        'site_id',
        'currency',
        'invoice_number',
        'product_ids',
        'current_amount',
        'discount_amount',
        'invoice_amount',
    ];

    protected $casts = [
        'product_ids' => 'array',
        'current_amount' => 'float',
        'discount_amount' => 'float',
        'invoice_amount' => 'float',
    ];
}
