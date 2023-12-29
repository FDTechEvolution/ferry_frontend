@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="text-main-color">Route map</h1>
    </div>
</div>
<hr>
<div class="row">
    @foreach($routemap as $rm)
        <div class="col-12 col-lg-10 offset-lg-1 mb-4">
            <a class="fancybox" href="{{ $img_url.$rm['image']['path'].'/'.$rm['image']['name'] }}">
                <img src="{{ $img_url.$rm['image']['path'].'/'.$rm['image']['name'] }}" class="w-100 lazy">
            </a>
        </div>
    @endforeach
</div>
@stop