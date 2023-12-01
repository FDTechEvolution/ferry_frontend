@extends('layouts.default')

@section('head_meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('cover-content')
<div class="px-3 py-2 bg-primary lazy text-light">
    <div class="row">
        <div class="col-9 offset-1 d-flex align-items-center">
            <h4 class="my-2">View your booking</h4>
        </div>
        <div class="col-2 text-center">
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
    @if($booking['ispayment'] == 'N')
    <div class="col-12 text-center mb-3">
        <form method="POST" action="{{ route('payment-link') }}">
            @csrf
            <input type="hidden" name="booking_number" value="{{ $booking['booking_number'] }}">
            <button type="submit" class="btn button-green-bg rounded px-5 py-2">Payment</button>
        </form>
    </div>
    @elseif($booking['ispayment'] == 'Y')
    <div class="col-12 text-center mb-3">
        <a href="{{ route('payment-print', ['bookingno' => $booking['booking_number']]) }}" class="btn button-blue-bg rounded px-5 py-2" target="_blank">Print Bill</a>
    </div>
    @endif
    <div class="col-12">
        <h4 class="mb-0 fw-bold">Passenger(s)</h4>
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

        <h4 class="mb-0 fw-bold">Booking</h4>
        <p class="mb-2">Detail</p>
        <div class="row bg-booking-payment-passenger mx-3 p-4 mb-5">
            <div class="col-12">
                <div class="row" id="payment-passenger-detail">
                    @foreach($booking['route'] as $route)
                        <div class="col-3">
                            <h6 class="fw-bold mb-1">From</h6>
                            <p class="mb-1">
                                {{ $route['station_from'] }}
                                @if($route['station_from_pier'] != null) ({{ $route['station_from_pier'] }}) @endif
                                @if($route['station_from_nickname'] != null) [{{ $route['station_from_nickname'] }}] @endif
                            </p>
                            <div style="line-height: 15px;">
                                <p class="small mb-1">{{ date_format(date_create($booking['depart_date']), 'd/m/Y') }}</p>
                                <p class="small mb-0">{{ date_format(date_create($route['depart_time']), 'H:i') }}</p>
                            </div>
                        </div>
                        <div class="col-3">
                            <h6 class="fw-bold mb-1">To</h6>
                            <p class="mb-1">
                                {{ $route['station_to'] }} 
                                @if($route['station_to_pier'] != null) ({{$route['station_to_pier']}}) @endif
                                @if($route['station_to_nickname'] != null) [{{ $route['station_to_nickname'] }}] @endif
                            </p>
                            <div style="line-height: 15px;">
                                <p class="small mb-1">{{ date_format(date_create($booking['depart_date']), 'd/m/Y') }}</p>
                                <p class="small mb-0">{{ date_format(date_create($route['arrive_time']), 'H:i') }}</p>
                            </div>
                        </div>
                        <div class="col-3 text-center">
                            <h6 class="fw-bold mb-1">Passenger</h6>
                            @foreach($customer as $cus)
                                <p class="mb-1">{{ $cus['name'] }}</p>
                            @endforeach
                            <button class="btn btn-sm button-orange-bg rounded py-1 mt-1" data-bs-toggle="modal" data-bs-target="#add-person">Add person</button>
                        </div>
                        <div class="col-3 text-center">
                            <h6 class="fw-bold mb-1">Extra detail</h6>
                            @foreach($booking['extra'] as $extra)
                                <p class="mb-0 small">{{ $extra['name'] }}</p>
                            @endforeach
                        </div>
                    @endforeach
                    <div class="col-12 text-end mt-3">
                        <button class="btn btn-sm button-orange-bg rounded py-1 px-5">Edit</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row bg-booking-payment-passenger mx-3 p-4 mb-5">
            <div class="col-12">
                <h4 class="mb-0 fw-bold">Add Multiple Trip</h4>
                <div class="row px-3 mt-2">
                    <div class="col-3">
                        <div class="form-floating mb-3">
                            <select required class="form-select form-select-sm" name="from[]" id="form-select" aria-label="booking station">
                                <option value="" selected>Select Original</option>
                                <option value="{{ $station_from[0]['station_to_id'] }}">{{ $route['station_to'] }} @if($route['station_to_pier'] != null) ({{$route['station_to_pier']}}) @endif</option>
                            </select>
                            <label for="form-select">From</label>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-floating mb-3">
                            <select required class="form-select form-select-sm" name="to[]" id="to-select" aria-label="booking station">
                                <option value="" selected disabled>Select Destination</option>
                                @foreach($station_to as $station)
                                    <option value="{{ $station['id'] }}">{{ $station['name'] }}</option>
                                @endforeach
                            </select>
                            <label for="to-select">To</label>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-floating mb-3">
                            <input required type="text" name="depart_date[]" class="form-control form-control-sm datepicker"
                                data-show-weeks="true"
                                data-today-highlight="true"
                                data-today-btn="true"
                                data-clear-btn="false"
                                data-autoclose="true"
                                data-date-start="today"
                                data-format="DD/MM/YYYY"
                                autocomplete="off"
                                placeholder="Departure date">
                            <label class="text-secondary">Departure date</label>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-floating mb-3">
                            <input required type="text" name="return_date[]" class="form-control form-control-sm datepicker"
                                data-show-weeks="true"
                                data-today-highlight="true"
                                data-today-btn="true"
                                data-clear-btn="false"
                                data-autoclose="true"
                                data-date-start="today"
                                data-format="DD/MM/YYYY"
                                autocomplete="off"
                                placeholder="Return date">
                            <label class="text-secondary">Return date</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h4 class="mb-0 fw-bold">Extra Services</h4>
        <p class="mb-2">please select youradditional services</p>
        <div class="row mx-3 mb-5">
            <div class="col-4">
                <div class="card">
                    <img src="{{ asset('pad-thai_addon.jpg') }}" class="card-img-top" alt="meal" style="min-height: 240px; max-height: 240px;">
                    <div class="card-body bg-booking-payment-extra">
                        <h5 class="card-title">Meal</h5>
                        <p class="card-text">Keep up your energy level with reserved meals and beverages.</p>
                        <div class="text-center mt-2">
                            <button class="btn btn-sm button-orange-bg rounded py-1 mt-1" @if(empty($addons['meals'])) disabled @endif data-bs-toggle="modal" data-bs-target="#extra-services">Select</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card">
                    <img src="{{ asset('cover/cover_03.webp') }}" class="card-img-top" alt="activity" style="min-height: 240px; max-height: 240px;">
                    <div class="card-body bg-booking-payment-extra">
                        <h5 class="card-title">Daytrip</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        <div class="text-center mt-2">
                            <button class="btn btn-sm button-orange-bg rounded py-1 mt-1" @if(empty($addons['activities'])) disabled @endif>Select</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row bg-warning-soft mx-3 p-4 mb-5">
            <div class="col-12">
                <h4 class="mb-1 text-dark fw-bold">Contact Services</h4>
                <textarea class="form-control" rows="6"></textarea>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-12 text-end">
                <button class="btn btn-sm button-green-bg">Update</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
@include('pages.payment.modal_extraservice')
@include('pages.payment.modal_addperson')
<script>
    const booking_current = `{{ $booking['booking_number'] }}`
</script>
<script src="{{ asset('assets/js/app/payment.js') }}"></script>
@stop