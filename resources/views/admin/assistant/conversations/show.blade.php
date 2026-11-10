@extends('admin.layouts.app', ['title' => $pageTitle])
@section('panel')
    <div class="row gy-4">

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">@lang('Transcript')</h6>
                    <small class="text-muted">{{ $conversation->messages->count() }} @lang('turns')</small>
                </div>

                <div class="card-body">
                    @forelse ($conversation->messages as $message)
                        @php
                            /*
                            | Direction comes from the message, not the thread: a
                            | visitor can switch language mid-conversation and each
                            | turn is answered in the language it was asked in.
                            */
                            $dir     = $message->lang === 'ar' ? 'rtl' : 'ltr';
                            $isVisitor = $message->role === 'user';
                        @endphp

                        <div class="d-flex mb-4 {{ $isVisitor ? '' : 'justify-content-end' }}">
                            <div class="border rounded p-3 {{ $isVisitor ? 'bg-light' : '' }}" style="max-width:88%">

                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <span class="badge {{ $isVisitor ? 'bg-secondary' : 'bg--primary' }}">
                                        {{ $isVisitor ? __('Visitor') : __('Assistant') }}
                                    </span>
                                    <span class="badge bg-secondary text-uppercase">{{ $message->lang }}</span>

                                    @if (!$isVisitor && $message->status !== 'ok')
                                        <span class="badge bg--warning">{{ __(str()->headline($message->status)) }}</span>
                                    @endif

                                    <small class="text-muted ms-auto">{{ showDateTime($message->created_at) }}</small>
                                </div>

                                @if (filled($message->content))
                                    <div dir="{{ $dir }}">{!! nl2br(e($message->content)) !!}</div>
                                @else
                                    <p class="text-muted mb-0 fst-italic">
                                        @lang('No answer was produced for this turn.')
                                    </p>
                                @endif

                                @if (!$isVisitor && $message->queryLog)
                                    <hr class="my-2">
                                    <small class="text-muted">
                                        {{ $message->queryLog->model ?: __('no model') }}
                                        &middot; {{ $message->queryLog->latency_ms }} ms
                                        @if ($message->queryLog->cost_usd > 0)
                                            &middot; ${{ number_format($message->queryLog->cost_usd, 5) }}
                                        @endif
                                        &middot; <a href="{{ route('admin.assistant.queries.show', $message->queryLog->id) }}">@lang('Detail')</a>
                                    </small>
                                @endif

                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">@lang('This conversation has no messages.')</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">@lang('Thread')</h6>
                </div>
                <ul class="list-group list-group-flush">
                    @php
                        /*
                        | Totalled from the linked query rows rather than stored on
                        | the conversation: assistant_queries stays the single ledger
                        | for what anything cost, so there is no second figure to
                        | drift out of step with it.
                        */
                        $cost = $conversation->messages->sum(fn ($message) => (float) ($message->queryLog->cost_usd ?? 0));
                        $unanswered = $conversation->messages->where('role', 'assistant')->where('status', '!=', 'ok')->count();
                    @endphp

                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Thread id')</span>
                        <span class="fw-bold"><code>{{ str()->limit($conversation->uuid, 13, '…') }}</code></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Started')</span>
                        <span class="fw-bold">{{ showDateTime($conversation->created_at) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Last message')</span>
                        <span class="fw-bold">
                            {{ $conversation->last_message_at ? diffForHumans($conversation->last_message_at) : '—' }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Turns without an answer')</span>
                        <span class="fw-bold {{ $unanswered ? 'text--danger' : '' }}">{{ $unanswered }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Total cost')</span>
                        <span class="fw-bold">{{ $cost > 0 ? '$' . number_format($cost, 5) : '—' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Signed in')</span>
                        <span class="fw-bold">{{ $conversation->user_id ? __('Yes') : __('No') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('IP')</span>
                        <span class="fw-bold">{{ $conversation->ip ?: '—' }}</span>
                    </li>
                </ul>
            </div>
        </div>

    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.assistant.conversations.index') }}" />
@endpush
