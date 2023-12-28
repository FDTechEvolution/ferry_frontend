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
    <ul class="navbar-nav font-proxima" id="navbar-menu">

        <!-- viw booking -->
        <li class="nav-item">
            <a class="nav-link fw-bold" href="{{ route('timetable-index') }}" style="text-decoration: none;">
                Timetable
            </a>
        </li>

        <!-- meal -->
        <li class="nav-item">
            <a class="nav-link fw-bold" href="{{ route('routemap-index') }}">
                Route map
            </a>
        </li>

        <!-- station -->
        <li class="nav-item">
            <a class="nav-link fw-bold" href="{{ route('station-index') }}">
                Check-in Station
            </a>
        </li>

        <li class="nav-item">
            <ul class="navbar-nav py-2 font-proxima">
                <li class="nav-item border-start border-2 addon-menu-style" style="line-height: 14px;">
                    <span class="smaller text-addon-color px-2">+ Add on</span>
                    <a class="nav-link py-0 fw-bold" href="#" style="height: 30px;">
                        Meal on board
                    </a>
                </li>

                <li class="nav-item" style="line-height: 14px;">
                    <span class="smaller text-addon-color px-2">+ Add on</span>
                    <a class="nav-link py-0 fw-bold" href="#" style="height: 30px;">
                        Shuttle Bus & Boat
                    </a>
                </li>

                <li class="nav-item" style="line-height: 14px;">
                    <span class="smaller text-addon-color px-2">+ Add on</span>
                    <a class="nav-link py-0 fw-bold" href="#" style="height: 30px;">
                        Activity
                    </a>
                </li>
            </ul>
        </li>

        <li class="nav-item ms-lg-3">
            <a class="nav-link fw-bold" href="#">
                <i class="fa-solid fa-motorcycle me-1 fs-2"></i> Rent a Bike!!
            </a>
        </li>

        <li class="nav-item">
            <div class="dropstart mt-lg-3 ms-lg-3">
                <a class="dropdown-toggle dropdown-color-style fs-4" href="#" role="button" id="exDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-bars"></i>
                </a>

                <ul class="dropdown-menu menu-on-nav" aria-labelledby="exDropdown">
                    <li><a class="dropdown-item" href="#">TIMETABLE</a></li>
                    <li><a class="dropdown-item" href="#">ROUTE MAP</a></li>
                    <li><a class="dropdown-item" href="#">CHECK-IN STATION</a></li>
                    <li><a class="dropdown-item" href="#">REVIEW</a></li>
                    <li><a class="dropdown-item" href="#">NEWS</a></li>
                    <li><a class="dropdown-item" href="#">+ MEAL ON BOARD</a></li>
                    <li><a class="dropdown-item" href="#">+ HOTEL SHUTTLE BUS</a></li>
                    <li><a class="dropdown-item" href="#">+ RESORT SHUTTLE BOAT</a></li>
                    <li><a class="dropdown-item" href="#">+ ACTIVITY</a></li>
                    <li><a class="dropdown-item" href="#">* PRIVATE CHATER</a></li>
                    <li><a class="dropdown-item" href="#">* RENT A BIKE !!</a></li>
                    <li><a class="dropdown-item" href="#">CONTACT US</a></li>
                </ul>
            </div>
        </li>


        <!-- social icons : mobile only -->
        <!-- <li class="nav-item d-block d-sm-none text-center mb-4">

            <h3 class="h6 text-muted">Follow Us</h3>

            <a href="#" class="btn btn-sm btn-facebook transition-hover-top mb-2 rounded-circle text-white" rel="noopener">
                <i class="fi fi-social-facebook"></i> 
            </a>

            <a href="#" class="btn btn-sm btn-twitter transition-hover-top mb-2 rounded-circle text-white" rel="noopener">
                <i class="fi fi-social-twitter"></i> 
            </a>

            <a href="#" class="btn btn-sm btn-linkedin transition-hover-top mb-2 rounded-circle text-white" rel="noopener">
                <i class="fi fi-social-linkedin"></i> 
            </a>

            <a href="#" class="btn btn-sm btn-youtube transition-hover-top mb-2 rounded-circle text-white" rel="noopener">
                <i class="fi fi-social-youtube"></i> 
            </a>

        </li> -->


    </ul>
    <!-- <ul class="navbar-nav py-2 font-proxima">
        <li class="nav-item border-start border-2" style="line-height: 14px;">
            <span class="smaller text-light px-2">+ Add on</span>
            <a class="nav-link py-0 fw-bold" href="#" style="height: 30px;">
                Meal on board
            </a>
        </li>

        <li class="nav-item" style="line-height: 14px;">
            <span class="smaller text-light px-2">+ Add on</span>
            <a class="nav-link py-0 fw-bold" href="#" style="height: 30px;">
                Shuttle Bus & Boat
            </a>
        </li>

        <li class="nav-item" style="line-height: 14px;">
            <span class="smaller text-light px-2">+ Add on</span>
            <a class="nav-link py-0 fw-bold" href="#" style="height: 30px;">
                Activity
            </a>
        </li>
    </ul> -->

    <!-- <ul class="navbar-nav font-proxima ms-3">
        <li class="nav-item ms-3">
            <a class="nav-link fw-bold" href="#">
                <i class="fa-solid fa-motorcycle me-1 fs-2"></i> Rent a Bike!!
            </a>
        </li>
    </ul> -->

    <!-- <div class="dropstart ms-3">
        <a class="dropdown-toggle text-light fs-4" href="#" role="button" id="exDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-bars"></i>
        </a>

        <ul class="dropdown-menu menu-on-nav" aria-labelledby="exDropdown">
            <li><a class="dropdown-item" href="#">TIMETABLE</a></li>
            <li><a class="dropdown-item" href="#">ROUTE MAP</a></li>
            <li><a class="dropdown-item" href="#">CHECK-IN STATION</a></li>
            <li><a class="dropdown-item" href="#">REVIEW</a></li>
            <li><a class="dropdown-item" href="#">NEWS</a></li>
            <li><a class="dropdown-item" href="#">+ MEAL ON BOARD</a></li>
            <li><a class="dropdown-item" href="#">+ HOTEL SHUTTLE BUS</a></li>
            <li><a class="dropdown-item" href="#">+ RESORT SHUTTLE BOAT</a></li>
            <li><a class="dropdown-item" href="#">+ ACTIVITY</a></li>
            <li><a class="dropdown-item" href="#">* PRIVATE CHATER</a></li>
            <li><a class="dropdown-item" href="#">* RENT A BIKE !!</a></li>
            <li><a class="dropdown-item" href="#">CONTACT US</a></li>
        </ul>
    </div> -->
    <!-- /navbar : navigation -->


</div>