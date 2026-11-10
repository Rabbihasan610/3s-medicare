@php
	$socialMediaElements = getContent('social_media.element', null, false, true);
	$footerContents = getContent('footer.content', true);
	$siteInfo = getContent('site_information.content', true);
	$pages = App\Models\Page::where('is_default', \App\Constants\Status::NO)->get();
	$policyPages = getContent('policy_pages.element', false, null, true);

	$sectors = collect();
@endphp

<footer class="text-white pt-20 pb-10" style="background: linear-gradient(135deg, #4b0066 0%, #2d0040 100%);">

	{{-- Top divider glow --}}
	<div class="mx-auto max-w-7xl px-6 lg:px-10">
		<div class="mb-14 h-px w-full bg-gradient-to-r from-transparent via-white/20 to-transparent"></div>
	</div>

	<div class="mx-auto max-w-7xl px-6 lg:px-10 grid gap-14 lg:grid-cols-2">

		{{-- LEFT: sectors + logo --}}
		<div>
			<div class="mb-10">
				<h2 class="text-xs font-bold uppercase tracking-[0.3em] text-white/60 mb-5">{{ __('Sectors') }}</h2>
				<div class="grid grid-cols-2 gap-y-2.5 text-sm">
					@foreach ($sectors as $sector)
						<div>
							<a href="{{ route('sectorPage', $sector->slug) }}"
								class="text-white/70 transition-colors duration-200 hover:text-white hover:underline underline-offset-2">
								{{ $sector?->lang('title') }}
							</a>
						</div>
					@endforeach
				</div>
			</div>

			{{-- Big site name --}}
			<div class="mt-10">
				<p class="text-3xl font-extrabold tracking-wider sm:tracking-widest text-white/90 leading-none sm:text-[44px] lg:text-[56px] break-words">
					{{ strtoupper(gs()->site_name) }}
				</p>
			</div>
		</div>

		{{-- RIGHT: link columns --}}
		<div class="grid gap-10 sm:grid-cols-2">

			{{-- Investment --}}
			<div>
				<h2 class="text-xs font-bold uppercase tracking-[0.3em] text-white/60 mb-5">{{ __('Investment') }}</h2>
				<ul class="space-y-3 text-sm">
					<li>
						<a href="{{ Route::has('investments') ? route('investments') : '#' }}"
							class="text-white/70 transition-colors duration-200 hover:text-white hover:underline underline-offset-2">
							{{ __('BOT Projects') }}
						</a>
					</li>
					<li>
						<a href="{{ Route::has('investment.services.request') ? route('investment.services.request') : '#' }}"
							class="text-white/70 transition-colors duration-200 hover:text-white hover:underline underline-offset-2">
							{{ __('Request Investment') }}
						</a>
					</li>
				</ul>
			</div>

			{{-- About --}}
			<div>
				<h2 class="text-xs font-bold uppercase tracking-[0.3em] text-white/60 mb-5">{{ __('About Us') }}</h2>
				<ul class="space-y-3 text-sm">
					<li>
						<a href="{{ Route::has('about') ? route('about') : '#' }}"
							class="text-white/70 transition-colors duration-200 hover:text-white hover:underline underline-offset-2">
							{{ __('About Us') }}
						</a>
					</li>
					<li>
						<a href="{{ Route::has('suppliers') ? route('suppliers') : '#' }}"
							class="text-white/70 transition-colors duration-200 hover:text-white hover:underline underline-offset-2">
							{{ __('Suppliers') }}
						</a>
					</li>
				</ul>
			</div>

			{{-- Contact --}}
			<div class="sm:col-span-2">
				<h2 class="text-xs font-bold uppercase tracking-[0.3em] text-white/60 mb-5">{{ __('Contact') }}</h2>
				<div class="h-px w-full bg-white/10 mb-5"></div>
				<ul class="space-y-4 text-sm">
					<li class="flex items-center gap-3 text-white/80">
						<span class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-white/10">
							<i class="fa-solid fa-phone text-xs"></i>
						</span>
						{{ @$siteInfo->data_values->phone ?? '+1 (555) 234-5678' }}
					</li>
					<li class="flex items-center gap-3 text-white/80">
						<span class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-white/10">
							<i class="fa-regular fa-envelope text-xs"></i>
						</span>
						{{ @$siteInfo->data_values->email ?? 'info@3smedicare.com' }}
					</li>
				</ul>
			</div>

		</div>
	</div>

	{{-- Bottom Bar --}}
	<div class="mx-auto mt-16 max-w-7xl px-6 lg:px-10">
		<div class="h-px w-full bg-white/10 mb-6"></div>
		<div class="flex flex-col gap-5 md:flex-row md:items-center md:justify-between text-sm text-white/60">

			<p>
				&copy; {{ date('Y') }} {{ strtoupper(gs()->site_name) }} &mdash; {{ __('All Rights Reserved') }}
			</p>

			{{-- Policy links --}}
			<div class="flex flex-wrap gap-5">
				@foreach ($policyPages as $policy)
					@php
						$slug = optional($policy->data_values)->slug;
						$title = optional($policy->data_values)->title;
					@endphp
					@if ($slug && $policy->id)
						<a href="{{ route('policy.pages', ['slug' => $slug, 'id' => $policy->id]) }}"
							class="transition-colors duration-200 hover:text-white hover:underline underline-offset-2">
							{{ __($title) }}
						</a>
					@endif
				@endforeach
			</div>

			{{-- Social icons --}}
			<div class="flex gap-3">
				@foreach ($socialMediaElements as $social)
					@if (!empty($social->data_values->url))
						<a href="{{ $social->data_values->url }}" target="_blank" rel="noopener"
							aria-label="{{ $social->lang('name') ?: __('Social media') }}"
							class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-white/70 transition-all duration-200 hover:bg-white/20 hover:text-white">
							<i class="{{ $social->data_values->icon ?? 'fa-brands fa-globe' }} text-sm" aria-hidden="true"></i>
						</a>
					@endif
				@endforeach

				{{-- Fallback icons if no social links configured --}}
				@if ($socialMediaElements->isEmpty())
					<a href="#" aria-label="{{ __('X (Twitter)') }}" class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-white/70 transition-all duration-200 hover:bg-white/20 hover:text-white">
						<i class="fa-brands fa-x-twitter text-sm" aria-hidden="true"></i>
					</a>
					<a href="#" aria-label="{{ __('LinkedIn') }}" class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-white/70 transition-all duration-200 hover:bg-white/20 hover:text-white">
						<i class="fa-brands fa-linkedin-in text-sm" aria-hidden="true"></i>
					</a>
					<a href="#" aria-label="{{ __('Instagram') }}" class="flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 text-white/70 transition-all duration-200 hover:bg-white/20 hover:text-white">
						<i class="fa-brands fa-instagram text-sm" aria-hidden="true"></i>
					</a>
				@endif
			</div>

		</div>
	</div>

</footer>
@push('script')
	<script>
		$(document).on('submit', '.subscribe-form', function(e) {
			e.preventDefault();
			var email = $('.email-input').val();
			if (!email) {
				notify('error', @json(__('Email field is required')));
			} else {
				$.ajax({
					headers: {
						"X-CSRF-TOKEN": "{{ csrf_token() }}",
					},
					url: "{{ route('subscribe') }}",
					method: "POST",
					data: {
						email: email
					},
					success: function(response) {
						if (response.success) {
							$('input[name="email"]').val('');
							notify('success', response.message);
						} else {
							notify('error', response.error);
						}
					}
				});
			}
		});
	</script>
@endpush
