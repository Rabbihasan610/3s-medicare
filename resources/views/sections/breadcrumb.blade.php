@props(['title' => ''])

<!-- BREADCRUMB -->
<section class="page-banner py-4">
  <div class="container reveal">
    <ul class="breadcrumb-3s mb-2">
      <li><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
      <li>{{ __($title) }}</li>
    </ul>
    <h1 class="h2 mb-0">{{ __($title) }}</h1>
  </div>
</section>

