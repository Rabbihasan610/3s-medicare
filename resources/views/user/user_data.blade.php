@extends('web.layouts.frontend',['title'=> __('User Data')])

@section('content')
<div class="container">
    <div class="py-5 row justify-content-center">
        <div class="col-md-8 col-lg-7 col-xl-5">
            <div class="card custom--card">
                <div class="card-header">
                    <h5 class="card-title">@lang('User Data')</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('user.data.submit') }}">
                        @csrf
                        <div class="row">
                            <div class="pb-3 form-group col-sm-12">
                                <label class="form-label">@lang('Full Name')</label>
                                <input type="text" class="form-control " name="name" value="{{ old('name') }}" required>
                            </div>
                            <div class="pb-3 form-group col-sm-12">
                                <label class="form-label">@lang('Position Title')</label>
                                <select class="form-control" name="position_title" required>
                                    <option value="Real estate resident">@lang('Real estate resident')</option>
                                    <option value="Real estate marketer">@lang('Real estate marketer')</option>
                                    <option value="Real estate broker">@lang('Real estate broker')</option>
                                    <option value="Real estate developer">@lang('Real estate developer')</option>
                                    <option value="Property owner">@lang('Property owner')</option>
                                    <option value="Legal agent">@lang('Legal agent')</option>
                                </select>
                            </div>
                            <div class="pb-3 form-group col-sm-6">
                                <label class="form-label">@lang('Val license number')</label>
                                <input type="text" class="form-control " name="val_license_number" value="{{ old('val_license_number') }}">
                            </div>
                            <div class="pb-3 form-group col-sm-6">
                                <label class="form-label">@lang('Address')</label>
                                <input type="text" class="form-control " name="address" value="{{ old('address') }}">
                            </div>
                            <div class="pb-3 form-group col-sm-6">
                                <label class="form-label">@lang('State')</label>
                                <input type="text" class="form-control " name="state" value="{{ old('state') }}">
                            </div>
                            <div class="pb-3 form-group col-sm-6">
                                <label class="form-label">@lang('Zip Code')</label>
                                <input type="text" class="form-control " name="zip" value="{{ old('zip') }}">
                            </div>

                            <div class="pb-3 form-group col-sm-6">
                                <label class="form-label">@lang('City')</label>
                                <input type="text" class="form-control " name="city" value="{{ old('city') }}">
                            </div>
                        </div>
                        <div class="pb-3 form-group">
                            <button type="submit" class="btn btn-base w-100">
                                @lang('Submit')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
