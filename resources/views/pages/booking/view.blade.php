@extends('layouts.default')

@section('head_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('cover-content')
<div class="px-3 py-2 bg-primary lazy text-light">
    <div class="row">
        <div class="col-6 col-lg-9 offset-lg-1 d-flex align-items-center">
            <h4 class="my-2" style="line-height: 20px;">View your booking<br/>
                <span class="smaller mb-0" id="booking-number">{{ $booking['booking_number'] }}</span>
            </h4>
        </div>
        <div class="col-6 col-lg-2 text-center">
            <p class="mb-1">status</p>
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
    <div class="col-12 py-4 px-1 px-lg-5">
        {{-- Booking Detail --}}
        <h4 class="mb-2 fw-bold">Itinerary Booking NO {{ $booking['booking_number'] }}</h4>
        <div class="row bg-booking-payment-passenger mx-3 p-3 mb-5 rounded">
            <div class="col-12">
                <div class="row depart-litinerary">
                    @php
                        $_route = $booking['route'][0]
                    @endphp
                    <div class="col-12">
                        <h4>{{ $_route['station_from'] }} @if($_route['station_from_pier'] != null) ({{ $_route['station_from_pier'] }}) @endif -
                            {{ $_route['station_to'] }} @if($_route['station_to_pier'] != null) ({{ $_route['station_to_pier'] }}) @endif
                        </h4>
                    </div>
                    <div class="col-12">
                        @php
                            $_type = $booking['trip_type'] == 'multi-trip' ? $trip_type : ['Depart', 'Return']
                        @endphp
                        @foreach ($booking['route'] as $index => $route)
                            <x-booking-view-itinerary
                                :trip="$trip_type[$index]"
                                :type="$_type[$index]"
                                :route="$route"
                                :passengers="$passengers"
                                :trip_date="$booking['depart_date']"
                                :addons="$booking['extra_addons'][$index]['addons']"
                                :icon_url="$icon_url"
                                :icons="$route['icons']"
                                :totalamt="$booking['payment'][0]['totalamt']"
                            />
                        @endforeach
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 text-end pt-3 pe-4">
                        @foreach ($route_payments as $rp)
                            @if ($rp['amount'] < 0)
                                <h6 class="d-flex justify-content-end align-items-end">
                                    {!! $rp['title'] !!}
                                    <p class="sum-amount text-end mb-0 ms-3">
                                        {{ number_format($rp['amount']) }}
                                    </p>
                                </h6>
                            @endif
                        @endforeach

                        @foreach ($premium_payments as $pp)
                            <h6 class="d-flex justify-content-end align-items-end">
                                {!! $pp['title'] !!}
                                <p class="sum-amount text-end mb-0 ms-3">
                                    {{ number_format($pp['amount']) }}
                                </p>
                            </h6>
                        @endforeach

                        @foreach ($addon_payments as $ap)
                            @if ($ap['amount'] < 0)
                                <h6 class="d-flex justify-content-end align-items-end">
                                    {!! $ap['title'] !!}
                                    <p class="sum-amount text-end mb-0 ms-3">
                                        {{ number_format($ap['amount']) }}
                                    </p>
                                </h6>
                            @endif
                        @endforeach

                        <hr/>
                        <h5 class="d-flex justify-content-end align-items-end">Total THB <p class="sum-amount text-end mb-0 ms-3">{{ number_format($booking['payment'][0]['totalamt']) }}</p></h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- Passenger --}}
        <h4 class="mb-0 fw-bold">Passenger(s)</h4>
        <p class="mb-2">Passenger detail</p>
        <div class="row bg-booking-payment-passenger mx-3 p-4 mb-5 border rounded">
            <div class="col-12">
                <x-booking-view-passenger
                    :customers="$customers"
                />
            </div>
        </div>

        {{-- Payment method --}}
        @if($booking['do_update'])
            @if($booking['ispayment'] == 'N')
            <h4 class="mb-0 fw-bold">Payment</h4>
            <p class="mb-0">Select payment method</p>
            <div class="row mx-3 mb-5 mt-3">
                <div class="col-12 text-center mb-4 ps-0 pe-0">
                    <form method="POST" action="{{ route('payment-link') }}">
                        @csrf
                        <p class="mb-0 text-start ms-0 ms-lg-4">Select a payment to complete booking</p>
                        <div class="text-start">
                            <x-booking-payment-list
                                :bg="_('#fae5d7')"
                            />
                        </div>
                        <div class="text-end mt-2">
                            <input type="hidden" name="payments" value="{{ $booking['payment'][0]['payment_id'] }}">
                            <button type="submit" class="btn button-green-bg rounded px-5 py-2 btn-confirm-payment" disabled>Payment</button>
                        </div>
                    </form>
                </div>
            @elseif($booking['ispayment'] == 'Y')
                <div class="col-12 text-center mb-3">
                    <a href="{{ route('payment-print', ['bookingno' => $booking['booking_number']]) }}" class="btn button-blue-bg rounded px-5 py-2" target="_blank">Print Bill</a>
                </div>
            @endif
        @endif
    </div>
</div>
@stop

@section('script')
@include('pages.payment.modal_extraservice')
@include('pages.payment.modal_addperson')
@include('pages.payment.modal_editcustomer')
<script>
    const booking_current = `{{ $booking['booking_number'] }}`
</script>
<script src="{{ asset('assets/js/app/payment.js') }}"></script>
@stop
