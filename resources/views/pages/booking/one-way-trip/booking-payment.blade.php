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
                <div class="col-12 text-end pe-5 pt-3 border-top border-secondary">
                    <h6>Total THB <span class="sum-of-payment"></span></h6>
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

    <div class="d-none">
        <h4 class="mb-0">Payment</h4>
        <p class="mb-0">Select payment method</p>
        <div class="accordion mx-3 mb-5 mt-2" id="accordionShadow">
            <p class="mb-0">Select a payment to complete booking</p>
            <div class="card mb-2">
                <div class="card-header mb-0 p-0 border-0 bg-transparent" id="headingCreditCard">
                    <h2 class="mb-0">
                        <button class="btn btn-link w-100 btn-md text-align-start text-decoration-none text-dark bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#credit-debit-card" aria-expanded="false" aria-controls="shadowCollapseCreditCard">
                            Credit Card / Debit Card
                            <span class="group-icon float-end">
                                <i class="fi fi-arrow-start-slim"></i>
                                <i class="fi fi-arrow-down-slim"></i>
                            </span>
                        </button>
                    </h2>
                </div>

                <div id="credit-debit-card" class="collapse" aria-labelledby="headingCreditCard" data-bs-parent="#shadowCollapseCreditCard">
                    <div class="card-body">
                        Anim pariatur cliche reprehenderit...
                    </div>
                </div>
            </div>

            <div class="card mb-2">
                <div class="card-header mb-0 p-0 border-0 bg-transparent" id="headingCounterPayment">
                    <h2 class="mb-0">
                        <button class="btn btn-link w-100 btn-md text-align-start text-decoration-none text-dark bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#counter-payment" aria-expanded="false" aria-controls="shadowCollapseCounterPayment">
                            Counter payment
                            <span class="group-icon float-end">
                                <i class="fi fi-arrow-start-slim"></i>
                                <i class="fi fi-arrow-down-slim"></i>
                            </span>
                        </button>
                    </h2>
                </div>

                <div id="counter-payment" class="collapse" aria-labelledby="headingCounterPayment" data-bs-parent="#shadowCollapseCounterPayment">
                    <div class="card-body">
                        Anim pariatur cliche reprehenderit...
                    </div>
                </div>
            </div>

            <div class="card mb-2">
                <div class="card-header mb-0 p-0 border-0 bg-transparent" id="headingQrPayment">
                    <h2 class="mb-0">
                        <button class="btn btn-link w-100 btn-md text-align-start text-decoration-none text-dark bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#qr-payment" aria-expanded="false" aria-controls="shadowCollapseQrPayment">
                            QR Payment
                            <span class="group-icon float-end">
                                <i class="fi fi-arrow-start-slim"></i>
                                <i class="fi fi-arrow-down-slim"></i>
                            </span>
                        </button>
                    </h2>
                </div>

                <div id="qr-payment" class="collapse" aria-labelledby="headingQrPayment" data-bs-parent="#shadowCollapseQrPayment">
                    <div class="card-body">
                        Anim pariatur cliche reprehenderit...
                    </div>
                </div>
            </div>

            <div class="card mb-2">
                <div class="card-header mb-0 p-0 border-0 bg-transparent" id="headingUnionPay">
                    <h2 class="mb-0">
                        <button class="btn btn-link w-100 btn-md text-align-start text-decoration-none text-dark bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#union-pay" aria-expanded="false" aria-controls="shadowCollapseUnionPayment">
                            Unionpay
                            <span class="group-icon float-end">
                                <i class="fi fi-arrow-start-slim"></i>
                                <i class="fi fi-arrow-down-slim"></i>
                            </span>
                        </button>
                    </h2>
                </div>

                <div id="union-pay" class="collapse" aria-labelledby="headingUnionPay" data-bs-parent="#shadowCollapseUnionPayment">
                    <div class="card-body">
                        Anim pariatur cliche reprehenderit...
                    </div>
                </div>
            </div>

            <div class="card mb-2">
                <div class="card-header mb-0 p-0 border-0 bg-transparent" id="headingLinePay">
                    <h2 class="mb-0">
                        <button class="btn btn-link w-100 btn-md text-align-start text-decoration-none text-dark bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#line-pay" aria-expanded="false" aria-controls="shadowCollapseLinePay">
                            Line pay
                            <span class="group-icon float-end">
                                <i class="fi fi-arrow-start-slim"></i>
                                <i class="fi fi-arrow-down-slim"></i>
                            </span>
                        </button>
                    </h2>
                </div>

                <div id="line-pay" class="collapse" aria-labelledby="headingLinePay" data-bs-parent="#shadowCollapseLinePay">
                    <div class="card-body">
                        Anim pariatur cliche reprehenderit...
                    </div>
                </div>
            </div>

            <div class="card mb-2">
                <div class="card-header mb-0 p-0 border-0 bg-transparent" id="headingAirPay">
                    <h2 class="mb-0">
                        <button class="btn btn-link w-100 btn-md text-align-start text-decoration-none text-dark bg-light collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#air-pay" aria-expanded="false" aria-controls="shadowCollapseAirPay">
                            Airpay / Wechatpay
                            <span class="group-icon float-end">
                                <i class="fi fi-arrow-start-slim"></i>
                                <i class="fi fi-arrow-down-slim"></i>
                            </span>
                        </button>
                    </h2>
                </div>

                <div id="air-pay" class="collapse" aria-labelledby="headingAirPay" data-bs-parent="#shadowCollapseAirPay">
                    <div class="card-body">
                        Anim pariatur cliche reprehenderit...
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>