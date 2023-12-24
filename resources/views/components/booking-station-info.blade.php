@props(['station_line' => [], 'station' => '', 'type' => ''])

@php
    $modal_id = uniqid();
@endphp

<i class="fi fi-round-info-full cursor-pointer icon-booking-color" title="Station info." data-bs-toggle="modal" data-bs-target="#m_{{ $modal_id }}"></i>

<div class="modal fade" id="m_{{ $modal_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLg" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabelLg">{{ $station }}</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<div class="modal-body">
                @if(!empty($station_line))
                    @foreach($station_line as $line)
                        @if($line['pivot']['type'] == $type)
                            {!! $line['text'] !!}
                        @endif
                    @endforeach
                @else
                    <p class="text-center">No station info.</p>
                @endif
			</div>
		</div>
	</div>
</div>