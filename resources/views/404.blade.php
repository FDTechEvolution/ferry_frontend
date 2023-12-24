@extends('layouts.default')

@section('content')
<div class="row min-h-50vh mb-6">
    <div class="col-12 d-flex justify-content-center align-items-center">
        <div class="row not-found-content">
            <div class="col-12 text-center">
                <h1 class="text-main-color-2" style="font-size: 10em; text-shadow: 10px 10px 16px #2f2e33;">404</h1>
                <h1 style="font-size: 6em;">Sorry</h1>
                <h1 class="mb-6">"
                    @if($msg != '')
                        {{ $msg }}
                    @else
                        Not found your request.
                    @endif
                "</h1>
                <a href="{{ route('home') }}" class="btn btn-sm button-orange-bg">Back to home</a>
            </div>
        </div>
    </div>
</div>
@stop