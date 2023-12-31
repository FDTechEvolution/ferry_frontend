<div class="modal fade" id="add-person" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="addPerson" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
		<div class="modal-content">
            <div class="modal-header">
				<div class="input-group w-50">
                    <input type="hidden" id="csrf_token" value="{{ csrf_token() }}">
                    <input type="text" class="form-control form-control-sm person-number-booking" placeholder="Booking Number" aria-label="Booking Number" aria-describedby="button-person">
                    <button class="btn btn-sm btn-outline-secondary" type="button" id="button-person">Button</button>
                </div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-12 text-center d-none person-loading">
                        <i class="fi fi-circle-spin fi-spin fs-1"></i>
                    </div>
                    <div class="col-12 text-center d-none person-notice mb-3">
                        <h3 class="notice-content"></h3>
                    </div>
                </div>
                <div class="row person-detail bg-booking-payment-passenger mx-3 p-4 mb-3 d-none"></div>
                <div class="row person-route bg-booking-payment-passenger mx-3 p-4 mb-3 d-none"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-primary btn-add-person" disabled>
                    <i class="fi fi-user-plus"></i>
					Add person
				</button>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                    <i class="fi fi-close"></i>
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>