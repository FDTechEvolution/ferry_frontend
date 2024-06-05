@extends('layouts.default')

@section('cover-content')
<div class="px-3 py-2 bg-primary lazy text-light">
    <div class="row">
        <div class="col-10 offset-1 d-flex align-items-center">
            <h4 class="my-2">Payment</h4>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="row min-h-50vh">
    <div class="col-12 text-center d-none" id="back-to-home">
        <div class="d-flex justify-content-center align-items-center">
            <a href="{{ route('home') }}" class="btn btn-sm bg-main-color-2 text-light rounded"><i class="fi fi-home me-2"></i> Back To Home</a>
            <span class="mx-3">OR</span>
            <button class="btn btn-sm bg-main-color-2 text-light rounded" id="submit-booking-record"><i class="fa-regular fa-calendar-days me-2"></i> View Your Booking</button>
            <form action="{{ route('booking-record') }}" id="booking-record" method="POST">
                @csrf
                <input type="hidden" name="booking_number" value="{{ $_b }}">
                <input type="hidden" name="booking_email" value="{{ $_e }}">
            </form>
        </div>
    </div>
    <div class="col-12 text-center">
        @if(!empty($_p))
            <button type="button" id="checkout-button-1">Cash</button>
            <button type="button" id="checkout-button-2">Card</button>
        @endif
    </div>
</div>
@stop

@section('script')
<script src="https://qasecure.counterservicepay.com/cspay.js"></script>

<script>
    document.querySelector("#checkout-button-1").addEventListener('click', () => {
        CSPay.configure({
            paymentData: `{{ $_p }}`
        })
    })
    // document.querySelector("#checkout-button-1").onclick = function() {
    //     console.log('xxxxx');
    //     CSPay.configure({
    //         paymentData: {{ $_p }},
    //     })
    // }
</script>
@stop
