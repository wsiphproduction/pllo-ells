<!-- Utility Bar
============================================= -->
<div id="utility-bar" class="w-100">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <ul class="navbar-nav d-flex flex-row">
                <li class="nav-item">
                    <a class="nav-link py-1 px-4 mini-logo text-white" href="#">
                       <img src="{{ asset('theme/addons/images/logos/ph-logo.png') }}" alt="logo" style="width: 40px;filter: grayscale(1);">
                    </a>
                </li>
                <li class="nav-item">
                    @if(auth()->user())
                        @if(auth()->user()->is_not_an_admin())
                            <a class="nav-link py-3 px-4 border-start border-secondary text-white text-uppercase" href="{{ route('member.dashboard') }}">
                                <small>PROFILE</small>
                            </a>   
                        @else
                        <div class="d-flex align-items-center">
                            <a class="nav-link py-3 px-4 border-start border-secondary text-white text-uppercase" href="{{ route('admin.dashboard') }}">
                                <small>DASHBOARD</small>
                            </a>
                            <a class="nav-link py-3 px-4 border-start border-secondary text-white text-uppercase" href="{{ route('maintenance.dashboard') }}">
                                <small>MAINTENANCE</small>
                            </a>
                        </div>
                        @endif
                    @else
                        <a class="nav-link py-3 px-4 border-start border-secondary text-white text-uppercase cursor-pointer" data-bs-toggle="modal" data-bs-target="#newLoginModal" id="newLoginModalOpen">
                            <small>LOGIN</small>
                        </a>
                    @endif
                </li>
                <li class="nav-item">
                    @if(auth()->user())
                        <a class="nav-link py-3 px-4 border-start border-secondary text-white text-uppercase" href="{{ route('member.logout') }}">
                            <small>LOGOUT</small>
                        </a>
                    @else
                        <a class="nav-link py-3 px-4 border-start border-secondary text-white text-uppercase" href="{{ route('register') }}">
                            <small>REGISTER</small>
                        </a>
                    @endif
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
                        <img src="{{ Auth::user()->avatar }}" class="rounded-circle" alt="" style="width: 30px; height: 30px;">
                    @else
                        <img src="theme/images/icons/accessibility-icon.png" class="rounded-circle" alt="" style="width: 30px; filter: brightness(4);">
                    @endif
                  </button>
                  <ul class="dropdown-menu">
                    <li>
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
                <a href="/">
                    <img class="logo-default" src="{{ asset('theme/addons/images/logos/lls-logo.png') }}" alt="logo" style="margin-top: 5px; padding-right: 16px;">
                </a>
            </div>

            <!-- Title -->
            <div class="header-title text-start">
                <div id="small-size-logo" class="d-none">
                    <a href="/">
                        <img src="{{ asset('theme/addons/images/logos/lls-logo.png') }}" alt="logo" style="margin-top: 5px; padding-right: 16px;">
                    </a>
                </div>
                <h3 class="text-roman text-black m-0" style="font-size: 38px;">Legislative Liaison System</h2>
                <h2 class="text-roman text-black mb-0" style="border-top: 1px solid #a1a1a1;">Presidential Legislative Liaison Office</h3>
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
                    <a href="/">
                        <img src="{{ asset('theme/addons/images/logos/lls-logo.png') }}" alt="logo">
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

<!-- New Login Modal -->
<div class="modal fade" id="newLoginModal" tabindex="-1" aria-labelledby="newLoginLabel" aria-hidden="true" style="left: -10%; top: -2%;">
    <div class="modal-dialog modal-dialog-centered" style="">
        <div class="modal-content border-0 rounded-0 shadow-lg" style="min-width: 800px;">
            <div class="modal-body"style="padding: 0px;"> 
                <div class="row">
                    <div class="d-flex">

                        <div class="col-7">
                            <img src="{{ asset('theme/addons/images/banners/login-pic.png') }}">
                        </div>

                        <div class="col-5" style="padding: 20px 20px 0px 20px;">

                            <div class="w-100 text-center mb-4">
                                <img src="{{ asset('theme/addons/images/logos/pllo-logo.png') }}" style="width: 180px;">
                            </div>

                            <div id="login-form-panel">

                                <h5 class="primary-text-color" style="font-size: 16px; font-weight: 600; margin-bottom: 6px;">USER LOGIN</h5>
                                <form id="login-form" name="login-form" class="nobottommargin mb-0" action="{{ route('member.online') }}" method="post">
                                    @csrf
                                    <div class="col_full" style="margin-bottom: 10px;">
                                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="EMAIL ADDRESS" />
                                    </div>

                                    <div class="col_full">
                                        <div class="col_full">
                                            <div class="input-group show_hide_password" id="show_hide_password">
                                                <input class="form-control" type="password" name="password" placeholder="PASSWORD">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col_full nobottommargin mt-2">
                                        <button type="submit" class="btn w-100" value="login" style="background-color: #3c5d90; color: white;"><small>LOGIN</small></button>
                                        <a href="{{ route('register') }}" class="btn btn-secondary w-100 mt-2"><small>SIGNUP</small></a>
                                        <br />
                                        <br />
                                        <small id="forgot-email-btn" onclick="showForgotEmail()" class="primary-text-color cursor-pointer">
                                            <i class="fa fa-chevron-right" style="font-size: 10px; margin-right: 4px; transform: translate(0px, -1px);"></i>
                                            Forgot Email Address
                                        </small>
                                        <br />
                                        <small id="forgot-email-btn" onclick="showResetPassword()" class="primary-text-color cursor-pointer">
                                            <i class="fa fa-chevron-right" style="font-size: 10px; margin-right: 4px; transform: translate(0px, -1px);"></i>
                                            Reset Password
                                        </small>
                                    </div>
                                </form>
                            </div>

                            <div id="forgot-form-panel" style="display: none;">
                            
                                @if(session('error'))
                                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                                        <i data-feather="alert-circle" class="mg-r-10"></i> {{ session('error') }}
                                    </div>
                                @endif

                                @if (session('status'))
                                    <div class="alert alert-success d-flex align-items-center" role="alert">
                                        <i data-feather="check-circle" class="mg-r-10"></i> {{ session('status') }}
                                    </div>
                                @endif

                                <h5 class="primary-text-color" style="font-size: 16px; font-weight: 600; margin-bottom: 6px;">FORGOT EMAIL ADDRESS</h5>
                                <form id="forgot-form" name="forgot-form" class="nobottommargin mb-0" action="{{ route('customer-front.send_reset_link_email') }}" method="post">
                                    @csrf
                                    <div class="col_full" style="margin-bottom: 10px;">
                                        <input type="email" id="alt_email" name="alt_email" value="{{ old('alt_email') }}" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="ALTERNATIVE EMAIL ADDRESS" />
                                    </div>

                                    <div class="col_full nobottommargin mt-2">
                                        <button type="submit" class="btn w-100" value="submit" style="background-color: #3c5d90; color: white;"><small>SUBMIT</small></button>
                                        <a href="{{ route('register') }}" class="btn btn-secondary w-100 mt-2"><small>SIGNUP</small></a>
                                        <br />
                                        <br />
                                        <small id="forgot-email-btn" onclick="showResetPassword()" class="primary-text-color cursor-pointer">
                                            <i class="fa fa-chevron-right" style="font-size: 10px; margin-right: 4px; transform: translate(0px, -1px);"></i> Forgot Password
                                        </small>
                                        <br />
                                        <small id="login-form-btn" onclick="showLogin()" class="primary-text-color cursor-pointer"><i class="fa fa-chevron-right" style="font-size: 10px; margin-right: 4px; transform: translate(0px, -1px);"></i> Login</small>
                                    </div>
                                </form>
                            </div>

                            <div id="reset-password-panel" style="display: none;">
                            
                                @if(session('error'))
                                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                                        <i data-feather="alert-circle" class="mg-r-10"></i> {{ session('error') }}
                                    </div>
                                @endif

                                @if (session('status'))
                                    <div class="alert alert-success d-flex align-items-center" role="alert">
                                        <i data-feather="check-circle" class="mg-r-10"></i> {{ session('status') }}
                                    </div>
                                @endif

                                <h5 class="primary-text-color" style="font-size: 16px; font-weight: 600; margin-bottom: 6px;">RESET PASSWORD</h5>
                                <form id="forgot-form" name="forgot-form" class="nobottommargin mb-0" action="{{ route('customer-front.send_reset_link_email') }}" method="post">
                                    @csrf
                                    <div class="col_full" style="margin-bottom: 10px;">
                                        <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" placeholder="EMAIL ADDRESS" />
                                    </div>

                                    <div class="col_full nobottommargin mt-2">
                                        <button type="submit" class="btn w-100" value="submit" style="background-color: #3c5d90; color: white;"><small>SUBMIT</small></button>
                                        <a href="{{ route('register') }}" class="btn btn-secondary w-100 mt-2"><small>SIGNUP</small></a>
                                        <br />
                                        <br />
                                        <small id="forgot-email-btn" onclick="showForgotEmail()" class="primary-text-color cursor-pointer">
                                            <i class="fa fa-chevron-right" style="font-size: 10px; margin-right: 4px; transform: translate(0px, -1px);"></i> Forgot Email Address
                                        </small>
                                        <br />
                                        <small id="login-form-btn" onclick="showLogin()" class="primary-text-color cursor-pointer"><i class="fa fa-chevron-right" style="font-size: 10px; margin-right: 4px; transform: translate(0px, -1px);"></i> Login</small>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('theme.layouts.components.alert')

<script>
    
    function showForgotEmail() {
        document.getElementById('login-form-panel').style.display = 'none';
        document.getElementById('forgot-form-panel').style.display = 'block';
        document.getElementById('reset-password-panel').style.display = 'none';
    }

    function showResetPassword() {
        document.getElementById('login-form-panel').style.display = 'none';
        document.getElementById('forgot-form-panel').style.display = 'none';
        document.getElementById('reset-password-panel').style.display = 'block';
    }

    function showLogin() {
        document.getElementById('login-form-panel').style.display = 'block';
        document.getElementById('forgot-form-panel').style.display = 'none';
        document.getElementById('reset-password-panel').style.display = 'none';
    }

</script>