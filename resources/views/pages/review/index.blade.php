@extends('layouts.default')

@section('content')
<div class="row min-h-50vh">
    <div class="col-12">
        <div class="row">
            <h1 class="text-center mb-3 fw-bold">Review</h1>
            @foreach($reviews as $review)
                <div class="col-4 m-3 p-3 card border-review">
                    <div class="card-body">
                        <p class="mb-2 fw-bold">{{ $review['title'] }}</p>
                        {{ $review['body'] }}
                        <hr/>
                        <p class="mb-0">{{ $review['reviewname'] }}</p>
                        <span class="d-flex">
                            @for($i = 1; $i <= $review['rating']; $i++)
                                <i class="fi fi-star-full" style="color: #daa520;"></i>
                            @endfor
                        </span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .border-review {
        border-right: 6px solid #f30512;
    }
</style>
@stop