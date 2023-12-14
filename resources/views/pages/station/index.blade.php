@extends('layouts.default')

@section('content')
<div class="row min-h-50vh">
    <div class="col-12 col-lg-10 offset-lg-1">
        <h2 class="text-light py-2 px-3 bg-main-color-2 rounded">Most Popular Destination</h2>
        
        <div class="row px-3 px-lg-5">
            <div class="col-12 col-lg-6">
                @foreach($section as $section_key => $stations)
                    <div class="row p-4 mb-4 card">
                        <div class="col-12 card-body">
                            <h4 class="text-main-color-2">{{ $section_key }}</h4>
                            <ul class="list-unstyled ps-2 ps-lg-4">
                                @foreach($stations as $station)
                                    <li class="list-item mb-3 d-flex">
                                        <i class="fa-solid fa-location-dot me-2"></i>
                                        {{ $station['name'] }} 
                                        @if($station['piername'] != NULL) ({{ $station['piername'] }}) @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-12 col-lg-6">
                <div class="row g-4">
                    @foreach($image_station as $station)
                    <div class="col-6 col-lg-12 mb-0">
                        <a class="fancybox fancybox-primary" data-fancybox="gallery" href="{{ asset('cover/'.$station) }}">
                            <img class="img-fluid" src="{{ asset('cover/'.$station) }}" alt="" />
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        
    </div>
</div>
@stop