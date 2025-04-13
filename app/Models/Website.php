<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_model_id',
        'site_name',
        'site_description',
        'db_host',
        'db_port',
        'db_name',
        'db_username',
        'db_password',
        'site_link',
        'remark',
        'company_name',
        'company_email',
        'company_mobile',
        'company_address',
        'invoice_header_image',
        'invoice_footer_image',
        'invoice_signature',
        'company_logo',
        'invoice_image1',
        'invoice_image2',
        'invoice_image3',
        'invoice_template',
    ];

    /**
     * Get the business model this website belongs to.
     */
    public function businessModel()
    {
        return $this->belongsTo(BusinessModel::class, 'business_model_id');
    }
}
