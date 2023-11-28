@extends('layouts.default')

@section('cover-content')
<div class="px-3 py-2 bg-primary lazy text-light">
    <div class="row">
        <div class="col-10 d-flex align-items-center">
            <h4>View your booking</h4>
        </div>
        <div class="col-2 text-center">
            <p class="mb-2">status</p>
            <span @class([
                'bg-light',
                'px-4',
                'py-1',
                'fw-bold',
                'rounded',
                'text-second-color' => $booking['status'] == 'CO',
                'text-main-color-2' => $booking['status'] == 'DR',
                'text-secondary' => $booking['status'] == 'VO'
            ])>{{ $booking_status[$booking['status']] }}</span>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <h4 class="mb-0">Passenger(s)</h4>
        <p class="mb-2">Passenger detail</p>
        <div class="row bg-booking-payment-passenger mx-3 p-4 mb-5">
            <div class="col-12">
                <div class="row" id="payment-passenger-detail">
                    @foreach($customers as $key => $customer)
                        <h6 class="fw-bold mb-1">{{ $key }}</h6>
                        @foreach($customer as $cus)
                            <div class="d-flex">
                                <p class="ms-3">{{ $cus['name'] }}</p>
                                <p class="ms-3"><strong class="fw-bold">Date of birth :</strong> xxxx</p>
                                @if($cus['email'] != null)
                                    <p class="ms-3"><strong class="fw-bold">Email :</strong> {{ $cus['email'] }} <span class="badge bg-primary-soft">Lead passenger</span></p>
                                @endif
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>

        <h4 class="mb-0">Booking</h4>
        <p class="mb-2">Detail</p>
        <div class="row bg-booking-payment-passenger mx-3 p-4 mb-5">
            <div class="col-12">
                <div class="row" id="payment-passenger-detail">
                    @foreach($booking['route'] as $route)
                    <div class="col-3">
                        <h6 class="fw-bold">From</h6>
                        <div style="line-height: 18px;">
                            <p class="mb-0">
                                {{ $route['station_from'] }}
                                @if($route['station_from_pier'] != null) ({{ $route['station_from_pier'] }}) @endif
                                @if($route['station_from_nickname'] != null) [{{ $route['station_from_nickname'] }}] @endif
                            </p>
                            <small>{{ $booking['depart_date'] }}</small><br/>
                            <small>{{ $route['depart_time'] }}</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <h6 class="fw-bold">To</h6>
                        <div style="line-height: 18px;">
                            <p class="mb-0">
                                {{ $route['station_to'] }} 
                                @if($route['station_to_pier'] != null) ({{$route['station_to_pier']}}) @endif
                                @if($route['station_to_nickname'] != null) [{{ $route['station_to_nickname'] }}] @endif
                            </p>
                            <small>{{ $booking['depart_date'] }}</small><br/>
                            <small>{{ $route['arrive_time'] }}</small>
                        </div>
                    </div>
                    <div class="col-3"></div>
                    <div class="col-3"></div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@stop