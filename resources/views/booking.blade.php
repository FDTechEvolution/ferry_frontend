@extends('layouts.default')

@section('content')
<ol class="process-steps process-steps-primary text-muted mb-3">
	<li class="process-step-item complete">{{ $isType }}</li>
	<li class="process-step-item text-primary active">Select</li>
	<li class="process-step-item">Passenger info</li>
    <li class="process-step-item">Extra services</li>
    <li class="process-step-item">Payment</li>
</ol>

<div class="row">
    <div class="col-12">
        @if($routes != '')
            @foreach($routes as $route)
                <div class="row p-2 px-4 mb-4 border rounded booking-route-list">
                    <div class="col-12 pb-2 border-0 border-bottom border-2 border-light">
                        <div class="float-start">
                            <span class="me-2">Depart</span>
                            <span class="station-name me-4">{{ $route['station_from']['name'] }} @if($route['station_from']['piername'] != NULL) ({{$route['station_from']['piername']}}) @endif</span>
                            <span class="me-2">Arrival</span>
                            <span class="station-name">{{ $route['station_to']['name'] }} @if($route['station_to']['piername'] != NULL) ({{$route['station_to']['piername']}}) @endif</span>
                        </div>
                        <div class="float-end">
                            <span>Fare</span>
                        </div>
                    </div>

                    <div class="col-12 py-3 border-0 border-bottom border-2 border-light">
                        <div class="float-start d-flex align-items-center">
                            <span class="me-2">{{ $route['depart_time'] }}</span>
                            <span class="me-2">
                                <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">  
                                    <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"></path>  
                                    <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"></path>
                                </svg>
                            </span>
                            <div class="d-flex me-2">
                                @foreach($route['icons'] as $icon)
                                <div class="mw--48">
                                    <img src="{{ $icon_url }}{{ $icon['path'] }}" class="me-1 w-100">
                                </div>
                                @endforeach
                            </div>
                            <span class="me-2">
                                <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">  
                                    <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"></path>  
                                    <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"></path>
                                </svg>
                            </span>
                            <span class="me-2">{{ $route['arrive_time'] }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@stop