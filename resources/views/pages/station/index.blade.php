@extends('layouts.default')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

@section('content')
    <div class="row gx-5 min-h-50vh">
        <div class="col-12 border-bottom border-2 mt-3 d-block d-lg-none">
            <div class="flickity-preloader flickity-white flickity-dot-line" data-flickity='{ "autoPlay": false, "cellAlign": "left", "pageDots": false, "rightToLeft": false }'>
                @foreach ($stations as $index => $station)
                @php
                    $_image = $station['image'] != '' ? $store.'/'.$station['image'] : '/apple-touch-icon.png';
                @endphp
                    <div class="col-4 col-md-3 px-1">
                        <div class="cursor-pointer" onClick="updateMap(`{{ $station['map'] }}`, {{ $index }})">
                            <img src="{{ $_image }}" class="w-100 rounded img-{{ $index }}" style="height: 85px;">
                            <p class="text-center mt-1 mb-0 --lh-20 small s_m_name name-m-{{ $index }}">{{ $station['name'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-12 col-lg-7 border-end border-3 d-none d-lg-block">
            <div class="row">
                @foreach ($stations as $index => $station)
                @php
                    $_image = $station['image'] != '' ? $store.'/'.$station['image'] : '/tiger-line-partner.jpg';
                @endphp
                    <div class="col-6 col-lg-4 mb-3">
                        <div class="cursor-pointer" onClick="updateMap(`{{ $station['map'] }}`, {{ $index }})">
                            <img src="{{ $_image }}" class="w-100 station-img rounded img-{{ $index }}">
                            <p class="text-center mt-2 fw-bold --lh-20 s_name name-{{ $index }}">{{ $station['name'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-12 col-lg-5 mt-2">
            @php
                $_img = $stations[0]['image'] != '' ? $store.'/'.$stations[0]['image'] : '/tiger-line-partner.jpg';
            @endphp
            <div class="div-sticky pb-4">
                <h3 class="main-station">{{ $stations[0]['name'] }}</h3>
                <img src="{{ $_img }}" class="w-100 rounded mb-3 show-img">
                <div class="map-zone">
                    <div class="geo-map" data-geo="{{ $stations[0]['map'] }}">
                        <div id="s_geo_map" class="mb-3 w-100" style="height: 300px;"></div>
                    </div>
                    <div class="google-map d-flex justify-content-start align-items-center">
                        <h4 class="me-3 mb-0"><i class="fa-solid fa-map-location-dot"></i> Google Map</h4>
                        <a href="https://www.google.com/maps/dir/?api=1&destination={{ $stations[0]['map'] }}" class="btn btn-sm btn-primary rounded-5 fw-bold get-direction" target="_blank">Get Direction</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
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

    async function updateMap(geo, index) {
        const _geo = geo !== '' ? geo.split(',') : ''
        await clearStationSelect(index)
        await setStationSelect(index)

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
        _names.forEach(n => { n.classList.remove('text-primary') })
        _m_names.forEach(m => {
            m.classList.remove('text-primary')
            m.classList.remove('fw-bold')
        })
    }

    function setStationSelect(index) {
        const s_name = document.querySelector(`.name-${index}`)
        const m_name = document.querySelector(`.name-m-${index}`)
        _name.innerHTML = s_name.innerText
        _show.src = document.querySelector(`.img-${index}`).src

        s_name.classList.add('text-primary')
        m_name.classList.add('text-primary')
        m_name.classList.add('fw-bold')
    }

    updateMap(geo, 0)
</script>
@stop
