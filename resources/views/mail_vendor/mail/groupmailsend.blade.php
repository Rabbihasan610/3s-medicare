@extends('admin.layouts.app', ['title' => 'Mail Send'])
@section('panel')
    <div class="container-fluid">
        <form action="{{ route('admin.mail.send.group.mail') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12 col-xl-12">
                    @if(session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-warning">{{session('error')}}</div>
                    @endif
                    <div class="mt-2 card">
                        <div class="card-body">
                            <div class="row">
                                <div class="py-3 col-12">
                                    <label for="" class="form-label">@lang('Sender Email')</label>
                                    <select name="domain" id="domain" class="form-control" required>
                                        <option value="">@lang('Select Email')</option>
                                        @foreach ($domainconfigs as $domainconfig)
                                            <option value="{{ $domainconfig->id }}">{{ $domainconfig->domain }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="py-3 col-12">
                                    <label for="" class="form-label">@lang('Select Group')<span
                                            class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-control" required>
                                        <option value="">@lang('Select Group')</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="py-3 col-12">
                                    <label for="" class="form-label">@lang('Email Subject')<span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="subject" class="form-control">
                                </div>
                                <div class="py-3 col-12">
                                    <label for="" class="form-label">@lang('Select Template')</label>
                                    <select name="template" id="template_id" class="form-control">
                                        <option value="" data-content="0">@lang('Select Template')</option>
                                        @foreach ($templates as $template)
                                            <option value="{{ $template->code }}" data-content="{{ $template }}">{{ $template->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('template')
                                    <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="py-3 col-12">
                                    <label for="" class="form-label">@lang('Message') <span
                                            class="text-danger">*</span></label>
                                    <textarea name="message" id="message" class="form-control message" rows="5"></textarea>
                                    <br>
                                    <p>Code : <span class="code"></span></p>
                                </div>
                                <div class="py-3 col-12">
                                    <label for="" class="form-label">@lang('Attachment') (@lang('User can add multiple File')) (@lang('Optional'))</label>
                                    <input type="file" name="attachment[]" class="form-control" multiple>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="px-4 btn btn-primary"> <i class="bi bi-send"></i>
                                        @lang('Send')</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@push("script")
    <script>
        $(document).ready(function() {
            $("#template_id").on("change", function() {
                var template = $(this).find('option:selected').data('content');

                if (template === 0) {
                    $(".code").empty();
                    $("#message").text('');
                } else {
                    var short_codes = template.short_code;
                    $(".code").html(short_codes);
                    $("#message").text(template.message_body);
                }

            });
        });
    </script>
@endpush
