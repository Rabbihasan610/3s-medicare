@extends('user.auth.layout', ['title' => __('Verify Email Address')])

@section('auth_heading', __('Verify Email Address'))
@section('auth_subheading')
    @lang('A 6 digit verification code sent to your email address'): {{ showEmailAddress(auth()->user()->email) }}
@endsection

@section('content')
    <form action="{{ route('user.verify.email') }}" method="POST" class="submit-form space-y-5">
        @csrf

        @include('partials.verification_code', [
            'resendUrl' => route('user.send.verify.code', 'email'),
            'resendLabel' => __('Try again'),
        ])

        @error('code')
            <p class="auth-error">{{ $message }}</p>
        @enderror

        @if ($errors->has('resend'))
            <p class="auth-error">{{ $errors->first('resend') }}</p>
        @endif

        <button type="submit" class="auth-submit">@lang('Submit')</button>
    </form>
@endsection
