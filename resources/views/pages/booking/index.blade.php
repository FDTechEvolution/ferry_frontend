@extends('layouts.default')

@section('cover-content')
    @if($isType != '')
    <div class="px-3 py-2 bg-primary lazy text-light">
        <div class="row">
            <div class="col-1 d-flex align-items-center justify-content-center">icon</div>
            <div class="col-7">
                <p class="mb-1">{{ $is_station['from'] }}</p>
                To
                <p class="mb-1">{{ $is_station['to'] }} <span class="ms-2">{{ $booking_date }}</span> <span class="ms-2 set-time-route-select"></span></p>
            </div>
            <div class="col-2 py-2 border-start">
                <p class="text-center mb-1">Adults</p>
                <p class="text-center mb-1">1</p>
            </div>
            <div class="col-2 border-start d-flex align-items-center justify-content-center">
                THB <span class="ms-2" id="sum-price">0.00</span>
            </div>
        </div>
    </div>
    @endif
@stop

@section('content')
<ol class="process-steps process-steps-primary text-muted mb-3">
	<li class="process-step-item complete" data-step="booking">{{ $isType != '' ? $isType : 'Booking' }}</li>
	<li class="process-step-item text-primary active" data-step="select">Select</li>
	<li class="process-step-item" data-step="passenger">Passenger info</li>
    <li class="process-step-item" data-step="extra">Extra services</li>
    <li class="process-step-item" data-step="payment">Payment</li>
</ol>

<div class="row">
    <div class="col-12">
        @if($isType != '')
        <div class="procress-step d-none"></div>
        <div class="procress-step d-none">
            <!-- booking select -->
            @include('pages.booking.booking-select')
        </div>
        <div class="procress-step d-none">
            <!-- booking passenger -->
            @include('pages.booking.booking-passenger')
        </div>
        <div class="procress-step d-none">
            <!-- booking extra -->
            @include('pages.booking.booking-extra')
        </div>
        <div class="procress-step d-none"><h1>Payment</h1></div>

        <div class="row mt-3">
            <div class="col-6">
                <button class="btn btn-sm btn-secondary border-radius-10" id="progress-prev" disabled><< Back</button>
            </div>
            <div class="col-6 text-end">
                <x-button-green
                    id="progress-next"
                    class="btn-sm"
                    :type="_('button')"
                    :text="_('Continue >>')"
                    disabled
                />
                <x-button-green
                    id="progress-next-passenger"
                    class="btn-sm d-none"
                    :type="_('button')"
                    :text="_('Continue >>')"
                    onClick="progressPassenger()"
                    disabled
                />
            </div>
        </div>
        @endif
    </div>
</div>
@stop

@section('script')
<script>
    let isStep = {{ $isType == '' ? 0 : 1 }}
</script>
<script src="{{ asset('assets/js/app/progress_bar.js') }}"></script>
@stop