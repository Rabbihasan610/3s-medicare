{{--
    6 digit verification code field. Used by the user email / mobile / password
    verification screens. The input name, id and auto submit behaviour are relied
    on by those forms, so keep them as they are.

    Optionally pass a resend link to get a cooldown countdown:
      @include('partials.verification_code', ['resendUrl' => route(...), 'resendLabel' => __('Try again')])
--}}
@php
    $resendSeconds = $resendSeconds ?? 60;
@endphp

<div class="mb-3 form-group">
    <label class="auth-label" for="verification-code">@lang('Verification Code')</label>
    <input type="text" name="code" id="verification-code" class="form-control auth-field auth-code-input"
        inputmode="numeric" autocomplete="one-time-code" maxlength="6" required>
</div>

@isset($resendUrl)
    <p class="mt-3 text-center text-sm text-slate-500">
        @lang('If you don\'t get any code')
        <a href="{{ $resendUrl }}" class="js-resend-code font-semibold text-[#6D47FF] hover:underline"
            data-cooldown="{{ $resendSeconds }}">{{ $resendLabel ?? __('Try again') }}</a>
        <span class="js-resend-timer text-slate-400"></span>
    </p>
@endisset

@push('script')
    <script>
        $('#verification-code').on('input', function() {
            $(this).val(function(i, val) {
                if (val.length >= 6) {
                    $('.submit-form').find('button[type=submit]').html(
                        '<i class="las la-spinner fa-spin"></i>');
                    $('.submit-form').submit()
                }
                if (val.length > 6) {
                    return val.substring(0, val.length - 1);
                }
                return val;
            });
            for (let index = $(this).val().length; index >= 0; index--) {
                $($('.boxes span')[index]).html('');
            }
        });

        // Hold the resend link for a moment so the code has time to arrive.
        (function($) {
            "use strict";
            var $link = $('.js-resend-code');
            if (!$link.length) {
                return;
            }

            var $timer = $('.js-resend-timer');
            var remaining = parseInt($link.data('cooldown'), 10) || 0;
            var href = $link.attr('href');

            function tick() {
                if (remaining <= 0) {
                    $link.attr('href', href).removeClass('pointer-events-none opacity-50');
                    $timer.text('');
                    return;
                }
                $link.addClass('pointer-events-none opacity-50').removeAttr('href');
                $timer.text('(' + remaining + @json(__('s')) + ')');
                remaining--;
                setTimeout(tick, 1000);
            }

            tick();
        })(jQuery);
    </script>
@endpush
