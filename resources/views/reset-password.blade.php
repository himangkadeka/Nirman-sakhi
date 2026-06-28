@extends('layouts.user-app')



@section('title', 'Forget Password')

@section('style')
    <style>
        .card-header {}

        .otp-inputs {
            display: flex;
            justify-content: space-between;
            width: 220px;
            /* Adjust as needed */
            margin-bottom: 20px;
            /* Add some space below the inputs */
        }

        .hidden {
            display: none;
        }

        .audio-control {
            cursor: pointer;
            font-size: 40px;
            /* Adjust the size of the icon */
            color: #333;
            /* Change the icon color */
        }

        .audio-control:hover {
            color: #007bff;
            /* Change the icon color on hover */
        }

        .timeframe {
            margin-top: 10px;
            font-size: 16px;
            color: #555;
        }

        .otp-input {
            width: 30px;
            /* Adjust width as needed */
            height: 40px;
            /* Adjust height as needed */
            text-align: center;
            font-size: 20px;
            margin-right: 5px;
            border: 1px solid #ccc;
            /* Light gray border */
            border-radius: 5px;
            /* Rounded corners */
            transition: border-color 0.3s, background-color 0.3s;
            /* Smooth transition for border and background */
        }

        .otp-input:focus {
            border-color: #007bff;
            /* Blue border on focus */
            background-color: #e7f0fe;
            /* Light blue background on focus */
            outline: none;
            /* Remove default outline */
        }

        .otp-input:last-child {
            margin-right: 0;
        }

        body {
            background-color: #f1f1f1;
        }

        * {

            font-family: "Roboto", sans-serif;

        }


        label.bold {
            font-weight: 600;
            font-family: "Roboto", sans-serif;
        }

        .btn-primary {
            background-color: #0f4547;
        }

        .toastify-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background-color: rgba(255, 255, 255, 0.7);
            animation: progressBar 3s linear forwards;
            /* Adjust duration to match the toast duration */
        }

        @keyframes progressBar {
            from {
                width: 100%;
            }

            to {
                width: 0%;
            }
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

        .modal-body {
            max-height: 400px;
            /* Adjust this value as needed */
            overflow-y: auto;
        }
    </style>
@endsection

@section('content')

    <div class="container mb-4 mt-4 ">
        <div class="row justify-content-md-center">
            <div class="col-md-8 col-sm-10 col-xs-12">
                <div class="card mt-1">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="card rounded-card">
                                <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center"
                                    style="background-color: #2badee;">
                                    <span>
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp; Reset Password
                                    </span>
                                </div>

                                <form action="{{route('password.reset-password')}}" method="POST">
                                    @csrf
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-md-12 px-5">
                                                <div class="form-group">
                                                    <label for="username_reset" class="bold">New Password <span
                                                            class="text-danger">*</span></label>
                                                    <input type="password" class="form-control" id="username_reset"
                                                        name="password" placeholder="Enter your password">

                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12 px-5" id="otp-inputs" >
                                                <div class="form-group">
                                                    <label for="otp" class="bold">Confirm Password <span
                                                            class="text-danger">*</span></label>
                                                    <input type="password"  class="form-control" id="otp-for-reset"
                                                        name="confirm_password" placeholder="Enter your otp">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row align-items-center">

                                            <div class="row">
                                                <div class="col-md-12 px-5 text-center">
                                                    <button type="submit" id="verify-otp-reset" class="btn btn-primary"><span
                                                            id="otp-text">Submit</span></button>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(document).ready(function() {
            $("#get-otp").click(function(event) {
                event.preventDefault();
                $("#get-otp").hide();
                sendOtp(0);
            });

            $("#resend_otp_reset").click(function(event) {
                event.preventDefault();
                $("#resend_otp_reset").hide();
                sendOtp(1);
            });


            function sendOtp(no) {
                // Prevent form submission
                $("#username_reset").attr('readonly', true);
                var username = $("#username_reset").val().trim(); // Trim to remove extra spaces

                if (username === " ") {
                    alert("Please enter your username");
                    if (no == 0) {
                        $("#get-otp").show();
                    } else {
                        $("#resend_otp_reset").show();
                    }
                    return; // Stop further execution
                }

                 // Hide the button after clicking

                $.ajax({
                    url: "{{ route('password.send-otp') }}",
                    type: "POST",
                    data: {
                        username: username,
                        _token: "{{ csrf_token() }}" // Include CSRF token for security
                    },
                    success: function(response) { // Show success message
                        $("#mobile_reset").html(response
                            .phone); // Show the last 6 digits of mobile number
                        $("#otp-reset-send-msg").show(); // Show the OTP sent message
                        $("#otp-inputs").show(); // Show the OTP input field

                        startOtpTimer(); // Start the timer for resend OTP
                    },
                    error: function(xhr, status, error) {
                        alert("Error sending OTP. Please try again."); // Show error message
                        console.log(xhr.responseText);
                        $("#get-otp").show(); // Show button again if there's an error
                    }
                });
            }
            // Prevent form submission
            function startOtpTimer() {
                $("#resend_timer_reset").show(); // Show the timer text
                var timer = 10; // 3 minutes
                var interval = setInterval(function() {
                    $("#timer_reset").text(timer);
                    timer--;

                    if (timer < 0) {
                        clearInterval(interval);
                        $("#resend_otp_reset").show(); // Enable resend OTP
                        $("#resend_timer_reset").hide();
                    }
                }, 1000);
            }


            $("verify-otp-reset").click(function(event) {
                event.preventDefault();
                var otp = $("#otp-for-reset").val().trim(); // Trim to remove extra spaces

                if (otp === "") {
                    alert("Please enter the OTP");
                    return; // Stop further execution
                }

                $.ajax({
                    url: "{{ route('password.verify-otp') }}",
                    type: "POST",
                    data: {
                        otp: otp,
                        _token: "{{ csrf_token() }}" // Include CSRF token for security
                    },
                    success: function(response) {
                        if (response.status == "true") {
                            alert("OTP verified successfully. You can now reset your password.");
                            window.location.href = "{{ route('password.reset') }}";
                        } else {
                            alert("Invalid OTP. Please try again.");
                        }
                    },
                    error: function(xhr, status, error) {
                        alert("Error verifying OTP. Please try again.");
                        console.log(xhr.responseText);
                    }
                });
            });

        });
    </script>
@endsection
