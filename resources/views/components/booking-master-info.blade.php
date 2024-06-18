@props(['s_info' => '', 'm_info' => '', 'i_info' => '', 'station' => '', 'image' => [], 'store' => '', 'lat_long' => []])

@php
    $modal_id = 'm_'.uniqid();
    $lat = !empty($lat_long) ? $lat_long[0] : '';
    $long = !empty($lat_long) ? $lat_long[1] : '';
    $img = !empty($image) ? $image['path'] : '';
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
                        @if($img != '')
                            <div class="p-3 border rounded">
                                <img class="w-100" src="{{ $store.'/'.$img }}">
                            </div>
                        @endif
                    </div>
                    <div class="col-12 mb-4">
                        @if($s_info == 'Y')
                            {!! $m_info !!}
                        @else
                            {!! $i_info !!}
                        @endif
                    </div>
                    <div class="col-12" id="map_{{ $modal_id }}">
                        @if($lat != '' || $long != '')
                            <div id="s_{{ $modal_id }}" class="mb-3 w-100" style="height: 400px;"></div>
                        @endif
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
