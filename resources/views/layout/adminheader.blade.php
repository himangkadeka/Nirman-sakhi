<!DOCTYPE html>
<html lang="en">
<head>
	<title>ABOCWWB | Dashboard</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Bootstrap Template created by UxDT division, National Informatics Centre">
  	<meta name="keywords" content="HTML, Bootstrap, CSS, JS">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{URL::asset('assets/template/vendor/bootstrap/css/bootstrap.min.css')}}" />
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/base.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/abaocwwb.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/base-responsive.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/animate.min.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/slicknav.min.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/font-awesome.min.css')}}" />
    <link href="{{URL::asset('assets/template/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

    <script src="{{URL::asset('assets/template/vendor/charts/Chart.js')}}"></script>
    <script src="{{URL::asset('assets/template/vendor/charts/moment.min.js')}}"></script>
	<script src="{{URL::asset('assets/template/vendor/charts/Chart.min.js')}}"></script>
	<script src="{{URL::asset('assets/template/vendor/charts/utils.js')}}"></script>
    <!-- Message Display -->
    @if(Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    @endif

    @if(Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
    @endif
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
    </style>
</head>
