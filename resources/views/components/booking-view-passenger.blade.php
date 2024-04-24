@props(['customers' => []])

<div class="row mb-2" id="payment-passenger-detail">
    @foreach ($customers as $i => $p)
        @if($i === 'ADULT')
            <div class="col-12 col-lg-4 fw-bold">Adult</div>
            <div class="col-12 col-lg-4 fw-bold">Date of birth</div>
            <div class="col-12 col-lg-4 fw-bold">Email</div>
            @foreach($p as $cus)
                <div class="col-12 col-lg-4">{{ $cus['name'] }}</div>
                <div class="col-12 col-lg-4">{{ date_format(date_create($cus['birth_day']), 'd/m/Y') }}</div>
                <div class="col-12 col-lg-4">{{ $cus['email'] }}</div>
            @endforeach
        @endif
        @if($i === 'CHILD')
            <div class="col-12 col-lg-4 fw-bold">Child</div>
            <div class="col-12 col-lg-4 fw-bold">Date of birth</div>
            @foreach($p as $cus)
                <div class="col-12 col-lg-4">{{ $cus['name'] }}</div>
                <div class="col-12 col-lg-4">{{ date_format(date_create($cus['birth_day']), 'd/m/Y') }}</div>
            @endforeach
        @endif
        @if($i === 'INFANT')
            <div class="col-12 col-lg-4 fw-bold">Infant</div>
            <div class="col-12 col-lg-4 fw-bold">Date of birth</div>
            @foreach($p as $cus)
                <div class="col-12 col-lg-4">{{ $cus['name'] }}</div>
                <div class="col-12 col-lg-4">{{ date_format(date_create($cus['birth_day']), 'd/m/Y') }}</div>
            @endforeach
        @endif
    @endforeach
</div>
