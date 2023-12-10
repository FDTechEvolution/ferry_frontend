<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
	<head>
		@include('includes.head')
	</head>
    <body>
		<div id="wrapper">
			<!-- Header -->
			<header id="header" class="shadow-xs">
				<!-- Navbar -->
                @include('includes.navbar')
                <!-- /Navbar -->
            </header>
            <!-- /Header -->

            <!-- COVER -->
            @yield('cover-content')
			<!-- /COVER -->

            <div class="section pb-2 pt-5">
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