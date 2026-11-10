@php
    $procContent = getContent('process.content', true);
    $procElements = getContent('process.element', false, null, true);
    $values = @$procContent->data_values;
@endphp

<!-- SECTION 06 · HOW WE WORK -->
<section class="section section--tint" id="process">
  <div class="container">
    <div class="reveal">
      <span class="eyebrow">{{ __(@$values->eyebrow ?? 'How We Work') }}</span>
      <h2 class="section-title">{{ __(@$values->title ?? 'A Clear Process From Brief to Launch.') }}</h2>
    </div>
    <div class="row g-4 mt-3">
      @foreach($procElements as $index => $item)
        @php
            $v = $item->data_values;
            $delay = ($index * 0.1) . 's';
        @endphp
        <div class="col-sm-6 col-lg-3 reveal" style="--d:{{ $delay }}">
          <div class="step-card">
            <span class="no">{{ @$v->step_no }}</span>
            <h3>{{ __(@$v->title) }}</h3>
            <p>{{ __(@$v->description) }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

