@extends('layouts.default')

@section('cover-content')
    @if($isType != '')
    <div class="px-3 py-2 bg-booking-cover lazy text-light">
        <div class="row">
            <div class="col-2 col-lg-1 d-flex align-items-center justify-content-end">
                <i class="fa-solid fa-ship fs-1"></i>
            </div>
            <div class="col-10 col-lg-7 d-flex align-items-center">
                <a tabindex="0" class="btn btm-sm btn-link text-light popover-destinations" role="button"
                    data-bs-toggle="popover" data-bs-placement="bottom" data-bs-trigger="focus" data-bs-html="true"
                    data-bs-content="">
                    <i class="fa-solid fa-location-dot"></i> Destinations <i class="fi fi-arrow-down ms-1"></i>
                </a>
            </div>
            <div class="col-6 col-lg-2 py-0 border-start-none-mobile border-start text-center">
                <p class="mb-1">Passenger</p>
                <p class="mb-0 d-flex justify-content-evenly align-items-end align-middle">
                    <x-booking-passenger-icon :passenger="$passenger" />
                </p>
                @if($passenger[0] != 0)
                    <input type="hidden" id="passenger-adult" value="{{ $passenger[0] }}" disabled>
                @endif
                @if($passenger[1] != 0)
                    <input type="hidden" id="passenger-child" value="{{ $passenger[1] }}" disabled>
                @endif
                @if($passenger[2] != 0)
                    <input type="hidden" id="passenger-infant" value="{{ $passenger[2] }}" disabled>
                @endif
            </div>
            <div class="col-6 col-lg-2 border-start text-center">
                <p class="mb-1">Total</p>
                THB <span class="ms-2" id="sum-price">0.00</span>
            </div>
        </div>
    </div>
    @endif
@stop

@section('content')
<a href="{{ route('home') }}" class="btn btn-sm btn-secondary border-radius-10 d-none" id="btn-back-to-home" style="margin-top: -30px;"><< Back</a>
<ol class="process-steps process-steps-primary text-muted mb-3">
	<li class="process-step-item position-relative complete" data-step="booking"><span class="ps-3 progress-step-name">{{ $isType != '' ? $isType : 'Booking' }}</span></li>
	<li class="process-step-item position-relative text-primary active" data-step="select"><span class="ps-3 progress-step-name">Select</span></li>
    <li class="process-step-item position-relative" data-step="premium"><span class="ps-2 progress-step-name">Premium Flex</span></li>
	<li class="process-step-item position-relative" data-step="passenger"><span class="ps-2 progress-step-name">Passenger info</span></li>
    <li class="process-step-item position-relative" data-step="extra"><span class="ps-2 progress-step-name">Extra services</span></li>
    <li class="process-step-item position-relative" data-step="payment"><span class="ps-3 progress-step-name">Payment</span></li>
</ol>

<div class="row min-h-50vh">
    <div class="col-12">
        @if($isType != '')
        <form novalidate class="bs-validate" id="booking-form" method="POST" action="{{ route('booking-multi-confirm') }}">
            @csrf
            <div class="procress-step d-none"></div>
            <div class="procress-step">
                <!-- booking select -->
                @include('pages.booking.multi-island.booking-select')
            </div>
            <div class="procress-step d-none">
                <!-- booking premium flex -->
                <x-booking-premium-flex />
            </div>
            <div class="procress-step d-none">
                <!-- booking passenger -->
                @include('pages.booking.multi-island.booking-passenger')
            </div>
            <div class="procress-step d-none">
                <!-- booking extra -->
                @include('pages.booking.multi-island.booking-extra')
            </div>
            <div class="procress-step d-none">
                <!-- booking payment -->
                @include('pages.booking.multi-island.booking-payment')
            </div>

            <div class="row mt-3">
                <div class="col-6">
                    <button type="button" class="btn btn-sm btn-secondary border-radius-10" id="progress-prev" disabled><< Back</button>
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
                    <x-button-green
                        id="progress-payment"
                        class="btn-sm d-none"
                        :type="_('submit')"
                        :text="_('Book / Payment')"
                        disabled
                    />
                </div>
            </div>
        </form>
        @endif
    </div>
</div>
@stop

@section('script')
<style>
    .popover {
        --bs-popover-max-width: 360px;
    }
    .popover-body {
        --bs-popover-max-width: 360px;
    }
    p.popover-destination-list:last-child {
        margin-bottom: 0;
    }
</style>

<script src="{{ asset('assets/js/app/progress_bar3.js') }}"></script>
@stop
