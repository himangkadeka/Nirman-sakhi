<!DOCTYPE html>
<html lang="en">
<head>
	<title>ABOCWWB | Dashboard</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Bootstrap Template created by UxDT division, National Informatics Centre">
  	<meta name="keywords" content="HTML, Bootstrap, CSS, JS">
    <link rel="stylesheet" href="{{URL::asset('assets/template/vendor/bootstrap/css/bootstrap.min.css')}}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Custom styles for this template -->
    <link rel="icon" href="/abocwwb.ico" type="image/x-icon">
    {{-- <link rel="shortcut icon" href="abocwwb2.ico" type="image/x-icon"> --}}
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/base.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/abaocwwb.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/base-responsive.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/animate.min.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/slicknav.min.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{URL::asset('assets/template/css/font-awesome.min.css')}}" />
    <link href="{{URL::asset('assets/template/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{URL::asset('assets/template/vendor/charts/Chart.js')}}"></script>
    <script src="{{URL::asset('assets/template/vendor/charts/moment.min.js')}}"></script>
	<script src="{{URL::asset('assets/template/vendor/charts/Chart.min.js')}}"></script>
	<script src="{{URL::asset('assets/template/vendor/charts/utils.js')}}"></script>
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/dataTables.bootstrap5.min.css')}}" />
    <script src="{{URL::asset('assets/template/js/popper.min.js')}}"></script>
    <link href="{{ URL::asset('assets/template/css/my-style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('assets/template/css/toastify.min.css') }}">
    <script src="{{URL::asset('assets/template/js/sweetAlert.js')}}"></script>
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">--}}
    <link rel="stylesheet" href="{{ URL::asset('assets/template/vendor/bootstrap/css/bootstrap.min.css') }}" />
    @php
        $base_url= env("APP_URL");
    @endphp

    <style>
    	body {
			background-color: #fff;
		}

		.b-leftmenu ul {
			list-style: none;
			margin: 0;
			padding: 0;
		}

		.b-leftmenu ul li a {
			display: block;
			background: #ebebeb;
			padding:15px;
			color: #333;
			text-decoration: none;
			-webkit-transition: 0.2s linear;
			-moz-transition: 0.2s linear;
			-ms-transition: 0.2s linear;
			-o-transition: 0.2s linear;
			transition: 0.2s linear;
		}
		.b-leftmenu ul li a:hover {
			background: #f8f8f8;
			color: #515151;
		}
		.b-leftmenu ul li a .fa {
			font-size:18px;
			text-align: center;
			margin-right: 5px;
			float:right;
		}
		.b-leftmenu ul ul {
			background-color:#ebebeb;
		}
		.b-leftmenu .sub-menu ul li a {
			background: #f8f8f8;
			border-left: 4px solid transparent;
			padding: 10px 25px;
		}
		.b-leftmenu .sub-sub-menu ul li a {
			padding: 10px 20px 10px 40px;
		}
		.b-leftmenu a.b-newpage:hover {
			background: #ebebeb;
			border-left: 4px solid #3498db;
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

        /* LOADER DESIGN starts here */
        .loader-container {
            background: rgba(0, 0, 0, 0.6);
            bottom: 0;
            left: 0;
            overflow: hidden;
            position: fixed;
            text-align: center;
            right: 0;
            top: 0;
            z-index: 99999;
        }

        .loading-text {
            margin-top: 325px;
            margin-left: 50px;
            font-size: 18px;
            color: white;

        }

        .loader {
            position: absolute;
            top: 50%;
            left: 50%;
            list-style: none;
            transform: translate(-50%, -50%);
            display: flex;
        }

        .loader li {
            display: inline-block;

            list-style: none;
            width: 6px;
            height: 20px;
            background: #bbbfc2;
            margin: 0 4px;
            animation: animate .5s infinite alternate;

        }

        @keyframes animate {
            0% {
                transform: scaleY(1);
            }

            25% {
                transform: scaleY(1);
            }

            50% {
                transform: scaleY(1);
            }

            75% {
                transform: scaleY(1);
            }

            100% {
                transform: scaleY(3);
            }
        }

        .loader li:nth-child(1) {
            animation-delay: .1s;
        }

        .loader li:nth-child(2) {
            animation-delay: .2s;
        }

        .loader li:nth-child(3) {
            animation-delay: .3s;
        }

        .loader li:nth-child(4) {
            animation-delay: .4s;
        }

        .loader li:nth-child(5) {
            animation-delay: .5s;
        }

        .loader li:nth-child(6) {
            animation-delay: .6s;
        }

        /* LOADER DESIGN ends here */


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
        }

        .active-new {
            border-bottom: 3px solid orange
        }
    </style>
</head>
<body>
    @include('sweetalert::alert')
    {{-- <div class="loader-container">--}}

        {{--<ul class="loader">--}}
            {{--<li></li>--}}
            {{--<li></li>--}}
            {{--<li></li>--}}
            {{--<li></li>--}}
            {{--<li></li>--}}
            {{--<li></li>--}}
        {{--</ul>--}}
        {{--<div class="loading-text">Loading...</div>--}}
    {{--</div> --}}
    <div class="overlay"></div>
