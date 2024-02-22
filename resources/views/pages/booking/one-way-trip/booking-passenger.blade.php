<div id="booking-route-passenger">
    <h4 class="mb-0">Passengers</h4>
    <small>Enter passenger details</small>
    <div class="row mt-2 mb-5 bg-white border-radius-10 border border-booking-passenger">
        <div class="col-12 py-3 bg-booking-passenger" style="border-radius: 10px 10px 0 0;">
            Passenger 1 <span class="text-light">(Lead passenger)</span>
        </div>
        <div class="col-12 mt-3" id="lead-passenger">
            <div class="row">
                <div class="col-12 col-lg-2 form-floating mb-3">
                    <select required class="form-select form-select-sm" name="title[]" id="passenger-title" aria-label="Floating label select example">
                        <option value="" selected disabled>Select Title</option>
                        <option value="mr">Mr.</option>
                        <option value="mrs">Mrs.</option>
                        <option value="ms">Ms.</option>
                        <option value="other">Other</option>
                    </select>
                    <label for="passenger-title">Title<span class="text-danger">*</span></label>
                </div>
                <div class="col-12 col-lg-5 form-floating mb-3">
                    <input required type="text" class="form-control form-control-sm" name="first_name[]" id="passenger-first-name" placeholder="First name & Middle name">
                    <label for="passenger-first-name" class="ms-2">First name & Middle name<span class="text-danger">*</span></label>
                </div>
                <div class="col-12 col-lg-5 form-floating mb-3">
                    <input required type="text" class="form-control form-control-sm" name="last_name[]" id="passenger-last-name" placeholder="Last name">
                    <label for="passenger-last-name" class="ms-2">Last name<span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-7 form-floating mb-3">
                    <input required type="text" name="birth_day[]" class="form-control form-control-sm datepicker lead-passenger-b-day"
                        data-show-weeks="true"
                        data-today-highlight="true"
                        data-today-btn="false"
                        data-clear-btn="false"
                        data-autoclose="true"
                        data-format="DD/MM/YYYY"
                        data-date-start="1924-01-01"
                        autocomplete="off"
                        placeholder="Date of Birth">
                    <label class="ms-2">Date of Birth<span class="text-danger">*</span></label>
                </div>
            </div>

            <div class="row mb-3 mb-lg-0">
                <div class="col-12 col-lg-7">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Contact Infomation</label>
                            <div class="form-floating mb-3">
                                <input required type="email" name="email" class="form-control form-control-sm" id="passenger-email" placeholder="E-mail" autocomplete="true"
                                        onselectstart="return false" onpaste="return false;" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false"
                                >
                                <label for="passenger-email" class="ms-2">E-mail<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-floating mb-3">
                                <input required type="email" name="confirm_email" class="form-control form-control-sm" id="passenger-confirm-email" placeholder="Confirm E-mail"
                                        onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false"
                                >
                                <label for="passenger-confirm-email" class="ms-2">Confirm E-mail<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Telephone number<span class="text-danger">*</span> ( <i class="fi fi-phone"></i> )</label>
                            <div class="row">
                                <div class="col-5">
                                    <select required class="form-select" name="mobile_code">
                                        <option value="" selected disabled></option>
                                        @foreach($code_country as $code)
                                            <option value="{{ $code }}">{{ $code }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-7">
                                    <input required type="number" class="form-control" name="mobile">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mt-4 pt-1">
                            <label class="form-label position-absolute mt-n4">Thai telephone number (if any)</label>
                            <div class="row">
                                <div class="col-4">
                                    <input type="text" name="th_code" class="form-control" value="+66" readonly>
                                </div>
                                <div class="col-8">
                                    <input type="number" name="th_mobile" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-5 form-floating mb-3">
                    <select required class="form-select form-select-sm" name="country" id="passenger-country" aria-label="Floating label select example" autocomplete="true">
                        <option value="" selected disabled>Select Country</option>
                        @foreach($country_list as $country)
                            <option value="{{ $country }}">{{ $country }}</option>
                        @endforeach
                    </select>
                    <label for="passenger-country">Country<span class="text-danger">*</span></label>
                </div>
                <div class="col-12 col-lg-5 offset-0 offset-lg-2 form-floating mb-3">
                    <input required type="text" name="passport_number" class="form-control form-control-sm" id="passenger-passport" placeholder="Passport Number">
                    <label for="passenger-passport" class="ms-2">Passport Number<span class="text-danger">*</span></label>
                </div>
            </div>
            <div class="row">
                <div class="col-12 form-floating mb-3">
                    <textarea class="form-control" placeholder="Address" id="passenger-address" name="address" style="height: 100px" autocomplete="true"></textarea>
                    <label for="passenger-address" class="ms-2">Address</label>
                </div>
            </div>
        </div>
        <input type="hidden" name="passenger_type[]" value="Adult">
        @php
            $b_date = explode('/', $booking_date)
        @endphp
        <input type="hidden" name="departdate" value="{{ $booking_date }}">
    </div>

    @php
        $is_passenger = 2;
    @endphp

    @if($passenger[0] > 1)
        @for($i = $is_passenger; $i <= $passenger[0]; $i++)
            <x-set-passenger
                :passenger_num="$is_passenger"
                :type="_('Adult')"
                :color="_('booking-passenger')"
            />
            @php
                $is_passenger++;
            @endphp
        @endfor
    @endif

    @if($passenger[1] > 0)
        @for($i = 1; $i <= $passenger[1]; $i++)
            <x-set-passenger
                :passenger_num="$is_passenger"
                :type="_('Child')"
                :color="_('booking-passenger')"
            />
            @php
                $is_passenger++;
            @endphp
        @endfor
    @endif

    @if($passenger[2] > 0)
        @for($i = 1; $i <= $passenger[2]; $i++)
            <x-set-passenger
                :passenger_num="$is_passenger"
                :type="_('Infant')"
                :color="_('booking-passenger')"
            />
            @php
                $is_passenger++;
            @endphp
        @endfor
    @endif
</div>
