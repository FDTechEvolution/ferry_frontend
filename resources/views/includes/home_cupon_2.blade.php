<div class="section home-cupon-mobile" style="padding: 0px; z-index: -1;">

        <div class="row p-2 pt-3 bg-light" style="border-radius: 10px;" data-aos="fade-up" data-aos-delay="0">
            <div class="col-12 d-none">
                <h2 class="text-main-color-2"><i class="fi fi-product-tag"></i> Offers and Promotions</h2>
            </div>
            <div class="flickity-preloader px-1"
                data-flickity='{ "autoPlay": true, "cellAlign": "left", "pageDots": false, "prevNextButtons": true, "contain": true, "rightToLeft": false }'>

                @foreach($promotions as $promotion)
                    <div class="col-6 col-lg-3 mb-0 me-2">
                        <a href="{{ route('promo-index') }}" target="_blank">
                            <div class="card border-0 shadow-md shadow-3d-hover transition-all-ease-250 transition-hover-top h-100">

                                <div class="card-body fw-light" style="height: 250px;border-radius: 10px 10px 10px 10px;color:#181818;background-color: {{ $promotion['bg_color']}};">
                                    <div class="d-table">
                                        <div class="d-table-cell align-middle text-center p-3">

                                            <h2 class="h5 font-proxima-400 card-title mb-4">
                                                {{ $promotion['title'] }}
                                            </h2>
                                            <h1>{{$promotion['code']}}</h1>
                                            <i class="fa-solid fa-barcode" style="font-size: 3rem;"></i>
                                            <i class="fa-solid fa-barcode" style="font-size: 3rem;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('promo-index') }}" class="text-end mt-2 text-main-color-2 fw-bold"><i class="fa-solid fa-tag"></i> Promotions Code</a>
        </div>

</div>
