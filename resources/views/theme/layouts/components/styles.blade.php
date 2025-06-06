<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="author" content="SemiColonWeb" />

    <!-- Font Imports -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400..900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

    <!-- Stylesheets
    ============================================= -->
    <link rel="stylesheet" href="{{ asset('theme/css/bootstrap.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/css/style.css') }}" type="text/css" />
    <!-- <link rel="stylesheet" href="{{ asset('theme/css/swiper.css') }}" type="text/css" /> -->

    <!-- Construction Demo Specific Stylesheet -->
    <!-- / -->
    
    <link rel="stylesheet" href="{{ asset('theme/css/dark.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/css/font-icons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/css/animate.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/css/magnific-popup.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/css/slick.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/css/slick-theme.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/css/fontawesome.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/css/cookiealert.css') }}" type="text/css"  />
    <link rel="stylesheet" href="{{ asset('theme/css/fonts.css') }}" type="text/css"  />
    <!-- <link rel="stylesheet" href="{{ asset('theme/css/cafe.css') }}" type="text/css"  /> -->
    
    <link rel="stylesheet" href="{{ asset('theme/css/custom.css') }}" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <!-- <link rel="icon" href="{{ asset('storage').'/icons/'.Setting::getFaviconLogo()->website_favicon }}" type="image/x-icon"> -->
    <!-- <link rel="stylesheet" href="{{ asset('theme/extra/drone.css') }}" type="text/css"  /> -->
 
    <link rel="stylesheet" href="{{ asset('theme/addons/css/style.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/addons/css/font-icons.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/addons/css/swiper.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/addons/include/rs-plugin/css/settings.css') }}" media="screen">
    <link rel="stylesheet" href="{{ asset('theme/addons/include/rs-plugin/css/layers.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/addons/include/rs-plugin/css/navigation.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('theme/addons/css/custom.css') }}" type="text/css" />


    <!-- add-on css -->
    <!-- main color #144596 -->
    <style type="text/css">
        .is-expanded-menu .menu-container:not(.mobile-primary-menu) {
            display: flex !important;
            flex-wrap: wrap !important;
            align-items: center !important;
        }
        #top-search.header-misc-icon {
/*            display: none;*/
        }
        .primary-menu-trigger {
/*            display: none;*/
        }
        body #header.transparent-header.floating-header {
             margin-top: 0px !important;
        }
        #wrapper #header.transparent-header.floating-header .container {
            background-color: transparent !important;
        }
        /*header#header:not(.sticky-header) div#header-wrap,
        header#header.sticky-header  div#header-wrap {
            margin-top: 24px;
        }*/
        #wrapper header#header div#header-wrap {
             /*background-color: transparent !important;
             box-shadow: none !important;
             border-bottom: none !important;
             margin-top: 24px;*/
        }
        #header-wrap > .container {
            /*border-radius: 50px !important;
            border: 1px solid #e5e5e599 !important;
            box-shadow: 0px 0px 4px #4c4c4c75;*/
        }
        header#header .menu-container > .menu-item.current > .menu-link,
        header#header .menu-container > .menu-item:hover > .menu-link {
/*            color: #144596 !important;*/
        }
        div#wrapper section#slider {
/*            margin-top: -85px;*/
        }
        #footer.modair-footer {
            background-color: #212529 !important;
        }
        .primary-a {
            color: #0c4499 !important;
            background-color: #dfecfd !important;
            font-weight: 800 !important;
            transition: all 0.2s;
        }
        .primary-label {
            color: #0c4499 !important;
            background-color: #dfecfd !important;
            padding: 2px 15px;
            font-size: 32px !important;
            max-width: fit-content;
            border-radius: 14px;
        }
        .light-body {
            background-color: #ffffff !important;
            margin: 0px !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 55px 80px 80px 80px;
        }
        .dark-body {
            background-color: #c9d3e0 !important;
            margin: 0px !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 55px 80px 80px 80px;
        }
        .text-extrabold{
            font-weight:900 !important;
        }
        .primary-a span {
            cursor: pointer;
            display: inline-block;
            position: relative;
            transition: 0.5s;
        }
        .primary-a span:after {
            content: '\00bb';
            position: absolute;
            opacity: 0;
            top: 0;
            right: -20px;
            transition: 0.5s;
        }
        .primary-a:hover span {
            padding-right: 25px;
        }
        .primary-a:hover span:after {
            opacity: 1;
            right: 0;
        }
        .primary-a:hover {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }
        #website-content .heading-block h1 {
            margin-top: -80px;
            z-index: 9;
            position: absolute;
        }
        .primary-colors {
            color: #0c4499 !important;
        }
        .qr-modair-size {
            max-height: 510px !important;
        }
        li.list-style-none {
            list-style: none;
            color: #0c4499 !important;
            font-size: 24px;
            font-weight: 600;
            text-shadow: 2px 2px 4px #767676;
            margin: 10px 0px;
        }
        li.list-style-none a {
            color: #0c4499 !important;
        }
        ul.list-group-container {
            margin-top: -16px;
        }
        li.list-style-none:hover {
            scale: 1.02;
            transition: all .2s;
            color: #c0cde3 !important;
            text-shadow: 2px 2px 4px #0c4499;
        }
        li.list-style-none:hover a {
            color: #c0cde3 !important;
            text-shadow: 2px 2px 4px #0c4499;
        }
        .light-body-services {
            margin-top: 0px !important;
        }
        #website-content .light-body-services .heading-block h1 {
            margin-top: -80px !important;
        }
        .col-md-6.services-list {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .rounded-corners {
            border-radius: 16px;
        }
        div#wrapper section#slider.slider-element.boxed-slider .slider-wrap .half-one{
            padding-top: 20px;
        }
        #slider .clearfix .heading-block::after {
            display: none;
        }
        .floating-panel {
            background-color: #85a1cc85;
            border-radius: 16px;
            padding: 24px;
            position: absolute;
            left: 4%;
            top: 20%;
            z-index: 1;
        }
        .flex-center-center {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .flex-center-center .position-relative.overflow-hidden a img {
            border-radius: 16px;
        }
        .invi {
            display: none;
        }

        .col-md-6.text-center.flex-center-center .position-relative.overflow-hidden a .card {
            position: absolute;
            z-index: 1;
            min-width: 50%; 
            max-width: 50%; 
            min-height: 60%;
            left: 5%;
            top: 10%;
            background-color: #85a1ccc7;
            border-radius: 14px;
            border: none;
            text-align: left;
            color: white;
        }
        .col-md-6.text-center.flex-center-center .position-relative.overflow-hidden a .card .card-header {
            border: none;
        }
        i.bi-facebook,
        i.bi-linkedin {
            font-size: 35px;
            margin-right: 12px;
            margin-left: 12px;
        }
        .modair-primary-logo {
            min-width: 210px;
        }
        
        /*our services animations*/
        a.img-services-wrapper {
            position: relative;
        }
        a.img-services-wrapper img.img-services-item {
            position: absolute;
            left: 0;
            border-radius: 100%;
        }
        img.img-services-item.img-services-animate-odd {
            -webkit-animation:spin 10s linear infinite;
            -moz-animation:spin 10s linear infinite;
            animation:spin 10s linear infinite;
        }
        img.img-services-item.img-services-animate-even {
            -webkit-animation:spin 50s linear infinite;
            -moz-animation:spin 50s linear infinite;
            animation:spin 50s linear infinite;
        }
        @-moz-keyframes spin { 
            100% { -moz-transform: rotate(360deg); } 
        }
        @-webkit-keyframes spin { 
            100% { -webkit-transform: rotate(360deg); } 
        }
        @keyframes spin { 
            100% { 
                -webkit-transform: rotate(360deg); 
                transform:rotate(360deg); 
            } 
        }
        .position-relative.overflow-hidden.img-services-container {
            padding: 15px;
        }
        .scaleUp {
            transform: scale(1.30);
            transition: all .2s;
        }
        
        .services-list li.list-style-none {
            font-size: 32px;
        }
        .primary-label.neutralfix {
            margin-left: 55px;
        }
        .light-body {
            margin: 0px !important;
            width: 100% !important;
            max-width: 100% !important;
            padding: 55px 80px 80px 80px;
        }

        .card .side-menu ul li a.menu-link {
            color: #2c2c2c !important;
            font-weight: 400 !important;
        }
        #copyrights .copyright-links a {
            color: rgba(255, 255, 255, 0.4);
        }
        #header .header-wrap-clone {
            height: 100% !important;
        }

        /*section#slider.slick-wrapper.clearfix .banner-wrapper:not(.no-slider-banner),
        section#slider.slick-wrapper.clearfix div#banner.home-slider.slick-initialized:not(.no-slider-banner) {
            height: 443px !important;
        }*/
        /*.slick-slide .hero-slide .banner-caption .row.align-items-center .col-lg-12 h2.text-center.slide-content {
            margin-top: -15%;
        }*/
        section#slider.slick-wrapper.clearfix .banner-wrapper .sub-banner-caption.dark > .container {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }
        section#slider.slick-wrapper.clearfix .banner-wrapper .sub-banner-caption.dark > .container .sub-banner-flex {
            transform: translate(0px, 80px);
        }
        nav.primary-menu.with-arrows ul.menu-container li.menu-item.sub-menu ul.sub-menu-container {
            background-color: rgb(0, 55, 87);
        }
        div#banner.home-slider:not(.no-slider-banner) .slick-list.draggable .slick-track .slick-slide .hero-slide {
            max-height: 650px;
        }
        div#banner.home-slider:not(.no-slider-banner) .slick-list.draggable .slick-track .slick-slide .hero-slide .banner-caption .row.align-items-center .col-lg-12 h2 {
            font-size: 48px;
            font-weight: 500 !important;
        }
        section#slider.home-slider-banner img {
            transform: translate(0px, -12%);
        }
        section#slider:not(.home-slider-banner) .sub-banner-caption.dark .container h2.text-center.excerpt-1.text-light {
            font-weight: 500 !important;
        }
        section#slider:not(.home-slider-banner):not(.no-slider-banner) .sub-banner-caption.dark .container h2.text-center.excerpt-1.text-light {
            font-weight: 500 !important;
            font-size: 42px;
        }
        section#slider:not(.home-slider-banner):not(.no-slider-banner) {
            max-height: 440px !important;
            min-height: 440px !important;
            height: 440px !important;
        }

        @media only screen and (max-width: 1367px) {
            section#slider.home-slider-banner img {
                transform: translate(0px, -8%);
            }
            div#banner.home-slider:not(.no-slider-banner) .slick-list.draggable .slick-track .slick-slide .hero-slide {
                max-height: 445px;
            }
            section#slider:not(.home-slider-banner):not(.no-slider-banner) {
                max-height: 300px !important;
                min-height: 300px !important;
                height: 300px !important;
            }
            section#slider:not(.home-slider-banner):not(.no-slider-banner) .sub-banner-caption.dark .container h2.text-center.excerpt-1.text-light {
                font-weight: 500 !important;
                font-size: 36px;
                transform: translate(0px, -30px);
            }
            section#slider.slick-wrapper.clearfix .banner-wrapper .sub-banner-caption.dark > .container .sub-banner-flex {
                transform: translate(0px, 45px);
            }
        }

        div#portfolio .entry .grid-inner.shadow-sm.h-shadow .w-100 a img.w-100 {
            max-height: 300px;
        }

        div#banner.home-slider:not(.no-slider-banner) .slick-list.draggable .slick-track .slick-slide .hero-slide .banner-caption .container {
            max-width: 700px;
        }

        div#banner.home-slider:not(.no-slider-banner) .slick-list.draggable .slick-track .slick-slide .hero-slide .banner-caption .container .col-lg-12 h2.text-center.slide-content {
            text-transform: none;
        }

        /*utility bar custom css*/
        #utility-bar {
            background-color: #2b3649;
        }
        #utility-bar ul.navbar-nav li.nav-item a.nav-link:not(.mini-logo):hover {
            background-color: #394863;
        }
        #utility-bar .dropdown-toggle {
            border: none;
            box-shadow: none;
        }
        #utility-bar .dropdown-toggle::after {
            display: none;
        }

        /* header custom css */
        div#header-wrap {
            background-color: #f6f6fa  !important;
        }
        div#header-wrap .menu-link:hover {
            color: #202020 !important;
        }


        /*top bar custom css*/
        #top-bar .text-roman {
            font-family: 'Cinzel', serif !important;
        }

        /*footer new*/
        .list-item-container .list-item i.fa{
            font-size: .5rem;
        }
        .list-item-container .list-item a,
        .list-item-container .list-item {
            list-style-type: none;
            text-decoration: none;
            color: white;
        }

        #footer .footer-image {
            display: flex;
            justify-content: center;
            padding-left: 0px !important;
        }
        #footer .footer-image img {
            filter: grayscale(4);
            width: 220px;
            opacity: .4;
        }
        #footer p {
            color: white;
        }

        #footer .footer-image + .col-12.col-lg-3.px-5.pb-4 {
            padding-left: 0px !important;
        }

        #footer #copyrights {
            background-color: #151c27;
        }
        #footer #copyrights a,
        #footer #copyrights .text-center {
            color: #979797;
        }
        
    </style>

    <style>
        @php
            $jsStyle = str_replace(array("'", "&#039;"), "", old('styles', $page->styles) );
            echo $jsStyle;
        @endphp
    </style>
    <!-- Document Title
    ============================================= -->
    @if (isset($page->name) && $page->name == 'Home')
        <title>{{ Setting::info()->company_name }}</title>
    @else
        <title>{{ (empty($page->meta_title) ? $page->name:$page->meta_title) }} | {{ Setting::info()->company_name }}</title>
    @endif

    @if(!empty($page->meta_description))
        <meta name="description" content="{{ $page->meta_description }}">
    @endif

    @if(!empty($page->meta_keyword))
        <meta name="keywords" content="{{ $page->meta_keyword }}">
    @endif

    @yield('pagecss')
</head>