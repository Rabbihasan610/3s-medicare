{{--
    Reusable page hero banner.
    Props:
      $heroTitle       (string)  – main heading
      $heroBreadcrumb  (array)   – [['label' => 'Home', 'url' => '/'], ['label' => 'Current Page']]
      $heroSubtitle    (string)  – optional small text below heading
      $heroDark        (bool)    – if true, uses dark purple bg
--}}

@php
    $heroDark     = $heroDark     ?? false;
    $heroSubtitle = $heroSubtitle ?? null;
    $heroBreadcrumb = $heroBreadcrumb ?? [
        ['label' => __('Home'), 'url' => url('/')],
        ['label' => $heroTitle ?? ''],
    ];
@endphp

<section class="relative overflow-hidden {{ $heroDark ? 'bg-gradient-to-br from-slate-900 via-[#1a0d2e] to-slate-900' : 'bg-gradient-to-br from-[#f0ebff] via-[#eef0ff] to-[#e8f4ff]' }} py-14 md:py-20">

    {{-- Decorative blobs --}}
    <div class="pointer-events-none absolute inset-0 overflow-hidden">
        <div class="absolute -start-20 -top-20 h-72 w-72 rounded-full {{ $heroDark ? 'bg-violet/10' : 'bg-violet/8' }} blur-3xl"></div>
        <div class="absolute -bottom-16 -end-16 h-64 w-64 rounded-full {{ $heroDark ? 'bg-gold/10' : 'bg-gold/10' }} blur-3xl"></div>
    </div>

    <div class="relative mx-auto max-w-7xl px-6 text-center lg:px-10">

        {{-- Breadcrumb --}}
        <nav aria-label="{{ __('Breadcrumb') }}" class="mb-5 flex items-center justify-center gap-2 text-xs font-medium {{ $heroDark ? 'text-white/50' : 'text-slate-400' }}">
            @foreach ($heroBreadcrumb as $index => $crumb)
                @if ($index > 0)
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                @endif

                @if (!empty($crumb['url']) && $index < count($heroBreadcrumb) - 1)
                    <a href="{{ $crumb['url'] }}" class="transition-colors hover:{{ $heroDark ? 'text-white' : 'text-violet' }}">
                        {{ $crumb['label'] }}
                    </a>
                @else
                    <span class="{{ $heroDark ? 'text-white/80' : 'text-slate-600' }} font-semibold">
                        {{ $crumb['label'] }}
                    </span>
                @endif
            @endforeach
        </nav>

        {{-- Title --}}
        <h1 class="text-4xl font-extrabold tracking-tight {{ $heroDark ? 'text-white' : 'text-slate-900' }} md:text-5xl lg:text-6xl">
            {{ $heroTitle ?? '' }}
        </h1>

        {{-- Divider --}}
        <div class="mx-auto mt-5 h-1 w-20 rounded-full bg-gradient-to-r from-violet to-gold"></div>

        {{-- Subtitle --}}
        @if ($heroSubtitle)
            <div class="mx-auto mt-5 max-w-3xl text-sm leading-7 {{ $heroDark ? 'text-white/70' : 'text-slate-500' }} md:text-base space-y-2">
                {!! nl2br(e($heroSubtitle)) !!}
            </div>
        @endif
    </div>
</section>
