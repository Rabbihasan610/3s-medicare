@extends('user.auth.layout', ['title' => __('Forgot Password')])

@section('auth_heading', __('Forgot Password'))
@section('auth_subheading', __('To initiate account recovery, kindly provide either your email or username for account identification.'))

@section('content')
    <form method="POST" action="{{ route('user.password.email') }}" class="verify-gcaptcha auth-form space-y-5">
        @csrf

        <div>
            <label for="value" class="auth-label">@lang('Email or Username')</label>
            <input type="text" id="value" name="value" value="{{ old('value') }}"
                class="auth-field @error('value') is-invalid @enderror" required autofocus>
            @error('value')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="auth-captcha">
            <x-captcha />
        </div>

        <button type="submit" class="auth-submit">@lang('Submit')</button>
    </form>
@endsection

@section('auth_footer')
    <a href="{{ route('user.login') }}" class="font-semibold text-[#6D47FF] hover:underline">@lang('Back to Sign In')</a>
@endsection
