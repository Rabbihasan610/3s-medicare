@extends('web.layouts.medicare', ['title' => @$title])
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags((@$title ? @$title . ' - ' : '') . gs('site_name')), 160, ''))

@section('content')
    @if($sections != null)
        @php
            $secsArray = is_array($sections) ? $sections : (is_string($sections) ? json_decode($sections, true) : []);
        @endphp
        @if(!empty($secsArray))
            @foreach($secsArray as $sec)
                @if(view()->exists('sections.' . $sec))
                    @include('sections.' . $sec)
                @endif
            @endforeach
        @endif
    @endif
@endsection
