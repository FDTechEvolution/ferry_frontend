@props(['type' => '', 'text' => ''])

<button 
    type="{{ $type }}"
    {{ $attributes->merge(['class' => 'btn button-green-bg border-radius-10']) }} 

>
{{ $text }}
</button>