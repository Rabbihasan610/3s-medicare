@php
	use App\Constants\Status;

	$currentLocale = session('lang', app()->getLocale());
	$localePrefix = substr((string) $currentLocale, 0, 2);
	$isRtl = in_array($localePrefix, ['fa', 'ur', 'he'], true);

	$currentRoute = request()->route()?->getName() ?? '';
	$isServicesActive = str_starts_with($currentRoute, 'strategic')
		|| str_starts_with($currentRoute, 'technology')
		|| str_starts_with($currentRoute, 'ai')
		|| str_starts_with($currentRoute, 'hr')
		|| str_starts_with($currentRoute, 'industry')
		|| str_starts_with($currentRoute, 'logistics')
		|| str_starts_with($currentRoute, 'international')
		|| str_starts_with($currentRoute, 'media')
		|| str_starts_with($currentRoute, 'scientific')
		|| str_starts_with($currentRoute, 'real')
		|| str_starts_with($currentRoute, 'entrepreneurship')
		|| str_starts_with($currentRoute, 'tenders')
		|| str_starts_with($currentRoute, 'investments');
@endphp

@push('style')
	<style>
		#mobileOverlay,
		#mobileMenu {
			position: fixed;
			top: 0;
			will-change: transform, opacity;
			backface-visibility: hidden;
			-webkit-backface-visibility: hidden;
			transform-style: preserve-3d;
		}

		#mobileOverlay { inset: 0; }

		#mobileMenu {
			height: 100vh;
			overflow-y: auto;
			isolation: isolate;
		}

		html.menu-open,
		body.menu-open {
			overflow: hidden;
			touch-action: none;
		}

		#desktopServicesMenu {
			max-height: min(390px, calc(100vh - 120px)) !important;
			overflow-y: auto !important;
			overflow-x: hidden !important;
			scrollbar-width: thin !important;
			scrollbar-color: #6D47FF #f1f5f9 !important;
		}

		#desktopServicesMenu::-webkit-scrollbar {
			width: 6px !important;
			display: block !important;
		}

		#desktopServicesMenu::-webkit-scrollbar-track {
			background: #f1f5f9 !important;
			border-radius: 9999px !important;
		}

		#desktopServicesMenu::-webkit-scrollbar-thumb {
			background: #6D47FF !important;
			border-radius: 9999px !important;
		}

		#desktopServicesMenu::-webkit-scrollbar-thumb:hover {
			background: #4E2DCA !important;
		}
	</style>
@endpush

{{-- Top bar --}}
<div class="w-full" style="background: linear-gradient(135deg, #5a0088 0%, #3b0055 100%);">
	<div class="mx-auto flex h-[32px] max-w-7xl items-center justify-between px-6 py-2 {{ $isRtl ? 'flex-row-reverse' : '' }}">
		<div class="text-xs font-medium text-white/80">
			{{ __('Welcome') }}
		</div>

		<div class="flex items-center gap-2 py-1">
			@if (gs('multi_language'))
				@php
					$language = App\Models\Language::all();
					$currentLang = session('lang')
					    ? $language->where('code', session('lang'))->first()
					    : $language->where('is_default', Status::YES)->first();
				@endphp

				<div class="relative">
					<span class="pointer-events-none absolute inset-y-0 {{ $isRtl ? 'right-2' : 'left-2' }} flex items-center text-white/80">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9 9 0 1 0 0-18m0 18c2.4 0 4.5-4 4.5-9S14.4 3 12 3m0 18c-2.4 0-4.5-4-4.5-9S9.6 3 12 3m-8.5 9h17" />
						</svg>
					</span>

					<select
						{{-- ps-/pe- already follow the text direction, so no rtl branch is needed here.
							The old branch mixed pr-7 with ps-8, which both resolve to padding-right in rtl. --}}
						class="h-7 appearance-none rounded-full border border-white/30 bg-white/10 ps-7 pe-8 text-xs font-semibold text-white outline-none transition hover:bg-white/20 focus:border-white/60 focus:bg-white/20 focus:ring-2 focus:ring-white/20"
						aria-label="{{ __('Select language') }}"
						onchange="window.location.href={{ json_encode(url('/change')) }} + '/' + this.value">
						@foreach ($language as $lang)
							<option class="text-slate-800" value="{{ $lang->code }}"
								{{ optional($currentLang)->code == $lang->code ? 'selected' : '' }}>
								{{ __($lang->name) }}
							</option>
						@endforeach
					</select>

					<span class="pointer-events-none absolute inset-y-0 {{ $isRtl ? 'left-2' : 'right-2' }} flex items-center text-white/70">
						<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
							<path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.13l3.71-3.9a.75.75 0 1 1 1.08 1.04l-4.25 4.46a.75.75 0 0 1-1.08 0L5.21 8.27a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
						</svg>
					</span>
				</div>
			@endif
		</div>
	</div>
</div>

{{-- Main nav --}}
<header class="sticky top-0 z-50 border-b border-slate-100/80 bg-white/95 text-black backdrop-blur-md shadow-sm">
	<div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-3.5 lg:px-10 {{ $isRtl ? 'flex-row-reverse' : '' }}">

		{{-- Logo --}}
		<a href="{{ url('/') }}" class="flex-shrink-0">
			<img src="{{ asset('assets/images/logoIcon/logo.png') }}" alt="{{ gs()->site_name }}"
				class="h-14 w-auto" />
		</a>

		{{-- Desktop nav --}}
		<nav class="hidden items-center gap-1 text-sm text-slate-700 md:flex {{ $isRtl ? 'flex-row-reverse' : '' }}">

			@php
				$navItem = 'rounded-lg px-3 py-2 font-medium transition-colors duration-200 hover:bg-violet/5 hover:text-violet';
				$navActive = 'rounded-lg px-3 py-2 font-semibold text-violet bg-violet/5';
			@endphp

			<a class="{{ $currentRoute === 'home' ? $navActive : $navItem }}" href="{{ route('home') }}">{{ __('Home') }}</a>
			@if(\Illuminate\Support\Facades\Route::has('about'))
			<a class="{{ $currentRoute === 'about' ? $navActive : $navItem }}" href="{{ route('about') }}">{{ __('About Us') }}</a>
			@endif

			@php
				$serviceLinks = [
					['route' => 'strategic.procurement', 'icon' => 'fa-boxes-stacked',    'label' => 'Strategic Procurement'],
					['route' => 'solutions',             'icon' => 'fa-helmet-safety',     'label' => 'Engineering Solutions'],
					['route' => 'investments',           'icon' => 'fa-chart-line',         'label' => 'Investment & BOT Model'],
					['route' => 'technology.digital',    'icon' => 'fa-laptop-code',       'label' => 'Technology & Digital'],
					['route' => 'ai.index',              'icon' => 'fa-robot',              'label' => 'Artificial Intelligence'],
					['route' => 'hr.training',           'icon' => 'fa-people-group',       'label' => 'HR Training'],
					['route' => 'industry.operations',   'icon' => 'fa-industry',           'label' => 'Industry Operations'],
					['route' => 'logistics.customs',     'icon' => 'fa-truck-fast',         'label' => 'Logistics & Customs'],
					['route' => 'international.trade',   'icon' => 'fa-earth-americas',     'label' => 'International Trade'],
					['route' => 'media.events',          'icon' => 'fa-clapperboard',       'label' => 'Media & Events'],
					['route' => 'scientific.research',   'icon' => 'fa-flask',              'label' => 'Scientific Research'],
					['route' => 'real.Estate',           'icon' => 'fa-building-columns',   'label' => 'Real Estate'],
					['route' => 'entrepreneurship',      'icon' => 'fa-lightbulb',          'label' => 'Entrepreneurship'],
					['route' => 'tenders.opportunities', 'icon' => 'fa-file-contract',      'label' => 'Tenders'],
				];
				$activeServiceLinks = array_filter($serviceLinks, fn($l) => \Illuminate\Support\Facades\Route::has($l['route']));
			@endphp

			@if(!empty($activeServiceLinks))
			{{-- Services dropdown --}}
			<div class="relative" id="desktopServicesDropdown">
				<button type="button" id="desktopServicesBtn"
					class="{{ $isServicesActive ? $navActive : $navItem }} flex items-center gap-1"
					aria-expanded="false" aria-controls="desktopServicesMenu">
					{{ __('Our Services') }}
					<svg id="desktopServicesIcon" xmlns="http://www.w3.org/2000/svg"
						class="h-4 w-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
					</svg>
				</button>

				<div id="desktopServicesMenu"
					style="max-height: min(390px, calc(100vh - 120px)) !important; overflow-y: auto !important; overflow-x: hidden !important;"
					class="absolute {{ $isRtl ? 'right-0' : 'left-0' }} top-full z-50 mt-2 w-72 rounded-2xl border border-slate-100 bg-white py-2 shadow-xl opacity-0 invisible translate-y-2 pointer-events-none transition-all duration-200 ease-out">

					@foreach ($activeServiceLinks as $link)
						<a href="{{ route($link['route']) }}"
							class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-700 transition-colors duration-150 hover:bg-violet/5 hover:text-violet">
							<span class="flex h-7 w-7 flex-shrink-0 items-center justify-center rounded-lg bg-violet/8 text-violet">
								<i class="fa-solid {{ $link['icon'] }} text-xs"></i>
							</span>
							{{ __($link['label']) }}
						</a>
					@endforeach
				</div>
			</div>
			@endif

			@if(\Illuminate\Support\Facades\Route::has('sectors'))
			<a class="{{ $currentRoute === 'sectors' ? $navActive : $navItem }}" href="{{ route('sectors') }}">{{ __('Sectors') }}</a>
			@endif
			@if(\Illuminate\Support\Facades\Route::has('register.supplier'))
			<a class="{{ $currentRoute === 'register.supplier' ? $navActive : $navItem }}" href="{{ route('register.supplier') }}">{{ __('Supplier Registration') }}</a>
			@endif
			@if(\Illuminate\Support\Facades\Route::has('contact'))
			<a class="{{ $currentRoute === 'contact' ? $navActive : $navItem }}" href="{{ route('contact') }}">{{ __('Contact Us') }}</a>
			@endif
		</nav>

		{{-- Mobile menu button --}}
		<div class="flex items-center gap-3 {{ $isRtl ? 'flex-row-reverse' : '' }}">
			<button id="menuBtn" type="button" aria-label="{{ __('Open menu') }}" aria-expanded="false"
				aria-controls="mobileMenu"
				class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 text-slate-700 transition-colors duration-200 hover:border-violet/30 hover:bg-violet/5 hover:text-violet md:hidden">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
					<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
				</svg>
			</button>
		</div>
	</div>

	{{-- Mobile overlay --}}
	<div id="mobileOverlay"
		class="pointer-events-none fixed inset-0 z-[60] bg-black/40 opacity-0 transition duration-300 md:hidden">
	</div>

	{{-- Mobile slide-in menu --}}
	<aside id="mobileMenu" style="visibility: hidden;"
		data-hidden-class="{{ $isRtl ? '-translate-x-full' : 'translate-x-full' }}"
		class="fixed top-0 z-[70] h-full w-[300px] bg-white shadow-2xl transition-transform duration-300 md:hidden {{ $isRtl ? 'left-0 -translate-x-full' : 'right-0 translate-x-full' }}"
		aria-hidden="true">

		<div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 {{ $isRtl ? 'flex-row-reverse' : '' }}">
			<img src="{{ asset('assets/images/logoIcon/logo.png') }}" class="h-10 w-auto" alt="{{ gs()->site_name }}" />

			<button id="closeMenu" type="button" aria-label="{{ __('Close menu') }}"
				class="inline-flex h-10 w-10 items-center justify-center rounded-lg border border-slate-200 text-slate-700 hover:border-violet/30 hover:text-violet transition-colors">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
					<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
				</svg>
			</button>
		</div>

		<nav class="flex flex-col px-4 py-5 text-[15px] font-medium text-slate-700 {{ $isRtl ? 'text-right' : 'text-left' }}">
			<a class="rounded-xl px-3 py-2.5 transition-colors hover:bg-violet/5 hover:text-violet {{ $currentRoute === 'home' ? 'text-violet bg-violet/5' : '' }}"
				href="{{ route('home') }}">{{ __('Home') }}</a>
			@if(\Illuminate\Support\Facades\Route::has('about'))
			<a class="rounded-xl px-3 py-2.5 transition-colors hover:bg-violet/5 hover:text-violet {{ $currentRoute === 'about' ? 'text-violet bg-violet/5' : '' }}"
				href="{{ route('about') }}">{{ __('About Us') }}</a>
			@endif

			@if(!empty($activeServiceLinks))
			<div class="mt-1">
				<button type="button" id="mobileServicesBtn"
					class="flex w-full items-center justify-between rounded-xl px-3 py-2.5 transition-colors hover:bg-violet/5 hover:text-violet {{ $isServicesActive ? 'text-violet bg-violet/5' : '' }}"
					aria-expanded="false" aria-controls="mobileServicesMenu">
					<span>{{ __('Services') }}</span>
					<svg id="mobileServicesIcon" xmlns="http://www.w3.org/2000/svg"
						class="h-4 w-4 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
					</svg>
				</button>

				<div id="mobileServicesMenu"
					class="{{ $isRtl ? 'pr-3' : 'pl-3' }} max-h-0 overflow-hidden transition-all duration-300 ease-out">
					<div class="mt-1 space-y-0.5 rounded-xl bg-slate-50 p-2">
						@foreach ($activeServiceLinks as $link)
							<a href="{{ route($link['route']) }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm hover:bg-white hover:text-violet">
								<i class="fa-solid {{ $link['icon'] }} w-4 text-xs text-violet/60"></i>{{ __($link['label']) }}
							</a>
						@endforeach
					</div>
				</div>
			</div>
			@endif

			@if(\Illuminate\Support\Facades\Route::has('sectors'))
			<a class="rounded-xl px-3 py-2.5 transition-colors hover:bg-violet/5 hover:text-violet {{ $currentRoute === 'sectors' ? 'text-violet bg-violet/5' : '' }}"
				href="{{ route('sectors') }}">{{ __('Sectors') }}</a>
			@endif
			@if(\Illuminate\Support\Facades\Route::has('register.supplier'))
			<a class="rounded-xl px-3 py-2.5 transition-colors hover:bg-violet/5 hover:text-violet {{ $currentRoute === 'register.supplier' ? 'text-violet bg-violet/5' : '' }}"
				href="{{ route('register.supplier') }}">{{ __('Supplier Registration') }}</a>
			@endif
			@if(\Illuminate\Support\Facades\Route::has('contact'))
			<a class="rounded-xl px-3 py-2.5 transition-colors hover:bg-violet/5 hover:text-violet {{ $currentRoute === 'contact' ? 'text-violet bg-violet/5' : '' }}"
				href="{{ route('contact') }}">{{ __('Contact Us') }}</a>
			@endif
		</nav>
	</aside>
</header>

@push('script')
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			const menuButtons = document.querySelectorAll('#menuBtn');
			const closeButtons = document.querySelectorAll('#closeMenu');
			const mobileMenu = document.getElementById('mobileMenu');
			const mobileOverlay = document.getElementById('mobileOverlay');

			if (mobileMenu && mobileOverlay) {
				if (mobileOverlay.parentNode !== document.body) document.body.appendChild(mobileOverlay);
				if (mobileMenu.parentNode !== document.body) document.body.appendChild(mobileMenu);

				const hiddenClass = mobileMenu.dataset.hiddenClass || 'translate-x-full';
				mobileMenu.style.visibility = 'visible';

				function openMenu() {
					mobileMenu.classList.remove('translate-x-full', '-translate-x-full');
					mobileOverlay.classList.remove('opacity-0', 'pointer-events-none');
					document.documentElement.classList.add('menu-open');
					document.body.classList.add('menu-open');
					mobileMenu.setAttribute('aria-hidden', 'false');
					menuButtons.forEach(btn => btn.setAttribute('aria-expanded', 'true'));
				}

				function closeMenuFn() {
					mobileMenu.classList.remove('translate-x-full', '-translate-x-full');
					mobileMenu.classList.add(hiddenClass);
					mobileOverlay.classList.add('opacity-0', 'pointer-events-none');
					document.documentElement.classList.remove('menu-open');
					document.body.classList.remove('menu-open');
					mobileMenu.setAttribute('aria-hidden', 'true');
					menuButtons.forEach(btn => btn.setAttribute('aria-expanded', 'false'));
				}

				menuButtons.forEach(btn => btn.addEventListener('click', openMenu));
				closeButtons.forEach(btn => btn.addEventListener('click', closeMenuFn));
				mobileOverlay.addEventListener('click', closeMenuFn);
				mobileMenu.querySelectorAll('a').forEach(link => link.addEventListener('click', closeMenuFn));
				document.addEventListener('keydown', e => { if (e.key === 'Escape') closeMenuFn(); });
				closeMenuFn();
			}

			// Desktop services dropdown
			const desktopDropdown = document.getElementById('desktopServicesDropdown');
			const desktopBtn      = document.getElementById('desktopServicesBtn');
			const desktopMenu     = document.getElementById('desktopServicesMenu');
			const desktopIcon     = document.getElementById('desktopServicesIcon');

			function openDesktop() {
				desktopMenu.classList.remove('opacity-0', 'invisible', 'translate-y-2', 'pointer-events-none');
				desktopMenu.classList.add('opacity-100', 'visible', 'translate-y-0');
				desktopBtn.setAttribute('aria-expanded', 'true');
				desktopIcon?.classList.add('rotate-180');
			}

			function closeDesktop() {
				desktopMenu.classList.add('opacity-0', 'invisible', 'translate-y-2', 'pointer-events-none');
				desktopMenu.classList.remove('opacity-100', 'visible', 'translate-y-0');
				desktopBtn.setAttribute('aria-expanded', 'false');
				desktopIcon?.classList.remove('rotate-180');
			}

			if (desktopDropdown && desktopBtn && desktopMenu) {
				desktopBtn.addEventListener('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					desktopBtn.getAttribute('aria-expanded') === 'true' ? closeDesktop() : openDesktop();
				});
				desktopDropdown.addEventListener('click', e => e.stopPropagation());
				document.addEventListener('click', closeDesktop);
				document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDesktop(); });
			}

			// Mobile services accordion
			const mobileServicesBtn  = document.getElementById('mobileServicesBtn');
			const mobileServicesMenu = document.getElementById('mobileServicesMenu');
			const mobileServicesIcon = document.getElementById('mobileServicesIcon');

			if (mobileServicesBtn && mobileServicesMenu) {
				mobileServicesBtn.addEventListener('click', function(e) {
					e.preventDefault();
					e.stopPropagation();
					const isOpen = mobileServicesBtn.getAttribute('aria-expanded') === 'true';
					if (isOpen) {
						mobileServicesMenu.style.maxHeight = '0px';
						mobileServicesBtn.setAttribute('aria-expanded', 'false');
						mobileServicesIcon?.classList.remove('rotate-180');
					} else {
						mobileServicesMenu.style.maxHeight = mobileServicesMenu.scrollHeight + 'px';
						mobileServicesBtn.setAttribute('aria-expanded', 'true');
						mobileServicesIcon?.classList.add('rotate-180');
					}
				});
			}
		});
	</script>
@endpush
