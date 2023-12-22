@extends('layouts.default')

@section('head_meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('cover-content')
    <div class="section bg-theme-color-light overlay-dark overlay-opacity-2 bg-cover lazy"
        data-background-image="{{ asset('/cover/' . $cover) }}">

        <div class="container">
            <div class="row text-center-md text-center d-middle justify-content-center font-proxima">
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
                                <form novalidate class="bs-validate d-none" id="booking-record" method="POST"
                                    action="{{ route('booking-record') }}">
                                    @csrf
                                    <div class="input-group">
                                        <input required type="text" class="form-control form-control-sm"
                                            name="booking_number" placeholder="Booking Number..." autocomplete="off">
                                        <button class="btn btn-sm button-link bg-light px-2" type="button"
                                            id="booking-record-back"><i class="fi fi-close me-0"></i></button>
                                        <button class="btn btn-sm button-orange-bg" type="submit"><i
                                                class="fi fi-search me-0"></i></button>
                                    </div>
                                </form>
                                <p class="text-light mb-0"><span class="cursor-pointer" id="view-your-booking">View your
                                        booking <i class="fa-regular fa-calendar-days fs-4 ms-1"></i></span></p>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-sm-12">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel"
                                        aria-labelledby="v-pills-home-tab">
                                        <x-booking-round-ticket :type="_('round')" :station_from="$station_from" :station_to="$station_to" />
                                    </div>
                                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel"
                                        aria-labelledby="v-pills-profile-tab">
                                        <x-booking-one-ticket :type="_('one')" :station_from="$station_from" :station_to="$station_to" />
                                    </div>
                                    <div class="tab-pane fade text-light" id="v-pills-messages" role="tabpanel"
                                        aria-labelledby="v-pills-messages-tab">
                                        <x-booking-multi-ticket :type="_('multi')" :station_from="$station_from" :station_to="$station_to" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    @include('includes.home_cupon_2')

    <div class="section">
        <div class="row">
            <div class="col-12">
                <h2 class="text-main-color-2"><i class="fa-solid fa-fire"></i> Trending</h2>
            </div>
            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-12">
                        <div class="swiper-container swiper-preloader swiper-btn-group swiper-btn-group-end text-white"
                            data-swiper='{
                                "slidesPerView": 1,
                                "spaceBetween": 0,
                                "autoplay": true,
                                "loop": true,
                                "pagination": { "type": "progressbar" }
                            }'
                            style="border-radius: 10px;">

                            <div class="swiper-wrapper" style="height:350px;">

                                @foreach ($slides as $slide)
                                    <div class="swiper-slide h-100 d-middle bg-white overlay-dark overlay-opacity-1 bg-cover" 
                                        style="background:url({{ asset($store . $slide['image']['path'] . '/' . $slide['image']['name']) }}); 
                                                background-position: bottom center !important;"
                                    >
                                    </div>
                                @endforeach

                            </div>

                            <!-- Add Arrows -->
                            <div class="home-tranding swiper-button-next swiper-button-white"></div>
                            <div class="home-tranding swiper-button-prev swiper-button-white"></div>

                            <!-- Add Pagination -->
                            <div class="swiper-pagination"></div>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="row">
                    <div class="col-12">
                        <video width="100%" height="350" style="border-radius: 10px;" controls>
                            <source src="video/tigerline.mp4" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="section py-3">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8 offset-lg-2 text-center">
                    <h2>Welcome to Tigerline Ferry!</h2>

                    <p class="mb-0">Greetings to all over the world.</p>
                    <p class="mb-0">Since 2003, We are Thai operators leading out this Andaman Sea's Tourism Industry.
                    </p>
                    <p>Capturing the scenic on this land of plenty. Thought the beauty
                        of the emerald sea, full with discovery that form a wonderful landscape. Andaman Tropical
                        Archipelago never run out of excitement for you explore.</p>

                    <p>We provide variety of transportation, extraodinary scenic experience is waiting for you to long for.
                        Your sea trips will be the best with
                        us as we aren't just an agency, but operators and travel connoisseurs.</p>

                    <p>We sell what we experienced and select only the best for you!</p>
                </div>
                
            </div>
        </div>
    </div>

@stop

@section('script')
    <script src="{{ asset('assets/js/app/booking.js') }}"></script>
@stop
