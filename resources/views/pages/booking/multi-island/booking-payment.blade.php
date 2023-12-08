<div id="booking-route-payment">
    <h4 class="mb-2">Litinerary</h4>
    <div class="row bg-booking-payment-litinerary mx-3 p-3 mb-5">
        <div class="col-12">
            <div class="row depart-litinerary">
                <div class="col-8 border-end border-secondary border-2" id="set-litinerary">
                    
                </div>
                <div class="col-4">
                    @foreach($route_arr as $index => $route)
                        <div class="set-passenger-litinerary mb-3 pb-3 border-bottom child-right">
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
                                    <div class="col-4">{{ $passenger[0] }} x <span class="payment-adult-price-{{ $index }}"></span></div>
                                    <div class="col-4"><span class="sum-of-adult-{{ $index }}"></span></div>
                                </div>
                            @endif
                            @if($passenger[1] != 0)
                                <div class="row text-center">
                                    <div class="col-4 text-start">
                                        @if($passenger[1] > 1) Childs @else Child @endif
                                    </div>
                                    <div class="col-4">{{ $passenger[1] }} x <span class="payment-child-price-{{ $index }}"></span></div>
                                    <div class="col-4"><span class="sum-of-child-{{ $index }}"></span></div>
                                </div>
                            @endif
                            @if($passenger[2] != 0)
                                <div class="row text-center">
                                    <div class="col-4 text-start">
                                        @if($passenger[2] > 1) Infants @else Infant @endif
                                    </div>
                                    <div class="col-4">{{ $passenger[2] }} x <span class="payment-infant-price-{{ $index }}"></span></div>
                                    <div class="col-4"><span class="sum-of-infant-{{ $index }}"></span></div>
                                </div>
                            @endif
                            <div class="row">
                                <div class="col-12 text-end">
                                    <p class="fw-bold">Total : <span class="total-route-{{ $index }} mb-0 mt-2 me-4 pe-1"></span></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
            <div id="set-extra-service">
                
            </div>
            <div class="col-12 text-end mt-3 pt-3 border-top border-secondary">
                <h6 class="text-dark pe-4">Total THB <span id="sum-of-extra">0</span></h6>
            </div>
        </div>
    </div>

    <h4 class="mb-0">Passenger(s)</h4>
    <p class="mb-2">Passenger detail</p>
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