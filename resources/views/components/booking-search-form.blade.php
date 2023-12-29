@props(['type' => '', 'station_to' => [], 'form_type' => '', 'section_from' => []])

@php
    $from_id = uniqid();
    $to_id = uniqid();
    $date_id = uniqid();
    $passenger_id = uniqid();
@endphp

<div class="row px-3 is-type-{{ $form_type }}">
    <input type="hidden" name="_from_type[]" value="{{ $form_type }}">
    <div class="col-sm-3 col-md-3 px-0">

        <div class="form-floating mb-3 dropdown">
            <input required type="text" class="dropdown-toggle form-control from-{{ $type }}-{{ $form_type }}-selected" id="from-{{ $from_id }}" data-bs-toggle="dropdown" placeholder="From">
            <label class="text-secondary" for="from-{{ $from_id }}">From</label>

            <div class="dropdown-menu dropdown-booking-width dropdown-md p-3">
                <div class="row mb-2 pb-2 pb-lg-0">
                    @foreach($section_from as $key => $sections)
                        <div class="col-12 col-lg-3">
                            @foreach($sections as $section_key => $section)
                                <p class="text-main-color-2 mb-1 fw-bold">{{ $section_key }}</p>
                                <ul class="section-key-{{ $section_key }}">
                                    @foreach($section as $station_key => $station)
                                        <li class="station-select_{{ $section_key }}_{{ $station_key }} mb-2 cursor-pointer" data-id="{{ $station['id'] }}" onClick="fromOriginalSelected2(this, '{{ $type }}', '{{ $form_type }}')">{{ $station['name'] }} @if($station['piername'] != NULL) ({{$station['piername']}}) @endif</li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            <input type="hidden" id="from-selected_{{ $type }}-{{ $form_type }}" name="from[]" value="">
        </div>
    </div>

    <div class="col-sm-3 col-md-3 px-0">

        <div class="form-floating mb-3 dropdown">
            <i class="fi fi-loading fi-spin loading-destination loading-destination-{{ $type }}-{{ $form_type }} d-none"></i>
            <input required type="text" class="dropdown-toggle form-control input-to-{{ $type }}-{{ $form_type }}" id="to-{{ $to_id }}" data-bs-toggle="dropdown" placeholder="To" disabled>
            <label class="text-secondary" for="to-{{ $to_id }}">To</label>

            <div class="dropdown-menu dropdown-booking-destinamtion-width dropdown-md p-3">
                <div class="row mb-2 pb-2 pb-lg-0 to-{{ $type }}-{{ $form_type }}-selected">

                </div>
            </div>
            <input type="hidden" id="to-selected_{{ $type }}-{{ $form_type }}" name="to[]" value="">
        </div>
    </div>
    <div class="col-sm-3 col-md-3 px-0">
        @if($form_type == 'depart')
            <div class="form-floating mb-3">
                <input required type="text" name="date[]" class="form-control form-control-sm datepicker date-{{ $type }}-{{ $form_type }}-selected"
                    data-show-weeks="true"
                    data-today-highlight="true"
                    data-today-btn="true"
                    data-clear-btn="false"
                    data-autoclose="true"
                    data-date-start="today"
                    data-format="DD/MM/YYYY"
                    autocomplete="off"
                    placeholder="Travel Date">
                <label class="text-secondary">Travel Date</label>
            </div>
        @else
            <div class="form-floating mb-3">
                <input required autocomplete="off" type="text" name="date[]" class="form-control rangepicker"
                    data-bs-placement="left"
                    data-ranges="false"
                    data-disable-past-dates="true"
                    data-date-start="{{ date('d/m/Y', strtotime('+1 day')) }}"
                    data-date-end="{{ date('d/m/Y', strtotime('+2 day')) }}"
                    data-date-format="DD/MM/YYYY"
                    data-quick-locale='{
                        "lang_apply"	: "Apply",
                        "lang_cancel" : "Cancel",
                        "lang_crange" : "Custom Range",
                        "lang_months"	 : ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                        "lang_weekdays" : ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"]
                    }'
                    placeholder="Depart date - Return date">
                <label class="text-secondary">Depart date - Return date</label>
            </div>
        @endif
    </div>
    <div class="col-sm-3 col-md-3 px-0">
        <div class="form-floating mb-3 dropdown">
            <input required type="text" class="dropdown-toggle form-control" data-id="{{ $type }}{{ $form_type }}" id="pass-{{ $passenger_id }}" data-bs-toggle="dropdown" placeholder="Passenger">
            <label class="text-secondary" for="pass-{{ $passenger_id }}">Passenger</label>

            <div class="dropdown-menu dropdown-click-ignore dropdown-md p-3">
                <div class="row mb-2 pb-2 pb-lg-0 border-bottom">
                    <div class="col-md-6 mb-2 mb-lg-0 lh-1">
                        <p class="text-primary mb-0">Adult</p>
                        <small class="smaller">Above 12 year old</small>
                    </div>
                    <div class="col-4 col-md-2 p-0 text-end">
                        <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" data-type="adult" onClick="dec('{{ $type }}{{ $form_type }}_adult[]', this)"><i class="fi fi-minus smaller"></i></button>
                    </div>
                    <div class="col-4 col-md-2 p-0 text-center">
                        <input required type="number" class="border-0 text-center w-100" name="{{ $type }}{{ $form_type }}_adult[]" value="0">
                    </div>
                    <div class="col-4 col-md-2 p-0">
                        <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" data-type="adult" onClick="inc('{{ $type }}{{ $form_type }}_adult[]', this)"><i class="fi fi-plus smaller"></i></button>
                    </div>
                </div>

                <div class="row mb-2 pb-2 pb-lg-0 border-bottom">
                    <div class="col-md-6 mb-2 mb-lg-0 lh-1">
                        <p class="text-primary mb-0">Child</p>
                        <small class="smaller">2 - 12 year old</small>
                    </div>
                    <div class="col-4 col-md-2 p-0 text-end">
                        <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" data-type="child" onClick="dec('{{ $type }}{{ $form_type }}_child[]', this)"><i class="fi fi-minus smaller"></i></button>
                    </div>
                    <div class="col-4 col-md-2 p-0 text-center">
                        <input type="number" class="border-0 text-center w-100" name="{{ $type }}{{ $form_type }}_child[]" value="0">
                    </div>
                    <div class="col-4 col-md-2 p-0">
                        <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" data-type="child" data-inc="disabled" onClick="inc('{{ $type }}{{ $form_type }}_child[]', this)" disabled><i class="fi fi-plus smaller"></i></button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-2 pb-2 pb-lg-0 mb-lg-0 lh-1">
                        <p class="text-primary mb-0">Infant</p>
                        <small class="smaller">Below 2 year old</small>
                    </div>
                    <div class="col-4 col-md-2 p-0 text-end">
                        <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" data-type="infant" onClick="dec('{{ $type }}{{ $form_type }}_infant[]', this)"><i class="fi fi-minus smaller"></i></button>
                    </div>
                    <div class="col-4 col-md-2 p-0 text-center">
                        <input type="number" class="border-0 text-center w-100" name="{{ $type }}{{ $form_type }}_infant[]" value="0">
                    </div>
                    <div class="col-4 col-md-2 p-0">
                        <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" data-type="infant" data-inc="disabled" onClick="inc('{{ $type }}{{ $form_type }}_infant[]', this)" disabled><i class="fi fi-plus smaller"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
