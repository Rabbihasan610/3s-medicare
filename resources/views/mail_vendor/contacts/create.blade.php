@extends('admin.layouts.app', ['title' => 'Add New Contact'])
@section('panel')
    <div class="container-fluid">
        <div class="pb-2 mb-2 page-breadcrumb d-flex align-items-center border-bottom">
            <div class="ms-auto">
                <a href="{{ route('admin.contacts.email.index') }}" type="button" class="btn btn-primary btn-sm"> <i
                        class="bi bi-arrow-counterclockwise"></i> @lang('Back')</a>
            </div>
        </div>
        <!--breadcrumb-->
        <div class="card">
            @if(session('success'))
                <div class="alert alert-success">{{session('success')}}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-warning">{{session('error')}}</div>
            @endif
            <div class="card-body">
                <form action="{{ route('admin.contacts.store') }}" method="POST">
                    @csrf
                    <div class="mb-3 row">
                        <div class="py-2 col-sm-7">
                            <div class="form-group">
                                <label for="title">@lang('Group')</label>
                                <select name="category_id" class="form-control">
                                    <option value="0">@lang('Select one')</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="py-2 col-sm-7">
                            <div class="form-group">
                                <label for="title">@lang('Type')</label>
                                <select name="type" class="form-control">
                                    {{-- <option value="SMS" {{ old('type') == 'SMS' ? 'selected' : '' }}>@lang('SMS')</option> --}}
                                    <option value="EMAIL" {{ old('type') == 'EMAIL' ? 'selected' : '' }}>@lang('EMAIL')</option>
                                    <option value="0">@lang('Select type')</option>
                                </select>
                                @error('type')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            </div>
                        </div>
                        <div class="py-2 col-sm-7">
                            <div class="form-group">
                                <label for="name">@lang('Name')</label>
                                <input type="text" name="name" value="{{ old('name') }}" class="form-control">
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="py-2 col-sm-7">
                            <div class="form-group">
                                <label for="name">@lang('Title')</label>
                                <input type="text" name="title" value="{{ old('title') }}" class="form-control">
                                @error('title')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="py-2 col-sm-7">
                            <div class="form-group">
                                <label for="name">@lang('City')</label>
                                <input type="text" name="city" value="{{ old('city') }}" class="form-control">
                                @error('city')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="py-2 col-sm-7">
                            <div class="form-group">
                                <label for="title">@lang('Phone')</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" class="form-control">
                                @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="py-2 col-sm-7">
                            <div class="form-group">
                                <label for="title">@lang('Email')</label>
                                <input type="text" name="email" value="{{ old('email') }}" class="form-control">
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-3 col-sm-12">
                            <a href="{{ route('admin.contacts.sms.index') }}" class="px-3 btn btn-warning btn-sm">Cancel</a>
                            <button type="submit" class="px-3 btn btn-primary btn-sm">@lang('Submit')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
