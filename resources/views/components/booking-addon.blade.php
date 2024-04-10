@props(['route_addons' => [], 'route_index' => '', 'addon_icon' => [], 'type' => '', 'station_from' => '', 'station_to' => '', 'passenger' => ''])

@foreach ($route_addons as $r_index => $route_addon)
<div class="row route-addon-lists-{{ $type }} route-addon-index-{{ $route_index }}-{{ $type }}">
    @php
        $r_addon = count($route_addon)
    @endphp

    @foreach($route_addon as $index => $addon)
        @php
            $from_id = uniqid();
            $addon_id = uniqid();
            $addon_name = explode(' ', explode($addon['subtype'], $addon['name'])[0]);
            $str_insert = $addon['subtype'] == 'from' ? 'pick-up' : 'drop-off';
            $no_addon = $addon['subtype'] == 'from' ? 'drop-off' : 'pick-up';
            $name = ucfirst($addon_name[0]).' '.ucfirst($addon_name[1]).' '.ucfirst($str_insert).' '.ucfirst($addon['subtype']).':';
        @endphp

        @if($addon['isactive'] == 'Y')
            @if($r_addon == 1 && $addon['subtype'] == 'to')
                <div class="col-12 col-lg-6 d-none d-lg-block mb-3 pb-4 px-2 position-relative">
                    <span class="is-no-addon text-danger text-center">
                        <strong>No add-on service option {{ $no_addon }}!</strong>
                    </span>
                </div>
                <div class="col-12 col-lg-6 mb-3 pb-4 px-2">
            @else
                <div class="col-12 col-lg-6 mb-3 pb-4 px-2">
            @endif
                <h5 class="addon-name-{{ $addon['type'] }}-{{ $addon['subtype'] }}-{{ $route_index }}-{{ $type }}">
                    {{ $name }}
                </h5>
                <div class="card">
                    <div @class(["card-body", "row"])>
                        <div class="col-12">
                            <p class="small mb-2" style="line-height: 18px;">{{ $addon['mouseover'] }}</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center align-items-center">
                            <div class="mb-2 d-grid" style="justify-items: center;">
                                <label class="form-check-label mb-2" for="x-{{ $from_id }}">
                                    <img src="{{ asset('icons/'.$addon_icon[$addon['type']]) }}"
                                        width="70" />
                                </label>
                                <span class="route-addon-checked-{{ $type }}">
                                    <input class="form-check-input form-check-input-default"
                                            type="checkbox" id="x-{{ $from_id }}" name="" data-addon="a-{{ $addon_id }}"
                                            data-type="{{ $addon['type'] }}" data-subtype="{{ $addon['subtype'] }}"
                                            data-routeindex="{{ $route_index }}" value="{{ $addon['id'] }}"
                                            onClick="selectRouteAddon(this, '{{ $type }}')">
                                </span>

                                <input type="hidden" class="{{ $addon['type'] }}-{{ $addon['subtype'] }}-{{ $route_index }}-{{ $type }} {{ $addon['type'] }}-is-service-charge-{{ $addon['subtype'] }}"
                                        value="{{ $addon['isservice_charge'] == 'Y' ? $addon['price'] : 0 }}">
                                <input type="hidden" class="{{ $addon['type'] }}-is-service-charge-current-{{ $addon['subtype'] }}" value="{{ $addon['isservice_charge'] == 'Y' ? $addon['price'] : 0 }}"
                                        data-routeindex="{{ $route_index }}" data-ex_index="{{ $type }}" data-subtype="{{ $addon['subtype'] }}" data-type="{{ $addon['type'] }}" data-addon="a-{{ $addon_id }}">
                            </div>
                        </div>
                        <div class="col-10">
                            <textarea class="form-control route-addon-detail-default route-addon-detail-{{ $type }} addon-detail-{{ $addon['type'] }}-{{ $addon['subtype'] }}-{{ $route_index }}-{{ $type }}" rows="4" name="" placeholder="{{ $addon['message'] }}" disabled></textarea>
                            <p class="small mt-2 mb-0"><span class="fw-bold">Service charge</span>
                                <span class="addon-service-charge-{{ $addon['type'] }}-{{ $addon['subtype'] }}">
                                    @if($addon['isservice_charge'] == 'Y')
                                        @php
                                            $all_person = $passenger[0] + $passenger[1] + $passenger[2];
                                        @endphp
                                        {{ number_format($addon['price']) }} x {{ $all_person }} Person = {{ number_format($addon['price']) * $all_person }} <span class="small">THB</span>
                                    @else
                                        <span class="text-second-color">Free</span>
                                    @endif
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($r_addon == 1 && $addon['subtype'] == 'from')
                <div class="col-12 col-lg-6 d-none d-lg-block mb-3 pb-4 px-2 position-relative">
                    <span class="is-no-addon text-danger text-center">
                        <strong>No add-on service option {{ $no_addon }}!</strong>
                    </span>
                </div>
            @endif
        @endif
    @endforeach
</div>
@endforeach
