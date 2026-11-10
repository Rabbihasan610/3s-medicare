@extends('admin.layouts.app', ['title' => $pageTitle])

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 mb-4">
                <div class="card-body p-3">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div class="btn-group flex-wrap gap-1" role="group">
                            <a href="{{ route('admin.service.index') }}" class="btn btn-sm {{ !request('group') || request('group') == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                                @lang('All Groups')
                            </a>
                            <a href="{{ route('admin.service.index', ['group' => 'digital_presence']) }}" class="btn btn-sm {{ request('group') == 'digital_presence' ? 'btn-primary' : 'btn-outline-primary' }}">
                                @lang('Digital Presence')
                            </a>
                            <a href="{{ route('admin.service.index', ['group' => 'marketing_creative']) }}" class="btn btn-sm {{ request('group') == 'marketing_creative' ? 'btn-primary' : 'btn-outline-primary' }}">
                                @lang('Marketing & Creative')
                            </a>
                            <a href="{{ route('admin.service.index', ['group' => 'patient_services']) }}" class="btn btn-sm {{ request('group') == 'patient_services' ? 'btn-primary' : 'btn-outline-primary' }}">
                                @lang('Patient Services')
                            </a>
                        </div>

                        <form action="{{ route('admin.service.index') }}" method="GET" class="d-flex gap-2">
                            @if(request('group'))
                                <input type="hidden" name="group" value="{{ request('group') }}">
                            @endif
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="@lang('Search title or group...')" value="{{ request('search') }}">
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
                                    <th>@lang('Service Title')</th>
                                    <th>@lang('Group')</th>
                                    <th>@lang('Short Description')</th>
                                    <th>@lang('Order')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $svc)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div class="avatar avatar-sm bg-light text-primary rounded p-2">
                                                    <i class="bi {{ $svc->icon ?? 'bi-window' }}"></i>
                                                </div>
                                                <span class="fw-bold">{{ $svc->title }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $svc->group_name }}</span>
                                        </td>
                                        <td>
                                            <span class="small text-muted">{{ \Illuminate\Support\Str::limit($svc->short_description, 60) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">{{ $svc->sort_order }}</span>
                                        </td>
                                        <td>
                                            @if($svc->is_active)
                                                <span class="badge bg-success">@lang('Active')</span>
                                            @else
                                                <span class="badge bg-danger">@lang('Inactive')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-bs-toggle="dropdown">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button class="dropdown-item editBtn"
                                                            data-id="{{ $svc->id }}"
                                                            data-title="{{ $svc->title }}"
                                                            data-group_key="{{ $svc->group_key }}"
                                                            data-icon="{{ $svc->icon }}"
                                                            data-short_description="{{ $svc->short_description }}"
                                                            data-description="{{ $svc->description }}"
                                                            data-sort_order="{{ $svc->sort_order }}"
                                                            data-is_active="{{ $svc->is_active ? 1 : 0 }}">
                                                            <i class="la la-pencil-alt text-primary"></i> @lang('Edit')
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('admin.service.status', $svc->id) }}" class="dropdown-item">
                                                            <i class="la la-toggle-{{ $svc->is_active ? 'on text-success' : 'off text-warning' }}"></i>
                                                            {{ $svc->is_active ? __('Disable') : __('Enable') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item confirmationBtn"
                                                            data-action="{{ route('admin.service.delete', $svc->id) }}"
                                                            data-question="@lang('Are you sure to delete this service permanently?')">
                                                            <i class="la la-trash text-danger"></i> @lang('Delete')
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-muted" colspan="100%">@lang('No services found')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($services->hasPages())
                    <div class="card-footer pagination-card-footer">
                        {{ paginateLinks($services) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- SERVICE MODAL (CREATE / EDIT) --}}
    <div class="modal fade" id="serviceModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">@lang('Add New Service')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="serviceForm" action="{{ route('admin.service.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">@lang('Service Title') <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="serviceTitle" class="form-control" required placeholder="@lang('e.g. Website Development')">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">@lang('Bootstrap Icon')</label>
                                <input type="text" name="icon" id="serviceIcon" class="form-control" placeholder="@lang('e.g. bi-window')">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">@lang('Service Group') <span class="text-danger">*</span></label>
                                <select name="group_key" id="serviceGroup" class="form-select" required>
                                    @foreach($groups as $key => $name)
                                        <option value="{{ $key }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-bold">@lang('Sort Order')</label>
                                <input type="number" name="sort_order" id="serviceSortOrder" class="form-control" value="0">
                            </div>
                            <div class="col-md-3 d-flex align-items-center pt-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_active" id="serviceIsActive" value="1" checked>
                                    <label class="form-check-label fw-bold ms-1" for="serviceIsActive">@lang('Active')</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">@lang('Short Description') <span class="text-danger">*</span></label>
                                <input type="text" name="short_description" id="serviceShortDesc" class="form-control" required placeholder="@lang('Brief single sentence summary for lists and cards')">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">@lang('Full Detailed Description')</label>
                                <textarea name="description" id="serviceFullDesc" class="form-control" rows="4" placeholder="@lang('Complete service description for services catalog page')"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit" class="btn btn-primary" id="modalSubmitBtn">@lang('Save Service')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-sm btn-outline-primary addBtn">
        <i class="las la-plus"></i> @lang('Add New Service')
    </button>
@endpush

@push('script')
<script>
    (function($){
        "use strict";

        $('.addBtn').on('click', function(){
            $('#modalTitle').text('@lang("Add New Service")');
            $('#serviceForm').attr('action', '{{ route("admin.service.store") }}');
            $('#serviceTitle').val('');
            $('#serviceIcon').val('bi-window');
            $('#serviceGroup').val('digital_presence');
            $('#serviceSortOrder').val('0');
            $('#serviceIsActive').prop('checked', true);
            $('#serviceShortDesc').val('');
            $('#serviceFullDesc').val('');
            $('#modalSubmitBtn').text('@lang("Save Service")');
            $('#serviceModal').modal('show');
        });

        $('.editBtn').on('click', function(){
            let id = $(this).data('id');
            $('#modalTitle').text('@lang("Edit Service")');
            $('#serviceForm').attr('action', '{{ url("admin/services/store") }}/' + id);
            $('#serviceTitle').val($(this).data('title'));
            $('#serviceIcon').val($(this).data('icon'));
            $('#serviceGroup').val($(this).data('group_key'));
            $('#serviceSortOrder').val($(this).data('sort_order'));
            $('#serviceIsActive').prop('checked', $(this).data('is_active') == 1);
            $('#serviceShortDesc').val($(this).data('short_description'));
            $('#serviceFullDesc').val($(this).data('description'));
            $('#modalSubmitBtn').text('@lang("Update Service")');
            $('#serviceModal').modal('show');
        });
    })(jQuery);
</script>
@endpush

