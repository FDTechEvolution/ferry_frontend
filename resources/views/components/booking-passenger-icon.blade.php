@props(['passenger' => []])

<span class="person-adult-icon"><i class="fa-solid fa-person fs-2"></i> {{ $passenger[0] }}</span>
<span class="person-child-icon"><img src="{{asset('icons/child.png')}}" width="26px" alt="" style="margin-top: -10px;"> {{ $passenger[1] }}</span>
<span class="person-infant-icon"><i class="fa-solid fa-baby fs-5"></i> {{ $passenger[2] }}</span>
