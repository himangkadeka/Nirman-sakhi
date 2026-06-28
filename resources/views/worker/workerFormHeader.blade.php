<!DOCTYPE html>
<html lang="en">
<head>
    <title>ABOCWWB | Homepage</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Bootstrap Template created by UxDT division, National Informatics Centre">
    <meta name="keywords" content="HTML, Bootstrap, CSS, JS">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{URL::asset('assets/template/vendor/bootstrap/css/bootstrap.min.css')}}" />
    <link href="{{URL::asset('assets/template/css/Monsterat.css')}}" rel='stylesheet'>
    <!-- Custom styles for this template -->
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/base.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/base-responsive.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/animate.min.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/slicknav.min.css')}}" />
{{--    <link rel="stylesheet" href="{{URL::asset('assets/template/css/font-awesome.min.css')}}" />--}}
    <link href="{{URL::asset('assets/template/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/symbols-materials.css') }}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/sweetAlert.css')}}" />
    <link rel="stylesheet" href="{{URL::asset('assets/template/css/abaocwwb.css')}}"




</head>
<body>
<div style="display:none;">
    <h1>Heading1</h1><h2>Heading2</h2>
</div>
<!-- Accessibility -->
<div class="container d-flex clearfix" id="b-accessibility">
    <div class="b-ministryname">
        <div class="text-right d-inline-block font-weight-bold b-acc-goi pr-sm-2">
            <a href="#" target="_blank"><span>Government of Assam</span></a>
        </div>
        <div class="d-inline-block font-weight-bold b-acc-ministry pl-sm-2">
            <a href="#" target="_blank"><span>Labour Welfare Department</span></a>
        </div>
    </div>
    <div class="ml-auto d-flex b-acc-icons">
        <div class="align-self-center">

            <div class="d-inline-block h-100 px-3">
                <img src="{{URL::asset('assets/template/images/icons/ico-site-search.png')}}" alt="site search icon" title="Site search" class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;">

                <div class="dropdown-menu p-0 border-0 b-search">
                    <label for="site-search" style="display:none;">Site search</label>
                    <input type="text" class="form-control float-left b-site-search" id="site-search" placeholder="Search" style="width: 150px; border-radius: 0;">
                    <div class="input-group-btn float-left">
                        <button class="btn" type="submit" style="border-radius: 0; background: #505050; color: white; box-shadow: 0 0 0 0.2rem rgba(0,123,255,0);">
                            <span style="display:none;">Search</span>
                            <span class="fas fa-search"></span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="d-inline-block h-100 px-3 dropdown">
                <img src="{{URL::asset('assets/template/images/icons/ico-social.png')}}" alt="social sites links" title="Social links" class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;">

                <div class="dropdown-menu b-social-dropdown" style="min-width: 50px; width: 50px">
                    <a href="javascript:void(0)" class="dropdown-item"> <span style="display:none;">Facebook link</span><span class="fab fa-facebook-f"></span> </a>
                    <a href="javascript:void(0);" class="dropdown-item"> <span style="display:none;">Twitter link</span><span class="fab fa-twitter"></span> </a>
                    <a href="javascript:void(0)" class="dropdown-item"> <span style="display:none;">Youtube link</span><span class="fab fa-youtube"></span> </a>
                </div>
            </div>


            <div class="d-inline-block h-100 px-3">
                <a href="#b-homedb" class="align-self-center b-skiptomain" title="Skip to main content">
                    <img src="{{URL::asset('assets/template/images/icons/ico-skip.png')}}" alt="skip to main content icon">
                </a>
            </div>

            <div class="d-inline-block h-100 px-3">
                <img src="{{URL::asset('assets/template/images/icons/ico-accessibility.png')}}" alt="accessibility icon" title="Accessibility Dropdown" class="dropdown-toggle" data-toggle="dropdown" style="cursor: pointer;">

                <div class="dropdown-menu b-accessibility-dropdown" style="min-width: 50px; width: 50px">
                    <a href="javascript:void(0);" class="dropdown-item" title="Increase font size"> <span class="font-weight-bold"> A<sup>+</sup> </span> </a>
                    <a href="javascript:void(0)" class="dropdown-item" title="Reset font size"> <span class="font-weight-bold"> A </span> </a>
                    <a href="javascript:void(0);" class="dropdown-item" title="Decrease font size"> <span class="font-weight-bold"> A<sup>-</sup> </span> </a>
                    <a href="javascript:void(0)" class="dropdown-item bg-dark" title="High contrast"> <span class="font-weight-bold text-white"> A </span> </a>
                </div>
            </div>

            <div class="d-inline-block h-100 px-3">
                <a href="site-map.html" title="Sitemap">
                    <img src="{{URL::asset('assets/template/images/icons/ico-sitemap.png')}}" alt="sitemap icon">
                </a>
            </div>


        </div>

    </div>

</div>


<!-- Header -->
<div class="container clearfix" id="b-header">
    <div class="float-left d-flex h-100">
        <img src="{{URL::asset('assets/template/images/emblem-dark.png')}}" class="align-self-center b-emblem-image" title="National Emblem of India" alt="emblem of india logo">
    </div>

    <div class="float-left d-flex h-100">
        <h2 class="align-self-center pl-3 b-appname"><span class="font-weight-bold">Assam Building & Other Construction Worker's Welfare Board</span><br><span class="b-appfullname" style="border-bottom: 2px solid #ffbf49;padding-bottom: 0.2em;font-size: 17px;">Social Security To Building & Other Construction Workers</span></h2>
    </div>
</div>

<style type="text/css">

    body{
        background-color: #f1f1f1;
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



    .card-title{
        background-image: url("/assets/template/images/frombannercopy.jpg");
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

    /*td {*/
    /*    border: 1px solid black;*/
    /*}*/



</style>

<!-- Global Navigation -->
	<div class="globalnav-bg">
		<div class="container">
			<nav class="navbar navbar-expand-sm navbar-dark px-0">
				<div class="d-flex w-100 b-nav-mobile">
					<button class="navbar-toggler align-self-center b-btn-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar" onclick="myFunction(this)">
						<span style="display:none;">Menu</span>
						<div>
						  <div class="bar1"></div>
						  <div class="bar2"></div>
						  <div class="bar3"></div>
						</div>
					</button>
					<!-- <button class="btn btn-outline-light align-self-center ml-auto b-btn-login" type="button" data-toggle="modal" data-target="#login-modal">
						Log In
					</button> -->
				</div>

				<div class="collapse navbar-collapse" id="collapsibleNavbar">
					<ul class="navbar-nav main-menu d-flex">
						<li class="nav-item d-block"> <a href="{{ url('/') }}" class="nav-link active">Home</a> </li>
						<li class="nav-item d-block"> <a href="inner.html" class="nav-link">About</a></li>
						<li class="nav-item d-block"> <a href="inner.html" class="nav-link">Progress Report</a></li>
						<li class="nav-item d-block"> <a href="contactus.html" class="nav-link">Contact Us</a></li>
						<li class="nav-item d-block ml-auto b-loginbut" data-toggle="modal" data-target="#login-modal">
							<!-- <a class="nav-link" href="javascript:void(0);">Log In</a> -->
							<button type="button" class="btn btn-outline-warning">LOG IN</button>
						</li>
					</ul>
				</div>

			</nav>
		</div>
	</div>
    <div class="mb-2"></div>
<div class="modal fade" id="login-modal" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header text-center d-block  border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                        data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->

            <div class="modal-body">
                <div class="col-md-12 mb-2 modal-image"
                     style="background-color:#bd362f; padding: 10px;color: whitesmoke;">
                    <h3>Please Note :</h3>
                    <p>Use Different tabs for different Stakeholders Login.</p>
                </div>
                <!--<form action="dashboard.html" autocomplete="off" method="POST">
      <div class="form-group">
       <label for="login-email">Email:</label>
       <input type="email" class="form-control" id="login-email" placeholder="Enter email" name="login-email">
      </div>
      <div class="form-group">
       <label for="login-pwd">Password:</label>
       <input type="password" class="form-control" id="login-pwd" placeholder="Enter password" name="login-pwd">
      </div>
      <div class="form-group form-check">
       <label class="form-check-label" for="login-rem">
        <input class="form-check-input" type="checkbox" id="login-rem" name="remember"> Remember me
       </label>
      </div>
      <p class="text-right b-notreg">Don't have an account? <a href="" data-toggle="modal" data-target="#signup-modal" data-dismiss="modal">Sign Up</a></p>
      <div class="text-center py-4">
       <button type="submit" class="btn btn-primary b-btn">Log In</button>
      </div>

     </form>-->
                <div class="login-tab">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#workerLogin">Worker Login</a>
                        </li>

                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content">
                    <div class="tab-pane container active" id="workerLogin">
                            <div id="workeruserloginmsg" class="text-danger"></div>
                            <div class="form-group mt-4">
                                <label for="phone_no" class="bold">Worker ID</label>
                                <input type="text" class="form-control" id="worker_id" placeholder="Enter Worker Id" name="worker_id" value="{{ old('worker_id') }}">
                                <span id="otp_sent_message"></span>


                            </div>

                            <div class="d-flex justify-content-center" id="get_otp_button">
                                <button type="button" id="get_otp" onclick="sendRenewalOtp()" class="get_button btn btn-primary"><i class="fas fa-sign-in-alt"></i>&nbspGenerate OTP</button>
                            </div>

                            <div class="" id="otp_form" style="display: none;">
                                <div class="form-group otp">
                                    <label for="phone_no" class="bold">Please Enter Otp</label>
                                    <div class="input-field-otp" id="input-field-otp-renew">
                                        <input type="number" id="otp_1" />
                                        <input type="number" id="otp_2" disabled />
                                        <input type="number" id="otp_3" disabled />
                                        <input type="number" id="otp_4" disabled />
                                        <input type="number" id="otp_5" disabled />
                                        <input type="number" id="otp_6" disabled />
                                    </div>

                                </div>

                                <div class="d-flex justify-content-center py-4">
                                    <button type="button" id="verify_otp" onclick="verifyRenewalOtp()" class="verify_button btn btn-primary"><i class="fas fa-sign-in-alt"></i>&nbspVerify OTP</button>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <p id="resend_timer"> Resend OTP in <span id="timer_1" class="text-success">180 </span> Seconds</p>
                                    <button type="button" id="resend_otp" class="resend_button btn btn-outlined-primary" style="display: none;" disabled>&nbspResend OTP</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
<script>
    function myFunction(x) {
        x.classList.toggle("change");
    }

         //    ********* otp login worker ********************

    const inputs = document.querySelectorAll(".input-field-otp input"),
        button = document.getElementById("verify_otp");
    // iterate over all inputs
    inputs.forEach((input, index1) => {
        input.addEventListener("keyup", (e) => {
            const currentInput = input,
                nextInput = input.nextElementSibling,
                prevInput = input.previousElementSibling;

            if (currentInput.value.length > 1) {
                currentInput.value = "";
                return;
            }

            if (nextInput && nextInput.hasAttribute("disabled") && currentInput.value !== "") {
                nextInput.removeAttribute("disabled");
                nextInput.focus();
            }

            if (e.key === "Backspace") {
                inputs.forEach((input, index2) => {
                    if (index1 <= index2 && prevInput) {
                        input.setAttribute("disabled", true);
                        input.value = "";
                        prevInput.focus();
                    }
                });
            }

            if (!inputs[5].disabled && inputs[5].value !== "") {
                button.classList.add("active");
                return;
            }
            button.classList.remove("active");
        });
    });

    //focus the first input which index is 0 on window load
    window.addEventListener("load", () => inputs[0].focus());


    function sendRenewalOtp() {
        worker_id = document.getElementById('worker_id');
        if (worker_id.value != null || worker_id.value != " ") {
            $.ajax({
                "url": 'worker/generate/otp',
                "method": 'POST',
                "data": {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "worker_id": worker_id.value,
                },
                "cache": false,
                "dataType": 'JSON',
                "processing": true,
                "serverside": true,
                success: function (res) {
                    if (res.status == false) {
                        $("#otp_sent_message").addClass('text-danger');
                        $("#otp_sent_message").html(res.error.worker_id[0]);
                        setTimeout(() => {
                            $("#otp_sent_message").fadeOut(2000);
                        }, 10000);
                    } else {
                        worker_id.setAttribute('disabled', true);
                        $("#otp_sent_message").addClass('text-success');
                        $("#otp_sent_message").html(res.message);
                        $("#resend_timer").show();
                        $("#resend_otp").hide();
                        $otpButton = document.getElementById("resend_otp");
                        $otpButton.setAttribute('disabled', true);
                        startTimer();
                        $("#get_otp").hide();
                        $("#otp_form").show();

                        setTimeout(() => {
                            $("#otp_sent_message").fadeOut(2000);
                        }, 10000);
                        alert(res.otp)
                    }

                },
                error: function (xhr) {
                    $('#workerregistermsg').html('');
                    $.each(xhr.responseJSON.errors, function (key, value) {
                        $('#workerregistermsg').append('<div class="alert alert-danger">' + value + '</div>');
                    });
                },


            });
        }

    }

    $("#get_otp").on("click", function () {
        sendOtp();
    })


    function startTimer() {
        var timeleft = 120;
        var downloadTimer = setInterval(function () {
            timeleft--;
            document.getElementById("timer_1").textContent = timeleft;
            if (timeleft == 0) {
                $("#resend_timer").hide();
                $("#resend_otp").show();
                $otpButton = document.getElementById("resend_otp");
                $otpButton.removeAttribute('disabled');
            } else if (timeleft < 0)
                clearInterval(downloadTimer);
        }, 1000);

    }


    $("#resend_otp").on('click', function () {
        sendOtp();
    })



    // Function to collect enabled OTP input values into a string
    function collectOTPValues() {
        const otpInputs = document.querySelectorAll('#input-field-otp-renew input');
        let otpValue = '';
        otpInputs.forEach(input => {
            if (!input.disabled) {
                otpValue += input.value;
            }
        });
        return otpValue;
    }




    function  verifyRenewalOtp() {
        const otpCode = collectOTPValues();
        verify_otp = document.getElementById('verify_otp');
        verify_otp.setAttribute('disabled', true);
        $.ajax({
            "url": 'worker/user-login',
            "method": 'POST',
            "data": {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "worker_id": worker_id.value,
                "otp": otpCode
            },
            "cache": false,
            "dataType": 'JSON',
            "processing": true,
            "serverside": true,
            success: function (res) {

                if (res.status == false) {

                    verify_otp.removeAttribute('disabled');
                    Swal.fire({
                        title: 'Verification Failed',
                        text: res.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                } else {
                    Swal.fire({
                        title: 'Login Successfull!',
                        text: 'OTP Verified',
                        icon: 'success',
                        showConfirmButton: false
                    });
                    setTimeout(() => {
                        // Replace 'your_redirect_url' with the URL where you want to redirect
                        window.location.href = res.redirect;
                    }, 2000);
                }

            },
            error: function (xhr) {
                $('#workerregistermsg').html('');
                $.each(xhr.responseJSON.errors, function (key, value) {
                    $('#workerregistermsg').append('<div class="alert alert-danger">' + value + '</div>');
                });
            },


        });


    };


//    *********End otp login worker ********************
</script>
