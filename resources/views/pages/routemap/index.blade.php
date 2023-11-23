@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-12 text-center mb-5">
        <h1 class="fw-bold">Route map</h1>
    </div>

    @foreach($routemap as $rm)
        <div class="col-12 mb-4">
            <a class="fancybox" href="{{ $img_url.$rm['image']['path'].'/'.$rm['image']['name'] }}">
                <img src="{{ $img_url.$rm['image']['path'].'/'.$rm['image']['name'] }}" class="w-100 lazy">
            </a>
        </div>
    @endforeach
</div>
@stop