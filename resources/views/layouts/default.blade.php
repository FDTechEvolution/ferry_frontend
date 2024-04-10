<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		@include('includes.head')
        <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-PT752T46');</script>
<!-- End Google Tag Manager -->

	</head>
    <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PT752T46"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
    <body>
		<div id="wrapper">
			<!-- Header -->
			<header id="header" class="shadow-xs ">
				<!-- Navbar -->
                @include('includes.navbar')
                <!-- /Navbar -->
            </header>
            <!-- /Header -->

            <!-- COVER -->
            @yield('cover-content')
			<!-- /COVER -->

            <div class="section pb-2 pt-2 pt-lg-5 section-main">
				<div class="container">
                    @yield('content')
                </div>
            </div>

            @yield('section-content')
        </div>

        <!-- Footer -->
        @include('includes.footer')
        <!-- /Footer -->

        <script src="{{ asset('assets/js/core.min.js') }}"></script>
        <script src="{{ asset('assets/js/app/app.js') }}"></script>
        @yield('script')
    </body>
</html>
