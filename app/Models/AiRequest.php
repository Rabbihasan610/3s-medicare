<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AiRequest extends Model
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
        'solution_type',
        'project_field',
        'project_name',
        'project_description',
        'objective',
        'project_size',
        'expected_start_date',
        'attachment',
        'status',
    ];
    protected $casts = [
        'solution_type' => 'array',
        'objective'     => 'array',
        'project_size'  => 'array',
        'expected_start_date' => 'date',
    ];
}
