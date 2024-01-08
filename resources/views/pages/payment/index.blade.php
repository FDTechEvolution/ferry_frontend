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
            <iframe name="output_frame" id="output_frame" src="{{ $_p }}"  width="800" height="600"></iframe>
        @endif
    </div>
</div>
@stop

@section('script')
<style>
    @media (max-width: 540px) {
        iframe {
            aspect-ratio: 16 / 9;
            height: 70vh;
            width: 100%;
        }
    }
</style>
<script>
    const handlePaymentPostMessages = ({ data }) => {
        const { paymentResult } = data
        if (paymentResult) {
            const { respCode, respDesc, respData } = paymentResult
            const home = document.querySelector('#back-to-home')

            if(respCode == '2000'){
                home.classList.remove('d-none')
                // alert("payment completed")
                // window.location.replace("./payment/thankyou")
            }
        }
    }

    window.addEventListener('message', handlePaymentPostMessages)

    document.querySelector('#submit-booking-record').addEventListener('click', () => {
        document.querySelector('#booking-record').submit()
    })
</script>
@stop
