@extends('admin.layouts.app', ['title' => 'Contacts Person Lists'])
@section('panel')
    <div class="container-fluid">
        <div class="pb-2 mb-2 page-breadcrumb d-flex align-items-center border-bottom">
            <div class="ms-auto">
                <button type="button"  data-bs-toggle="modal" data-bs-target="#contactImportModal" class="btn btn-primary btn-sm"> <i
                    class="bi bi-excel"></i> @lang('Import')</button>
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
                                <th>@lang('Name')</th>
                                <th>@lang('Phone')</th>
                                <th>@lang('Email')</th>
                                <th>@lang('Group')</th>
                                <th>@lang('Status')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($contacts as $contact)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $contact->name }}</td>
                                    <td>{{ $contact->phone }}</td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->category->title }}</td>
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

    <div id="contactImportModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="mt-0 modal-title" id="myModalLabel">@lang('Upload contact CSV File')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form" action="{{ route('admin.contacts.contactBulkUpload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="my-3 form-group">
                                <label for="" class="col-md-12 pull-left">@lang('Group')  <sup class="text-danger">*</sup></label>
                                <div class="col-md-12">
                                    <select class="form-control" name="category_id" required>
                                        <option value="0">@lang('Select one')</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="my-3 form-group">
                                <label for="file" class="form-label">{{ __('File')}} <sup class="text-danger">*</sup></label>
                                <div class="col-md-12">
                                    <input type="file" name="csvfile" class="form-control" required>
                                    <div class="form-text">{{ __('Supported files: csv & exel')}}</div>
                                </div>
                            </div>
                            <div class="my-3 form-group">
                                <div class="progress">
                                    <div class="progress-bar"
                                        role="progressbar"
                                        style="width: 0%;"
                                        aria-valuenow="0"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                        25%
                                    </div>
                                </div>
                            </div>
                            <div class="my-3 form-group">
                                <div class="form-text">{{ __('Download file format from here')}}
                                    <a href="{{route('admin.demo.csv.downlode')}}">{{ __('csv')}}</a> ,
                                    <a href="{{route('admin.demo.exel.downlode','xlsx')}}">{{ __('exel')}}</a>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn btn-primary">@lang('Save')</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@endsection



@push('script')
<script>
    $(document).ready(function() {
        $('#form').submit(function(e) {
            e.preventDefault(); // prevent the form from submitting normally

            var form = $(this);
            var formData = new FormData(form[0]);

            $.ajax({
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener("progress", function(evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = evt.loaded / evt.total * 100;
                            $('.progress-bar').width(percentComplete + '%');
                            $('.progress-bar').html(percentComplete + '%');
                        }
                    }, false);
                    return xhr;
                },
                type: form.attr('method'),
                url: form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);
                    if(response.status) {
                        window.location.reload();

                    } else {
                        $('.progress-bar').width('100%').removeClass('bg-success').addClass('bg-danger').html('Faild');
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                    $('.progress-bar').width('100%').removeClass('bg-success').addClass('bg-danger').html('Faild');
                }
            });
        });
    });
</script>
@endpush

