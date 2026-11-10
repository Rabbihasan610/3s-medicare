@php
    $mapContent = getContent('contact_map.content', true);
    $values = @$mapContent->data_values;
@endphp

<!-- CONTACT · 03 MAP -->
<section class="section pt-0">
  <div class="container reveal reveal--zoom">
    @if(!empty(@$values->embed_code))
      <div class="map-responsive rounded-3 overflow-hidden shadow-sm" style="min-height: 380px;">
        {!! $values->embed_code !!}
      </div>
    @else
      <div class="map-block">
        <div>
          <div class="pin"><i class="bi bi-geo-alt-fill"></i></div>
          <strong class="text-white d-block">{{ __(@$values->location_name ?? '3S Medi Care Headquarters') }}</strong>
          <span class="small">{{ __(@$values->map_note ?? 'Medical Arts Plaza, Suite 400') }}</span>
        </div>
      </div>
    @endif
  </div>
</section>

