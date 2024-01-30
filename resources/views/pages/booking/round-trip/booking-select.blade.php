<div id="booking-route-select">
    <div class="mb-6" id="booking-depart">
        <h6 class="booking-select-header">
            <span class="badge bg-booking-select-depart px-3 py-2">Depart</span>
            @if(!empty($depart_routes))
                {{ $station_depart['from'] }} <span class="mx-1 mx-lg-3">To</span> {{ $station_depart['to'] }}
            @else
                <span class="ms-2">Sorry. No depart route.</span>
            @endif
        </h6>
        @foreach($depart_routes as $index => $route)
            <div class="row p-2 px-4 mx-1 mb-4 border rounded booking-depart-list @if(!$route['do_booking']) over-time bg-dark-light @endif">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-lg-10">
                            <div class="row py-3 pb-lg-3 pb-2">
                                @if($route['ispromocode'] == 'Y')
                                    <p class="mb-2 small">
                                        <img src="promo_icon.png" width="40"> <small class="text-main-color-2 promo-avaliable-depart">PromoCode Avaliable!</small>
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
                                        <span class="small station-depart-from-text">{{ $route['station_from']['name'] }} @if($route['station_from']['piername'] != NULL) ({{$route['station_from']['piername']}}) @endif
                                            <x-booking-master-info
                                                :info="$route['master_from']"
                                                :station="$route['station_from']['name']"
                                                :googlemap="$route['station_from']['google_map']"
                                                :image="$route['station_from']['image']['path']"
                                                :store="$icon_url"/>
                                        </span>
                                    </p>
                                    <span class="mx-0 mx-md-3">
                                        <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"></path>
                                            <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"></path>
                                        </svg>
                                    </span>
                                    <p class="mb-0 ms-2">
                                        <span class="arrival-time">{{ date("H:i", strtotime($route['arrive_time'])) }}</span><br/>
                                        <span class="small station-depart-to-text">{{ $route['station_to']['name'] }} @if($route['station_to']['piername'] != NULL) ({{$route['station_to']['piername']}}) @endif
                                            <x-booking-master-info
                                                :info="$route['master_to']"
                                                :station="$route['station_to']['name']"
                                                :googlemap="$route['station_to']['google_map']"
                                                :image="$route['station_to']['image']['path']"
                                                :store="$icon_url"/>
                                        </span>
                                    </p>
                                </div>

                                <div @class(['col-lg-1', 'px-0', 'travel-time', 'd-flex', 'justify-content-center', 'align-items-center', 'col-3' => $route['text_1'] != '', 'col-12' => $route['text_1'] == ''])>
                                    <p class="mb-0 smaller">{{ $route['travel_time'] }}</p>
                                </div>

                                @if($route['text_1'] != '')
                                    <div class="col-9 col-lg-3 route-text d-flex justify-content-start align-items-center">
                                        <p class="mb-0 smaller">{{ $route['text_1'] }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="row pt-2 border-top">
                                <div class="col-12 col-lg-4 route-icon d-flex align-items-center justify-content-lg-start justify-content-center">
                                    <x-booking-select-icon
                                        :icons="$route['icons']"
                                        :icon_url="$icon_url"
                                    />
                                </div>

                                @if($route['text_2'] != '')
                                    <div class="col-12 col-lg-8 d-flex align-items-center justify-content-center justify-content-lg-start">
                                        <p class="mb-0 smaller">{{ $route['text_2'] }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 col-lg-2 mt-lg-0 mt-3 d-lg-flex justify-content-lg-center align-items-lg-center booking-selected-zone">
                            <div class="text-end">
                                <div class="row">
                                    <div class="col-6 col-lg-12 mb-0 text-center-m" style="line-height: 18px;">
                                        <p class="mb-0 position-relative">
                                            <span class="small me-2">THB</span>
                                            @if(isset($route['promo_price']) && $route['promo_price'] != 0)
                                                <span class="smaller text-danger current-price"><s>{{ number_format($route['amount']) }}</s></span>
                                                <span class="route-price promo-price fs-4">{{ number_format($route['promo_price']) }}</span>
                                            @else
                                                <span class="route-price fs-4">{{ number_format($route['amount']) }}</span>
                                            @endif
                                        </p>
                                        <p class="mb-1 smaller">For {{ $passenger[0] + $passenger[1] + $passenger[2] }} passenger(s)</p>
                                    </div>
                                    <div class="col-6 col-lg-12 mt-2 mt-lg-0 mb-lg-2 text-center-m">
                                        <button type="button" class="btn btn-sm button-blue-bg btn-route-depart-list py-1 px-4 btn-route-depart-select-{{ $index }}">Select</button>
                                    </div>
                                    <div class="col-6 col-lg-12 text-center-m">
                                        <x-booking-select-passenger-icon
                                            :passenger="$passenger"
                                            :p_adult="$route['p_adult']"
                                            :p_child="$route['p_child']"
                                            :p_infant="$route['p_infant']"
                                        />
                                    </div>
                                </div>
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
        <input type="hidden" name="booking_depart_selected" value="">
    </div>

    <div class="mt-4" id="booking-return">
        <h6 class="booking-select-header">
            <span class="badge bg-booking-select-return px-3 py-2 text-light">Return</span>
            @if(!empty($return_routes))
                {{ $station_return['from'] }} <span class="mx-1 mx-lg-3">To</span> {{ $station_return['to'] }}
            @else
                <span class="ms-2">Sorry. No return route.</span>
            @endif
        </h6>
        @foreach($return_routes as $index => $route)
            <div class="row p-2 px-4 mx-1 mb-4 border rounded booking-return-list @if(!$route['do_booking']) over-time bg-dark-light @endif">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-lg-10">
                            <div class="row py-3 pb-lg-3 pb-2">
                                @if($route['ispromocode'] == 'Y')
                                    <p class="mb-2 small">
                                        <img src="promo_icon.png" width="40"> <small class="text-main-color-2 promo-avaliable-return">PromoCode Avaliable!</small>
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
                                        <span class="small station-return-from-text">{{ $route['station_from']['name'] }} @if($route['station_from']['piername'] != NULL) ({{$route['station_from']['piername']}}) @endif
                                            <x-booking-master-info
                                                :info="$route['master_from']"
                                                :station="$route['station_from']['name']"
                                                :googlemap="$route['station_from']['google_map']"
                                                :image="$route['station_from']['image']['path']"
                                                :store="$icon_url"/>
                                        </span>
                                    </p>
                                    <span class="mx-0 mx-md-3">
                                        <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-chevron-double-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z"></path>
                                            <path fill-rule="evenodd" d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z"></path>
                                        </svg>
                                    </span>
                                    <p class="mb-0 ms-2">
                                        <span class="arrival-time">{{ date("H:i", strtotime($route['arrive_time'])) }}</span><br/>
                                        <span class="small station-return-to-text">{{ $route['station_to']['name'] }} @if($route['station_to']['piername'] != NULL) ({{$route['station_to']['piername']}}) @endif
                                            <x-booking-master-info
                                                :info="$route['master_to']"
                                                :station="$route['station_to']['name']"
                                                :googlemap="$route['station_to']['google_map']"
                                                :image="$route['station_to']['image']['path']"
                                                :store="$icon_url" />
                                        </span>
                                    </p>
                                </div>

                                <div @class(['col-lg-1', 'px-0', 'travel-time', 'd-flex', 'justify-content-center', 'align-items-center', 'col-3' => $route['text_1'] != '', 'col-12' => $route['text_1'] == ''])>
                                    <p class="mb-0 smaller">{{ $route['travel_time'] }}</p>
                                </div>

                                @if($route['text_1'] != '')
                                    <div class="col-9 col-lg-3 route-text d-flex justify-content-start align-items-center">
                                        <p class="mb-0 smaller">{{ $route['text_1'] }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="row pt-2 border-top">
                                <div class="col-12 route-icon d-flex align-items-center justify-content-lg-start justify-content-center">
                                    <x-booking-select-icon
                                        :icons="$route['icons']"
                                        :icon_url="$icon_url"
                                    />
                                </div>

                                @if($route['text_2'] != '')
                                    <div class="col-12 col-lg-8 d-flex align-items-center justify-content-center justify-content-lg-start">
                                        <p class="mb-0 smaller">{{ $route['text_2'] }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 col-lg-2 mt-lg-0 mt-3 d-lg-flex justify-content-lg-center align-items-lg-center booking-selected-zone">
                            <div class="text-end">
                                <div class="row">
                                    <div class="col-6 col-lg-12 mb-0 text-center-m" style="line-height: 18px;">
                                        <p class="mb-0 position-relative">
                                            <span class="small me-2">THB</span>
                                            @if(isset($route['promo_price']) && $route['promo_price'] != 0)
                                                <span class="smaller text-danger current-price"><s>{{ number_format($route['amount']) }}</s></span>
                                                <span class="route-price promo-price fs-4">{{ number_format($route['promo_price']) }}</span>
                                            @else
                                                <span class="route-price fs-4">{{ number_format($route['amount']) }}</span>
                                            @endif
                                        </p>
                                        <p class="mb-1 smaller">For {{ $passenger[0] + $passenger[1] + $passenger[2] }} passenger(s)</p>
                                    </div>
                                    <div class="col-6 col-lg-12 mt-2 mt-lg-0 mb-lg-2 text-center-m">
                                        <button type="button" class="btn btn-sm button-orange-bg btn-route-return-list py-1 px-3 btn-route-return-select-{{ $index }}">Select</button>
                                    </div>
                                    <div class="col-6 col-lg-12 text-center-m passenger-icon-price-list">
                                        <x-booking-select-passenger-icon
                                            :passenger="$passenger"
                                            :p_adult="$route['p_adult']"
                                            :p_child="$route['p_child']"
                                            :p_infant="$route['p_infant']"
                                        />
                                    </div>
                                </div>
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
        <input type="hidden" name="booking_return_selected" value="">
        <input type="hidden" name="use_promocode" value="{{ $promocode }}">
    </div>
</div>
