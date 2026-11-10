@extends('web.layouts.master', ['title' => 'Dashboard'])
@section('content')
    <div class="row">

        <div class="pb-3 col-12 col-lg-4">
            <div class="dashboard-card" style="background: #265073;">
                <div>
                    <i class="bi bi-envelope"></i>
                </div>
                <div>
                    <h3> {{ $supportCount }} </h3>
                    <h6>@lang('Supports')</h6>
                </div>
            </div>
        </div>
    </div>
@endsection

