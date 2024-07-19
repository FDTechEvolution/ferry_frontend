@props(['title' => '', 'stations' => [], 'store' => '', 'bg' => ''])

<div class="col-12 py-3" style="background-color: {{ $bg }};">
    <div class="row">
        <div class="col-3 text-center">
            <strong>{{ $title }}</strong>
        </div>
        <div class="col-9">
            <div class="flickity-preloader flickity-white"
                data-flickity='{ "autoPlay": false, "cellAlign": "left", "wrapAround": true,
                                "pageDots": false, "prevNextButtons": false, "rightToLeft": false }'>
                @foreach ($stations as $index => $item)
                    @php
                        $_name = '';
                        $_image = $item['image'] != '' ? $store.'/'.$item['image'] : '/apple-touch-icon.png';
                        if($item['type'] == 'airport') {
                            $_name = $item['name'];
                            $item['name'] = strpos($item['name'], 'Airport') != '' ? explode('Airport', $item['name'])[0].' Airport' : $item['name'];
                            $_name = strpos($_name, 'Airport') != '' ? explode('Airport', $_name)[1] : '';
                        }
                    @endphp
                    <div class="col-12 col-md-3 px-1">
                        <div class="cursor-pointer" onClick="updateMap(`{{ $item['map'] }}`, {{ $index }})">
                            <p class="text-center mt-1 mb-0 --lh-20 small s_m_name name-m-{{ $index }}">{{ $item['name'] }}</p>
                            <img src="{{ $_image }}" class="w-100 rounded img-{{ $index }}" style="height: 130px;">
                            @if($item['type'] == 'island' || $item['type'] == 'pier')
                                <p class="text-center mt-1 mb-0 --lh-20 smaller">({{ $item['piername'] }})</p>
                            @elseif($item['type'] == 'airport')
                                <p class="text-center mt-1 mb-0 --lh-20 smaller">{{ $_name }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
