@props(['route_addons' => [], 'route_index' => '', 'addon_icon' => [], 'type' => '', 'station_from' => '', 'station_to' => ''])

@foreach ($route_addons as $r_index => $route_addon)
<div class="row route-addon-lists-{{ $type }} route-addon-index-{{ $route_index }}-{{ $type }}">
    @php
        $r_addon = count($route_addon)
    @endphp

    @foreach($route_addon as $index => $addon)
        @php
            $from_id = uniqid();
        @endphp

        @if($addon['isactive'] == 'Y')
            @if($r_addon == 1 && $addon['subtype'] == 'to')
                <div class="col-12 col-lg-6 offset-lg-6 mb-3 pb-4 px-2 border-bottom">
            @else
                <div class="col-12 col-lg-6 mb-3 pb-4 px-2 border-bottom">
            @endif
                <h5 class="addon-name-{{ $addon['type'] }}-{{ $addon['subtype'] }}-{{ $route_index }}-{{ $type }}">
                    {{ $addon['name'] }} @if($addon['subtype'] == 'from') {{ $station_from }} @else {{ $station_to }} @endif
                </h5>
                <div class="card">
                    <div @class(["card-body", "row", "border-end" => $addon['subtype'] == 'from'])>
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <div class="mb-2 d-grid" style="justify-items: center;">
                                <label class="form-check-label mb-2" for="x-{{ $from_id }}">
                                    <img src="{{ asset('icons/'.$addon_icon[$addon['type']]) }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $addon['mouseover'] }}"
                                        width="70" />
                                </label>
                                <span class="route-addon-checked-{{ $type }}">
                                    <input class="form-check-input form-check-input-default"
                                            type="checkbox" id="x-{{ $from_id }}" name=""
                                            data-type="{{ $addon['type'] }}" data-subtype="{{ $addon['subtype'] }}"
                                            data-routeindex="{{ $route_index }}" value="{{ $addon['id'] }}"
                                            onClick="selectRouteAddon(this, '{{ $type }}')">
                                </span>

                                <input type="hidden" class="{{ $addon['type'] }}-{{ $addon['subtype'] }}-{{ $route_index }}-{{ $type }}"
                                        value="{{ $addon['isservice_charge'] == 'Y' ? $addon['price'] : 0 }}">
                            </div>
                        </div>
                        <div class="col-10">
                            <textarea class="form-control route-addon-detail-default route-addon-detail-{{ $type }} addon-detail-{{ $addon['type'] }}-{{ $addon['subtype'] }}-{{ $route_index }}-{{ $type }}" rows="4" name="" placeholder="{{ $addon['message'] }}" disabled></textarea>
                            <p class="small mt-2 mb-0"><span class="fw-bold">Service charge</span>
                                @if($addon['isservice_charge'] == 'Y')
                                    {{ number_format($addon['price']) }} <span class="small">THB</span>
                                @else
                                    <span class="text-second-color">Free</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
@endforeach

<style>
    .tooltip {
        --bs-tooltip-max-width: 400px;
    }
</style>
