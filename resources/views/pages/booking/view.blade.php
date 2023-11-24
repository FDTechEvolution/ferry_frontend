@extends('layouts.default')

@section('cover-content')
<div class="px-3 py-2 bg-primary lazy text-light">
    <div class="row">
        <div class="col-10">
            <h4>View your booking</h4>
        </div>
        <div class="col-2 text-center">
            <p class="mb-2">status</p>
            xxxxxxx
        </div>
    </div>
</div>
@stop

@section('content')
<div class="row">
    <div class="col-12">
        <h4 class="mb-0">Passenger(s)</h4>
        <p class="mb-2">Passenger detail</p>
        <div class="row bg-booking-payment-passenger mx-3 p-4 mb-5">
            <div class="col-12">
                <div class="row" id="payment-passenger-detail">
                    @foreach($customers as $key => $customer)
                        <p class="fw-bold mb-1">{{ $key }}</p>
                        @foreach($customer as $cus)
                            <p class="ms-3">{{ $cus['name'] }}</p>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@stop