@extends('admin.layouts.app', ['title' => $pageTitle])
@section('panel')

    @if ($stats['chunks'] > 0 && $stats['embedded'] < $stats['chunks'])
        <div class="alert alert-warning">
            <i class="bi bi-exclamation-triangle pe-1"></i>
            {{ __(':missing chunk(s) have no vector, so those fall back to keyword search only. Check the embedding provider, then reindex.', ['missing' => $stats['chunks'] - $stats['embedded']]) }}
        </div>
    @endif

    <div class="row gy-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted text-uppercase">@lang('Documents')</small>
                    <h3 class="mb-0">{{ number_format($stats['documents']) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted text-uppercase">@lang('Chunks')</small>
                    <h3 class="mb-0">{{ number_format($stats['chunks']) }}</h3>
                    <small class="text-muted">
                        {{ number_format($stats['en_chunks']) }} EN · {{ number_format($stats['ar_chunks']) }} AR
                    </small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted text-uppercase">@lang('With vectors')</small>
                    <h3 class="mb-0">{{ number_format($stats['embedded']) }}</h3>
                    <small class="text-muted">@lang('Version') {{ $stats['version'] }}</small>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6">
            <div class="card h-100">
                <div class="card-body">
                    <small class="text-muted text-uppercase">@lang('Last indexed')</small>
                    <h3 class="mb-0 h5 pt-2">
                        {{ $stats['indexed_at'] ? diffForHumans($stats['indexed_at']) : __('Never') }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Title')</th>
                                    <th>@lang('Source')</th>
                                    <th>@lang('Suggested route')</th>
                                    <th class="text-end">@lang('Chunks')</th>
                                    <th>@lang('Indexed')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($documents as $document)
                                    <tr>
                                        <td>
                                            @if ($document->url)
                                                <a href="{{ $document->url }}" target="_blank">{{ $document->title }}</a>
                                            @else
                                                {{ $document->title }}
                                            @endif
                                            @if ($document->title_ar)
                                                <br><small class="text-muted" dir="rtl">{{ $document->title_ar }}</small>
                                            @endif
                                        </td>
                                        <td><span class="badge bg-secondary">{{ $document->source_type }}</span></td>
                                        <td>
                                            <small>{{ $document->route_name ?: '—' }}</small>
                                        </td>
                                        <td class="text-end">{{ $document->chunks_count }}</td>
                                        <td>{{ $document->indexed_at ? diffForHumans($document->indexed_at) : '—' }}</td>
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
                @if ($documents->hasPages())
                    <div class="card-footer pagination-card-footer">
                        {{ paginateLinks($documents) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <div class="flex-wrap gap-2 d-flex">
        <form action="" method="GET" class="gap-2 d-flex">
            <input type="search" name="search" class="form-control" placeholder="@lang('Search documents')"
                value="{{ request()->search }}">
            <select class="form-control w-auto" name="source_type" onchange="this.form.submit()">
                <option value="">@lang('All sources')</option>
                @foreach (['service' => 'Services', 'sector' => 'Sectors', 'section' => 'Page sections', 'blog' => 'Blog'] as $value => $label)
                    <option value="{{ $value }}" @selected(request()->source_type === $value)>{{ __($label) }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary" type="submit"><i class="la la-search"></i></button>
        </form>

        <form action="{{ route('admin.assistant.knowledge.reindex') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-primary">
                <i class="bi bi-arrow-repeat pe-1"></i>@lang('Reindex changed')
            </button>
        </form>

        <button class="btn btn-dark confirmationBtn"
            data-question="@lang('Rebuild the whole knowledge base? Every chunk is re-embedded, which takes time and costs embedding tokens.')"
            data-action="{{ route('admin.assistant.knowledge.reindex') }}?fresh=1">
            <i class="bi bi-arrow-clockwise pe-1"></i>@lang('Full rebuild')
        </button>
    </div>
@endpush
