@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="text-main-color">Timetable</h1>
    </div>
</div>
<hr>
<div class="row">
    @foreach($timetable as $tt)
        <div class="col-12 col-lg-10 offset-lg-1 text-center mb-4">
            <a class="fancybox" href="{{ $img_url.'/'.$tt['image']['path'] }}">
                <img src="{{ $img_url.'/'.$tt['image']['path'] }}" class="w-100 lazy">
            </a>
        </div>
    @endforeach
</div>
@stop