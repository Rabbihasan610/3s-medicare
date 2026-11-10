@extends('web.layouts.medicare', ['title' => $pageTitle])

@section('meta_title', $question ? $question . ' | ' . gs('site_name') : $pageTitle)

@section('content')
	{{-- Server-rendered answer page. This is what a visitor gets when JavaScript
	     is off, and it is also the shareable, indexable URL behind every question
	     asked from the homepage bar. Styles come from assistant.css, loaded by the
	     widget partial in the layout. --}}
	<main class="amlk amlk-hero" data-amlk-scope>
		<div class="amlk-hero__inner" style="max-width:760px">

			<form action="{{ route('assistant.answer') }}" method="GET" role="search" autocomplete="off"
				data-amlk-form="#amlk-page-answer">

				<label class="sr-only" for="amlk-page-input">@lang('Your question')</label>

				<div class="amlk-field" style="margin-top:0">
					<span class="amlk-field__icon" aria-hidden="true"><i class="las la-search"></i></span>

					<input id="amlk-page-input" class="amlk-field__input" type="search" name="q" required maxlength="500"
						value="{{ $question }}" data-amlk-input placeholder="{{ __('Ask about our services…') }}">

					<button type="submit" class="amlk-btn" data-amlk-submit>@lang('Ask')</button>
				</div>
			</form>

			{{-- assistant.js replaces this with a fresh answer when a new question
			     is asked without leaving the page. --}}
			<div id="amlk-page-answer" aria-live="polite">

				@if ($question === '')
					<p class="amlk-note" style="margin-top:24px">
						@lang('Type a question above and we will answer it from the content of this site.')
					</p>
				@elseif ($result && $result['status'] === 'ok')
					@php
						/*
						| The answer follows the question's own script, not the site
						| toggle - an Arabic question asked on the English site is
						| answered in Arabic. Without dir the reply renders LTR.
						*/
						$answerLang = $result['lang'] ?? app()->getLocale();
						$answerDir  = $answerLang === 'ar' ? 'rtl' : 'ltr';
					@endphp

					<article class="amlk-answer">
						<p class="amlk-answer__q">{{ $question }}</p>

						<p class="amlk-answer__body" lang="{{ $answerLang }}" dir="{{ $answerDir }}">
							{!! nl2br(e($result['answer'])) !!}
						</p>

						@if ($result['route_url'])
							<div class="amlk-answer__cta">
								<a class="amlk-btn" href="{{ $result['route_url'] }}">@lang('Start a request')</a>
							</div>
						@endif

						@if (count($result['sources']))
							{{-- Source titles are indexed in the answer's language too. --}}
							<div class="amlk-sources" lang="{{ $answerLang }}" dir="{{ $answerDir }}">
								<p class="amlk-sources__label">@lang('Sources on this site')</p>
								<ul class="amlk-sources__list">
									@foreach ($result['sources'] as $source)
										<li>
											<a href="{{ $source['url'] ?? '#' }}" target="_blank" rel="noopener">
												<i class="las la-link" aria-hidden="true"></i>{{ $source['title'] }}
											</a>
											{{-- The model's note on why this link answers the question. --}}
											@if (!empty($source['reason']))
												<span class="amlk-sources__why">{{ $source['reason'] }}</span>
											@endif
										</li>
									@endforeach
								</ul>
							</div>
						@endif

						@if ($result['query_id'])
							<div class="amlk-feedback" id="assistant-feedback" data-query="{{ $result['query_id'] }}">
								<span>@lang('Was this helpful?')</span>
								<button type="button" class="amlk-feedback__btn" data-helpful="1">@lang('Yes')</button>
								<button type="button" class="amlk-feedback__btn" data-helpful="0">@lang('No')</button>
								<span class="amlk-feedback__thanks" hidden>@lang('Thanks for the feedback.')</span>
							</div>
						@endif
					</article>
				@else
					{{-- No confident answer. Never guess - hand the visitor to a human. --}}
					<article class="amlk-answer amlk-answer--empty">
						<p class="amlk-answer__q">{{ $question }}</p>

						<p class="amlk-answer__body">
							@lang('We could not find an answer for that on this site. Our team can help you directly.')
						</p>

						<div class="amlk-answer__cta">
							<a class="amlk-btn" href="{{ url('contact') }}">@lang('Contact us')</a>
							<a class="amlk-btn amlk-btn--ghost" href="{{ url('services') }}">@lang('Browse all services')</a>
						</div>
					</article>
				@endif

			</div>

			<p class="amlk-note">
				@lang('Answers are generated from the content of this website and may not cover every case.')
			</p>

		</div>
	</main>
@endsection

@push('script')
	<script>
		(function($) {
			"use strict";

			// Feedback for the server-rendered answer. Answers that assistant.js
			// renders carry their own handler, wired up when the node is built.
			$(document).on('click', '#assistant-feedback .amlk-feedback__btn', function() {
				var $wrap = $('#assistant-feedback');

				$wrap.find('.amlk-feedback__btn').prop('disabled', true);
				$wrap.find('.amlk-feedback__thanks').prop('hidden', false);

				$.post("{{ route('assistant.feedback') }}", {
					_token: "{{ csrf_token() }}",
					query_id: $wrap.data('query'),
					helpful: $(this).data('helpful')
				});
			});
		})(jQuery);
	</script>
@endpush
