@include('layout.workerheader')
@php
    use Carbon\Carbon;
@endphp
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



        .card-title {
            background-image: url("/assets/template/images/frombannercopy.jpg");
            height: 100px;
            background-repeat: no-repeat, no-repeat;
            background-position: center;
            text-align: center;
            color: white;
            /*width:;*/

        }

        .custom-navbar {
            border-bottom: 2px solid #eee;
        }

        .custom-container {
            max-width: 1200px;
        }

        .custom-flex-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .custom-left-content {
            display: flex;
            flex-direction: column;
        }

        .custom-heading {
            margin-bottom: 0.5rem;
        }

        .custom-bold {
            font-weight: bold;
        }

        .custom-icon {
            color: #007bff;
        }


        .table {
            font-size: 0.9rem;
            /* Smaller font size for table */
        }

        th,
        td {
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
            /* Header background color */
            color: #333;
            /* Header text color */
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
            /* Even row background color */
        }

        tbody tr:hover {
            background-color: #e9ecef;
            /* Hover row background color */
        }

        /*td {*/
        /*    border: 1px solid black;*/
        /*}*/
    </style>
@endsection


<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')
    <!-- Page Content -->
    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')
        <ul class="breadcrumb">
            <li><a href="{{ route('worker-dashboard') }}">Dashboard</a></li>
            <li>Subscription</li>
        </ul>


        <div class="container mt-5">
            <div id="print_content" class="card mt-2" style="border-top-left-radius: 12px; border-top-right-radius: 12px">
                <div class="card-body">
                    <h5>Payment Receipt Details</h5>
                    <div class="mt-5">
                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-check" aria-hidden="true"></i> Payment is Successful
                        </div>
                        <div class="mt-5">
                            <p>Dear <span class="font-weight-bold"> {{ $getVaultData['name'] }}</span>, You have
                                Successfully Paid the subscription fees</p>
                            <p>Phone No : {{ $wmf->phone_no }}</p>
                            <p>Transaction No : {{ $paymentDetails->PRN ? $paymentDetails->PRN : 'NA' }}</p>
                            <p>Transaction Date : {{ now() }}</p>
                            <p>GRN : {{ $paymentDetails->GRN ? $paymentDetails->GRN : 'NA' }}</p>
                            <p>Amount : Rs {{ $paymentDetails->GRN ? $paymentDetails->AMOUNT : '00' }}</p>
                            <p>Status : Paid</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center align-items-center mt-3 mb-3">
                {{-- <button id="" class="btn btn-success">Acknowledgement Page <i class="fa fa-forward" aria-hidden="true"></i></button> --}}
                <button id="payment-receipt" class="btn btn-warning ml-1">Download Payment Receipt<i
                        class="fa fa-print pl-2" aria-hidden="true"></i></button>

                <a href="{{route('worker-dashboard')}}" class="btn btn-success ml-1"><i
                            class="fa fa-undo pl-2" aria-hidden="true"></i>&nbsp;Return to Dashboard</a>
            </div>

        </div>


        <div class="d-flex justify-content-center mb-4" id="redirectDiv">
            @isset($pfcData)
                <span id="redirectTimer">Automatically Redirecting to Sewasetu Portal in <span id="countdown">5</span> sec
                    or <button type="button" id="redirectToPfc">Click Here to redirect</button></span>

                <form action="{{ $url }}" name="frm1" id="rtps-form" method="post" target="_blank"
                    style="display:none;">
                    <div class="form-container">
                        <div class="row">
                            <input type="hidden" id="data" name="data" value="{{ $encrypted_data }}">
                        </div>
                    </div>
                </form>
            @endisset


        </div>
    </div>
</div>
<!-- /#page-content-wrapper -->
</div>
@include('components.worker.payment.payment-receipt-initiation')

@include('layout.footer')
<script>
    function countdown() {
        var seconds = parseInt(document.getElementById("countdown").innerText, 10);
        if (seconds == 0) {
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


    $("#redirectToPfc").on('click', function() {
        submitFormtoRTPS()
    })


    function submitFormtoRTPS() {
        document.getElementById('redirectDiv').style.display = 'none';
        var form = document.getElementById('rtps-form');
        form.submit();
        @php
            session()->forget('pfcData');
        @endphp

    }
    $("#payment-receipt").on('click', function() {
        // showLoader();

        // Wait for one second, then hide the loader and submit the form
        setTimeout(function() {
            hideLoader();
            $("#payment-receipt-form").attr('target', '_blank').submit();
        }, 1000);
    })
    // $("#payment-receipt").on('click', function() {

    //     event.preventDefault();
    //     $.ajax({
    //         type: 'POST',
    //         url: "{{ route('egrass-receipt') }}",
    //         data: $("#payment-receipt-form").serialize(),
    //         success: function(response) {
    //             if (response.status == true) {
    //                 console.log(response.results)
    //                 $("#enc_string_rec").val(response.results)

    //                 // Show the loader
    //                 showLoader();

    //                 // Wait for one second, then hide the loader and submit the form
    //                 setTimeout(function() {
    //                     hideLoader();
    //                     $("#payment-receipt-submit-form").attr('target', '_blank').submit();
    //                 }, 1000);
    //             } else {
    //                 alert(response.results)
    //             }
    //         },
    //         error: function(xhr, status, error) {
    //             console.error(response.results);
    //         }
    //     });
    // })
</script>
