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
        <h4 class="mb-0 fw-bold">Passenger(s)</h4>
        <p class="mb-2">Passenger detail</p>
        <div class="row bg-booking-payment-passenger mx-3 p-4 mb-5 border rounded">
            <div class="col-12">
                <div class="row mb-2" id="payment-passenger-detail">
                    @foreach($customers as $key => $customer)
                        @if($key === 'ADULT')
                            <h6 class="fw-bold mb-1">Adult</h6>
                            @foreach($customer as $cus)
                                <div class="d-block d-lg-flex">
                                    <p class="ms-1 ms-lg-3 mb-0">{{ $cus['name'] }}</p>
                                    <p class="ms-1 ms-lg-3 mb-0"><strong class="fw-bold">Date of birth :</strong> {{ date_format(date_create($cus['birth_day']), 'd/m/Y') }}</p>
                                    @if($cus['email'] != null)
                                        <p class="ms-1 ms-lg-3 mb-0"><strong class="fw-bold">Email :</strong> {{ $cus['email'] }} <span class="badge bg-primary-soft">Lead passenger</span></p>
                                    @endif
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                    @foreach($customers as $key => $customer)
                        @if($key === 'CHILD')
                            <h6 class="fw-bold mb-1">Child</h6>
                            @foreach($customer as $cus)
                                <div class="d-flex">
                                    <p class="ms-1 ms-lg-3 mb-0">{{ $cus['name'] }}</p>
                                    <p class="ms-1 ms-lg-3 mb-0"><strong class="fw-bold">Date of birth :</strong> {{ date_format(date_create($cus['birth_day']), 'd/m/Y') }}</p>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                    @foreach($customers as $key => $customer)
                        @if($key === 'INFANT')
                            <h6 class="fw-bold mb-1">Infant</h6>
                            @foreach($customer as $cus)
                                <div class="d-flex">
                                    <p class="ms-1 ms-lg-3 mb-0">{{ $cus['name'] }}</p>
                                    <p class="ms-1 ms-lg-3 mb-0"><strong class="fw-bold">Date of birth :</strong> {{ date_format(date_create($cus['birth_day']), 'd/m/Y') }}</p>
                                </div>
                            @endforeach
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-12 text-end">
                @if($booking['do_update'])
                    <button class="btn btn-sm button-orange-bg rounded py-1 px-5" data-bs-toggle="modal" data-bs-target="#edit-customer">Edit</button>
                @endif
            </div>
        </div>

        <h4 class="mb-0 fw-bold">Booking No.{{ $booking['booking_number'] }}</h4>
        <p class="mb-2">Detail</p>
        <div class="row bg-booking-payment-passenger mx-3 p-4 mb-5 border rounded">
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
                                    @foreach($customer as $cus)
                                        <p class="mb-1 ms-2">{{ $cus['name'] }}</p>
                                    @endforeach
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

        @if($booking['do_update'])
        <div class="row bg-booking-payment-passenger mx-3 p-4 mb-5 border rounded d-none">
            <div class="col-12">
                <h4 class="mb-0 fw-bold">Add Multiple Trip</h4>
                <form method="POST" action="{{ route('booking-new') }}">
                    @csrf
                    <input type="hidden" name="bookingno" value="{{ $booking['booking_number'] }}">
                    <input type="hidden" name="booking_id" value="{{ $booking['id'] }}">
                    <div class="row px-3 mt-2">
                        <div class="col-12 col-lg-3">
                            <div class="form-floating mb-3">
                                <select required class="form-select form-select-sm" name="from" id="form-select" aria-label="booking station">
                                    <option value="" disabled>Select Original</option>
                                    <option value="{{ $station_from['id'] }}" selected>{{ $station_from['name'] }} @if($station_from['piername'] != null) ({{$station_from['piername']}}) @endif</option>
                                </select>
                                <label for="form-select">From</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-floating mb-3">
                                <select required class="form-select form-select-sm" name="to" id="to-select" aria-label="booking station">
                                    <option value="" selected disabled>Select Destination</option>
                                    @if(!empty($station_to))
                                        @foreach($station_to as $section_key => $stations)
                                            <optgroup label="{{ $section_key }}">
                                                @foreach($stations as $index => $station)
                                                    <option value="{{ $station['id'] }}">{{ $station['name'] }}</option>
                                                @endforeach
                                            </optgroup>
                                        @endforeach
                                    @else
                                        <option value="" disabled>No route.</option>
                                    @endif
                                </select>
                                <label for="to-select">To</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-floating mb-3">
                                <input required type="text" name="depart_date" class="form-control form-control-sm datepicker add-multi-trip-depart"
                                    data-show-weeks="true"
                                    data-today-highlight="false"
                                    data-clear-btn="false"
                                    data-autoclose="true"
                                    data-format="DD/MM/YYYY"
                                    autocomplete="off"
                                    placeholder="Departure date"
                                    disabled>
                                <label class="text-secondary">Departure date</label>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="form-floating mb-3">
                                <input required type="text" name="return_date" class="form-control form-control-sm datepicker add-multi-trip-return"
                                    data-show-weeks="true"
                                    data-today-highlight="false"
                                    data-clear-btn="false"
                                    data-autoclose="true"
                                    data-format="DD/MM/YYYY"
                                    autocomplete="off"
                                    placeholder="Return date"
                                    disabled>
                                <label class="text-secondary">Return date</label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            @foreach($station_to_time as $station_key => $times)
                            <div class="row station-depart-hide station-index-{{ $station_key }} d-none">
                                <div class="col-12 mb-1">
                                    <div class="row fw-bold">
                                        <div class="col-3">From</div>
                                        <div class="col-3">To</div>
                                        <div class="col-2 text-center">Depart Time</div>
                                        <div class="col-2 text-center">Arrive Time</div>
                                        <div class="col-1 text-center">Select</div>
                                    </div>
                                </div>
                                @foreach($times as $t_index => $time)
                                <div class="col-12 mb-2">
                                    <div class="row">
                                        <div class="col-3">{{ $station_from['name'] }} @if($station_from['piername'] != null) ({{$station_from['piername']}}) @endif</div>
                                        <div class="col-3">{{ $time['station_name'] }}</div>
                                        <div class="col-2 text-center">{{ date_format(date_create($time['depart']), 'H:i') }}</div>
                                        <div class="col-2 text-center">{{ date_format(date_create($time['arrive']), 'H:i') }}</div>
                                        <div class="col-1 text-center"><input required type="radio" class="radio-input" name="route_id" value="{{ $time['id'] }}"></div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                        <div class="col-12 text-end">
                            <button type="submit" class="btn btn-sm btn-light text-main-color rounded-pill fw-bold py-1">Book Now</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <h4 class="mb-0 fw-bold">Extra Services</h4>
        <p class="mb-2">please select youradditional services</p>
        <div class="row mx-3 mb-5">
            <div class="col-12 col-lg-4 mb-4">
                <div class="card">
                    <img src="{{ asset('pad-thai_addon.jpg') }}" class="card-img-top" alt="meal" style="min-height: 200px; max-height: 200px;">
                    <div class="card-body bg-booking-payment-extra">
                        <h5 class="card-title">Meal</h5>
                        <p class="card-text">Keep up your energy level with reserved meals and beverages.</p>
                        @if($booking['do_update'])
                            <div class="text-center mt-2">
                                <button class="btn btn-sm button-orange-bg rounded py-1 mt-1" @if(empty($addons['meals'])) disabled @endif data-bs-toggle="modal" data-bs-target="#extra-services">Select</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 mb-4">
                <div class="card">
                    <img src="{{ asset('cover/cover_03.webp') }}" class="card-img-top" alt="activity" style="min-height: 200px; max-height: 200px;">
                    <div class="card-body bg-booking-payment-extra">
                        <h5 class="card-title">Daytrip</h5>
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        @if($booking['do_update'])
                            <div class="text-center mt-2">
                                <button class="btn btn-sm button-orange-bg rounded py-1 mt-1" @if(empty($addons['activities'])) disabled @endif>Select</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($booking['do_update'])
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
        @endif
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
