<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierRegistration extends Model
{
    protected $fillable = [
        'company_name',
        'business_type',
        'year_of_establishment',
        'country',
        'city',
        'website',
        'responsible_person_name',
        'job_title',
        'email',
        'phone',
        'supply_area',
        'product_description',
        'supply_scope',
        'certifications',
        'commercial_registration',
        'company_profile',
        'product_catalog',
    ];

    protected $casts = [
        'supply_area' => 'array',
        'supply_scope' => 'array',
    ];
}
