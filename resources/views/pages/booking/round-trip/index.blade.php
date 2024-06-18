@extends('layouts.default')

@section('head_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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
                        @php
                            $_depart_date = explode('/', $depart_date);
                        @endphp
                        <small>
                            {{ $station_depart['from'] }}
                            <span class="mx-2">To</span>
                            {{ $station_depart['to'] }}
                            <span class="ms-2">[ {{ date('l M d, Y', strtotime($_depart_date[2].'-'.$_depart_date[1].'-'.$_depart_date[0])) }}</span><span class="set-time-route-depart"></span> ]
                        </small>
                    @else
                        <small>Sorry. No depart route.</small>
                    @endif
                </p>
                <p class="my-2 mt-1 booking-route-return-roundtrip"><span class="fw-bold">Return : </span>
                    @if(!empty($return_routes))
                        @php
                            $_return_date = explode('/', $return_date);
                        @endphp
                        <small>
                            {{ $station_return['from'] }}
                            <span class="mx-2">To</span>
                            {{ $station_return['to'] }}
                            <span class="ms-2">[ {{ date('l M d, Y', strtotime($_return_date[2].'-'.$_return_date[1].'-'.$_return_date[0])) }}</span><span class="set-time-route-return"></span> ]
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
    <div class="col-12 col-lg-9">
        <ol class="process-steps process-steps-primary text-muted mb-3">
            <li class="process-step-item position-relative complete" data-step="booking">
                <span class="ps-3 progress-step-name">
                    <span class="fs-5">
                        <i class="fa-solid fa-suitcase-rolling"></i>
                    </span>
                    <span class="progress-step-text-name">{{ $isType != '' ? $isType : 'Booking' }}</span>
                </span>
            </li>
            <li class="process-step-item position-relative text-primary active" data-step="select">
                <span class="ps-2 progress-step-name">
                    <span class="fs-5">
                        <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"></path>
                          </svg>
                    </span>
                    <span class="progress-step-text-name">Select</span>
                </span>
            </li>
            <li class="process-step-item position-relative" data-step="premium">
                <span class="ps-2 progress-step-name">
                    <span class="fs-5">
                        <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"></path>
                          </svg>
                    </span>
                    <span class="progress-step-text-name">Premium Flex</span>
                </span>
            </li>
            <li class="process-step-item position-relative" data-step="extra">
                <span class="ps-2 progress-step-name">
                    <span class="fs-5">
                        <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"></path>
                          </svg>
                    </span>
                    <span class="progress-step-text-name">Extra services</span>
                </span>
            </li>
            <li class="process-step-item position-relative" data-step="passenger">
                <span class="ps-2 progress-step-name">
                    <span class="fs-5">
                        <i class="fa-solid fa-person-circle-plus"></i>
                    </span>
                    <span class="progress-step-text-name">Passenger info</span>
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
                        <x-booking-premium-flex
                            :ispremiumflex="$freepremiumflex"
                            :premium_flex="$premium_flex"
                        />
                    </div>
                    <div class="procress-step d-none">
                        <!-- booking extra -->
                        @include('pages.booking.round-trip.booking-extra')
                    </div>
                    <div class="procress-step d-none">
                        <!-- booking passenger -->
                        @include('pages.booking.round-trip.booking-passenger')
                    </div>
                    {{-- <div class="procress-step d-none">
                        <!-- booking payment -->
                        @include('pages.booking.round-trip.booking-payment')
                    </div> --}}

                    <div class="row mt-3">
                        <div class="col-6">
                            <a href="{{ route('home') }}" class="btn btn-sm btn-secondary border-radius-10 d-none position-absolute" id="btn-back-to-home" style="margin-left: 0.5rem;"><< Back</a>
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
                                :text="_('Book / Payment')"
                                onClick="progressPassenger()"
                                disabled
                            />
                            <x-button-green
                                id="progress-payment"
                                class="btn-sm d-none"
                                :type="_('button')"
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
        <div class="border rounded bg-white">
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
                <div class="your-booking-depart-date">
                    @php
                        $booking_depart_date = explode('/', $depart_date);
                        $booking_return_date = explode('/', $return_date);
                    @endphp
                    <span class="badge bg-booking-select-depart px-2 py-1 smaller">Depart</span>
                    <p class="fw-bold mb-1 is-booking-date-depart"><i class="fa-regular fa-calendar-days"></i> {{ date('l M d, Y', strtotime($booking_depart_date[2].'-'.$booking_depart_date[1].'-'.$booking_depart_date[0])) }}</p>
                </div>
                <div class="your-booking-depar ps-2">
                    <small class="your-booking-depart-time"></small>
                    <p class="your-booking-depart-from mb-1"></p>

                    <small class="your-booking-arrive-time"></small>
                    <p class="your-booking-depart-to"></p>
                </div>

                <div class="your-booking-return-date">
                    <span class="badge bg-booking-select-return px-2 py-1 smaller">Return</span>
                    <p class="fw-bold mb-1 is-booking-date-return"><i class="fa-regular fa-calendar-days"></i> {{ date('l M d, Y', strtotime($booking_return_date[2].'-'.$booking_return_date[1].'-'.$booking_return_date[0])) }}</p>
                </div>
                <div class="your-booking-return ps-2">
                    <small class="your-booking-return-depart-time"></small>
                    <p class="your-booking-return-from mb-1"></p>

                    <small class="your-booking-return-arrive-time"></small>
                    <p class="your-booking-return-to"></p>
                </div>

                <div class="your-booking-promocode mb-2">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-sm booking-promocode-input" placeholder="PromoCode" aria-label="PromoCode" aria-describedby="button-promocode">
                        <button class="btn btn-sm btn-outline-secondary text-center" type="button" id="button-promocode-submit">
                            <i class="fa-solid fa-circle-check m-0 promocode-loading"></i>
                            <i class="fi fi-circle-spin fi-spin m-0 promocode-loaded d-none"></i>
                        </button>
                    </div>
                </div>

                <div class="card your-booking-summary d-none">
                    <div class="card-body px-2">
                        <div class="fare-passenger-depart d-none">
                            <span class="badge bg-booking-select-depart px-2 py-1 smaller">Depart</span>
                            <div class="px-2 py-1">
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
                        </div>
                        <div class="fare-passenger-return d-none">
                            <span class="badge bg-booking-select-return px-2 py-1 smaller">Return</span>
                            <div class="px-2 py-1">
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
                        </div>
                        <div class="d-flex justify-content-between your-booking-discount border-top pt-2 d-none">
                            <p class="mb-2 fw-bold">Discount <small class="your-booking-promocode-discount-amount text-danger"></small> <small class="your-booking-promocode-discount" style="font-size: .65rem;"></small></p>
                            <p class="mb-2 your-booking-discount-price"></p>
                        </div>
                        <div class="d-flex justify-content-between your-booking-premium-flex pt-2 border-top d-none">
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
<script src="{{ asset('assets/js/app/progress_bar2.js') }}"></script>
@stop
