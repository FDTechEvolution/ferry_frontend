<div id="booking-multi-route-select">
    @foreach($route_arr as $index => $routes)
    <div class="row mb-4">
        <div class="col-12 mb-2">
            <p class="mb-0 fw-bolder booking-select-header">
                <span class="me-0">Depart : </span>
                <span class="station-name depart-station-name-{{ $index }} me-4">{{ $routes['station_from'] }}</span>
                <span class="me-0">Arrival : </span>
                <span class="station-name arrive-station-name-{{ $index }} me-4">{{ $routes['station_to'] }}</span>
                <span class="me-0">Date : </span>
                <span class="station-name travel-date-{{ $index }}">{{ $routes['depart'] }}</span>
            </p>
        </div>
        <div class="col-12 col-lg-11 ms-0 ms-lg-5 booking-route-select">
            @foreach($routes['data'] as $key => $route)
                <div class="row p-2 px-4 mx-1 mb-4 border rounded booking-route-list list-index_{{ $index }} list-position_{{ $index }}_{{ $key }} @if(!$route['do_booking']) over-time bg-dark-light @endif" data-list="{{ $index }}" data-key="{{ $key }}">

                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-lg-10">
                                <div class="row py-3">
                                    @if($route['ispromocode'] == 'Y')
                                        <p class="mb-2 small">
                                            <img src="promo_icon.png" width="40"> <small class="text-main-color-2">PromoCode Avaliable!</small>
                                        </p>
                                    @endif
                                    <div class="col-1 d-flex justify-content-center align-items-center">
                                        <div class="partner-image me-3">
                                            @if($route['partner'] != NULL)
                                                <div class="avatar avatar-md" style="background-image:url({{ $icon_url.'/'.$route['partner']['image']['path'] }})"></div>
                                            @else
                                                <div class="avatar avatar-md" style="background-image:url({{ asset('tiger-line-partner.jpg') }})"></div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-11 col-lg-7 d-flex align-items-center mb-2 pb-2 pb-lg-0 mb-lg-0 border-bottom-m fs--14-m">
                                        <p class="mb-0 me-2">
                                            <span class="depart-time">{{ date("H:i", strtotime($route['depart_time'])) }}</span><br/>
                                            <span class="small">{{ $route['station_from']['name'] }} @if($route['station_from']['piername'] != NULL) ({{$route['station_from']['piername']}}) @endif <x-booking-station-info :station_line="$route['station_lines']" :station="$route['station_from']['name']" :type="_('from')" :is_master="$route['master_from_info']"/></span>
                                        </p>
                                        <span class="mx-1 mx-lg-3">
                                            <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"></path>
                                                <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"></path>
                                            </svg>
                                        </span>
                                        <p class="mb-0 ms-2">
                                            <span class="arrival-time">{{ date("H:i", strtotime($route['arrive_time'])) }}</span><br/>
                                            <span class="small">{{ $route['station_to']['name'] }} @if($route['station_to']['piername'] != NULL) ({{$route['station_to']['piername']}}) @endif <x-booking-station-info :station_line="$route['station_lines']" :station="$route['station_to']['name']" :type="_('to')" :is_master="$route['master_to_info']"/></span>
                                        </p>
                                    </div>

                                    <div class="col-6 col-lg-1 travel-time d-flex justify-content-center align-items-center">
                                        <p class="mb-0 smaller">{{ $route['travel_time'] }}</p>
                                    </div>

                                    <div class="col-6 col-lg-3 route-text d-flex justify-content-center align-items-center">
                                        <p class="mb-0 smaller">{{ $route['text_1'] }}</p>
                                    </div>
                                </div>

                                <div class="row pt-2 border-top">
                                    <div class="col-12 col-lg-4 route-icon d-flex align-items-center justify-content-lg-start justify-content-center">
                                        @foreach($route['icons'] as $icon)
                                        <div class="mw--48">
                                            <img src="{{ $icon_url }}{{ $icon['path'] }}" class="me-1 w-100 icon-selected">
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="col-12 col-lg-8 d-flex align-items-center justify-content-center justify-content-lg-start">
                                        <p class="mb-0 smaller">{{ $route['text_2'] }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-lg-2 mt-lg-0 mt-3 d-lg-flex justify-content-lg-center align-items-lg-center booking-selected-zone">
                                <div class="text-end">
                                    <div class="row">
                                        <div class="col-6 col-lg-12 mb-0 text-center-m" style="line-height: 18px;">
                                            <p class="mb-0">
                                                <span class="small me-2">THB</span>
                                                <span class="route-price fs-4">{{ number_format($route['p_adult'] + $route['p_child'] + $route['p_infant']) }}</span>
                                            </p>
                                            <p class="mb-1 small">For {{ $passenger[0] + $passenger[1] + $passenger[2] }} passenger(s)</p>
                                        </div>
                                        <div class="col-6 col-lg-12 mt-2 mt-lg-0 mb-lg-2 text-center-m">
                                            <button type="button" class="btn btn-sm button-blue-bg py-1 px-4 btn-route-list_{{ $index }} btn-route-select-{{ $index }}_{{ $key }}">Select</button>
                                        </div>
                                        <div class="col-6 col-lg-12 text-center-m">
                                            @if($passenger[0] > 0)
                                                <p class="mb-0 small">
                                                    <i class="fa-solid fa-person fs-5 me-1"></i> <span class="smaller">{{ $passenger[0] }} x {{ number_format($route['p_adult'] / $passenger[0]) }}</span>
                                                </p>
                                            @endif
                                            @if($passenger[1] > 0)
                                                <p class="mb-0 small">
                                                    <i class="fa-solid fa-children fs-6 me-1"></i> <span class="smaller">{{ $passenger[1] }} x {{ number_format($route['p_child'] / $passenger[1]) }}</span>
                                                </p>
                                            @endif
                                            @if($passenger[2] > 0)
                                                <p class="mb-0 small">
                                                    <i class="fa-solid fa-baby fs-6 me-1"></i> <span class="smaller">{{ $passenger[2] }} x {{ number_format($route['p_infant'] / $passenger[2]) }} pax</span>
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" class="selected-adult-price" value="{{ $route['regular_price'] }}">
                    <input type="hidden" class="selected-child-price" value="{{ $route['child_price'] }}">
                    <input type="hidden" class="selected-infant-price" value="{{ $route['infant_price'] }}">
                    <input type="hidden" class="selected-route-{{ $index }}_{{ $key }}" value="{{ $route['id'] }}">
                </div>
            @endforeach
        </div>
    </div>
    <input type="hidden" name="booking_route_selected[{{ $index }}]" id="booking-route-selected" value="">
    <input type="hidden" name="departdate[{{ $index }}]" id="booking-route-departdate" value="">
    @endforeach
</div>
