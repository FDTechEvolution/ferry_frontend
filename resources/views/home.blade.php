@extends('layouts.default')

@section('cover-content')
<div class="section bg-theme-color-light overlay-dark overlay-opacity-5 bg-cover lazy" 
    data-background-image="{{ asset('/cover/'.$cover) }}">
    
    <div class="container"> 
        <div class="row text-center-md text-center d-middle justify-content-center">
            <div class="col-12 text-align-center text-center-md text-center" data-aos="fade-in" data-aos-delay="20" data-aos-offset="0">
                <div class="d-inline-block bg-main-color-2 shadow-primary-xs rounded p-4 w-100 text-align-center border">
                    <div class="row mb-3">
                        <div class="col-sm-12 col-lg-2">
                            <span class="d-block p-2 text-light">Booking <i class="fa-solid fa-ship ms-1 fs-4"></i></span>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div class="nav flex nav-pills me-3" id="booking-tab" aria-orientation="horizontal">
                                <a class="nav-link px-4 active" id="v-pills-home-tab" data-bs-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Round Trip Ticket</a>
                                <a class="nav-link px-4" id="v-pills-profile-tab" data-bs-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">One Way Ticket</a>
                                <a class="nav-link px-4" id="v-pills-messages-tab" data-bs-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Multi Island <img src="{{ asset('coconut_tree.svg') }}" style="width: 30px; margin-top: -10px;"></a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-4 text-end">
                            <form novalidate class="bs-validate d-none" id="booking-record" method="POST" action="{{ route('booking-record') }}">
                                @csrf
                                <div class="input-group">
                                    <input required type="text" class="form-control form-control-sm" name="booking_number" placeholder="Booking Number..." autocomplete="off">
                                    <button class="btn btn-sm button-link bg-light px-2" type="button" id="booking-record-back"><i class="fi fi-close me-0"></i></button>
                                    <button class="btn btn-sm button-orange-bg" type="submit"><i class="fi fi-search me-0"></i></button>
                                </div>
                            </form>
                            <p class="text-light mb-0"><span class="cursor-pointer" id="view-your-booking">View your booking <i class="fa-regular fa-calendar-days fs-4 ms-1"></i></span></p>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-sm-12">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                                    <x-booking-round-ticket 
                                        :type="_('round')"
                                        :stations="$stations"
                                    />
                                </div>
                                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                                    <x-booking-one-ticket 
                                        :type="_('one')"
                                        :stations="$stations"
                                    />
                                </div>
                                <div class="tab-pane fade text-light" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                                    <x-booking-multi-ticket 
                                        :type="_('multi')"
                                        :stations="$stations"
                                    />
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
<div class="swiper-container swiper-white swiper-preloader"
	data-swiper='{
		"autoplay": { "delay" : 3000, "disableOnInteraction": false }
	}'>
	<div class="swiper-wrapper">

        @foreach($slides as $slide)
		<div class="swiper-slide">
            @if($slide['link'] != NULL)
                <a href="{{ $slide['link'] }}" target="_blank">
                    <img class="img-fluid" src="{{ asset($store.$slide['image']['path'].'/'.$slide['image']['name']) }}" alt="...">
                </a>
            @else
                <img class="img-fluid" src="{{ asset($store.$slide['image']['path'].'/'.$slide['image']['name']) }}" alt="...">
            @endif
		</div>
		@endforeach

	</div>

	<!-- Navs -->
	<div class="bg-white rounded-circle swiper-button-next"></div>
	<div class="bg-white rounded-circle swiper-button-prev"></div>

</div>
@stop

@section('script')
<script src="{{ asset('assets/js/app/booking.js') }}"></script>
@stop