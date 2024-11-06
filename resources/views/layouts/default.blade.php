<!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
    @include('includes.head')
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-11355587433"></script>
    <script>
        window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-11355587433');
    </script>

    @yield('script_head')

</head>


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
    <script src="{{ asset('assets/js/app/app.js') }}?v=@php echo date('YmdHis'); @endphp"></script>
    @yield('script')
</body>

</html>