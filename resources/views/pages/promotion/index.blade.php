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
                    <div class="col-12 col-lg-3 text-center">
                        <i class="fa-solid fa-barcode" style="font-size: 6rem;"></i>
                        <i class="fa-solid fa-barcode" style="font-size: 6rem;"></i>
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
