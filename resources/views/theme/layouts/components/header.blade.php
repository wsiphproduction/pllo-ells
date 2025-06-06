<!-- Utility Bar
============================================= -->
<div id="utility-bar" class="w-100">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <ul class="navbar-nav d-flex flex-row">
                <li class="nav-item">
                    <a class="nav-link py-1 px-4 mini-logo text-white" href="#">
                       <img src="theme/addons/images/logos/ph-logo.png" alt="logo" style="width: 40px;filter: grayscale(1);">
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 px-4 border-start border-secondary text-white text-uppercase" href="#">
                        <small>Login</small>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link py-3 px-4 border-start border-secondary text-white text-uppercase" href="{{ route('register') }}">
                        <small>Register</small>
                    </a>
                </li>
            </ul>

            <div class="d-flex align-items-center">
                <form action="{{ route('search.result') }}" method="get" style="margin-bottom: 0px;">
                    <div class="d-flex align-items-center">
                        <input class="px-2 pr-4 py-1" type="text" name="searchtxt" placeholder="Search" style="padding-right: 30px !important;">
                        <i class="uil uil-search" style="transform: translate(-28px, 0px);"></i>
                    </div>
                </form>
                <div class="btn-group">
                  <button type="button" class="btn dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                    @if(Auth::user())
                        <img src="{{ Auth::user()->avatar }}" class="rounded-circle" alt="" style="width: 30px">
                    @else
                        <img src="theme/images/icons/accessibility-icon.png" class="rounded-circle" alt="" style="width: 30px; filter: brightness(4);">
                    @endif
                  </button>
                  <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item" href="#">Login</a>
                        <a class="dropdown-item" href="#">Help</a>
                    </li>
                  </ul>
                </div>
            </div>

            {{-- <div class="header-misc ms-lg-2">
                <!-- Top Search
                ============================================= -->
                <div id="top-search" class="header-misc-icon  ps-lg-4">
                    <a href="#" id="top-search-trigger">
                        <i class="uil uil-search"></i>
                        <i class="bi-x-lg"></i>
                    </a>
                </div>
            </div>
            <form class="top-search-form" action="{{ route('search.result') }}" method="get">
                <input type="text" name="searchtxt" class="form-control" value="" placeholder="Search..." autocomplete="off" style="padding-left: 175px;">
            </form> --}}
        </div>
    </div>
</div>

<!-- Top Bar
============================================= -->
<div id="top-bar" class="py-4" style="border: none;">
    <div class="container">
        <div class="d-flex justify-content-start flex-md-row fw-medium text-center text-white">
            <!-- Logo -->
            <div id="main-logo" class="m-0 d-none">
                <a href="index.html">
                    <!-- <img class="logo-default" src="{{env('APP_URL')}}/theme/addons/images/logos/Seal_of_the_Supreme_Court_of_the_Philippines.png" alt="logo"> -->
                    <img class="logo-default" src="theme/addons/images/logos/pllo-logo.png" alt="logo">
                </a>
            </div>

            <!-- Title -->
            <div class="header-title text-start">
                <div id="small-size-logo" class="d-none">
                    <a href="index.html">
                        <!-- <img src="{{env('APP_URL')}}/theme/addons/images/logos/Seal_of_the_Supreme_Court_of_the_Philippines.png" alt="logo"> -->
                        <img src="theme/addons/images/logos/pllo-logo.png" alt="logo">
                    </a>
                </div>
                <h4 class="text-roman text-black m-0 text-uppercase">Republic of the Philippines</h4>
                <h2 class="text-roman text-black mb-0" style="font-size: 38px; border-top: 1px solid #a1a1a1;">PRESIDENTIAL LEGISLATIVE LIAISON OFFICE</h2>
                <small class="text-roman text-black">MALACAÑANG MANILA</small>
            </div>
        </div>
    </div>
</div> 

<!-- Header
============================================= -->
<header id="header" class="header-size-sm transparent-header floating-header" data-sticky-shrink="false">
	<div id="header-wrap">


		<div class="container" data-class="up-lg:border up-lg:shadow-sm">
			<div class="header-row">

                <!-- Logo
				============================================= -->
                <div id="header-logo" class="px-3 d-none">
                    <a href="index.html">
                        <!-- <img src="../images/logos/Seal_of_the_Supreme_Court_of_the_Philippines.png" alt="logo"> -->
                        <img src="/theme/addons/images/logos/pllo-logo.png" alt="logo">
                    </a>
                </div><!-- #logo end -->

                <div class="primary-menu-trigger">
                    <button class="cnvs-hamburger" type="button" title="Open Mobile Menu">
                        <span class="cnvs-hamburger-box"><span class="cnvs-hamburger-inner"></span></span>
                    </button>
                </div>


				<!-- Primary Navigation
				============================================= -->
				<nav class="primary-menu with-arrows">

					@include('theme.layouts.components.menu')

				</nav><!-- #primary-menu end -->

			</div>
		</div>


	</div>
	<!-- <div class="header-wrap-clone"></div> -->
</header><!-- #header end -->

@include('theme.layouts.components.alert')