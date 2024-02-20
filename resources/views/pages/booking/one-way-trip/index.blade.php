@extends('layouts.default')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

@section('cover-content')
    @if($isType != '')
    <div class="px-3 py-2 bg-booking-cover lazy text-light">
        <div class="row">
            @php
                $booking_date_1 = explode('/', $booking_date);
            @endphp
            <div class="col-2 col-lg-1 d-flex align-items-center justify-content-end">
                <i class="fa-solid fa-ship fs-1"></i>
            </div>
            <div class="col-10 col-lg-7 d-flex align-items-center">
                <p class="mb-1"><span class="fw-bold">Depart : </span> {{ $is_station['from'] }}
                <span class="mx-2">To</span>
                {{ $is_station['to'] }} <span class="ms-2"> | {{ date('l M d, Y', strtotime($booking_date_1[2].'-'.$booking_date_1[1].'-'.$booking_date_1[0])) }}</span> <span class="ms-2 set-time-route-select"></span></p>
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
                 <span class="ms-2" id="sum-price">0</span> THB
            </div>
        </div>
    </div>
    @endif
@stop

@section('content')

<div class="row">
    <div class="col-12 col-lg-9">
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
            <li class="process-step-item position-relative" data-step="extra">
                <span class="ps-2 progress-step-name">
                    <img src="{{ asset('icons/booking/extra-service.png') }}" width="24" class="me-1">
                    <span class="progress-step-text-name">Extra services</span>
                </span>
            </li>
            <li class="process-step-item position-relative" data-step="passenger">
                <span class="ps-2 progress-step-name">
                    <img src="{{ asset('icons/booking/passenger-info.png') }}" width="24" class="me-1">
                    <span class="progress-step-text-name">Passenger info</span>
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
                <form novalidate class="bs-validate" id="booking-form" method="POST" action="{{ route('booking-confirm') }}">
                    @csrf
                    <div class="procress-step d-none"></div>
                    <div class="procress-step d-none">
                        <!-- booking select -->
                        @include('pages.booking.one-way-trip.booking-select')
                    </div>
                    <div class="procress-step d-none">
                        <!-- booking premium flex -->
                        <x-booking-premium-flex
                            :ispremiumflex="$freepremiumflex"
                            :premium_flex="$premium_flex"
                        />
                    </div>
                    <div class="procress-step d-none">
                        <!-- booking extra -->
                        @include('pages.booking.one-way-trip.booking-extra')
                    </div>
                    <div class="procress-step d-none">
                        <!-- booking passenger -->
                        @include('pages.booking.one-way-trip.booking-passenger')
                    </div>
                    <div class="procress-step d-none">
                        <!-- booking payment -->
                        @include('pages.booking.one-way-trip.booking-payment')
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-6">
                            <a href="{{ route('home') }}" class="btn btn-sm btn-secondary border-radius-10 d-none" id="btn-back-to-home" style="margin-left: 0.5rem;"><< Back</a>
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
    <div class="col-12 col-lg-3 d-none d-lg-block">
        <div class="border bg-white rounded">
            <div class="your-booking-title p-3" style="background-color: #075ae8; border-radius: 5px 5px 0 0; border: 1px solid #075ae8;">
                <h5 class="mb-0 text-light">Booking Summary</h5>
            </div>
            <div class="your-booking-body p-3">
                <div class="your-booking-passenger border-bottom pb-2 mb-2">
                    <p class="fw-bold mb-0">{{ $passenger[0] + $passenger[1] + $passenger[2] }} Passenger(s)</p>
                    <div class="d-flex">
                        @if($passenger[0] != 0)
                            <p class="mb-0 small">{{ $passenger[0] }} Adult</p>
                        @endif
                        @if($passenger[1] != 0)
                            <p class="mb-0 small ms-1">, {{ $passenger[1] }} Child</p>
                        @endif
                        @if($passenger[2] != 0)
                            <p class="mb-0 small ms-1">, {{ $passenger[2] }} Infant</p>
                        @endif
                    </div>
                </div>
                <div class="your-booking-date">
                    @php
                        $booking_date_2 = explode('/', $booking_date);
                    @endphp
                    <p class="fw-bold mb-2"><i class="fa-regular fa-calendar-days"></i> {{ date('l M d, Y', strtotime($booking_date_2[2].'-'.$booking_date_2[1].'-'.$booking_date_2[0])) }}</p>
                </div>
                <div class="your-booking-destination ms-2">
                    <small class="your-booking-depart-time"></small>
                    <p class="your-booking-destination-from"></p>

                    <small class="your-booking-arrive-time"></small>
                    <p class="your-booking-destination-to"></p>
                </div>

                <div class="card your-booking-summary d-none">
                    <div class="card-body">
                        <div class="fare-passenger">
                            @if($passenger[0] > 0)
                                <div class="d-flex justify-content-between">
                                    <i class="fa-solid fa-person fs-5 me-1"></i>
                                    <span class="d-flex">
                                        <p class="mb-0 me-2">{{ $passenger[0] }} x </p>
                                        <p class="mb-0 your-booking-fare-adult"></p>
                                    </span>
                                </div>
                            @endif
                            @if($passenger[1] > 0)
                                <div class="d-flex justify-content-between">
                                    <img src="{{asset('icons/child.png')}}" width="17px" alt="" style="filter: invert(1); margin-left: -2px; height: 20px;">
                                    <span class="d-flex">
                                        <p class="mb-0 me-2">{{ $passenger[1] }} x </p>
                                        <p class="mb-0 your-booking-fare-child"></p>
                                    </span>
                                </div>
                            @endif
                            @if($passenger[2] > 0)
                                <div class="d-flex justify-content-between">
                                    <i class="fa-solid fa-baby fs-6 me-1"></i>
                                    <span class="d-flex">
                                        <p class="mb-0 me-2">{{ $passenger[2] }} x </p>
                                        <p class="mb-0 your-booking-fare-infant"></p>
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between your-booking-premium-flex d-none">
                            <p class="mb-2 fw-bold">Premium Flex</p>
                            <p class="mb-2 your-booking-premium-flex-price"></p>
                        </div>
                        <div class="d-flex justify-content-between your-booking-extra d-none">
                            <p class="mb-2 fw-bold">Extra Service</p>
                            <p class="mb-2 your-booking-extra-price"></p>
                        </div>
                        <div class="d-flex justify-content-between border-top pt-2">
                            <p class="mb-0 fw-bold">Total</p>
                            <p class="mb-0 your-booking-amount"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<style>
    @media (min-width: 1200px) {
        .container {
            max-width: 1366px;
        }
    }
</style>
<script>
    let isStep = {{ $isType == '' ? 0 : 1 }}
</script>
<script src="{{ asset('assets/js/app/progress_bar.js') }}"></script>
@stop
