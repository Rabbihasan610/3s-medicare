@extends('admin.layouts.app', ['title' => 'Edit Template'])
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.template.update', $template->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">@lang('Title')</label>
                                <input type="text" name="title" value="{{ $template->title }}" class="form-control" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">@lang('Subject')</label>
                                <input type="text" name="subject" value="{!! $template->subject !!}" class="form-control" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label">@lang('Message')</label>
                                <textarea name="message_body" class="form-control" rows="8" required>{!! $template->message_body !!}</textarea>
                                @if($template->short_code)
                                    <small class="text-muted mt-2 d-block">
                                        @lang('Shortcodes you can use'): <code>{{ $template->short_code }}</code>
                                    </small>
                                @endif
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary w-100">@lang('Update')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
