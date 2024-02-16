@extends('layouts.default')

@section('content')
<div class="row min-h-50vh">
    <div class="col-12">
        <h1>Blogs</h1>
            <div class="row mb-5">
                <div class="col-9">
                    <a href="{{ route('blog-view', ['slug' => $first_blog['slug']]) }}" target="_blank" class="text-dark">
                        <img src="{{ asset($store . $first_blog['image']['path'] . '/' . $first_blog['image']['name']) }}" class="w-100 rounded">

                        <h4 class="mb-0">{{ $first_blog['title'] }}</h4>
                    </a>
                </div>
                <div class="col-3">
                    <div class="row mb-4">
                        <div class="col-12">
                            <a href="{{ route('blog-view', ['slug' => $second_blog['slug']]) }}" target="_blank" class="text-dark">
                                <img src="{{ asset($store . $second_blog['image']['path'] . '/' . $second_blog['image']['name']) }}" class="w-100 rounded">

                                <h5 class="mb-0">{{ $second_blog['title'] }}</h5>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('blog-view', ['slug' => $third_blog['slug']]) }}" target="_blank" class="text-dark">
                                <img src="{{ asset($store . $third_blog['image']['path'] . '/' . $third_blog['image']['name']) }}" class="w-100 rounded">

                                <h5 class="mb-0">{{ $third_blog['title'] }}</h5>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($blog as $index => $item)
                    @if ($index >= 3)
                        <div class="col-4">
                            <a href="{{ route('blog-view', ['slug' => $item['slug']]) }}" target="_blank" class="text-dark">
                                <img src="{{ asset($store . $item['image']['path'] . '/' . $item['image']['name']) }}" class="w-100 rounded">

                                <h5 class="mb-0">{{ $item['title'] }}</h5>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@stop
