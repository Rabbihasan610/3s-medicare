@extends('admin.layouts.app', ['title' => $pageTitle])

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 mb-4">
                <div class="card-body p-3">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div class="btn-group flex-wrap gap-1" role="group">
                            <a href="{{ route('admin.quote_request.index') }}" class="btn btn-sm {{ !request('status') || request('status') == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                                @lang('All')
                            </a>
                            <a href="{{ route('admin.quote_request.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') == 'pending' ? 'btn-warning' : 'btn-outline-warning' }}">
                                @lang('Pending') @if(@$pendingCount) <span class="badge bg-danger">{{ $pendingCount }}</span> @endif
                            </a>
                            <a href="{{ route('admin.quote_request.index', ['status' => 'contacted']) }}" class="btn btn-sm {{ request('status') == 'contacted' ? 'btn-info' : 'btn-outline-info' }}">
                                @lang('Contacted')
                            </a>
                            <a href="{{ route('admin.quote_request.index', ['status' => 'completed']) }}" class="btn btn-sm {{ request('status') == 'completed' ? 'btn-success' : 'btn-outline-success' }}">
                                @lang('Completed')
                            </a>
                            <a href="{{ route('admin.quote_request.index', ['status' => 'rejected']) }}" class="btn btn-sm {{ request('status') == 'rejected' ? 'btn-danger' : 'btn-outline-danger' }}">
                                @lang('Rejected')
                            </a>
                        </div>

                        <form action="{{ route('admin.quote_request.index') }}" method="GET" class="d-flex gap-2">
                            @if(request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="@lang('Search name, email, phone...')" value="{{ request('search') }}">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="bi bi-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead class="table-light">
                                <tr>
                                    <th>@lang('Client Name')</th>
                                    <th>@lang('Contact')</th>
                                    <th>@lang('Practice Type')</th>
                                    <th>@lang('Services')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Submitted At')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($quotes as $quote)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{ $quote->name }}</span>
                                        </td>
                                        <td>
                                            <div class="small">
                                                <div><i class="bi bi-envelope text-muted"></i> {{ $quote->email }}</div>
                                                @if($quote->phone)
                                                    <div><i class="bi bi-telephone text-muted"></i> {{ $quote->phone }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $quote->category ?: ($quote->client_type ?: __('General')) }}</span>
                                        </td>
                                        <td>
                                            @if($quote->services && is_array($quote->services))
                                                @foreach(array_slice($quote->services, 0, 2) as $s)
                                                    <span class="badge bg-light text-dark border">{{ $s }}</span>
                                                @endforeach
                                                @if(count($quote->services) > 2)
                                                    <span class="badge bg-light text-muted border">+{{ count($quote->services) - 2 }}</span>
                                                @endif
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($quote->status == 'pending')
                                                <span class="badge bg-warning text-dark">@lang('Pending')</span>
                                            @elseif($quote->status == 'contacted')
                                                <span class="badge bg-info">@lang('Contacted')</span>
                                            @elseif($quote->status == 'completed')
                                                <span class="badge bg-success">@lang('Completed')</span>
                                            @else
                                                <span class="badge bg-danger">@lang('Rejected')</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ showDateTime($quote->created_at) }}<br>
                                            <small class="text-muted">{{ diffForHumans($quote->created_at) }}</small>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-bs-toggle="dropdown">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a href="{{ route('admin.quote_request.detail', $quote->id) }}" class="dropdown-item">
                                                            <i class="la la-eye text-primary"></i> @lang('View Details')
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item confirmationBtn"
                                                            data-action="{{ route('admin.quote_request.delete', $quote->id) }}"
                                                            data-question="@lang('Are you sure to remove this quote request?')">
                                                            <i class="la la-trash text-danger"></i> @lang('Delete')
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-muted" colspan="100%">@lang('No quote requests found')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($quotes->hasPages())
                    <div class="card-footer pagination-card-footer">
                        {{ paginateLinks($quotes) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

