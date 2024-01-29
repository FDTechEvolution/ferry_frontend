<div id="booking-route-payment">
    <h4 class="mb-2">Itinerary</h4>
    <div class="row bg-booking-payment-litinerary mx-3 p-3 mb-5">
        <div class="col-12 mb-5">
            <div class="row depart-litinerary">
                <div class="col-12 col-lg-8 border-bottom-mobile border-end-none-mobile border-end border-secondary border-2">
                    @php
                        $d_date = explode('/', $depart_date)
                    @endphp
                    <h5 class="mb-0">{{ $station_depart['from'] }} - {{ $station_depart['to'] }}</h5>
                    <p class="mb-1"><span class="badge bg-booking-select-depart fw-bold">Depart</span> {{ date('l d F Y' ,strtotime($d_date[1].'/'.$d_date[0].'/'.$d_date[2])) }}</p>
                    <input type="hidden" name="departdate" value="{{ $depart_date }}">

                    <div class="d-flex">
                        <p class="is_d_depart_time mb-0 me-2 fw-bold"></p> :
                        <p class="ms-2 mb-0">{{ $station_depart['from'] }}</p>
                    </div>
                    <div id="depart-icon-payment" class="d-flex mw--48"></div>
                    <div class="d-flex">
                        <p class="is_d_arrive_time mb-0 me-2 fw-bold"></p> :
                        <p class="ms-2 mb-0">{{ $station_depart['to'] }}</p>
                    </div>
                </div>
                <div class="col-12 col-lg-4 pt-2">
                    <div class="row text-center fw-bold mb-3">
                        <div class="col-4 text-start">Depart</div>
                        <div class="col-4">Fare</div>
                        <div class="col-4 text-end">THB</div>
                    </div>
                    @if($passenger[0] != 0)
                        <div class="row text-center">
                            <div class="col-4 text-start">
                                @if($passenger[0] > 1) Adults @else Adult @endif
                            </div>
                            <div class="col-4">{{ $passenger[0] }} x <span class="depart-payment-adult-price"></span></div>
                            <div class="col-4 text-end"><span class="depart-sum-of-adult"></span></div>
                        </div>
                    @endif
                    @if($passenger[1] != 0)
                        <div class="row text-center">
                            <div class="col-4 text-start">
                                @if($passenger[1] > 1) Childs @else Child @endif
                            </div>
                            <div class="col-4">{{ $passenger[1] }} x <span class="depart-payment-child-price"></span></div>
                            <div class="col-4 text-end"><span class="depart-sum-of-child"></span></div>
                        </div>
                    @endif
                    @if($passenger[2] != 0)
                        <div class="row text-center">
                            <div class="col-4 text-start">
                                @if($passenger[2] > 1) Infants @else Infant @endif
                            </div>
                            <div class="col-4">{{ $passenger[2] }} x <span class="depart-payment-infant-price"></span></div>
                            <div class="col-4 text-end"><span class="depart-sum-of-infant"></span></div>
                        </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-12 col-md-4 col-lg-12 offset-md-8 offset-lg-0 text-end">
                            <h6 class="fw-bold">Depart <span class="sum-of-depart ms-3"></span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="row return-litinerary">
                <div class="col-12 col-lg-8 border-bottom-mobile border-end-none-mobile border-end border-secondary border-2">
                    @php
                        $r_date = explode('/', $return_date)
                    @endphp
                    <h5 class="mb-0">{{ $station_return['from'] }} - {{ $station_return['to'] }}</h5>
                    <p class="mb-1"><span class="badge bg-booking-select-return fw-bold">Return</span> {{ date('l d F Y' ,strtotime($r_date[1].'/'.$r_date[0].'/'.$r_date[2])) }}</p>
                    <input type="hidden" name="returndate" value="{{ $return_date }}">

                    <div class="d-flex">
                        <p class="is_r_depart_time mb-0 me-2 fw-bold"></p> :
                        <p class="ms-2 mb-0">{{ $station_return['from'] }}</p>
                    </div>
                    <div id="return-icon-payment" class="d-flex mw--48"></div>
                    <div class="d-flex">
                        <p class="is_r_arrive_time mb-0 me-2 fw-bold"></p> :
                        <p class="ms-2 mb-0">{{ $station_return['to'] }}</p>
                    </div>
                </div>
                <div class="col-12 col-lg-4 pt-2">
                    <div class="row text-center fw-bold mb-2">
                        <div class="col-4 text-start">Return</div>
                        <div class="col-4">Fare</div>
                        <div class="col-4 text-end">THB</div>
                    </div>
                    @if($passenger[0] != 0)
                        <div class="row text-center">
                            <div class="col-4 text-start">
                                @if($passenger[0] > 1) Adults @else Adult @endif
                            </div>
                            <div class="col-4">{{ $passenger[0] }} x <span class="return-payment-adult-price"></span></div>
                            <div class="col-4 text-end"><span class="return-sum-of-adult"></span></div>
                        </div>
                    @endif
                    @if($passenger[1] != 0)
                        <div class="row text-center">
                            <div class="col-4 text-start">
                                @if($passenger[1] > 1) Childs @else Child @endif
                            </div>
                            <div class="col-4">{{ $passenger[1] }} x <span class="return-payment-child-price"></span></div>
                            <div class="col-4 text-end"><span class="return-sum-of-child"></span></div>
                        </div>
                    @endif
                    @if($passenger[2] != 0)
                        <div class="row text-center">
                            <div class="col-4 text-start">
                                @if($passenger[2] > 1) Infants @else Infant @endif
                            </div>
                            <div class="col-4">{{ $passenger[2] }} x <span class="return-payment-infant-price"></span></div>
                            <div class="col-4 text-end"><span class="return-sum-of-infant"></span></div>
                        </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-12 col-md-4 col-lg-12 offset-md-8 offset-lg-0 text-end">
                            <h6 class="fw-bold">Return <span class="sum-of-return ms-3"></span></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8 offset-lg-4 mt-3 text-end pe-0 pe-lg-5 pt-3 border-top border-secondary amount-detail-list">
            <h6 class="d-flex justify-content-end align-items-end">Route <p class="sum-of-payment w--20 w-sm-30 me-2 mb-0"></p> <small class="smaller">THB</small></h6>
            <h6 class="d-flex justify-content-end align-items-end d-none promocode-show">PromoCode <small class="ms-1">[{{$promocode}}]</small> <p class="sum-of-promocode w--20 w-sm-30 me-2 mb-0"></p> <small class="smaller">THB</small></h6>
            <h6 class="d-flex justify-content-end align-items-end">Premium Flex <p class="sum-of-premium w--20 w-sm-30 me-2 mb-0"></p> <small class="smaller">THB</small></h6>
        </div>
        <div class="col-12 col-lg-8 offset-lg-4 pt-2 pe-0 pe-lg-5 border-top">
            <h6 class="d-flex justify-content-end align-items-end pt-2">Total <p class="sum-amount w--20 w-sm-30 me-2 mb-0 text-end"></p> <small class="smaller">THB</small></h6>
        </div>
    </div>

    <div id="payment-extra-service">
        <h4 class="mb-0">Extra services</h4>
        <div class="row bg-booking-payment-extra mx-3 p-3 mb-5 extra-service-list">
            <div class="col-12 service-list" id="depart-extra">
                <h5 class="text-dark"><span class="badge bg-booking-select-depart">Depart</span> Extra service</h5>
                <div class="row ps-4 mb-3 payment-extra-shuttle-bus"></div>
                <div class="row ps-4 mb-3 payment-extra-longtail-boat"></div>
                <div class="row ps-4 mb-3 payment-extra-meal"></div>
                <div class="row ps-4 mb-3 payment-extra-activity"></div>
            </div>
            <div class="col-12 service-list" id="return-extra">
                <h5 class="text-dark"><span class="badge bg-booking-select-return">Return</span> Extra service</h5>
                <div class="row ps-4 mb-3 payment-extra-shuttle-bus"></div>
                <div class="row ps-4 mb-3 payment-extra-longtail-boat"></div>
                <div class="row ps-4 mb-3 payment-extra-meal"></div>
                <div class="row ps-4 mb-3 payment-extra-activity"></div>
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
        <x-booking-payment-list :isfreecredit="$freecredit" />
    </div>
</div>
