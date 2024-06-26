@props(['ispremiumflex' => '', 'premium_flex' => []])

<div id="booking-route-premuim">
    <div class="row">
        <div class="col-12 col-lg-10 mx-auto card">
            <div class="row card-body">
                <h4 class="mb-2 pb-2 border-bottom"><i class="fi fi-star-full" style="color: #daa520;"></i> Premuim Flex</h4>
                <div class="col-12 col-lg-6 mb-4 mb-lg-0 p-2 order-lg-2">
                    <div class="bg-primary-soft p-3 rounded premium-border border-selected" style="min-height: 420px;">
                        <div class="form-check mb-2">
                            <input class="form-check-input form-check-input-default premium-selected" type="radio" name="ispremiumflex" value="Y" id="is-premiumflex" checked>
                            <label class="form-check-label fw-bold" for="is-premiumflex"> {{ $premium_flex[1]['title'] }} <i class="fi fi-star-full" style="color: #daa520; margin-top: -5px;"></i></label>
                        </div>
                        {!! $premium_flex[1]['body'] !!}
                        {{-- <p class="mb-3">Think your plans might change? You need the Flex</p>
                        <p class="mb-2 text-primary">Following are the benefits:</p>
                        <ul>
                            <li>
                                <p class="mb-0">Guests may change trips up to 3 hours before the scheduled time of departure.</p>
                                <p class="mb-0 text-warning">No fee is changed for these first three (3) changes, but fare differences apply (if any).</p>
                            </li>
                            <li>
                                Premium Flex Hotline: Premium Flex guest are able to us the Premium Hotline number.
                            </li>
                        </ul> --}}
                        <p class="text-second-color fw-bold fs-4 mb-0">+ <span class="is-premium-price"></span> <span class="smaller ms-1">THB</span></p>
                        @if($ispremiumflex == 'Y')
                            <small class="text-success selected-route-promocode d-none">Free by promoCode</small>
                        @endif
                    </div>
                </div>
                <div class="col-12 col-lg-6 mb-4 mb-lg-0 rounded p-2 order-lg-1">
                    <div class="bg-secondary-soft p-3 rounded online-border border-none-selected" style="min-height: 420px;">
                        <div class="form-check mb-2">
                            <input class="form-check-input form-check-input-default online-selected" type="radio" name="ispremiumflex" value="N" id="none-premiumflex">
                            <label class="form-check-label fw-bold" for="none-premiumflex">{{ $premium_flex[0]['title'] }}</label>
                        </div>
                        {!! $premium_flex[0]['body'] !!}
                        {{-- <p class="mb-2 text-primary">Fare conditions:</p>
                        <ul>
                            <li>
                                <p>Changes of traveling date or passenger name can be made through the Booking Center via email only,
                                Email: 168ferry@gmail.com The traveling date or passenger name changes may be made at least 48 hours before
                                the departure time.
                                    <span class="text-danger">Please not that change frees is 25% of the fare, plus the fare differences apply</span>
                                </p>
                            </li>
                        </ul> --}}
                        <input type="hidden" class="ispremiumflex" value="{{ $ispremiumflex }}">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-selected {
        border: 2px solid #faac00;
    }
    .border-none-selected {
        border: 2px solid transparent;
    }
</style>

<script>
    const p_selected = document.querySelector('.premium-selected')
    const o_selected = document.querySelector('.online-selected')

    p_selected.addEventListener('click', () => {
        document.querySelector('.premium-border').classList.add('border-selected')
        document.querySelector('.premium-border').classList.remove('border-none-selected')

        document.querySelector('.online-border').classList.remove('border-selected')
        document.querySelector('.online-border').classList.add('border-none-selected')
    })
    o_selected.addEventListener('click', () => {
        document.querySelector('.online-border').classList.add('border-selected')
        document.querySelector('.online-border').classList.remove('border-none-selected')

        document.querySelector('.premium-border').classList.remove('border-selected')
        document.querySelector('.premium-border').classList.add('border-none-selected')
    })
</script>
