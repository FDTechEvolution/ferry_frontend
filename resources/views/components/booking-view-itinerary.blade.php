@props(['trip' => '', 'type' => '', 'route' => [], 'passengers' => [], 'trip_date' => '',
        'addons' => [], 'icon_url' => '', 'icons' => [], 'totalamt' => ''])

<div class="row">
    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-12">
                <p class="trip-date mb-2">
                    <strong class="me-2">{{ $trip }} Trip</strong>
                    <span class="trip-date-format">{{ date_format(date_create($trip_date), 'l d F Y') }}</span>
                </p>
            </div>
            <div class="col-12 col-lg-8 pb-2 pb-lg-0 border-end border-secondary border-2 border-bottom-mobile">
                <div class="station-from-depart">
                    <p class="is_depart_time mb-0">
                        {{ date_format(date_create($route['depart_time']), 'H:i') }}
                    </p>
                    <p class="mb-0">
                        {{ $route['station_from'] }}
                        @if($route['station_from_pier'] != null) ({{ $route['station_from_pier'] }}) @endif
                        @if($route['station_from_nickname'] != null) [{{ $route['station_from_nickname'] }}] @endif
                    </p>
                </div>
                <div id="route-icon-payment" class="d-flex mw--48">
                    @foreach ($icons as $icon)
                        <img src="{{ $icon_url }}{{ $icon['path'] }}" width="42" class="me-2">
                    @endforeach
                </div>
                <div class="station-to-arrive">
                    <p class="is_arrive_time mb-0">
                        {{ date_format(date_create($route['arrive_time']), 'H:i') }}
                    </p>
                    <p class="mb-0">
                        {{ $route['station_to'] }}
                        @if($route['station_to_pier'] != null) ({{$route['station_to_pier']}}) @endif
                        @if($route['station_to_nickname'] != null) [{{ $route['station_to_nickname'] }}] @endif
                    </p>
                </div>
            </div>
            <div class="col-12 col-lg-4 mt-3 mt-lg-0 px-0 px-lg-5">
                <div class="row text-center fw-bold mb-2">
                    <div class="col-4 text-start">Depart</div>
                    <div class="col-4">FARE</div>
                    <div class="col-4 text-end">THB</div>
                </div>
                @if($passengers['adult'] != 0)
                    <div class="row text-center">
                        <div class="col-4 text-start">
                            @if($passengers['adult'] > 1) Adults @else Adult @endif
                        </div>
                        <div class="col-4">{{ $passengers['adult'] }} x <span class="payment-adult-price">{{ number_format($route['adult_price']) }}</span></div>
                        <div class="col-4 text-end">
                            <span class="sum-of-adult">{{ number_format($passengers['adult']*$route['adult_price']) }}</span>
                        </div>
                    </div>
                @endif
                @if($passengers['child'] != 0)
                    <div class="row text-center">
                        <div class="col-4 text-start">
                            @if($passengers['child'] > 1) Childs @else Child @endif
                        </div>
                        <div class="col-4">{{ $passengers['child'] }} x <span class="payment-child-price">{{ number_format($route['child_price']) }}</span></div>
                        <div class="col-4 text-end">
                            <span class="sum-of-child">{{ number_format($passengers['child']*$route['adult_child']) }}</span>
                        </div>
                    </div>
                @endif
                @if($passengers['infant'] != 0)
                    <div class="row text-center">
                        <div class="col-4 text-start">
                            @if($passengers['infant'] > 1) Infants @else Infant @endif
                        </div>
                        <div class="col-4">{{ $passengers['infant'] }} x <span class="payment-infant-price">{{ number_format($route['infant_price']) }}</span></div>
                        <div class="col-4 text-end">
                            <span class="sum-of-infant">{{ number_format($passengers['infant']*$route['adult_infant']) }}</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-12 mb-2">
        <strong class="mb-1">Extra Service</strong>
        @foreach ($addons as $addon)
            <div class="row mb-2">
                <div class="col-12 col-lg-8 pb-2 pb-lg-0">
                    <p class="mb-0 addon-name-setup" data-type="{{ $addon['subtype'] }}">{{ $addon['name'] }}</p>
                    <small>{{ $addon['description'] }}</small>
                </div>
                <div class="col-12 col-lg-4 mt-3 mt-lg-0 px-0 px-lg-5">
                    <div class="row">
                        <div class="col-4 offset-lg-4 text-end">
                            {{ $passengers['adult'] + $passengers['child'] + $passengers['infant'] }} x {{ number_format($addon['price']) }}
                        </div>
                        <div class="col-4 text-end">
                            {{ number_format(($passengers['adult'] + $passengers['child'] + $passengers['infant']) * $addon['price']) }}
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    <div class="col-12 pe-0 pe-lg-5 mb-2">
        <h5 class="text-end"><strong><span class="me-3">{{ $type }}</span> {{ number_format($totalamt) }}</strong></h5>
    </div>
</div>
