<div>
    <div class="gap-4 profile d-flex align-items-center">
        <img src="{{ getImage(getFilepath('userProfile') . '/' . auth()->user()->image) }}"
            alt="{{ auth()->user()->name }}" loading="lazy">
        <div>
            <p>@lang('Welcome To')</p>
            <h4>{{ auth()->user()->name }}</h4>
        </div>
    </div>
</div>

<div class="gap-3 d-flex justify-content-between align-items-end">
    <a href="{{ url('user/message') }}" class="btn-primary btn"><i class="bi bi-chat-dots"></i> @lang('Message')</a>
    <button class="d-mobile-btn d-mobile-toggle"><i class="bi bi-list"></i></button>
    @stack('title')
</div>
