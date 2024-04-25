@props(['customers' => []])

<div class="row mb-2" id="payment-passenger-detail">
    @foreach ($customers as $i => $p)
        <div class="col-12 mb-3">
            @if($i === 'ADULT')
                <div class="row d-none d-lg-flex">
                    <div class="col-12 col-lg-4 fw-bold">Adult</div>
                    <div class="col-12 col-lg-4 fw-bold">Date of birth</div>
                    <div class="col-12 col-lg-4 fw-bold">Email</div>
                </div>
                <div class="row border-bottom-route-mobile">
                    <strong class="d-block d-lg-none">Adult</strong>
                    @foreach($p as $i => $cus)
                        <div class="col-12 d-block d-lg-none"><small>{{ $i+1 }}.</small> {{ $cus['name'] }} | <small>DOB. {{ $cus['birth_day'] }} @if($cus['email'] != '') [{{ $cus['email'] }}]@endif</small></div>
                        <div class="col-12 col-lg-4 d-none d-lg-flex">{{ $cus['name'] }}</div>
                        <div class="col-12 col-lg-4 d-none d-lg-flex">{{ $cus['birth_day'] }}</div>
                        <div class="col-12 col-lg-4 d-none d-lg-flex">{{ $cus['email'] }}</div>
                    @endforeach
                </div>
            @endif
            @if($i === 'CHILD')
                <div class="row d-none d-lg-flex">
                    <div class="col-12 col-lg-4 fw-bold">Child</div>
                    <div class="col-12 col-lg-4 fw-bold">Date of birth</div>
                </div>
                <div class="row border-bottom-route-mobile">
                    <strong class="d-block d-lg-none">Child</strong>
                    @foreach($p as $i => $cus)
                        <div class="col-12 d-block d-lg-none"><small>{{ $i+1 }}.</small> {{ $cus['name'] }} | <small>DOB. {{ $cus['birth_day'] }}</small></div>
                        <div class="col-12 col-lg-4 d-none d-lg-flex">{{ $cus['name'] }}</div>
                        <div class="col-12 col-lg-4 d-none d-lg-flex">{{ $cus['birth_day'] }}</div>
                    @endforeach
                </div>
            @endif
            @if($i === 'INFANT')
                <div class="row d-none d-lg-flex">
                    <div class="col-12 col-lg-4 fw-bold">Infant</div>
                    <div class="col-12 col-lg-4 fw-bold">Date of birth</div>
                </div>
                <div class="row border-bottom-route-mobile">
                    <strong class="d-block d-lg-none">Infant</strong>
                    @foreach($p as $i => $cus)
                        <div class="col-12 d-block d-lg-none"><small>{{ $i+1 }}.</small> {{ $cus['name'] }} | <small>DOB. {{ $cus['birth_day'] }}</small></div>
                        <div class="col-12 col-lg-4 d-none d-lg-flex">{{ $cus['name'] }}</div>
                        <div class="col-12 col-lg-4 d-none d-lg-flex">{{ $cus['birth_day'] }}</div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>
