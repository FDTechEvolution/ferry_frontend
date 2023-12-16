@extends('layouts.default')
@php
    $station = $station['data'];
@endphp
@section('content')

    <div class="row">
        <div class="col-12 text-center">
            <h1>{{ $station['name'] }}</h1>
        </div>
    </div>
    <hr>
    <div class="row mb-4">
        <div class="col-12 col-lg-6 offset-lg-3 text-center">
            @if (isset($station['image']['path']))
                <a class="photoswipe" data-photoswipe="ps-group-name"
                    href="{{ asset($store . '/' . $station['image']['path']) }}">
                    <img class="img-fluid rounded" src="{{ asset($store . '/' . $station['image']['path']) }}"
                        alt="{{ $station['name'] }}" />
                </a>
            @else
            @endif
            <p>{{ $station['address'] }}</p>
        </div>
    </div>
    @if (isset($station['google_map']))
        <div class="col-12 col-lg-6 offset-lg-3 text-center">
            <h3><i class="fa-solid fa-map-location-dot"></i> Google Map</h3>
            <a href="https://www.google.com/maps/dir/?api=1&destination={{$station['google_map']}}" class="btn btn-sm btn-outline-primary" target="_blank">Get Direction</a>
            @php
                $latlong = explode(',', $station['google_map']);
                $lat = (float) $latlong[0];
                $long = (float) $latlong[1];
            @endphp
            <div class="col-12 mt-3">
                <div class="map-leaflet w-100 rounded" style="height:300px" data-map-tile="voyager" data-map-zoom="15"
                    data-map-json='[
{
"map_lat": {{ $lat }},
"map_long": {{ $long }},
"map_popup": ""
}
]'>
                    <!-- map container-->
                </div>
            </div>
        </div>
    @endif
@stop
