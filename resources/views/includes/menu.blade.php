<div class="collapse navbar-collapse navbar-animate-fadein" id="navbarMainNav">
    <!-- navbar : mobile menu -->
    <div class="navbar-xs d-none"><!-- .sticky-top -->

        <!-- mobile menu button : close -->
        <button class="navbar-toggler pt-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMainNav" aria-controls="navbarMainNav" aria-expanded="false" aria-label="Toggle navigation">
            <svg width="20" viewBox="0 0 20 20">
                <path d="M 20.7895 0.977 L 19.3752 -0.4364 L 10.081 8.8522 L 0.7869 -0.4364 L -0.6274 0.977 L 8.6668 10.2656 L -0.6274 19.5542 L 0.7869 20.9676 L 10.081 11.679 L 19.3752 20.9676 L 20.7895 19.5542 L 11.4953 10.2656 L 20.7895 0.977 Z"></path>
            </svg>
        </button>

        <!-- 
            Mobile Menu Logo 
            Logo : height: 70px max
        -->
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('assets/images/logo_tiger_line_ferry.png') }}" alt="...">
        </a>

    </div>
    <!-- /navbar : mobile menu -->



    <!-- navbar : navigation -->
    <ul class="navbar-nav" id="navbar-menu">

        <!-- booking -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                Booking
            </a>
        </li>

        <!-- viw booking -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('timetable-index') }}">
                Timetable
            </a>
        </li>

        <!-- meal -->
        <li class="nav-item">
            <a class="nav-link" href="{{ route('routemap-index') }}">
                Route map
            </a>
        </li>

        <!-- station -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                Station
            </a>
        </li>

        <!-- news -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                News
            </a>
        </li>

        <!-- review -->
        <li class="nav-item">
            <a class="nav-link" href="#">
                Review
            </a>
        </li>


        <!-- social icons : mobile only -->
        <li class="nav-item d-block d-sm-none text-center mb-4">

            <h3 class="h6 text-muted">Follow Us</h3>

                <!-- facebook -->
            <a href="#" class="btn btn-sm btn-facebook transition-hover-top mb-2 rounded-circle text-white" rel="noopener">
                <i class="fi fi-social-facebook"></i> 
            </a>

            <!-- twitter -->
            <a href="#" class="btn btn-sm btn-twitter transition-hover-top mb-2 rounded-circle text-white" rel="noopener">
                <i class="fi fi-social-twitter"></i> 
            </a>

            <!-- linkedin -->
            <a href="#" class="btn btn-sm btn-linkedin transition-hover-top mb-2 rounded-circle text-white" rel="noopener">
                <i class="fi fi-social-linkedin"></i> 
            </a>

            <!-- youtube -->
            <a href="#" class="btn btn-sm btn-youtube transition-hover-top mb-2 rounded-circle text-white" rel="noopener">
                <i class="fi fi-social-youtube"></i> 
            </a>

        </li>


    </ul>
    <!-- /navbar : navigation -->


</div>