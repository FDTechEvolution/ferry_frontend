@props(['type' => '', 'stations' => []])

@php
    $from_id = uniqid();
    $to_id = uniqid();
    $date_id = uniqid();
    $passenger_id = uniqid();
@endphp


<form novalidate class="bs-validate" id="{{ $type }}-search-form" method="POST" action="{{ route('booking-search') }}">
    @csrf
    <fieldset id="search-form">
        <input type="hidden" name="_type" value="{{ $type }}">
        <div class="row px-3">
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
                        data-format="DD/MM/YYYY">
                    <label>Travel Date</label>
                </div>
            </div>
            <div class="col-sm-3 col-md-3 px-0">
                <div class="form-floating mb-3 dropdown">
                    <input required type="text" class="dropdown-toggle form-control" data-id="{{ $type }}" id="pass-{{ $passenger_id }}" data-bs-toggle="dropdown">
                    <label for="pass-{{ $passenger_id }}">Passenger</label>
                
                    <div class="dropdown-menu dropdown-click-ignore dropdown-md p-3">
                        <div class="row mb-2 border-bottom">
                            <div class="col-md-6 lh-1">
                                <p class="text-primary mb-0">Adult</p>
                                <small class="smaller">Above 12 year old</small>
                            </div>
                            <div class="col-md-2 p-0 text-end">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" onClick="dec('{{ $type }}_adult')"><i class="fi fi-minus smaller"></i></button>
                            </div>
                            <div class="col-md-2 p-0 text-center">
                                <input type="number" class="border-0 text-center w-100" name="{{ $type }}_adult" value="0">
                            </div>
                            <div class="col-md-2 p-0">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" onClick="inc('{{ $type }}_adult')"><i class="fi fi-plus smaller"></i></button>
                            </div>
                        </div>

                        <div class="row mb-2 border-bottom">
                            <div class="col-md-6 lh-1">
                                <p class="text-primary mb-0">Child</p>
                                <small class="smaller">2 - 12 year old</small>
                            </div>
                            <div class="col-md-2 p-0 text-end">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" onClick="dec('{{ $type }}_child')"><i class="fi fi-minus smaller"></i></button>
                            </div>
                            <div class="col-md-2 p-0 text-center">
                                <input type="number" class="border-0 text-center w-100" name="{{ $type }}_child" value="0">
                            </div>
                            <div class="col-md-2 p-0">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" onClick="inc('{{ $type }}_child')"><i class="fi fi-plus smaller"></i></button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 lh-1">
                                <p class="text-primary mb-0">Infant</p>
                                <small class="smaller">Below 2 year old</small>
                            </div>
                            <div class="col-md-2 p-0 text-end">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" onClick="dec('{{ $type }}_infant')"><i class="fi fi-minus smaller"></i></button>
                            </div>
                            <div class="col-md-2 p-0 text-center">
                                <input type="number" class="border-0 text-center w-100" name="{{ $type }}_infant" value="0">
                            </div>
                            <div class="col-md-2 p-0">
                                <button type="button" class="btn btn-primary rounded-circle btn-sm p-2" onClick="inc('{{ $type }}_infant')"><i class="fi fi-plus smaller"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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