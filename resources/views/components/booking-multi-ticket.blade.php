@props(['type' => '', 'station_to' => [], 'section_from' => []])

<form novalidate class="bs-validate" id="{{ $type }}-search-form" method="POST" action="{{ route('booking-multi') }}">
    @csrf
    <fieldset id="search-form">
        <input type="hidden" name="_type" value="{{ $type }}">
        <x-booking-search-form
            :type="$type"
            :station_to="$station_to"
            :form_type="_('depart')"
            :section_from="$section_from"
        />
        <!-- <input type="hidden" class="from-0-input" name="from[]" value="">
        <input type="hidden" class="to-0-input" name="to[]" value=""> -->
        <input type="hidden" class="date-0-input" name="date[]" value="">
        <div class="row multi-search-form-row">
            <div class="col-12 multi-search-form-0 d-none">
                <x-booking-search-multi
                    :number="1"
                />
                <input type="checkbox" class="d-none multi-check-0" name="check_form[]" value="1">
            </div>
            <div class="col-12 multi-search-form-1 d-none">
                <x-booking-search-multi
                    :number="2"
                />
                <input type="checkbox" class="d-none multi-check-1" name="check_form[]" value="1">
            </div>
            <div class="col-12 multi-search-form-2 d-none">
                <x-booking-search-multi
                    :number="3"
                />
                <input type="checkbox" class="d-none multi-check-2" name="check_form[]" value="1">
            </div>
            <div class="col-12 multi-search-form-3 d-none">
                <x-booking-search-multi
                    :number="4"
                />
                <input type="checkbox" class="d-none multi-check-3" name="check_form[]" value="1">
            </div>
            <div class="col-12 multi-search-form-4 d-none">
                <x-booking-search-multi
                    :number="5"
                />
                <input type="checkbox" class="d-none multi-check-4" name="check_form[]" value="1">
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-3 offset-md-6 offset-lg-9 text-end">
                <div class="d-flex justify-content-between" id="add-another-trip">
                    <p class="mb-0 me-3">Add Another Trip</p>
                    <i class="fi fi-plus cursor-pointer me-3" data-bs-toggle="tooltip" data-bs-placement="top" title="Add another trip."></i>
                </div>
            </div>
        </div>
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
