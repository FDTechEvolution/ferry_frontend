@props(['info' => '', 'station' => '', 'googlemap' => '', 'image' => '', 'store' => ''])

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
                @if($info)
                    <div class="row">
                        <div class="col-12 mb-4">
                            {!! $info !!}
                        </div>
                        <div class="col-12 text-center mb-3">
                            @if ($googlemap != '')
                                <a href="https://www.google.co.th/maps/dir//{{ $googlemap }}"
                                    target="_blank"><i class="fa-solid fa-location-dot"></i> Google Map.</a>
                            @endif
                        </div>
                        <div class="col-12">
                            <div class="p-3 border rounded">
                                <img class="w-100" src="{{ $store.'/'.$image }}">
                            </div>
                        </div>
                    </div>
                @else
                    <p class="text-center">No station info.</p>
                @endif
			</div>
		</div>
	</div>
</div>
