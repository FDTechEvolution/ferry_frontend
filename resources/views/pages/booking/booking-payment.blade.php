<div id="booking-route-payment">
    <h4 class="mb-2">Litinerary</h4>
    <div class="row bg-primary-soft mx-3 p-3 mb-5">
        <div class="col-12">
            <h5>{{ $is_station['from'] }} - {{ $is_station['to'] }}</h5>
            <p><span class="fw-bold">{{ $isType }}</span> {{ date('l d F Y' ,strtotime($booking_date)) }}</p>
        </div>
        <div class="col-8 border-end border-secondary border-2">
            <p class="is_depart_time mb-0"></p>
            <p class="mb-0">{{ $is_station['from'] }}</p>
            <div id="route-icon-payment" class="d-flex mw--48"></div>
            <p class="is_arrive_time mb-0"></p>
            <p class="mb-0">{{ $is_station['to'] }}</p>
        </div>
        <div class="col-4">
            <div class="row text-center fw-bold mb-3">
                <div class="col-4 text-start">Depart</div>
                <div class="col-4">Fare</div>
                <div class="col-4">THB</div>
            </div>
            @if($passenger[0] != 0)
                <div class="row text-center">
                    <div class="col-4 text-start">
                        @if($passenger[0] > 1) Adults @else Adult @endif
                    </div>
                    <div class="col-4">{{ $passenger[0] }} x <span class="payment-adult-price"></span></div>
                    <div class="col-4"><span class="sum-of-adult"></span></div>
                </div>
            @endif
            @if($passenger[1] != 0)
                <div class="row text-center">
                    <div class="col-4 text-start">
                        @if($passenger[1] > 1) Childs @else Child @endif
                    </div>
                    <div class="col-4">{{ $passenger[1] }} x <span class="payment-child-price"></span></div>
                    <div class="col-4"><span class="sum-of-child"></span></div>
                </div>
            @endif
            @if($passenger[2] != 0)
                <div class="row text-center">
                    <div class="col-4 text-start">
                        @if($passenger[2] > 1) Infants @else Infant @endif
                    </div>
                    <div class="col-4">{{ $passenger[2] }} x <span class="payment-infant-price"></span></div>
                    <div class="col-4"><span class="sum-of-infant"></span></div>
                </div>
            @endif

            <div class="row mt-3">
                <div class="col-12 text-end pe-5">
                    <h6>Depart <span class="sum-of-payment"></span></h6>
                </div>
            </div>
        </div>
    </div>

    <h4 class="mb-0">Extra services</h4>
    <div class="row bg-warning-soft mx-3 p-3 mb-4">
        <div class="col-12">
            <div class="row text-dark">
                <div class="col-4">Meal</div>
            </div>
        </div>
    </div>

    <h4 class="mb-0">Passenger(s)</h4>
    <h4 class="mb-2">Passenger detail</h4>
    <div class="row bg-success-soft mx-3 p-3 mb-4">
        <div class="col-12">
            <div class="row">
                <div class="col-4">Adult</div>
            </div>
        </div>
    </div>
</div>