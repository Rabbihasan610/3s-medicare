<?php

namespace Database\Seeders;

use App\Models\HealthcareService;
use Illuminate\Database\Seeder;

class HealthcareServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            // Group 01: Digital Presence
            [
                'group_key' => 'digital_presence',
                'group_name' => 'Digital Presence',
                'title' => 'Website Development',
                'slug' => 'website-development',
                'icon' => 'bi-window',
                'short_description' => 'Professional, responsive websites that present your healthcare services clearly.',
                'sort_order' => 1,
            ],
            [
                'group_key' => 'digital_presence',
                'group_name' => 'Digital Presence',
                'title' => 'SEO Services',
                'slug' => 'seo-services',
                'icon' => 'bi-search',
                'short_description' => 'Improve how your practice appears when people search online.',
                'sort_order' => 2,
            ],
            [
                'group_key' => 'digital_presence',
                'group_name' => 'Digital Presence',
                'title' => 'Profile Listing',
                'slug' => 'profile-listing',
                'icon' => 'bi-person-vcard',
                'short_description' => 'Keep your practice information visible on online listing platforms.',
                'sort_order' => 3,
            ],

            // Group 02: Marketing & Creative
            [
                'group_key' => 'marketing_creative',
                'group_name' => 'Marketing & Creative',
                'title' => 'Digital Marketing',
                'slug' => 'digital-marketing',
                'icon' => 'bi-bar-chart-line',
                'short_description' => 'Plan and run campaigns around your healthcare practice.',
                'sort_order' => 4,
            ],
            [
                'group_key' => 'marketing_creative',
                'group_name' => 'Marketing & Creative',
                'title' => 'Social Media',
                'slug' => 'social-media',
                'icon' => 'bi-share',
                'short_description' => 'Consistent, engaging presence on all relevant social channels.',
                'sort_order' => 5,
            ],
            [
                'group_key' => 'marketing_creative',
                'group_name' => 'Marketing & Creative',
                'title' => 'Graphic Design',
                'slug' => 'graphic-design',
                'icon' => 'bi-palette',
                'short_description' => 'Visual branding and graphics that match your clinic identity.',
                'sort_order' => 6,
            ],
            [
                'group_key' => 'marketing_creative',
                'group_name' => 'Marketing & Creative',
                'title' => 'Facebook Ads',
                'slug' => 'facebook-ads',
                'icon' => 'bi-facebook',
                'short_description' => 'Targeted paid reach on Facebook to attract prospective patients.',
                'sort_order' => 7,
            ],
            [
                'group_key' => 'marketing_creative',
                'group_name' => 'Marketing & Creative',
                'title' => 'Google Ads',
                'slug' => 'google-ads',
                'icon' => 'bi-google',
                'short_description' => 'High-intent search visibility on Google for your medical specialties.',
                'sort_order' => 8,
            ],

            // Group 03: Patient-Focused Digital Services
            [
                'group_key' => 'patient_services',
                'group_name' => 'Patient-Focused Digital Services',
                'title' => 'E-Prescription',
                'slug' => 'e-prescription',
                'icon' => 'bi-file-earmark-medical',
                'short_description' => 'Digital prescription support and paperless record keeping.',
                'sort_order' => 9,
            ],
            [
                'group_key' => 'patient_services',
                'group_name' => 'Patient-Focused Digital Services',
                'title' => 'Patient Appointment',
                'slug' => 'patient-appointment',
                'icon' => 'bi-calendar-check',
                'short_description' => 'Simpler, seamless appointment booking for your patients.',
                'sort_order' => 10,
            ],
            [
                'group_key' => 'patient_services',
                'group_name' => 'Patient-Focused Digital Services',
                'title' => 'Patient Queue',
                'slug' => 'patient-queue',
                'icon' => 'bi-people',
                'short_description' => 'Clearer patient queue handling and reduced waiting room friction.',
                'sort_order' => 11,
            ],
        ];

        foreach ($services as $svc) {
            HealthcareService::updateOrCreate(['slug' => $svc['slug']], $svc);
        }
    }
}

