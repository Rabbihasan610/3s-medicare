@extends('admin.layouts.app', ['title' => 'Category List'])
@section('panel')
    <div class="container-fluid">
        <div class="pb-2 mb-2 page-breadcrumb d-flex align-items-center border-bottom">

            <div class="ms-auto">
                <a href="{{ route('admin.category.create') }}" type="button" class="btn btn-primary btn-sm"> <i
                        class="bi bi-plus-circle"></i> @lang('Create New Category')</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Subscribe')</th>
                                <th>@lang('Type')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->title }}</td>
                                    <td>{{ $item->type }}</td>
                                    <td>
                                        <div class="gap-3 table-actions d-flex align-items-center fs-6">
                                            <a href="{{ route('admin.category.edit', $item->id) }}"
                                                class="text-warning" data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                title="Edit"><i class="bi bi-pencil-fill"></i></a>
                                            <a href="javascript:;" class="text-danger"
                                                onclick="deleteItem({{ $item->id }})" data-bs-toggle="tooltip"
                                                data-bs-placement="bottom" title="@lang('Delete')"><i
                                                    class="bi bi-trash-fill"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('delete')
    <form method="POST" id="deleteForm">
        @csrf
        @method('delete')
    </form>
@endpush
