@extends('web.layouts.master',['title'=>'Supports'])

@section('content')
    <div class="card custom-card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center">
            <h5 class="mt-0">
                @php echo $myTicket->statusBadge; @endphp
                {{ $myTicket->subject }}
            </h5>
            @if ($myTicket->status != Status::TICKET_CLOSE && $myTicket->user)
                <button class="btn btn-danger close-button btn-sm confirmationBtn" type="button"
                    data-question="@lang('Are you sure to close this support?')" data-action="{{ route('support.close', $myTicket->id) }}"><i
                        class="fa fa-lg fa-times-circle"></i>
                </button>
            @endif
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('support.reply', $myTicket->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-between">
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea name="message" class="form-control" rows="4">{{ old('message') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="text-end mt-3">
                    <a href="javascript:void(0)" class="btn btn-base btn-sm addFile"><i class="bi bi-plus-circle"></i>
                        @lang('Add New')</a>
                </div>
                <div class="form-group">
                    <label class="form-label">@lang('Attachments')</label>
                    <input type="file" name="attachments[]" class="form-control" />
                    <div id="fileUploadsContainer"></div>
                    <p class="my-2 ticket-attachments-message text-muted">
                        @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'),
                        .@lang('pdf'), .@lang('doc'), .@lang('docx')
                    </p>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-base btn-sm"> <i class="bi bi-reply-all"></i>
                        @lang('Reply')</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card custom-card mt-4">
        <div class="card-body">
            @foreach ($messages as $message)
                @if ($message->admin_id == 0)
                    <div class="card mt-3">
                        <div class="card-header">
                            <span>{{ $message->ticket->name }}</span>
                            |
                            <span class="text-muted fw-bold">
                                <small>{{ showDateTime($message->created_at, 'd M Y') }}</small>
                                @
                                <small>{{ showDateTime($message->created_at, 'H:i A') }}</small>
                            </span>
                        </div>
                        <div class="card-body">
                            <p>{{ $message->message }}</p>

                            @if ($message->attachments->count() > 0)
                                <div class="mt-2">
                                    @foreach ($message->attachments as $k => $image)
                                        <a href="{{ route('support.download', encrypt($image->id)) }}" class="me-3"><i
                                                class="fa fa-file"></i> @lang('Attachment')
                                            {{ ++$k }} </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="card mt-3">
                        <div class="card-header" style="background:#f1f1f1">
                            <span>{{ $message->admin->name }}</span>
                            |
                            <span class="text-muted fw-bold">
                                <small>{{ showDateTime($message->created_at, 'd M Y') }}</small>
                                @
                                <small>{{ showDateTime($message->created_at, 'H:i A') }}</small>
                            </span>

                        </div>
                        <div class="card-body">
                            <p>{{ $message->message }}</p>

                            @if ($message->attachments->count() > 0)
                                <div class="mt-2">
                                    @foreach ($message->attachments as $k => $image)
                                        <a href="{{ route('support.download', encrypt($image->id)) }}" class="me-3"><i
                                                class="fa fa-file"></i> @lang('Attachment')
                                            {{ ++$k }} </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <x-confirmation-modal />
@endsection
@push('style')
    <style>
        .input-group-text:focus {
            box-shadow: none !important;
        }
    </style>
@endpush
@push('script')
    <script>
        (function($) {
            "use strict";
            var fileAdded = 0;
            $('.addFile').on('click', function() {
                if (fileAdded >= 4) {
                    notify('error', 'You\'ve added maximum number of file');
                    return false;
                }
                fileAdded++;
                $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form-control" required />
                        <button type="submit" class="input-group-text btn-danger remove-btn"><i class="las la-times"></i></button>
                    </div>
                `)
            });
            $(document).on('click', '.remove-btn', function() {
                fileAdded--;
                $(this).closest('.input-group').remove();
            });
        })(jQuery);
    </script>
@endpush

@push('title')
    <h5>@lang('Support')#{{ $myTicket->ticket }}</h5>
@endpush
