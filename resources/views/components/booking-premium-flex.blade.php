@props(['ispremiumflex' => ''])

<div id="booking-route-premuim">
    <div class="row">
        <div class="col-12 col-lg-8 offset-lg-2 card">
            <div class="row card-body">
                <h4 class="mb-2 pb-2 border-bottom"><i class="fi fi-star-full" style="color: #daa520;"></i> Premuim Flex</h4>
                <div class="col-12 col-lg-6 mb-4 mb-lg-0 border border-warning rounded p-3 bg-warning-light order-lg-2">
                    <div class="form-check mb-2">
                        <input class="form-check-input form-check-input-default" type="radio" name="ispremiumflex" value="Y" id="is-premiumflex">
                        <label class="form-check-label fw-bold" for="is-premiumflex"> Premium Flex <i class="fi fi-star-full" style="color: #daa520; margin-top: -5px;"></i></label>
                    </div>
                    <p class="mb-3">An additional 10% for travel changes can be made 1 time.</p>
                    <p class="mb-3">**Note: Tickets without +10% at this price cannot change the itinerary**</p>
                    <p class="mb-3">You can notify of travel changes, name changes and email notifications. Regarding seat availability 12 hours before departure</p>
                    <p class="text-second-color fw-bold fs-4 mb-0">+ <span class="is-premium-price"></span> <span class="smaller ms-1">THB</span></p>
                    @if($ispremiumflex == 'Y')
                        <small class="text-success selected-route-promocode d-none">Free by promoCode</small>
                    @endif
                </div>
                <div class="col-12 col-lg-6 mt-3 order-lg-1">
                    <div class="form-check mb-2">
                        <input class="form-check-input form-check-input-default" type="radio" name="ispremiumflex" value="N" id="none-premiumflex" checked>
                        <label class="form-check-label fw-bold" for="none-premiumflex">Non-Premium Flex</label>
                    </div>
                    <input type="hidden" name="ispremiumflex" value="Y">
                    <input type="hidden" class="ispremiumflex" value="{{ $ispremiumflex }}">
                </div>
            </div>
        </div>
    </div>
</div>
