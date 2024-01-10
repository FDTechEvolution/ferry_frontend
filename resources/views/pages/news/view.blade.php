@extends('layouts.default')

@section('content')
<div class="row min-h-50vh">
    <div class="col-12">
        <div class="row">
            <div class="col-12 border-bottom mb-3 pb-3">
                <h2 class="mb-0">{{ $news['title'] }}</h2>
                <p class="mb-0 smaller"><span class="fw-bold">Post Date:</span> {{ date('M d, Y', strtotime($news['created_at'])) }}</p>
            </div>
            <div class="col-12 col-lg-9 mt-lg-4 px-lg-4">
                {!! $news['body'] !!}
            </div>
            <div class="col-12 col-lg-3 mt-5 mt-lg-0">
                <div class="row">
                    <div class="col-6 col-lg-12 mb-5">
                        <h4>Top Recommended</h4>
                        <ul class="nav flex-column">
                        @foreach($_news as $new)
                            <li class="nav-item py-2 border-bottom lh--16 d-flex">
                                <i class="fi fi-arrow-end m-0 smaller me-2"></i>
                                <a href="{{ route('news-view', ['id' => $new['id']]) }}" class="nav-link py-0 ps-0 text-dark">
                                    <p class="mb-0">{{ $new['title'] }}</p>
                                    <small class="smaller">{{ date('M d, Y', strtotime($new['created_at'])) }}</small>
                                </a>
                            </li>
                        @endforeach
                        </ul>
                    </div>
                    <div class="col-6 col-lg-12">
                        <img src="{{ asset('banner/banner_news.jpg') }}" class="img-fluid" style="border-radius: 10px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop
