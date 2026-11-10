@extends('admin.layouts.app', ['title' => $pageTitle])

@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10 mb-4">
                <div class="card-body p-3">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div class="btn-group flex-wrap gap-1" role="group">
                            <a href="{{ route('admin.project.index') }}" class="btn btn-sm {{ !request('category') || request('category') == 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                                @lang('All Categories')
                            </a>
                            @foreach($categories as $cat)
                                <a href="{{ route('admin.project.index', ['category' => $cat]) }}" class="btn btn-sm {{ request('category') == $cat ? 'btn-primary' : 'btn-outline-primary' }}">
                                    {{ __($cat) }}
                                </a>
                            @endforeach
                        </div>

                        <form action="{{ route('admin.project.index') }}" method="GET" class="d-flex gap-2">
                            @if(request('category'))
                                <input type="hidden" name="category" value="{{ request('category') }}">
                            @endif
                            <input type="text" name="search" class="form-control form-control-sm" placeholder="@lang('Search title or client...')" value="{{ request('search') }}">
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
                                    <th>@lang('Project')</th>
                                    <th>@lang('Client')</th>
                                    <th>@lang('Category')</th>
                                    <th>@lang('Featured')</th>
                                    <th>@lang('Order')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($projects as $p)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <img src="{{ asset($p->thumbnail) }}" alt="{{ $p->title }}" class="rounded" style="width: 60px; height: 42px; object-fit: cover;">
                                                <div>
                                                    <span class="fw-bold d-block">{{ $p->title }}</span>
                                                    @if($p->live_url)
                                                        <a href="{{ $p->live_url }}" target="_blank" class="small text-primary text-decoration-none">
                                                            <i class="bi bi-box-arrow-up-right me-1"></i>@lang('Live Preview')
                                                        </a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $p->client_name ?? '—' }}</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $p->category }}</span>
                                        </td>
                                        <td>
                                            @if($p->is_featured)
                                                <span class="badge bg-success"><i class="bi bi-star-fill me-1"></i>@lang('Featured')</span>
                                            @else
                                                <span class="badge bg-light text-muted border">@lang('Standard')</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark border">{{ $p->sort_order }}</span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-bs-toggle="dropdown">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button class="dropdown-item editBtn"
                                                            data-id="{{ $p->id }}"
                                                            data-title="{{ $p->title }}"
                                                            data-client_name="{{ $p->client_name }}"
                                                            data-category="{{ $p->category }}"
                                                            data-thumbnail="{{ $p->thumbnail }}"
                                                            data-summary="{{ $p->summary }}"
                                                            data-live_url="{{ $p->live_url }}"
                                                            data-sort_order="{{ $p->sort_order }}"
                                                            data-is_featured="{{ $p->is_featured ? 1 : 0 }}">
                                                            <i class="la la-pencil-alt text-primary"></i> @lang('Edit')
                                                        </button>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('admin.project.featured', $p->id) }}" class="dropdown-item">
                                                            <i class="la la-star text-warning"></i>
                                                            {{ $p->is_featured ? __('Unmark Featured') : __('Mark as Featured') }}
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <button class="dropdown-item confirmationBtn"
                                                            data-action="{{ route('admin.project.delete', $p->id) }}"
                                                            data-question="@lang('Are you sure to delete this case study?')">
                                                            <i class="la la-trash text-danger"></i> @lang('Delete')
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center text-muted" colspan="100%">@lang('No projects found')</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($projects->hasPages())
                    <div class="card-footer pagination-card-footer">
                        {{ paginateLinks($projects) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- PROJECT MODAL (CREATE / EDIT) --}}
    <div class="modal fade" id="projectModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">@lang('Add New Case Study')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="projectForm" action="{{ route('admin.project.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold">@lang('Project Title') <span class="text-danger">*</span></label>
                                <input type="text" name="title" id="projectTitle" class="form-control" required placeholder="@lang('e.g. Modern Clinic Digital Presence & Booking')">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">@lang('Client Name')</label>
                                <input type="text" name="client_name" id="projectClient" class="form-control" placeholder="@lang('e.g. MediHealth Clinic')">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">@lang('Category') <span class="text-danger">*</span></label>
                                <select name="category" id="projectCategory" class="form-select" required>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat }}">{{ $cat }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">@lang('Live URL')</label>
                                <input type="text" name="live_url" id="projectUrl" class="form-control" placeholder="@lang('https://example.com')">
                            </div>
                            <div class="col-md-8">
                                <label class="form-label fw-bold">@lang('Thumbnail Image Path')</label>
                                <input type="text" name="thumbnail" id="projectThumb" class="form-control" value="assets/images/3s/work-showcase.jpg" placeholder="@lang('assets/images/3s/work-showcase.jpg')">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label fw-bold">@lang('Sort Order')</label>
                                <input type="number" name="sort_order" id="projectSortOrder" class="form-control" value="0">
                            </div>
                            <div class="col-md-2 d-flex align-items-center pt-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="is_featured" id="projectIsFeatured" value="1" checked>
                                    <label class="form-check-label fw-bold ms-1" for="projectIsFeatured">@lang('Featured')</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold">@lang('Project Summary / Description') <span class="text-danger">*</span></label>
                                <textarea name="summary" id="projectSummary" class="form-control" rows="4" required placeholder="@lang('Explain the results, metrics achieved, and solutions implemented')"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Cancel')</button>
                        <button type="submit" class="btn btn-primary" id="modalSubmitBtn">@lang('Save Project')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-sm btn-outline-primary addBtn">
        <i class="las la-plus"></i> @lang('Add New Case Study')
    </button>
@endpush

@push('script')
<script>
    (function($){
        "use strict";

        $('.addBtn').on('click', function(){
            $('#modalTitle').text('@lang("Add New Case Study")');
            $('#projectForm').attr('action', '{{ route("admin.project.store") }}');
            $('#projectTitle').val('');
            $('#projectClient').val('');
            $('#projectCategory').val('Clinic');
            $('#projectUrl').val('');
            $('#projectThumb').val('assets/images/3s/work-showcase.jpg');
            $('#projectSortOrder').val('0');
            $('#projectIsFeatured').prop('checked', true);
            $('#projectSummary').val('');
            $('#modalSubmitBtn').text('@lang("Save Project")');
            $('#projectModal').modal('show');
        });

        $('.editBtn').on('click', function(){
            let id = $(this).data('id');
            $('#modalTitle').text('@lang("Edit Case Study")');
            $('#projectForm').attr('action', '{{ url("admin/projects/store") }}/' + id);
            $('#projectTitle').val($(this).data('title'));
            $('#projectClient').val($(this).data('client_name'));
            $('#projectCategory').val($(this).data('category'));
            $('#projectUrl').val($(this).data('live_url'));
            $('#projectThumb').val($(this).data('thumbnail'));
            $('#projectSortOrder').val($(this).data('sort_order'));
            $('#projectIsFeatured').prop('checked', $(this).data('is_featured') == 1);
            $('#projectSummary').val($(this).data('summary'));
            $('#modalSubmitBtn').text('@lang("Update Project")');
            $('#projectModal').modal('show');
        });
    })(jQuery);
</script>
@endpush

