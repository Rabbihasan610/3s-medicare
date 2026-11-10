@extends('admin.layouts.app',['title'=> 'System Email Settings'])
@section('panel')
<div class="row">
        <div class="col-md-12">
            <div class="alert alert-info d-flex gap-2 align-items-start" role="note">
                <i class="bi bi-info-circle mt-1"></i>
                <div>
                    <strong>@lang('This is the transactional email configuration.')</strong>
                    @lang('It sends registration, verification code, password reset, support and form notification emails.')
                    <br>
                    @lang('Marketing campaigns use a separate configuration under')
                    <a href="{{ route('admin.setting.email') }}">@lang('Marketing') &rsaquo; @lang('Sending Domains')</a>.
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <form action="" method="POST">
                    @csrf
                    <div class="card-body">

                        {{-- Sender identity: who these notifications appear to come from. --}}
                        <h6 class="mb-3">@lang('Sender Identity')</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label class="form-label" for="email_from_name">@lang('From Name')</label>
                                    <input type="text" id="email_from_name" class="form-control" name="email_from_name"
                                        value="{{ old('email_from_name', $general->email_from_name ?? $general->site_name) }}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label class="form-label" for="email_from">@lang('From Address')</label>
                                    <input type="email" id="email_from" class="form-control" name="email_from"
                                        value="{{ old('email_from', $general->email_from) }}" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label class="form-label" for="email_reply_to">@lang('Reply To')</label>
                                    <input type="email" id="email_reply_to" class="form-control" name="email_reply_to"
                                        placeholder="@lang('Defaults to the from address')"
                                        value="{{ old('email_reply_to', $general->email_reply_to) }}" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label class="form-label" for="email_signature">@lang('Email Signature')</label>
                                    <textarea id="email_signature" name="email_signature" rows="2" class="form-control">{{ old('email_signature', $general->email_signature) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label class="form-label" for="email_signature_ar">@lang('Email Signature') (@lang('Arabic'))</label>
                                    <textarea id="email_signature_ar" name="email_signature_ar" rows="2" dir="rtl" class="form-control">{{ old('email_signature_ar', $general->email_signature_ar) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="mb-3 form-group">
                            <label class="form-label">@lang('Email Send Method')</label>
                            <select name="email_method" class="form-control" >
                                <option value="php" @if($general->mail_config->name == 'php') selected @endif>@lang('PHP Mail')</option>
                                <option value="smtp" @if($general->mail_config->name == 'smtp') selected @endif>@lang('SMTP')</option>
                                <option value="sendgrid" @if($general->mail_config->name == 'sendgrid') selected @endif>@lang('SendGrid API')</option>
                                <option value="mailjet" @if($general->mail_config->name == 'mailjet') selected @endif>@lang('Mailjet API')</option>
                            </select>
                        </div>
                        <div class="mt-4 row d-none configForm" id="smtp">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('SMTP Configuration')</h6>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 form-group">
                                    <label class="form-label">@lang('Host') </label>
                                    <input type="text" class="form-control" placeholder="e.g. @lang('smtp.googlemail.com')" name="host" value="{{ $general->mail_config->host ?? '' }}"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 form-group">
                                    <label class="form-label">@lang('Port') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Available port')" name="port" value="{{ $general->mail_config->port ?? '' }}"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3 form-group">
                                    <label class="form-label">@lang('Encryption')</label>
                                    <select class="form-control" name="enc">
                                        <option value="ssl" @selected(@$general->mail_config->enc == 'ssl')>@lang('SSL')</option>
                                        <option value="tls" @selected(@$general->mail_config->enc == 'tls')>@lang('TLS')</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label class="form-label">@lang('Username') </label>
                                    <input type="text" class="form-control" placeholder="@lang('Normally your email') address" name="username" value="{{ $general->mail_config->username ?? '' }}"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label class="form-label">@lang('Password') </label>
                                    <input type="password" class="form-control" placeholder="@lang('Leave blank to keep the current value')" name="password" autocomplete="new-password"/>
                                    <small class="text-muted">@if(!empty($general->mail_config->password)) @lang('A value is saved. Leave blank to keep it.') @else @lang('Not set yet.') @endif</small>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 row d-none configForm" id="sendgrid">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('SendGrid API Configuration')</h6>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="form-label">@lang('App Key') </label>
                                <input type="password" class="form-control" placeholder="@lang('Leave blank to keep the current value')" name="appkey" autocomplete="new-password"/>
                                    <small class="text-muted">@if(!empty($general->mail_config->appkey)) @lang('A value is saved. Leave blank to keep it.') @else @lang('Not set yet.') @endif</small>
                            </div>
                        </div>
                        <div class="mt-4 row d-none configForm" id="mailjet">
                            <div class="col-md-12">
                                <h6 class="mb-2">@lang('Mailjet API Configuration')</h6>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label class="form-label">@lang('Api Public Key') </label>
                                    <input type="password" class="form-control" placeholder="@lang('Leave blank to keep the current value')" name="public_key" autocomplete="new-password"/>
                                    <small class="text-muted">@if(!empty($general->mail_config->public_key)) @lang('A value is saved. Leave blank to keep it.') @else @lang('Not set yet.') @endif</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label class="form-label">@lang('Api Secret Key') </label>
                                    <input type="password" class="form-control" placeholder="@lang('Leave blank to keep the current value')" name="secret_key" autocomplete="new-password"/>
                                    <small class="text-muted">@if(!empty($general->mail_config->secret_key)) @lang('A value is saved. Leave blank to keep it.') @else @lang('Not set yet.') @endif</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div><!-- card end -->
        </div>


    </div>


    {{-- TEST MAIL MODAL --}}
    <div id="testMailModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Test Mail Setup')</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.setting.notification.email.test') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3 form-group">
                                    <label class="form-label">@lang('Sent to') </label>
                                    <input type="text" name="email" class="form-control" placeholder="@lang('Email Address')">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100 h-45">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('breadcrumb-plugins')
    <button type="button" data-bs-target="#testMailModal" data-bs-toggle="modal" class="btn btn-sm btn-outline-primary"><i class="las la-paper-plane"></i> @lang('Send Test Mail')</button>
@endpush
@push('script')
    <script>
        (function ($) {
            "use strict";

            var method = '{{ $general->mail_config->name }}';
            emailMethod(method);
            $('select[name=email_method]').on('change', function() {
                var method = $(this).val();
                emailMethod(method);
            });

            function emailMethod(method){
                $('.configForm').addClass('d-none');
                if(method != 'php') {
                    $(`#${method}`).removeClass('d-none');
                }
            }

        })(jQuery);

    </script>
@endpush
