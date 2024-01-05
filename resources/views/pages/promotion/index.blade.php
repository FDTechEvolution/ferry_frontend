@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="text-main-color">Promotion</h1>

        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12 article-format p-4 p-lg-5 shadow-sm rounded">

            @foreach ($promotions as $item)
                <div class="row">
                    <div class="col-12 col-lg-3">
                        @if ($item['image'] != '')
                            <img class="img-fluid " src="{{ asset($store . '/' . $item['image']) }}" alt="{{ $item['title'] }}"
                                style="border-radius: 15px 15px 0px 0px;">
                        @else
                            <img class="img-fluid rounded" src="{{ asset('assets/images/cupon/a.jpg')}}" alt="{{ $item['title'] }}">
                        @endif
                    </div>
                    <div class="col-12 col-lg-9">
                        <a href="{{ route('promo-view', ['promocode' => $item['code']]) }}" target="">
                            <h3>{{ $item['title'] }}</h3>
                        </a>
                       <p>{{$item['description']}}</p>
                    </div>
                    
                </div>
                
                <hr>
            @endforeach
        </div>
    </div>
@stop
