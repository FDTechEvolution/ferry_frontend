<div id="booking-multi-route-extra">
    <h4 class="mb-0">Extra Service</h4>
    <span>Please selecte additional services</span>
    @foreach($route_arr as $r_index => $routes)
    <div class="row mb-4">
        <div class="col-12 mb-2">
            <p class="mb-0 fw-bolder">
                <span class="me-0">Depart : </span>
                <span class="station-name me-4">{{ $routes['station_from'] }}</span>
                <span class="me-0">Arrival : </span>
                <span class="station-name me-4">{{ $routes['station_to'] }}</span>
                <span class="me-0">Date : </span>
                <span class="station-name">{{ $routes['depart'] }}</span>
            </p>
        </div>
        <div class="col-11 ms-5 booking-route-extra border rounded p-3" data-list="{{ $r_index }}">
            @foreach($routes['data'] as $index => $route)
                <div class="row route-shuttle-bus px-3 mb-5" id="route-shuttle-bus-index-{{ $r_index }}_{{ $index }}">
                    <h5 class="mb-2">Shuttle bus</h5>
                    @if(!empty($route['shuttle_bus']))
                        @foreach($route['shuttle_bus'] as $key => $bus)
                        <div class="col-12 mb-3 pb-2 border-bottom">
                            <div class="row">
                                <div class="col-1 d-flex justify-content-center align-items-center">
                                    <i class="fa-solid fa-van-shuttle fs-1"></i>
                                </div>
                                <div class="col-7">
                                    <h6 class="mb-1" id="extra-bus-name-{{ $key }}">{{ $bus['name'] }}</h6>
                                    <p class="mb-0">{{ $bus['description'] }}</p>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <span class="extra-bus-amount-{{ $key }} me-2">{{ number_format($bus['amount']) }}</span> THB
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('bus', '{{ $key }}', '{{ $r_index }}')"><i class="fi fi-minus smaller"></i></button>
                                    <input type="number" name="bus_qty[]" id="extra-bus-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                    <input type="hidden" name="bus_id[]" value="{{ $bus['id'] }}">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('bus', '{{ $key }}', '{{ $r_index }}')"><i class="fi fi-plus smaller"></i></button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-12">No Shuttle bus</div>
                    @endif
                </div>
                <div class="row route-longtail-boat px-3 mb-5" id="route-longtail-boat-index-{{ $r_index }}_{{ $index }}">
                    <h5 class="mb-2">Longtail boat</h5>
                    @if(!empty($route['longtail_boat']))
                        @foreach($route['longtail_boat'] as $key => $boat)
                        <div class="col-12 mb-3 pb-2 border-bottom">
                            <div class="row">
                                <div class="col-1 d-flex justify-content-center align-items-center">
                                    <i class="fa-solid fa-sailboat fs-1"></i>
                                </div>
                                <div class="col-7">
                                    <h6 class="mb-1" id="extra-boat-name-{{ $key }}">{{ $boat['name'] }}</h6>
                                    <p class="mb-0">{{ $boat['description'] }}</p>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <span class="extra-boat-amount-{{ $key }} me-2">{{ number_format($boat['amount']) }}</span> THB
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('boat', '{{ $key }}', '{{ $r_index }}')"><i class="fi fi-minus smaller"></i></button>
                                    <input type="number" name="boat_qty[]" id="extra-boat-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                    <input type="hidden" name="boat_id[]" value="{{ $boat['id'] }}">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('boat', '{{ $key }}', '{{ $r_index }}')"><i class="fi fi-plus smaller"></i></button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-12">No Longtail boat</div>
                    @endif
                </div>
                <div class="row route-meal px-3 mb-5" id="route-meal-index-{{ $r_index }}_{{ $index }}">
                    <h5 class="mb-2">Meal Service</h5>
                    @if(!empty($route['meal_lines']))
                        @foreach($route['meal_lines'] as $key => $meal)
                        <div class="col-12 mb-3 pb-2 border-bottom">
                            <div class="row">
                                <div class="col-1 d-flex justify-content-center align-items-center">
                                    <img src="{{$icon_url}}/icon/meal/icon/{{$meal['image_icon']}}" width="80" id="extra-meal-img-{{ $key }}">
                                </div>
                                <div class="col-7">
                                    <h6 class="mb-1" id="extra-meal-name-{{ $key }}">{{ $meal['name'] }}</h6>
                                    <p class="mb-0">{{ $meal['description'] }}</p>
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <span class="extra-meal-amount-{{ $key }} me-2">{{ number_format($meal['amount']) }}</span> THB
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('meal', '{{ $key }}', '{{ $r_index }}')"><i class="fi fi-minus smaller"></i></button>
                                    <input type="number" name="meal_qty[]" id="extra-meal-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                    <input type="hidden" name="meal_id[]" value="{{ $meal['id'] }}">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('meal', '{{ $key }}', '{{ $r_index }}')"><i class="fi fi-plus smaller"></i></button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-12">No Meal</div>
                    @endif
                </div>

                <div class="row route-activity px-3 mb-5" id="route-activity-index-{{ $r_index }}_{{ $index }}">
                    <h5 class="mb-2">Activity Service</h5>
                    @if(!empty($route['activity_lines']))
                        @foreach($route['activity_lines'] as $key => $activity)
                        <div class="col-12 mb-3 pb-2 border-bottom">
                            <div class="row">
                                <div class="col-1 d-flex justify-content-center align-items-center">
                                    <img src="{{$icon_url}}{{$activity['icon']['path'].'/'.$activity['icon']['name']}}" width="80" id="extra-activity-img-{{ $key }}">
                                </div>
                                <div class="col-7">
                                    <h6 class="mb-1" id="extra-activity-name-{{ $key }}">{{ $activity['name'] }}</h6>
                                    {!! $activity['description'] !!}
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <span class="extra-activity-amount-{{ $key }} me-2">{{ number_format($activity['amount']) }}</span> THB
                                </div>
                                <div class="col-2 d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('activity', '{{ $key }}')"><i class="fi fi-minus smaller"></i></button>
                                    <input type="number" name="activity_qty[]" id="extra-activity-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                    <input type="hidden" name="activity_id[]" value="{{ $activity['id'] }}">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('activity', '{{ $key }}')"><i class="fi fi-plus smaller"></i></button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="col-12">No Activity</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endforeach
</div>