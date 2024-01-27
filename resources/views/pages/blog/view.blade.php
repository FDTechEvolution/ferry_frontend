@extends('layouts.default')

@section('section-content')
<div class="bg-light">
    <div class="container article-format">
        <div class="row g-4 align-items-center">
            <div class="col position-relative mt-0">
                <header class="py-5">
                    <p class="smaller mb-0">Post Date : {{ date('M d, Y', strtotime($blog['created_at'])) }}</p>
                    <h1 class="mb-0 fw-bold">{{ $blog['title'] }}</h1>
                </header>
            </div>
            <div class="col-lg-6 position-relative mt-0">
                <svg class="d-none d-lg-block position-absolute h-100 top-0 text-light" style="margin-left:-3rem; width:6rem"
                        fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <polygon points="50,0 100,0 50,100 0,100"></polygon>
                </svg>
                <picture class="mb-0">
                    <img class="w-100 mb-0" src="{{ asset($store . $blog['image']['path'] . '/' . $blog['image']['name']) }}">
                </picture>
            </div>
        </div>
    </div>
</div>

<div class='container py-6'>
    <div class="col-lg-10 mx-auto">
        <div class="article-format">
            {!! $blog['description'] !!}
        </div>
    </div>
</div>
@stop

@section('script')
<style>
    .section-main {
        display: none;
    }
</style>
@stop
