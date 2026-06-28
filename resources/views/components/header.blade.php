<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ config('app.name', 'ABOCWWB') }} | @yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description"
        content="Building & Other Construction Workers (BOCW) are one of the most vulnerable segments of the unorganized sector workforce in India and are characterized by their inherent risk to the life and limb of the workers.">
    <meta name="keywords"
        content="Building, Construction Worker, workforce, BOCW India, BOCW, Unorganized sector workforce, Vulnerable construction workers, Construction worker safety India, Building and construction risks, Worker vulnerability India, Risk to life in construction, Unorganized workforce risks, India construction worker safety, BOCW workforce safety">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ URL::asset('assets/template/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/base.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/abaocwwb.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/base-responsive.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/slicknav.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/font-awesome.min.css') }}">
    {{--    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/dataTables.bootstrap5.min.css') }}"> --}}
    <link href="{{ URL::asset('assets/template/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/template/css/buttons.dataTables.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/symbols-materials.css') }}" />
    <link href="{{ URL::asset('assets/template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet"
        type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/symbols-materials.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/sweetAlert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/header.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/font-google-apis.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/toastify.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/template/css/my-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/template/css/bootstrap-icons.min.css') }}">
    <link rel="icon" href="/abocwwb.ico" type="image/x-icon">

    <script src="{{ URL::asset('assets/template/vendor/jquery/jquery.min.js') }}"></script>
    {{-- <script type="application/javascript" src="{{ URL::asset('assets/template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script> --}}
    {{-- <link rel="stylesheet" href="{{ URL::asset('assets/template/css/header.css') }}" /> --}}
    <script>
        var base_url = "{{ env('APP_URL') }}";
        var csrf = "{{ csrf_token() }}";
        var env = "{{ env('STAGING') }}";
    </script>
    <style type="text/css">
        #year-list {
            display: none;
            position: absolute;
            left: 100%;
            /* Position it to the right */
            margin-top: -30px;
            /* Adjust as needed */
        }

        #year-list a {
            background-color: white;
            /* Make background of the 2025 item white */
            color: black;
            /* Change text color to black for better visibility */
            padding: 5px 10px;
            /* Optional: Add some padding for better appearance */
            text-decoration: none;
            /* Remove underline if necessary */
        }

        #year-list a:hover {
            background-color: #f0f0f0;
            /* Optional: Add a hover effect */
        }


        .small-radio {
            transform: scale(0.8);
            /* Adjust scale as needed */
        }

        .my-container {
            max-width: 1480px;
            margin: 0 auto;
        }


        @media (min-width: 1200px) {
            .my-container {
                max-width: 90%;
            }

            .content-11 {
                height: 34px;
            }


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

            /* padding: 4px */
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

            .g20logo {
                display: flex;
                justify-content: flex-start;
                align-items: center;
                margin-top: -15px;
            }


            .b-emblem-image {
                max-width: 100%;
                /* Ensures the image fits within the container */
                height: auto;
            }

        }

        .nav-link:hover {
            border-bottom: 3px solid orange;
            /* Style for hovered links */
            /* Change background color on hover */
            /* color: yellow;*/
        }

        .nav-link a:hover {
            color: white;
        }

        .active-new {
            border-bottom: 3px solid orange;
            /* Style for active link */
            background-color: darkblue;
        }

        /* Remove active style when hovering over other links */
        .nav-link:hover+.active-new,
        .nav-link:hover~.active-new {
            border-bottom: none;
            /* Remove active style */
        }

        input[type="radio"] {
            transform: scale(1.2);
            margin-right: 10px;
        }

        .dropdown-menu {
            z-index: 1050;
            /* Increase this value if necessary */
        }

        .dropdown-menu.custom-dropdown.selectyear ul {
            background: white;
            width: 200px;
            height: fit-content;
            list-style-type: none;
            border: none;
            border-radius: 0px;
            padding: 0px;
        }

        .dropdown-menu.custom-dropdown.selectyear ul li {
            border-bottom: 1px solid #ccc;
            width: 100%;
            display: block;
        }

        .dropdown-menu.custom-dropdown.selectyear ul li a {
            text-decoration: none;
            padding: 8px 10px;
            transition: 0.3s linear;
            width: 100%;
            display: block;
        }

        .dropdown-menu.custom-dropdown.selectyear ul li a:hover {
            text-decoration: none;
            background: #eb6f48;
            color: white;
        }

        .dropdown-menu.custom-dropdown.selectyear ul li:last-child {
            border-bottom: 0px
        }
    </style>

</head>

<body>
    @include('components.loader')
    @include('sweetalert::alert')

    <div class="modal fade" id="password-modal" tabindex="-1" role="dialog" aria-labelledby="passwordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="passwordModalLabel">Password Modal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Your content goes here -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>






    <div>
        <div class="content-11 mb-1"
            style="background-color: #e4e0dc;  display: flex;align-items: center; font-family: 'Poppins', sans-serif;">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center text-center px-md-5 px-sm-0"
                    id="b-accessibility">
                    <div class="govtAssam">
                        <span>Government of Assam</span>
                        &nbsp;|&nbsp;
                        <span>Labour Welfare Department</span>
                    </div>
                    <div class="d-flex justify-content-center  mr-1">
                        <div class="language-selection">
                            <form action="#" class="d-flex align-items-center">
                                <span class="mr-3 select-language">Select Language | ভাষা নিৰ্বাচন কৰক</span>

                                <ul class="list-unstyled d-flex mb-0">
                                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        <li class="ml-3">
                                            <label class="form-check-label mr-4" style="font-size: 14px;">
                                                <input type="radio" name="language"
                                                    class="form-check-input small-radio"
                                                    onclick="window.location.href='{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}'"
                                                    @if (app()->getLocale() === $localeCode) checked @endif>
                                                {{ $properties['native'] }}
                                            </label>
                                        </li>
                                    @endforeach
                                </ul>
                            </form>
                        </div>

                        <div class="dropdown smedia">
                            <i class="fa fa-users" data-bs-toggle="dropdown"
                                style="cursor:pointer;height:100%;width:30px"></i>
                            <ul class="dropdown-menu social-media">
                                <li><a href="#" class="dropdown-item"><span
                                            class="fab fa-facebook-f"></span></a>
                                </li>
                                <li><a href="#" class="dropdown-item"><span class="fab fa-twitter"></span></a>
                                </li>
                                <li><a href="#" class="dropdown-item"><span class="fab fa-youtube"></span></a>
                                </li>
                            </ul>
                        </div>
                        <a href="#b-homedb" class="mx-2" title="Skip to main content">
                            <i class="fa fa-angle-double-down" style="color: #505050;"></i>
                        </a>
                        <div class="dropdown Accessibility">
                            <i class="fa fa-universal-access" aria-hidden="true" title="Accessibility"
                                data-bs-toggle="dropdown" style="cursor: pointer;height:100%;width:30px;"></i>
                            <ul class="dropdown-menu font-increase">
                                <li><a href="#" id="increaseFont" class="dropdown-item">A<sup>+</sup></a></li>
                                <li><a href="#" id="resetFont" class="dropdown-item ">A</a></li>
                                <li><a href="#" id="decreaseFont" class="dropdown-item">A<sup>-</sup></a></li>
                                <li><a href="#" id="toggleDarkMode"
                                        class="dropdown-item bg-dark text-white">A</a></li>
                            </ul>
                        </div>






                    </div>
                </div>
            </div>
        </div>


        <!-- Header -->
        <div class=" " style="">
            <div class="col">
                <div class="container-fluid px-md-5" id="b-header">
                    <div class="row align-items-center justify-content-around">
                        <div class="col-md d-flex align-items-center d-flex-column-sm mb-md-0">
                            <div class="emblem" onclick="window.location.href='{{ url('/') }}'"
                                style="cursor: pointer;">
                                <img src="{{ URL::asset('assets/template/images/header/emblem-dark.png') }}"
                                    class="b-emblem-image" alt="emblem of india logo">
                            </div>


                            {{-- <div class="emblem" onclick="redirectToIndex()">
                                <img src="{{ URL::asset('assets/template/images/header/emblem-dark.png') }}"
                                     class="b-emblem-image" alt="emblem of india logo">
                            </div> --}}

                            <div class="nirmanSakhi">
                                <div class="header-title" onclick="window.location.href='{{ url('/') }}'"
                                    style="cursor: pointer; font-family:'Poppins',Sans-Serif;">
                                    {{ trans('header.nirmansakhi') }}
                                </div>
                                <div class="header-subtitle" style="font-family:'Roboto',Sans-Serif">
                                    {{ trans('header.abocwwb') }}
                                </div>
                            </div>
                            {{-- <div class="emblem">
                                <img src="{{ URL::asset('assets/template/images/g20-logo.png') }}"
                                     class="b-emblem-image" alt="emblem of india logo"
                                     style="width: 50%; height: 60%;padding-top: 30px;">
                            </div> --}}

                        </div>
                        <div class="g20logo">
                            <img src="{{ URL::asset('assets/template/images/g20-logo.png') }}" class="b-emblem-image"
                                alt="emblem of india logo" id="g20-image">
                        </div>
                        <div class="helpdesk">
                            <span class="text-danger" style="font-weight: 550; ">{{ trans('helpdesk.Helpdeskno') }}.
                                1800-345-3574</span><br>
                            <span>{{ trans('helpdesk.time') }}</span>

                        </div>
                        <div>
                            <img src="{{ URL::asset('assets/template/images/header/ABOC logo-01.svg') }}"
                                class="b-logo-image" alt="ABOC logo" id="aboc-image">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Global Navigation -->
        <div class="globalnav-bg">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <div class="container-fluid px-md-5 menubar">

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse md:d-flex justify-content-between" id="navbarNav">
                        <ul class="navbar-nav ms-auto mr-1 ml-1">
                            <li class="nav-item">
                                {{-- <a class="nav-link @if (Route::is('home.index')) active-new @endif"
                                    href="{{ route('home.index') }}">Home</a> --}}
                                <a class="nav-link @if (Route::is('home.index')) active-new @endif"
                                    href="{{ route('home.index') }}">{{ trans('header.home') }}</a>
                            </li>
                            <li class="nav-item dropdown">
                                {{-- <a class="nav-link dropdown-toggle @if (Route::is('home.about.*')) active-new @endif"
                                    href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    About Us <span class="dropdown-toggle-icon"><i class="fa fa-angle-down"></i></span>
                                </a> --}}
                                <a class="nav-link dropdown-toggle @if (Route::is('home.about.*')) active-new @endif"
                                    href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{ trans('header.about_us') }} <span class="dropdown-toggle-icon"><i
                                            class="fa fa-angle-down"></i></span>
                                </a>
                                <ul class="dropdown-menu about-drop" aria-labelledby="navbarDropdown"
                                    style="font-family:'Roboto',Sans-Serif">
                                    <li style="font-family:'Roboto',Sans-Serif">
                                        {{-- <a
                                            class="dropdown-item about-drop-item @if (Route::is('home.about.introduction')) active @endif"
                                            href="{{ route('home.about.introduction') }}">Introduction</a> --}}
                                        <a class="dropdown-item about-drop-item @if (Route::is('home.about.introduction')) active @endif"
                                            href="{{ route('home.about.introduction') }}">{{ trans('header.introduction') }}</a>
                                    </li>
                                    <li>
                                        {{-- <a class="dropdown-item about-drop-item @if (Route::is('home.about.whos-who')) active @endif"
                                            href="{{ route('home.about.whos-who') }}">Who's Who</a> --}}
                                        <a class="dropdown-item about-drop-item @if (Route::is('home.about.whos-who')) active @endif"
                                            href="{{ route('home.about.whos-who') }}">{{ trans('header.who') }}</a>
                                    </li>
                                    <li>
                                        {{-- <a class="dropdown-item about-drop-item  @if (Route::is('home.about.mission-and-vission')) active @endif"
                                            href="{{ route('home.about.mission-and-vission') }}">Mission and Vision</a> --}}
                                        <a class="dropdown-item about-drop-item  @if (Route::is('home.about.mission-and-vission')) active @endif"
                                            href="{{ route('home.about.mission-and-vission') }}">{{ trans('header.missionandvision') }}</a>
                                    </li>
                                    <li>
                                        {{-- <a class="dropdown-item about-drop-item @if (Route::is('home.about.aims-and-objectives')) active @endif"
                                            href="{{ route('home.about.aims-and-objectives') }}">Aims and Objectives</a> --}}
                                        <a class="dropdown-item about-drop-item @if (Route::is('home.about.aims-and-objectives')) active @endif"
                                            href="{{ route('home.about.aims-and-objectives') }}">{{ trans('header.aimsandobjectives') }}</a>

                                    </li>
                                    <li>
                                        {{-- <a class="dropdown-item about-drop-item @if (Route::is('home.about.functions')) active @endif"
                                            href="{{ route('home.about.functions') }}">Functions of the Board</a> --}}
                                        <a class="dropdown-item about-drop-item @if (Route::is('home.about.functions')) active @endif"
                                            href="{{ route('home.about.functions') }}">{{ trans('header.functions') }}</a>
                                    </li>
                                    <li>
                                        {{-- <a class="dropdown-item about-drop-item @if (Route::is('home.about.organizations')) active @endif"
                                            href="{{ route('home.about.organizations') }}">Organogram</a> --}}
                                        <a class="dropdown-item about-drop-item @if (Route::is('home.about.organizations')) active @endif"
                                            href="{{ route('home.about.organizations') }}">{{ trans('header.organogram') }}</a>
                                    </li>
                                </ul>
                            </li>


                            <li class="nav-item">
                                {{-- <a class="nav-link @if (Route::is('home.actandrules')) active-new @endif"
                                    href="{{ route('home.actandrules') }}">Act & Rules</a> --}}
                                <a class="nav-link @if (Route::is('home.actandrules')) active-new @endif"
                                    href="{{ route('home.actandrules') }}">{{ trans('header.actandrules') }}</a>
                            </li>


                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle @if (Route::is('home.schemesandbenefits.*')) active-new @endif"
                                    href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{ trans('header.benefits') }} <span class="dropdown-toggle-icon"><i
                                            class="fa fa-angle-down"></i></span>
                                </a>

                                <ul class="dropdown-menu about-drop" aria-labelledby="navbarDropdown"
                                    style="font-family:'Roboto',Sans-Serif">
                                    <li style="font-family:'Roboto',Sans-Serif">

                                        <a class="dropdown-item about-drop-item @if (Route::is('home.schemesandbenefits.benifits')) active-new @endif"
                                            href="{{ route('home.schemesandbenefits.benefits') }}">{{ trans('benefitsProvidedByTheBoard.head') }}</a>

                                    </li>
                                    <li style="font-family:'Roboto',Sans-Serif">

                                        <a class="dropdown-item about-drop-item @if (Route::is('home.grivence')) active @endif"
                                            href="#" data-toggle="modal"
                                            data-target="#listofapprovedbenefits-modal">{{ trans('benefitsProvidedByTheBoard.list') }}</a>

                                    </li>

                                    @php
                                        $years_returned = App\Models\IndexNotification::where('category', 5)
                                            ->distinct()
                                            ->orderBy('year', 'desc')
                                            ->pluck('year'); // Fetch only the 'year' column as a collection

                                        // dd($data['years_returned']); // This should now display an array/collection of year values

                                        // Fetch distinct years for category_id = 4
                                        $years_disbursed = App\Models\IndexNotification::where('category', 4)
                                            ->distinct()
                                            ->orderBy('year', 'desc')
                                            ->pluck('year');
                                    @endphp


                                    <!-- Disbursed Benefit Dropdown -->
                                    <li class="nav-item dropdown">
                                        <a class="dropdown-item about-drop-item" href="#"
                                            id="dropdownMenuButton2" aria-haspopup="true" aria-expanded="false">
                                            List of Disbursed benefit
                                        </a>
                                        <div class="dropdown-menu custom-dropdown selectyear"
                                            aria-labelledby="dropdownMenuButton2">
                                            @isset($years_disbursed)
                                                <ul name="year" id="year-dropdown" class="form-control"
                                                    onchange="window.location.href=this.value;">

                                                    @foreach ($years_disbursed as $year)
                                                        <li>
                                                            @if (isset($year))
                                                                <a
                                                                    href="{{ route('home.schemesandbenefits.disbursed.year', ['year' => $year]) }}">
                                                                    Year {{ $year }}
                                                                </a>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endisset

                                            {{-- @isset($years_disbursed)
                                                <select name="year" id="year-dropdown" class="form-control"
                                                    onchange="window.location.href=this.value;">
                                                    <option value="">Select Year</option>

                                                    @foreach ($years_disbursed as $year)
                                                        <option
                                                            value="{{ route('home.schemesandbenefits.disbursed.year', ['year' => $year]) }}">
                                                            Year {{ $year }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            @endisset --}}
                                        </div>
                                    </li>
                                    <!-- Benefits Returned Dropdown -->
                                    <li class="nav-item dropdown">
                                        <a class="dropdown-item about-drop-item" href="#"
                                            id="dropdownMenuButton1" aria-haspopup="true" aria-expanded="false">
                                            List of Benefits Returned
                                        </a>

                                        <div class="dropdown-menu custom-dropdown selectyear"
                                            aria-labelledby="dropdownMenuButton2">
                                            @isset($years_returned)
                                                <ul name="year" id="year-dropdown" class="form-control"
                                                    onchange="window.location.href=this.value;">

                                                    @foreach ($years_returned as $year)
                                                        <li>
                                                            <a href="{{ route('home.schemesandbenefits.returned.year', ['year' => $year]) }}"
                                                                value="{{ route('home.schemesandbenefits.returned.year', ['year' => $year]) }}">
                                                                Year {{ $year }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endisset
                                        </div>
                                    </li>





                                    <script>
                                        // Get the dropdown buttons and dropdown menus
                                        const dropdownButton1 = document.getElementById('dropdownMenuButton1');
                                        const dropdownMenu1 = dropdownButton1.nextElementSibling; // Get the next sibling, which is the dropdown menu

                                        const dropdownButton2 = document.getElementById('dropdownMenuButton2');
                                        const dropdownMenu2 = dropdownButton2.nextElementSibling; // Get the next sibling, which is the dropdown menu

                                        // Initially hide the dropdowns
                                        dropdownMenu1.style.display = 'none';
                                        dropdownMenu2.style.display = 'none';

                                        // Show dropdown on mouse enter for Benefits Returned
                                        dropdownButton1.addEventListener('mouseenter', function() {
                                            dropdownMenu1.style.display = 'block';
                                        });

                                        // Show dropdown on mouse enter for Disbursed Benefit
                                        dropdownButton2.addEventListener('mouseenter', function() {
                                            dropdownMenu2.style.display = 'block';
                                        });

                                        // Hide dropdown on mouse leave for both
                                        dropdownButton1.addEventListener('mouseleave', function() {
                                            setTimeout(function() {
                                                if (!dropdownMenu1.matches(':hover')) {
                                                    dropdownMenu1.style.display = 'none';
                                                }
                                            }, 200); // Slight delay to allow click inside
                                        });

                                        dropdownButton2.addEventListener('mouseleave', function() {
                                            setTimeout(function() {
                                                if (!dropdownMenu2.matches(':hover')) {
                                                    dropdownMenu2.style.display = 'none';
                                                }
                                            }, 200); // Slight delay to allow click inside
                                        });

                                        // Optional: Hide dropdown if clicked elsewhere
                                        document.addEventListener('click', function(event) {
                                            if (!dropdownButton1.contains(event.target) && !dropdownMenu1.contains(event.target)) {
                                                dropdownMenu1.style.display = 'none';
                                            }
                                            if (!dropdownButton2.contains(event.target) && !dropdownMenu2.contains(event.target)) {
                                                dropdownMenu2.style.display = 'none';
                                            }
                                        });

                                        // Prevent dropdown from closing when clicking inside the dropdown menu items
                                        dropdownMenu1.addEventListener('click', function(event) {
                                            event.stopPropagation(); // Prevent event from propagating to the document
                                        });

                                        dropdownMenu2.addEventListener('click', function(event) {
                                            event.stopPropagation(); // Prevent event from propagating to the document
                                        });
                                    </script>

                                    <style>
                                        /* Custom CSS to align the dropdowns to the right */
                                        .custom-dropdown {
                                            position: absolute;
                                            left: 100%;
                                            /* Move the dropdown to the right */
                                            top: 0;
                                            display: none;
                                            /* Ensure the dropdowns are hidden initially */
                                        }
                                    </style>


                                    {{-- <li style="font-family:'Roboto',Sans-Serif">
                                        <a class="dropdown-item about-drop-item @if (Route::is('home.schemesandbenefits.benifits')) active-new @endif" href="#" id="benefits-link">
                                            Benefits returned
                                        </a>
                                        <ul id="year-list" style="">
                                            <li>
                                                <a class="dropdown-item about-drop-item" href="">2025</a>
                                            </li>
                                        </ul>
                                    </li> --}}

                                    {{-- <li style="font-family:'Roboto',Sans-Serif">

                                        <a class="dropdown-item about-drop-item @if (Route::is('home.schemesandbenefits.benifits')) active-new @endif"
                                            href="">Disbursed benefit </a>
                                            <ul>
                                                <li>
                                                    <a class="dropdown-item" href="#">2025</a>
                                                </li>

                                            </ul>
                                    </li> --}}

                                    {{-- <li style="font-family:'Roboto',Sans-Serif"><a
                                            class="dropdown-item about-drop-item @if (Route::is('home.grivence')) active @endif"
                                            href="#" data-toggle="modal"
                                            data-target="#grievance-modal">{{ trans('header.grivence') }}</a>
                                    </li> --}}



                                </ul>
                                {{--
                                <a class="nav-link @if (Route::is('home.benefits')) active-new @endif"
                                    href="{{ route('home.benefits') }}">{{ trans('header.benefits') }}</a> --}}
                            </li>
                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle @if (Route::is('home.services.*')) active-new @endif"
                                    href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    {{ trans('header.eservices') }} <span class="dropdown-toggle-icon"><i
                                            class="fa fa-angle-down"></i></span>
                                </a>

                                @php
                                    $cards = [
                                        [
                                            'image' => asset('assets/template/images/index/registration.png'),
                                            'title' => __('index.constructionworker'),
                                            'subtitle' => __('index.newregistration'),
                                            'modal' => '#initiating-modal',
                                            'circle-bg-color' => '#ffad16',
                                        ],
                                        [
                                            'image' => asset('assets/template/images/index/registration.png'),
                                            'title' => __('index.constructionworker'),
                                            'subtitle' => __('index.oldregistration'),
                                            'url' => route('home.onboarding-criteria'), // Updated to use 'url' instead of 'modal'
                                            'circle-bg-color' => '#009cdb',
                                        ],

                                        // Add other cards as needed
                                    ];
                                @endphp
                                <ul class="dropdown-menu about-drop" aria-labelledby="navbarDropdown"
                                    style="font-family:'Roboto',Sans-Serif">
                                    <li style="font-family:'Roboto',Sans-Serif">
                                        <a class="dropdown-item about-drop-item" href="{{ $cards[0]['modal'] }}"
                                            data-toggle="modal" data-target="{{ $cards[0]['modal'] }}">
                                            {{ $cards[0]['subtitle'] }}
                                        </a>
                                    </li>
                                    <li style="font-family:'Roboto',Sans-Serif">
                                        <a class="dropdown-item about-drop-item" href="{{ $cards[1]['url'] }}">
                                            <!-- Use 'url' instead of 'modal' -->
                                            {{ __('index.oldregistration') }}
                                        </a>
                                    </li>
                                    <li style="font-family:'Roboto',Sans-Serif">
                                        <a class="dropdown-item about-drop-item" href="#" data-toggle="modal"
                                            data-target="#renewal-modal">
                                            {{ trans('index.Renewal') }}
                                        </a>
                                    </li>
                                    <li style="font-family:'Roboto',Sans-Serif">
                                        <a class="dropdown-item about-drop-item"
                                            @if (Route::is('home.schemesandbenefits.benifits')) active-new @endif"
                                            href="{{ route('home.schemesandbenefits.benefits') }}">
                                            Welfare Benefit
                                        </a>


                                    </li>
                                    <li style="font-family:'Roboto',Sans-Serif">
                                        <a class="dropdown-item about-drop-item @if (Route::is('home.grivence')) active @endif"
                                            href="#" data-toggle="modal" data-target="#grievance-modal">
                                            {{ trans('header.grivence') }}
                                        </a>
                                    </li>
                                    <li style="font-family:'Roboto',Sans-Serif">
                                        <a class="dropdown-item about-drop-item @if (Route::is('home.helpdesk')) active @endif"
                                            href="{{ route('home.services.helpdesk') }}">
                                            {{ trans('helpdesk.Helpdesk') }}
                                        </a>
                                    </li>
                                </ul>

                            </li>
                            <li class="nav-item" style="font-family:'Roboto',Sans-Serif"><a
                                    class="nav-link @if (Route::is('home.mis')) active-new @endif"
                                    href="#" data-toggle="modal"
                                    data-target="#mis-modal">{{ trans('header.dashboard') }}</a>
                            </li>
                            {{-- <li class="nav-item" style="font-family:'Roboto',Sans-Serif"><a
                                    class="nav-link @if (Route::is('home.mis.index')) active-new @endif"
                                    href="{{ route('home.mis.index') }}"
                                   >{{ trans('header.mis') }}</a>
                            </li> --}}
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle @if (Route::is('home.pfcs.*')) active-new @endif"
                                    href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                   {{ trans('header.cscs') }}<span class="dropdown-toggle-icon"><i
                                            class="fa fa-angle-down"></i></span>
                                </a>

                                <ul class="dropdown-menu about-drop" aria-labelledby="navbarDropdown"
                                    style="font-family:'Roboto',Sans-Serif">
                                    <li style="font-family:'Roboto',Sans-Serif">



                                        <a class="dropdown-item about-drop-item @if (Route::is('home.pfcs.cscdetails')) active @endif"
                                            href="{{ route('home.pfcs.cscdetails') }}">{{ trans('header.cscdetails') }}</a>
                                    </li>
                                    {{-- <li style="font-family:'Roboto',Sans-Serif">

                                        <a class="dropdown-item about-drop-item @if (Route::is('home.grivence')) active @endif"
                                            href="#" data-toggle="modal"
                                            data-target="#listofapprovedpfcs-modal">2</a>

                                    </li> --}}





                                </ul>

                            </li>


                            <li class="nav-item" style="font-family:'Roboto',Sans-Serif;">

                                <a class="nav-link @if (Route::is('home.downloads')) active-new @endif"
                                    href="{{ route('home.downloads') }}">{{ trans('header.downloads') }}</a>
                            </li>

                            {{--<li class="nav-item">--}}

                                {{--<a class="nav-link @if (Route::is('home.gallery')) active-new @endif"--}}
                                    {{--href="{{ route('home.gallery') }}">{{ trans('header.gallery') }}</a>--}}
                            {{--</li>--}}
                            <li class="nav-item">

                                <a class="nav-link @if (Route::is('home.gallery')) active-new @endif"
                                   href="#">{{ trans('header.gallery') }}</a>
                            </li>

                            {{-- <li class="nav-item">
                                <a class="nav-link @if (Route::is('home.cess')) active-new @endif"
                                    href="#" data-toggle="modal" data-target="#cess-modal">{{ trans('header.cess') }}</a>
                            </li> --}}



                            <li class="nav-item">
                                {{-- <a class="nav-link @if (Route::is('home.contactus')) active-new @endif"
                                    href="{{ route('home.contactus') }}">Contact Us</a> --}}
                                <a class="nav-link @if (Route::is('home.contactus')) active-new @endif"
                                    href="{{ route('home.contactus') }}">{{ trans('header.contact_us') }}</a>
                            </li>

                            {{-- <li class="nav-item">

                                <a class="nav-link "
                                    href="">PFC Locators</a>
                            </li> --}}
                        </ul>
                        {{-- @if (Route::is('home.') || Route::is('home.about.') || Route::is('home.services.') || Route::is('home.schemesandbenefits.') || Route::is('home.gallery'))
                            <div class="login-button">
                                <a class="btn btn-sm btn-warning btn-rounded" href="#" data-bs-toggle="modal"
                                    data-bs-target="#login-modal" id="login_modal_open">
                                    {{ trans('header.login') }}&nbsp;<i class="fa fa-sign-in"></i>
                                </a>
                            </div>
                        @endif --}}

                        @if (Route::is('home.*'))
                            <div class="login-button" data-bs-toggle="modal" data-bs-target="#login-modal"
                                id="login_modal_open">
                                {{-- <a class="btn btn-sm" href="#" data-bs-toggle="modal"
                                    data-bs-target="#login-modal" id="login_modal_open">
                                    {{ trans('header.login') }}&nbsp;<i class="fa fa-sign-in"></i>
                                </a> --}}
                                <img src="{{ URL::asset('assets/template/images/animatedlogin2.gif') }}"
                                    alt="login"> <span>LOGIN</span>
                            </div>
                        @endif



                        {{-- <div class="login-button">
                            <a class="btn btn-sm btn-warning btn-rounded" href="#" data-bs-toggle="modal"
                                data-bs-target="#login-modal" id="login_modal_open">
                                {{ trans('header.login') }}&nbsp;<i class="fa fa-sign-in"></i>
                            </a>

                        </div> --}}

                    </div>
                </div>
            </nav>
        </div>
    </div>

    {{-- @include('components.registration')
    @include('components.registrationonboarding') --}}
    @include('components.cess-modal')
    @include('components.grievance-modal')
    @include('components.mis-modal')
    @include('components.listofapprovedbenefits')
    {{-- @include('components.registration')
    @include('components.registrationonboarding') --}}

    <!-- Bootstrap JavaScript (Optional for modals) -->

    <script src="{{ URL::asset('assets/template/js/popper.min.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/popper.min.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/bootstrap5.1.3.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Toggle dropdown icons
            const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
            dropdownToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const icon = this.querySelector('.dropdown-toggle-icon');
                    icon.textContent = icon.textContent === '+' ? '-' : '+';
                });
            });
        });
    </script>

    <script>
        // Default font size
        let currentFontSize = 16;

        // Increase font size
        document.getElementById('increaseFont').addEventListener('click', function() {
            currentFontSize += 2;
            document.body.style.fontSize = currentFontSize + 'px';
        });

        // Decrease font size
        document.getElementById('decreaseFont').addEventListener('click', function() {
            if (currentFontSize > 5) {
                currentFontSize -= 2;
                document.body.style.fontSize = currentFontSize + 'px';
            }
        });

        // Reset font size
        document.getElementById('resetFont').addEventListener('click', function() {
            currentFontSize = 16;
            document.body.style.fontSize = currentFontSize + 'px';
        });

        // Toggle dark mode
        document.getElementById('toggleDarkMode').addEventListener('click', function() {
            document.body.classList.toggle('bg-dark');
            document.body.classList.toggle('text-white');
        });
    </script>

</body>

</html>
