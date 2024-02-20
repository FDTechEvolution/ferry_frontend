@props(['passenger' => [], 'p_adult' => '', 'p_child' => '', 'p_infant' => '', 'type' => '', 'index' => ''])

@if($passenger[0] > 0)
    <p class="mb-0 small">
        <i class="fa-solid fa-person fs-5 me-1"></i> <span class="smaller">{{ $passenger[0] }} x <span class="adult-per-price-{{ $type }}-{{ $index }}">{{ number_format($p_adult / $passenger[0]) }}</span></span>
    </p>
@endif
@if($passenger[1] > 0)
    <p class="mb-0 small">
        <img src="{{asset('icons/child.png')}}" width="18px" alt="" style="filter: invert(1); margin-top: -5px;"> <span class="smaller">{{ $passenger[1] }} x <span class="child-per-price-{{ $type }}-{{ $index }}">{{ number_format($p_child / $passenger[1]) }}</span></span>
    </p>
@endif
@if($passenger[2] > 0)
    <p class="mb-0 small">
        <i class="fa-solid fa-baby fs-6 me-1"></i> <span class="smaller">{{ $passenger[2] }} x <span class="infant-per-price-{{ $type }}-{{ $index }}">{{ number_format($p_infant / $passenger[2]) }}</span></span>
    </p>
@endif
