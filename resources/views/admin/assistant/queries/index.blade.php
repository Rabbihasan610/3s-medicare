@extends('admin.layouts.app', ['title' => $pageTitle])
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Question')</th>
                                    <th>@lang('Lang')</th>
                                    <th>@lang('Result')</th>
                                    <th>@lang('Served')</th>
                                    <th>@lang('Cost')</th>
                                    <th>@lang('Feedback')</th>
                                    <th>@lang('Asked')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($queries as $query)
                                    <tr>
                                        <td style="max-width:340px">
                                            <a href="{{ route('admin.assistant.queries.show', $query->id) }}">
                                                {{ str()->limit($query->query, 90) }}
                                            </a>
                                            @if ($query->suggested_route)
                                                <br><small class="text-muted">
                                                    <i class="bi bi-arrow-right-short"></i>{{ $query->suggested_route }}
                                                </small>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-secondary text-uppercase">{{ $query->lang }}</span></td>
                                        <td>@php echo $query->statusBadge @endphp</td>
                                        <td>
                                            @php echo $query->cacheBadge @endphp
                                            <br><small class="text-muted">{{ $query->latency_ms }} ms</small>
                                        </td>
                                        <td>
                                            @if ($query->cost_usd > 0)
                                                ${{ number_format($query->cost_usd, 5) }}
                                            @else
                                                <span class="text-muted">&mdash;</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($query->feedback === 1)
                                                <i class="bi bi-hand-thumbs-up-fill text-success"></i>
                                            @elseif ($query->feedback === 0)
                                                <i class="bi bi-hand-thumbs-down-fill text-danger"></i>
                                            @else
                                                <span class="text-muted">&mdash;</span>
                                            @endif
                                        </td>
                                        <td>{{ diffForHumans($query->created_at) }}</td>
                                        <td>
                                            <a href="{{ route('admin.assistant.queries.show', $query->id) }}"
                                                class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-muted" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($queries->hasPages())
                    <div class="card-footer pagination-card-footer">
                        {{ paginateLinks($queries) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    {{-- One GET form so the text search, the filters and the date range submit
         together - the Searchable trait reads them all off the query string. --}}
    <form action="" method="GET" class="flex-wrap gap-2 d-flex">
        <div class="input-group w-auto flex-fill">
            <input type="search" name="search" class="form-control" placeholder="@lang('Search questions')"
                value="{{ request()->search }}">
            <button class="btn btn-primary" type="submit"><i class="la la-search"></i></button>
        </div>

        <select class="form-control w-auto" name="status" onchange="this.form.submit()">
            <option value="">@lang('All results')</option>
            <option value="ok" @selected(request()->status === 'ok')>@lang('Answered')</option>
            <option value="no_answer" @selected(request()->status === 'no_answer')>@lang('No answer')</option>
            <option value="error" @selected(request()->status === 'error')>@lang('Error')</option>
        </select>

        <select class="form-control w-auto" name="lang" onchange="this.form.submit()">
            <option value="">@lang('All languages')</option>
            <option value="en" @selected(request()->lang === 'en')>@lang('English')</option>
            <option value="ar" @selected(request()->lang === 'ar')>@lang('Arabic')</option>
        </select>

        <x-search-date-field />
    </form>
@endpush
