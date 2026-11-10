@php
    $serviceGroups = App\Models\HealthcareService::active()->get()->groupBy('group_name');
@endphp

<!-- SERVICES · 02 SERVICE GROUPS -->
@foreach($serviceGroups as $groupName => $services)
  @php
      $groupSlug = \Illuminate\Support\Str::slug($groupName);
      $firstSvc = $services->first();
  @endphp
  <section class="svc-light" id="{{ $groupSlug }}">
    <div class="container">
      <div class="row g-4 g-lg-5">
        <div class="col-lg-4 reveal">
          <div class="group-head">
            <h2>{{ __($groupName) }}</h2>
            <p>{{ __($firstSvc->short_description ?? '') }}</p>
          </div>
        </div>
        <div class="col-lg-8">
          @foreach($services as $index => $svc)
            @php $delay = ($index * 0.08) . 's'; @endphp
            <a class="svc-item reveal" id="{{ $svc->slug }}" href="{{ url('get-quote?service=' . urlencode($svc->title)) }}" style="--d:{{ $delay }}">
              <span class="ico"><i class="bi {{ $svc->icon }}"></i></span>
              <div>
                <h3>{{ __($svc->title) }}</h3>
                <p>{{ __($svc->short_description) }}</p>
              </div>
              <span class="link-arrow">{{ __('Get a Quote') }} <i class="bi bi-arrow-up-right"></i></span>
            </a>
          @endforeach
        </div>
      </div>
    </div>
  </section>
@endforeach

