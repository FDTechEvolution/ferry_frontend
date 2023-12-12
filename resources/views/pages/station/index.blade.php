@extends('layouts.default')

@section('content')
<div class="row min-h-50vh">
    <div class="col-12">
        <h1>Most Popular</h1>
        <div class="row px-5">
            @foreach($section as $section_key => $stations)
            <div class="col-12 mb-4 card">
                <div class="card-body">
                    <h4 class="text-main-color-2">{{ $section_key }}</h4>
                    <ul>
                        @foreach($stations as $station)
                            <li>{{ $station['name'] }} @if($station['piername'] != NULL) ({{ $station['piername'] }}) @endif</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@stop