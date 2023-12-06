@props(['type' => '', 'station_from' => [], 'station_to' => []])

<form novalidate class="bs-validate" id="{{ $type }}-search-form" method="POST" action="{{ route('booking-multi') }}">
    @csrf
    <fieldset id="search-form">
        <input type="hidden" name="_type" value="{{ $type }}">
        <x-booking-search-form 
            :type="$type"
            :station_from="$station_from"
            :station_to="$station_to"
            :form_type="_('depart')"
        />
        <input type="hidden" class="from-0-input" name="from[]" value="">
        <input type="hidden" class="to-0-input" name="to[]" value="">
        <div class="row multi-search-form-row">
            <div class="col-12 multi-search-form-0 d-none">
                <x-booking-search-multi 
                    :number="1"
                />
                <input type="hidden" class="from-1-input" name="from[]" value="">
                <input type="hidden" class="to-1-input" name="to[]" value="">
                <input type="checkbox" class="d-none multi-check-0" name="check_form[]" value="1">
            </div>
            <div class="col-12 multi-search-form-1 d-none">
                <x-booking-search-multi 
                    :number="2"
                />
                <input type="hidden" class="from-2-input" name="from[]" value="">
                <input type="hidden" class="to-2-input" name="to[]" value="">
                <input type="checkbox" class="d-none multi-check-1" name="check_form[]" value="1">
            </div>
            <div class="col-12 multi-search-form-2 d-none">
                <x-booking-search-multi 
                    :number="3"
                />
                <input type="hidden" class="from-3-input" name="from[]" value="">
                <input type="hidden" class="to-3-input" name="to[]" value="">
                <input type="checkbox" class="d-none multi-check-2" name="check_form[]" value="1">
            </div>
            <div class="col-12 multi-search-form-3 d-none">
                <x-booking-search-multi 
                    :number="4"
                />
                <input type="hidden" class="from-4-input" name="from[]" value="">
                <input type="hidden" class="to-4-input" name="to[]" value="">
                <input type="checkbox" class="d-none multi-check-3" name="check_form[]" value="1">
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-end">
                <i class="fi fi-plus cursor-pointer me-3" id="add-another-trip" data-bs-toggle="tooltip" data-bs-placement="left" title="Add another trip."></i>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-6 text-start">
                <a href="javascript:void(0);" class="text-light add-promotioncode-{{ $type }} pt-2" onClick="addPromotionCode(this, '{{ $type }}')"><i class="fa-solid fa-tag fs-4 me-1"></i> Add Promotioncode</a>
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