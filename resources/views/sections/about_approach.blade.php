@php
    $apprContent = getContent('about_approach.content', true);
    $apprElements = getContent('about_approach.element', false, null, true);
    $values = @$apprContent->data_values;
    $img = @$values->image ? asset($values->image) : asset('assets/images/3s/why-team.jpg');
@endphp

<!-- ABOUT · 02 OUR APPROACH -->
<section class="section about-approach" id="approach" x-data="{ ready: false }" x-init="ready = true">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6 reveal reveal--left">
        <div class="why-media position-relative overflow-hidden">
          <div class="shimmer position-absolute top-0 start-0 w-100 h-100" x-show="!ready"></div>
          <img src="{{ $img }}" alt="{{ __(@$values->title) }}" loading="lazy">
        </div>
      </div>
      <div class="col-lg-6 reveal reveal--right" style="--d:.15s">
        <span class="eyebrow">{{ __(@$values->eyebrow ?? 'Our Approach') }}</span>
        <h2 class="section-title">{{ __(@$values->title ?? 'Healthcare-focused, from website to patient access') }}</h2>
        <ul class="why-list">
          @foreach($apprElements as $item)
            @php $v = $item->data_values; @endphp
            <li>
              <strong>{{ __(@$v->title) }}</strong>
              <span>{{ __(@$v->description) }}</span>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
</section>

