@props(['passenger_num' => '', 'type' => '', 'color'])

@php
    $title = uniqid();
    $first_name = uniqid();
    $last_name = uniqid();
@endphp

<div class="row mt-2 mb-5 border-radius-10 border border-{{ $color }} normal-passenger">
    <div class="col-12 py-3 bg-{{ $color }}" style="border-radius: 10px 10px 0 0;">
        Passenger {{ $passenger_num }}
    </div>
    <div class="col-12 mt-3">
        <div class="row">
            <div class="col-12 col-lg-2 form-floating mb-3">
                <select required name="title[]" class="form-select form-select-sm" id="passenger-title-{{ $title }}" aria-label="Floating label select example">
                    <option value="" selected disabled>Select Title</option>
                    <option value="mr">Mr.</option>
                    <option value="mrs">Mrs.</option>
                    <option value="ms">Ms.</option>
                    <option value="other">Other</option>
                </select>
                <label for="passenger-title-{{ $title }}">Title<span class="text-danger">*</span></label>
            </div>
            <div class="col-12 col-lg-5 form-floating mb-3">
                <input required type="text" name="first_name[]" class="form-control form-control-sm" id="passenger-first-name-{{ $first_name }}" placeholder="First name & Middle name">
                <label for="passenger-first-name-{{ $first_name }}" class="ms-2">First name & Middle name<span class="text-danger">*</span></label>
            </div>
            <div class="col-12 col-lg-5 form-floating mb-3">
                <input required type="text" name="last_name[]" class="form-control form-control-sm" id="passenger-last-name-{{ $last_name }}" placeholder="Last name">
                <label for="passenger-last-name-{{ $last_name }}" class="ms-2">Last name<span class="text-danger">*</span></label>
            </div>
        </div>
        <div class="row">
            <div class="col-8 col-lg-7 form-floating mb-3">
                <input required type="text" name="birth_day[]" class="form-control form-control-sm datepicker sub-passenger-b-date"
                    data-show-weeks="true"
                    data-today-highlight="true"
                    data-today-btn="false"
                    data-clear-btn="false"
                    data-autoclose="true"
                    data-format="DD/MM/YYYY"
                    autocomplete="off"
                    placeholder="Date of Birth"
                    data-type="{{ $type }}">
                <label class="ms-2">Date of Birth<span class="text-danger">*</span></label>
            </div>
            <div class="col-4 col-lg-5 mb-3 d-flex align-items-center justify-content-center">
                @if($type == 'Adult')
                    <span class="me-2">{{ $type }}</span> <i class="fa-solid fa-person fs-1"></i>
                @elseif($type == 'Child')
                    <span class="me-2">{{ $type }}</span> <img src="{{asset('icons/child.png')}}" width="26px" alt="" style="filter: invert(1); margin-top: -5px;">
                @elseif($type == 'Infant')
                    <span class="me-2">{{ $type }}</span> <i class="fa-solid fa-baby fs-3"></i>
                @endif
            </div>
        </div>
        <input type="hidden" name="passenger_type[]" value="{{ $type }}">
    </div>
</div>
