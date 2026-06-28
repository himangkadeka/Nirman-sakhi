<!DOCTYPE html>
<html lang="en">

<head>
    <title>ABOCWWB | Homepage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="created by UxDT division, National Informatics Centre">
    <meta name="keywords" content="HTML, Bootstrap, CSS, JS">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/template/vendor/bootstrap/css/bootstrap.min.css') }}" />
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/base.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/abaocwwb.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/base-responsive.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/slicknav.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/dataTables.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/toastr.min.css') }}" />
    
    <link rel="stylesheet" href="{{ asset('assets/template/css/bootstrap-icons.min.css') }}">

    
    <link href="{{ URL::asset('assets/template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet"
        type="text/css">
    
        <script src="{{ URL::asset('assets/template/js/popper.min.js') }}"></script>

    <style>
        @media (max-width: 768px) {
            .emblem {
                padding-top: 10px;
                margin-left: 200px;
                display: block;
            }

            .headcontent {
                text-align: center;
                margin-top: 10px;



            }

            .dropdown-content {
                width: 100%;
            }

            .dropbtn {
                width: 300px;
            }

        }
    </style>

</head>

<body>
    <div style="display:none;">
        <h1>Heading1</h1>
        <h2>Heading2</h2>
    </div>
    <!-- Accessibility -->
    <div class="container d-flex clearfix" id="b-accessibility">
        <div class="b-ministryname">
            <div class="text-right d-inline-block font-weight-bold b-acc-goi pr-sm-2">
                <span>{{ trans('header.govt_of_assam') }}</span>
                {{-- <a href="#" target="_blank"><span>Government of Assam</span></a> --}}
            </div>
            <div class="d-inline-block font-weight-bold b-acc-ministry pl-sm-2">
                <span>{{ trans('header.labour_dept') }}</span>
                {{-- <a href="#" target="_blank"><span>Labour Welfare Department</span></a> --}}
            </div>
        </div>
        <div class="ml-auto d-flex b-acc-icons">
            <div class="align-self-center">

                <div class="d-inline-block h-100 px-1">

                    <i class="fa fa-search" data-toggle="dropdown" style="cursor: pointer;" aria-hidden="true"></i>
                    <div class="dropdown-menu p-0 border-0 b-search">
                        <label for="site-search" style="display:none;">Site search</label>
                        <input type="text" class="form-control float-left b-site-search" id="site-search"
                            placeholder="Search" style="width: 150px; border-radius: 0;">
                        <div class="input-group-btn float-left">
                            <button class="btn" type="submit"
                                style="border-radius: 0; background: #505050; color: white; box-shadow: 0 0 0 0.2rem rgba(0,123,255,0);">
                                <span style="display:none;">Search</span>
                                <span class="fas fa-search"></span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="d-inline-block h-100 px-1 dropdown">
                    <i class="fa fa-users" data-toggle="dropdown" style="cursor: pointer;" aria-hidden="true"></i>


                    <div class="dropdown-menu b-social-dropdown" style="min-width: 50px; width: 50px">
                        <a href="javascript:void(0)" class="dropdown-item"> <span style="display:none;">Facebook
                                link</span><span class="fab fa-facebook-f"></span> </a>
                        <a href="javascript:void(0);" class="dropdown-item"> <span style="display:none;">Twitter
                                link</span><span class="fab fa-twitter"></span> </a>
                        <a href="javascript:void(0)" class="dropdown-item"> <span style="display:none;">Youtube
                                link</span><span class="fab fa-youtube"></span> </a>
                    </div>
                </div>


                <div class="d-inline-block h-100 px-1">

                    <a href="#b-homedb" class="align-self-center b-skiptomain" title="Skip to main content">
                        <i class="fa fa-angle-double-down" style="color: #505050;"></i>
                    </a>
                </div>

                <div class="d-inline-block h-100 px-1">

                    <i class="fa fa-universal-access" aria-hidden="true" itle="Accessibility" data-toggle="dropdown"
                        style="cursor: pointer;"></i>

                    <div class="dropdown-menu b-accessibility-dropdown" style="min-width: 50px; width: 50px">
                        <a href="javascript:void(0);" class="dropdown-item" title="Increase font size"> <span
                                class="font-weight-bold"> A<sup>+</sup> </span> </a>
                        <a href="javascript:void(0)" class="dropdown-item" title="Reset font size"> <span
                                class="font-weight-bold"> A </span> </a>
                        <a href="javascript:void(0);" class="dropdown-item" title="Decrease font size"> <span
                                class="font-weight-bold"> A<sup>-</sup> </span> </a>
                        <a href="javascript:void(0)" class="dropdown-item bg-dark" title="High contrast"> <span
                                class="font-weight-bold text-white"> A </span> </a>
                    </div>
                </div>


                <div class="d-inline-block h-200 dropdown px-1;"
                    style=" background-color:#0f3a47; padding-left: 10px; padding-right:10px; padding-top: 4px; padding-bottom: 4px; border-radius:10px">

                    <div style="display: flex; cursor: pointer; justify-content:center; align-items:center"
                        data-toggle="dropdown" data-toggle="dropdown" aria-hidden="true">
                        <div style="margin-right: 4px">
                            <i class="fa fa-globe" style="color: white; font-size: 14px;"></i>
                            <!-- Adjust font-size to match the text font size -->
                        </div>
                        <div>
                            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                @php
                                    $isActive = LaravelLocalization::getCurrentLocale() == $localeCode; // Check if the current locale is active
                                    $style = $isActive
                                        ? 'color: white; text-decoration: none; font-size: 14px'
                                        : 'display: none;'; // Set style to hide inactive languages
                                @endphp
                                <a style="{{ $style }}" rel="alternate" hreflang="{{ $localeCode }}"
                                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    {{ $properties['native'] }}
                                </a>
                            @endforeach
                        </div>
                    </div>


                    <div class="dropdown-menu b-social-dropdown">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            @php
                                $isActive = LaravelLocalization::getCurrentLocale() == $localeCode; // Check if the current locale is active
                                $style = $isActive
                                    ? 'background-color: #e3e5e8; color: black; text-decoration: none;'
                                    : 'color: black; text-decoration: none;'; // Set style based on active or inactive
                            @endphp
                            <a style="{{ $style }}" rel="alternate" hreflang="{{ $localeCode }}"
                                href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                {{ $properties['native'] }}
                            </a>
                        @endforeach
                    </div>

                </div>

                <div class="d-inline-block h-100 px-1">
                    {{-- <a href="sitemap" title="Sitemap"> --}}
                    {{--                    <a href="{{ route('home.sitemap') }}" class="nav-link @if (Route::is('home.sitemap')) active @endif" onclick="redirectToHome();" > --}}

                    {{-- <i class="fas fa-sitemap" style="color: #505050;"></i> --}}



                    </a>
                </div>


            </div>

        </div>

    </div>


    <!-- Header -->
    <div class="container clearfix" id="b-header">
        <div class="float-left d-flex h-100">
            <div class="emblem">
                <img src="{{ URL::asset('assets/template/images/header/emblem-dark.png') }}"
                    class="align-self-center b-emblem-image" title="National Emblem of India"
                    alt="emblem of india logo">
            </div>
        </div>

        <div class="float-left d-flex h-100">
            <div class="headcontent">
                <h2 class="align-self-center pl-3 b-appname mt-3">
                    <span class="font-weight-bold">{{ trans('header.abocwwb') }}</span>
                    <br>
                    <span class="b-appfullname">{{ trans('header.social') }}</span>
                </h2>
            </div>
        </div>
    </div>

    <style type="text/css">
        .bar1,
        .bar2,
        .bar3 {
            width: 25px;
            height: 3px;
            background-color: #fff;
            margin: 5px 0;
            transition: 0.4s;
        }

        .change .bar1 {
            -webkit-transform: rotate(-45deg) translate(-5px, 5px);
            transform: rotate(-45deg) translate(-5px, 5px);
        }

        .change .bar2 {
            opacity: 0;
        }

        .change .bar3 {
            -webkit-transform: rotate(45deg) translate(-5px, -7px);
            transform: rotate(45deg) translate(-5px, -7px);
        }

        .dropbtn {
            /* background-color: #074e58; */
            position: relative;
            color: white;

            /* padding: 16px; */
            padding-right: 35px;
            font-size: 18px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        /* .dropbtn:hover, .dropbtn:focus {
      background-color: green;
    } */
        /* Loader Container styles */
        .loader-container {
            background: rgba(0, 0, 0, 0.6);
            bottom: 0;
            left: 0;
            overflow: hidden;
            position: fixed;
            right: 0;
            top: 0;
            z-index: 99999;
        }

        .loader-inner {
            bottom: 0;
            height: 60px;
            left: 0;
            margin: auto;
            position: absolute;
            right: 0;
            top: 0;
            width: 100px;
        }

        .loader-line-wrap {
            animation:
                spin 2000ms cubic-bezier(.175, .885, .32, 1.275) infinite;
            /* Adjust the animation duration to reduce the total time */

            box-sizing: border-box;
            height: 50px;
            left: 0;
            overflow: hidden;
            position: absolute;
            top: 0;
            transform-origin: 50% 100%;
            width: 100px;
        }

        .loader-line {
            border: 4px solid transparent;
            border-radius: 100%;
            box-sizing: border-box;
            height: 100px;
            left: 0;
            margin: 0 auto;
            position: absolute;
            right: 0;
            top: 0;
            width: 100px;
        }

        .loader-line-wrap:nth-child(1) {
            animation-delay: -50ms;
        }

        .loader-line-wrap:nth-child(2) {
            animation-delay: -100ms;
        }

        .loader-line-wrap:nth-child(3) {
            animation-delay: -150ms;
        }

        .loader-line-wrap:nth-child(4) {
            animation-delay: -200ms;
        }

        .loader-line-wrap:nth-child(5) {
            animation-delay: -250ms;
        }

        .loader-line-wrap:nth-child(1) .loader-line {
            border-color: hsl(0, 80%, 60%);
            height: 90px;
            width: 90px;
            top: 7px;
        }

        .loader-line-wrap:nth-child(2) .loader-line {
            border-color: hsl(60, 80%, 60%);
            height: 76px;
            width: 76px;
            top: 14px;
        }

        .loader-line-wrap:nth-child(3) .loader-line {
            border-color: hsl(120, 80%, 60%);
            height: 62px;
            width: 62px;
            top: 21px;
        }

        .loader-line-wrap:nth-child(4) .loader-line {
            border-color: hsl(180, 80%, 60%);
            height: 48px;
            width: 48px;
            top: 28px;
        }

        .loader-line-wrap:nth-child(5) .loader-line {
            border-color: hsl(240, 80%, 60%);
            height: 34px;
            width: 34px;
            top: 35px;
        }

        @keyframes spin {

            0%,
            15% {
                transform: rotate(0);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: -40px;
            /* top:36px; */
            background-color: #f9f9f9;
            width: 220px;
            height: max-content+10%;

            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        /* Show the dropdown content on hover */
        .nav-item:hover .dropdown-content {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 4px
        }

        /* Style the dropdown links */
        .dropdown-content a {
            /* display: block; */
            text-align: left;
            padding-top: 5px;
            padding-bottom: 5px;
            margin: 8px;
            /* Adjust margin for gaps between items */
            text-decoration: none;
            color: black;
            transition: background-color 0.3s;
        }

        /* Additional styles for mobile responsiveness (optional) */
        @media only screen and (max-width: 767px) {
            .dropdown {
                display: block;
                text-align: left;
            }

            .dropdown-content {
                text-align: left;
                width: 100%;
            }
        }
    </style>



    <!-- Global Navigation -->
    <div class="globalnav-bg">
        <!-- Loader -->
        <div class="loader-container">
            <div class="loader-inner">
                <div class="loader-line-wrap">
                    <div class="loader-line"></div>
                </div>
                <div class="loader-line-wrap">
                    <div class="loader-line"></div>
                </div>
                <div class="loader-line-wrap">
                    <div class="loader-line"></div>
                </div>
                <div class="loader-line-wrap">
                    <div class="loader-line"></div>
                </div>
                <div class="loader-line-wrap">
                    <div class="loader-line"></div>
                </div>
            </div>
        </div>
        <div class="overlay"></div>

        <div class="container">
            <nav class="navbar navbar-expand-sm navbar-dark px-0">
                <div class="d-flex w-100 b-nav-mobile">
                    <button class="navbar-toggler align-self-center b-btn-toggler" type="button"
                        data-toggle="collapse" data-target="#collapsibleNavbar" onclick="myFunction(this)">
                        <span style="display:none;">Menu</span>
                        <div>
                            <div class="bar1"></div>
                            <div class="bar2"></div>
                            <div class="bar3"></div>
                        </div>

                        </li>
                        <li class="nav-item d-block"> <a href="{{ route('home.progressreport') }}"
                                class="nav-link @if (Route::is('home.progressreport')) active @endif"
                                onclick="redirectToHome();">Progress Report</a></li>
                        <li class="nav-item d-block"> <a href="{{ route('home.contactus') }}"
                                class="nav-link @if (Route::is('home.contactus')) active @endif">Contact Us</a></li>
                        <li class="nav-item d-block ml-auto b-loginbut" data-toggle="modal"
                            data-target="#login-modal">

                    </button>


                </div>

                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav main-menu d-flex align-items-center">
                        <li class="nav-item d-block"> <a href="{{ route('home.index') }}"
                                class="nav-link @if (Route::is('home.index')) active @endif"
                                onclick="redirectToHome();">{{ trans('header.home') }}</a> </li>
                        <li class="nav-item d-block">
                            <a href="#" class="nav-link @if (Route::is('home.about.introduction') ||
                                    Route::is('home.about.mission-and-vission') ||
                                    Route::is('home.about.aims-and-objectives') ||
                                    Route::is('home.about.organizations')) active @endif"
                                onclick="redirectToHome();">{{ trans('header.about_us') }}</a>
                            <div class="dropdown-content">
                                <!-- Your dropdown content goes here -->
                                <a href="{{ route('home.introduction') }}"
                                    class="@if (Route::is('home.introduction')) new-active @endif">{{ trans('header.introduction') }}</a>
                                <a href="{{ route('home.members_of_the_board') }}"
                                    class="@if (Route::is('home.members_of_the_board')) new-active @endif">{{ trans('header.who') }}</a>
                                <a href="{{ route('home.missionandvission') }}"
                                    class="@if (Route::is('home.missionandvission')) new-active @endif">{{ trans('header.missionandvision') }}</a>
                                <a href="{{ route('home.aimsandobjectives') }}"
                                    class="@if (Route::is('home.aimsandobjectives')) new-active @endif">{{ trans('header.aimsandobjectives') }}</a>
                                <a href="{{ route('home.organizations') }}"
                                    class="@if (Route::is('home.organizations')) new-active @endif">{{ trans('header.organizations') }}</a>
                                <!-- Add more items as needed -->
                            </div>
                        </li>
                        {{-- <li class="nav-item d-block"> <a href="{{ route('home.progressreport') }}" class="nav-link @if (Route::is('home.progressreport')) active @endif" onclick="redirectToHome();" >Progress Report</a></li> --}}
                        <li class="nav-item d-block"> <a href="{{ route('home.contactus') }}"
                                class="nav-link @if (Route::is('home.contactus')) active @endif">{{ trans('header.contact_us') }}</a>
                        </li>
                        <li class="nav-item d-block"> <a href="gallery"
                                class="nav-link @if (Route::is('home.gallery')) active @endif">{{ trans('header.gallery') }}</a>
                        </li>
                        <li class="nav-item d-block ml-auto b-loginbut" data-toggle="modal"
                            data-target="#login-modal">

                            <button type="button" class="btn btn-outline-warning bold" id="login_modal_open"
                                style="padding: 0.25rem 0.5rem; font-size: 0.75rem;">{{ trans('header.login') }}&nbsp;<i
                                    class="fa fa-sign-in" aria-hidden="true"></i></button>








                        </li>
                    </ul>
                </div>

            </nav>
        </div>
    </div>

    <script>
        function myFunction(x) {
            x.classList.toggle("change");
        }
    </script>

    {{-- <script>
    function redirectToHome() {
        window.location.href = "index";
    }
</script> --}}

    <script>
        /* When the user clicks on the button,
<<<<<<< HEAD
                                    toggle between hiding and showing the dropdown content */
=======
<<<<<<< HEAD
                    toggle between hiding and showing the dropdown content */
=======
                        toggle between hiding and showing the dropdown content */
>>>>>>> dfa1ac16fbc46495ecd3c0ac2e04b7020374eff4
>>>>>>> 41f79e5b3d67d2b77fbba6762e84dd191efada45
        function mydropdownFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>

    <script>
        // Show loader and overlay
        function showLoader() {
            document.querySelector('.loader-container').style.display = 'block';
            // document.querySelector('.overlay').style.display = 'block';
        }

        // Hide loader and overlay
        function hideLoader() {
            document.querySelector('.loader-container').style.display = 'none';
            // document.querySelector('.overlay').style.display = 'none';
        }

        // Show loader initially
        showLoader();


        // Show loader initially
        showLoader();

        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                hideLoader();
            }, 100);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                hideLoader();
            }, 100);
        });
    </script>
