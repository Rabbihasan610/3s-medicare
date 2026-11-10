@extends('user.auth.layout', ['title' => __('Verify Email')])

@section('auth_heading', __('Verify Email Address'))
@section('auth_subheading')
    @lang('A 6 digit verification code sent to your email address') : {{ showEmailAddress($email) }}
@endsection

@section('content')
    <form action="{{ route('user.password.verify.code') }}" method="POST" class="submit-form space-y-5">
        @csrf

        <input type="hidden" name="email" value="{{ $email }}">

        @include('partials.verification_code', [
            'resendUrl' => route('user.password.request'),
            'resendLabel' => __('Try to send again'),
        ])

        @error('code')
            <p class="auth-error">{{ $message }}</p>
        @enderror

        <button type="submit" class="auth-submit">@lang('Submit')</button>
    </form>
@endsection

@section('auth_footer')
    <a href="{{ route('user.login') }}" class="font-semibold text-[#6D47FF] hover:underline">@lang('Back to Sign In')</a>
@endsection
