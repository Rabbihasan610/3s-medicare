@php
    $workContent = getContent('our_work.content', true);
    $values = @$workContent->data_values;
    $project = App\Models\Project::featured()->first();
    $img = $project && $project->thumbnail ? asset($project->thumbnail) : (@$values->showcase_image ? asset($values->showcase_image) : asset('assets/images/3s/work-showcase.jpg'));
@endphp

<!-- SECTION 07 · OUR WORK -->
<section class="section" id="our-work" x-data="{ ready: false }" x-init="ready = true">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-6 reveal reveal--left">
        <span class="eyebrow">{{ __(@$values->eyebrow ?? 'Our Work') }}</span>
        <h2 class="section-title">{{ __(@$values->title ?? 'Digital Work Designed Around Healthcare Needs.') }}</h2>
        @if($project)
          <p class="text-secondary mt-2">{{ $project->summary }}</p>
        @endif
        <a href="{{ url(@$values->btn_url ?? 'services') }}" class="btn-3s btn-3s--blue mt-3">{{ __(@$values->btn_text ?? 'View Case Studies') }} <i class="bi bi-arrow-up-right"></i></a>
      </div>
      <div class="col-lg-6 reveal reveal--right" style="--d:.15s">
        <div class="work-media position-relative overflow-hidden">
          <div class="shimmer position-absolute top-0 start-0 w-100 h-100" x-show="!ready"></div>
          <img src="{{ $img }}" alt="{{ $project->title ?? 'Healthcare Project' }}" loading="lazy">
        </div>
      </div>
    </div>
  </div>
</section>

