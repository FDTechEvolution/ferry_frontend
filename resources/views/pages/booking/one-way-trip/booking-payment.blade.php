<div id="booking-route-payment">
    <h4 class="mb-2">Itinerary</h4>
    <div class="row bg-booking-payment-litinerary mx-3 p-3 mb-5">
        <div class="col-12">
            <div class="row depart-litinerary">
                <div class="col-12">
                    @php
                        $b_date = explode('/', $booking_date)
                    @endphp
                    <h5 class="mb-0">{{ $is_station['from'] }} - {{ $is_station['to'] }}</h5>
                    <p><span class="fw-bold">{{ $isType }}</span> {{ date('l d F Y' ,strtotime($b_date[1].'/'.$b_date[0].'/'.$b_date[2])) }}</p>
                    <input type="hidden" name="departdate" value="{{ $booking_date }}">
                </div>
                <div class="col-12 col-lg-8 pb-2 pb-lg-0 border-bottom-mobile border-end-none-mobile border-end border-secondary border-2">
                    <div class="d-flex">
                        <p class="is_depart_time mb-0 me-2 fw-bold"></p> :
                        <p class="ms-2 mb-0">{{ $is_station['from'] }}</p>
                    </div>
                    <div id="route-icon-payment" class="d-flex mw--48"></div>
                    <div class="d-flex">
                        <p class="is_arrive_time mb-0 me-2 fw-bold"></p> :
                        <p class="ms-2 mb-0">{{ $is_station['to'] }}</p>
                    </div>
                </div>
                <div class="col-12 col-lg-4 mt-3 mt-lg-0">
                    <div class="row text-center fw-bold mb-2">
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
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12 text-end pe-0 pe-lg-5 pt-3 border-top border-secondary">
                    <h6 class="d-flex justify-content-end align-items-end">Route <p class="sum-of-payment w--7 w-sm-30 me-2 mb-0"></p> <small class="smaller">THB</small></h6>
                    <h6 class="d-flex justify-content-end align-items-end d-none promocode-show">PromoCode <small>[{{$promocode}}]</small> <p class="sum-of-promocode w--7 w-sm-30 me-2 mb-0"></p> <small class="smaller">THB</small></h6>
                    <h6 class="d-flex justify-content-end align-items-end">Premium Flex <p class="sum-of-premium w--7 w-sm-30 me-2 mb-0"></p> <small class="smaller">THB</small></h6>
                    <h6 class="d-flex justify-content-end align-items-end pt-2 border-top">Total <p class="sum-amount w--7 w-sm-30 me-2 mb-0"></p> <small class="smaller">THB</small></h6>
                </div>
            </div>
        </div>
    </div>

    <div id="payment-extra-service">
        <h4 class="mb-0">Extra services</h4>
        <div class="row bg-booking-payment-extra mx-3 p-3 mb-5">
            <div class="col-12">
                <div class="row mb-3 d-none" id="payment-extra-shuttle-bus"></div>

                <div class="row mb-3 d-none" id="payment-extra-longtail-boat"></div>

                <div class="row mb-3 d-none" id="payment-extra-meal"></div>

                <div class="row mb-3 d-none" id="payment-extra-activity"></div>
            </div>
            <div class="col-12 text-end mt-3 pt-3 border-top border-secondary">
                <h6 class="text-dark pe-4">Total THB <span id="sum-of-extra">0</span></h6>
            </div>
        </div>
    </div>

    <h4 class="mb-0">Passenger(s)</h4>
    <p class="mb-2">Passenger details</p>
    <div class="row bg-booking-payment-passenger mx-3 p-4 mb-5">
        <div class="col-12">
            <div class="row" id="payment-passenger-detail">

            </div>
        </div>
    </div>

    <div class="payment-list mb-6">
        <h4 class="mb-0">Payment</h4>
        <p class="mb-0">Select payment method</p>
        <p class="mb-0 d-none">Select a payment to complete booking</p>
        <x-booking-payment-list />
    </div>
</div>
