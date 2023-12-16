<div id="booking-route-select">
    @foreach($routes as $index => $route)
        <div class="row p-2 px-4 mb-4 border rounded booking-route-list @if(!$route['do_booking']) over-time bg-dark-light @endif">

            <div class="col-12">
                <div class="row">
                    <div class="col-10">
                        <div class="row py-3">
                            <div class="col-1 d-flex justify-content-center align-items-center">
                                <div class="partner-image me-3">
                                    @if($route['partner'] != NULL)
                                        <div class="avatar avatar-md" style="background-image:url({{ $icon_url.'/'.$route['partner']['image']['path'] }})"></div>
                                    @else
                                        <div class="avatar avatar-md" style="background-image:url({{ asset('tiger-line-partner.jpg') }})"></div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6 d-flex align-items-center">
                                <p class="mb-0 me-2">
                                    <span class="depart-time">{{ date("H:i", strtotime($route['depart_time'])) }}</span><br/>
                                    <span class="small">{{ $route['station_from']['name'] }} @if($route['station_from']['piername'] != NULL) ({{$route['station_from']['piername']}}) @endif</span>
                                </p>
                                <span class="mx-3">
                                    <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">  
                                        <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"></path>  
                                        <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"></path>
                                    </svg>
                                </span>
                                <p class="mb-0 ms-2">
                                    <span class="arrival-time">{{ date("H:i", strtotime($route['arrive_time'])) }}</span><br/>
                                    <span class="small">{{ $route['station_to']['name'] }} @if($route['station_to']['piername'] != NULL) ({{$route['station_to']['piername']}}) @endif</span>
                                </p>
                            </div>

                            <div class="col-2 travel-time d-flex justify-content-center align-items-center">
                                <p class="mb-0 smaller">{{ $route['travel_time'] }}</p>
                            </div>

                            <div class="col-3 route-text d-flex justify-content-center align-items-center">
                                <p class="small mb-0">{{ $route['text_1'] }}</p>
                            </div>
                        </div>
                        <div class="row pt-2 border-top">
                            <div class="col-12 route-icon d-flex align-items-center">
                                @foreach($route['icons'] as $icon)
                                <div class="mw--48">
                                    <img src="{{ $icon_url }}{{ $icon['path'] }}" class="me-1 w-100 icon-selected">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-2">
                        <div class="text-end">
                            <p class="mb-0">
                                <span class="small me-2">THB</span>
                                <span class="route-price fs-4">{{ number_format($route['p_adult'] + $route['p_child'] + $route['p_infant']) }}</span>
                            </p>
                            <p class="mb-1 small">For {{ $passenger[0] + $passenger[1] + $passenger[2] }} passenger.</p>
                            <button type="button" class="btn btn-sm button-blue-bg btn-route-list btn-route-select-{{ $index }}">Select</button>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" class="selected-adult-price" value="{{ $route['regular_price'] }}">
            <input type="hidden" class="selected-child-price" value="{{ $route['child_price'] }}">
            <input type="hidden" class="selected-infant-price" value="{{ $route['infant_price'] }}">
            <input type="hidden" class="selected-route" value="{{ $route['id'] }}">
        </div>
    @endforeach
    <input type="hidden" name="booking_route_selected" value="">
</div>