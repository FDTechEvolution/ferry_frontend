@props(['type' => '', 'stations' => []])

@php
    $from_id = uniqid();
    $to_id = uniqid();
    $date_id = uniqid();
    $passenger_id = uniqid();
@endphp

<form novalidate class="bs-validate" id="{{ $type }}-search-form" method="POST" action="{{ route('booking-round-trip') }}">
    @csrf
    <fieldset id="search-form">
        <input type="hidden" name="_type" value="{{ $type }}">
        <p class="text-start text-light mb-0">Depart</p>
        <x-booking-search-form 
            :type="$type"
            :stations="$stations"
            :form_type="_('depart')"
        />

        <p class="text-start text-light mb-0">Return</p>
        <x-booking-search-form 
            :type="$type"
            :stations="$stations"
            :form_type="_('return')"
        />
        <div class="row mt-3">
            <div class="col-6 text-start">
                <a href="javascript:void(0);" class="text-light add-promotioncode-{{ $type }} pt-2" onClick="addPromotionCode(this, '{{ $type }}')">Add Promotioncode</a>
                <div class="div-promotioncode-{{ $type }} position-relative w-50 d-none">
                    <input type="hidden" class="form-control form-control-sm input-promotioncode-{{ $type }}" name="promotioncode">
                    <i class="fi fi-round-close text-dark cursor-pointer position-absolute top--9 end--9" onClick="clearPromotionCode('{{ $type }}')"></i>
                </div>
            </div>
            <div class="col-6 text-end">
                <button type="submit" class="btn btn-sm button-orange-bg">Search</button>
            </div>
        </div>
    </fieldset>
</form>

<style>
    .datepicker::placeholder {
        color: #000 !important;
        opacity: 1;
    }
    .datepicker::-ms-input-placeholder {
        color: #000 !important;
    }
    .btn.btn-sm.rounded-circle {
        height: 1.5rem;
        width: 1.5rem;
    }
    i.fi.fi-minus.smaller, i.fi.fi-plus.smaller {
        font-size: 0.7rem !important;
    }
</style>