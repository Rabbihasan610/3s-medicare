@php
    $impactContent = getContent('digital_impact.content', true);
    $impactElements = getContent('digital_impact.element', false, null, true);
    $values = @$impactContent->data_values;
@endphp

<!-- SECTION 02 · DIGITAL IMPACT -->
<section class="section" id="impact" x-data="{ ready: false }" x-init="ready = true">
  <div class="container">
    <div class="reveal">
      <span class="eyebrow">{{ __(@$values->eyebrow ?? 'Digital Impact') }}</span>
      <h2 class="section-title" style="max-width:640px">{{ __(@$values->title ?? 'Build a Stronger Digital Presence for Your Healthcare Business.') }}</h2>
      <p class="section-lead">{{ __(@$values->lead ?? 'From professional websites and online visibility to patient-focused digital services, we help healthcare businesses create better digital experiences.') }}</p>
    </div>
    <div class="row g-4 mt-3">
      @forelse($impactElements as $index => $item)
        @php
            $itemVal = $item->data_values;
            $chips = array_filter(array_map('trim', explode(',', @$itemVal->tags ?? '')));
            $img = @$itemVal->thumb ? asset($itemVal->thumb) : asset('assets/images/3s/card-be-found.jpg');
            $delay = ($index * 0.12) . 's';
        @endphp
        <div class="col-md-6 col-lg-4 reveal" style="--d:{{ $delay }}">
          <article class="impact-card">
            <div class="thumb position-relative overflow-hidden">
              <div class="shimmer position-absolute top-0 start-0 w-100 h-100" x-show="!ready"></div>
              <img src="{{ $img }}" alt="{{ __(@$itemVal->title) }}" loading="lazy">
            </div>
            <h3>{{ __(@$itemVal->title) }}</h3>
            <p>{{ __(@$itemVal->description) }}</p>
            @foreach($chips as $chip)
              <span class="chip">{{ __($chip) }}</span>
            @endforeach
          </article>
        </div>
      @empty
      @endforelse
    </div>
  </div>
</section>

