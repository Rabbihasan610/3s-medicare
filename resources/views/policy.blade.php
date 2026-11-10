@extends('web.layouts.medicare', ['title' => @$title ?? __('Privacy Policy')])

@section('content')
<!-- POLICY PAGE BANNER -->
<section class="page-banner" style="background: radial-gradient(1200px 480px at 85% 0%, rgba(25, 181, 165, 0.20), transparent 65%), #081C36; padding-top: 3.5rem; padding-bottom: 5.5rem; position: relative;">
  <div class="container position-relative z-1">
    <nav aria-label="breadcrumb" class="mb-3">
      <ol class="breadcrumb mb-0" style="font-size: 0.85rem;">
        <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50 text-decoration-none"><i class="bi bi-house-door me-1"></i>{{ __('Home') }}</a></li>
        <li class="breadcrumb-item active text-white" aria-current="page">{{ __(@$title ?? 'Privacy Policy') }}</li>
      </ol>
    </nav>
    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 rounded-pill mb-3 border border-white border-opacity-15 shadow-sm" style="background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(8px);">
      <span class="rounded-circle" style="width: 8px; height: 8px; background: #19b5a5; display: inline-block;"></span>
      <span class="text-white fw-semibold" style="font-size: 0.78rem; letter-spacing: 0.08em; text-transform: uppercase;">
        {{ __('Legal & Healthcare Compliance') }}
      </span>
    </div>
    <h1 class="display-6 fw-bold text-white mb-2" style="letter-spacing: -0.02em;">
      {{ __(@$title ?? 'Privacy Policy') }}
    </h1>
    <p class="text-white-50 mb-0" style="max-width: 620px; font-size: 0.95rem;">
      {{ __('Transparency and patient confidentiality standards governing 3S Medi Care digital services.') }}
    </p>
  </div>
</section>

<!-- POLICY CONTENT SECTION (FLOATING CARD) -->
<section class="section py-0" style="margin-top: -3.5rem; padding-bottom: 5rem; position: relative; z-index: 10;">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card border border-light-subtle shadow-lg p-4 p-md-5" style="border-radius: 20px; background: #ffffff;">
          <div class="policy-body" style="font-size: 0.95rem; line-height: 1.7; color: var(--c-ink-700, #33475b);">
            {!! @$policy->data_values->details ?? $policy->lang('details') !!}
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
