@php
    $aboutHero = getContent('about_hero.content', true);
    $values = @$aboutHero->data_values;
    $img = frontendImage('about_hero', @$values->image, 'assets/images/3s/about-hero.jpg');
@endphp

<!-- ABOUT · 01 HERO -->
<section class="inner-hero" id="about" x-data="{ ready: false }" x-init="ready = true">
  <div class="container">
    <div class="row align-items-center gy-5">
      <div class="col-lg-6 reveal reveal--left">
        <span class="eyebrow">{{ __(@$values->eyebrow ?? 'About Us') }}</span>
        <h1>{{ __(@$values->heading ?? 'A Digital Agency Focused on Healthcare.') }}</h1>
        <p class="hero-text">{{ __(@$values->description ?? 'We create professional, responsive websites that help doctors, clinics, hospitals, and diagnostic centers communicate their services clearly and provide visitors with an easy-to-use online experience.') }}</p>
        <div class="hero-actions">
          <a href="{{ url(@$values->btn_1_url ?? 'contact') }}" class="btn-3s btn-3s--primary">{{ __(@$values->btn_1_text ?? 'Discuss Your Website') }} <i class="bi bi-arrow-up-right"></i></a>
          <a href="{{ url(@$values->btn_2_url ?? 'services') }}" class="btn-3s btn-3s--outline">{{ __(@$values->btn_2_text ?? 'Explore Our Services') }} <i class="bi bi-arrow-up-right"></i></a>
        </div>
      </div>
      <div class="col-lg-6 reveal reveal--right" style="--d:.15s">
        <div class="hero-visual position-relative overflow-hidden">
          <div class="shimmer position-absolute top-0 start-0 w-100 h-100" x-show="!ready"></div>
          <img src="{{ $img }}" alt="{{ __(@$values->heading) }}" width="667" height="444">
        </div>
      </div>
    </div>
  </div>
</section>

