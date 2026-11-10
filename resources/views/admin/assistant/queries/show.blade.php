@extends('admin.layouts.app', ['title' => $pageTitle])
@section('panel')
    <div class="row gy-4">

        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">@lang('Question')</h6>
                </div>
                <div class="card-body">
                    <p class="lead mb-0" dir="{{ $query->lang == 'ar' ? 'rtl' : 'ltr' }}">{{ $query->query }}</p>

                    @if ($query->query_norm && $query->query_norm !== $query->query)
                        <hr>
                        <small class="text-muted d-block">@lang('Normalised for caching and analytics (personal data masked)')</small>
                        <code>{{ $query->query_norm }}</code>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">@lang('Answer')</h6>
                </div>
                <div class="card-body">
                    @if ($query->answer)
                        <div dir="{{ $query->lang == 'ar' ? 'rtl' : 'ltr' }}">{!! nl2br(e($query->answer)) !!}</div>
                    @else
                        <p class="text-muted mb-0">@lang('No answer was produced for this question.')</p>
                    @endif

                    @if ($query->error)
                        <div class="alert alert-danger mt-3 mb-0">
                            <strong>@lang('Error'):</strong> {{ $query->error }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">@lang('Sources used')</h6>
                </div>
                <div class="card-body">
                    @forelse($query->sources ?? [] as $source)
                        <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                            <div>
                                <strong>{{ $source['title'] ?? '—' }}</strong>
                                @if (!empty($source['route']))
                                    <br><small class="text-muted">{{ $source['route'] }}</small>
                                @endif
                            </div>
                            <div class="text-end">
                                @if (!empty($source['score']))
                                    <span class="badge bg-light text-dark">{{ $source['score'] }}</span>
                                @endif
                                @if (!empty($source['url']))
                                    <a href="{{ $source['url'] }}" target="_blank" class="btn btn-sm btn-outline-primary ms-2">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0">@lang('No sources were retrieved.')</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">@lang('Delivery')</h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Result')</span><span>@php echo $query->statusBadge @endphp</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Served from')</span><span>@php echo $query->cacheBadge @endphp</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Provider')</span><span>{{ $query->provider?->name ?? '—' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Model')</span><span><code>{{ $query->model ?: '—' }}</code></span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Confidence')</span><span>{{ number_format($query->confidence, 2) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Latency')</span><span>{{ $query->latency_ms }} ms</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Suggested route')</span><span>{{ $query->suggested_route ?: '—' }}</span>
                    </li>
                </ul>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">@lang('Tokens and cost')</h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Input')</span><span>{{ number_format($query->tokens_in) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Output')</span><span>{{ number_format($query->tokens_out) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Served from provider cache')</span>
                        <span>{{ number_format($query->tokens_cached) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Cost')</span>
                        <span>{{ $query->cost_usd > 0 ? '$' . number_format($query->cost_usd, 6) : '—' }}</span>
                    </li>
                </ul>
                @if ($query->status === 'ok' && $query->cache_layer === 'none' && $query->tokens_cached == 0)
                    <div class="card-body pt-0">
                        <small class="text-warning">
                            <i class="bi bi-exclamation-triangle pe-1"></i>
                            @lang('Nothing was served from the provider cache. If this is true of most questions, something volatile has crept into the frozen part of the prompt.')
                        </small>
                    </div>
                @endif
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">@lang('Visitor')</h6>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Language')</span><span class="text-uppercase">{{ $query->lang }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Feedback')</span>
                        <span>
                            @if ($query->feedback === 1)
                                <i class="bi bi-hand-thumbs-up-fill text-success"></i>
                            @elseif ($query->feedback === 0)
                                <i class="bi bi-hand-thumbs-down-fill text-danger"></i>
                            @else
                                &mdash;
                            @endif
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('IP')</span><span>{{ $query->ip ?: '—' }}</span>
                    </li>
                    <li class="list-group-item">
                        <span class="d-block">@lang('Asked from')</span>
                        <small class="text-muted">{{ $query->page_url ?: '—' }}</small>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>@lang('Asked at')</span><span>{{ showDateTime($query->created_at) }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <x-back route="{{ route('admin.assistant.queries.index') }}" />
@endpush
