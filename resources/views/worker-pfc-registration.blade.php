@extends('layouts.user-app')

@section('title','Verification')

@section('style')
    <style>

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
        .form-check-inline .form-check-input + .form-check-label {
            margin-left: 0.3rem; /* Adjust as necessary */
        }
        .custom-bordered-box {
            border: 2px solid #dee2e6;
            padding: 20px;
            border-radius: 5px;
        }
        .custom-table {
            width: 100%;
        }
        .custom-table th, .custom-table td {
            padding: 10px;
            border-bottom: 1px solid #dee2e6;
        }
        .custom-table th {
            width: 20%;
            text-align: left;
        }
        .custom-table td {
            width: 30%;
        }
    </style>
@endsection


@section('content')
    <div class="container-fluid mb-4 mt-2">
        <div class="row">
        {{--    <div class="col-md-2"></div>--}}
        <!-- Left side columns -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="heading-wrapper">
                            <h4 class="text-center font-weight-bold" style="color: #076f6b;">WORKER DETAILS</h4>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="" class="form-group form needs-validation" method="post" novalidate>

                            @csrf
                            <input type="hidden" name="worker_id" value="">
                            @if ($errors->has('worker_id'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <span><strong>{{ $errors->first('worker_id') }}</strong></span>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="row mt-3 mb-3">
                                <div class="col-md-12">
                                    <label class="d-block">Choose an option / এটা বিকল্প বাছক :</label>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input " type="radio" name="newreg" id="new-reg" value="1">
                                        <label class="form-check-label bold" for="inlineRadio1">New Registration / নতুন পঞ্জীয়ন</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="alreg" id="already-reg" value="2">
                                        <label class="form-check-label bold" for="inlineRadio2">Already Registered / ইতিমধ্যে পঞ্জীয়ন কৰা হৈছে ?</label>
                                    </div>

                                </div>

                            </div>
                            <div class="row mt-5">
                                <div class="col-md-6" id="registeredInput" style="display: none">
                                    <label for="registeredField" class=" text-center">আপোনাৰ আইডি কাৰ্ডৰ সবিশেষ প্ৰৱেশ কৰক</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control custom-bottom-border" id="registeredField" name="registeredField" placeholder="Enter ID Card Number" />
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-primary" type="button" id="verifyButtonEx">Proceed to form</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="custom-bordered-box mt-5">
                                <table class="custom-table">
                                    <tbody>
                                    <tr>
                                        <th>RTPS Reference No</th>
                                        <td>{{$data['rtps_trans_id']}}</td>
                                        <th>Contact No</th>
                                        <td>{{$data['mobile']}}</td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div class="form-row mt-3" id="aadhaarSection" style="display: none;">
                                <div class="form-group col-md-4">
                                    <label for="aadhaar" class="bold">Aadhaar Number</label><span class="text-danger">*</span>
                                    <div class="input-group">
                                        <input type="text" class="form-control custom-bottom-border" id="uidEx" name="uid" placeholder="Enter 12 Digit UID" maxlength="12" inputmode="numeric" pattern="\d*" />
                                        
                                        <div class="input-group-append">
                                            <button class="btn btn-sm btn-primary" type="button" id="verifyButtonEx">Generate OTP</button>
                                        </div>
                                    </div>
                                    <div id="spinner" style="display:none;">
                                        <i class="fa fa-spinner fa-spin" style="font-size:24px"></i> Generating OTP...
                                    </div>
                                </div>
                                <div class="form-group col-md-4" id="otpVerificationEx" style="display: none">

                                    <label for="" class="bold"> Successfully Generated One Time Password (OTP)</label>
                                    <input type="text" class="form-control custom-bottom-border" id="dynamicPinEx" name="dynamicPin" placeholder="Enter OTP">

                                </div>
                                <div class="form-group col-md-4 mt-4" id="submitBtnEx" style="display: none">
                                    <button type="button" class="btn btn-sm btn-success " id="submitOTPEx">Submit OTP&nbsp;<i class="fa fa-check-circle" aria-hidden="true"></i></button>
                                    <button type="button" class="btn btn-sm btn-secondary" id="resendOtpButtonEx" disabled>Resend OTP&nbsp;<i class="fa fa-refresh" aria-hidden="true"></i></button>
                                    <span id="otpTimerEx" class="ml-2"></span>
                                </div>

                            </div>

                            <div class="row justify-content-center mt-5">

                                <div class="col-auto">
                                    <a href="{{route('home.index')}}" class="btn btn-danger">Go Home</a>
                                </div>
                                <div class="col-auto">
                                    <a href="{{route('new-registration')}}" type="submit" id="proceed-btn" class="btn btn-success" style="display: none;">Proceed To Next</a>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div><!-- End Left side columns -->
        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">

                                <strong>{!! $message !!} </strong>

                            </div>

                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        {{--                @if ($message = Session::get('success'))--}}
                        {{--                    <a href="{{route('generate-uan',['id'=>encrypt($id)])}}" target="_blank" class="btn btn-success">Print Acknowledgement</a>--}}

                        {{--                @endif--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('footer')
    <script src="{{URL::asset('assets/template/js/sweetAlert.js')}}"></script>
    <script src="{{URL::asset('assets/template/js/toastr.min.js')}}"></script>
    <script>
        $(document).ready(function() {
            let otpInterval;
            $('#verifyButtonEx').click(function(event) {
                const uid = $('#uidEx').val();

                if (uid === '') {
                    toastr.error('Please enter UID.');
                    return;
                }

                $('#spinner').show();
                $('#verifyButtonEx').prop('disabled', true);

                $.ajax({
                    url: "{{ route('generate-aadhaar-otp') }}",
                    method: 'POST',
                    data: { uid: uid, _token: token },
                    success: function(response) {
                        $('#spinner').hide();
                        $('#verifyButtonEx').prop('disabled', false);
                        console.log('Encrypted data:', response);
                        if (response.status === '0') {
                            toastr.success('OTP has been sent to your mobile');
                            $('#otpVerificationEx').show();
                            $('#submitBtnEx').show();
                            $("#uid").prop("readonly", true);
                            $('#verifyButtonEx').hide();
                            startOtpTimer();
                        } else{
                            // Hide OTP input field if status is not 0
                            toastr.error('Something Went Wrong try again');
                            $('#otpVerificationEx').hide();

                        }
                    },
                    error: function(xhr, status, error) {
                        $('#spinner').hide();
                        $('#verifyButtonEx').prop('disabled', false);
                        console.error('Error:', error);

                        if (xhr.status >= 500) {
                            console.error('Server Error: An error occurred on the server, please try again later.');
                        } else {
                            console.error('Request Error:', error);
                        }
                    }
                });
            });

            //Aadhaar OTP Submit
            $('#submitOTPEx').click(function (event) {
                const dynamicPin = $('#dynamicPinEx').val();
                if (dynamicPin === '') {
                    // Show a toast message if the UID is empty
                    alert('Please enter OTP');
                }
                $.ajax({
                    url: "{{route('ekyc-aadhaar')}}",
                    method: 'POST',
                    data: { dynamicPin: dynamicPin, _token: token },
                    success: function(response) {
                        console.log('Encrypted data:', response);
                        if (response.errorCode === '000') {
                            toastr.success('Aadhaar Authentication Completed Successfully!');
                            $('#otpVerificationEx').hide();
                            $('#verifyButtonEx').hide();
                            $('#submitBtnEx').hide();
                            $('#saveBtnEx').show();
                            $("#uidEx").prop("readonly", true);
                        } else{
                            toastr.error('Aadhaar Authentication Failed!');
                            // Hide OTP input field if status is not 0
                            $('#otpVerificationEx').show();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);

                        if (xhr.status >= 500) {
                            console.error('Server Error: An error occurred on the server, please try again later.');
                        } else {
                            console.error('Request Error:', error);
                        }
                    }
                });

            });
            $('#resendOtpButtonEx').click(function(event) {
                $('#verifyButtonEx').click();
            });

            function startOtpTimer() {
                const duration = 3 * 60; // 3 minutes in seconds
                let timer = duration, minutes, seconds;

                otpInterval = setInterval(function() {
                    minutes = parseInt(timer / 60, 10);
                    seconds = parseInt(timer % 60, 10);

                    minutes = minutes < 10 ? "0" + minutes : minutes;
                    seconds = seconds < 10 ? "0" + seconds : seconds;

                    $('#otpTimerEx').text("Resend OTP in " + minutes + ":" + seconds);

                    if (--timer < 0) {
                        clearInterval(otpInterval);
                        $('#otpTimerEx').text("");
                        $('#resendOtpButtonEx').prop('disabled', false);
                    }
                }, 1000);

                $('#resendOtpButtonEx').prop('disabled', true);
            }

            // Make sure to clear the interval if the page is refreshed or navigated away from
            $(window).on('beforeunload', function() {
                clearInterval(otpInterval);
            });
        });

    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var registeredInput = document.getElementById('registeredInput');
            var proccedBtn = document.getElementById('proceed-btn');
            var newRegRadio = document.getElementById('new-reg');
            var alreadyRegRadio = document.getElementById('already-reg');

            newRegRadio.addEventListener('change', function() {
                if (this.checked) {
                    proccedBtn.style.display = 'block';
                    registeredInput.style.display = 'none';

                    if (alreadyRegRadio.checked) {
                        alreadyRegRadio.checked = false;
                    }
                }
            });

            alreadyRegRadio.addEventListener('change', function() {
                if (this.checked) {
                    registeredInput.style.display = 'block';
                    proccedBtn.style.display = 'none';
                    if (newRegRadio.checked) {
                        newRegRadio.checked = false;
                    }
                }
            });
        });
    </script>
{{--    <script>--}}
{{--        document.getElementById('dataCorrectCheckbox').addEventListener('change', function() {--}}
{{--            var aadhaarSection = document.getElementById('aadhaarSection');--}}
{{--            if (this.checked) {--}}
{{--                aadhaarSection.style.display = 'flex';--}}
{{--            } else {--}}
{{--                aadhaarSection.style.display = 'none';--}}
{{--            }--}}
{{--        });--}}
{{--    </script>--}}
    <script>
        var token = "{{ csrf_token() }}";
    </script>
@endsection
