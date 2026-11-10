@php
    /*
    | AI Help Center - floating widget, rendered on every public page.
    |
    | Starter questions reuse the same CMS row as the homepage ask bar
    | (Admin > Frontend Manager > Ask Assistant Section), so the team edits them in
    | one place and both surfaces follow.
    */
    $assistantWidget = getContent('assistant_search.content', true);

    $assistantStarters = collect([1, 2, 3, 4])
        ->map(fn($i) => $assistantWidget ? trim((string) @$assistantWidget->lang('question_' . $i)) : '')
        ->filter()
        ->take(3)
        ->values()
        ->all();

    if (empty($assistantStarters)) {
        $assistantStarters = [
            __('What digital services do you offer for clinics?'),
            __('How do you help doctors rank #1 on Google?'),
            __('How fast can I get a project quote?'),
        ];
    }

    $assistantConfig = [
        'threadKey' => '3s-thread-' . substr(sha1(config('app.url')), 0, 8),
        'askUrl' => route('assistant.ask'),
        'feedbackUrl' => route('assistant.feedback'),
        'contactUrl' => url('contact'),
        'servicesUrl' => url('services'),
        'csrf' => csrf_token(),
        'strings' => [
            'thinking' => __('Thinking'),
            'sources' => __('Sources on this site'),
            'startRequest' => __('Start a request'),
            'helpful' => __('Was this helpful?'),
            'yes' => __('Yes'),
            'no' => __('No'),
            'thanks' => __('Thanks for the feedback.'),
            'contact' => __('Contact us'),
            'browse' => __('Browse all services'),
            'noAnswer' => __('We could not find an answer for that on this site. Our team can help you directly.'),
            'rateLimited' => __('Too many questions just now. Please wait a moment and try again.'),
            'expired' => __('Your session expired. Please refresh the page and try again.'),
            'failed' => __('Something went wrong. Please try again.'),
        ],
    ];
@endphp

@push('style')
    {{-- Versioned by file mtime: these two are edited in place rather than
         built, so without a cache-buster a returning visitor keeps the old copy
         and a styling fix appears not to have shipped. --}}
    <link rel="stylesheet" href="{{ assistantAsset('assets/web/css/assistant.css') }}">
@endpush

{{-- Hidden until assistant.js runs, so it never shows as a dead button. --}}
<button type="button" class="amlk amlk-launcher" data-amlk-open hidden
    aria-label="{{ __('Open the AI Help Center') }}">
    <span class="amlk-launcher__icon" aria-hidden="true"><i class="bi bi-chat-heart-fill"></i></span>
    <span>{{ __('Ask 3S Medi Care') }}</span>
</button>

<section class="amlk amlk-panel" data-amlk-panel hidden aria-label="{{ __('AI Help Center') }}">

    <header class="amlk-panel__head">
        <div>
            <p class="amlk-panel__title">{{ __('Ask 3S Medi Care') }}</p>
            <p class="amlk-panel__sub">@lang('Answered from this website')</p>
        </div>
        <button type="button" class="amlk-panel__close" data-amlk-close
            aria-label="{{ __('Close') }}">&times;</button>
    </header>

    <div class="amlk-panel__body" data-amlk-thread role="log" aria-live="polite">
        <div class="amlk-intro" data-amlk-intro>
            {{-- A greeting, not an explanation. The panel header already says
                 where answers come from, and the disclaimer under the hero bar
                 says it again - repeating it here just made the visitor read a
                 paragraph before they could ask anything. --}}
            <p class="amlk-intro__greeting">@lang('How can I help you?')</p>

            @if (count($assistantStarters))
                <div class="amlk-intro__chips">
                    @foreach ($assistantStarters as $starter)
                        <button type="button" class="amlk-chip"
                            data-amlk-suggest="{{ $starter }}">{{ $starter }}</button>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <footer class="amlk-panel__foot">
        <form data-amlk-widget-form autocomplete="off">
            <div class="amlk-field">
                <label class="sr-only" for="amlk-widget-input">@lang('Your question')</label>
                <input id="amlk-widget-input" class="amlk-field__input" type="text" maxlength="500"
                    data-amlk-widget-input placeholder="{{ __('Type your question…') }}">
                <button type="submit" class="amlk-btn" data-amlk-widget-submit>@lang('Ask')</button>
            </div>
        </form>
    </footer>
</section>

@push('script')
    <script>
        window.amlkAssistant = @json($assistantConfig);
    </script>
    <script src="{{ assistantAsset('assets/web/js/assistant.js') }}"></script>
@endpush
