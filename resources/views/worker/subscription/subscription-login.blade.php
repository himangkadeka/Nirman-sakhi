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

            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

        }


        label.bold {
            font-weight: 600;
            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

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
    <div class="container mb-4 mt-2">
        <div class="row justify-content-md-center">
            <div class="col-md-8 col-sm-10 col-xs-12">
                <div class="card mt-1">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="card rounded-card">
                                <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center"
                                    style="background-color: #248f8f;">
                                    <span>
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;ID Card Details
                                    </span>
                                </div>

                                <div class="row justify-content-md-center">
                                    <form class="form-group" id="new-registration-form"
                                        action="{{ route('save-phone-no') }}" method="post">
                                        @csrf
                                        <div class="container">
                                            <div class="col-md-12">
                                                <label class="control-label" for="phone_no">Phone Number<span
                                                        class="text-danger" style="font-size:1.5em">*</span></label>
                                                <div class="input-group">
                                                    @php
                                                        $isReadonly = session()->has('pfcData');
                                                        $pfc_data = $isReadonly ? session()->get('pfcData') : '';
                                                        $mobileValue = $isReadonly ? $pfc_data->mobile : '';
                                                    @endphp
                                                    <input type="text" class="form-control custom-bottom-border"
                                                        id="phone_no" name="phone_no"
                                                        placeholder="{{ trans('worker-registration/worker_new_registration.enter_contact') }}"
                                                        maxlength="10" inputmode="numeric" pattern="\d*"
                                                        value="{{ $mobileValue }}" {{ $isReadonly ? 'readonly' : '' }} />
                                                    {{-- <div class="input-group-append">
                                                        <button class="btn btn-sm btn-warning checkAccount" type="button">Check
                                                            Record</button>
                                                    </div> --}}
                                                </div>
                                                <p class="error text-danger" id="phone_noError"></p>
                                                @if ($errors->has('phone_no'))
                                                    <span
                                                        class="text-warning font-weight-normal">{{ $errors->first('phone_no') }}</span>
                                                @endif
                                            </div>

                                        </div>
                                        @if (isset($id_cardDatas))
                                            <div class="col-md-12" id="accounts-dropdown-container">
                                                <label for="accounts-radio">Select Your ID card:</label>
                                                {{--<div id="accounts-radio-container" class="worker_id"></div>--}}
                                            </div>
                                        @else
                                            <span class="badge badge-danger">No Id Card Found</span>
                                        @endif



                                        <hr>
                                        <div class="container text-centre">
                                            @foreach ($id_cardDatas as $id_cardData)
                                                <table>
                                                    <tr class="mt-2">

                                                        <td>{{ $id_cardData->id_card }}</td>
                                                        <td>
                                                            <a href="javascript:void(0);"
                                                               onclick="viewDetails('{{ $id_cardData->id_card }}')"
                                                               class="text-primary fw-bold"
                                                               style="text-decoration:none;">
                                                                🔍 View Details
                                                            </a>
                                                        </td>

                                                        {{-- <td><button type="button" class="btn btn-primary" onclick="getSubscriptionLoginOtp('{{ $id_cardData->id_card }}')" >Get Otp</button></td> --}}
                                                    </tr>
                                                </table>
                                            @endforeach
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
        </div>
    </div>

    <div class="modal fade" id="worker-login-to-portal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header text-center d-block  border-bottom-0">
                    <h5 class="modal-title" id="exampleModalLabel">Login</h5>
                    <button type="button" class="close position-absolute" style="right: 15px; top: 20px;"
                        data-bs-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->

                <div class="modal-body">
                    <div class="tab-pane container active" id="workerLogin">
                        <div id="workeruserloginmsg_subscription" class="text-danger"></div>
                        <form id="worker-subscription-login" action="{{ route('auth.worker') }}" method="POST">
                            @csrf
                            <div class="form-group mt-4">
                                <label for="phone_no" class="bold">Worker ID Card</label>
                                <input type="text" class="form-control" id="id_card_no_to_display"
                                    placeholder="Please Enter ID Card" name="id_card" readonly>
                                <span id="otp_sent_message_subscription"></span>


                            </div>
                        </form>


                        <div class="" id="otp_form_subscription">
                            <div class="form-group otp">
                                <label for="phone_no" class="bold">Please Enter Otp</label>
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
                                <button type="button" id="verify_otp_subscription" onclick="verifyOtpSubscription()"
                                    class=" btn btn-primary"><i class="fas fa-sign-in-alt"></i>&nbspVerify OTP</button>
                            </div>
                            <div class="d-flex justify-content-center">
                                <p id="resend_timer_subscription"> Resend OTP in <span id="timer_subscription"
                                        class="text-success">180 </span>
                                    Seconds</p>
                                <button type="button" id="resend_otp_subscription"
                                    class="resend_button btn btn-outlined-primary" style="display: none;"
                                    disabled>&nbspResend OTP</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->



    <div class="modal fade" id="accountDetailsModal" tabindex="-1" role="dialog"
        aria-labelledby="accountDetailsLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="accountDetailsLabel">Account Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>ID Card:</strong> <span id="idCard"></span></p>
                    <p><strong>Name:</strong> <span id="modalApplicationName"></span></p>
                    {{-- <p><strong>Care Of:</strong> <span id="modalApplicationCareOf"></span></p> --}}
                    {{-- <p><strong>Phone:</strong> <span id="modalAccountPhone"></span></p> --}}
                    {{-- <p><strong>Created At:</strong> <span id="modalAccountEmail"></span></p> --}}
                    <input type="hidden" id="hiddenidCard" value="">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="closeModalButton"
                        data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="subScriptionOtp">Login with OTP</button>
                </div>

            </div>
        </div>
    </div>

@endsection
@if (Route::is('account.details'))
    <script src="{{ URL::asset('assets/template/js/getVaultData.js') }}"></script>
@endif

@section('footer')



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

        function viewDetails(idCard) {
            var idCard = idCard;
            $.ajax({
                url: "{{ route('sewasetu.accountDetails') }}",
                type: 'post',
                data: {
                    id_card: idCard,
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    if (response.status === true) {
                        // console.log(response)
                        $('#idCard').text(idCard);
                        $('#modalApplicationName').text(response.results.name);
                        // $('#spinner-old').show();
                        $("#hiddenidCard").val(idCard);
                        $('#accountDetailsModal').modal('show');
                        // $('#spinner-old').hide();
                    } else {
                        alert('Account details not found.');
                    }
                }
            });
        }


        $("#subScriptionOtp").on('click', function() {
            $('#accountDetailsModal').modal('hide');
            var idCard = $("#hiddenidCard").val();
            $("#id_card_no_to_display").val(idCard);
            $("#worker-login-to-portal").modal({
                backdrop: 'static',
                keyboard: false
            }).modal('show');
            $.ajax({
                type: 'POST',
                url: host + 'auth/worker',
                data: {
                    "_token": $('meta[name="csrf-token"]').attr('content'),
                    id_card: idCard,
                },
                success: function(res) {
                    console.log(res)
                    if (res.status === false) {

                        $("#otp_sent_message_subscription").addClass('text-danger');
                        $("#otp_sent_message_subscription").html(res.error.id_card[0]);
                        setTimeout(() => {
                            $("#otp_sent_message_subscription").fadeOut(2000);
                        }, 10000);
                    } else {
                        // window.location.href = res.url;
                        id_card.setAttribute('disabled', true);
                        $("#otp_sent_message_subscription").addClass('text-success');
                        $("#otp_sent_message_subscription").html(res.message);
                        $("#resend_timer_subscription").show();
                        $("#resend_otp_subscription").hide();
                        $otpButton = document.getElementById("resend_otp_subscription");
                        $otpButton.setAttribute('disabled', true);
                        startTimerSubscription();
                        // $("#get_otp").hide();
                        $("#otp_form_subscription").show();

                        setTimeout(() => {
                            $("#otp_sent_message_subscription").fadeOut(2000);
                        }, 10000);
                        // alert(res.otp)
                    }

                },
                error: function(xhr) {
                    $('#workeruserloginmsg_subscription').html('');
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        $('#workeruserloginmsg_subscription').append(
                            '<div class="alert alert-danger">' + value + '</div>');
                    });
                },
            });
        })
    </script>

@endsection
