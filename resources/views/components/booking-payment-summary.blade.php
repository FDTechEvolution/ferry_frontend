@props(['total' => '0'])

<div class="card mt-2">
    <div class="card-body pt-1">
        <div class="row py-3 px-0 rounded" style="background-color: #e6edf5;">
            <div class="col-12 col-lg-5 text-end text-lg-start">
                <span class="fw-bold">Total Payment</span>
            </div>
            <div class="col-12 col-lg-7 text-end">
                <h3 class="mb-0">{{ number_format($total) }} THB</h3>
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
                        {{ number_format($total) }} THB
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        Lorem Ipsum Fee 3.5%
                    </div>
                    <div class="col-6 text-end">
                        {{ number_format($total) }} THB
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
