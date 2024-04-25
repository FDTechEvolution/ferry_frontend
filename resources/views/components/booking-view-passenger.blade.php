@props(['customers' => []])

<div class="row mb-2" id="payment-passenger-detail">
    @foreach ($customers as $i => $p)
        <div class="col-12 mb-3">
            @if($i === 'ADULT')
                <div class="row">
                    <div class="col-12 col-lg-4 fw-bold">Adult</div>
                    <div class="col-12 col-lg-4 fw-bold">Date of birth</div>
                    <div class="col-12 col-lg-4 fw-bold">Email</div>
                </div>
                <div class="row">
                    @foreach($p as $cus)
                        <div class="col-12 col-lg-4">{{ $cus['name'] }}</div>
                        <div class="col-12 col-lg-4">{{ $cus['birth_day'] }}</div>
                        <div class="col-12 col-lg-4">{{ $cus['email'] }}</div>
                    @endforeach
                </div>
            @endif
            @if($i === 'CHILD')
                <div class="row">
                    <div class="col-12 col-lg-4 fw-bold">Child</div>
                    <div class="col-12 col-lg-4 fw-bold">Date of birth</div>
                </div>
                <div class="row">
                    @foreach($p as $cus)
                        <div class="col-12 col-lg-4">{{ $cus['name'] }}</div>
                        <div class="col-12 col-lg-4">{{ $cus['birth_day'] }}</div>
                    @endforeach
                </div>
            @endif
            @if($i === 'INFANT')
                <div class="row">
                    <div class="col-12 col-lg-4 fw-bold">Infant</div>
                    <div class="col-12 col-lg-4 fw-bold">Date of birth</div>
                </div>
                <div class="row">
                    @foreach($p as $cus)
                        <div class="col-12 col-lg-4">{{ $cus['name'] }}</div>
                        <div class="col-12 col-lg-4">{{ $cus['birth_day'] }}</div>
                    @endforeach
                </div>
            @endif
        </div>
    @endforeach
</div>
