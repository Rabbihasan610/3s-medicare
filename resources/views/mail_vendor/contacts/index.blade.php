@extends('admin.layouts.app', ['title' => 'Contacts Person Lists'])
@section('panel')
    <div class="container-fluid">
        <div class="pb-2 mb-2 page-breadcrumb d-flex align-items-center border-bottom">
            <div class="ms-auto">
                <a href="{{ route('admin.contacts.create') }}" type="button" class="btn btn-primary btn-sm"> <i
                        class="bi bi-plus-circle"></i> @lang('Create New Contacts')</a>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Group')</th>
                                <th>@lang('Name')</th>
                                <th>@lang('Title')</th>
                                <th>@lang('City')</th>
                                <th>@lang('Phone')</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Status')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $contact->category->title }}</td>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->title }}</td>
                                    <td>{{ $contact->city }}</td>
                                    <td>{{ $contact->phone }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>
                                        @if ($contact->status == 1)
                                            <span class="text-white badge bg-success">@lang('Active')</span>
                                        @elseif ($contact->status == 2)
                                            <span class="text-white badge bg-warning">@lang('Inactive')</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="my-3">
                    {{ $contacts->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
