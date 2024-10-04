@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-6 col-lg-10">
        <h1 class="text-main-color">Premium Flex</h1>
    </div>
    <div class="col-6 col-lg-2 text-end">
        <a href="/">
            <img src="{{ asset('images/book_button.webp') }}" alt="" class="img-fluid">
        </a>
    </div>
</div>
<hr>

<div class="row">
    <div class="col-12 col-lg-10 offset-lg-1">
        <h4>Following are the benefits</h4>
        <p><i class="fi fi-star-full" style="color: #daa520; margin-top: -5px;"></i> Guests may change trips up to 3
            hours before the scheduled time of departure. No fee is changed for these
            first three (3) changes, but fare differences apply (if any).</p>

        <p><i class="fi fi-star-full" style="color: #daa520; margin-top: -5px;"></i>Premium Flex Hotline: Premium Flex
            guest are able to us the Premium Hotline number.
        </p>
    </div>
</div>



@stop