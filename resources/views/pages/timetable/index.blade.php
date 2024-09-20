@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="text-main-color">Timetable</h1>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-12 col-lg-3">
        <div class="row">
            @foreach($timetable as $tt)
            <div class="col-4 col-lg-10 offset-lg-1 text-center mb-4 text-center">
                <strong>{{ $tt['title'] }}</strong>
                <a href="{{ route('timetable-index',['id'=>$tt['id'],'t'=>$tt['title']]) }}">
                    <img src="{{ $img_url.'/'.$tt['image']['path'] }}" class="w-100 lazy">
                </a>
            </div>

            @endforeach
        </div>
        <hr>
    </div>
    <div class="col-12 col-lg-9">
        @if (!empty($default))
        <div class="row">
            <div class="col-12 mb-3 text-center">
                <a href="{{ $img_url.'/'.$default['image']['path'] }}"
                    class="btn btn-sm button-orange-bg transition-hover-top" rel="noopener" target="_blank"><i
                        class="fi fi-cloud-download"></i> Download {{ $default['title'] }}
                </a>
            </div>

            <div class="col-12">
                <a class="fancybox" href="{{ $img_url.'/'.$default['image']['path'] }}">
                    <img src="{{ $img_url.'/'.$default['image']['path'] }}" class="w-100 lazy">
                </a>
            </div>
        </div>
        @endif

    </div>

</div>
@stop
