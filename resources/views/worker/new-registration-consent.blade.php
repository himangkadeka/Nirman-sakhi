@extends('layouts.user-app')

@section('title', 'Worker')

@section('style')
    <style>
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

        /* Blur the background when the modal is open */
        .modal-backdrop {
            backdrop-filter: blur(50px);
            /* Increase the blur intensity */
            background-color: rgba(0, 0, 0, 0.8);
            /* Optional: darken the background */
        }

        /* Ensure modal is vertically centered */
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            /* Full screen height */
        }
        #question-2{display: flex;gap: 10px;}
        #question-2 .queAns, .sample-card{flex:1 1} .sample-card img{width: 100%}
        .queAns{
            flex: 1 1;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #question-2 .queAns, .sample-card{display: flex;flex-direction: column;border-right: 1px solid #ccc;position: relative}
        .cardTitle{position: absolute;
            top: 0;
            left: 50%;
            background: #145d82;
            color: white;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            /* height: 60px; */
            transform: translate(-50%, 10px);
            padding: 12px;
            border-radius: 2px;}
    </style>
@endsection


@section('content')
    <div class="container mb-4 mt-2" style="min-height: 500px">
        <div class="row justify-content-md-center">
            <div class="col-md-10 col-sm-10 col-xs-12">
                <div class="card mt-1">
                    <div class="card-body">
                        <div class="question-box">
                            <div class="card rounded-card">
                                <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center"
                                     style="background-color: #2badee;">
                                    <span>
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp; Construction
                                        Workers
                                        Form
                                    </span>
                                </div>

                                {{-- <div id="question-1" style="display: none">
                                    <div class="row justify-content-md-center mt-4">
                                        <p><strong> Are you already registered with Assam BOCW Board?</strong></p>
                                    </div>
                                    <div class="row justify-content-md-center mb-4 " id="beneficiary-answer">
                                        <button type="button" class="btn btn-success" id="questtion-1-yes"
                                                data-dismiss="modal">Yes</button>
                                        <a href="{{ route('new-auth-uidai-worker') }}" class="btn btn-danger ml-2"
                                           id="login-with-tempId">No</a>
                                    </div>
                                </div> --}}

                                {{-- <div id="question-2" style="display: none">
                                    <div class="queAns">
                                        <p><strong> Do you have the Assam BOCW ID card? (As per any of the format shown here)</strong></p> <br/>
                                        <div class="" id="beneficiary-answer">
                                            <button type="button" class="btn btn-success" id="question-2-yes"
                                                    data-dismiss="modal">Yes</button>
                                            <button class="btn btn-danger ml-2" data-dismiss="modal"
                                               id="login-with-tempId-ques2">No</button>
                                        </div>
                                    </div>
                                    <div class="sample-card">
                                        <img src="{{ asset('assets/template/images/demo2.jpg') }}" alt="Image 1">
                                        <img src="{{ asset('assets/template/images/bocw-sample-card.jpg') }}" alt="Image 1">
                                        <div class="cardTitle">Sample BOCW ID Card</div>
                                    </div>

                                </div> --}}
                            </div>

                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
        </div>
    </div>


    <!-- Modal -->
    {{-- <div class="modal fade" id="consentOnboarding" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"
        data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountDetailsLabel">Confirmation</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>You need to apply through the Onboarding registration process. Proceed to go to the Onboarding registration page.
                        </strong> </p>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('send-to-onboarding') }}" class="btn btn-primary">Proceed</a>
                </div>

            </div>
        </div>
    </div> --}}

    <div class="modal fade" id="popupMessage" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true"
        data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountDetailsLabel">Warning</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Please contact your Assam BOCW Office or Helpdesk for further guidance
                        </strong> </p>
                </div>
                <div class="modal-footer">
                    @if (session()->has('pfcData'))
                    <a href="https://sewasetu.assam.gov.in/iservices/myapplications/list" class="btn btn-primary">Okay</a>
                        @else
                        <a href="{{ route('home.index') }}" class="btn btn-primary">Proceed</a>
                    @endif
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="consentModal" tabindex="-1" role="dialog" aria-labelledby="accountDetailsLabel"
        aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountDetailsLabel">Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="padding: 5px;"><strong>The Board will consider the Aadhaar data to be final. Before you proceed, make sure that your
                            Aadhaar data, especially name and DOB (age) is correct. If not, please update your Aadhaar data,
                            and then apply.
                        </strong> </p>
                </div>
                <div class="modal-footer">
                    Do you want to proceed now?
                    <a href="{{ route('new-auth-uidai-worker') }}" class="btn btn-success" id="yes-button" data-dismiss="modal">Yes</a>
                    <a href="{{ route('home.index') }}" class="btn btn-danger" id="login-with-tempId">No</a>
                </div>

            </div>
        </div>
    </div>

@endsection
@if (Route::is('account.details'))
    <script src="{{ URL::asset('assets/template/js/getVaultData.js') }}"></script>
@endif

@section('footer')

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Open the modal on page load
            $('#consentModal').modal({
                backdrop: 'static', // Prevent close on outside click
                keyboard: false // Prevent close on Esc key
            }).modal('show');
        });

        $("#yes-button").on('click', function() {
            $('#consentModal').modal('hide');
            $("#question-1").show();
        })

        $("#questtion-1-yes").on('click', function() {
            $("#question-2").show();
            $("#question-1").hide();
        })

        $("#question-2-yes").on('click', function() {
            $('#consentOnboarding').modal('show');
        })

        $("#login-with-tempId-ques2").on('click', function() {
            $('#popupMessage').modal('show');
        })
    </script>


    <script src="{{ URL::asset('assets/template/js/sweetAlert.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/toastr.min.js') }}"></script>


    {{--    @if (session()->has('worker_id')) --}}
    {{--        <script> --}}
    {{--            Swal.fire({ --}}
    {{--                title: 'Worker Registered Successfully', --}}
    {{--                text: 'Note Down Your Temporary ID: {{ session('worker_id') }}', --}}
    {{--                icon: 'success', --}}
    {{--                confirmButtonText: 'OK' --}}
    {{--            }).then((result) => { --}}
    {{--                if (result.isConfirmed) { --}}
    {{--                    window.location.href = '{{ route('main-page') }}'; --}}
    {{--                } --}}
    {{--            }); --}}
    {{--        </script> --}}
    {{--    @endif --}}

    <script>
        var token = "{{ csrf_token() }}";
    </script>

@endsection
