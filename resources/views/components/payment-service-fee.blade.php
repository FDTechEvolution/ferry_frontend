@props(['fee_total' => ''])

@if($fee_total > 0)
    <small class="d-block mt-minus-creditfee" style="margin-top: -5px;">Service+Processing fee <span class="cc-fee">{{ number_format($fee_total, 2) }}</span>฿</small>
@endif
