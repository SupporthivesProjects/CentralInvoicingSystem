<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_connectivity',
        'business_model_id',
        'site_name',
        'site_description',
        'technology',
        'db_host',
        'db_port',
        'db_name',
        'db_username',
        'db_password',
        'product_table',
        'product_price_table',
        'currency_table',
        'bundle_table',
        'general_settings',
        'category_table',
        'tags_table',
        'term_taxonomy_table',
        'consumer_key',
        'consumer_secret',
        'site_name',
        'site_link',
        'std_trans_url',   
        'cert_trans_url', 
        'remark',
        'company_name',
        'company_email',
        'company_mobile',
        'company_address',
        'registration_number',
        'license_number',
        'bank_name',
        'bank_code',
        'pdf_size',
        'pdf_orientation',
        'site_status',
        'added_by',
        'invoice_header_image',
        'invoice_footer_image',
        'invoice_signature',
        'company_logo',
        'invoice_image1',
        'invoice_image2',
        'invoice_image3',
        'invoice_image4',
        'invoice_image5',
        'invoice_image6',
        'invoice_image7',
        'invoice_image8',
        'invoice_image9',
        'invoice_template',
    ];

    /**
     * Get the business model this website belongs to.
     */
    public function businessModel()
    {
        return $this->belongsTo(BusinessModel::class, 'business_model_id');
    }

    public function getStandardTranslationUrlAttribute()
    {
        return rtrim($this->site_link, '/') . '/' . ltrim($this->std_trans_url, '/');
    }
    
    public function getCertifiedTranslationUrlAttribute()
    {
        return rtrim($this->site_link, '/') . '/' . ltrim($this->cert_trans_url, '/');
    }
    

}
