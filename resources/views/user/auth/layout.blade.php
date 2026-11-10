{{--
    Shared shell for every user facing auth screen.

    Child views provide:
      @section('auth_heading')   - the form heading
      @section('auth_subheading')- one line of supporting text (optional)
      @section('content')        - the form itself
      @section('auth_footer')    - links below the form (optional)

    Everything is written with logical Tailwind utilities (ps-/pe-/ms-/me-/start-/end-)
    so the layout mirrors correctly under dir="rtl".
--}}
@extends('web.layouts.app')

{{-- Sign in / sign up / verification screens have no place in search results. --}}
@section('meta_robots', 'noindex, nofollow')

@php
    $authTagline = seoValue('social_description') ?: seoValue('description');
    $authTagline = trim(strip_tags((string) $authTagline));

    $authPoints = [
        __('One account for every service request'),
        __('Track the status of your submissions'),
        __('Direct line to our specialised teams'),
    ];
@endphp

@section('panel')
    <div class="grid min-h-screen grid-cols-1 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.05fr)]">

        {{-- Brand panel --}}
        <aside
            class="relative hidden overflow-hidden bg-gradient-to-br from-[#4b0066] via-[#3a0052] to-[#2d0040] p-12 text-white lg:flex lg:flex-col lg:justify-between">
            <div class="pointer-events-none absolute inset-0" aria-hidden="true">
                <div class="absolute -top-24 -start-24 h-80 w-80 rounded-full bg-white/5 blur-3xl"></div>
                <div class="absolute -bottom-28 -end-16 h-96 w-96 rounded-full bg-[#FDBA2D]/10 blur-3xl"></div>
            </div>

            <a href="{{ route('home') }}" class="relative inline-flex items-center gap-3">
                <img src="{{ siteLogo() }}" alt="{{ __(gs('site_name')) }}" class="h-11 w-auto">
            </a>

            <div class="relative max-w-md">
                <h2 class="text-3xl font-extrabold leading-tight xl:text-4xl">
                    {{ __('Welcome to') }} {{ __(gs('site_name')) }}
                </h2>

                @if ($authTagline !== '')
                    <p class="mt-5 text-base leading-8 text-white/70">
                        {{ \Illuminate\Support\Str::limit($authTagline, 180, '') }}
                    </p>
                @endif

                <ul class="mt-9 space-y-4">
                    @foreach ($authPoints as $point)
                        <li class="flex items-start gap-3 text-sm text-white/80">
                            <span class="mt-0.5 flex h-5 w-5 flex-none items-center justify-center rounded-full bg-white/15"
                                aria-hidden="true">
                                <svg class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M16.7 5.3a1 1 0 010 1.4l-7.5 7.5a1 1 0 01-1.4 0L3.3 9.7a1 1 0 111.4-1.4l3.8 3.8 6.8-6.8a1 1 0 011.4 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                            {{ $point }}
                        </li>
                    @endforeach
                </ul>
            </div>

            <p class="relative text-xs text-white/40">
                &copy; {{ date('Y') }} {{ __(gs('site_name')) }}
            </p>
        </aside>

        {{-- Form panel --}}
        <main class="flex flex-col bg-white">

            <div class="flex items-center justify-between gap-4 px-6 py-5 sm:px-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 lg:hidden">
                    <img src="{{ siteLogo() }}" alt="{{ __(gs('site_name')) }}" class="h-9 w-auto">
                </a>

                <a href="{{ route('home') }}"
                    class="ms-auto inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-[#6D47FF]">
                    <svg class="h-4 w-4 rtl:-scale-x-100" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M12.7 4.3a1 1 0 010 1.4L8.4 10l4.3 4.3a1 1 0 01-1.4 1.4l-5-5a1 1 0 010-1.4l5-5a1 1 0 011.4 0z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ __('Go to Home') }}
                </a>
            </div>

            <div class="flex flex-1 items-center justify-center px-6 pb-12 sm:px-10">
                <div class="w-full @yield('auth_width', 'max-w-md')">

                    <header class="mb-8">
                        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900 sm:text-3xl">
                            @yield('auth_heading')
                        </h1>
                        @hasSection('auth_subheading')
                            <p class="mt-2 text-sm leading-6 text-slate-500">@yield('auth_subheading')</p>
                        @endif
                    </header>

                    @yield('content')

                    @hasSection('auth_footer')
                        <div class="mt-8 text-center text-sm text-slate-500">
                            @yield('auth_footer')
                        </div>
                    @endif

                </div>
            </div>
        </main>
    </div>
@endsection

@push('style')
    <style>
        /* The auth screens are their own page - no site chrome around them. */
        .auth-field {
            display: block;
            width: 100%;
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            background-color: #fff;
            padding: 0.7rem 0.9rem;
            font-size: 0.875rem;
            color: #1e293b;
            outline: none;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .auth-field:focus {
            border-color: #6D47FF;
            box-shadow: 0 0 0 3px rgba(109, 71, 255, .15);
        }

        .auth-field.is-invalid {
            border-color: #ef4444;
        }

        .auth-label {
            display: block;
            margin-bottom: 0.375rem;
            font-size: 0.8125rem;
            font-weight: 600;
            color: #334155;
        }

        .auth-error {
            margin-top: 0.375rem;
            font-size: 0.75rem;
            color: #dc2626;
        }

        .auth-submit {
            display: inline-flex;
            width: 100%;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border-radius: 0.75rem;
            background-image: linear-gradient(to right, #6D47FF, #4E2DCA);
            padding: 0.75rem 1rem;
            font-size: 0.9375rem;
            font-weight: 600;
            color: #fff;
            border: 0;
            transition: opacity .15s ease, transform .15s ease;
        }

        .auth-submit:hover {
            opacity: .92;
        }

        .auth-submit[disabled] {
            opacity: .65;
            cursor: not-allowed;
        }

        .auth-toggle-password {
            position: absolute;
            inset-block: 0;
            inset-inline-end: 0.6rem;
            display: flex;
            align-items: center;
            color: #94a3b8;
            background: none;
            border: 0;
            padding: 0 .2rem;
        }

        .auth-toggle-password:hover {
            color: #6D47FF;
        }

        /* Verification codes must stay left to right even in Arabic. */
        .auth-code-input {
            direction: ltr;
            text-align: center;
            letter-spacing: .6em;
            font-weight: 700;
            font-size: 1.15rem;
        }

        /* The captcha component ships bootstrap markup; keep it from looking cramped. */
        .auth-captcha .form-control {
            border-radius: .75rem;
            padding: .7rem .9rem;
        }
    </style>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";

            // Show / hide password
            $(document).on('click', '.auth-toggle-password', function() {
                var $field = $(this).closest('.auth-password').find('input');
                var toShow = $field.attr('type') === 'password';
                $field.attr('type', toShow ? 'text' : 'password');
                $(this).attr('aria-label', toShow ? @json(__('Hide password')) : @json(__('Show password')));
                $(this).find('.eye-open').toggleClass('hidden', toShow);
                $(this).find('.eye-closed').toggleClass('hidden', !toShow);
            });

            // Block double submits and show progress on the button
            $(document).on('submit', 'form.auth-form', function() {
                var $btn = $(this).find('button[type=submit]');
                if ($btn.prop('disabled')) {
                    return false;
                }
                $btn.data('label', $btn.html());
                $btn.prop('disabled', true).html(
                    '<i class="las la-spinner fa-spin"></i> ' + $btn.data('label')
                );
            });
        })(jQuery);
    </script>
@endpush
