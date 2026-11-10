@extends('admin.layouts.app', ['title' => $pageTitle])
@section('panel')

    <p class="text-muted mb-3">@lang('Last 30 days.')</p>

    <div class="row gy-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted text-uppercase">@lang('Questions asked')</small>
                    <h3 class="mb-0">{{ number_format($summary['total']) }}</h3>
                    <small class="text-muted">
                        {{ number_format($summary['answered']) }} @lang('answered')
                    </small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted text-uppercase">@lang('Could not answer')</small>
                    <h3 class="mb-0 {{ $summary['unanswered'] ? 'text-warning' : '' }}">
                        {{ number_format($summary['unanswered']) }}
                    </h3>
                    <a href="{{ route('admin.assistant.queries.unanswered') }}" class="small">
                        @lang('See what people asked')
                    </a>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted text-uppercase">@lang('Served from cache')</small>
                    <h3 class="mb-0">{{ $summary['cache_rate'] }}%</h3>
                    <small class="text-muted">@lang('These cost nothing to answer')</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted text-uppercase">@lang('Spend')</small>
                    <h3 class="mb-0">
                        {{ $summary['cost'] > 0 ? '$' . number_format($summary['cost'], 2) : '—' }}
                    </h3>
                    <small class="text-muted">
                        @if ($summary['cost'] > 0)
                            {{ $summary['latency'] }} ms @lang('average')
                        @else
                            @lang('Add token prices to the provider to track cost')
                        @endif
                    </small>
                </div>
            </div>
        </div>

        {{-- The content roadmap: questions the site could not answer, most asked first. --}}
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">@lang('Content gaps')</h6>
                    <a href="{{ route('admin.assistant.queries.unanswered') }}" class="btn btn-sm btn-outline-primary">
                        @lang('View all')
                    </a>
                </div>
                <div class="card-body p-0">
                    <table class="table table--light style--two mb-0">
                        <thead>
                            <tr>
                                <th>@lang('Question')</th>
                                <th class="text-end">@lang('Times asked')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($gaps as $gap)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.assistant.queries.show', $gap->last_id) }}">
                                            {{ str()->limit($gap->sample, 70) }}
                                        </a>
                                    </td>
                                    <td class="text-end"><span class="badge bg-warning">{{ $gap->hits }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="100%">
                                        @lang('Nothing went unanswered. Add content when that changes.')
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0">@lang('Most asked')</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table--light style--two mb-0">
                        <thead>
                            <tr>
                                <th>@lang('Question')</th>
                                <th class="text-end">@lang('Times asked')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topQuestions as $row)
                                <tr>
                                    <td>{{ str()->limit($row->sample, 70) }}</td>
                                    <td class="text-end"><span class="badge bg-primary">{{ $row->hits }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="100%">@lang('No questions yet')</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0">@lang('Marked unhelpful')</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table--light style--two mb-0">
                        <thead>
                            <tr>
                                <th>@lang('Question')</th>
                                <th>@lang('When')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($negative as $row)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.assistant.queries.show', $row->id) }}">
                                            {{ str()->limit($row->query, 60) }}
                                        </a>
                                    </td>
                                    <td>{{ diffForHumans($row->created_at) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="100%">@lang('No negative feedback')</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header">
                    <h6 class="mb-0">@lang('Daily volume')</h6>
                </div>
                <div class="card-body p-0">
                    <table class="table table--light style--two mb-0">
                        <thead>
                            <tr>
                                <th>@lang('Day')</th>
                                <th class="text-end">@lang('Questions')</th>
                                <th class="text-end">@lang('Cost')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($daily as $row)
                                <tr>
                                    <td>{{ $row->day }}</td>
                                    <td class="text-end">{{ $row->hits }}</td>
                                    <td class="text-end">
                                        {{ $row->cost > 0 ? '$' . number_format($row->cost, 4) : '—' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center text-muted" colspan="100%">@lang('No activity yet')</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <div class="flex-wrap gap-2 d-flex">
        <a href="{{ route('admin.assistant.knowledge') }}" class="btn btn-outline-primary">
            <i class="bi bi-database pe-1"></i>@lang('Knowledge Base')
        </a>
        <a href="{{ route('admin.assistant.providers.index') }}" class="btn btn-primary">
            <i class="bi bi-cpu pe-1"></i>@lang('Providers')
        </a>
    </div>
@endpush
