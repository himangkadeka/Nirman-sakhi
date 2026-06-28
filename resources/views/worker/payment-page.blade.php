@extends('layouts.user-app')

@section('title', 'Payment Page')

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
            font-size: 11px;
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


@section('content')
        {{--@include('partials.payment-navigate')--}}
    <div class="container-fluid mb-4">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-md-12">

                <nav class="custom-navbar navbar-light p-3" style="border-radius: 20px;">
                    <div class="custom-container">
                        <div class="custom-flex-container">
                            <div class="custom-left-content">
                                <h6 class="custom-heading">{{ trans('worker-registration/worker-payment-page.reg') }}
                                </h6>
                                <h6 class="custom-bold">
                                    <i
                                        class="custom-icon fas fa-file-alt pr-2"></i>{{ trans('worker-registration/worker-payment-page.appno') }}
                                    - {{ $application_no }}
                                </h6>
                            </div>
                            {{--                            <div class="custom-right-content"> --}}
                            {{--                                <h6 class="custom-heading"> --}}
                            {{--                                    <i class="custom-icon fas fa-clock"></i> Session Uptime - --}}
                            {{--                                </h6> --}}
                            {{--                            </div> --}}
                        </div>
                    </div>
                </nav>

                <div class="card mt-1">
                    <div class="card-body">
                        <div class="container">
                            <div class="card rounded-card">
                                <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center"
                                    style="background-color: #248f8f;">
                                    <span>
                                        <i class="fa fa-plus-circle"
                                            aria-hidden="true"></i>&nbsp;{{ trans('worker-registration/worker-payment-page.paymentdetails') }}

                                    </span>
                                </div>

                                <form action="" class="form-group form needs-validation">
                                    <div>
                                        <div class="d-flex justify-content-center p-4 payment-container">
                                            <div class="card fee">
                                                <div class="bg-light text-dark text-center p-2  mb-2">
                                                    {{ trans('worker-registration/worker-payment-page.feedetails') }}
                                                </div>
                                                <div class="table-responsive p-4">
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>{{ trans('worker-registration/worker-payment-page.description') }}
                                                                </th>
                                                                <th>{{ trans('worker-registration/worker-payment-page.amount') }}
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-info">
                                                                    {{ trans('worker-registration/worker-payment-page.description2') }}
                                                                </td>
                                                                <td class="text-danger">{{ $amount }}.00</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="card ml-4 payment">
                                                <div class="bg-light text-dark text-center rounded-top p-2 mb-3">
                                                    {{ trans('worker-registration/worker-payment-page.paymentdetails') }}
                                                </div>
                                                <div class="card-body">
                                                    <div class="d-flex mb-3">
                                                        <div class="mr-2">
                                                            <i class="fa fa-user"></i>
                                                        </div>
                                                        <div class="text-info">
                                                            {{ $getVaultData['name'] }}
                                                        </div>
                                                    </div>
                                                    <div class="d-flex mb-3">
                                                        <div class="mr-2">
                                                            <i class="fa fa-phone"></i>
                                                        </div>
                                                        <div class="text-info">
                                                            {{ $phone }}
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-between p-2 mb-4">
                                                        <div class="text-info mr-2">
                                                            {{ trans('worker-registration/worker-payment-page.totalfee') }}
                                                            :</div>
                                                        <div class="text-danger">Rs {{ $amount }}.00</div>
                                                    </div>

                                                    @if($pfc_details && $pfc_details->is_login_csc)
                                                        <a href="{{ route('payment.initiate', ['cscId' => $pfc_details->kiosk_registration_id]) }}"
                                                           onclick="event.preventDefault();
                                                                   fetch('{{ route('store.worker.session', ['workerId' => $worker_id]) }}')
                                                                   .then(() => window.location.href=this.href);"
                                                           class="btn btn-primary">
                                                            Pay using CSC Wallet
                                                        </a>
                                                    @else
                                                    <div class="d-flex justify-content-center">
                                                        <a href="{{ route('home.index') }}"
                                                            class="btn btn-sm btn-danger mr-2">{{ trans('worker-registration/worker-payment-page.cancel') }}</a>
                                                        @if ($time == false)
                                                            <button type="button" class="btn btn-sm btn-primary"
                                                                data-toggle="modal" data-target="#exampleModal"
                                                                id="pay_button">
                                                                {{ $payment_type }}
                                                                <i class="fa fa-check-circle"></i>
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-sm btn-primary "
                                                                id="payment_verify_button">
                                                                {{ trans('worker-registration/worker-payment-page.verifypayment') }}
                                                                <i class="fa fa-check-circle"></i>
                                                            </button>
                                                        @endif

                                                    </div>
                                                        @endif
                                                </div>
                                            </div>
                                        </div>
                                        {{--<a href="{{route('payment.initiate')}}" target="_blank" class="btn-primary">Pay using CSC Wallet</a>--}}
                                    </div>


                                </form>
                                @if ($time == true)
                                    @if ($disabled == true)
                                        <div class="d-flex justify-content-center mb-4">

                                            <span id="redirectTimer"
                                                style="display: none">{{ trans('worker-registration/worker-payment-page.verifypaymentafter') }}
                                                <span id="countdown">{{ $minute }}:{{ $seconds }}</span> sec
                                            </span>

                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div><!-- End Left side columns -->
            </div>
        </div>
    </div>

    <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    {{-- @if ($message = Session::get('success')) --}}
                    {{-- <a href="{{route('generate-uan',['id'=>encrypt($id)])}}" target="_blank" class="btn btn-success">Print Acknowledgement</a> --}}

                    {{-- @endif --}}
                </div>
            </div>
        </div>
    </div>
    {{-- @if ($time == false) --}}
    @if(!$pfc_details)
    @include('components.worker.payment.payment-initiation-form')

    @include('components.worker.payment.payment-verification-form')

     @endif
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center d-block bg-primary">
                    <h3 class="modal-title text-white " id="exampleModalLabel">
                        {{ trans('worker-registration/worker-payment-page.warning') }}</h3>


                </div>
                <div class="modal-body">
                    <h3 class="text-center">{{ trans('worker-registration/worker-payment-page.question') }} </h3>
                    <h6 class="text-danger mt-3 p-3">{{ trans('worker-registration/worker-payment-page.note') }}
                    </h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger"
                        data-dismiss="modal">{{ trans('worker-registration/worker-payment-page.no') }}</button>
                    <button type="button" id="payment-submit"
                        class="btn btn-primary">{{ trans('worker-registration/worker-payment-page.yes') }}</button>

                </div>
            </div>
        </div>
    </div>


@endsection


@section('footer')

    <script src="{{ URL::asset('assets/template/js/getVaultData.js') }}"></script>

    <script>
        $("#pay_button").on('click', function() {

            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ route('egrass-encrypt') }}",
                data: $("#payment-form").serialize(),
                success: function(response) {
                    if (response.status == true) {
                        console.log(response.results)
                        $("#enc_string").val(response.results)
                    } else {
                        alert(response.results)
                    }
                    errors / 404
                },
                error: function(xhr, status, error) {
                    console.error(response.results);
                }
            });
            console.log(plain_string);
        })
    </script>

    @if ($payment_type == 'Pay Now' && !$pfc_details)
        <script>
            $("#payment-submit").on('click', function() {

                event.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('egrass-initiate') }}",
                    data: {
                        "_token": $('meta[name="csrf-token"]').attr('content'),
                        "department_id": "{{ $department_id->DEPARTMENT_ID }}",
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status == true) {
                            var form = document.getElementById('payment-submit-form');
                            form.submit();
                        } else {
                            alert(response.results)
                        }

                    },
                    error: function(xhr, status, error) {
                        console.error(response.results);
                    }
                });

            })
        </script>
    @endif
    <script>
        // Clear browser history state and redirect to home if back button is used
        if (window.history && window.history.pushState) {
            window.history.pushState(null, '', window.location.href);
            window.onpopstate = function() {
                window.location.href = "{{route('submit-worker-payment')}}";
            };
        }
    </script>
    @if(!$pfc_details)
    <script>
        $("#payment_verify_button").on('click', function() {
            showLoader();
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ route('egrass-initiate') }}",
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    "department_id": "{{ $department_id->DEPARTMENT_ID }}",
                },
                success: function(response) {
                    console.log(response);
                    if (response.status == true) {
                        verify();
                    } else {
                        alert(response.results)
                    }

                },
                error: function(xhr, status, error) {
                    console.error(response.results);
                }
            });

            // console.log(plain_string);
        });


        function verify() {
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ route('egrass-encrypt-getcin') }}",
                data: $("#payment-verification-form").serialize(),
                success: function(response) {
                    if (response.status == true) {
                        console.log(response.results)
                        $("#enc_string_ver").val(response.results)
                        setTimeout(function() {
                            var form = document.getElementById(
                                'payment-verification-submit-form');
                            form.submit();
                        }, 2000);
                    } else {
                        alert(response.results)
                    }
                    errors / 404
                },
                error: function(xhr, status, error) {
                    console.error(response.results);
                }
            });
        }

        function showLoader() {
            document.querySelector('.loader-container').style.display = 'block';
        }


        // $("#payment-submit").on('click', function() {

        // })
    </script>
    @endif
    <script>
        function countdown() {
            var countdownElement = document.getElementById("countdown");
            var timeArray = countdownElement.innerText.split(':');
            var minutes = parseInt(timeArray[0], 10);
            var seconds = parseInt(timeArray[1], 10);

            if (minutes === 0 && seconds === 0) {
                // Redirect logic
                $("#payment_verify_button").attr('disabled', false);
                $("#redirectTimer").hide();
            } else {
                if (seconds === 0) {
                    minutes -= 1;
                    seconds = 59;
                } else {
                    seconds -= 1;
                }

                // Format the time as MM:SS
                var formattedTime = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;
                countdownElement.innerText = formattedTime;

                setTimeout(countdown, 1000);
            }
        }
    </script>

    @if ($time == true)

        @if ($disabled == true)
            <script>
                window.onload = function() {

                    var timer = document.getElementById("redirectTimer");
                    timer.style.display = "inline";
                    if (timer) {
                        countdown(); // Start the countdown immediately
                    }
                };
            </script>
            <script>
                $(document).ready(function() {
                    $("#payment_verify_button").attr('disabled', true);
                });
            </script>
        @endif
    @endif
@endsection

<script>
    (function() {
        // Push initial state so there's no "real" back
        window.history.pushState({
            noBackExitsApp: true
        }, '', window.location.href);

        window.onpopstate = function(event) {
            if (event.state && event.state.noBackExitsApp) {
                // Redirect to same page when back button is pressed
                window.location.replace("{{ url()->current() }}");
            }
        };
    })();
</script>
