@extends('layouts.default')

@section('content')
<div class="row min-h-50vh">
    <div class="col-12 text-center mt-lg-0 mt-4">
        <h1 class="fw-bold">Term & Condition</h1>
    </div>
    <div class="col-12 col-lg-10 offset-lg-1">
        <p>{!! $data !!}</p>
    </div>
</div>
@stop
