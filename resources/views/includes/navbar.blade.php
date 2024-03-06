<div class="container-fluid px-0 position-relative header-style">

    <nav class="navbar navbar-expand-lg navbar-light justify-content-lg-between justify-content-md-inherit navbar-bg-color">

        <div class="align-items-start">

            <!-- mobile menu button : show -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation" style="border: none;">

                <img src="{{ asset('icons/tg-menu.png') }}" width="40">
            </button>

            <!-- navbar : brand (logo) -->
            @include('includes.logo')

        </div>

        <!-- Menu -->
        @include('includes.menu')


        <!-- OPTIONS -->

        <!-- /OPTIONS -->
    </nav>

</div>
<style>
    .navbar-toggler{
        height: 0px;
    }
</style>
