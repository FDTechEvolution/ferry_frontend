<div class="container-fluid px-0 position-relative header-style">

    <nav class="navbar navbar-expand-lg navbar-light justify-content-lg-between justify-content-md-inherit navbar-bg-color">

        <div class="align-items-start">

            <!-- mobile menu button : show -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
                <svg width="25" viewBox="0 0 20 20">
                    <path d="M 19.9876 1.998 L -0.0108 1.998 L -0.0108 -0.0019 L 19.9876 -0.0019 L 19.9876 1.998 Z"></path>
                    <path d="M 19.9876 7.9979 L -0.0108 7.9979 L -0.0108 5.9979 L 19.9876 5.9979 L 19.9876 7.9979 Z"></path>
                    <path d="M 19.9876 13.9977 L -0.0108 13.9977 L -0.0108 11.9978 L 19.9876 11.9978 L 19.9876 13.9977 Z"></path>
                    <path d="M 19.9876 19.9976 L -0.0108 19.9976 L -0.0108 17.9976 L 19.9876 17.9976 L 19.9876 19.9976 Z"></path>
                </svg>
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