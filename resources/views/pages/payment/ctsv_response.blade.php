@extends('layouts.default')

@section('script_head')
<!-- Event snippet for Page view conversion page -->
<script>
    gtag('event', 'conversion', { 'send_to': 'AW-11355587433/8mt2CI6E3eQZEOmG4qYq', 'value': 1.0, 'currency': 'THB' }); 
</script>
@stop

@section('content')
<div class="row min-h-50vh">
    <div class="col-12 text-center">
        <h2 class="{{ $payment_code == 100 ? 'text-success' : 'text-danger' }}">{{ $payment_result }}</h2>
        <div class="d-flex justify-content-center">
            <h4 class="me-1">Redirect to your booking in... </h4>
            <h4 class="hide timer-countdown text-main-color-2" data-timer-countdown-from="2000"
                data-timer-countdown-callback-function="autoReturn"></h4>
        </div>
        <form class="bs-validate" id="booking-record" method="POST" action="{{ route('booking-record') }}">
            @csrf
            <input type="hidden" name="booking_number" value="{{ $bookingno }}">
            <input type="hidden" name="booking_email" value="{{ $email }}">
        </form>
    </div>
</div>
@stop

@section('script')
<script>
    function autoReturn() {
        document.querySelector('#booking-record').submit()
    }
</script>
@stop