@props(['isfreecredit' => 'N'])

<div class="row mt-2">
    <div class="col-12">
        <label class="row mb-2">
            <div class="col-2 col-lg-1 d-flex justify-content-center align-items-center">
                <input class="form-check-input form-check-input-primary payment-methods" type="radio" name="payment_method" id="payment-method-1" value="CC">
            </div>
            <div class="col-9 col-lg-10 card bg-light">
                <div class="card-body p-2">
                    <p class="mb-0">
                        <span class="me-3 d-lg-inline d-block fw-bold">Credit Card / Debit Card</span>
                        <img src="{{ asset('icons/visa_icon.svg') }}" class="me-2" width="40"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="VISA"
                        >
                        <img src="{{ asset('icons/mastercard_icon.svg') }}" class="me-2" width="40"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Master Card"
                        >
                        <img src="{{ asset('icons/jcb_icon.svg') }}" class="me-2" width="40"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="JCB"
                        >
                    </p>
                    @if($isfreecredit == 'Y')
                        <small class="d-block mt-1 mt-minus-creditfee">Credit card fee 0%
                            <span class="text-success">Free by promoCode</span>
                        </small>
                    @else
                        <small class="d-block mt-1 mt-lg-0 mt-minus-creditfee">Credit card fee 3.5%</small>
                    @endif
                </div>
            </div>
        </label>

        <label class="row mb-2">
            <div class="col-2 col-lg-1 d-flex justify-content-center align-items-center">
                <input class="form-check-input form-check-input-primary payment-methods" type="radio" name="payment_method" id="payment-method-2" value="GCARD">
            </div>
            <div class="col-9 col-lg-10 card bg-light">
                <div class="card-body p-2">
                    <p class="mb-0">
                        <span class="me-3 fw-bold">Global Card</span>
                        <img src="{{ asset('icons/unionpay_icon.svg') }}" class="me-2" width="40"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="UnionPay"
                        >
                        <img src="{{ asset('icons/diners_icon.svg') }}" class="me-2" width="40"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Diners"
                        >
                    </p>
                </div>
            </div>
        </label>

        <label class="row mb-2">
            <div class="col-2 col-lg-1 d-flex justify-content-center align-items-center">
                <input class="form-check-input form-check-input-primary payment-methods" type="radio" name="payment_method" id="payment-method-2" value="DPAY">
            </div>
            <div class="col-9 col-lg-10 card bg-light">
                <div class="card-body p-2">
                    <p class="mb-0">
                        <span class="me-3 fw-bold">Digital Payment</span>
                        <img src="{{ asset('icons/alipay_icon.svg') }}" class="me-2" width="40"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Alipay"
                        >
                        <img src="{{ asset('icons/wechatpay_icon.svg') }}" class="me-2" width="40"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Wechat Pay"
                        >
                        <img src="{{ asset('icons/linepay_icon.svg') }}" class="me-2" width="100"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Line Pay"
                        >
                        <img src="{{ asset('icons/truemoney_wallet_icon.svg') }}" class="me-2" width="50"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="TrueMoney"
                        >
                    </p>
                </div>
            </div>
        </label>

        <label class="row mb-2">
            <div class="col-2 col-lg-1 d-flex justify-content-center align-items-center">
                <input class="form-check-input form-check-input-primary payment-methods" type="radio" name="payment_method" id="payment-method-2" value="THQR">
            </div>
            <div class="col-9 col-lg-10 card bg-light">
                <div class="card-body p-2">
                    <p class="mb-0">
                        <span class="me-3 fw-bold">Thai QR Payment</span>
                        <img src="{{ asset('icons/promptpay_icon.svg') }}" class="me-2" width="90"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Prompt Pay"
                        >
                    </p>
                </div>
            </div>
        </label>

        <label class="row mb-2">
            <div class="col-2 col-lg-1 d-flex justify-content-center align-items-center">
                <input class="form-check-input form-check-input-primary payment-methods" type="radio" name="payment_method" id="payment-method-2" value="GQR">
            </div>
            <div class="col-9 col-lg-10 card bg-light">
                <div class="card-body p-2">
                    <p class="mb-0">
                        <span class="me-3 fw-bold">QR Payment</span>
                        <img src="{{ asset('icons/visa_qr_icon.svg') }}" class="me-2 border border-secondary rounded" width="90"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Visa QR Payment"
                        >
                        <img src="{{ asset('icons/mastercard_qr_icon.svg') }}" class="me-2 border border-secondary rounded" width="90"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Master Card QR Payment"
                        >
                        <img src="{{ asset('icons/unionpay_qr_icon.svg') }}" class="me-2 border border-secondary rounded" width="90"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="UnionPay QR Payment"
                        >
                    </p>
                </div>
            </div>
        </label>
    </div>
</div>
