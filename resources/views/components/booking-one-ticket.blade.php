@props(['type' => '', 'station_to' => [], 'section_from' => []])

<form novalidate class="bs-validate" id="{{ $type }}-search-form" method="POST" action="{{ route('booking-index') }}">
    @csrf
    <fieldset id="search-form">
        <input type="hidden" name="_type" value="{{ $type }}">
        <x-booking-search-form
            :type="$type"
            :station_to="$station_to"
            :form_type="_('depart')"
            :section_from="$section_from"
        />
        <div class="row mt-3">
            <div class="col-8 col-md-6 text-start">

                <div class="div-promotioncode-{{ $type }} position-relative promo-input-w">
                    <input type="text" class="form-control form-control-sm input-promotioncode-{{ $type }} text-main-color-2 w-100" name="promotioncode" placeholder="Promotion Code">
                    <i class="fi fi-round-close text-dark cursor-pointer position-absolute top--9 end--9" onClick="clearPromotionCode('{{ $type }}')"></i>
                </div>
            </div>
            <div class="col-8 col-md-6 text-end">
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
