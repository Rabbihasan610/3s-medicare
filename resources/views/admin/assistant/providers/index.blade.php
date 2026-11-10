@extends('admin.layouts.app', ['title' => $pageTitle])
@section('panel')
    <div class="row">
        <div class="col-lg-12">

            <div class="alert alert-info" role="alert">
                <i class="bi bi-info-circle pe-1"></i>
                @lang('Two roles are registered separately. A "chat" provider writes the answers; an "embedding" provider turns site content and visitor questions into vectors. Within each role the lowest priority number is tried first, and the next one takes over if it fails.')
            </div>

            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Role')</th>
                                    <th>@lang('Model')</th>
                                    <th>@lang('Priority')</th>
                                    <th>@lang('Health')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($providers as $provider)
                                    <tr>
                                        <td>
                                            <strong>{{ $provider->name }}</strong>
                                            <br><small class="text-muted">{{ $provider->driver }}</small>
                                        </td>
                                        <td>
                                            @if ($provider->purpose == 'chat')
                                                <span class="badge bg-primary">@lang('Answers')</span>
                                            @else
                                                <span class="badge bg-info">@lang('Embeddings')</span>
                                            @endif
                                        </td>
                                        <td><code>{{ $provider->model }}</code></td>
                                        <td>{{ $provider->priority }}</td>
                                        <td>
                                            @if (!$provider->hasKey())
                                                <span class="badge bg-danger">@lang('No API key')</span>
                                            @elseif ($provider->last_error)
                                                <span class="badge bg-danger" data-bs-toggle="tooltip"
                                                    title="{{ $provider->last_error }}">@lang('Failing')</span>
                                            @elseif ($provider->last_check_at)
                                                <span class="badge bg-success">@lang('OK')</span>
                                                <br><small class="text-muted">{{ diffForHumans($provider->last_check_at) }}</small>
                                            @else
                                                <span class="badge bg-secondary">@lang('Not tested')</span>
                                            @endif
                                        </td>
                                        <td>@php echo $provider->statusBadge @endphp</td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-bs-toggle="dropdown" class="btn btn-sm btn-outline-primary">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a href="{{ route('admin.assistant.providers.edit', $provider->id) }}">
                                                            <i class="bi bi-pencil"></i>@lang('Edit')
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button class="confirmationBtn"
                                                            data-question="@lang('Send a test request to this provider now?')"
                                                            data-action="{{ route('admin.assistant.providers.test', $provider->id) }}">
                                                            <i class="bi bi-plug pe-1"></i>@lang('Test connection')
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="confirmationBtn"
                                                            data-question="{{ $provider->status ? __('Disable this provider?') : __('Enable this provider?') }}"
                                                            data-action="{{ route('admin.assistant.providers.status', $provider->id) }}">
                                                            <i class="bi bi-toggle-on pe-1"></i>
                                                            {{ $provider->status ? __('Disable') : __('Enable') }}
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <button class="confirmationBtn"
                                                            data-question="@lang('Remove this provider permanently?')"
                                                            data-action="{{ route('admin.assistant.providers.destroy', $provider->id) }}">
                                                            <i class="bi bi-trash pe-1"></i>@lang('Delete')
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
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
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.assistant.providers.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg pe-2"></i>@lang('Add Provider')
    </a>
@endpush
