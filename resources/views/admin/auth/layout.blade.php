{{--
    Shared shell for the admin authentication screens.

    Child views provide:
      @section('auth_heading')    - card heading
      @section('auth_subheading') - supporting line (optional)
      @section('auth_form')       - the form
      @section('auth_footer')     - links below the form (optional)
--}}
@extends('admin.layouts.master')

@section('content')
    <main class="authentication-content login-bg">
        <div class="container-fluid">
            <div class="authentication-card">
                <div class="card shadow rounded-4 overflow-hidden border-0 w-100">
                    <div class="card-body p-4 p-sm-5">

                        <div class="text-center mb-4">
                            <a href="{{ route('home') }}">
                                <img src="{{ siteLogo() }}" alt="{{ __(gs('site_name')) }}" class="admin-auth-logo">
                            </a>
                        </div>

                        <h1 class="card-title h5 text-center mb-1">@yield('auth_heading')</h1>

                        @hasSection('auth_subheading')
                            <p class="card-text text-center text-muted small mb-4">@yield('auth_subheading')</p>
                        @else
                            <div class="mb-4"></div>
                        @endif

                        @yield('auth_form')

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('style')
    <style>
        .admin-auth-logo {
            max-height: 52px;
            width: auto;
        }

        .authentication-card .card {
            max-width: 460px;
        }

        .admin-auth-field {
            position: relative;
        }

        .admin-auth-field .field-icon {
            position: absolute;
            inset-block: 0;
            inset-inline-start: 0;
            display: flex;
            align-items: center;
            padding-inline: 1rem;
            color: #94a3b8;
            pointer-events: none;
        }

        .admin-auth-field .form-control {
            padding-inline-start: 2.75rem;
        }

        .admin-auth-field .toggle-password {
            position: absolute;
            inset-block: 0;
            inset-inline-end: 0;
            display: flex;
            align-items: center;
            padding-inline: 1rem;
            color: #94a3b8;
            background: none;
            border: 0;
        }

        .admin-auth-field .toggle-password:hover {
            color: var(--bs-primary, #6D47FF);
        }

        .admin-auth-field:has(.toggle-password) .form-control {
            padding-inline-end: 2.75rem;
        }

        /* Verification codes stay left to right even when the panel is in Arabic. */
        .admin-code-input {
            direction: ltr;
            text-align: center;
            letter-spacing: .5em;
            font-weight: 600;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            $(document).on('click', '.toggle-password', function() {
                var $field = $(this).closest('.admin-auth-field').find('input');
                var toShow = $field.attr('type') === 'password';
                $field.attr('type', toShow ? 'text' : 'password');
                $(this).find('i').attr('class', toShow ? 'bi bi-eye-slash' : 'bi bi-eye');
            });

            // Prevent a second submit and show progress.
            $(document).on('submit', 'form.admin-auth-form', function() {
                var $btn = $(this).find('button[type=submit]');
                if ($btn.prop('disabled')) {
                    return false;
                }
                $btn.data('label', $btn.html());
                $btn.prop('disabled', true).html('<i class="las la-spinner fa-spin"></i> ' + $btn.data('label'));
            });
        })(jQuery);
    </script>
@endpush
