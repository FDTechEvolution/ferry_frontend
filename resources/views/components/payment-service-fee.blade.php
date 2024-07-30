@props(['fee_total' => '', 'isuse_pf' => '', 'isuse_sc' => ''])

@if($fee_total > 0)
    <small class="d-block mt-minus-creditfee" style="margin-top: -5px;">
        @if($isuse_sc == 'Y') Service @endif
        @if($isuse_sc == 'Y' && $isuse_pf == 'Y') + @endif
        @if($isuse_pf == 'Y') Processing @endif fee
        <span class="cc-fee">{{ number_format($fee_total, 2) }}</span>฿
    </small>
@endif
