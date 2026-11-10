@extends('user.auth.layout', ['title' => __('You are banned')])

@section('auth_heading', __('You are banned'))

@section('content')
    <div class="rounded-2xl border border-red-100 bg-red-50 p-6">
        <div class="flex items-start gap-3">
            <span class="mt-0.5 flex h-9 w-9 flex-none items-center justify-center rounded-full bg-red-100 text-red-600"
                aria-hidden="true">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v3.75m0 3.75h.008M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </span>
            <div>
                <p class="text-sm font-semibold text-red-800">@lang('Reason'):</p>
                <p class="mt-1 text-sm leading-6 text-red-700">{{ $user->ban_reason }}</p>
            </div>
        </div>
    </div>
@endsection

@section('auth_footer')
    <a href="{{ route('home') }}" class="font-semibold text-[#6D47FF] hover:underline">@lang('Go to Home')</a>
@endsection
