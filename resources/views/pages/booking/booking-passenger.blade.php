<div id="booking-route-passenger">
    <h4 class="mb-0">Passengers</h4>
    <small>Enter passenger detail</mall>
    <div class="row mt-2 border-radius-10 border border-primary">
        <div class="col-12 py-3 bg-primary" style="border-radius: 10px 10px 0 0;">
            Passenger 1 <span class="text-light">(Lead passenger)</span>
        </div>
        <div class="col-12 mt-3">
            <div class="row">
                <div class="col-2 form-floating mb-3">
                    <select required class="form-select form-select-sm" id="passenger-title" aria-label="Floating label select example">
                        <option selected disabled>Select Title</option>
                        <option value="mr">Mr.</option>
                        <option value="mrs">Mrs.</option>
                        <option value="ms">Ms.</option>
                        <option value="other">Other</option>
                    </select>
                    <label for="passenger-title">Title<span class="text-danger">*</span></label>
                </div>
                <div class="col-5 form-floating mb-3">
                    <input required type="text" class="form-control form-control-sm" id="passenger-first-name" placeholder="First name & Middle name">
                    <label for="passenger-first-name" class="ms-2">First name & Middle name<span class="text-danger">*</span></label>
                </div>
                <div class="col-5 form-floating mb-3">
                    <input required type="text" class="form-control form-control-sm" id="passenger-last-name" placeholder="Last name">
                    <label for="passenger-last-name" class="ms-2">Last name<span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="row">
                <div class="col-7 form-floating mb-3">
                    <input required type="text" name="birth_day" class="form-control form-control-sm datepicker"
                        data-show-weeks="true"
                        data-today-highlight="true"
                        data-today-btn="false"
                        data-clear-btn="false"
                        data-autoclose="true"
                        data-format="DD/MM/YYYY"
                        autocomplete="off"
                        placeholder="Birth Day date">
                    <label class="ms-2">Birth Day date<span class="text-danger">*</span></label>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-7">
                    <label class="form-label">Contact Infomation</label>
                    <div class="form-floating mb-3">
                        <input required type="email" class="form-control form-control-sm" id="passenger-email" placeholder="E-mail">
                        <label for="passenger-email" class="ms-2">E-mail<span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-5">
                    <label class="form-label">Telephone number<span class="text-danger">*</span></label>
                    <div class="row">
                        <div class="col-4">
                            <select class="form-select" name="phone_code">
                                <option value="" selected disabled></option>
                                @foreach($code_country as $code)
                                    <option value="{{ $code }}">+{{ $code }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-8">
                            <input type="number" class="form-control" name="phone">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-7">
                    <div class="form-floating mb-3">
                        <input required type="email" class="form-control form-control-sm" id="passenger-confirm-email" placeholder="Confirm E-mail">
                        <label for="passenger-confirm-email" class="ms-2">Confirm E-mail<span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-5 position-relative">
                    <label class="form-label position-absolute mt-n4">Thai telephone number (if any)<span class="text-danger">*</span></label>
                    <div class="row">
                        <div class="col-4">
                            <input type="text" class="form-control" name="th_code" value="+66" readonly>
                        </div>
                        <div class="col-8">
                            <input type="number" class="form-control" name="th_phone">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-5 form-floating mb-3">
                    <select required class="form-select form-select-sm" id="passenger-country" aria-label="Floating label select example">
                        <option value="" selected disabled>Select Country</option>
                        @foreach($country_list as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>
                    <label for="passenger-country">Country<span class="text-danger">*</span></label>
                </div>
                <div class="col-5 offset-2 form-floating mb-3">
                    <input type="number" class="form-control form-control-sm" id="passenger-passport" placeholder="Passport Number">
                    <label for="passenger-passport" class="ms-2">Passport Number</label>
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-floating mb-3">
                    <textarea class="form-control" placeholder="Address" id="passenger-address" name="passenger_address" style="height: 100px"></textarea>
                    <label for="passenger-address" class="ms-2">Address</label>
                </div>
            </div>
        </div>
    </div>
</div>