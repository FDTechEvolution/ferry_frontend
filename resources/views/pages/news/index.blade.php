@extends('layouts.default')

@section('content')
<div class="row min-h-50vh">
    <div class="col-12">
        <h1>News</h1>
        <div class="row">
            @foreach($news as $new)
                <div class="col-12 col-lg-4 mb-4">
                    <div class="card shadow-3d news-content bg-warning-light">
                        <div class="card-body">
                            <h4 class="mb-0">{{ $new['title'] }}</h4>
                            <p class="smaller mb-2">{{ date('M d, Y', strtotime($new['created_at'])) }}</p>
                            <span class="small text-overflow ellipsis">{!! $new['body'] !!}</span>
                            <a href="{{ route('news-view', ['id' => $new['id']]) }}" class="text-main-color-2 text-end mb-0 mt-2 d-block" target="_blank">Read more...</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@stop