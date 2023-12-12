@extends('layouts.default')

@section('content')
<div class="row min-h-50vh">
    <div class="col-12 text-center mb-5">
        <h1 class="fw-bold">Timetable</h1>
    </div>

    @foreach($timetable as $tt)
        <div class="col-12 text-center mb-4">
            <a class="fancybox" href="{{ $img_url.'/'.$tt['image']['path'] }}">
                <img src="{{ $img_url.'/'.$tt['image']['path'] }}" class="w-100 lazy">
            </a>
        </div>
    @endforeach
</div>
@stop