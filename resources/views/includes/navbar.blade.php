<div class="container-fluid px-0 position-relative header-style">

    <nav class="navbar navbar-expand-lg navbar-light justify-content-lg-between justify-content-md-inherit navbar-bg-color">

        <div class="d-flex align-items-center display-menu-setting">

            <!-- navbar : brand (logo) -->
            @include('includes.logo')

            <!-- mobile menu button : show -->
            <button class="navbar-toggler ms-3 nav-bar-on-mobile" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation" style="border: none;">
                <i class="fa-solid fa-bars fs-1" style="color: #FFF;"></i>
            </button>
        </div>

        <!-- Menu -->
        @include('includes.menu')


        <!-- OPTIONS -->

        <!-- /OPTIONS -->
    </nav>

</div>
<style>
    .navbar-toggler{
        height: auto;
    }
</style>
