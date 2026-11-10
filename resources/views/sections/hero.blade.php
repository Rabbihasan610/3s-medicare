@php
    $heroContent = getContent('hero.content', true);
    $heroValues = @$heroContent->data_values;
    $heroTags = array_filter(array_map('trim', explode(',', @$heroValues->hero_tags ?? 'Doctors, Hospitals, Clinics, Diagnostic Centers')));
    $heroImg = @$heroValues->hero_image ? asset($heroValues->hero_image) : asset('assets/images/3s/hero-doctor.jpg');
@endphp

<!-- SECTION 01 · HERO -->
<section class="hero" id="home" x-data="{ loaded: false }" x-init="loaded = true">
  <div class="container">
    <div class="row align-items-center gy-5">
      <div class="col-lg-6 reveal reveal--left">
        <span class="eyebrow">{{ __(@$heroValues->eyebrow ?? 'Your Healthcare Digital Partner') }}</span>
        <h1>{{ __(@$heroValues->heading ?? 'Your Healthcare Expertise.') }}<br><span class="text-accent">{{ __(@$heroValues->heading_accent ?? 'Our Digital Growth.') }}</span></h1>
        <p class="hero-text">{{ __(@$heroValues->subheading ?? 'Websites, Branding, SEO and Digital Marketing for doctor, clinics, Hospitals and Diagnostic centers.') }}</p>
        <div class="hero-actions">
          <a href="{{ url(@$heroValues->btn_1_url ?? 'get-quote') }}" class="btn-3s btn-3s--primary rounded-0">{{ __(@$heroValues->btn_1_text ?? 'Get a Quote') }} <i class="bi bi-arrow-up-right"></i></a>
          <a href="{{ url(@$heroValues->btn_2_url ?? '#services') }}" class="btn-3s btn-3s--outline rounded-0">{{ __(@$heroValues->btn_2_text ?? 'View Our Work') }} <i class="bi bi-arrow-up-right"></i></a>
        </div>
        <ul class="hero-tags">
          @foreach($heroTags as $tag)
            <li>{{ __($tag) }}</li>
          @endforeach
        </ul>
      </div>
      <div class="col-lg-6 reveal reveal--right" style="--d:.15s">
        <div class="hero-media position-relative overflow-hidden">
          {{-- Shimmer skeleton placeholder until image loads --}}
          <div class="shimmer position-absolute top-0 start-0 w-100 h-100" x-show="!loaded" style="border-radius: var(--radius-md);"></div>
          <img src="{{ $heroImg }}" alt="{{ gs('site_name') }}" width="656" height="391" @load="loaded = true" :class="{ 'opacity-100': loaded, 'opacity-0': !loaded }" style="transition: opacity 0.4s ease;">
        </div>
      </div>
    </div>
  </div>
</section>

