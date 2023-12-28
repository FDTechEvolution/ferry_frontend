<div class="section" style="padding: 0px;">
    <div class="row">
        <div class="col-12" data-aos="fade-up" data-aos-delay="0">
            <h2 class="text-main-color-2"><i class="fa-solid fa-plane-departure"></i> Hot Holiday Destinations</h2>
        </div>
        <div class="col-12">
            <div class="row" data-aos="fade-up" data-aos-delay="150">
                <div class="flickity-preloader"
                    data-flickity='{ "autoPlay": true, "cellAlign": "left", "pageDots": true, "prevNextButtons": true, "contain": true, "rightToLeft": false }'>

                    @foreach ($slides as $slide)
                        <div class="col-12 col-lg-3 mb-4 me-4">
                            <div
                                class="card border-0 shadow-md shadow-3d-hover transition-all-ease-250 transition-hover-top h-100">
                                <div class="clearfix">
                                    <img class="img-fluid "
                                        src="{{ asset($store . $slide['image']['path'] . '/' . $slide['image']['name']) }}"
                                        alt="" style="border-radius: 15px 15px 0px 0px;">
                                </div>
                                <div class="card-body fw-light"
                                    style="border-radius: 0px 0px 15px 15px;color:#181818;background-color: #BDBDBD;">
                                    <div class="d-table">
                                        <div class="d-table-cell align-bottom text-center">

                                            <h2 class="h5 card-title">
                                                {{ Str::limit($slide['description'], 65) }}
                                            </h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
