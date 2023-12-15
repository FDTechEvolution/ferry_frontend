<div class="modal fade" id="edit-customer" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="editCustomer" aria-hidden="true">
	<div class="modal-dialog modal-xl" role="document">
        <form novalidate method="POST" action="{{ route('booking-update-customer') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="mb-0">Edit</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    @foreach($customers as $key => $customer)
                        @if($key === 'ADULT')
                        <h6 class="fw-bold mb-1">Adult</h6>
                            @foreach($customer as $cus)
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="fullname[]" value="{{ $cus['name'] }}" placeholder="Name" autocomplete="false">
                                            <label>Name</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-floating mb-3">
                                            <input required type="text" name="date[]" class="form-control form-control-sm datepicker"
                                                data-show-weeks="true"
                                                data-today-highlight="false"
                                                data-today-btn="false"
                                                data-clear-btn="false"
                                                data-autoclose="true"
                                                data-format="DD/MM/YYYY"
                                                autocomplete="off"
                                                placeholder="Date of birth"
                                                value="{{ htmlspecialchars(date_format(date_create($cus['birth_day']), 'd/m/Y')) }}">
                                            <label class="text-secondary">Date of birth</label>
                                        </div>
                                    </div>
                                    @if($cus['email'] != NULL)
                                    <div class="col-4">
                                        <div class="form-floating mb-3">
                                            <input required type="email" class="form-control" name="email[]" value="{{ $cus['email'] }}" placeholder="Name" autocomplete="false">
                                            <label>Email</label>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <input type="hidden" name="cus_id[]" value="{{ $cus['id'] }}">
                            @endforeach
                        @endif

                        @if($key === 'CHILD')
                        <h6 class="fw-bold mb-1">Child</h6>
                            @foreach($customer as $cus)
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="fullname[]" value="{{ $cus['name'] }}" placeholder="Name" autocomplete="false">
                                            <label>Name</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-floating mb-3">
                                            <input required type="text" name="date[]" class="form-control form-control-sm datepicker"
                                                data-show-weeks="true"
                                                data-today-highlight="false"
                                                data-today-btn="false"
                                                data-clear-btn="false"
                                                data-autoclose="true"
                                                data-format="DD/MM/YYYY"
                                                autocomplete="off"
                                                placeholder="Date of birth"
                                                value="{{ htmlspecialchars(date_format(date_create($cus['birth_day']), 'd/m/Y')) }}">
                                            <label class="text-secondary">Date of birth</label>
                                        </div>
                                    </div>
                                    @if($cus['email'] != NULL)
                                    <div class="col-4">
                                        <div class="form-floating mb-3">
                                            <input required type="email" class="form-control" name="email[]" value="{{ $cus['email'] }}" placeholder="Name" autocomplete="false">
                                            <label>Email</label>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <input type="hidden" name="cus_id[]" value="{{ $cus['id'] }}">
                            @endforeach
                        @endif

                        @if($key === 'INFANT')
                        <h6 class="fw-bold mb-1">Infant</h6>
                            @foreach($customer as $cus)
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-floating mb-3">
                                            <input required type="text" class="form-control" name="fullname[]" value="{{ $cus['name'] }}" placeholder="Name" autocomplete="false">
                                            <label>Name</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-floating mb-3">
                                            <input required type="text" name="date[]" class="form-control form-control-sm datepicker"
                                                data-show-weeks="true"
                                                data-today-highlight="false"
                                                data-today-btn="false"
                                                data-clear-btn="false"
                                                data-autoclose="true"
                                                data-format="DD/MM/YYYY"
                                                autocomplete="off"
                                                placeholder="Date of birth"
                                                value="{{ htmlspecialchars(date_format(date_create($cus['birth_day']), 'd/m/Y')) }}">
                                            <label class="text-secondary">Date of birth</label>
                                        </div>
                                    </div>
                                    @if($cus['email'] != NULL)
                                    <div class="col-4">
                                        <div class="form-floating mb-3">
                                            <input required type="email" class="form-control" name="email[]" value="{{ $cus['email'] }}" placeholder="Name" autocomplete="false">
                                            <label>Email</label>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                                <input type="hidden" name="cus_id[]" value="{{ $cus['id'] }}">
                            @endforeach
                        @endif
                    @endforeach
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-sm btn-primary btn-add-person">
                        <i class="fi fi-user-plus"></i>
                        Edit
                    </button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">
                        <i class="fi fi-close"></i>
                        Cancel
                    </button>
                </div>
            </div>
            <input type="hidden" name="bookingno" value="{{ $booking['booking_number'] }}">
        </form>
    </div>
</div>