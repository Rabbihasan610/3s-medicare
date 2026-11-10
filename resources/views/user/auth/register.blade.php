@extends('user.auth.layout', ['title' => __('Sign Up')])

@php
    $policyPages = getContent('policy_pages.element', false, null, true);
@endphp

@section('auth_width', 'max-w-xl')
@section('auth_heading', __('Sign Up'))
@section('auth_subheading', __('Create your account to submit and follow your requests.'))

@section('content')
    <form method="POST" action="{{ route('user.register') }}" class="auth-form space-y-5">
        @csrf

        <div class="grid gap-5 sm:grid-cols-2">

            <div>
                <label for="username" class="auth-label">@lang('Username')</label>
                <input type="text" id="username" name="username" value="{{ old('username') }}"
                    class="auth-field checkUser @error('username') is-invalid @enderror" autocomplete="username" required>
                <small class="auth-error usernameExist"></small>
                @error('username')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="auth-label">@lang('Email Address')</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="auth-field checkUser @error('email') is-invalid @enderror" autocomplete="email" required>
                <small class="auth-error emailExist"></small>
                @error('email')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="country" class="auth-label">@lang('Country')</label>
                <select name="country" id="country" class="auth-field @error('country') is-invalid @enderror">
                    @foreach ($countries as $country)
                        @if (app()->getLocale() == 'en')
                            <option value="{{ $country->id }}">{{ __($country->name) }}</option>
                        @else
                            <option value="{{ $country->id }}">{{ __($country->name_ar) }}</option>
                        @endif
                    @endforeach
                </select>
                @error('country')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="mobile" class="auth-label">@lang('Mobile Number')</label>
                <input type="number" id="mobile" name="mobile" value="{{ old('mobile') }}"
                    class="auth-field checkUser @error('mobile') is-invalid @enderror" autocomplete="tel" required>
                <small class="auth-error mobileExist"></small>
                @error('mobile')
                    <p class="auth-error">{{ $message }}</p>
                @enderror
            </div>

            @include('user.auth.partials.password', [
                'name' => 'password',
                'label' => __('Password'),
                'autocomplete' => 'new-password',
                'extraClass' => gs('secure_password') ? 'secure-password' : '',
            ])

            @include('user.auth.partials.password', [
                'name' => 'password_confirmation',
                'label' => __('Confirm Password'),
                'autocomplete' => 'new-password',
            ])

        </div>

        <div class="auth-captcha">
            <x-captcha />
        </div>

        @if (gs()->agree)
            <div class="flex items-start gap-2 text-sm text-slate-600">
                <input type="checkbox" id="agree" @checked(old('agree')) name="agree" required
                    class="mt-0.5 h-4 w-4 rounded border-slate-300 text-[#6D47FF] focus:ring-[#6D47FF]">
                <label for="agree">
                    @lang('I agree with')
                    @foreach ($policyPages as $policy)
                        <a href="{{ route('policy.pages', [slug($policy->data_values->title), $policy->id]) }}" target="_blank"
                            class="font-semibold text-[#6D47FF] hover:underline">{{ __($policy->data_values->title) }}</a>@if (!$loop->last),
                        @endif
                    @endforeach
                </label>
            </div>
        @endif

        <button type="submit" id="recaptcha" class="auth-submit">@lang('Sign Up')</button>
    </form>
@endsection

@section('auth_footer')
    @lang('Already have an account?')
    <a href="{{ route('user.login') }}" class="font-semibold text-[#6D47FF] hover:underline">@lang('Sign In')</a>
@endsection

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif

@push('script')
    <script>
        "use strict";
        (function($) {
            $('.checkUser').on('focusout', function(e) {

                var url = '{{ route('user.checkUser') }}';
                var value = $(this).val();
                var token = '{{ csrf_token() }}';

                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'username') {
                    var data = {
                        username: value,
                        _token: token
                    }
                }

                if ($(this).attr('name') == 'mobile') {
                    var data = {
                        mobile: value,
                        _token: token
                    }
                }

                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exists`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });

            });
        })(jQuery);
    </script>
@endpush
