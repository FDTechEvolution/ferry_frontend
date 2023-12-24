<div class="section" style="padding: 0px;">
 
        <div class="row p-2 pt-3 bg-light" style="border-radius: 10px;">
            <div class="col-12 d-none">
                <h2 class="text-main-color-2"><i class="fi fi-product-tag"></i> Offers and Promotions</h2>
            </div>
            <div class="flickity-preloader px-1"
                data-flickity='{ "autoPlay": true, "cellAlign": "left", "pageDots": false, "prevNextButtons": true, "contain": true, "rightToLeft": false }'>

                @foreach($promotions as $promotion)
                    <div class="col-12 col-lg-3 mb-0 me-2">
                        <div
                            class="card border-0 shadow-md shadow-3d-hover transition-all-ease-250 transition-hover-top h-100">
   
                            <div class="card-body fw-light" style="height: 250px;border-radius: 10px 10px 10px 10px;color:#181818;background-color: {{ $promotion['bg_color']}};">
                                <div class="d-table">
                                    <div class="d-table-cell align-middle text-center p-3">
                                    
                                        <h2 class="h5 font-proxima-400 card-title mb-4">
                                            {{ $promotion['title'] }}
                                        </h2>
                                        <h1>{{$promotion['code']}}</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <a href="#" class="text-end mt-2 text-main-color-2 fw-bold"><i class="fi fi-product-tag"></i> See more</a>
        </div>
    
</div>