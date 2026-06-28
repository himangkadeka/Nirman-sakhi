<!DOCTYPE html>

<head>
    <title>{{ config('app.name', 'ABOCWWB') }} | @yield('title')</title>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bootstrap Template created by UxDT division, National Informatics Centre">
    <meta name="keywords" content="HTML, Bootstrap, CSS, JS">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{URL::asset('assets/template/vendor/bootstrap/css/bootstrap.min.css')}}" />
    <!-- Custom styles for this template -->
    <link rel="icon" href="/abocwwb.ico" type="image/x-icon">
    {{-- <link rel="shortcut icon" href="abocwwb2.ico" type="image/x-icon"> --}}
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/base.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/abaocwwb.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/base-responsive.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/animate.min.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/slicknav.min.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/font-awesome.min.css')}}" />
    <script src="{{URL::asset('assets/template/vendor/charts/Chart.js')}}"></script>
    <script src="{{URL::asset('assets/template/vendor/charts/moment.min.js')}}"></script>
	<script src="{{URL::asset('assets/template/vendor/charts/Chart.min.js')}}"></script>
	<script src="{{URL::asset('assets/template/vendor/charts/utils.js')}}"></script>
    <link href="{{URL::asset('assets/template/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{URL::asset('assets/template/css/Monsterat.css')}}" rel='stylesheet'>
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/dataTables.bootstrap5.min.css')}}" />
    @yield('header')
    <link href="{{URL::asset('assets/template/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <script src="{{ URL::asset('assets/template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin_assets/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <link href="{{URL::asset('assets/template/css/buttons.dataTables.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/symbols-materials.css') }}" />
    <link href="{{ URL::asset('assets/template/css/my-style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ asset('assets/summernote/summernote-lite.min.css') }}">
    <script src="{{ asset('assets/summernote/summernote-lite.min.js') }}"></script>
    <script src="{{asset('assets/template/js/popper.min.js')}}"></script>

    <script>
        var base_url = "{{ env('APP_URL') }}";
        var csrf = "{{ csrf_token() }}";
    </script>

    {{-- <script src="{{URL::asset('assets/template/vendor/charts/Chart.js')}}"></script> --}}
    {{-- <script src="{{URL::asset('assets/template/vendor/charts/moment.min.js')}}"></script> --}}
    {{-- <script src="{{URL::asset('assets/template/vendor/charts/Chart.min.js')}}"></script> --}}
    {{-- <script src="{{URL::asset('assets/template/vendor/charts/utils.js')}}"></script> --}}
    <script src="{{URL::asset('assets/template/js/sweetAlert.js')}}"></script>
    <!-- Message Display -->



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
            float: right;
        }

        .b-leftmenu ul ul {
            background-color: #ebebeb;
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
    @yield('style')
</head>

<body>
    {{-- @include('components.loader') --}}
    @include('sweetalert::alert')

    <div class="d-flex" id="wrapper">
        <!-- Sidebar Content -->
        @include('components.sidebar')
        <div id="page-content-wrapper">
            <!-- topNav Content -->
            @include('components.topnav')
            <!-- BreedCrumb -->
            <div class="office-list">
                <ul class="breadcrumb" style="font-size: 0.5rem;">
                    <li>@yield('breadcrumb_item_1')</li>
                    <li>@yield('breadcrumb_item_2')</li>
                </ul>

                <div class="user-office">
        <span style="color: #de2717 !important; font-size:1rem;font-weight: 500;">
            {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
        </span><br/>
         <span class="text-success" style="color: #18b33b !important; font-size: 0.9rem;font-weight: 500;">
            {{ Auth::user()->office->office_name }}
        </span>
                </div>
            </div>


            <!-- Main Content -->
            @yield('content')
        </div>
    </div>
    <!-- Footer Content -->
    @include('components.footer')
    <!-- Additional Footer Content (if(any)) -->
    @yield('footer')

    <script>
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>


</body>

</html>
