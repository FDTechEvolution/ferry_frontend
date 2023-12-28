<div class="section pt-4 pb-4 pb-lg-6">
    <div class="row">
        <div class="col-12">
            <h2 class="text-main-color-2"><i class="fa-solid fa-fire"></i> Trending</h2>
        </div>
        <div class="col-12 col-lg-4 mb-4">
            <div class="row">
                <div class="col-12">
                    <div class="swiper-container swiper-preloader swiper-btn-group swiper-btn-group-end text-white"
                        data-swiper='{
                            "slidesPerView": 1,
                            "spaceBetween": 0,
                            "autoplay": true,
                            "loop": true,
                            "pagination": { "type": "progressbar" }
                        }'
                        style="border-radius: 10px; box-shadow: 1px 4px 10px rgba(0, 0, 0, 0.7)">

                        <div class="swiper-wrapper" style="height:230px;">

                            @foreach ($slides as $slide)
                                <div class="swiper-slide h-100 d-middle bg-white overlay-dark overlay-opacity-1 bg-cover"
                                    style="background:url({{ asset($store . $slide['image']['path'] . '/' . $slide['image']['name']) }}); 
                                            background-position: bottom center !important;">
                                </div>
                            @endforeach

                        </div>

                        <!-- Add Arrows -->
                        <div class="home-tranding swiper-button-next swiper-button-white d-none"></div>
                        <div class="home-tranding swiper-button-prev swiper-button-white d-none"></div>

                        <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8 px-2 px-lg-6 d-flex justify-content-center align-items-center slide-desc-desktop">
            <div class="swiper-container swiper-preloader swiper-btn-group swiper-btn-group-end"
                data-swiper='{
                    "slidesPerView": 1,
                    "spaceBetween": 0,
                    "autoplay": true,
                    "loop": true,
                }'>

                <div class="swiper-wrapper">
                    @foreach ($slides as $slide)
                        <div class="swiper-slide d-middle" style="flex-wrap: wrap; align-content: center;">
                            <div class="slide-description font-proxima">
                                <p class="text-center slide-desc-mobile fs-5">{{ $slide['description'] }}</p>
                                <a href="#" class="btn btm-sm float-end w-25 py-2 fw-bold text-light"
                                    style="background-color: #426f95;">View</a>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
</div>
