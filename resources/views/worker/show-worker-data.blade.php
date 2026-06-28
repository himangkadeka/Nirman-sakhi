@extends('layouts.user-app')

@section('title', 'Renewal')

@section('style')
    <style>
        .custom-bordered-box {
            border: 2px solid #dee2e6;
            padding: 20px;
            border-radius: 5px;
        }

        .custom-table {
            width: 100%;
        }

        .custom-table th,
        .custom-table td {
            padding: 10px;

        }

        .custom-table th {
            width: 20%;
            text-align: left;
        }

        .custom-table td {
            width: 30%;
        }

        ::placeholder {
            font-size: 15px;
            /* You can adjust the font size as needed */
            /* Additional styles if needed */
        }

        body {
            background-color: #f1f1f1;
        }

        * {

            font-family: "Roboto", sans-serif;

        }

        label.bold {
            font-weight: 600;
            font-family: "Poppins", sans-serif;

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

        /* Renewal Card Container */
        .card {
            border: 1px solid #dee2e6;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Card Header */
        .card-header {
            font-size: 1.1rem;
            font-weight: 600;
            border-bottom: 2px solid #007bff;
            padding: 0.75rem 1.25rem;
        }

        /* Table Enhancements */
        .table th,
        .table td {
            vertical-align: middle;
            font-size: 0.95rem;
            padding: 0.6rem;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .table td {
            background-color: #ffffff;
        }

        /* Image Styling */
        .img-thumbnail {
            border-radius: 0.5rem;
            border: 1px solid #6c757d;
            transition: transform 0.3s ease;
        }

        .img-thumbnail:hover {
            transform: scale(1.05);
        }

        /* Buttons */
        .btn-sm {
            font-size: 0.85rem;
            padding: 0.4rem 0.75rem;
            border-radius: 0.35rem;
            font-weight: 500;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* Text Colors */
        .text-success {
            font-weight: bold;
        }

        .text-danger {
            font-weight: bold;
        }

        .text-warning {
            font-weight: bold;
        }

        /* Center modal headers */
        .modal-header {
            background-color: #007bff;
            color: #fff;
            border-top-left-radius: 0.5rem;
            border-top-right-radius: 0.5rem;
        }

        /* Modal content styling */
        .modal-content {
            border-radius: 0.75rem;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

    </style>
@endsection


@section('content')
    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-md-12">
                <nav class="custom-navbar navbar-light p-3" style="border-radius: 20px;">
                    <div class="custom-container">
                        <div class="custom-flex-container">
                        </div>
                    </div>
                </nav>
                <div class="card  shadow-sm rounded">
                    <div class="card-header  text-dark d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fa fa-sync-alt mr-1"></i> Renewal Status
                        </div>
                        <div>
                            <i class="fa fa-id-card mr-1"></i> ID Card: <strong id="id_card_no">{{ $workerData->id_card }}</strong>
                        </div>

                    </div>

                    <div class="card-body">
                        <div class="row">
                            <!-- Photo Section -->
                            <div class="col-md-3 text-center">
                                <img src="data:image/jpeg;base64,{{ $aadhar_photo }}"
                                     alt="User Photo"
                                     class="img-thumbnail"
                                     style="width: 100%; max-width: 120px; height: auto;">
                            </div>

                            <!-- Details Section -->
                            <div class="col-md-9">
                                <table class="table table-sm mb-2">
                                    <tbody>
                                    <tr>
                                        <th>Card Status</th>
                                        <td style="color: {{ $cardStatus['color'] }}">{{ $cardStatus['message'] }}</td>
                                        <th>Membership Status</th>
                                        <td>
                                <span class="@if ($status === 'Active') text-success
                                             @elseif($status === 'Lapsed and suspended') text-warning
                                             @elseif($status === 'Lapsed and ceased' || $status === 'Lapsed') text-danger
                                             @else text-secondary @endif">
                                    {{ $status }}
                                </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Existing Card Validity Date</th>
                                        <td class="text-primary">{{ $id_card_validity_date }}</td>
                                        <th>Current ID Expires on</th>
                                        <td class="text-danger">{{ $id_card_validity_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Renewal Date</th>
                                        <td class="text-danger">{{ $renewal_date_n }}</td>
                                        <th>Worker Name</th>
                                        <td>{{ $getVaultData['name'] }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!-- Collapsible Section (below the table) -->
                                <div class="mt-2">
                                    <button class="btn btn-outline-secondary btn-sm" type="button" data-toggle="collapse" data-target="#additionalDetails" aria-expanded="false" aria-controls="additionalDetails">
                                        <i class="fa fa-info-circle"></i> Show Payment Details
                                    </button>

                                    <div class="collapse mt-2" id="additionalDetails">
                                        <div class="card card-body border border-primary">
                                            <h6 class="text-primary font-weight-bold mb-2">Additional Information</h6>
                                            <ul class="mb-0 pl-3">
                                                <li>
                                                    Subscription Payment Status:
                                                    <span class="{{ $isPaid == '1' ? 'text-success' : 'text-danger' }}">{{ $isPaid == '1' ? 'Paid' : 'Unpaid' }}</span>
                                                </li>
                                                <li>Total no of months for subscription : {{ \Carbon\Carbon::parse($subscription_validity)->diffInMonths(\Carbon\Carbon::parse($advancedPaymentDate)) }} months.</li>
                                                <li>Penalty: {{ $no_of_penalty_months }} months.</li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>


                            </div>

                            @php
                            $today = \Carbon\Carbon::today()->format('d-m-Y');
                            @endphp

                            <div class="row justify-content-center mt-3 mb-2">

                                <div class="col-auto">
                                    <a type="submit" href="{{ url('/') }}" class="btn btn-sm btn-danger"><i
                                            class="fa fa-undo" aria-hidden="true"></i>&nbsp;Exit</a>
                                    {{--<!--                             <button type="button" data-toggle="modal" data-target="#login-modal" onclick="proceedForRenewal('{{ $workerData->id_card }}')"--}}
                                                                        {{--class="btn btn-sm btn-primary"--}}
                                                                    {{--{{ $renewalDate > $today ? 'disabled' : '' }}>--}}
                                                                    {{--<i class="fa fa-check-circle" aria-hidden="true"></i>--}}
                                                                    {{--Proceed to Renewal--}}
                                                                {{--</button>  -->--}}

                                        <!-- <button type="button" class="btn btn-sm btn-primary"
                                            {{ $renewal_date_n != $today ? 'disabled' : '' }}
                                            data-toggle="modal" data-target="#renewModal">
                                            Proceed To Renewal <i class="fa fa-check-circle"></i>
                                        </button> -->
                                        <button type="button" class="btn btn-sm btn-primary"
                                            data-toggle="modal" data-target="#renewModal">
                                            Proceed To Renewal <i class="fa fa-check-circle"></i>
                                        </button>
                                    <button type="button" class="btn btn-sm btn-warning" {{$status === 'Active' ? 'disabled' : ''}} id="login-click" data-toggle="modal"
                                        data-target="#login-modal-renewal">
                                        Login <i class="fa fa-check-circle"></i>
                                    </button>

                                </div>

                                <div class="modal fade" id="login-modal-renewal">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">

                                            <!-- Modal Header -->
                                            <div class="modal-header text-center d-block  border-bottom-0">
                                                <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                                                <button type="button" class="close position-absolute"
                                                    style="right: 15px; top: 20px;" data-bs-dismiss="modal">&times;</button>
                                            </div>

                                            <!-- Modal body -->

                                            <div class="modal-body">


                                                <div class="login-tab">

                                                    <!-- Tab panes -->
                                                    <div class="tab-content">
                                                        <div class="tab-pane container active" id="workerLogin">
                                                            <div id="workeruserloginmsg" class="text-danger"></div>

                                                                <div class="form-group mt-4 text-centre">
                                                                    <label for="phone_no" class="bold">Worker ID
                                                                        Card</label>
                                                                    <input type="text" class="form-control"
                                                                        id="id_card_renew" placeholder="Please Enter ID Card"
                                                                        name="id_card" readonly value="{{ old('id_card') }}"
                                                                        autocomplete="off">
                                                                    <span id="otp_sent_message_renwal"></span>


                                                                </div>

                                                                {{-- <div class="d-flex justify-content-center"
                                                                    id="get_otp_button">
                                                                    <button type="submit" id="get_otp"
                                                                        class="get_button btn-sm btn btn-primary"><i
                                                                            class="fas fa-sign-in-alt"></i>&nbspGenerate
                                                                        OTP</button>
                                                                </div> --}}



                                                            <div class="" id="otp_form">
                                                                <div class="form-group otp">
                                                                    <label for="phone_no" class="bold">Please Enter
                                                                        Otp</label>
                                                                    <div class="input-field-otp">
                                                                        <input type="number" id="otp_1" />
                                                                        <input type="number" id="otp_2" disabled />
                                                                        <input type="number" id="otp_3" disabled />
                                                                        <input type="number" id="otp_4" disabled />
                                                                        <input type="number" id="otp_5" disabled />
                                                                        <input type="number" id="otp_6" disabled />
                                                                    </div>

                                                                </div>

                                                                <div class="d-flex justify-content-center py-4">
                                                                    <button type="button" id="verify_otp_renewal"
                                                                        class="verify_button_renewal btn btn-primary"><i
                                                                            class="fas fa-sign-in-alt"></i>&nbspVerify
                                                                        OTP</button>
                                                                </div>
                                                                <div class="d-flex justify-content-center">
                                                                    <p id="resend_timer_renewal"> Resend OTP in <span
                                                                            id="timer_1_renew" class="text-success">180
                                                                        </span> Seconds</p>
                                                                    <button type="button" id="resend_otp_renewal"
                                                                        class="resend_button btn btn-outlined-primary"
                                                                        style="display: none;" disabled>&nbspResend
                                                                        OTP</button>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>


                                <div class="modal fade" id="renewModal" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header text-center d-block">
                                                <h3 class="modal-title text-white " id="exampleModalLabel">Warning</h3>


                                            </div>
                                            <div class="modal-body">
                                                <h5 class="text-center">Do you want to renew ID Card? </h5>
                                                {{--                                        <h6 class="text-danger mt-3">Note: No changes can be made after the final Submission. Check all details carefully!</h6> --}}
                                            </div>
                                            <div class="modal-footer justify-content-center">
                                                <button type="button" class="btn btn-sm btn-danger"
                                                    data-dismiss="modal"><i class="fa fa-undo"
                                                        aria-hidden="true"></i>&nbsp;No</button>
                                                <a href="{{ route('workbook-details',['worker_id' => session('worker')->worker_id]) }}"
                                                    class="btn btn-sm btn-primary">Yes&nbsp;<i
                                                        class="fa fa-check-circle"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>




@endsection
@section('footer')

<script>
    $("#login-click").on('click', function(){
        var id = $("#id_card_no").html();
        console.log(id);
        $("#id_card_renew").val(id);
        event.preventDefault();
        $.ajax({
            type: 'POST',
            url: "{{route('auth.worker')}}",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                id_card: id,
            },
            success: function (res) {
                if (res.status === false) {

                    $("#otp_sent_message_renwal").addClass('text-danger');
                    $("#otp_sent_message_renwal").html(res.error.id_card[0]);
                    setTimeout(() => {
                        $("#otp_sent_message_renwal").fadeOut(2000);
                    }, 10000);
                } else {
                    // window.location.href = res.url;
                    id_card.setAttribute('disabled', true);
                    $("#otp_sent_message_renwal").addClass('text-success');
                    // $("#otp_sent_message_renwal").html(res.message);
                    $("#resend_timer_renewal").show();
                    $("#resend_otp_renewal").hide();
                    $otpButton = document.getElementById("resend_otp_renewal");
                    $otpButton.setAttribute('disabled', true);
                    startTimerRenwal();
                    // $("#get_otp").hide();
                    $("#otp_form").show();

                    setTimeout(() => {
                        $("#otp_sent_message_renwal").fadeOut(2000);
                    }, 10000);
                    // alert(res.otp)
                }

            },
            error: function (xhr) {
                $('#workerregistermsg').html('');
                $.each(xhr.responseJSON.errors, function (key, value) {
                    $('#workerregistermsg').append('<div class="alert alert-danger">' + value + '</div>');
                });
            },
        });
    })



function startTimerRenwal() {
    var timeleft = 120;
    var downloadTimer = setInterval(function () {
        timeleft--;
        document.getElementById("timer_1_renew").textContent = timeleft;
        if (timeleft == 0) {
            $("#resend_timer_renewal").hide();
            $("#resend_otp_renewal").show();
            $otpButton = document.getElementById("resend_otp_renewal");
            $otpButton.removeAttribute('disabled');
        } else if (timeleft < 0)
            clearInterval(downloadTimer);
    }, 1000);

}


$("#resend_otp_renewal").on('click', function () {
    const username = $("#id_card_no").html();
    sendOfficeorAdminOtp(username);
})


const otpInputsRenew = document.querySelectorAll('.input-field-otp input');
// Function to collect enabled OTP input values into a string
function collectOTPValues() {
    let otpValue = '';
    otpInputsRenew.forEach(input => {
        if (!input.disabled) {
            otpValue += input.value;
        }
    });
    return otpValue;
}




$("#verify_otp_renewal").on('click', function () {
    const otpCode = collectOTPValues();
    verify_otp = document.getElementById('verify_otp_renewal');
    verify_otp.setAttribute('disabled', true);
    $.ajax({
        "url": host + 'auth/verify-worker-otp',
        "method": 'POST',
        "data": {
            "_token": $('meta[name="csrf-token"]').attr('content'),
            "id_card": $("#id_card_no").html(),
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


});
</script>
@endsection
{{--    <script> --}}
{{--        $(document).ready(function() { --}}
{{--            $('#renewalBtn').on('click', function() { --}}
{{--                if (!$(this).attr('disabled')) { --}}
{{--                    $('#confirmationModal').modal('show'); --}}
{{--                } --}}
{{--            }); --}}

{{--            $('#confirmRenewalBtn').on('click', function() { --}}
{{--                // Proceed with the renewal action, e.g., redirect to another page or submit a form --}}
{{--                window.location.href = "{{ route('show-worker-data') }}"; --}}
{{--            }); --}}
{{--        }); --}}
{{--    </script> --}}
{{-- <script> --}}
{{--    function proceedForRenewal(id_card){ --}}
{{--    $("#id_card").val(id_card); --}}
{{--    $('#id_card').prop('disabled', true); --}}
{{-- } --}}


{{-- </script> --}}
<script src="{{ URL::asset('assets/template/js/getVaultData.js') }}"></script>
