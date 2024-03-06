@props(['type' => '', 'station_to' => [], 'section_from' => []])

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
        <x-booking-search-form
            :type="$type"
            :station_to="$station_to"
            :form_type="_('return')"
            :section_from="$section_from"
        />
        <div class="row mt-3">
            <div class="col-6 text-start">
                <a href="javascript:void(0);" class="text-light add-promotioncode-{{ $type }} pt-2" onClick="addPromotionCode(this, '{{ $type }}')"><i class="fa-solid fa-tag fs-4 me-1"></i>Promotion Code</a>
                <div class="div-promotioncode-{{ $type }} position-relative promo-input-w d-none">
                    <input type="hidden" class="form-control form-control-sm input-promotioncode-{{ $type }} button-orange-bg" name="promotioncode">
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
