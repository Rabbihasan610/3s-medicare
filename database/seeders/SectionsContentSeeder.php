<?php

namespace Database\Seeders;

use App\Models\Frontend;
use App\Models\Page;
use Illuminate\Database\Seeder;

class SectionsContentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Hero
        Frontend::updateOrCreate(
            ['data_keys' => 'hero.content'],
            [
                'data_values' => [
                    'eyebrow' => 'Your Healthcare Digital Partner',
                    'heading' => 'Your Healthcare Expertise.',
                    'heading_accent' => 'Our Digital Growth.',
                    'subheading' => 'Websites, Branding, SEO and Digital Marketing for doctor, clinics, Hospitals and Diagnostic centers.',
                    'btn_1_text' => 'Get a Quote',
                    'btn_1_url' => 'contact',
                    'btn_2_text' => 'View Our Work',
                    'btn_2_url' => '#services',
                    'hero_tags' => 'Doctors, Hospitals, Clinics, Diagnostic Centers',
                    'hero_image' => 'assets/images/3s/hero-doctor.jpg',
                ]
            ]
        );

        // 2. Digital Impact (content + elements)
        Frontend::updateOrCreate(
            ['data_keys' => 'digital_impact.content'],
            [
                'data_values' => [
                    'eyebrow' => 'Digital Impact',
                    'title' => 'Build a Stronger Digital Presence for Your Healthcare Business.',
                    'lead' => 'From professional websites and online visibility to patient-focused digital services, we help healthcare businesses create better digital experiences.'
                ]
            ]
        );

        $impactCards = [
            [
                'title' => 'Be Found Online',
                'description' => 'Help patients discover your practice when they search.',
                'tags' => 'SEO Services, Profile Listing, Website Development',
                'thumb' => 'assets/images/3s/card-be-found.jpg',
            ],
            [
                'title' => 'Reach the Right Audience',
                'description' => 'Promote your services to the people who need them.',
                'tags' => 'Digital Marketing, Facebook Ads, Google Ads',
                'thumb' => 'assets/images/3s/card-reach.jpg',
            ],
            [
                'title' => 'Simplify Patient Access',
                'description' => 'Make it easier for patients to reach and book you.',
                'tags' => 'Patient Appointment, Patient Queue, E-Prescription',
                'thumb' => 'assets/images/3s/card-simplify.jpg',
            ],
        ];

        Frontend::where('data_keys', 'digital_impact.element')->delete();
        foreach ($impactCards as $c) {
            Frontend::create(['data_keys' => 'digital_impact.element', 'data_values' => $c]);
        }

        // 3. Who We Help (content + elements)
        Frontend::updateOrCreate(
            ['data_keys' => 'who_we_help.content'],
            [
                'data_values' => [
                    'eyebrow' => 'Who We Help',
                    'title' => 'Digital Support for Every Healthcare Practice.',
                ]
            ]
        );

        $helpCards = [
            [
                'title' => 'Doctors',
                'description' => 'A professional online presence for individual practitioners.',
                'link_text' => 'Services for doctors',
                'link_url' => 'services#doctors',
                'thumb' => 'assets/images/3s/who-doctors.jpg',
            ],
            [
                'title' => 'Hospitals',
                'description' => 'Connected digital services for larger organizations.',
                'link_text' => 'Services for hospitals',
                'link_url' => 'services#hospitals',
                'thumb' => 'assets/images/3s/who-hospitals.jpg',
            ],
            [
                'title' => 'Clinics',
                'description' => 'Visibility and patient access for your clinic.',
                'link_text' => 'Services for clinics',
                'link_url' => 'services#clinics',
                'thumb' => 'assets/images/3s/who-clinics.jpg',
            ],
            [
                'title' => 'Diagnostic Centers',
                'description' => 'Clear digital presence for diagnostic services.',
                'link_text' => 'Services for diagnostic centers',
                'link_url' => 'services#diagnostic',
                'thumb' => 'assets/images/3s/who-diagnostic.jpg',
            ],
        ];

        Frontend::where('data_keys', 'who_we_help.element')->delete();
        foreach ($helpCards as $h) {
            Frontend::create(['data_keys' => 'who_we_help.element', 'data_values' => $h]);
        }

        // 4. Services preview
        Frontend::updateOrCreate(
            ['data_keys' => 'services.content'],
            [
                'data_values' => [
                    'eyebrow' => 'Our Services',
                    'title' => 'Everything Your Healthcare Business Needs to Grow Online.',
                    'lead' => 'Three connected service groups make it easier to identify the right starting point.'
                ]
            ]
        );

        // 5. Why Choose Us
        Frontend::updateOrCreate(
            ['data_keys' => 'why_choose_us.content'],
            [
                'data_values' => [
                    'eyebrow' => 'Why Choose Us',
                    'title' => 'Healthcare Expertise. Digital Solutions That Work for Your Practice.',
                    'image' => 'assets/images/3s/why-team.jpg',
                ]
            ]
        );

        $whyPoints = [
            ['title' => 'Healthcare-Focused Approach', 'description' => 'Built around how healthcare practices work.'],
            ['title' => 'Connected Digital Services', 'description' => 'Website, marketing and patient services that fit together.'],
            ['title' => 'Patient-Friendly Digital Access', 'description' => 'Simple ways for patients to reach you.'],
            ['title' => 'Consistent Brand Presence', 'description' => 'One look across every channel.'],
        ];

        Frontend::where('data_keys', 'why_choose_us.element')->delete();
        foreach ($whyPoints as $p) {
            Frontend::create(['data_keys' => 'why_choose_us.element', 'data_values' => $p]);
        }

        // 6. Process (How We Work)
        Frontend::updateOrCreate(
            ['data_keys' => 'process.content'],
            [
                'data_values' => [
                    'eyebrow' => 'How We Work',
                    'title' => 'A Clear Process From Brief to Launch.',
                ]
            ]
        );

        $steps = [
            ['step_no' => '01', 'title' => 'Discover', 'description' => 'We learn about your practice audience and goals.'],
            ['step_no' => '02', 'title' => 'Strategize', 'description' => 'We shape the right digital strategy and project plan.'],
            ['step_no' => '03', 'title' => 'Design & Deliver', 'description' => 'We design and build your website, branding or marketing solution.'],
            ['step_no' => '04', 'title' => 'Launch & Grow', 'description' => 'We take it live and support you with ongoing improvements.'],
        ];

        Frontend::where('data_keys', 'process.element')->delete();
        foreach ($steps as $s) {
            Frontend::create(['data_keys' => 'process.element', 'data_values' => $s]);
        }

        // 7. Our Work
        Frontend::updateOrCreate(
            ['data_keys' => 'our_work.content'],
            [
                'data_values' => [
                    'eyebrow' => 'Our Work',
                    'title' => 'Digital Work Designed Around Healthcare Needs.',
                    'btn_text' => 'View Case Studies',
                    'btn_url' => 'services',
                    'showcase_image' => 'assets/images/3s/work-showcase.jpg',
                ]
            ]
        );

        // 8. CTA
        Frontend::updateOrCreate(
            ['data_keys' => 'cta.content'],
            [
                'data_values' => [
                    'heading' => 'Ready to Strengthen Your Healthcare Online?',
                    'subheading' => 'Tell us about your practice and the digital services you need.',
                    'btn_1_text' => 'Get a Quote',
                    'btn_1_url' => 'contact',
                    'btn_2_text' => 'Contact Us',
                    'btn_2_url' => 'contact',
                ]
            ]
        );

        // 9. About Hero
        Frontend::updateOrCreate(
            ['data_keys' => 'about_hero.content'],
            [
                'data_values' => [
                    'eyebrow' => 'About Us',
                    'heading' => 'A Digital Agency Focused on Healthcare.',
                    'description' => 'We create professional, responsive websites that help doctors, clinics, hospitals, and diagnostic centers communicate their services clearly and provide visitors with an easy-to-use online experience.',
                    'btn_1_text' => 'Discuss Your Website',
                    'btn_1_url' => 'contact',
                    'btn_2_text' => 'Explore Our Services',
                    'btn_2_url' => 'services',
                    'image' => 'assets/images/3s/about-hero.jpg',
                ]
            ]
        );

        // 10. About Approach
        Frontend::updateOrCreate(
            ['data_keys' => 'about_approach.content'],
            [
                'data_values' => [
                    'eyebrow' => 'Our Approach',
                    'title' => 'Healthcare-focused, from website to patient access',
                    'image' => 'assets/images/3s/why-team.jpg',
                ]
            ]
        );

        Frontend::where('data_keys', 'about_approach.element')->delete();
        foreach ($whyPoints as $p) {
            Frontend::create(['data_keys' => 'about_approach.element', 'data_values' => $p]);
        }

        // 11. Services Hero
        Frontend::updateOrCreate(
            ['data_keys' => 'services_hero.content'],
            [
                'data_values' => [
                    'eyebrow' => 'Our Services',
                    'heading' => 'Digital Solutions Built for Better Healthcare Growth.',
                    'description' => 'From healthcare websites and search visibility to digital marketing and patient-focused digital services, we help healthcare providers build a stronger digital presence.',
                    'btn_1_text' => 'Explore Our Services',
                    'btn_1_url' => '#digital-presence',
                    'btn_2_text' => 'Book a Consultation',
                    'btn_2_url' => 'contact',
                    'image' => 'assets/images/3s/services-hero.jpg',
                ]
            ]
        );

        // 12. Contact Banner
        Frontend::updateOrCreate(
            ['data_keys' => 'contact_banner.content'],
            [
                'data_values' => [
                    'eyebrow' => 'Contact Us',
                    'heading' => 'Tell Us About Your Practice.',
                    'subheading' => 'Share the digital services you need and our team will get back to you with the next steps.',
                ]
            ]
        );

        // 13. Contact Info & Form
        Frontend::updateOrCreate(
            ['data_keys' => 'contact_form.content'],
            [
                'data_values' => [
                    'card_title' => 'Get in Touch',
                    'card_subtitle' => 'We help doctors, clinics, hospitals and diagnostic centers build a stronger online presence.',
                    'email' => 'info@3smedicare.com',
                    'phone' => '+1 (555) 234-5678',
                    'hours' => 'Mon - Fri: 9:00 AM - 6:00 PM',
                    'location' => 'Medical Arts Plaza, Suite 400',
                ]
            ]
        );

        // 14. Contact Map
        Frontend::updateOrCreate(
            ['data_keys' => 'contact_map.content'],
            [
                'data_values' => [
                    'location_name' => '3S Medi Care Headquarters',
                    'map_note' => 'Medical Arts Plaza, Suite 400',
                    'embed_code' => '',
                ]
            ]
        );

        // 15. Pages: Update default sections for Home ('/'), About ('about'), Services ('services'), Contact ('contact')
        Page::updateOrCreate(
            ['slug' => '/'],
            [
                'name' => 'Home',
                'slug' => '/',
                'secs' => json_encode(['hero', 'digital_impact', 'who_we_help', 'services', 'why_choose_us', 'process', 'our_work', 'cta']),
                'is_default' => 1,
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'about'],
            [
                'name' => 'About Us',
                'slug' => 'about',
                'secs' => json_encode(['about_hero', 'about_approach', 'why_choose_us', 'cta']),
                'is_default' => 0,
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'services'],
            [
                'name' => 'Our Services',
                'slug' => 'services',
                'secs' => json_encode(['services_hero', 'services_groups', 'cta']),
                'is_default' => 0,
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'contact'],
            [
                'name' => 'Contact Us',
                'slug' => 'contact',
                'secs' => json_encode(['contact_banner', 'contact_form', 'contact_map']),
                'is_default' => 0,
            ]
        );

        // 16. Get a Quote Section Content
        Frontend::updateOrCreate(
            ['data_keys' => 'get_quote.content'],
            [
                'data_values' => [
                    'eyebrow' => 'Instant Healthcare Quote',
                    'title' => 'Request a Tailored Quote for Your Practice',
                    'subheading' => 'Fill out the simple form below. Pick a category or type your custom practice type, select the services you need, and our medical growth specialists will get back to you within 24 hours.',
                    'categories' => 'Doctor / Practitioner, Hospital, Specialized Clinic, Diagnostic & Imaging Center, Dental Practice, HealthTech & Startup, Other',
                    'services_list' => 'Website Design & Development, Healthcare SEO & Google Ranking, Social Media & Marketing, Patient Appointment & Queue, Branding & Identity, HIPAA Compliant Hosting',
                    'side_card_title' => 'Why Healthcare Leaders Partner with 3S Medi Care',
                    'side_card_desc' => 'We specialize strictly in healthcare organizations. Our digital solutions are built around patient trust, medical accuracy, and conversion.',
                    'side_points' => 'Fast 24-hour turnaround on custom proposals, 100% HIPAA & Medical Compliance focused, Specialized healthcare UI/UX design, Dedicated account manager and ongoing support',
                    'btn_text' => 'Submit Quote Request',
                ]
            ]
        );

        Page::updateOrCreate(
            ['slug' => 'get-quote'],
            [
                'name' => 'Get a Quote',
                'slug' => 'get-quote',
                'secs' => json_encode(['get_quote']),
                'is_default' => 0,
            ]
        );
    }
}

