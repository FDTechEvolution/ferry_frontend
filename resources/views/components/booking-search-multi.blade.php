@props(['number' => ''])

@php
    $from_id = uniqid();
    $to_id = uniqid();
    $date_id = uniqid();
    $passenger_id = uniqid();
    $action_id = uniqid();
@endphp

<div class="row px-3 is-type-multi">
    <input type="hidden" name="_from_type[]" value="multi">
    <div class="col-sm-3 col-md-3 px-0">
        <div class="form-floating mb-3">
            <select class="form-select form-select-sm from-{{ $number }}-selected" id="from-{{ $from_id }}" aria-label="booking station">
                <option value="" selected disabled>Select Original</option>
                
            </select>
            <label for="from-{{ $from_id }}">From</label>
        </div>
    </div>
    <div class="col-sm-3 col-md-3 px-0">
        <div class="form-floating mb-3">
            <select class="form-select form-select-sm to-{{ $number }}-selected" id="to-{{ $to_id }}" aria-label="booking station" onChange="updateToDataValue(this, '{{ $number }}')" disabled>
                <option value="" selected>Select Destination</option>
                
            </select>
            <label for="to-{{ $to_id }}">To</label>
        </div>
    </div>
    <div class="col-sm-3 col-md-3 px-0">
        <div class="form-floating mb-3">
            <input type="text" name="date[]" class="form-control form-control-sm datepicker date-{{ $number }}-selected"
                data-show-weeks="true"
                data-today-highlight="false"
                data-today-btn="true"
                data-clear-btn="false"
                data-autoclose="true"
                data-date-start="today"
                data-format="DD/MM/YYYY"
                autocomplete="off"
                placeholder="Travel Date">
            <label class="text-secondary">Travel Date</label>
        </div>
    </div>
    <div class="col-sm-3 col-md-3 px-3 d-flex justify-content-start align-items-center">
        @if($number < 4)
            <div class="is-action" id="a-{{ $action_id }}" style="margin-top: -16px;">
                <i class="fi fi-plus cursor-pointer me-3" data-bs-toggle="tooltip" data-bs-placement="left" title="Add another trip." onClick="addAmotherTrip('{{ $action_id }}', '{{ $number }}')"></i>
                <i class="fi fi-minus cursor-pointer me-3" data-bs-toggle="tooltip" data-bs-placement="left" title="Delete this trip." onClick="removeThisTrip('{{ $action_id }}', '{{ $number }}')"></i>
            </div>
        @elseif($number == 4)
            <div class="is-action" id="a-{{ $action_id }}" style="margin-top: -16px;">
                <i class="fi fi-minus cursor-pointer me-3" data-bs-toggle="tooltip" data-bs-placement="left" title="Delete this trip." onClick="removeThisTrip('{{ $action_id }}', '{{ $number }}')"></i>
            </div>
        @endif
    </div>
</div>