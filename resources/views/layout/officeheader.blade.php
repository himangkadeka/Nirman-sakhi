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
    <link href="{{URL::asset('assets/template/css/Monsterat.css')}}" rel='stylesheet'>
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/symbols-materials.css') }}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/dataTables.bootstrap5.min.css')}}" />

    <style>
    	body {
			background-color: #fff;
		}

		.b-leftmenu ul {
			list-style: none;
			margin: 0;
			padding: 0;
		}
		.b-leftmenu ul li {
		  /* Sub Menu */
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
        * {

            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

        }
        label.bold{
            font-weight: 600;
            font-family:"Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

        }
        .btn-primary {
            background-color: #0f4547;
        }
        .bar1, .bar2, .bar3 {
            width: 25px;
            height: 3px;
            background-color: #fff;
            margin: 5px 0;
            transition: 0.4s;
        }
        .label{
            /*font-weight: 300;*/
        }

        .change .bar1 {
            -webkit-transform: rotate(-45deg) translate(-5px, 5px);
            transform: rotate(-45deg) translate(-5px, 5px);
        }

        .change .bar2 {opacity: 0;}

        .change .bar3 {
            -webkit-transform: rotate(45deg) translate(-5px, -7px);
            transform: rotate(45deg) translate(-5px, -7px);
        }
        .card {
            -webkit-box-shadow: -2px 2px 0px 1px rgba(15,58,71,1);
            -moz-box-shadow: -2px 2px 0px 1px rgba(15,58,71,1);
            box-shadow: -2px 2px 0px 1px rgba(15,58,71,1);

        }
        /*box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;*/

        .card:hover {
            /*box-shadow: 0 8px 16px 0 rgba(15,58,71,0.81);*/
            /*box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(15,58,71,0.81) 0px 15px 12px;*/
            /*box-shadow: rgba(15,58,71,0.81) 0px 0px 0px 3px;*/
            /*box-shadow: rgba(15,58,71,0.81) 0px 5px 15px;*/
        }

        .card-title{

            height: 100px;
            background-repeat: no-repeat, no-repeat;
            background-position: center;
            text-align: center;
            color: white;
            /*width:;*/

        }

        .btn-outline-info{
            display: flex;
            align-items: center;
            background-color: #0f3a47;
            color:white;
        }
        .btn-outline-warning{
            display: flex;
            align-items: center;
            background-color: #f17000;
            color:white;
        }
        .btn-outline-success{
            display: flex;
            align-items: center;
            background-color: #0FAA5F;
            color:white;
        }
        .material-symbols-outlined {
            margin-right: 5px; /* Adjust this value to control the spacing between the icon and text. */
        }
        .table,th{
            font-size:13px;
            text-align: center;
            /*background-color: #0f3a47;*/
            color: black;
        }
        input[type='checkbox'] {
            width:20px;
            height:20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }

        /*td {*/
        /*    border: 1px solid black;*/
        /*}*/


        /* try removing the "hack" below to see how the table overflows the .body */
        .hack1 {
            display: table;
            table-layout: fixed;
            width: 100%;
        }

        .hack2 {
            display: table-cell;
            overflow-x: auto;
            width: 100%;
        }

        .alert-info{
            background-color: #0c5460;
        }
        hr.gradient {
            height: 3px;
            border: none;
            border-radius: 6px;
            background: linear-gradient(
                90deg,
                rgba(13, 8, 96, 1) 0%,
                rgba(9, 9, 121, 1) 21%,
                rgba(6, 84, 170, 1) 51%,
                rgba(0, 255, 113, 1) 100%
            );
        }
    </style>
</head>
