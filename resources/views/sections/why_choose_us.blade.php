@php
    $whyContent = getContent('why_choose_us.content', true);
    $whyElements = getContent('why_choose_us.element', false, null, true);
    $values = @$whyContent->data_values;
    $img = frontendImage('why_choose_us', @$values->image, 'assets/images/3s/why-team.jpg');
@endphp

<!-- SECTION 05 · WHY CHOOSE US -->
<section class="section" id="why-us" x-data="{ ready: false }" x-init="ready = true">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6 reveal reveal--left">
        <div class="why-media position-relative overflow-hidden">
          <div class="shimmer position-absolute top-0 start-0 w-100 h-100" x-show="!ready"></div>
          <img src="{{ $img }}" alt="{{ __(@$values->title) }}" loading="lazy">
        </div>
      </div>
      <div class="col-lg-6 reveal reveal--right" style="--d:.15s">
        <span class="eyebrow">{{ __(@$values->eyebrow ?? 'Why Choose Us') }}</span>
        <h2 class="section-title">{{ __(@$values->title ?? 'Healthcare Expertise. Digital Solutions That Work for Your Practice.') }}</h2>
        <ul class="why-list">
          @foreach($whyElements as $item)
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

