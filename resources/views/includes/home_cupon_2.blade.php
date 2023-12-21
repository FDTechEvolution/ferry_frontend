<div class="section" style="padding: 0px;">
 
        <div class="row">
            <div class="col-12">
                <h2 class="text-main-color-2"><i class="fi fi-product-tag"></i> Offers and Promotions</h2>
            </div>
            <div class="flickity-preloader"
                data-flickity='{ "autoPlay": true, "cellAlign": "left", "pageDots": true, "prevNextButtons": true, "contain": true, "rightToLeft": false }'>

                @foreach($promotions as $promotion)
                    <div class="col-12 col-lg-3 mb-4 me-4">
                        <div
                            class="card border-0 shadow-md shadow-3d-hover transition-all-ease-250 transition-hover-top h-100">
   
                            <div class="card-body fw-light" style="border-radius: 15px 15px 15px 15px;color:#181818;background-color: {{ $promotion['bg_color']}};">
                                <div class="d-table">
                                    <div class="d-table-cell align-bottom text-center p-3">
                                    
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
        </div>
    
</div>