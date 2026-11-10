@extends('admin.layouts.app', ['title' => 'SMS send'])
@section('panel')
    <div class="container-fluid">
    
        <form action="{{ route('admin.sms.send.general.message') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12 col-xl-12">
                    @if(session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-warning">{{session('error')}}</div>
                    @endif
                    <div class=""></div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="py-3 col-12">
                                    <label for="" class="form-label">Select provider <span class="text-danger">*</span></label>
                                    <select name="provider" id="provider" class="form-control" required>
                                        <option value="0">Select provider</option>
                                        @foreach ($providers as $provider)
                                            <option value="{{ $provider->code }}">{{ $provider->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('provider')
                                       <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="py-3 col-12">
                                    <label for="" class="form-label">Mobile Numbers <span
                                            class="text-danger">*</span></label>
                                    <textarea name="phone" id="phone" class="form-control" rows="3"
                                        placeholder="01xxxxxxxxx,01xxxxxxxxx,01xxxxxxxxx"></textarea>
                                    @error('phone')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="py-3 col-12">
                                    <label for="" class="form-label">Select Template <span class="text-danger">*</span></label>
                                    <select name="template" id="template_id" class="form-control" required>
                                        <option value="" data-content="0">Select Template</option>
                                        @foreach ($templates as $template)
                                        <option value="{{ $template->code }}" data-content="{{ $template }}">{{ $template->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('template')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="py-3 col-12">
                                    <label for="" class="form-label">Message <span
                                            class="text-danger">*</span></label>
                                    <textarea name="message" id="message" class="form-control message" rows="3"></textarea>
                                    @error('message')
                                        <p class="text-danger">{{ $message }}</p>
                                    @enderror
                                    <br>
                                    <p>Code : <span class="code"></span></p>
                                    <br>
                                    <p><strong>Note:</strong> <span class="text-danger">If your are using template to avoid short code and place your actual information.</span></p>
                                    <br>
                                    <ul id="sms-counter" class="list-group">
                                        <li class="list-group-item">Encoding: <span class="encoding"></span></li>
                                        <li class="list-group-item">Length: <span class="length"></span></li>
                                        <li class="list-group-item">Messages: <span class="messages"></span></li>
                                        <li class="list-group-item">Per Message: <span class="per_message"></span></li>
                                        <li class="list-group-item">Remaining: <span class="remaining"></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="px-4 btn btn-primary"> <i class="bi bi-send"></i>
                                        Send</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    @include('components.smscount')
@endsection

@push("script")
    <script>
        $(document).ready(function() {
            $("#template_id").on("change", function() {
                var template = $(this).find('option:selected').data('content');
                if(template === 0){
                    $(".code").html('');
                    $(".message").text('');
                }else{
                    var short_codes = template.short_code;
                    $(".code").html(short_codes);
                    $(".message").text(template.message_body);
                }

            });
        });
    </script>
@endpush
