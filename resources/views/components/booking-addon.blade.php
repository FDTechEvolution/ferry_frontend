@props(['route_addons' => [], 'route_index' => ''])

@foreach($route_addons as $index => $addon)
    <div class="row border-bottom route-addon-lists route-addon-index-{{ $route_index }}">
        @if($addon['subtype'] == 'from')
            <div class="col-12 col-lg-6">
                <h3>{{ $addon['name'] }}</h3>
                <span class="small">{{ $route_index }} - {{ $index }}</span><hr/>
                <span class="small">{{ $addon['route_id'] }}</span>
                <p>{!! $addon['message'] !!}</p>
            </div>
        @elseif($addon['subtype'] == 'to')
            <div class="col-12 col-lg-6">
                <h3>{{ $addon['name'] }}</h3>
                <span class="small">{{ $route_index }} - {{ $index }}</span><hr/>
                <span class="small">{{ $addon['route_id'] }}</span>
                <p>{!! $addon['message'] !!}</p>
            </div>
        @endif
    </div>
@endforeach

