@extends('layouts.default')

@section('cover-content')
    @if($isType != '')
    <div class="px-3 py-2 bg-primary lazy text-light">
        <div class="row">
            <div class="col-1 d-flex align-items-center justify-content-center">icon</div>
            <div class="col-7">
                <p class="mb-1">{{ $is_station['from'] }}</p>
                To
                <p class="mb-1">{{ $is_station['to'] }} <span class="ms-2">{{ $booking_date }}</span></p>
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
	<li class="process-step-item complete">{{ $isType }}</li>
	<li class="process-step-item text-primary active">Select</li>
	<li class="process-step-item">Passenger info</li>
    <li class="process-step-item">Extra services</li>
    <li class="process-step-item">Payment</li>
</ol>

<div class="row min-h-50vh">
    <div class="col-12">
        @if($isType != '')
        <!-- Select -->
        @include('pages.booking.booking-select')

        @include('pages.booking.booking-passenger')

        <!-- Button -->
        <div class="row">
            <div class="col-6">
                <button class="btn btn-sm btn-secondary border-radius-10"><< Back</button>
            </div>
            <div class="col-6 text-end">
                <x-button-green
                    class="btn-sm"
                    :type="_('button')"
                    :text="_('Continue >>')"
                />
            </div>
        </div>
        @endif
    </div>
</div>
@stop

@section('script')
<script src="{{ asset('assets/js/app/booking.js') }}"></script>
@stop