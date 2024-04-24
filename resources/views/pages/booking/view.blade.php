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
    <div class="card card-body col-12 py-4 px-1 px-lg-5">
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
                        @foreach ($booking['route'] as $index => $route)
                            <x-booking-view-itinerary
                                :trip="$booking['trip_type']"
                                :type="_('Depart')"
                                :route="$_route"
                                :passengers="$passengers"
                                :trip_date="$booking['depart_date']"
                                :addons="$route_addon"
                                :icon_url="$icon_url"
                                :icons="$route['icons']"
                                :totalamt="$booking['payment'][0]['totalamt']"
                            />
                        @endforeach
                    </div>
                </div>

                <div class="row pt-2 pe-0 pe-lg-0">
                    <div class="col-12 col-lg-8 offset-lg-4 pe-0 pe-lg-5">
                        <h5 class="d-flex justify-content-end align-items-end">Total THB <p class="sum-amount text-end mb-0 ms-3">{{ number_format($booking['payment'][0]['totalamt']) }}</p></h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- old version --}}
        <div class="row bg-booking-payment-passenger mx-3 p-4 mb-5 border rounded d-none">
            <div class="col-12 mb-3">
                <div class="row" id="payment-passenger-detail">
                    @foreach($booking['route'] as $route)
                        <div class="col-12 mb-4">
                            <div class="row">
                                <div class="col-12 col-lg-3">
                                    <h6 class="fw-bold mb-1">From</h6>
                                    <p class="mb-1 ms-2">
                                        {{ $route['station_from'] }}
                                        @if($route['station_from_pier'] != null) ({{ $route['station_from_pier'] }}) @endif
                                        @if($route['station_from_nickname'] != null) [{{ $route['station_from_nickname'] }}] @endif
                                    </p>
                                    <div style="line-height: 15px;">
                                        <p class="small mb-1 ms-2">{{ date_format(date_create($booking['depart_date']), 'd/m/Y') }}</p>
                                        <p class="small mb-0 ms-2">{{ date_format(date_create($route['depart_time']), 'H:i') }}</p>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 mb-3">
                                    <h6 class="fw-bold mb-1">To</h6>
                                    <p class="mb-1 ms-2">
                                        {{ $route['station_to'] }}
                                        @if($route['station_to_pier'] != null) ({{$route['station_to_pier']}}) @endif
                                        @if($route['station_to_nickname'] != null) [{{ $route['station_to_nickname'] }}] @endif
                                    </p>
                                    <div style="line-height: 15px;">
                                        <p class="small mb-1 ms-2 depart-last-date">{{ date_format(date_create($booking['depart_date']), 'd/m/Y') }}</p>
                                        <p class="small mb-0 ms-2">{{ date_format(date_create($route['arrive_time']), 'H:i') }}</p>
                                    </div>
                                    <div class=" mt-2 text-end border-bottom">Total : {{ number_format($route['amount']) }} THB</div>
                                </div>
                                <div class="col-12 col-lg-3 mb-3 pb-2 border-bottom-sm">
                                    <h6 class="fw-bold mb-1">Passenger</h6>
                                    {{-- @foreach($customer as $cus)
                                        <p class="mb-1 ms-2">{{ $cus['name'] }}</p>
                                    @endforeach --}}
                                    {{-- @if($booking['do_update'])
                                        <button class="btn btn-sm button-orange-bg rounded py-1 mt-1" data-bs-toggle="modal" data-bs-target="#add-person">Add person</button>
                                        <form method="POST" id="form-confirm-merge" action="{{ route('booking-record') }}">
                                            @csrf
                                            <input type="hidden" name="booking_number" id="booking-number-current" value="{{ $booking['booking_number'] }}">
                                            <input type="hidden" name="booking_number_new" id="booking-number-new" value="">
                                        </form>
                                    @endif --}}
                                </div>
                                <div class="col-12 col-lg-3 text-start">
                                    <h6 class="fw-bold mb-1">Extra detail</h6>
                                    @foreach ($route_addon as $r_addon)
                                        <p class="small mb-1 pb-1 text-start border-bottom ms-2">
                                            <span class="r-addon-name fw-bold">{{ $r_addon['name'] }}</span><br/>
                                            <span class="r-addon-description">{{ $r_addon['description'] }}</span>
                                        </p>
                                    @endforeach

                                    @foreach($booking['extra'] as $extra)
                                        @if($extra != NULL)
                                            <p class="mb-0 small">{{ $extra['name'] }}</p>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-12 mt-3 border-top">
                <div class="row">
                    <div class="col-12 text-end pt-3 pe-2">
                        @php
                            $line_amount = 0;
                        @endphp
                        @foreach($payment_lines as $line)
                            <h6 class="d-lg-flex justify-content-end align-items-end mb-2 pb-2 border-sm-bottom">{!! $line['title'] !!} :
                                <p class="sum-of-payment w--15 w--none me-2 mb-0">
                                    <span class="fw-bold border-bottom-amount">
                                        @if($line['type'] == 'ADDON' && strpos($line['title'],"bus") != '' ||
                                            $line['type'] == 'ADDON' && strpos($line['title'],"boat") != '' ||
                                            $line['type'] == 'ADDON' && strpos($line['title'],"taxi") != ''
                                        )
                                            {{ $passenger }} x {{ number_format(($line['amount']/$passenger), 2) }}
                                        @else
                                            {{ number_format($line['amount'], 2) }}
                                        @endif
                                    </span>
                                    <small class="smaller border-bottom-amount">THB</small>
                                </p>
                            </h6>
                            @php
                                $line_amount += $line['amount'];
                            @endphp
                        @endforeach
                        <h6 class="d-flex justify-content-end align-items-end pt-3 border-top"><span class="fw-bold">Total :</span>
                            <p class="sum-of-payment w--15 w--none me-2 mb-0"><span class="fw-bold ms-3">{{ number_format($line_amount + $booking['amount_extra'], 2) }}</span> <small class="smaller">THB</small></p>
                        </h6>
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
    </div>


    {{-- Payment method --}}
    @if($booking['do_update'])
        @if($booking['ispayment'] == 'N')
        <div class="col-12 text-center mb-4 ps-0 pe-0 mt-4">

            <button type="button" class="btn button-green-bg rounded px-1 px-lg-5 py-2" data-bs-toggle="collapse" href="#collapsePayment" role="button" aria-expanded="false" aria-controls="collapsePayment">Payment</button>
            <div class="collapse mt-2" id="collapsePayment">
                <div class="card card-body bg-white">
                    <form method="POST" action="{{ route('payment-link') }}">
                        @csrf
                        <div class="card">
                            <div class="card-body">
                                <div class="row fw-bold mb-2">
                                    <div class="col-1 text-center">#</div>
                                    <div class="col-3">Payment Number</div>
                                    <div class="col-2">Amount</div>
                                    <div class="col-1">Status</div>
                                </div>

                                @foreach($booking['payment'] as $index => $payment)
                                    <label class="row">
                                        <div class="col-1 text-center">
                                            <input class="form-check-input form-check-input-primary" type="radio" name="payments" id="payment-method-{{ $index }}" value="{{ $payment['payment_id'] }}" checked>
                                        </div>
                                        <div class="col-3">{{ $payment['paymentno'] }}</div>
                                        <div class="col-2">{{ number_format($payment['totalamt']) }}</div>
                                        <div class="col-1">{!! $is_paid[$payment['ispaid']] !!}</div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <hr class="my-3"/>
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-0 text-start">Select a payment to complete booking</p>
                                <div class="text-start">
                                    <x-booking-payment-list />
                                </div>
                                <div class="text-end mt-2">
                                    <button type="submit" class="btn button-green-bg rounded px-5 py-2 btn-confirm-payment" disabled>Confirm</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @elseif($booking['ispayment'] == 'Y')
        <div class="col-12 text-center mb-3">
            <a href="{{ route('payment-print', ['bookingno' => $booking['booking_number']]) }}" class="btn button-blue-bg rounded px-5 py-2" target="_blank">Print Bill</a>
        </div>
        @endif
    @endif
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
