@extends('admin.auth.layout', ['title' => 'Code Verify'])

@section('auth_heading', __('Forgot Password'))
@section('auth_subheading', __('Enter the 6 digit code we sent to your email.'))

@section('auth_form')
    <form action="{{ route('admin.password.verify.code') }}" method="POST" class="login-form w-100 verify-gcaptcha">
        @csrf
        <div class="row g-3">

            <div class="col-12">
                <label class="form-label" for="code">@lang('Verification Code')</label>
                <input type="text" id="code" class="form-control radius-30 admin-code-input @error('code') is-invalid @enderror"
                    value="{{ old('code') }}" name="code" placeholder="------" inputmode="numeric"
                    autocomplete="one-time-code" maxlength="6" required autofocus>
                @error('code')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-12">
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary radius-30">@lang('Submit')</button>
                </div>
            </div>

            <div class="col-12 text-center">
                <p class="small text-muted mb-1">
                    @lang('If you don\'t get any code')
                    <a href="{{ route('admin.password.reset') }}" class="js-admin-resend"
                        data-cooldown="60">@lang('Try again')</a>
                    <span class="js-admin-resend-timer text-muted"></span>
                </p>
                <a href="{{ route('admin.login') }}">@lang('Login Here')</a>
            </div>

        </div>
    </form>
@endsection

@push('script')
    <script>
        (function($) {
            'use strict';

            $('[name=code]').on('input', function() {

                $(this).val(function(i, val) {
                    if (val.length >= 6) {
                        $('form').find('button[type=submit]').html(
                            '<i class="las la-spinner fa-spin"></i>');
                        $('form').find('button[type=submit]').removeClass('disabled');
                        $('form')[0].submit();
                    } else {
                        $('form').find('button[type=submit]').addClass('disabled');
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

            // Hold the resend link briefly so the code has time to arrive.
            var $link = $('.js-admin-resend');
            if ($link.length) {
                var $timer = $('.js-admin-resend-timer');
                var remaining = parseInt($link.data('cooldown'), 10) || 0;
                var href = $link.attr('href');

                (function tick() {
                    if (remaining <= 0) {
                        $link.attr('href', href).css({
                            'pointer-events': '',
                            opacity: ''
                        });
                        $timer.text('');
                        return;
                    }
                    $link.css({
                        'pointer-events': 'none',
                        opacity: .5
                    }).removeAttr('href');
                    $timer.text('(' + remaining + @json(__('s')) + ')');
                    remaining--;
                    setTimeout(tick, 1000);
                })();
            }

        })(jQuery)
    </script>
@endpush
