@include('layout.workerheader')
@php
    use Carbon\Carbon;
@endphp
<style>

  body{
      font-family: 'Inter', sans-serif;
      background-color: #f4f7fa;
      font-size: 13px;
      font-weight: 400;
  }


    th,
    td {
        text-align: center;
    }
    /*.badge{*/
        /*font-size: 12px;*/
    /*}*/

    th {
        /*background-color: #f8f9fa;*/
        /* Header background color */
        /*color: #333;*/
        /* Header text color */

    }

    tbody tr:nth-child(even) {
        background-color: #f2f2f2;
        /* Even row background color */
    }

    tbody tr:hover {
        /*background-color: #e9ecef;*/
        /* Hover row background color */
    }
    .box{
        width: 100%;
        margin: 0px auto;
    }
</style>
<div class="d-flex" id="wrapper">
@include('worker.leftmenu')

<!-- Page Content -->
    <div id="page-content-wrapper">
    @include('components.worker.ui.navbar')

    <!-- Breadcrumb -->
        <ul class="breadcrumb"> <li><a href="{{ route('worker-dashboard') }}">Dashboard</a></li> <li>Subscription</li> <li>My Subscription</li> </ul>

        <div class="box">
            <div class="card rounded-card shadow border-0">

                <!-- Header -->
                <div class="card-header bg-primary border-bottom d-flex align-items-center">
                    <h5 class="mb-0 font-weight-bold text-white">
                       Subscription Details
                    </h5>
                </div>
                <div class="row mb-2">

                    <!-- Total Paid -->
                    <div class="col-md-4 mb-1">
                        <div class="card border-0 shadow-sm" style="background: linear-gradient(45deg, #28a745, #218838); border-radius: 10px;">
                            <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-dark-50">Total Paid</small>
                                    <div class="text-dark font-weight-bold" style="font-size: 16px;">
                                        ₹ {{ $subscription->where('payment_status', 1)->sum('amount_paid') ?? 0 }}
                                    </div>
                                </div>
                                <div class="text-dark" style="font-size: 22px; opacity: 0.7;">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pending -->
                    <div class="col-md-4 mb-1">
                        <div class="card border-0 shadow-sm" style="background: linear-gradient(45deg, #ffc107, #e0a800); border-radius: 10px;">
                            <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-dark-50">Pending</small>
                                    <div class="text-dark font-weight-bold" style="font-size: 16px;">
                                        ₹ {{ $subscription->where('payment_status', 0)->sum('amount_paid') ?? 0 }}
                                    </div>
                                </div>
                                <div class="text-dark" style="font-size: 22px; opacity: 0.6;">
                                    <i class="fas fa-clock"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Penalty -->
                    <div class="col-md-4 mb-1">
                        <div class="card border-0 shadow-sm" style="background: linear-gradient(45deg, #dc3545, #c82333); border-radius: 10px;">
                            <div class="card-body py-2 px-3 d-flex justify-content-between align-items-center">
                                <div>
                                    <small class="text-dark-50">Penalty</small>
                                    <div class="text-dark font-weight-bold" style="font-size: 16px;">
                                        ₹ {{ $subscription->sum('fine') ?? 0 }}
                                    </div>
                                </div>
                                <div class="text-dark" style="font-size: 22px; opacity: 0.7;">
                                    <i class="fas fa-exclamation-triangle"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="card-body">

                    @if ($subscription->isNotEmpty())
                        <div class="table-responsive">

                            <table class="table table-hover table-bordered text-center align-middle">

                                <!-- Table Head -->
                                <thead style="background: linear-gradient(45deg, #007bff, #0056b3); color: #fff;">
                                <tr>
                                    <th class="text-nowrap">Subscription(In Months)</th>
                                    <th class="text-nowrap">From Period</th>
                                    <th class="text-nowrap">To Period</th>
                                    <th class="text-nowrap">Subscription Fee</th>
                                    <th class="text-nowrap">Penalty</th>
                                    <th class="text-nowrap">Total Amount</th>
                                    <th class="text-nowrap">Payment Status</th>
                                    <th class="text-nowrap">Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach ($subscription as $sub)
                                    <tr style="transition: all 0.2s ease;">

                                        <td class="align-middle font-weight-bold text-dark">
                                            {{ $sub->month_paid }}
                                        </td>

                                        <td class="align-middle">
                                            <span class="text-primary font-weight-bold">
                                                {{ Carbon::parse($sub->from_period)->format('d-m-Y') }}
                                            </span>
                                        </td>

                                        <td class="align-middle">
                                            <span class="text-primary font-weight-bold">
                                                {{ Carbon::parse($sub->to_period)->format('d-m-Y') }}
                                            </span>
                                        </td>

                                        <td class="align-middle">
                                            <span class="text-info font-weight-bold" id="subscription">
                                                ₹ {{ $sub->total_amount }}.00
                                            </span>
                                        </td>

                                        <td class="align-middle">
                                            <span class="text-danger font-weight-bold">
                                                ₹ {{ $sub->fine ?? '0' }}.00
                                            </span>
                                        </td>

                                        <td class="align-middle">
                                            <span class="badge badge-success px-3 py-2">
                                                ₹ {{ $sub->amount_paid }}.00
                                            </span>
                                        </td>

                                        <td class="align-middle">
                                            @if ($sub->payment_status == '0')
                                                <span class="badge badge-danger px-3 py-2">
                                                    <i class="fas fa-clock mr-1"></i> In Progress
                                                </span>
                                            @elseif($sub->payment_status == '1')
                                                <span class="badge badge-primary px-3 py-2">
                                                    <i class="fas fa-check-circle mr-1"></i> Paid
                                                </span>
                                            @endif
                                        </td>

                                        <td class="align-middle text-center">
                                            @if(!$pfcData)
                                                @if ($sub->payment_status == 1)
                                                    <a class="btn btn-sm btn-outline-primary shadow-sm" target="_blank"
                                                       href="{{ route('download-payment-sub-pdf', ['id' => $sub->id]) }}">
                                                        <i class="fas fa-file-pdf mr-1"></i> Receipt
                                                    </a>
                                                @else
                                                    @if ($amount)
                                                        @if ($time == false)
                                                            <button type="button" class="btn btn-sm btn-primary shadow-sm"
                                                                    data-toggle="modal" data-target="#payConfModal"
                                                                    id="pay_button">
                                                                {{ $payment_type }} <i class="fas fa-check-circle ml-1"></i>
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-sm btn-warning shadow-sm"
                                                                    id="payment_verify_button">
                                                                Verify <i class="fas fa-check-circle ml-1"></i>
                                                            </button>
                                                        @endif
                                                    @endif
                                                @endif
                                            @else
                                                @if ($sub->payment_status == 1)
                                                    <a class="btn btn-sm btn-outline-primary shadow-sm" target="_blank"
                                                       href="{{ route('download-payment-sub-pdf', ['id' => $sub->id]) }}">
                                                        <i class="fas fa-file-pdf mr-1"></i> Receipt
                                                    </a>
                                                @else
                                                    <a href="{{ route('payment-s.initiate-s', [
                                                        'cscId' => $pfcData->kiosk_registration_id,
                                                        'worker_id' => $sub->worker_id
                                                    ]) }}"
                                                       class="btn btn-sm btn-success shadow-sm">
                                                        <i class="fas fa-wallet mr-1"></i> Pay using Wallet
                                                    </a>
                                                @endif
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                                </tbody>

                            </table>
                        </div>

                    @else
                        <div class="alert alert-info mb-0 shadow-sm">
                            <i class="fas fa-info-circle mr-2"></i> No Subscription data found!
                        </div>
                    @endif

                    @if ($time == true && $disabled == true && !$pfcData)
                        <div class="d-flex justify-content-center mt-3">
                            <div id="redirectTimer" class="alert alert-warning shadow-sm mb-0" style="display: none">
                                <i class="fas fa-clock mr-2"></i>
                                {{ trans('worker-registration/worker-payment-page.verifypaymentafter') }}
                                <span id="countdown" class="font-weight-bold text-danger">
                                    {{ $minute }}:{{ $seconds }}
                                </span> sec
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#wrapper -->
<!-- Signup Modal -->
<!--view application details-->
<div class="modal fade" id="signout-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center d-block p-5 border-bottom-0">
                <h3 class="modal-title">Sign Out?</h3>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                    data-dismiss="modal">&times;</button>
            </div>
            <!-- Modal body -->
            <div class="modal-body">
                <p class="text-center">Are you sure you want to Log Out?</p>
                <div class="text-center py-4">
                    <form action="{{ route('user-logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary b-btn mx-2">Sign Out</button>
                        <button class="btn btn-secondary mx-3" data-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if ($amount != 0 && !$pfcData)
    @include('components.worker.payment.payment-initiation-form')

    @include('components.worker.payment.payment-verification-form')
@endif

<div class="modal fade" id="payConfModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to proceed with the payment?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" id="payment-submit" class="btn btn-primary">Pay Now</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Welcome to the dashboard!</h5>
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
            </div>
        </div>
    </div>
</div>
<div class="loader-container" style="
    display:none;
    position: fixed;
    z-index: 99999;
    top:0;
    left:0;
    width:100%;
    height:100%;
    background: rgba(255,255,255,0.7);
">
    <div style="
        position:absolute;
        top:50%;
        left:50%;
        transform:translate(-50%, -50%);
    ">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
</div>
@include('components.footer')
<script>
    @if ($message = Session::get('success'))
        $(document).ready(function() {
            $('#successModal').modal({
                backdrop: 'static',
                keyboard: false
            }, 'show');

        });
    @endif
</script>
<script>
    $("#submitPayment").on('click', function() {
        // Open the modal for confirmation
        $('#confirmationModal').modal('show');
    });

</script>

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

@if ($payment_type == 'Pay Now' && !$pfcData)
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
@if (!$pfcData)
{{--<script>--}}

    {{--$("#payment_verify_button").on('click', function() {--}}
        {{--showLoader();--}}
        {{--event.preventDefault();--}}
        {{--$.ajax({--}}
            {{--type: 'POST',--}}
            {{--url: "{{ route('egrass-initiate') }}",--}}
            {{--data: {--}}
                {{--"_token": $('meta[name="csrf-token"]').attr('content'),--}}
                {{--"department_id": "{{ $department_id->DEPARTMENT_ID }}",--}}
            {{--},--}}
            {{--success: function(response) {--}}
                {{--console.log(response);--}}
                {{--if (response.status == true) {--}}
                    {{--verify();--}}
                {{--} else {--}}
                    {{--alert(response.results)--}}
                {{--}--}}

            {{--},--}}
            {{--error: function(xhr, status, error) {--}}
                {{--console.error(response.results);--}}
            {{--}--}}
        {{--});--}}

        {{--// console.log(plain_string);--}}
    {{--})--}}


    {{--function verify() {--}}
        {{--event.preventDefault();--}}
        {{--$.ajax({--}}
            {{--type: 'POST',--}}
            {{--url: "{{ route('egrass-encrypt-getcin') }}",--}}
            {{--data: $("#payment-verification-form").serialize(),--}}
            {{--success: function(response) {--}}
                {{--if (response.status == true) {--}}
                    {{--console.log(response.results)--}}
                    {{--$("#enc_string_ver").val(response.results)--}}
                    {{--setTimeout(function() {--}}
                        {{--var form = document.getElementById(--}}
                            {{--'payment-verification-submit-form');--}}
                        {{--form.submit();--}}
                    {{--}, 2000);--}}
                {{--} else {--}}
                    {{--alert(response.results)--}}
                {{--}--}}
                {{--errors / 404--}}
            {{--},--}}
            {{--error: function(xhr, status, error) {--}}
                {{--console.error(response.results);--}}
            {{--}--}}
        {{--});--}}
    {{--}--}}

    {{--function showLoader() {--}}
        {{--document.querySelector('.loader-container').style.display = 'block';--}}
    {{--}--}}


    {{--// $("#payment-submit").on('click', function() {--}}

    {{--// })--}}
{{--</script>--}}
<script>
    function showLoader() {
        const loader = document.querySelector('.loader-container');

        if (loader) {
            loader.style.display = 'block';
        }
    }

    function hideLoader() {
        const loader = document.querySelector('.loader-container');

        if (loader) {
            loader.style.display = 'none';
        }
    }

    $("#payment_verify_button").on('click', function(event) {

        event.preventDefault();

        showLoader();

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

                    hideLoader();
                    alert(response.results);
                }
            },

            error: function(xhr, status, error) {

                hideLoader();

                console.error(error);

                alert('Something went wrong');
            }
        });

    });


    function verify() {

        $.ajax({
            type: 'POST',
            url: "{{ route('egrass-encrypt-getcin') }}",
            data: $("#payment-verification-form").serialize(),

            success: function(response) {

                if (response.status == true) {

                    $("#enc_string_ver").val(response.results);

                    setTimeout(function() {

                        hideLoader();

                        var form = document.getElementById(
                            'payment-verification-submit-form'
                        );

                        form.submit();

                    }, 2000);

                } else {

                    hideLoader();

                    alert(response.results);
                }
            },

            error: function(xhr, status, error) {

                hideLoader();

                console.error(error);

                alert('Verification failed');
            }
        });
    }
</script>
@endif
@if (!$pfcData)
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
@endif

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

