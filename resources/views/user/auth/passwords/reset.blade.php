@extends('user.auth.layout', ['title' => __('Reset Password')])

@section('auth_heading', __('Reset Password'))
@section('auth_subheading', __('Your account is verified successfully. Now you can change your password'))

@section('content')
    <form action="{{ route('user.password.update') }}" method="post" class="auth-form space-y-5">
        @csrf

        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="token" value="{{ $token }}">

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

        <div class="auth-captcha">
            <x-captcha />
        </div>

        <button type="submit" class="auth-submit">@lang('Submit')</button>
    </form>
@endsection

@section('auth_footer')
    <a href="{{ route('user.login') }}" class="font-semibold text-[#6D47FF] hover:underline">@lang('Back to Sign In')</a>
@endsection

@if (gs('secure_password'))
    @push('script-lib')
        <script src="{{ asset('assets/global/js/secure_password.js') }}"></script>
    @endpush
@endif
