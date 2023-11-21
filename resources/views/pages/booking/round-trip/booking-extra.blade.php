<div id="booking-route-extra">
    <h4 class="mb-0">Extra Service</h4>
    <span>Please selecte additional services</span>
    <div class="row mt-2 mb-4">
        <div class="col-12">
            <h5 class="text-primary"><span class="badge bg-primary">Depart</span> {{ $station_depart['from'] }} <span class="mx-2 text-dark">To</span> {{ $station_depart['to'] }}</h5>
        </div>
    </div>
    
    <div id="depart-route-extra">
        @foreach($depart_routes as $index => $route)
            <div class="row depart-route-shuttle-bus px-3 mb-5" id="depart-route-shuttle-bus-index-{{ $index }}">
                <h5 class="mb-2">Shuttle bus</h5>
                @if(!empty($route['shuttle_bus']))
                    @foreach($route['shuttle_bus'] as $key => $bus)
                    <div class="col-12 mb-3 pb-2 border-bottom">
                        <div class="row">
                            <div class="col-1 d-flex justify-content-center align-items-center">
                                <i class="fa-solid fa-van-shuttle fs-1"></i>
                            </div>
                            <div class="col-7">
                                <h6 class="mb-1" id="depart-bus-name-{{ $key }}">{{ $bus['name'] }}</h6>
                                <p class="mb-0">{{ $bus['description'] }}</p>
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <span class="depart-bus-amount-{{ $key }} me-2">{{ number_format($bus['amount']) }}</span> THB
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('depart', 'bus', {{ $key }})"><i class="fi fi-minus smaller"></i></button>
                                <input type="number" name="depart_bus_qty[]" id="depart-bus-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                <input type="hidden" name="depart_bus_id[]" value="{{ $bus['id'] }}">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('depart', 'bus', {{ $key }})"><i class="fi fi-plus smaller"></i></button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12 ps-4">No Shuttle bus</div>
                @endif
            </div>
            <div class="row depart-route-longtail-boat px-3 mb-5" id="depart-route-longtail-boat-index-{{ $index }}">
                <h5 class="mb-2">Longtail boat</h5>
                @if(!empty($route['longtail_boat']))
                    @foreach($route['longtail_boat'] as $key => $boat)
                    <div class="col-12 mb-3 pb-2 border-bottom">
                        <div class="row">
                            <div class="col-1 d-flex justify-content-center align-items-center">
                                <i class="fa-solid fa-sailboat fs-1"></i>
                            </div>
                            <div class="col-7">
                                <h6 class="mb-1" id="depart-boat-name-{{ $key }}">{{ $boat['name'] }}</h6>
                                <p class="mb-0">{{ $boat['description'] }}</p>
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <span class="depart-boat-amount-{{ $key }} me-2">{{ number_format($boat['amount']) }}</span> THB
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('depart', 'boat', {{ $key }})"><i class="fi fi-minus smaller"></i></button>
                                <input type="number" name="depart_boat_qty[]" id="depart-boat-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                <input type="hidden" name="depart_boat_id[]" value="{{ $boat['id'] }}">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('depart', 'boat', {{ $key }})"><i class="fi fi-plus smaller"></i></button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12 ps-4">No Longtail boat</div>
                @endif
            </div>
            <div class="row depart-meal px-3 mb-5" id="extra-depart-meal-index-{{ $index }}">
                <h5 class="mb-2">Meal Service</h5>
                @if(!empty($route['meal_lines']))
                    @foreach($route['meal_lines'] as $key => $meal)
                    <div class="col-12 mb-3 pb-2 border-bottom">
                        <div class="row">
                            <div class="col-1 d-flex justify-content-center align-items-center">
                                <img src="{{$icon_url}}/icon/meal/icon/{{$meal['image_icon']}}" width="80" id="depart-meal-img-{{ $key }}">
                            </div>
                            <div class="col-7">
                                <h6 class="mb-1" id="depart-meal-name-{{ $key }}">{{ $meal['name'] }}</h6>
                                <p class="mb-0">{{ $meal['description'] }}</p>
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <span class="depart-meal-amount-{{ $key }} me-2">{{ number_format($meal['amount']) }}</span> THB
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('depart', 'meal', {{ $key }})"><i class="fi fi-minus smaller"></i></button>
                                <input type="number" name="depart_meal_qty[]" id="depart-meal-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                <input type="hidden" name="depart_meal_id[]" value="{{ $meal['id'] }}">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('depart', 'meal', {{ $key }})"><i class="fi fi-plus smaller"></i></button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12 ps-4">No Meal</div>
                @endif
            </div>

            <div class="row depart-activity px-3 mb-5" id="extra-depart-activity-index-{{ $index }}">
                <h5 class="mb-2">Activity Service</h5>
                @if(!empty($route['activity_lines']))
                    @foreach($route['activity_lines'] as $key => $activity)
                    <div class="col-12 mb-3 pb-2 border-bottom">
                        <div class="row">
                            <div class="col-1 d-flex justify-content-center align-items-center">
                                <img src="{{$icon_url}}{{$activity['icon']['path']}}" width="80" id="depart-activity-img-{{ $key }}">
                            </div>
                            <div class="col-7">
                                <h6 class="mb-1" id="depart-activity-name-{{ $key }}">{{ $activity['name'] }}</h6>
                                {!! $activity['detail'] !!}
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <span class="depart-activity-amount-{{ $key }} me-2">{{ number_format($activity['price']) }}</span> THB
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('depart', 'activity', {{ $key }})"><i class="fi fi-minus smaller"></i></button>
                                <input type="number" name="depart_activity_qty[]" id="depart-activity-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                <input type="hidden" name="depart_activity_id[]" value="{{ $activity['id'] }}">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('depart', 'activity', {{ $key }})"><i class="fi fi-plus smaller"></i></button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12 ps-4">No Activity</div>
                @endif
            </div>
        @endforeach
    </div>

    <div class="row mt-2 mb-4">
        <div class="col-12">
            <h5 class="text-primary"><span class="badge bg-warning">Return</span> {{ $station_return['from'] }} <span class="mx-2 text-dark">To</span> {{ $station_return['to'] }}</h5>
        </div>
    </div>

    <div id="return-route-extra">
        @foreach($return_routes as $index => $route)
            <div class="row return-route-shuttle-bus px-3 mb-5" id="return-route-shuttle-bus-index-{{ $index }}">
                <h5 class="mb-2">Shuttle bus</h5>
                @if(!empty($route['shuttle_bus']))
                    @foreach($route['shuttle_bus'] as $key => $bus)
                    <div class="col-12 mb-3 pb-2 border-bottom">
                        <div class="row">
                            <div class="col-1 d-flex justify-content-center align-items-center">
                                <i class="fa-solid fa-van-shuttle fs-1"></i>
                            </div>
                            <div class="col-7">
                                <h6 class="mb-1" id="return-bus-name-{{ $key }}">{{ $bus['name'] }}</h6>
                                <p class="mb-0">{{ $bus['description'] }}</p>
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <span class="return-bus-amount-{{ $key }} me-2">{{ number_format($bus['amount']) }}</span> THB
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('return', 'bus', {{ $key }})"><i class="fi fi-minus smaller"></i></button>
                                <input type="number" name="return_bus_qty[]" id="return-bus-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                <input type="hidden" name="return_bus_id[]" value="{{ $bus['id'] }}">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('return', 'bus', {{ $key }})"><i class="fi fi-plus smaller"></i></button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12 ps-4">No Shuttle bus</div>
                @endif
            </div>
            <div class="row return-route-longtail-boat px-3 mb-5" id="return-route-longtail-boat-index-{{ $index }}">
                <h5 class="mb-2">Longtail boat</h5>
                @if(!empty($route['longtail_boat']))
                    @foreach($route['longtail_boat'] as $key => $boat)
                    <div class="col-12 mb-3 pb-2 border-bottom">
                        <div class="row">
                            <div class="col-1 d-flex justify-content-center align-items-center">
                                <i class="fa-solid fa-sailboat fs-1"></i>
                            </div>
                            <div class="col-7">
                                <h6 class="mb-1" id="return-boat-name-{{ $key }}">{{ $boat['name'] }}</h6>
                                <p class="mb-0">{{ $boat['description'] }}</p>
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <span class="return-boat-amount-{{ $key }} me-2">{{ number_format($boat['amount']) }}</span> THB
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('return', 'boat', {{ $key }})"><i class="fi fi-minus smaller"></i></button>
                                <input type="number" name="return_boat_qty[]" id="return-boat-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                <input type="hidden" name="return_boat_id[]" value="{{ $boat['id'] }}">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('return', 'boat', {{ $key }})"><i class="fi fi-plus smaller"></i></button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12 ps-4">No Longtail boat</div>
                @endif
            </div>
            <div class="row return-meal px-3 mb-5" id="extra-return-meal-index-{{ $index }}">
                <h5 class="mb-2">Meal Service</h5>
                @if(!empty($route['meal_lines']))
                    @foreach($route['meal_lines'] as $key => $meal)
                    <div class="col-12 mb-3 pb-2 border-bottom">
                        <div class="row">
                            <div class="col-1 d-flex justify-content-center align-items-center">
                                <img src="{{$icon_url}}/icon/meal/icon/{{$meal['image_icon']}}" width="80" id="return-meal-img-{{ $key }}">
                            </div>
                            <div class="col-7">
                                <h6 class="mb-1" id="return-meal-name-{{ $key }}">{{ $meal['name'] }}</h6>
                                <p class="mb-0">{{ $meal['description'] }}</p>
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <span class="return-meal-amount-{{ $key }} me-2">{{ number_format($meal['amount']) }}</span> THB
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('return', 'meal', {{ $key }})"><i class="fi fi-minus smaller"></i></button>
                                <input type="number" name="return_meal_qty[]" id="return-meal-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                <input type="hidden" name="return_meal_id[]" value="{{ $meal['id'] }}">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('return', 'meal', {{ $key }})"><i class="fi fi-plus smaller"></i></button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12 ps-4">No Meal</div>
                @endif
            </div>

            <div class="row return-activity px-3 mb-5" id="extra-return-activity-index-{{ $index }}">
                <h5 class="mb-2">Activity Service</h5>
                @if(!empty($route['activity_lines']))
                    @foreach($route['activity_lines'] as $key => $activity)
                    <div class="col-12 mb-3 pb-2 border-bottom">
                        <div class="row">
                            <div class="col-1 d-flex justify-content-center align-items-center">
                                <img src="{{$icon_url}}{{$activity['icon']['path']}}" width="80" id="return-activity-img-{{ $key }}">
                            </div>
                            <div class="col-7">
                                <h6 class="mb-1" id="return-activity-name-{{ $key }}">{{ $activity['name'] }}</h6>
                                {!! $activity['detail'] !!}
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <span class="return-activity-amount-{{ $key }} me-2">{{ number_format($activity['price']) }}</span> THB
                            </div>
                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('return', 'activity', {{ $key }})"><i class="fi fi-minus smaller"></i></button>
                                <input type="number" name="return_activity_qty[]" id="return-activity-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                <input type="hidden" name="return_activity_id[]" value="{{ $activity['id'] }}">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('return', 'activity', {{ $key }})"><i class="fi fi-plus smaller"></i></button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12 ps-4">No Activity</div>
                @endif
            </div>
        @endforeach
    </div>
</div>