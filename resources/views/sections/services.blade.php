@php
    $svcContent = getContent('services.content', true);
    $values = @$svcContent->data_values;
    $serviceGroups = App\Models\HealthcareService::active()->get()->groupBy('group_name');
@endphp

<!-- SECTION 04 · OUR SERVICES -->
<section class="section section--dark" id="services" x-data="{ currentGroup: 'all' }">
  <div class="container">
    <div class="reveal">
      <span class="eyebrow">{{ __(@$values->eyebrow ?? 'Our Services') }}</span>
      <h2 class="section-title" style="max-width:520px">{{ __(@$values->title ?? 'Everything Your Healthcare Business Needs to Grow Online.') }}</h2>
      <p class="section-lead">{{ __(@$values->lead ?? 'Three connected service groups make it easier to identify the right starting point.') }}</p>
    </div>

    <div class="mt-5">
      @php $groupIndex = 1; @endphp
      @foreach($serviceGroups as $groupName => $services)
        <div class="svc-group reveal">
          <div>
            <div class="group-no">Group 0{{ $groupIndex++ }}</div>
            <h3>{{ __($groupName) }}</h3>
          </div>
          <ul class="svc-list">
            @foreach($services as $svc)
              <li class="list-unstyled">
                <a href="{{ url('services#' . $svc->slug) }}" class="svc-row text-reset text-decoration-none">
                  <strong>{{ __($svc->title) }}</strong>
                  <span>{{ __($svc->short_description) }}</span>
                  <i class="bi bi-arrow-right"></i>
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      @endforeach
    </div>
  </div>
</section>

