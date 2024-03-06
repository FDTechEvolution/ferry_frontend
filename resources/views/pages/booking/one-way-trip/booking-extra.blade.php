<div id="booking-route-extra">
    <h4 class="mb-0">Extra Service</h4>
    <span>Please selecte additional services</span>
    <div class="row mt-2 mb-1">
        <div class="col-12 col-lg-6">
            <h5 class="text-primary"><i class="fa-solid fa-ship text-dark"></i> {{ $is_station['from'] }}</h5>
        </div>
        <div class="col-12 col-lg-6">
            <h5 class="text-primary"><i class="fa-solid fa-anchor text-dark"></i> {{ $is_station['to'] }}</h5>
        </div>
    </div>

    <div id="depart-route-extra" class="ps-lg-4 ms-lg-3 border-start border-2" style="border-color: #16aded !important;">
        @foreach($routes as $index => $route)
            <x-booking-addon
                :route_addons="$route['addon_group']"
                :route_index="$index"
                :addon_icon="$addon_icon"
                :type="_('depart')"
                :station_from="$is_station['from']"
                :station_to="$is_station['to']"
            />

            <div @class(['d-none' => empty($route['meal_lines'])])>
                <div class="row route-meal px-3 mb-5" id="route-meal-index-{{ $index }}">
                    @if(!empty($route['meal_lines']))
                        <h5 class="mb-2">Meal Service</h5>
                        @foreach($route['meal_lines'] as $key => $meal)
                        <div class="col-12 mb-3 pb-2 border-bottom">
                            <div class="row">
                                <div class="col-2 col-lg-1 d-flex justify-content-center align-items-center">
                                    <img src="{{$icon_url}}/icon/meal/icon/{{$meal['image_icon']}}" width="80" id="extra-meal-img-{{ $key }}">
                                </div>
                                <div class="col-10 col-lg-7">
                                    <h6 class="mb-1" id="extra-meal-name-{{ $key }}">{{ $meal['name'] }}</h6>
                                    <p class="mb-0">{{ $meal['description'] }}</p>
                                </div>
                                <div class="col-6 col-lg-2 d-flex justify-content-center align-items-center">
                                    <span class="extra-meal-amount-{{ $key }} me-2">{{ number_format($meal['amount']) }}</span> THB
                                </div>
                                <div class="col-6 col-lg-2 d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('meal', '{{ $key }}')"><i class="fi fi-minus smaller"></i></button>
                                    <input type="number" name="meal_qty[]" id="extra-meal-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                    <input type="hidden" name="meal_id[]" value="{{ $meal['id'] }}">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('meal', '{{ $key }}')"><i class="fi fi-plus smaller"></i></button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div @class(['d-none' => empty($route['activity_lines'])])>
                <div class="row route-activity px-3 mb-5" id="route-activity-index-{{ $index }}">
                    @if(!empty($route['activity_lines']))
                        <h5 class="mb-2">Activity Service</h5>
                        @foreach($route['activity_lines'] as $key => $activity)
                        <div class="col-12 mb-3 pb-2 border-bottom">
                            <div class="row">
                                <div class="col-2 col-lg-1 d-flex justify-content-center align-items-center">
                                    <img src="{{$icon_url}}{{$activity['icon']['path'].'/'.$activity['icon']['name']}}" width="80" id="extra-activity-img-{{ $key }}">
                                </div>
                                <div class="col-10 col-lg-7">
                                    <h6 class="mb-1" id="extra-activity-name-{{ $key }}">{{ $activity['name'] }}</h6>
                                    {!! $activity['description'] !!}
                                </div>
                                <div class="col-6 col-lg-2 d-flex justify-content-center align-items-center">
                                    <span class="extra-activity-amount-{{ $key }} me-2">{{ number_format($activity['amount']) }}</span> THB
                                </div>
                                <div class="col-6 col-lg-2 d-flex justify-content-center align-items-center">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="dec('activity', '{{ $key }}')"><i class="fi fi-minus smaller"></i></button>
                                    <input type="number" name="activity_qty[]" id="extra-activity-index-{{ $key }}" class="form-control form-control-xs text-center mx-2 border-0" value="0" readonly>
                                    <input type="hidden" name="activity_id[]" value="{{ $activity['id'] }}">
                                    <button type="button" class="btn btn-primary rounded-circle btn-sm p-3" onClick="inc('activity', '{{ $key }}')"><i class="fi fi-plus smaller"></i></button>
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
