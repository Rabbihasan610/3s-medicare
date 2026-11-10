@extends('web.layouts.medicare', ['title' => gs('site_name')])

@section('content')
    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include('sections.' . $sec)
        @endforeach
    @endif
@endsection
