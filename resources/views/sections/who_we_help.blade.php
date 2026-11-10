@php
    $helpContent = getContent('who_we_help.content', true);
    $helpElements = getContent('who_we_help.element', false, null, true);
    $values = @$helpContent->data_values;
@endphp

<!-- SECTION 03 · WHO WE HELP -->
<section class="section section--tint" id="who-we-help" x-data="{ ready: false }" x-init="ready = true">
  <div class="container">
    <div class="reveal">
      <span class="eyebrow">{{ __(@$values->eyebrow ?? 'Who We Help') }}</span>
      <h2 class="section-title" style="max-width:520px">{{ __(@$values->title ?? 'Digital Support for Every Healthcare Practice.') }}</h2>
    </div>
    <div class="row g-4 mt-3">
      @forelse($helpElements as $index => $item)
        @php
            $itemVal = $item->data_values;
            $img = frontendImage('who_we_help', @$itemVal->thumb ?: @$itemVal->image, 'assets/images/3s/who-doctors.jpg');
            $delay = ($index * 0.1) . 's';
        @endphp
        <div class="col-sm-6 col-lg-3 reveal" style="--d:{{ $delay }}">
          <article class="help-card">
            <div class="thumb position-relative overflow-hidden">
              <div class="shimmer position-absolute top-0 start-0 w-100 h-100" x-show="!ready"></div>
              <img src="{{ $img }}" alt="{{ __(@$itemVal->title) }}" loading="lazy">
            </div>
            <div class="body">
              <h3>{{ __(@$itemVal->title) }}</h3>
              <p>{{ __(@$itemVal->description) }}</p>
              <a href="{{ url(@$itemVal->link_url ?? 'services') }}" class="link-arrow">{{ __(@$itemVal->link_text ?? 'Explore Services') }} <i class="bi bi-arrow-right"></i></a>
            </div>
          </article>
        </div>
      @empty
      @endforelse
    </div>
  </div>
</section>

