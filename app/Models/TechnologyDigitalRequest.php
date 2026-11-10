<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TechnologyDigitalRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'company_name',
        'job_title',
        'email',
        'phone',
        'country',
        'city',

        'service_type',
        'project_type',
        'project_name',
        'project_description',
        'estimated_budget',
        'expected_start_date',
        'attachment',

        'status',
    ];

    protected $casts = [
        'service_type'        => 'array',
        'project_type'        => 'array',
        'expected_start_date' => 'date',
    ];
}
