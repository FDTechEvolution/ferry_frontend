@props(['title' => '', 'stations' => [], 'store' => '', 'bg' => '', 'type' => '', 'color' => ''])

@if(!empty($stations))
<div class="col-12 py-3" style="background-color: {{ $bg }};">
    <div class="row">
        <div class="col-12 col-md-3 text-center check-in-col mb-3 mb-md-0">
            <p class="mb-0" style="min-height: 16px;"></p>
            <img src="{{ asset('icons/check-in/'.$type.'.png') }}" class="d-none d-md-block w-50">
            <p class="mb-0 d-none d-md-block"><strong>{{ $title }}</strong></p>
            <h3 class="mb-0 d-block d-md-none border-bottom border-2 border-dark"><strong>{{ $title }}</strong></h3>
        </div>
        <div class="col-12 col-md-9">
            @php
            $prevNextButtons = count($stations) > 4 ? 'true' : 'false';
            @endphp
            <div class="flickity-preloader flickity-white" data-flickity='{ "autoPlay": false, "cellAlign": "left",
                                "pageDots": false, "prevNextButtons": {{ $prevNextButtons }}, "rightToLeft": false }'>
                @foreach ($stations as $index => $item)
                @php
                $_name = '';
                $_image = !empty($item['image']) ? $store.'/'.$item['image']['path'] : '/apple-touch-icon.png';
                if($item['type'] == 'airport') {
                $_name = $item['name'];
                $item['name'] = strpos($item['name'], 'Airport') != '' ? explode('Airport', $item['name'])[0].' Airport'
                : $item['name'];
                $_name = strpos($_name, 'Airport') != '' ? explode('Airport', $_name)[1] : '';
                }
                @endphp
                <div class="col-3 col-md-3 col-md-custom px-1">
                    <div class="cursor-pointer text-center check-in-list"
                        onClick="updateMap(`{{ $item['google_map'] }}`, '{{ $type }}', {{ $index }})">
                        <p class="text-center mt-1 mb-0 --lh-16 fw-medium small s_name name-{{ $type }}-{{ $index }}"
                            style="min-height: 38px;">{{ $item['name'] }}</p>
                        <img src="{{ asset('icons/check-in/'.$type.'.png') }}" class="w-50">
                        @if($item['type'] == 'island' || $item['type'] == 'pier')
                        <p class="text-center mt-1 mb-0 --lh-16 smaller" style="color: {{ $color }};">({{
                            $item['piername'] }})</p>
                        @elseif($item['type'] == 'airport')
                        @php
                        $nickname = strpos($_name, '-') != '' ? explode('-', $_name)[0] : $_name;
                        $_nickname = strpos($_name, '-') != '' ? explode('-', $_name)[1] : '';
                        @endphp
                        <p class="text-center mt-1 mb-0 --lh-16 smaller" style="color: {{ $color }};">
                            @if($_nickname != '')
                            {{ $nickname }} <br /> {{ $_nickname }}
                            @else
                            {{ $nickname }}
                            @endif
                        </p>
                        @endif
                        <div class="img-{{ $type }}-{{ $index }}" data-img="{{ $_image }}"></div>
                        <div class="station-{{ $type }}-{{ $index }}-detail" data-detail="{{ $item['master_from'] }}"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endif
