@props(['type' => '', 'stations' => [], 'form_type' => ''])

@php
    $from_id = uniqid();
    $to_id = uniqid();
    $date_id = uniqid();
    $passenger_id = uniqid();
@endphp

<div class="row px-3">
    <input type="hidden" name="_from_type" value="{{ $form_type }}">
    <div class="col-sm-3 col-md-3 px-0">
        <div class="form-floating mb-3">
            <select required class="form-select form-select-sm" name="from" id="from-{{ $from_id }}" aria-label="booking station">
                <option value="" selected disabled>Select Original</option>
                @foreach($stations as $station)
                    <option value="{{ $station['id'] }}">{{ $station['name'] }} @if($station['piername'] != NULL) ({{$station['piername']}}) @endif</option>
                @endforeach
            </select>
            <label for="from-{{ $from_id }}">From</label>
        </div>
    </div>
    <div class="col-sm-3 col-md-3 px-0">
        <div class="form-floating mb-3">
            <select required class="form-select form-select-sm" name="to" id="to-{{ $to_id }}" aria-label="booking station">
                <option value="" selected disabled>Select Destination</option>
                @foreach((array)$stations as $station)
                    <option value="{{ $station['id'] }}">{{ $station['name'] }} @if($station['piername'] != NULL) ({{$station['piername']}}) @endif</option>
                @endforeach
            </select>
            <label for="to-{{ $to_id }}">To</label>
        </div>
    </div>
    <div class="col-sm-3 col-md-3 px-0">
        <div class="form-floating mb-3">
            <input required type="text" name="date" class="form-control form-control-sm datepicker"
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
    </div>
    <div class="col-sm-3 col-md-3 px-0">
        <div class="form-floating mb-3 dropdown">
            <input required type="text" class="dropdown-toggle form-control" data-id="{{ $type }}{{ $form_type }}" id="pass-{{ $passenger_id }}" data-bs-toggle="dropdown" placeholder="Passenger">
            <label class="text-secondary" for="pass-{{ $passenger_id }}">Passenger</label>
        
            <div class="dropdown-menu dropdown-click-ignore dropdown-md p-3">
                <div class="row mb-2 border-bottom">
                    <div class="col-md-6 lh-1">
                        <p class="text-primary mb-0">Adult</p>
                        <small class="smaller">Above 12 year old</small>
                    </div>
                    <div class="col-md-2 p-0 text-end">
                        <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" onClick="dec('{{ $type }}{{ $form_type }}_adult')"><i class="fi fi-minus smaller"></i></button>
                    </div>
                    <div class="col-md-2 p-0 text-center">
                        <input type="number" class="border-0 text-center w-100" name="{{ $type }}{{ $form_type }}_adult" value="0">
                    </div>
                    <div class="col-md-2 p-0">
                        <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" onClick="inc('{{ $type }}{{ $form_type }}_adult')"><i class="fi fi-plus smaller"></i></button>
                    </div>
                </div>

                <div class="row mb-2 border-bottom">
                    <div class="col-md-6 lh-1">
                        <p class="text-primary mb-0">Child</p>
                        <small class="smaller">2 - 12 year old</small>
                    </div>
                    <div class="col-md-2 p-0 text-end">
                        <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" onClick="dec('{{ $type }}{{ $form_type }}_child')"><i class="fi fi-minus smaller"></i></button>
                    </div>
                    <div class="col-md-2 p-0 text-center">
                        <input type="number" class="border-0 text-center w-100" name="{{ $type }}{{ $form_type }}_child" value="0">
                    </div>
                    <div class="col-md-2 p-0">
                        <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" onClick="inc('{{ $type }}{{ $form_type }}_child')"><i class="fi fi-plus smaller"></i></button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 lh-1">
                        <p class="text-primary mb-0">Infant</p>
                        <small class="smaller">Below 2 year old</small>
                    </div>
                    <div class="col-md-2 p-0 text-end">
                        <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" onClick="dec('{{ $type }}{{ $form_type }}_infant')"><i class="fi fi-minus smaller"></i></button>
                    </div>
                    <div class="col-md-2 p-0 text-center">
                        <input type="number" class="border-0 text-center w-100" name="{{ $type }}{{ $form_type }}_infant" value="0">
                    </div>
                    <div class="col-md-2 p-0">
                        <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" onClick="inc('{{ $type }}{{ $form_type }}_infant')"><i class="fi fi-plus smaller"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>