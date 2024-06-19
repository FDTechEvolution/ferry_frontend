<div class="section pt-2 pb-2 pb-lg-6">
    <div class="row">
        <div class="col-12 mb-3 d-md-none">
            <div class="ratio ratio-16x9">
                <iframe class="embed-responsive-item" src="//player.vimeo.com/video/898274896?autoplay=1&loop=1&muted=1&sidedock=0&title=0" width="800" height="450" style="border-radius: 10px; box-shadow: 1px 4px 10px rgba(0, 0, 0, 0.7); background-color: #fff;"></iframe>
            </div>
        </div>
        <div class="col-12 col-lg-4 mb-4 position-relative d-none d-md-block">
            <div class="row position-absolute" style="width: 100%; z-index: 2;">
                <div class="col-12" data-aos="fade-up" data-aos-delay="150">
                    <div class="ratio ratio-16x9">
                        <iframe class="embed-responsive-item" src="//player.vimeo.com/video/898274896?autoplay=1&loop=1&muted=1&sidedock=0&title=0" width="800" height="450" style="border-radius: 10px; box-shadow: 1px 4px 10px rgba(0, 0, 0, 0.7); background-color: #fff;"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8 slide-desc-desktop position-relative">
            <div class="accordion" id="billboardContent">
                @php
                    $bb_index = count($billboards);
                @endphp
                @foreach ($billboards as $index => $item)
                    <div class="row">
                        @if($bb_index > 1)
                            <button
                                style="background-color: {{ $item['color'] }}; top: {{40 * $index}}px; margin-top: 10px;"
                                class="btn btn-link btn-sm btn-billboard btn-content-announce " type="button"
                                data-bs-toggle="collapse" data-bs-target="#billboard-content-{{ $index }}"
                                aria-expanded="true" aria-controls="billboard-content-{{ $index }}"
                            >

                            <img class="avatar avatar-xs icon-announce" style="margin-left: -13px; " src="{{asset($store.'/'.$item['icon'])}}" />

                            </button>
                        @endif
                        <div style="background-color: {{ $item['color'] }}; border-radius: 10px;" id="billboard-content-{{ $index }}" @class(['collapse', 'show' => $index == 0]) aria-labelledby="cleanHeadingOne" data-bs-parent="#billboardContent">
                            <div class="col-12 col-lg-10 offset-lg-1 py-3 text-center" data-aos="fade-up" data-aos-delay="0" style="min-height: 400px;">
                                <h2 class="blog-title">{{ $item['title'] }}</h2>

                                <span class="">
                                    {!! $item['description'] !!}
                                </span>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
            {{-- <div class="row">
                <div class="col-12 col-lg-10 offset-lg-1 py-3 text-center" data-aos="fade-up" data-aos-delay="0">
                    <h2>Welcome to Tigerline Ferry!</h2>

                    <p class="mb-0">Greetings to all over the world.</p>
                    <p class="mb-0">Since 2003, We are Thai operators leading out this Andaman Sea's Tourism Industry.
                    </p>
                    <p>Capturing the scenic on this land of plenty. Thought the beauty
                        of the emerald sea, full with discovery that form a wonderful landscape. Andaman Tropical
                        Archipelago never run out of excitement for you explore.</p>

                    <p>We provide variety of transportation, extraodinary scenic experience is waiting for you to long
                        for.
                        Your sea trips will be the best with
                        us as we aren't just an agency, but operators and travel connoisseurs.</p>

                    <p>We sell what we experienced and select only the best for you!</p>
                </div>
            </div> --}}

        </div>
    </div>
</div>

<style>
    .icon-shake {
        animation: shake 1s;
        animation-iteration-count: 1;
    }
    @keyframes shake {
        0% { transform: translate(1px, 1px) rotate(0deg) scaleX(-1); }
        10% { transform: translate(-1px, -2px) rotate(-1deg) scaleX(-1); }
        20% { transform: translate(-3px, 0px) rotate(1deg) scaleX(-1); }
        30% { transform: translate(3px, 2px) rotate(0deg) scaleX(-1); }
        40% { transform: translate(1px, -1px) rotate(1deg) scaleX(-1); }
        50% { transform: translate(-1px, 2px) rotate(-1deg) scaleX(-1); }
        60% { transform: translate(-3px, 1px) rotate(0deg) scaleX(-1); }
        70% { transform: translate(3px, 1px) rotate(-1deg) scaleX(-1); }
        80% { transform: translate(-1px, -1px) rotate(1deg) scaleX(-1); }
        90% { transform: translate(1px, 2px) rotate(0deg) scaleX(-1); }
        100% { transform: translate(1px, -2px) rotate(-1deg) scaleX(-1); }
    }
</style>
