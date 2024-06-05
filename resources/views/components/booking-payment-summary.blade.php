@props(['total' => '0'])

<div class="card mt-2">
    <div class="card-body pt-1">
        <div class="row py-3 px-0 rounded" style="background-color: #e6edf5;">
            <div class="col-12 col-lg-5 text-end text-lg-start">
                <span class="fw-bold">Total Payment</span>
            </div>
            <div class="col-12 col-lg-7 text-end">
                <h3 class="mb-0"><span class="summary-total-payment">{{ number_format($total) }}</span> THB</h3>
                <small>Lorem Ipsum is simply dummy.</small>
            </div>
            <div class="col-12 mt-3">
                Lorem Ipsum is simply dummy text.
            </div>
        </div>

        <div class="row py-4">
            <div class="col-12 mb-2">
                <div class="row">
                    <div class="col-6">
                        Lorem Ipsum
                    </div>
                    <div class="col-6 text-end">
                        <span class="main-total-payment">{{ number_format($total) }}</span> THB
                    </div>
                </div>
            </div>
            <div class="col-12 is-credit-fee d-none">
                <div class="row">
                    <div class="col-6">
                        Processing Fee <span class="is-show-fee"></span>%
                    </div>
                    <div class="col-6 text-end">
                        <span class="fee-result"></span> THB
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
