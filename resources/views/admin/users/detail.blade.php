@extends('admin.layouts.app', ['title' => 'User Detail - ' . $user->username])

@section('panel')

    <div class="row">
        <div class="col-12 col-lg-5">
            <div class="card">
                <div class="card-body">
                    <div class="flex-wrap gap-4 profile-img d-flex">
                        <div>
                            <img src="{{ getImage(getFilePath('userProfile') . '/' . $user->image) }}" alt="">
                        </div>
                        <div>
                            <h5>{{ $user->name }}</h5>
                            <h6>{{ '@' . $user->username }}</h6>
                            <h6>{{ $user->email }}</h6>
                            <h6>{{ $user->mobile }}</h6>
                            <h6><span class="badge bg-primary">{{ __($user->position_title) }}</span></h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="flex-wrap gap-3 mt-4 d-flex">
                                <div class="flex-fill">
                                    <a href="{{ route('admin.report.login.history') }}?search={{ $user->username }}"
                                        class="px-5 btn btn-primary w-100">
                                        <i class="las la-list-alt me-2"></i>@lang('Logins')
                                    </a>
                                </div>

                                <div class="flex-fill">
                                    <a href="{{ route('admin.users.notification.log', $user->id) }}"
                                        class="px-5 btn btn-secondary w-100">
                                        <i class="las la-bell me-2"></i>@lang('Notifications')
                                    </a>
                                </div>

                                <div class="flex-fill">
                                    <a href="{{ route('admin.users.login', $user->id) }}" target="_blank"
                                        class="px-5 btn btn-success w-100">
                                        <i class="las la-sign-in-alt me-2"></i>@lang('Login as User')
                                    </a>
                                </div>

                                <div class="flex-fill">
                                    @if ($user->status == Status::USER_ACTIVE)
                                        <button type="button" class="px-5 btn btn-danger w-100" data-bs-toggle="modal"
                                            data-bs-target="#userStatusModal">
                                            <i class="las la-ban me-2"></i>@lang('Ban User')
                                        </button>
                                    @else
                                        <button type="button" class="px-5 btn btn-success w-100" data-bs-toggle="modal"
                                            data-bs-target="#userStatusModal">
                                            <i class="las la-undo me-2"></i>@lang('Unban User')
                                        </button>
                                    @endif
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-7">
            <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="pb-3 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">@lang('Name')</label>
                                    <input class="form-control" type="text" name="name" required
                                        value="{{ $user->name }}">
                                </div>
                            </div>
                            <div class="pb-3 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">@lang('Email') </label>
                                    <input class="form-control" type="email" name="email" value="{{ $user->email }}"
                                        required>
                                </div>
                            </div>

                            <div class="pb-3 col-md-4">
                                <div class="form-group">
                                    <label class="form-label">@lang('Mobile Number') </label>
                                    <input type="number" name="mobile" value="{{ old('mobile',@$user->mobile) }}" 
                                    class="form-control" required>
                                </div>
                            </div>

                            <div class="pb-3 col-md-6">
                                <div class="form-group ">
                                    <label class="form-label">@lang('Address')</label>
                                    <input class="form-control" type="text" name="address"
                                        value="{{ @$user->address->address }}">
                                </div>
                            </div>

                            <div class="pb-3 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">@lang('City')</label>
                                    <input class="form-control" type="text" name="city"
                                        value="{{ @$user->address->city }}">
                                </div>
                            </div>

                            <div class="pb-3 col-md-4">
                                <div class="form-group ">
                                    <label class="form-label">@lang('State')</label>
                                    <input class="form-control" type="text" name="state"
                                        value="{{ @$user->address->state }}">
                                </div>
                            </div>

                            <div class="pb-3 col-md-4">
                                <div class="form-group ">
                                    <label class="form-label">@lang('Zip/Postal')</label>
                                    <input class="form-control" type="text" name="zip"
                                        value="{{ @$user->address->zip }}">
                                </div>
                            </div>

                            <div class="pb-3 col-md-4">
                                <div class="form-group ">
                                    <label class="form-label">@lang('Country')</label>
                                    <select name="country" class="form-select">
                                        @foreach($countries as $country)
                                        <option value="{{$country->id}}" @selected($country->id == $user->country_id)> {{$country->name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="form-label">@lang('Email Verification')</label>
                                <input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger"
                                    data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')"
                                    name="ev" @if ($user->ev) checked @endif>

                            </div>

                            <div class="form-group col-sm-6">
                                <label class="form-label">@lang('Mobile Verification')</label>
                                <input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger"
                                    data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')"
                                    name="sv" @if ($user->sv) checked @endif>
                            </div>
                        </div>

                        <div class="div">
                            <button type="submit" class="mt-4 btn btn-primary w-100">@lang('Submit')
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict"
            $('.bal-btn').click(function() {
                var act = $(this).data('act');
                $('#addSubModal').find('input[name=act]').val(act);
                if (act == 'add') {
                    $('.type').text('Add');
                } else {
                    $('.type').text('Subtract');
                }
            });

            // let mobileElement = $('.mobile-code');

            // $('select[name=country]').change(function() {
            //     mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            // });

            // $('select[name=country]').val('{{ @$user->country_code }}');

            // let dialCode = $('select[name=country] :selected').data('mobile_code');
            // let mobileNumber = `{{ $user->mobile }}`;
            // mobileNumber = mobileNumber.replace(dialCode, '');
            // $('input[name=mobile]').val(mobileNumber);
            // mobileElement.text(`+${dialCode}`);

        })(jQuery);
    </script>
@endpush


@push('style')
    <style>
        .profile-img img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
        }
    </style>
@endpush
