<div class="section" style="padding: 0px;">
    <div class="row">
        <div class="col-12" data-aos="fade-up" data-aos-delay="0">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <h2 class="text-main-color-2 text-start d-flex align-items-end"><img src="{{ asset('icons/blog_icon.png') }}" width="50"> Look what's news!</h2>
                </div>
                <div class="col-12 col-lg-6 d-flex justify-content-end align-items-end pt-2">
                    <a href="{{ route('blog-index') }}" class="fw-bold text-main-color pb-2">More</a>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-12">
            <div class="row" data-aos="fade-up" data-aos-delay="150">
                <div class="flickity-preloader"
                    data-flickity='{ "autoPlay": false, "cellAlign": "left", "pageDots": false, "prevNextButtons": false, "contain": true, "rightToLeft": false }'>
                    @foreach ($slides as $index => $slide)
                        <a href="{{ route('blog-view', ['slug' => $slide['slug']]) }}" @class([
                                'col-12',
                                'col-lg-5' => $index == 0,
                                'col-lg-3' => $index >= 1,
                                'mb-4', 'me-4', 'text-dark'])
                            >
                            @if($index == 0)
                                <div class="card border-0 shadow-md shadow-3d-hover transition-all-ease-250 transition-hover-top h-100 position-relative">
                                    <div class="clearfix">
                                        <img class="img-fluid"
                                            src="{{ asset($store . $slide['image']['path'] . '/' . $slide['image']['name']) }}"
                                            alt="" style="border-radius: 15px">
                                    </div>
                                    <div class="card-body fw-light position-absolute slide-first-text">
                                        <div class="d-table">
                                            <div class="d-table-cell align-bottom text-left">

                                                <h2 class="h6 card-title" style="line-height: 1.4rem;">
                                                    <h5>{{ $slide['title'] }}</h5>
                                                    {!! Str::limit($slide['description'], 100) !!} <span class="text-main-color-2 fw-bold small">See More.</span>
                                                </h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="card border-0 shadow-md shadow-3d-hover transition-all-ease-250 transition-hover-top h-100 mb-2"
                                    style="background-color: transparent;"
                                >
                                    <div class="clearfix">
                                        <img class="img-fluid "
                                            src="{{ asset($store . $slide['image']['path'] . '/' . $slide['image']['name']) }}"
                                            alt="" style="border-radius: 15px;">
                                    </div>
                                </div>
                                <h2 class="h6 card-title">
                                    <h5 class="mb-2">{{ $slide['title'] }}</h5>
                                    {!! Str::limit($slide['description'], 60) !!} <span class="text-main-color-2 fw-bold small">See More.</span>
                                </h2>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>

<style>
@media only screen and (max-width: 768px) {
    .flickity-page-dots {
        width: 97%;
    }
}
</style>
