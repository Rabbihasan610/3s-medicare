<!doctype html>
<html lang="{{ app()->getLocale() }}" dir="ltr" itemscope itemtype="http://schema.org/WebPage">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ gs('site_name') }} - {{ __(@$title ?? 'Healthcare Digital Growth') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ siteFavicon() }}">

    @php
        $seo = getContent('seo.data', true);
        $seoValues = @$seo->data_values;

        $seoKeywords = @$seoValues->keywords;
        if (is_array($seoKeywords)) {
            $seoKeywords = implode(', ', $seoKeywords);
        }

        $pageTitle = (@$title ? $title . ' - ' : '') . gs('site_name');
        $seoDescription =
            @$seoValues->description ?:
            gs('site_name') . ' - Healthcare digital growth, medical website design, and practice marketing solutions.';
        $socialTitle = @$seoValues->social_title ?: $pageTitle;
        $socialDescription = @$seoValues->social_description ?: $seoDescription;
        $seoImage = seoImage();
        $googleVerification =
            @$seoValues->google_verification ?: extensionShortcode('google-site-verification', 'verification_code');
        $bingVerification =
            @$seoValues->bing_verification ?: extensionShortcode('bing-site-verification', 'verification_code');
        $robotsMeta = @$seoValues->robots_meta ?: 'index, follow';
        $canonicalUrl = @$seoValues->canonical_url ?: url()->current();
    @endphp

    <!-- Search Engine Meta Tags -->
    <meta name="title" content="{{ $pageTitle }}">
    <meta name="description" content="{{ $seoDescription }}">
    @if (!empty($seoKeywords))
        <meta name="keywords" content="{{ $seoKeywords }}">
    @endif
    <meta name="robots" content="{{ $robotsMeta }}">
    <meta name="author" content="{{ gs('site_name') }}">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <!-- Google & Search Engine Verification -->
    @if (!empty($googleVerification) && $googleVerification !== '------')
        <meta name="google-site-verification" content="{{ $googleVerification }}">
    @endif
    @if (!empty($bingVerification) && $bingVerification !== '------')
        <meta name="msvalidate.01" content="{{ $bingVerification }}">
    @endif

    <!-- Open Graph / Facebook / LinkedIn Meta -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ gs('site_name') }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:title" content="{{ $socialTitle }}">
    <meta property="og:description" content="{{ $socialDescription }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:image:width" content="1180">
    <meta property="og:image:height" content="600">

    <!-- Twitter / X Meta -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $canonicalUrl }}">
    <meta name="twitter:title" content="{{ $socialTitle }}">
    <meta name="twitter:description" content="{{ $socialDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">

    <!-- Schema.org JSON-LD Structured Data -->
    @include('partials.structured_data')

    <!-- Head Analytics & Tracking Scripts -->
    @include('partials.head_scripts')

    <!-- Google Font: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5.3.3 & Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- 3S Medi Care Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/web/css/3s/root.css') }}?v=3s1.3">
    <link rel="stylesheet" href="{{ asset('assets/web/css/3s/base.css') }}?v=3s1.3">
    <link rel="stylesheet" href="{{ asset('assets/web/css/3s/sections.css') }}?v=3s1.3">
    <link rel="stylesheet" href="{{ asset('assets/web/css/3s/pages.css') }}?v=3s1.3">

    <!-- Header & Shimmer Animation Styles -->
    <style>
        .site-header {
            background-color: #081C24 !important;
            background: #081C24 !important;
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
        }

        .site-header.is-scrolled {
            background-color: #081C24 !important;
            background: #081C24 !important;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .35) !important;
        }

        [x-cloak] {
            display: none !important;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        .shimmer {
            background: linear-gradient(90deg,
                    rgba(227, 234, 240, 0.4) 25%,
                    rgba(227, 234, 240, 0.9) 37%,
                    rgba(227, 234, 240, 0.4) 63%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite ease-in-out;
            border-radius: var(--radius-sm, 8px);
        }

        .opacity-0 {
            opacity: 0;
        }

        .opacity-100 {
            opacity: 1;
        }
    </style>

    @stack('style-lib')
    @stack('style')

    <!-- Alpine.js 3.x (defer for non-blocking super fast load) -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.3/dist/cdn.min.js"></script>
</head>

<body x-data="{ mobileNav: false, isScrolled: false, searchOpen: false }" @scroll.window="isScrolled = (window.pageYOffset > 20)">

    <!-- SHARED HEADER -->
    <header class="site-header" :class="{ 'is-scrolled': isScrolled }">
        <nav class="navbar navbar-expand-lg">
            <div class="container d-flex align-items-center">
                <a class="navbar-brand" href="{{ url('/') }}" aria-label="{{ gs('site_name') }}">
                    <img src="{{ siteLogo() }}" alt="{{ gs('site_name') }}"
                        style="max-height: 42px; width: auto; object-fit: contain;">
                </a>

                <div class="d-flex align-items-center gap-2 d-lg-none">

                    <button class="navbar-toggler border-0 p-0" type="button" @click="mobileNav = !mobileNav"
                        aria-label="Toggle navigation">
                        <i class="bi bi-list fs-2 text-white"></i>
                    </button>
                </div>

                <div class="collapse navbar-collapse" :class="{ 'show': mobileNav }" id="mainNav">
                    <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                                href="{{ url('/') }}">{{ __('Home') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('services*') ? 'active' : '' }}"
                                href="{{ url('services') }}">{{ __('Our Services') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('about-us*') ? 'active' : '' }}"
                                href="{{ url('about-us') }}">{{ __('About Us') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('contact*') ? 'active' : '' }}"
                                href="{{ url('contact') }}">{{ __('Contact') }}</a>
                        </li>
                    </ul>

                    <div class="d-flex align-items-center gap-2">
                        <a href="{{ url('get-quote') }}" class="btn-header">{{ __('Get a Quote') }} <i
                                class="bi bi-arrow-up-right"></i></a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- SHARED FOOTER -->
    @php
        $footerInfo = getContent('footer.content', true);
        $fValues = @$footerInfo->data_values;

        $contactInfo = getContent('contact_form.content', true);
        $cValues = @$contactInfo->data_values;

        $aboutText =
            @$fValues->about_text ?:
            'Healthcare-focused digital services for practices ready to build a stronger online presence.';
        $email = @$fValues->email ?: (@$cValues->email ?: 'info@3smedicare.com');
        $phone = @$fValues->phone ?: (@$cValues->phone ?: '+1 (555) 234-5678');
        $hours = @$fValues->hours ?: (@$cValues->hours ?: 'Mon - Fri: 9:00 AM - 6:00 PM');
        $location = @$fValues->location ?: (@$cValues->location ?: 'Medical Arts Plaza, Suite 400');
        $copyrightText = @$fValues->copyright_text ?: __('All rights reserved.');

        $activeServices = \App\Models\HealthcareService::active()->limit(5)->get();
    @endphp
    <footer class="site-footer">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4">
                    <img class="footer-logo mb-3" src="{{ siteLogo() }}" alt="{{ gs('site_name') }}"
                        style="max-height: 42px; width: auto; object-fit: contain;">
                    <p class="mb-0" style="max-width:280px">
                        {{ __($aboutText) }}
                    </p>
                </div>
                <div class="col-6 col-lg-2 ms-lg-auto">
                    <h4>{{ __('Company') }}</h4>
                    <ul>
                        <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                        <li><a href="{{ url('about-us') }}">{{ __('About Us') }}</a></li>
                        <li><a href="{{ url('services') }}">{{ __('Our Services') }}</a></li>
                        <li><a href="{{ url('contact') }}">{{ __('Contact Us') }}</a></li>
                        <li><a href="{{ url('get-quote') }}">{{ __('Get a Quote') }}</a></li>
                    </ul>
                </div>
                <div class="col-6 col-lg-3">
                    <h4>{{ __('Services') }}</h4>
                    <ul>
                        @if ($activeServices->count() > 0)
                            @foreach ($activeServices as $asvc)
                                <li><a href="{{ url('services#' . $asvc->slug) }}">{{ __($asvc->title) }}</a></li>
                            @endforeach
                        @else
                            <li><a href="{{ url('services#web') }}">{{ __('Website Development') }}</a></li>
                            <li><a href="{{ url('services#seo') }}">{{ __('Healthcare SEO') }}</a></li>
                            <li><a href="{{ url('services#marketing') }}">{{ __('Digital Marketing') }}</a></li>
                            <li><a href="{{ url('services#appointment') }}">{{ __('Patient Appointment') }}</a></li>
                        @endif
                    </ul>
                </div>
                <div class="col-6 col-lg-3">
                    <h4>{{ __('Contact') }}</h4>
                    <ul>
                        <li><i class="bi bi-envelope me-1 text-accent"></i> {{ $email }}</li>
                        <li><i class="bi bi-telephone me-1 text-accent"></i> {{ $phone }}</li>
                        <li><i class="bi bi-clock me-1 text-accent"></i> {{ $hours }}</li>
                        <li><i class="bi bi-geo-alt me-1 text-accent"></i> {{ $location }}</li>
                    </ul>
                </div>
            </div>
            <div
                class="footer-bottom mt-5 pt-3 border-top border-secondary text-secondary d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div>&copy; {{ date('Y') }} {{ gs('site_name') }}. {{ $copyrightText }}</div>
                <div>
                    <a href="{{ route('cookie.policy') }}"
                        class="text-secondary text-decoration-none me-3">{{ __('Cookie Policy') }}</a>
                    <a href="{{ route('privacy.policy') }}"
                        class="text-secondary text-decoration-none">{{ __('Privacy Policy') }}</a>
                </div>
            </div>
        </div>
    </footer>

    {{-- Search & Instant Query Modal --}}
    @include('web.partials.search_modal')

    {{-- AI Help Center Widget --}}
    @include('web.partials.assistant_widget')

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scroll Reveal Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const reveals = document.querySelectorAll('.reveal');
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('is-visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.12
                });
                reveals.forEach(el => observer.observe(el));
            } else {
                reveals.forEach(el => el.classList.add('is-visible'));
            }
        });
    </script>

    @stack('script-lib')
    @stack('script')
</body>

</html>
