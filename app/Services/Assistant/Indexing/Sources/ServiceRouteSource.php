<?php

namespace App\Services\Assistant\Indexing\Sources;

use App\Models\HealthcareService;
use App\Services\Assistant\Indexing\KnowledgeSource;

/*
| The routing and knowledge map for 3S Medi Care healthcare services.
| Powers the AI Help Center and live search indexing.
*/
class ServiceRouteSource implements KnowledgeSource
{
    public function type(): string
    {
        return 'service';
    }

    public function documents(): iterable
    {
        // 1. Primary Pages of 3S Medi Care
        $corePages = [
            'home' => [
                'title' => '3S Medi Care - Healthcare Expertise. Our Digital Growth.',
                'desc' => 'Your Healthcare Expertise, Our Digital Growth. We help doctors, clinics, hospitals, and diagnostic centers build modern websites, rank #1 on Google, and simplify patient access.',
                'url' => '/',
                'route' => 'home'
            ],
            'services' => [
                'title' => 'Healthcare Digital Growth Services',
                'desc' => 'Comprehensive digital solutions tailored for healthcare practices: Medical Website Design & Development, Healthcare SEO & Google Ranking, Social Media & Marketing, Patient Appointment & Queue Systems, Medical Branding & Identity, and HIPAA Compliant Hosting.',
                'url' => '/services',
                'route' => 'pages'
            ],
            'about-us' => [
                'title' => 'About 3S Medi Care',
                'desc' => 'Specialized healthcare digital agency. We bridge the gap between healthcare excellence and patient acquisition through modern technology, design, and search engine optimization.',
                'url' => '/about-us',
                'route' => 'pages'
            ],
            'get-quote' => [
                'title' => 'Request a Tailored Healthcare Quote',
                'desc' => 'Get a fixed-scope digital proposal and cost estimate for your practice within 24 hours. Zero obligation, 100% medical privacy compliant.',
                'url' => '/get-quote',
                'route' => 'get.quote'
            ],
            'contact' => [
                'title' => 'Contact 3S Medi Care',
                'desc' => 'Get in touch with our medical digital consultants via phone at +1 (555) 234-5678 or email at info@3smedicare.com. Located at Medical Arts Plaza, Suite 400.',
                'url' => '/contact',
                'route' => 'pages'
            ],
        ];

        foreach ($corePages as $key => $p) {
            yield [
                'source_key' => 'page.' . $key,
                'route_name' => $p['route'],
                'url'        => $p['url'],
                'title'      => $p['title'],
                'title_ar'   => $p['title'],
                'bodies'     => [
                    'en' => "Page: {$p['title']}\nURL: {$p['url']}\nDescription: {$p['desc']}\nCompany: 3S Medi Care",
                    'ar' => "Page: {$p['title']}\nURL: {$p['url']}\nDescription: {$p['desc']}\nCompany: 3S Medi Care",
                ],
            ];
        }

        // 2. Active Healthcare Services from Database
        if (class_exists(HealthcareService::class)) {
            $services = HealthcareService::active()->get();
            foreach ($services as $svc) {
                $title = $svc->title;
                $desc = $svc->short_description ?: $svc->description;
                $features = is_array($svc->features) ? implode(', ', $svc->features) : '';
                $group = $svc->group_name;
                $url = '/services#' . $svc->slug;
                $quoteUrl = '/get-quote?service=' . urlencode($svc->title);

                $content = "Service: {$title}\nCategory: {$group}\nDetails: {$desc}\nKey Features: {$features}\nExplore Service: {$url}\nRequest a Quote: {$quoteUrl}\nOffered by 3S Medi Care.";

                yield [
                    'source_key' => 'service.' . $svc->id,
                    'route_name' => 'get.quote',
                    'url'        => $url,
                    'title'      => $title,
                    'title_ar'   => $title,
                    'bodies'     => [
                        'en' => $content,
                        'ar' => $content,
                    ],
                ];
            }
        }
    }
}
