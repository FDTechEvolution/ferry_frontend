<div class="row mt-2">
    <div class="col-12">
        <label class="row mb-2">
            <div class="col-1 d-flex justify-content-center align-items-center">
                <input class="form-check-input form-check-input-primary payment-methods" type="radio" name="payment_method" id="payment-method-1" value="CC">
            </div>
            <div class="col-10 card bg-light">
                <div class="card-body p-2">
                    <p class="mb-0">
                        <span class="me-3 fw-bold">Credit Card / Debit Card</span>
                        <img src="{{ asset('icons/visa_icon.svg') }}" class="me-2" width="40">
                        <img src="{{ asset('icons/mastercard_icon.svg') }}" class="me-2" width="40">
                        <img src="{{ asset('icons/jcb_icon.svg') }}" class="me-2" width="40">
                    </p>
                    <small class="d-block" style="margin-top: -12px;">Credit card fee 3.5%</small>
                </div>
            </div>
        </label>
        <label class="row mb-2">
            <div class="col-1 d-flex justify-content-center align-items-center">
                <input class="form-check-input form-check-input-primary payment-methods" type="radio" name="payment_method" id="payment-method-2" value="QR">
            </div>
            <div class="col-10 card bg-light">
                <div class="card-body p-2">
                    <p class="mb-0">
                        <span class="me-3 fw-bold">QR Payment</span>
                        <img src="{{ asset('icons/qr_payment_icon.svg') }}" class="me-2" width="40">
                    </p>
                </div>
            </div>
        </label>
    </div>
</div>