@extends('layouts.default')

@section('cover-content')
    @if($isType != '')
    <div class="px-3 py-2 bg-booking-cover lazy text-light">
        <div class="row">
            <div class="col-2 col-lg-1 d-flex align-items-center justify-content-end">
                <i class="fa-solid fa-ship fs-1"></i>
            </div>
            <div class="col-10 col-lg-7">
                <p class="my-2 mb-1 booking-route-depart-roundtrip"><span class="fw-bold">Depart : </span>
                    @if(!empty($depart_routes))
                        <small>
                            {{ $station_depart['from'] }}
                            <span class="mx-2">To</span>
                            {{ $station_depart['to'] }}
                            <span class="ms-4">[ {{ $depart_date }}</span><span class="set-time-route-depart"></span> ]
                        </small>
                    @else
                        <small>Sorry. No depart route.</small>
                    @endif
                </p>
                <p class="my-2 mt-1 booking-route-return-roundtrip"><span class="fw-bold">Return : </span>
                    @if(!empty($return_routes))
                        <small>
                            {{ $station_return['from'] }}
                            <span class="mx-2">To</span>
                            {{ $station_return['to'] }}
                            <span class="ms-4">[ {{ $return_date }}</span><span class="set-time-route-return"></span> ]
                        </small>
                    @else
                        <small>Sorry. No return route.</small>
                    @endif
                </p>
            </div>
            <div class="col-6 col-lg-2 py-0 border-start-none-mobile border-start text-center">
                <p class="mb-1">Passenger</p>
                <p class="mb-0 d-flex justify-content-evenly align-items-end align-middle">
                    <x-booking-passenger-icon :passenger="$passenger" />
                </p>
                @if($passenger[0] > 0)
                    <input type="hidden" id="passenger-adult" value="{{ $passenger[0] }}" disabled>
                @endif
                @if($passenger[1] > 0)
                    <input type="hidden" id="passenger-child" value="{{ $passenger[1] }}" disabled>
                @endif
                @if($passenger[2] > 0)
                    <input type="hidden" id="passenger-infant" value="{{ $passenger[2] }}" disabled>
                @endif
            </div>
            <div class="col-6 col-lg-2 border-start text-center">
                <p class="mb-1">Total</p>
                THB <span class="ms-2" id="sum-price">0</span>
            </div>
        </div>
    </div>
    @endif
@stop

@section('content')
<div class="row">
    <div class="col-12 col-lg-12">
        <a href="{{ route('home') }}" class="btn btn-sm btn-secondary border-radius-10 d-none position-absolute" id="btn-back-to-home" style="margin-top: -40px;"><< Back</a>
        <ol class="process-steps process-steps-primary text-muted mb-3">
            <li class="process-step-item position-relative complete" data-step="booking">
                <span class="ps-3 progress-step-name">
                    <img src="{{ asset('icons/booking/trip.png') }}" width="24" class="me-1">
                    <span class="progress-step-text-name">{{ $isType != '' ? $isType : 'Booking' }}</span>
                </span>
            </li>
            <li class="process-step-item position-relative text-primary active" data-step="select">
                <span class="ps-2 progress-step-name">
                    <img src="{{ asset('icons/booking/select.png') }}" width="24" class="me-1">
                    <span class="progress-step-text-name">Select</span>
                </span>
            </li>
            <li class="process-step-item position-relative" data-step="premium">
                <span class="ps-2 progress-step-name">
                    <img src="{{ asset('icons/booking/premium-flex.png') }}" width="24" class="me-1">
                    <span class="progress-step-text-name">Premium Flex</span>
                </span>
            </li>
            <li class="process-step-item position-relative" data-step="passenger">
                <span class="ps-2 progress-step-name">
                    <img src="{{ asset('icons/booking/passenger-info.png') }}" width="24" class="me-1">
                    <span class="progress-step-text-name">Passenger info</span>
                </span>
            </li>
            <li class="process-step-item position-relative" data-step="extra">
                <span class="ps-2 progress-step-name">
                    <img src="{{ asset('icons/booking/extra-service.png') }}" width="24" class="me-1">
                    <span class="progress-step-text-name">Extra services</span>
                </span>
            </li>
            <li class="process-step-item position-relative" data-step="payment">
                <span class="ps-2 progress-step-name">
                    <img src="{{ asset('icons/booking/payment.png') }}" width="24" class="me-1">
                    <span class="progress-step-text-name">Payment</span>
                </span>
            </li>
        </ol>

        <div class="row min-h-50vh">
            <div class="col-12">
                @if($isType != '')
                <form novalidate class="bs-validate" id="booking-form" method="POST" action="{{ route('bookings-confirm') }}">
                    @csrf
                    <div class="procress-step d-none"></div>
                    <div class="procress-step show">
                        <!-- booking select -->
                        @include('pages.booking.round-trip.booking-select')
                    </div>
                    <div class="procress-step d-none">
                        <!-- booking premium flex -->
                        <x-booking-premium-flex :ispremiumflex="$freepremiumflex"/>
                    </div>
                    <div class="procress-step d-none">
                        <!-- booking passenger -->
                        @include('pages.booking.round-trip.booking-passenger')
                    </div>
                    <div class="procress-step d-none">
                        <!-- booking extra -->
                        @include('pages.booking.round-trip.booking-extra')
                    </div>
                    <div class="procress-step d-none">
                        <!-- booking payment -->
                        @include('pages.booking.round-trip.booking-payment')
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
    </div>
    <div class="col-12 col-lg-2 d-none">
        xxxxxxxxxxxx
    </div>
</div>
@stop

@section('script')
<script>
    let isStep = {{ $isType == '' ? 0 : 1 }}
</script>
<script src="{{ asset('assets/js/app/progress_bar2.js') }}"></script>
@stop
