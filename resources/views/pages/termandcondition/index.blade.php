@extends('layouts.default')

@section('content')
<div class="row min-h-50vh">
    <div class="col-12 text-center">
        <h1 class="fw-bold">Term & Condition</h1>
    </div>
    <div class="col-10 offset-1">
        <p>{!! $data !!}</p>
    </div>
</div>
@stop