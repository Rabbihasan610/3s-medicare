@props([
    'typeInfo' => null,
    'type' => null,
    'name' => null,
    'id' => null,
    'required' => false,
    'darkMode' => false,
])

<div class="product-card">
    <div class="product-card-header">
        <h6 class="m-0 text-light"><span>@lang('Detail')</span></h6>
    </div>
    <div class="product-card-body">

        @if($typeInfo != null)
            <div class="row">
                <div class="mb-3 col-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <label class="form-label">@lang('Electricity')</label>
                        <select name="electricity" class="form-control">
                            <option value="">@lang('Select One')</option>
                            <option value="Yes" @selected(old('electricity') == 'Yes')>@lang('Yes')</option>
                            <option value="No" @selected(old('electricity') == 'No')>@lang('No')</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 col-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <label class="form-label">@lang('Water')</label>
                        <select name="water" class="form-control">
                            <option value="">@lang('Select One')</option>
                            <option value="Yes" @selected(old('water') == 'Yes')>@lang('Yes')</option>
                            <option value="No" @selected(old('water') == 'No')>@lang('No')</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3 col-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <label class="form-label">@lang('Property Length')</label>
                        <input type="text" name="length" value="{{ old('length') }}" class="form-control">
                    </div>
                </div>
                <div class="mb-3 col-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <label class="form-label">@lang('Property Width')</label>
                        <input type="text" name="width" value="{{ old('width') }}" class="form-control">
                    </div>
                </div>

                <div class="mb-3 col-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <label class="form-label">@lang('Property Age')</label>
                        <input type="text" name="age" value="{{ old('age') }}" class="form-control">
                    </div>
                </div>
                <div class="mb-3 col-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <label class="form-label">@lang('Bedrooms')</label>
                        <input type="number" name="bed_rooms" value="{{ old('bed_rooms') }}" class="form-control">
                    </div>
                </div>
                <div class="mb-3 col-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <label class="form-label">@lang('Bathrooms')</label>
                        <input type="number" name="bath_rooms" value="{{ old('bath_rooms') }}" class="form-control">
                    </div>
                </div>
                <div class="mb-3 col-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <label class="form-label">@lang('Living Rooms')</label>
                        <input type="number" name="living_room" value="{{ old('living_room') }}"
                            class="form-control">
                    </div>
                </div>
                <div class="mb-3 col-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <label class="form-label">@lang('Guest Rooms')</label>
                        <input type="number" name="guest_room" value="{{ old('guest_room') }}"
                            class="form-control">
                    </div>
                </div>
                <div class="mb-3 col-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <label class="form-label">@lang('Land Area')</label>
                        <input type="text" name="land_area" value="{{ old('land_area') }}" class="form-control">
                    </div>
                </div>

                <div class="mb-3 col-12 col-md-6 col-lg-4">
                    <div class="form-group">
                        <label class="form-label">@lang('Built-Up Area')</label>
                        <input type="text" name="build_up_area" value="{{ old('build_up_area') }}"
                            class="form-control">
                    </div>
                </div>
            </div>
        @else
        <div class="row">
            <div class="mb-3 col-12 col-md-12 col-lg-12">
                <h6 class="text-center">@lang('Please selected one property type')</h6>
            </div>
        </div>
        @endif

    </div>
</div>
