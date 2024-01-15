<div id="booking-route-payment">
    <h4 class="mb-2">Itinerary</h4>
    <div class="row bg-booking-payment-litinerary mx-3 p-3 mb-5">
        <div class="col-12">
            <div class="row depart-litinerary">
                <div class="col-12 col-lg-8 border-end border-secondary border-2 border-end-none-mobile" id="set-litinerary">

                </div>
                <div class="col-12 col-lg-4">
                    @foreach($route_arr as $index => $route)
                        <div class="set-passenger-litinerary mb-3 pb-3 border-bottom child-right">
                            <div class="row text-center fw-bold mb-2">
                                <div class="col-4 text-start">Depart</div>
                                <div class="col-4">Fare</div>
                                <div class="col-4 text-end">THB</div>
                            </div>
                            @if($passenger[0] != 0)
                                <div class="row text-center">
                                    <div class="col-4 text-start">
                                        @if($passenger[0] > 1) Adults @else Adult @endif
                                    </div>
                                    <div class="col-4">{{ $passenger[0] }} x <span class="payment-adult-price-{{ $index }}"></span></div>
                                    <div class="col-4 text-end"><span class="sum-of-adult-{{ $index }}"></span></div>
                                </div>
                            @endif
                            @if($passenger[1] != 0)
                                <div class="row text-center">
                                    <div class="col-4 text-start">
                                        @if($passenger[1] > 1) Childs @else Child @endif
                                    </div>
                                    <div class="col-4">{{ $passenger[1] }} x <span class="payment-child-price-{{ $index }}"></span></div>
                                    <div class="col-4 text-end"><span class="sum-of-child-{{ $index }}"></span></div>
                                </div>
                            @endif
                            @if($passenger[2] != 0)
                                <div class="row text-center">
                                    <div class="col-4 text-start">
                                        @if($passenger[2] > 1) Infants @else Infant @endif
                                    </div>
                                    <div class="col-4">{{ $passenger[2] }} x <span class="payment-infant-price-{{ $index }}"></span></div>
                                    <div class="col-4 text-end"><span class="sum-of-infant-{{ $index }}"></span></div>
                                </div>
                            @endif
                            <div class="row mt-2">
                                <div class="col-12 text-end">
                                    <p class="fw-bold">Total : <span class="total-route-{{ $index }} mb-0 mt-2 ma-2"></span></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="row mt-3 border-top border-secondary">
                <div class="col-12 col-lg-6 offset-lg-6 text-end pe-3 pt-3 amount-detail-list">
                    <h6 class="d-flex justify-content-end align-items-end">Route <p class="sum-of-payment w--20 w-sm-30 me-2 mb-0"></p> <small class="smaller">THB</small></h6>
                    <h6 class="d-flex justify-content-end align-items-end d-none promocode-show">PromoCode <small class="ms-1">[{{$promocode}}]</small> <p class="sum-of-promocode w--20 w-sm-30 me-2 mb-0"></p> <small class="smaller">THB</small></h6>
                    <h6 class="d-flex justify-content-end align-items-end">Premium Flex <p class="sum-of-premium w--20 w-sm-30 me-2 mb-0"></p> <small class="smaller">THB</small></h6>
                </div>
            </div>
            <div class="row pt-2 pe-0 border-top">
                <div class="col-12 col-lg-6 offset-lg-6 pe-3">
                    <h6 class="d-flex justify-content-end align-items-end pt-2">Total <p class="sum-amount w--20 w-sm-30 me-2 mb-0 text-end"></p> <small class="smaller">THB</small></h6>
                </div>
            </div>
        </div>
    </div>

    <div id="payment-extra-service">
        <h4 class="mb-0">Extra services</h4>
        <div class="row bg-booking-payment-extra mx-3 p-3 mb-5">
            <div id="set-extra-service">

            </div>
            <div class="col-12 text-end mt-3 pt-3 border-top border-secondary">
                <h6 class="text-dark pe-4">Total THB <span id="sum-of-extra">0</span></h6>
            </div>
        </div>
    </div>

    <h4 class="mb-0">Passenger(s)</h4>
    <p class="mb-2">Passenger details</p>
    <div class="row bg-booking-payment-passenger mx-3 px-2 py-3 p-lg-4 mb-5">
        <div class="col-12">
            <div class="row" id="payment-passenger-detail">

            </div>
        </div>
    </div>

    <div class="payment-list mb-6">
        <h4 class="mb-0">Payment</h4>
        <p class="mb-0">Select payment method</p>
        <p class="mb-0 d-none">Select a payment to complete booking</p>
        <x-booking-payment-list :isfreecredit="$freecredit"/>
    </div>
</div>
