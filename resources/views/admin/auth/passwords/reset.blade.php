@extends('admin.auth.layout', ['title' => 'Reset Password'])

@section('auth_heading', __('Reset Your Password'))
@section('auth_subheading', __('Choose a new password for your admin account.'))

@section('auth_form')
    <form action="{{ route('admin.password.change') }}" method="POST" class="login-form admin-auth-form">
        @csrf

        <input type="hidden" name="email" value="{{ $email }}">
        <input type="hidden" name="token" value="{{ $token }}">

        <div class="row g-3">

            <div class="col-12">
                <label class="form-label" for="password">@lang('New Password')</label>
                <div class="admin-auth-field">
                    <span class="field-icon"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" id="password"
                        class="form-control radius-30 @error('password') is-invalid @enderror" name="password"
                        placeholder="@lang('Enter new password')" autocomplete="new-password" required autofocus>
                    <button type="button" class="toggle-password" aria-label="@lang('Show password')">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-12">
                <label class="form-label" for="password_confirmation">@lang('Confirm Password')</label>
                <div class="admin-auth-field">
                    <span class="field-icon"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" id="password_confirmation" class="form-control radius-30"
                        name="password_confirmation" placeholder="@lang('Enter Confirm password')"
                        autocomplete="new-password" required>
                    <button type="button" class="toggle-password" aria-label="@lang('Show password')">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <div class="col-12">
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary radius-30">@lang('Submit')</button>
                </div>
            </div>

            <div class="text-center col-12">
                <a href="{{ route('admin.login') }}">@lang('Login Here')</a>
            </div>

        </div>
    </form>
@endsection
