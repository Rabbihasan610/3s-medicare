@extends('admin.auth.layout', ['title' => 'Account Recovery'])

@section('auth_heading', __('Forgot Password'))
@section('auth_subheading', __('Enter your account email and we will send you a recovery code.'))

@section('auth_form')
    <form action="{{ route('admin.password.reset') }}" method="POST" class="login-form verify-gcaptcha admin-auth-form">
        @csrf
        <div class="row g-4">

            <div class="col-12">
                <label class="form-label" for="email">@lang('Email')</label>
                <div class="admin-auth-field">
                    <span class="field-icon"><i class="bi bi-envelope"></i></span>
                    <input type="email" id="email" class="form-control radius-30 @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" name="email" placeholder="@lang('Enter Email')" autocomplete="email"
                        required autofocus>
                </div>
                @error('email')
                    <small class="text-danger d-block mt-1">{{ $message }}</small>
                @enderror
            </div>

            @php
                $admin = true;
            @endphp
            <x-captcha :$admin="$admin" />

            <div class="col-12">
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary radius-30">@lang('Submit')</button>
                </div>
            </div>

            <div class="text-center col-12 mt-2">
                <a href="{{ route('admin.login') }}">@lang('Login Here')</a>
            </div>

        </div>
    </form>
@endsection
