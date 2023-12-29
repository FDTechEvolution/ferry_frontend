<div class="section" style="padding: 0px; z-index: -1;">
    <div class="row d-none d-md-block">
        <div class="col-12">
            <div class="d-inline-block bg-light shadow-primary-xs rounded w-100">
            <div class="row p-2 pt-3"data-aos="fade-up" data-aos-delay="0">

                @foreach ($promotions as $index => $promotion)
                    
                    <div style="width: 20%;">
                    <div class="col-12 ">
                        <a href="{{ route('promo-view', ['promocode' => $promotion['code']]) }}" target="_blank">
                            <div
                                class="card border-0 shadow-md shadow-3d-hover transition-all-ease-250 transition-hover-top h-100">

                                <div class="card-body fw-light"
                                    style="height: 250px;border-radius: 10px 10px 10px 10px;color:#181818;background-color: {{ $promotion['bg_color'] }};">
                                    <div class="d-table">
                                        <div class="d-table-cell align-middle text-center p-3">

                                            <h2 class="h5 font-proxima-400 card-title mb-4">
                                                {{ Str::limit($promotion['title'], 40) }}
                                            </h2>
                                            <h1 style="font-size: 2rem;">{{ $promotion['code'] }}</h1>
                                            <i class="fa-solid fa-barcode" style="font-size: 3rem;"></i> <i class="fa-solid fa-barcode" style="font-size: 3rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    </div>
                @endforeach
                <div class="col-12 text-end mt-2">
                    <a href="{{route('promo-index')}}" class="mt-2 text-main-color-2 fw-bold"><i class="fi fi-product-tag"></i> See
                        more</a>

                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="row d-md-none">
        <div class="col-12">
            <div class="d-inline-block bg-light shadow-primary-xs rounded w-100">
            <div class="row p-2 pt-3"data-aos="fade-up" data-aos-delay="0">

                @foreach ($promotions as $index => $promotion)
                    <div class="col-6">
                        <a href="{{ route('promo-view', ['promocode' => $promotion['code']]) }}" target="_blank">
                            <div
                                class="card border-0 shadow-md shadow-3d-hover transition-all-ease-250 transition-hover-top h-100">

                                <div class="card-body fw-light"
                                    style="height: 250px;border-radius: 10px 10px 10px 10px;color:#181818;background-color: {{ $promotion['bg_color'] }};">
                                    <div class="d-table">
                                        <div class="d-table-cell align-middle text-center p-3">
                                            <h2 class="h5 font-proxima-400 card-title mb-4">
                                                {{ Str::limit($promotion['title'], 40) }}
                                            </h2>
                                            <h1 style="font-size: 1.7rem;">{{ $promotion['code'] }}</h1>
                                            <i class="fa-solid fa-barcode" style="font-size: 3rem;"></i> <i class="fa-solid fa-barcode" style="font-size: 3rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
                <div class="col-12 text-end mt-2">
                    <a href="{{route('promo-index')}}" class="mt-2 text-main-color-2 fw-bold"><i class="fi fi-product-tag"></i> See
                        more</a>

                </div>
            </div>
        </div>
        </div>
    </div>

</div>
