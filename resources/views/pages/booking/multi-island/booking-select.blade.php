<div id="booking-multi-route-select">
    @foreach($route_arr as $index => $routes)
    <div class="row mb-4">
        <div class="col-12 mb-2">
            <p class="mb-0 fw-bolder">
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
                <div class="row p-2 px-4 mb-4 border rounded booking-route-list route-hover cursor-pointer list-index_{{ $index }} list-position_{{ $index }}_{{ $key }}" data-list="{{ $index }}" data-key="{{ $key }}">
                    <div class="col-12 pb-2 border-0 border-bottom border-2 border-light">
                        <div class="float-start">
                            <span class="me-2">Depart</span>
                            <span class="station-name me-4">{{ $route['station_from']['name'] }} @if($route['station_from']['piername'] != NULL) ({{$route['station_from']['piername']}}) @endif</span>
                            <span class="me-2">Arrival</span>
                            <span class="station-name">{{ $route['station_to']['name'] }} @if($route['station_to']['piername'] != NULL) ({{$route['station_to']['piername']}}) @endif</span>
                        </div>
                        <div class="float-end d-none d-lg-block">
                            <span class="px-3">Fare</span>
                        </div>
                    </div>

                    <div class="col-12 py-3 border-0 border-bottom border-2 border-light">
                        <div class="float-start d-flex align-items-center">
                            <span class="me-2 depart-time">{{ date("H:i", strtotime($route['depart_time'])) }}</span>
                            <span class="me-2">
                                <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">  
                                    <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"></path>  
                                    <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"></path>
                                </svg>
                            </span>
                            <div class="d-flex me-2">
                                @foreach($route['icons'] as $icon)
                                <div class="mw--48">
                                    <img src="{{ $icon_url }}{{ $icon['path'] }}" class="me-1 w-100 icon-selected">
                                </div>
                                @endforeach
                            </div>
                            <span class="me-2">
                                <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">  
                                    <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"></path>  
                                    <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"></path>
                                </svg>
                            </span>
                            <span class="me-2 arrival-time">{{ date("H:i", strtotime($route['arrive_time'])) }}</span>
                        </div>
                        <div class="float-end d-flex align-items-center">
                            <span class="bg-white py-1 px-3 rounded border border-warning route-price">{{ number_format($route['p_adult'] + $route['p_child'] + $route['p_infant']) }}</span>
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