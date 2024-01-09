@props(['icons' => [], 'icon_url' => ''])

@foreach($icons as $icon)
<div class="mw--48">
    <img src="{{ $icon_url }}{{ $icon['path'] }}" class="me-1 w-100 icon-selected">
</div>
@endforeach
