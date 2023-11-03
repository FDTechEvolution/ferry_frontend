<div id="booking-route-extra">
    <h4 class="mb-0">Extra Service</h4>
    <span>Please selecte additional services</span>
    <div class="row mt-2 mb-5">
        <div class="col-12">
            <h5 class="text-primary">{{ $is_station['from'] }} <span class="mx-2 text-dark">To</span> {{ $is_station['to'] }}</h5>
        </div>
    </div>
    @foreach($routes as $index => $route)
    <div class="row route-meal" id="route-meal-index-{{ $index }}">
        @if(!empty($route['meal_lines']))
            @foreach($route['meal_lines'] as $key => $meal)
            <div class="col-12 mb-3">
                <div class="row">
                    <div class="col-1 d-flex justify-content-center align-items-center">
                        <div class="form-check mb-2">
                            <input class="form-check-input form-check-input-default" name="extra_meal[]" type="checkbox" value="{{ $meal['id'] }}">
                        </div>
                    </div>
                    <div class="col-1 d-flex justify-content-center align-items-center">
                        <img src="{{$icon_url}}/icon/meal/icon/{{$meal['image_icon']}}" width="80">
                    </div>
                    <div class="col-6">
                        <h6 class="mb-1">{{ $meal['name'] }}</h6>
                        <p>{{ $meal['description'] }}</p>
                    </div>
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <span class="extra-meal-amount me-2">{{ number_format($meal['amount']) }}</span> THB
                    </div>
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <input type="number" name="extra_qty[]" class="form-control form-control-xs text-center" value="0"> + -
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <div class="col-12 text-center">No Meal</div>
        @endif
    </div>
    @endforeach
</div>