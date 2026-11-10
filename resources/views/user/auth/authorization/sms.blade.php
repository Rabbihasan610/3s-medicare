@extends('user.auth.layout', ['title' => __('Verify Mobile Number')])

@section('auth_heading', __('Verify Mobile Number'))
@section('auth_subheading')
    <span dir="ltr" class="inline-block">
        @lang('A 6 digit verification code sent to your mobile number') : +{{ showMobileNumber(auth()->user()->mobile) }}
    </span>
@endsection

@section('content')
    <form action="{{ route('user.verify.mobile') }}" method="POST" class="submit-form space-y-5">
        @csrf

        @include('partials.verification_code', [
            'resendUrl' => route('user.send.verify.code', 'phone'),
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
