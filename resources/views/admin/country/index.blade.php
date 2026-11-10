@extends('admin.layouts.app', ['title' => 'Countries'])
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive--md table-responsive">
                        <table class="table">
                            <thead class="table-light">
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Name Arabic')</th>
                                    <th>@lang('Cities')</th>
                                    <th>@lang('Sort order')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>

                                @forelse($countries as $country)
                                    <tr>
                                        <td>
                                            {{ $country->name }}
                                        </td>
                                        <td>
                                            {{ $country->name_ar }}
                                        </td>
                                        <td>
                                            <a href="#"
                                                class="badge bg-primary rounded-pill ms-auto">{{ $country->city_count }}</a>
                                        </td>

                                        <td>
                                            {{ $country->sort_order }}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button data-bs-toggle="dropdown">
                                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <button class="cuModalBtn" data-modal_title="@lang('Update Country')"
                                                            data-resource="{{ $country }}">
                                                            <i class="bi bi-pencil"></i>@lang('Edit')
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
                @if ($countries->hasPages())
                    <div class="card-footer pagination-card-footer">
                        {{ paginateLinks($countries) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="cuModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"></h6>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.country.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3 form-group">
                            <label class="form-label">@lang('Name') <span class="text-danger fs-6">*</span></label>
                            <select name="name" class="form-control select2-basic" required>
                                @foreach ($countriesAll as $key => $country)
                                    <option value="{{ $country->country }}">{{ __($country->country) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 form-group">
                            <label class="form-label">@lang('Name Arabic') <span class="text-danger fs-6">*</span></label>
                            <input class="form-control" name="name_ar" type="text" required>
                        </div>

                        <div class="mb-3 form-group">
                            <label class="form-label">@lang('Sort order')</label>
                            <input class="form-control" name="sort_order" type="number">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary w-100" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('breadcrumb-plugins')
    <div class="flex-wrap gap-3 d-flex">
        <x-search-form placeholder="Search" />
        <div>
            <button class="btn btn-primary cuModalBtn" data-modal_title="@lang('Add Country')"><i
                    class="fa-solid fa-plus"></i> @lang('Add New')</button>
        </div>
    </div>
@endpush

@push('script')
    <script>
        $('.select2-basic').select2({
            dropdownParent: $('#cuModal')
        });
    </script>
@endpush
