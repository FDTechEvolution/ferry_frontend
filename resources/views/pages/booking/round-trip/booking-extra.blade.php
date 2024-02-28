<div id="booking-route-extra">
    <h4 class="mb-0">Extra Service</h4>
    <span>Please selecte additional services</span>
    <div class="row mt-2 mb-1">
        <div class="col-12 col-lg-6">
            <h5 class="text-primary"><span class="badge bg-booking-select-depart">Depart</span> {{ $station_depart['from'] }}</h5>
        </div>
        <div class="col-12 col-lg-6">
            <h5 class="text-primary ps-lg-4">{{ $station_depart['to'] }}</h5>
        </div>
    </div>

    <div id="depart-route-extra" class="ps-lg-4 ms-lg-3 border-start border-2" style="border-color: #16aded !important;">
        @foreach($depart_routes as $index => $route)
            <x-booking-addon
                :route_addons="$route['addon_group']"
                :route_index="$index"
                :addon_icon="$addon_icon"
                :type="_('depart')"
                :station_from="$station_depart['from']"
                :station_to="$station_depart['to']"
            />

            <div @class(['d-none' => empty($route['meal_lines'])])>
                <div class="row depart-meal px-3 mb-5" id="extra-depart-meal-index-{{ $index }}">
                    @if(!empty($route['meal_lines']))
                        <h5 class="mb-2">Meal Service</h5>
                        @foreach($route['meal_lines'] as $key => $meal)
                        <div class="col-12 mb-3 pb-2 border-bottom">
                            <div class="row">
                                <div class="col-2 col-lg-1 d-flex justify-content-center align-items-center">
                                    <img src="{{$icon_url}}/icon/meal/icon/{{$meal['image_icon']}}" width="80" id="depart-meal-img-{{ $key }}">
                                </div>
                                <div class="col-10 col-lg-7">
                                    <h6 class="mb-1" id="depart-meal-name-{{ $key }}">{{ $meal['name'] }}</h6>
                                    <p class="mb-0">{{ $meal['description'] }}</p>
                                </div>
                                <div class="col-6 col-lg-2 d-flex justify-content-center align-items-center">
                                    <span class="depart-meal-amount-{{ $key }} me-2">{{ number_format($meal['amount']) }}</span> THB
                                </div>
                                <div class="col-6 col-lg-2 d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('depart', 'meal', '{{ $key }}')"><i class="fi fi-minus smaller"></i></button>
                                    <input type="number" name="depart_meal_qty[]" id="depart-meal-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                    <input type="hidden" name="depart_meal_id[]" value="{{ $meal['id'] }}">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('depart', 'meal', '{{ $key }}')"><i class="fi fi-plus smaller"></i></button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div @class(['d-none' => empty($route['activity_lines'])])>
                <div class="row depart-activity px-3 mb-5" id="extra-depart-activity-index-{{ $index }}">
                    @if(!empty($route['activity_lines']))
                        <h5 class="mb-2">Activity Service</h5>
                        @foreach($route['activity_lines'] as $key => $activity)
                        <div class="col-12 mb-3 pb-2 border-bottom">
                            <div class="row">
                                <div class="col-2 col-lg-1 d-flex justify-content-center align-items-center">
                                    <img src="{{$icon_url}}{{$activity['icon']['path'].'/'.$activity['icon']['name']}}" width="80" id="depart-activity-img-{{ $key }}">
                                </div>
                                <div class="col-10 col-lg-7">
                                    <h6 class="mb-1" id="depart-activity-name-{{ $key }}">{{ $activity['name'] }}</h6>
                                    {!! $activity['description'] !!}
                                </div>
                                <div class="col-6 col-lg-2 d-flex justify-content-center align-items-center">
                                    <span class="depart-activity-amount-{{ $key }} me-2">{{ number_format($activity['amount']) }}</span> THB
                                </div>
                                <div class="col-6 col-lg-2 d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('depart', 'activity', '{{ $key }}')"><i class="fi fi-minus smaller"></i></button>
                                    <input type="number" name="depart_activity_qty[]" id="depart-activity-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                    <input type="hidden" name="depart_activity_id[]" value="{{ $activity['id'] }}">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('depart', 'activity', '{{ $key }}')"><i class="fi fi-plus smaller"></i></button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="row mt-4 mb-1">
        <div class="col-12 col-lg-6">
            <h5 class="text-main-color-2"><span class="badge bg-booking-select-return">Return</span> {{ $station_return['from'] }}</h5>
        </div>
        <div class="col-12 col-lg-6">
            <h5 class="text-main-color-2 ps-lg-4">{{ $station_return['to'] }}</h5>
        </div>
    </div>

    <div id="return-route-extra" class="ps-lg-4 ms-lg-3 border-start border-2" style="border-color: #ff6100 !important;">
        @foreach($return_routes as $index => $route)
            <x-booking-addon
                :route_addons="$route['addon_group']"
                :route_index="$index"
                :addon_icon="$addon_icon"
                :type="_('return')"
                :station_from="$station_return['from']"
                :station_to="$station_return['to']"
            />

            <div @class(['d-none' => empty($route['meal_lines'])])>
                <div class="row return-meal px-3 mb-5" id="extra-return-meal-index-{{ $index }}">
                    @if(!empty($route['meal_lines']))
                        <h5 class="mb-2">Meal Service</h5>
                        @foreach($route['meal_lines'] as $key => $meal)
                        <div class="col-12 mb-3 pb-2 border-bottom">
                            <div class="row">
                                <div class="col-2 col-lg-1 d-flex justify-content-center align-items-center">
                                    <img src="{{$icon_url}}/icon/meal/icon/{{$meal['image_icon']}}" width="80" id="return-meal-img-{{ $key }}">
                                </div>
                                <div class="col-10 col-lg-7">
                                    <h6 class="mb-1" id="return-meal-name-{{ $key }}">{{ $meal['name'] }}</h6>
                                    <p class="mb-0">{{ $meal['description'] }}</p>
                                </div>
                                <div class="col-6 col-lg-2 d-flex justify-content-center align-items-center">
                                    <span class="return-meal-amount-{{ $key }} me-2">{{ number_format($meal['amount']) }}</span> THB
                                </div>
                                <div class="col-6 col-lg-2 d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('return', 'meal', '{{ $key }}')"><i class="fi fi-minus smaller"></i></button>
                                    <input type="number" name="return_meal_qty[]" id="return-meal-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                    <input type="hidden" name="return_meal_id[]" value="{{ $meal['id'] }}">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('return', 'meal', '{{ $key }}')"><i class="fi fi-plus smaller"></i></button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div @class(['d-none' => empty($route['activity_lines'])])>
                <div class="row return-activity px-3 mb-5" id="extra-return-activity-index-{{ $index }}">
                    @if(!empty($route['activity_lines']))
                        <h5 class="mb-2">Activity Service</h5>
                        @foreach($route['activity_lines'] as $key => $activity)
                        <div class="col-12 mb-3 pb-2 border-bottom">
                            <div class="row">
                                <div class="col-2 col-lg-1 d-flex justify-content-center align-items-center">
                                    <img src="{{$icon_url}}{{$activity['icon']['path'].'/'.$activity['icon']['name']}}" width="80" id="return-activity-img-{{ $key }}">
                                </div>
                                <div class="col-10 col-lg-7">
                                    <h6 class="mb-1" id="return-activity-name-{{ $key }}">{{ $activity['name'] }}</h6>
                                    {!! $activity['description'] !!}
                                </div>
                                <div class="col-6 col-lg-2 d-flex justify-content-center align-items-center">
                                    <span class="return-activity-amount-{{ $key }} me-2">{{ number_format($activity['amount']) }}</span> THB
                                </div>
                                <div class="col-6 col-lg-2 d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('return', 'activity', '{{ $key }}')"><i class="fi fi-minus smaller"></i></button>
                                    <input type="number" name="return_activity_qty[]" id="return-activity-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                    <input type="hidden" name="return_activity_id[]" value="{{ $activity['id'] }}">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('return', 'activity', '{{ $key }}')"><i class="fi fi-plus smaller"></i></button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
