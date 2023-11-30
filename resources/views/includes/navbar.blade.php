<div class="container position-relative">

    <nav class="navbar navbar-expand-lg navbar-light justify-content-lg-between justify-content-md-inherit">

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
        <ul class="list-inline list-unstyled mb-0 d-flex align-items-end">
            <li class="list-inline-item mx-1 dropdown text-center">
                <!-- <a href="#" aria-label="Account Sign In" class="js-ajax-modal btn btn-sm btn-light btn-pill"
                    data-href="_ajax/modal_signin.html"
                        data-ajax-modal-size="modal-md"
                        data-ajax-modal-centered="true"
                        data-ajax-modal-backdrop="static">
                    <span>Login</span>
                    <span class="group-icon">
                        <i class="fi fi-user-male"></i>
                        <i class="fi fi-close"></i>
                    </span> 
                </a> -->

                <p class="mb-0 smaller">Contact Us: +66123456789</p>

            </li>

        </ul>
        <!-- /OPTIONS -->
    </nav>

</div>