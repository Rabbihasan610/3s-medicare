@php
    $bannerContent = getContent('contact_banner.content', true);
    $values = @$bannerContent->data_values;
@endphp

<!-- CONTACT · 01 PAGE BANNER -->
<section class="page-banner">
  <div class="container reveal">
    <ul class="breadcrumb-3s">
      <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
      <li>{{ __('Contact Us') }}</li>
    </ul>
    <span class="eyebrow">{{ __(@$values->eyebrow ?? 'Contact Us') }}</span>
    <h1>{{ __(@$values->heading ?? 'Tell Us About Your Practice.') }}</h1>
    <p>{{ __(@$values->subheading ?? 'Share the digital services you need and our team will get back to you with the next steps.') }}</p>
  </div>
</section>

