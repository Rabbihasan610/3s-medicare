@extends('admin.layouts.app', ['title' => $pageTitle])

@section('panel')
    <div class="row gy-4">
        <div class="col-xl-8 col-lg-7">
            <div class="card b-radius--10 mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-person-circle text-primary me-2"></i>{{ $quote->name }}
                    </h5>
                    @if($quote->status == 'pending')
                        <span class="badge bg-warning text-dark px-3 py-2">@lang('Pending')</span>
                    @elseif($quote->status == 'contacted')
                        <span class="badge bg-info px-3 py-2">@lang('Contacted')</span>
                    @elseif($quote->status == 'completed')
                        <span class="badge bg-success px-3 py-2">@lang('Completed')</span>
                    @else
                        <span class="badge bg-danger px-3 py-2">@lang('Rejected')</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <label class="text-muted small">@lang('Email Address')</label>
                            <p class="fw-bold mb-0">
                                <a href="mailto:{{ $quote->email }}" class="text-decoration-none">
                                    <i class="bi bi-envelope me-1"></i>{{ $quote->email }}
                                </a>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small">@lang('Phone Number')</label>
                            <p class="fw-bold mb-0">
                                @if($quote->phone)
                                    <a href="tel:{{ $quote->phone }}" class="text-decoration-none">
                                        <i class="bi bi-telephone me-1"></i>{{ $quote->phone }}
                                    </a>
                                @else
                                    <span class="text-muted">@lang('Not provided')</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small">@lang('Healthcare Practice Type')</label>
                            <p class="fw-bold mb-0">
                                <span class="badge bg-primary px-2 py-1">{{ $quote->category ?: ($quote->client_type ?: __('General Practice')) }}</span>
                            </p>
                        </div>
                        <div class="col-sm-6">
                            <label class="text-muted small">@lang('Submitted On')</label>
                            <p class="fw-bold mb-0">
                                {{ showDateTime($quote->created_at, 'd M, Y - h:i A') }}
                                <small class="text-muted">({{ diffForHumans($quote->created_at) }})</small>
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-muted small d-block mb-2">@lang('Services of Interest')</label>
                        <div>
                            @if($quote->services && is_array($quote->services))
                                @foreach($quote->services as $service)
                                    <span class="badge bg-light text-dark border px-3 py-2 me-1 mb-1 fs-6">
                                        <i class="bi bi-check2-circle text-primary me-1"></i>{{ $service }}
                                    </span>
                                @endforeach
                            @else
                                <span class="text-muted">@lang('No specific service checked')</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="text-muted small d-block mb-2">@lang('Client Message & Requirements')</label>
                        <div class="p-3 bg-light rounded border" style="white-space: pre-wrap; font-size: 0.95rem; line-height: 1.6;">
                            {{ $quote->message }}
                        </div>
                    </div>

                    @if($quote->ip_address)
                        <div class="text-muted small pt-2">
                            <i class="bi bi-shield-check me-1"></i>@lang('Sender IP'): <code>{{ $quote->ip_address }}</code>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-5">
            <div class="card b-radius--10">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0">@lang('Manage Lead')</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.quote_request.update', $quote->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">@lang('Lead Status')</label>
                            <select name="status" class="form-select">
                                <option value="pending" {{ $quote->status == 'pending' ? 'selected' : '' }}>@lang('Pending')</option>
                                <option value="contacted" {{ $quote->status == 'contacted' ? 'selected' : '' }}>@lang('Contacted')</option>
                                <option value="completed" {{ $quote->status == 'completed' ? 'selected' : '' }}>@lang('Completed')</option>
                                <option value="rejected" {{ $quote->status == 'rejected' ? 'selected' : '' }}>@lang('Rejected')</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">@lang('Internal Admin Notes')</label>
                            <textarea name="admin_notes" class="form-control" rows="5" placeholder="@lang('Add internal team notes, follow-up dates, call summaries...')">{{ $quote->admin_notes }}</textarea>
                            <small class="text-muted">@lang('Visible only to admin team.')</small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-check2-circle me-1"></i>@lang('Update Status & Notes')
                        </button>
                    </form>
                </div>
                <div class="card-footer bg-white border-top">
                    <button class="btn btn-outline-danger w-100 confirmationBtn"
                        data-action="{{ route('admin.quote_request.delete', $quote->id) }}"
                        data-question="@lang('Are you sure to delete this lead record permanently?')">
                        <i class="la la-trash"></i> @lang('Delete Quote Request')
                    </button>
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <a href="{{ route('admin.quote_request.index') }}" class="btn btn-sm btn-outline-primary">
        <i class="la la-arrow-left"></i> @lang('Back to All Requests')
    </a>
@endpush

