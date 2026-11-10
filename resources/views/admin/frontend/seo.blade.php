@extends('admin.layouts.app', ['title' => 'SEO & Webmaster Configuration'])

@section('panel')
<div class="row gy-4">
    {{-- TOP BANNER --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm" style="border-radius: 14px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div>
                        <h5 class="card-title fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                            <i class="bi bi-search text-primary fs-4"></i>
                            <span>{{ __('Search Engine Optimization & Verification') }}</span>
                            <span class="badge bg-success-subtle text-success px-2 py-1 fs-7 rounded-pill">{{ __('Active') }}</span>
                        </h5>
                        <p class="text-muted small mb-0">
                            {{ __('Manage meta tags, Open Graph previews, Google Search Console verification, and search crawler indexing for 3S Medi Care.') }}
                        </p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('admin.setting.sitemap') }}" class="btn btn-outline-primary btn-sm px-3 d-inline-flex align-items-center gap-1">
                            <i class="bi bi-diagram-3"></i> {{ __('Sitemap Manager') }}
                        </a>
                        <a href="{{ route('admin.setting.robots') }}" class="btn btn-outline-secondary btn-sm px-3 d-inline-flex align-items-center gap-1">
                            <i class="bi bi-robot"></i> {{ __('Robots.txt') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <form action="{{ route('admin.frontend.sections.content', 'seo') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="data">
            <input type="hidden" name="seo_image" value="1">

            <div class="row g-4">
                {{-- LEFT COLUMN: SOCIAL SHARE IMAGE & SEARCH CONSOLE GUIDE --}}
                <div class="col-xl-4">
                    {{-- SOCIAL SHARE IMAGE CARD --}}
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
                        <div class="card-header bg-white border-bottom py-3">
                            <strong class="text-dark"><i class="bi bi-image text-primary me-2"></i>{{ __('Social Share / OG Image') }}</strong>
                        </div>
                        <div class="card-body p-4">
                            <x-image-uploader class="w-100" name="image_input" :imagePath="getImage(getFilePath('seo') . '/' . @$seo->data_values->image, getFileSize('seo'))" :size="getFileSize('seo')" :required="false" />
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle me-1"></i>{{ __('Recommended dimensions: 1180x600 px (PNG/JPG). Displayed when sharing your website on Facebook, Twitter, WhatsApp, and LinkedIn.') }}
                            </small>
                        </div>
                    </div>

                    {{-- GOOGLE SEARCH CONSOLE QUICK LINKS --}}
                    <div class="card border-0 shadow-sm" style="border-radius: 14px; background: #081C36; color: #ffffff;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-google text-warning fs-4"></i>
                                <h6 class="fw-bold text-white mb-0">{{ __('Google Search Console') }}</h6>
                            </div>
                            <p class="small text-white-50 mb-3" style="line-height: 1.5;">
                                {{ __('Verify your domain with Google to monitor keyword rankings, index status, and submit your sitemap.') }}
                            </p>
                            <a href="https://search.google.com/search-console" target="_blank" class="btn btn-sm btn-outline-light w-100 py-2">
                                <i class="bi bi-box-arrow-up-right me-1"></i> {{ __('Open Search Console') }}
                            </a>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN: META TAGS, SOCIAL TAGS & VERIFICATIONS --}}
                <div class="col-xl-8">
                    {{-- SECTION 1: SEARCH ENGINE VERIFICATION CODES --}}
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
                        <div class="card-header bg-white border-bottom py-3">
                            <strong class="text-dark"><i class="bi bi-shield-check text-success me-2"></i>{{ __('Webmaster & Search Engine Verification') }}</strong>
                        </div>
                        <div class="card-body p-4">
                            {{-- GOOGLE SITE VERIFICATION --}}
                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark d-flex align-items-center justify-content-between">
                                    <span>
                                        <i class="bi bi-google text-danger me-1"></i>
                                        {{ __('Google Site Verification Code') }}
                                    </span>
                                    <small class="text-muted fw-normal">{{ __('HTML tag code or token') }}</small>
                                </label>
                                @php
                                    $gCode = @$seo->data_values->google_verification ?: (@$googleExt->shortcode->verification_code->value !== '------' ? @$googleExt->shortcode->verification_code->value : '');
                                @endphp
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-key-fill text-muted"></i></span>
                                    <input type="text" class="form-control border-start-0" name="google_verification" value="{{ $gCode }}" placeholder="{{ __('e.g. 4vE9_xZ9abcdef12345 or <meta name="google-site-verification" content="..." />') }}">
                                </div>
                                <small class="text-muted d-block mt-1">
                                    {{ __('Paste either the verification code from Google Search Console (HTML tag method) or the entire meta tag. Antigravity auto-extracts the code and injects it into every public page header.') }}
                                </small>
                            </div>

                            {{-- BING SITE VERIFICATION --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark d-flex align-items-center justify-content-between">
                                    <span>
                                        <i class="bi bi-microsoft text-primary me-1"></i>
                                        {{ __('Bing Webmaster Tools Verification Code') }}
                                    </span>
                                    <small class="text-muted fw-normal">{{ __('Optional') }}</small>
                                </label>
                                @php
                                    $bCode = @$seo->data_values->bing_verification ?: (@$bingExt->shortcode->verification_code->value !== '------' ? @$bingExt->shortcode->verification_code->value : '');
                                @endphp
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-key text-muted"></i></span>
                                    <input type="text" class="form-control border-start-0" name="bing_verification" value="{{ $bCode }}" placeholder="{{ __('e.g. 9B8A7C6D5E4F3G2H1 or <meta name="msvalidate.01" content="..." />') }}">
                                </div>
                                <small class="text-muted d-block mt-1">
                                    {{ __('Used by Bing, Yahoo, and DuckDuckGo webmaster tools.') }}
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 2: META TAGS & KEYWORDS --}}
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
                        <div class="card-header bg-white border-bottom py-3">
                            <strong class="text-dark"><i class="bi bi-tags text-primary me-2"></i>{{ __('Primary Search Engine Meta Tags') }}</strong>
                        </div>
                        <div class="card-body p-4">
                            {{-- META KEYWORDS --}}
                            <div class="mb-3 form-group select2-parent position-relative">
                                <label class="form-label fw-bold text-dark">
                                    {{ __('Meta Keywords') }}
                                    <small class="text-muted fw-normal">({{ __('Separate multiple keywords by comma or Enter') }})</small>
                                </label>
                                <select name="keywords[]" class="form-control select2-auto-tokenize" multiple="multiple">
                                    @if (@$seo->data_values->keywords)
                                        @foreach ($seo->data_values->keywords as $option)
                                            <option value="{{ $option }}" selected>{{ __($option) }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            {{-- META DESCRIPTION --}}
                            <div class="mb-3 form-group">
                                <label class="form-label fw-bold text-dark d-flex justify-content-between">
                                    <span>{{ __('Meta Description') }}</span>
                                    <small class="text-muted fw-normal" id="descCounter">{{ __('Recommended: 150-160 characters') }}</small>
                                </label>
                                <textarea name="description" id="metaDescriptionInput" rows="3" class="form-control" placeholder="{{ __('Concise summary of your healthcare digital agency services shown in Google search results...') }}" required>{{ @$seo->data_values->description }}</textarea>
                            </div>

                            <div class="row g-3">
                                {{-- ROBOTS INDEXING --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">{{ __('Robots Indexing Tag') }}</label>
                                    @php $robotsVal = @$seo->data_values->robots_meta ?: 'index, follow'; @endphp
                                    <select name="robots_meta" class="form-select">
                                        <option value="index, follow" {{ $robotsVal == 'index, follow' ? 'selected' : '' }}>{{ __('index, follow (Recommended for Live Site)') }}</option>
                                        <option value="noindex, nofollow" {{ $robotsVal == 'noindex, nofollow' ? 'selected' : '' }}>{{ __('noindex, nofollow (Block All Search Engines)') }}</option>
                                        <option value="index, nofollow" {{ $robotsVal == 'index, nofollow' ? 'selected' : '' }}>{{ __('index, nofollow') }}</option>
                                        <option value="noindex, follow" {{ $robotsVal == 'noindex, follow' ? 'selected' : '' }}>{{ __('noindex, follow') }}</option>
                                    </select>
                                </div>

                                {{-- CANONICAL URL OVERRIDE --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark">
                                        {{ __('Canonical Base URL') }}
                                        <small class="text-muted fw-normal">({{ __('Optional override') }})</small>
                                    </label>
                                    <input type="url" name="canonical_url" class="form-control" value="{{ @$seo->data_values->canonical_url }}" placeholder="{{ url('/') }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- SECTION 3: OPEN GRAPH & SOCIAL PREVIEW --}}
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 14px;">
                        <div class="card-header bg-white border-bottom py-3">
                            <strong class="text-dark"><i class="bi bi-share text-primary me-2"></i>{{ __('Social Media & Open Graph Previews') }}</strong>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-3 form-group">
                                <label class="form-label fw-bold text-dark">{{ __('Social Title (OG / Twitter)') }}</label>
                                <input type="text" class="form-control" name="social_title" value="{{ @$seo->data_values->social_title }}" placeholder="{{ __('3S Medi Care - Healthcare Expertise. Our Digital Growth.') }}" required />
                            </div>

                            <div class="mb-3 form-group">
                                <label class="form-label fw-bold text-dark">{{ __('Social Description (OG / Twitter)') }}</label>
                                <textarea name="social_description" rows="3" class="form-control" placeholder="{{ __('Short engaging summary for Facebook, Twitter, and LinkedIn post previews...') }}" required>{{ @$seo->data_values->social_description }}</textarea>
                            </div>
                        </div>
                    </div>

                    {{-- SUBMIT BUTTON --}}
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-5 py-3 fw-bold shadow-sm" style="font-size: 1rem; border-radius: 10px;">
                            <i class="bi bi-check2-circle me-2"></i>{{ __('Save SEO & Verification Settings') }}
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')
<script>
(function($) {
    "use strict";
    $('.select2-auto-tokenize').each(function() {
        $(this).select2({
            dropdownParent: $(this).closest('.select2-parent'),
            tags: true,
            tokenSeparators: [',']
        });
    });

    const desc = document.getElementById('metaDescriptionInput');
    const counter = document.getElementById('descCounter');
    if (desc && counter) {
        function updateCount() {
            const len = desc.value.length;
            counter.innerText = `${len} characters (Recommended: 150-160)`;
            if (len >= 140 && len <= 165) {
                counter.className = 'text-success fw-bold';
            } else if (len > 165) {
                counter.className = 'text-danger fw-semibold';
            } else {
                counter.className = 'text-muted fw-normal';
            }
        }
        desc.addEventListener('input', updateCount);
        updateCount();
    }
})(jQuery);
</script>
@endpush
