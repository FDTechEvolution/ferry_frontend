@extends('layouts.default')

@section('content')
<div class="row min-h-50vh">
    <div class="col-12">
        <h1>Promotion</h1>
        <div class="row">
            <div class="col-12 col-lg-4 mb-4  card card-body">
                <h4 class="mb-4">{{ $promotion['title'] }}</h4>
                <h4>Code : <span class="text-main-color-2">{{ $promotion['code'] }}</span></h4>
            </div>
        </div>
    </div>
</div>
@stop