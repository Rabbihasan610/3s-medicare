<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class MediaAndEventsRequest extends Model
{
       use HasFactory;

       protected $table ='media_events_requests';
    protected $fillable = [
        'full_name',
        'company_name',
        'job_title',
        'email',
        'phone',
        'country',
        'city',
        'service_type',
        'event_type',
        'event_country',
        'event_city',
        'expected_event_date',
        'expected_attendees',
        'event_description',
        'additional_services',
        'attachment',
        'status',
    ];

    protected $casts = [
        'service_type'        => 'array',
        'additional_services' => 'array',
        'expected_event_date' => 'date',
    ];
}
