@extends('user.auth.layout', ['title' => __('Sign In')])

@section('auth_heading', __('Sign In'))
@section('auth_subheading', __('Enter your credentials to access your account.'))

@section('content')
    <form method="POST" action="{{ route('user.login') }}" class="verify-gcaptcha auth-form space-y-5">
        @csrf

        <div>
            <label for="username" class="auth-label">@lang('Username or Email')</label>
            <input type="text" id="username" name="username" value="{{ old('username') }}"
                class="auth-field @error('username') is-invalid @enderror" autocomplete="username" required autofocus>
            @error('username')
                <p class="auth-error">{{ $message }}</p>
            @enderror
        </div>

        @include('user.auth.partials.password', [
            'name' => 'password',
            'label' => __('Password'),
            'autocomplete' => 'current-password',
        ])

        <div class="auth-captcha">
            <x-captcha />
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3">
            <label for="remember" class="inline-flex items-center gap-2 text-sm text-slate-600">
                <input class="h-4 w-4 rounded border-slate-300 text-[#6D47FF] focus:ring-[#6D47FF]" type="checkbox"
                    name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                @lang('Remember Me')
            </label>

            <a class="text-sm font-semibold text-[#6D47FF] hover:underline" href="{{ route('user.password.request') }}">
                @lang('Forgot your password?')
            </a>
        </div>

        <button type="submit" id="recaptcha" class="auth-submit">
            @lang('Sign In')
        </button>
    </form>
@endsection

@section('auth_footer')
    @lang('Don\'t have any account?')
    <a href="{{ route('user.register') }}" class="font-semibold text-[#6D47FF] hover:underline">@lang('Sign Up')</a>
@endsection
