<footer id="footer" class="text-dark">

    <!-- footer cta -->
    <div class="container text-dark pt-5 pb-2">

        <div class="row g-4 align-items-center">
            @yield('footer-logo')
            <div class="col-lg-12 pt-2 pb-4 text-center font-proxima">
                <p class="text-main-color-2 mb-0 link-on-mobile">
                    {{-- <a class="text-main-color-2" href="{{ route('review-index') }}">Review</a> |
                    <a class="text-main-color-2" href="{{ route('station-index') }}">Station</a> |
                    <a class="text-main-color-2" href="{{ route('news-index') }}">News</a> | --}}
                    <a class="text-main-color-2" href="{{ route('term-index', ['type' => 'TERM']) }}">Terms & Conditions</a> |
                    <a class="text-main-color-2" href="{{ route('term-index', ['type' => 'BAGGAGE_POLICY']) }}">Baggage Policy</a> |
                    <a class="text-main-color-2" href="{{ route('term-index', ['type' => 'TERMS_OF_SERVICE']) }}">Terms of Service</a> |
                    <a class="text-main-color-2" href="{{ route('term-index', ['type' => 'PRIVACY_POLICY']) }}">Privacy Policy</a> |
                    <a class="text-main-color-2" href="{{ route('term-index', ['type' => 'Q&A']) }}">Q&A</a> |
                    <a class="text-main-color-2" href="{{ route('term-index', ['type' => 'PRIVATE_CHATER_BOAT']) }}">Private Chater Boat</a></p>
                <p class="text-main-color-2 mb-3 mb-lg-2 right-on-mobile">
                    Siri Lanta Company Limited. All Right Reserved.
                </p>

            </div>
        </div>

    </div>
    <!-- /footer cta -->

</footer>
