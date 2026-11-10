@php
    $pageTitle = 'Order Details';
@endphp

@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Order #{{ $order->id }}</h5>
                    <span class="badge bg-{{ $order->status == 'approved' ? 'success' : ($order->status == 'rejected' ? 'danger' : 'warning') }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>

            <!-- Service Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Service Information</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th width="30%" class="bg-light">@lang('Service Type')</th>
                                    <td>{{ $order->type }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">@lang('Service Name')</th>
                                    <td>{{ $order?->service($order->type, $order->service_id)?->title ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">@lang('Order Date')</th>
                                    <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                </tr>
                                <tr>
                                    <th class="bg-light">@lang('Last Updated')</th>
                                    <td>{{ $order->updated_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Form Data -->
            @if($order->form_data && count(json_decode($order->form_data, true) ?? []) > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-list-alt me-2"></i>Form Details</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th width="40%">@lang('Field')</th>
                                    <th>@lang('Value')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(json_decode($order->form_data, true) ?? [] as $key => $value)
                                    <tr>
                                        <th class="bg-light">{{ ucfirst(str_replace('_',' ',$key)) }}</th>
                                        <td>{{ $value ?? 'Not Provided' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Checkbox Data -->
            @if($order->form_checkbox && count(json_decode($order->form_checkbox, true) ?? []) > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-check-square me-2"></i>Selected Options</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th width="40%">@lang('Option Category')</th>
                                    <th>@lang('Selected Values')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(json_decode($order->form_checkbox, true) ?? [] as $key => $values)
                                    <tr>
                                        <th class="bg-light">{{ ucfirst(str_replace('_',' ',$key)) }}</th>
                                        <td>
                                            @if(is_array($values) && count($values) > 0)
                                                @foreach($values as $value)
                                                    <span class="badge bg-primary me-1 mb-1">{{ $value }}</span>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No options selected</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Radio Button Data -->
            @if($order->form_radio && count(json_decode($order->form_radio, true) ?? []) > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-dot-circle me-2"></i>Single Selections</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th width="40%">@lang('Field')</th>
                                    <th>@lang('Selected Value')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(json_decode($order->form_radio, true) ?? [] as $key => $value)
                                    <tr>
                                        <th class="bg-light">{{ ucfirst(str_replace('_',' ',$key)) }}</th>
                                        <td>
                                            <span class="badge bg-info">{{ $value }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- File Attachments -->
            @if($order->form_file && count(json_decode($order->form_file, true) ?? []) > 0)
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-paperclip me-2"></i>File Attachments</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th width="40%">@lang('Attachment Type')</th>
                                    <th>@lang('Files')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(json_decode($order->form_file, true) ?? [] as $key => $files)
                                    <tr>
                                        <th class="bg-light">{{ ucfirst(str_replace('_',' ',$key)) }}</th>
                                        <td>
                                            @if(is_array($files) && count($files) > 0)
                                                @foreach($files as $index => $file)
                                                    <div class="file-item mb-2">
                                                        <a href="{{ asset('storage/'.$file) }}" 
                                                           target="_blank" 
                                                           class="btn btn-sm btn-outline-primary d-inline-flex align-items-center">
                                                            <i class="fas fa-download me-1"></i>
                                                            Download File {{ $index + 1 }}
                                                        </a>
                                                        <small class="text-muted ms-2">
                                                            ({{ pathinfo($file, PATHINFO_EXTENSION) }} file)
                                                        </small>
                                                    </div>
                                                @endforeach
                                            @else
                                                <span class="text-muted">No files attached</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Status Update Form -->
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fas fa-cog me-2"></i>Update Order Status</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.request_order.update', $order->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Current Status</label>
                                    <div class="alert alert-{{ $order->status == 'approved' ? 'success' : ($order->status == 'rejected' ? 'danger' : 'warning') }} mb-0">
                                        <strong>{{ ucfirst($order->status) }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Update Status</label>
                                    <select name="status" class="form-select">
                                        <option value="pending" @if($order->status=='pending') selected @endif>Pending</option>
                                        <option value="approved" @if($order->status=='approved') selected @endif>Approved</option>
                                        <option value="rejected" @if($order->status=='rejected') selected @endif>Rejected</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2 mt-4">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-save me-1"></i>Update Status
                            </button>
                            <a href="{{ route('admin.request_order.index', ['type' => $order->type]) }}" 
                               class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back To List
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        .table th {
            font-weight: 600;
        }
        .badge {
            font-size: 0.75em;
        }
        .file-item {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }
    </style>
@endsection