{{--
    Password field with a show/hide toggle.

    @include('user.auth.partials.password', [
        'name'  => 'password',
        'label' => __('Password'),
        'id'    => 'password',            // optional, defaults to the name
        'extraClass'   => 'secure-password',  // optional
        'autocomplete' => 'new-password',     // optional
    ])
--}}
@php
    $fieldId = $id ?? $name;
    $fieldAutocomplete = $autocomplete ?? 'current-password';
    $fieldExtra = $extraClass ?? '';
@endphp

<div>
    <label for="{{ $fieldId }}" class="auth-label">{{ $label }}</label>

    <div class="auth-password relative">
        <input type="password" id="{{ $fieldId }}" name="{{ $name }}"
            class="auth-field pe-10 {{ $fieldExtra }} @error($name) is-invalid @enderror"
            autocomplete="{{ $fieldAutocomplete }}" required>

        <button type="button" class="auth-toggle-password" aria-label="@lang('Show password')">
            <svg class="eye-open h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.04 12.32a1 1 0 010-.64C3.42 7.51 7.36 4.5 12 4.5s8.57 3.01 9.96 7.18a1 1 0 010 .64C20.58 16.49 16.64 19.5 12 19.5s-8.57-3.01-9.96-7.18z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <svg class="eye-closed hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7"
                aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.98 8.22A10.48 10.48 0 001.93 12c1.39 4.17 5.33 7.18 9.97 7.18 1.4 0 2.74-.27 3.96-.77M6.23 6.23A10.45 10.45 0 0112 4.5c4.64 0 8.58 3.01 9.97 7.18a10.5 10.5 0 01-4.29 5.29M6.23 6.23L3 3m3.23 3.23l3.65 3.65m4.24 4.24L17.77 17.77M14.12 14.12a3 3 0 11-4.24-4.24" />
            </svg>
        </button>
    </div>

    @error($name)
        <p class="auth-error">{{ $message }}</p>
    @enderror
</div>
