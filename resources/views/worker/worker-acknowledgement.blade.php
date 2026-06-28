@extends('layouts.user-app')

@section('title', ' Home')

@section('style')
    <style type="text/css">
        body {
            background-color: #f1f1f1;
        }

        * {

            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

        }

        label.bold {
            font-weight: 600;
            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

        }

        .btn-primary {
            background-color: #0f4547;
        }

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

        .card {
            -webkit-box-shadow: -2px 2px 0px 1px rgba(15, 58, 71, 1);
            -moz-box-shadow: -2px 2px 0px 1px rgba(15, 58, 71, 1);
            box-shadow: -2px 2px 0px 1px rgba(15, 58, 71, 1);

        }

        /*box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;*/
    </style>

@endsection


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="card mt-5">
                    <div class="card-body">
                        <div class="" id=""
                            style="display:flex; flex-direction:column; justify-content:center; align-items:center ">
                            <div class="float-left d-flex h-100">
                                <img src="{{ URL::asset('assets/template/images/emblem-dark.png') }}"
                                    class="align-self-center b-emblem-image" title="National Emblem of India"
                                    alt="emblem of india logo">
                            </div>

                            <div class="float-left d-flex h-100">
                                <h2 class="align-self-center pl-3 b-appname"><span class="font-weight-bold">Assam Building &
                                        Other Construction Worker's Welfare Board </span></h2>
                            </div>
                        </div>
                        <div class="text-center mt-4">
                            <p>Dear <span class="font-weight-bold">{{ $getVaultData['name'] }}</span>, Your application has
                                been submitted successfully and forwarded to Registering Officer at <span
                                    class="text-danger font-weight-bold">{{ $mwf->office_name }}</span>.</p>
                            <h5 class="justify-content-center">Acknowledgement Number: &nbsp;<span
                                    class="font-weight-bold">{{ $worker->ack_no }}</span></h5>
                        </div>
                        <div class="mt-3" style="display:flex; justify-content:center">
                            {{-- @if (!empty($aadharPhoto))
                            <img src="data:image/jpeg;base64,{{ $aadharPhoto }}" alt="User Photo" height="150px" width="150px">
                            @else
                            <p>No photo available.</p>
                            @endif --}}
                        </div>
                        <div class="mt-4 " style="display: flex;">
                            <p>
                                <span class="">Application Number: <span
                                        class="text-danger">{{ $worker->application_no }}</span></span><br>
                                <span class="">Registering Office: <span
                                        class="text-danger">{{ $mwf->office_name }}</span></span><br>
                                <span>Applicant Name: <span
                                        class="text-danger">{{ $getVaultData['name'] }}</span></span><br>

                                <span>Phone: <span class="text-danger">{{ $mwf->phone_no }}</span></span><br>
                                @php
                                    use Carbon\Carbon;
                                @endphp

                                <span>Receipt Date: <span class="text-danger">{{ Carbon::parse($mfb->created_at)->format('d-m-Y H:i:s') }}</span></span><br>

                                <span>Payment Status: <span
                                        class="text-danger">{{ $mwf->payment_status }}</span></span><br>
                            </p>
                        </div>
                        <div class="text-center">
                            {{--                        <h4 class="justify-content-center">Your Acknowledgement Id is: &nbsp;<span class="font-weight-bold">{{$worker->ack_no}}</span></h4> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-center">
            <a href="{{ route('return-home-new') }}" class="btn btn-danger mt-3 mb-3">
                <i class="fa fa-undo" aria-hidden="true"></i>&nbsp;Return to Homepage
            </a>
            &nbsp;
            <a href="{{ route('download-ack-pdf') }}" target="_blank" class="btn btn-success mt-3 mb-3">Download
                Acknowledgement Receipt<i class="fa fa-print pl-2" aria-hidden="true"></i></a>
            {{-- <a href="{{route('download-payment-pdf')}}"  class="btn btn-warning mt-3 mb-3 ml-1">Download Payment Receipt<i class="fa fa-print pl-2" aria-hidden="true"></i></a> --}}
            @if ($worker->already_payment_status==false && !$pfcData)
            <button type="button" id="payment-receipt" class="btn btn-warning mt-3 mb-3 ml-1">Download Payment Receipt<i
                    class="fa fa-print pl-2" aria-hidden="true"></i></button>
            @endif

        </div>

        <div class="d-flex justify-content-center mb-4" id="redirectDiv">
            @if($pfcData)
                <span id="redirectTimer">Automatically Redirecting to Sewasetu Portal in <span id="countdown">15</span> sec
                    or <button type="button" id="redirectToPfc">Click Here to redirect</button></span>
            @endif

        </div>
    </div>
    @if(!$pfcData)
    @if ($worker->already_payment_status==false && $revert_back == 0)
    @include('components.worker.payment.payment-receipt-initiation')
    @endif
    @endif

    @if (session()->has('pfcData'))
        <form action="{{ $url }}" name="frm1" id="rtps-form" method="post" style="display:none;">
            <div class="form-container">
                <div class="row">
                    <input type="hidden" id="data" name="data" value="{{ $encrypted_data }}">
                </div>
            </div>
        </form>
        @else
    @endif

@endsection


@section('footer')

    <script>
        function countdown() {
            var seconds = parseInt(document.getElementById("countdown").innerText, 10);
            if (seconds === 0) {
                // Redirect logic
                submitFormtoRTPS()
            } else {
                document.getElementById("countdown").innerText = seconds - 1;
                setTimeout(countdown, 1000);
            }
        }

        window.onload = function() {
            var timer = document.getElementById("redirectTimer");
            if (timer) {
                setTimeout(countdown, 1000);
            }
        };

        // Handle manual redirection button click
        document.getElementById("redirectToPfc").onclick = function() {
            submitFormtoRTPS()
        };


        function submitFormtoRTPS() {
            document.getElementById('redirectDiv').style.display = 'none';
            var form = document.getElementById('rtps-form');
            form.submit();
            @php
                session()->forget('pfcData');
            @endphp

        }
    </script>

    <script>
        $("#payment-receipt").on('click', function() {
            showLoader();

            // Wait for one second, then hide the loader and submit the form
            setTimeout(function() {
                hideLoader();
                $("#payment-receipt-form").attr('target', '_blank').submit();
            }, 1000);
        })
    </script>

@endsection
