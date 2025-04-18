<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessModel extends Model
{
    use HasFactory;

    protected $table = 'business_models';

    protected $fillable = [
        'name',
        'icon_class',
        'model_type',
    ];

    public function websites()
    {
        return $this->hasMany(Website::class, 'business_model_id');
    }
}
