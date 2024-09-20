@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="text-main-color">Route map</h1>
    </div>
</div>
<hr>

@foreach($routemap as $rm)
<div class="row">
    <div class="col-12 col-lg-10 offset-lg-1 mb-4">
        <a class="fancybox" href="{{ $img_url.$rm['image']['path'].'/'.$rm['image']['name'] }}">
            <img src="{{ $img_url.$rm['image']['path'].'/'.$rm['image']['name'] }}" class="w-100 lazy">
        </a>
    </div>
    <div class="col-12 text-center">
        <a href="{{ $img_url.$rm['image']['path'].'/'.$rm['image']['name'] }}"
            class="btn btn-sm button-orange-bg transition-hover-top" rel="noopener" target="_blank"><i
                class="fi fi-cloud-download"></i> Download {{ $rm['detail'] }}
        </a>
    </div>
</div>
<hr>
@endforeach

@stop
