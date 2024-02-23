@props(['s_info' => '', 'm_info' => '', 'i_info' => '', 'station' => '', 'image' => '', 'store' => '', 'lat' =>'' , 'long' => ''])

@php
    $modal_id = 'm_'.uniqid();
@endphp

<i class="fi fi-round-info-full cursor-pointer icon-booking-color" title="Station info." data-bs-toggle="modal" data-bs-target="#{{ $modal_id }}" onClick="updateMap(`{{ $modal_id }}`, `{{ $lat }}`, `{{ $long }}`)"></i>

<div class="modal fade" id="{{ $modal_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLg" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabelLg">{{ $station }}</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<div class="modal-body">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="p-3 border rounded">
                            @if($image != '')
                                <img class="w-100" src="{{ $store.'/'.$image }}">
                            @endif
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        @if($s_info == 'Y')
                            {!! $m_info !!}
                        @else
                            {!! $i_info !!}
                        @endif
                    </div>
                    <div class="col-12" id="map_{{ $modal_id }}">
                        <div id="s_{{ $modal_id }}" class="mb-3 w-100" style="height: 400px;"></div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>

<script>
    function updateMap(modal_id, lat, long) {
        if(lat !== '' && long !== '') {
            if(map) {
                map.off()
                map.remove()
            }

            var map = L.map(`s_${modal_id}`).setView([lat, long], 17)
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                        }).addTo(map)
            L.marker([lat, long]).addTo(map)

            setTimeout(function() {
                map.invalidateSize()
            }, 500)
        }
    }
</script>
