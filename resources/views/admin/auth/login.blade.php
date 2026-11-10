@extends('admin.auth.layout', ['title' => 'Admin Login'])

@section('auth_heading')
    @lang('Welcome to') {{ __(gs('site_name')) }}
@endsection

@section('auth_subheading')
    @lang('Admin Login') @lang('to') {{ __(gs('site_name')) }} @lang('Dashboard')
@endsection

@section('auth_form')
    <form class="form-body admin-auth-form" action="{{ route('admin.login') }}" method="POST">
        @csrf
        <div class="row g-3">

            <div class="col-12">
                <label class="form-label" for="username">@lang('Email/Username')</label>
                <div class="admin-auth-field">
                    <span class="field-icon"><i class="bi bi-person-fill"></i></span>
                    <input type="text" id="username" class="form-control radius-30 @error('username') is-invalid @enderror"
                        value="{{ old('username') }}" name="username" placeholder="@lang('Enter Email/Username')"
                        autocomplete="username" required autofocus>
                </div>
                @error('username')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-12">
                <label class="form-label" for="password">@lang('Password')</label>
                <div class="admin-auth-field">
                    <span class="field-icon"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" id="password"
                        class="form-control radius-30 @error('password') is-invalid @enderror" name="password"
                        placeholder="@lang('Enter Password')" autocomplete="current-password" required>
                    <button type="button" class="toggle-password" aria-label="@lang('Show password')">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            <div class="col-6">
                <div class="form-check form-switch">
                    <input class="form-check-input" name="remember" type="checkbox" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">@lang('Remember Me')</label>
                </div>
            </div>

            <div class="col-6 text-end">
                <a href="{{ route('admin.password.reset') }}">@lang('Forgot Password?')</a>
            </div>

            <div class="col-12">
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary radius-30">@lang('Sign In')</button>
                </div>
            </div>

        </div>
    </form>
@endsection
