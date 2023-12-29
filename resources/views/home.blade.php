@extends('layouts.default')

@section('head_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('cover-content')
    <div class="section bg-theme-color-light overlay-dark overlay-opacity-2 bg-cover lazy cover-home"
        data-background-image="{{ asset('/cover/' . $cover) }}">

        <div class="container">
            <div class="row text-center-md text-center d-middle justify-content-center font-proxima mb-4">
                <div class="col-12 text-align-center text-center-md text-center" data-aos="fade-in" data-aos-delay="20"
                    data-aos-offset="0">
                    <div
                        class="d-inline-block bg-main-color-2 shadow-primary-xs rounded p-4 w-100 text-align-center border">
                        <div class="row mb-3">
                            <div class="col-sm-12 col-lg-2">
                                <span class="d-block p-2 text-light">Booking <i
                                        class="fa-solid fa-ship ms-1 fs-4"></i></span>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <div class="nav flex nav-pills mb-3 mb-lg-0" id="booking-tab" aria-orientation="horizontal">
                                    <a class="nav-link mb-2 mb-lg-0 px-4 active" id="v-pills-home-tab" data-bs-toggle="pill"
                                        href="#v-pills-home" role="tab" aria-controls="v-pills-home"
                                        aria-selected="true">Round Trip Ticket</a>
                                    <a class="nav-link mb-2 mb-lg-0 px-4" id="v-pills-profile-tab" data-bs-toggle="pill"
                                        href="#v-pills-profile" role="tab" aria-controls="v-pills-profile"
                                        aria-selected="false">One Way Ticket</a>
                                    <a class="nav-link mb-2 mb-lg-0 px-4" id="v-pills-messages-tab" data-bs-toggle="pill"
                                        href="#v-pills-messages" role="tab" aria-controls="v-pills-messages"
                                        aria-selected="false">Multi-Island <img src="{{ asset('multi-island.webp') }}"
                                            style="width: 35px; margin-top: -10px;"></a>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-4 text-end">
                                <div class="text-light mb-0 dropdown">
                                    <span class="cursor-pointer dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                        View your booking <i class="fa-regular fa-calendar-days fs-4 ms-1"></i>
                                    </span>

                                    <div class="dropdown-menu dropdown-click-ignore dropdown-lg p-4 bg-main-color-2 border">
                                        <h6 class="mb-2 text-light">View your booking</h6>
                                        <form class="bs-validate" id="booking-record" method="POST"
                                            action="{{ route('booking-record') }}">
                                            @csrf
                                            <div class="row g-3">
                                                <div class="col-md-12">
                                                    <input required type="text" class="form-control form-control-sm"
                                                        name="booking_number" placeholder="Booking Number..." autocomplete="off">
                                                </div>
                                                <div class="col-md-12">
                                                    <input required type="email" class="form-control form-control-sm"
                                                        name="booking_email" placeholder="Booking Email..." autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-end pt-2">
                                                <button type="submit" class="btn btn-sm button-orange-bg"><i class="fi fi-search me-0"></i></button>
                                            </div>
                                        </form>

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                        aria-labelledby="v-pills-home-tab">
                                        <x-booking-round-ticket :type="_('round')" :station_to="$station_to" :section_from="$section_from" />
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                        aria-labelledby="v-pills-profile-tab">
                                        <x-booking-one-ticket :type="_('one')" :station_to="$station_to" :section_from="$section_from" />
                                    </div>
                                    <div class="tab-pane fade text-light" id="v-pills-messages" role="tabpanel"
                                        aria-labelledby="v-pills-messages-tab">
                                        <x-booking-multi-ticket :type="_('multi')" :station_to="$station_to" :section_from="$section_from" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('includes.home_cupon_3')

        </div>
    </div>
@stop

@section('content')
    @include('includes.home_vdo')

    <div class="row mt-lg-2">
        <div class="col-12 d-flex justify-content-center">
            <hr class="border-4 rounded w-25"/>
        </div>
    </div>

    @include('includes.home_slide')



@stop

@section('script')
    <script src="{{ asset('assets/js/app/booking.js') }}"></script>
@stop
