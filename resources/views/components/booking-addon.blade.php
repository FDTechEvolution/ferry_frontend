@props(['route_addons' => [], 'route_index' => '', 'addon_icon' => []])

<div class="row route-addon-lists route-addon-index-{{ $route_index }}">
    @foreach($route_addons as $index => $addon)
        @php
            $from_id = uniqid();
            $to_id = uniqid();
        @endphp

        @if($addon['isactive'] == 'Y')
            <div class="col-12 col-lg-6 mb-3 pb-4 border-bottom">
                <h4>{{ $addon['name'] }}</h4>
                <div class="row">
                    <div class="col-2 d-flex justify-content-center align-items-center">
                        <div class="mb-2 d-grid" style="justify-items: center;">
                            <label class="form-check-label mb-2" for="{{ $from_id }}">
                                <i class="{{ $addon_icon[$addon['type']] }} fs-2"
                                    data-bs-toggle="tooltip"
                                    data-bs-placement="top"
                                    title="{{ $addon['mouseover'] }}">
                                </i>
                            </label>
                            <input class="form-check-input form-check-input-default route-addon-checked"
                                    type="checkbox" id="{{ $from_id }}" name="route_addon[]"
                                    data-type="{{ $addon['type'] }}" data-subtype="{{ $addon['subtype'] }}"
                                    data-routeindex="{{ $route_index }}" value="{{ $addon['id'] }}">

                            <input type="hidden" class="{{ $addon['type'] }}-{{ $addon['subtype'] }}-{{ $route_index }}"
                                    value="{{ $addon['isservice_charge'] == 'Y' ? $addon['price'] : 0 }}">
                        </div>
                    </div>
                    <div class="col-10">
                        <textarea class="form-control route-addon-detail addon-detail-{{ $addon['type'] }}-{{ $addon['subtype'] }}-{{ $route_index }}" rows="3" name="" placeholder="{{ $addon['message'] }}"></textarea>
                        @if($addon['isservice_charge'] == 'Y')
                            <p class="small mt-2 mb-0"><span class="fw-bold">Service charge</span> {{ number_format($addon['price']) }} <span class="small">THB</span></p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>

<style>
    .tooltip {
        --bs-tooltip-max-width: 400px;
    }
</style>
