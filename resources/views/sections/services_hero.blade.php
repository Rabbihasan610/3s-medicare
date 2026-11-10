@php
    $svcHero = getContent('services_hero.content', true);
    $values = @$svcHero->data_values;
    $img = @$values->image ? asset($values->image) : asset('assets/images/3s/services-hero.jpg');
@endphp

<!-- SERVICES · 01 HERO -->
<section class="inner-hero" id="services-hero" x-data="{ ready: false }" x-init="ready = true">
  <div class="container">
    <div class="row align-items-center gy-5">
      <div class="col-lg-6 reveal reveal--left">
        <span class="eyebrow">{{ __(@$values->eyebrow ?? 'Our Services') }}</span>
        <h1>{{ __(@$values->heading ?? 'Digital Solutions Built for Better Healthcare Growth.') }}</h1>
        <p class="hero-text">{{ __(@$values->description ?? 'From healthcare websites and search visibility to digital marketing and patient-focused digital services, we help healthcare providers build a stronger digital presence.') }}</p>
        <div class="hero-actions">
          <a href="{{ url(@$values->btn_1_url ?? '#digital-presence') }}" class="btn-3s btn-3s--primary">{{ __(@$values->btn_1_text ?? 'Explore Our Services') }} <i class="bi bi-arrow-up-right"></i></a>
          <a href="{{ url(@$values->btn_2_url ?? 'get-quote') }}" class="btn-3s btn-3s--outline">{{ __(@$values->btn_2_text ?? 'Get a Quote') }} <i class="bi bi-arrow-up-right"></i></a>
        </div>
      </div>
      <div class="col-lg-6 reveal reveal--right" style="--d:.15s">
        <div class="hero-visual position-relative overflow-hidden">
          <div class="shimmer position-absolute top-0 start-0 w-100 h-100" x-show="!ready"></div>
          <img src="{{ $img }}" alt="{{ __(@$values->heading) }}" width="665" height="405">
        </div>
      </div>
    </div>
  </div>
</section>

