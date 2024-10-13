@extends('layouts.default')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

@section('content')
<div class="row">


    <div class="col-12">
        <div class="row">
            <div class="col-6 col-lg-10">
                <h1 class="text-main-color">Check-in Station</h1>
            </div>
            <div class="col-6 col-lg-2 text-end">
                <a href="/">
                    <img src="{{ asset('images/book_button.webp') }}" alt="" class="img-fluid">
                </a>
            </div>
        </div>
        <hr>

    </div>
    <div class="col-12 border-bottom border-2 mt-3 d-block d-lg-none">
        <div class="flickity-preloader flickity-white flickity-dot-line"
            data-flickity='{ "autoPlay": false, "cellAlign": "left", "pageDots": false, "rightToLeft": false }'>
            {{-- @foreach ($stations as $index => $station)
            @php
            $_image = $station['image'] != '' ? $store.'/'.$station['image'] : '/apple-touch-icon.png';
            @endphp
            <div class="col-4 col-md-3 px-1">
                <div class="cursor-pointer" onClick="updateMap(`{{ $station['map'] }}`, {{ $index }})">
                    <img src="{{ $_image }}" class="w-100 rounded img-{{ $index }}" style="height: 85px;">
                    <p class="text-center mt-1 mb-0 --lh-20 small s_m_name name-m-{{ $index }}">{{ $station['name'] }}
                    </p>
                </div>
            </div>
            @endforeach --}}
        </div>
    </div>
    @if($station_default !== null)
    <div class="col-12">
        <h3 class="main-station text-center">{{ $station_default['name'] }}</h3>
    </div>
    @endif
    <div class="col-12 col-lg-6 border-end border-3 mb-4">
        <div class="row">
            @foreach ($stations as $type => $station)
            @if($type == 'island')
            <x-station-check-in-type :title="_('Island')" :stations="$station" :store="$store" :bg="_('#fdfbca')"
                :type="$type" :color="_('#17aded')" />
            @endif
            @if($type == 'pier')
            <x-station-check-in-type :title="_('Pier')" :stations="$station" :store="$store" :bg="_('#f7f6f1')"
                :type="$type" :color="_('#d76a00')" />
            @endif
            @if($type == 'airport')
            <x-station-check-in-type :title="_('Airport Transfer')" :stations="$station" :store="$store"
                :bg="_('#cfedf5')" :type="$type" :color="_('#0082b9')" />
            @endif
            @if($type == 'hotel')
            <x-station-check-in-type :title="_('Hotel Transfer')" :stations="$station" :store="$store"
                :bg="_('#cfe8d3')" :type="$type" :color="_('#333333')" />
            @endif
            @if($type == 'other')
            <x-station-check-in-type :title="_('Other Location')" :stations="$station" :store="$store"
                :bg="_('#fccbc7')" :type="$type" :color="_('#bf000a')" />
            @endif
            @endforeach
        </div>
    </div>
    @if($station_default !== null)
    <div class="col-12 col-lg-6">
        @php
        $_img = $station_default['image'] != '' ? $store.'/'.$station_default['image'] : '/tiger-line-partner.jpg';
        @endphp
        <div class="div-sticky pb-4">

            <img src="{{ $_img }}" class="w-100 rounded mb-3 show-img">
            <p class="station-show-detail small"></p>
            <div class="map-zone">
                <div class="geo-map" data-geo="{{ $station_default['map'] }}">
                    <div id="s_geo_map" class="mb-3 w-100" style="height: 300px;"></div>
                </div>
                <div class="google-map d-flex justify-content-start align-items-center">
                    <h4 class="me-3 mb-0"><i class="fa-solid fa-map-location-dot"></i> Google Map</h4>
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $station_default['map'] }}"
                        class="btn btn-sm btn-primary rounded-5 fw-bold get-direction" target="_blank">Get Direction</a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@stop

@section('script')
<style>
    .check-in-col {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        align-items: center;
        align-content: center;
        flex-direction: column;
    }

    .min-h-140vh {
        min-height: 140vh;
    }

    p.station-show-detail {
        height: 140px;
        margin-bottom: 30px;
        overflow-y: auto;
        padding-right: 5px;
    }

    /* width */
    .station-show-detail::-webkit-scrollbar {
        width: 5px;
    }

    /* Track */
    .station-show-detail::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    .station-show-detail::-webkit-scrollbar-thumb {
        background: #888;
    }

    /* Handle on hover */
    .station-show-detail::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    .flickity-white .flickity-button {
        width: 26px !important;
        height: 26px !important;
    }

    .flickity-prev-next-button.next {
        right: -10px;
    }

    .flickity-prev-next-button.previous {
        left: -10px;
    }

    .flickity-button:before {
        line-height: 26px;
    }

    .flickity-button.previous:before {
        margin-left: -3px;
    }

    /* @media only screen and (min-width: 1000px) {
        .col-md-custom {
            width: 28%;
        }
    } */
</style>

<script>
    const div = document.querySelector('.geo-map')
    let geo = div.dataset.geo
    let map = null
    const _map = document.querySelector('.map-zone')
    const _show = document.querySelector('.show-img')
    const _name = document.querySelector('.main-station')
    const _direction = document.querySelector('.get-direction')
    const _names = document.querySelectorAll('.s_name')
    const _m_names = document.querySelectorAll('.s_m_name')
    const _detail = document.querySelector('.station-show-detail')

    async function updateMap(geo, type, index) {
        const _geo = geo !== '' ? geo.split(',') : ''
        await clearStationSelect(index)
        await setStationSelect(type, index)

        if(_geo !== '') {
            if(map !== null) {
                map.off()
                map.remove()
            }
            map = L.map(`s_geo_map`).setView([_geo[0], _geo[1]], 17)
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                        }).addTo(map)
            L.marker([_geo[0], _geo[1]]).addTo(map)

            setTimeout(function() {
                map.invalidateSize()
            }, 500)

            _direction.href = `https://www.google.com/maps/dir/?api=1&destination=${geo}`
            _map.classList.remove('d-none')
        }
        else {
            _map.classList.add('d-none')
        }
    }

    function clearStationSelect(index) {
        _detail.innerHTML = ''
        _names.forEach(n => { n.classList.remove('text-primary') })
        // _m_names.forEach(m => {
        //     m.classList.remove('text-primary')
        //     m.classList.remove('fw-bold')
        // })
    }

    function setStationSelect(type, index) {
        const s_name = document.querySelector(`.name-${type}-${index}`)
        // const m_name = document.querySelector(`.name-m-${index}`)
        const detail = document.querySelector(`.station-${type}-${index}-detail`)

        _name.innerHTML = s_name.innerText
        _detail.innerHTML = detail.dataset.detail
        _show.src = document.querySelector(`.img-${type}-${index}`).dataset.img

        s_name.classList.add('text-primary')
        // m_name.classList.add('text-primary')
        // m_name.classList.add('fw-bold')
    }

    if(`{{ $station_key }}` !== null) updateMap(geo, `{{ $station_key }}`, 0)
</script>
@stop