@extends('layouts.user-app')

@section('title', ' Home')

@section('style')
    <style>
        body {
            background-color: #f1f1f1;
        }

        * {

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
        }

        .custom-bold {
            font-weight: bold;
        }

        .custom-icon {
            color: #007bff;
        }
    </style>
@endsection


@section('content')

    @include('components.multistep')
    <div class="container-fluid mb-4">
        <div class="col-md-12">
            <nav class="custom-navbar navbar-light">
                <div class="custom-container">
                    <div class="custom-flex-container">
                        <div class="custom-left-content">
                            @include('components.session-timeout')
                        </div>

                    </div>
                </div>
            </nav>
            <div class="card mt-1">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <span>
                                <i class="fa fa-user" aria-hidden="true"></i>
                                {{ trans('worker-registration/worker-family-details.workername') }}
                                - {{ $getVaultData['name'] }}
                            </span>
                        </div>
                        <div class="card rounded-card">
                            <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center"
                                style="background-color: #2badee;">
                                <span>
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i> Update Bank Details&nbsp; (Application No -
                                {{ $formdata->application_no }})
                                </span>

                            </div>
                            <div class="mr-2 mt-3 ml-2"
                                style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                <p style="margin: 0;">
                                    <strong>{{ trans('worker-registration/worker-bank-details.note') }}:</strong>
                                </p>
                                <p style="margin: 0;">
                                    <strong>1.</strong><span class="text-danger"> {{ trans('worker-registration/worker-bank-details.mandatory') }}</span>
                                </p>
                                <p style="margin: 0;">
                                    <strong>2.</strong><span class="text-danger"> {{ trans('worker-registration/worker-bank-details.mandatory2') }}</span>
                                </p>
                            </div>

                            <div class="form-row mt-4 ml-2 d-flex align-items-center">
                                <div class="col-auto">
                                    <label for="ifsc" class="form-label mr-1">{{ trans('worker-registration/worker-bank-details.ifsccode') }} <span style="color:red;"></span></label>
                                </div>
                                <div class="col-auto">
                                    <input type="text" class="search-input custom-bottom-border form-control uc-text-smooth mr-1" name="ifsc" id="ifsc" value="{{$formdata->ifsc_code}}" maxlength="11" placeholder="Enter IFSC Code" />
                                </div>
                                <div class="col-auto">
                                    <input type="button" value="Search Bank Details" id="populateBank" class="btn-sm btn-info proceed" />
                                </div>
                            </div>
                            <form action="{{ route('update-bank-details') }}" id="bankForm" class="form-group ml-2 mr-2"
                                method="post">
                                @csrf
                                {{--                        <input type="hidden" name="worker_id" value="{{$formdata->worker_id}}" > --}}
                                <input type="hidden" name="ifsc_pk" class="bank" id="ifsc_pk" value="000">
                                <input type="hidden" name="ifsc_code" class="bank" id="ifsc_code" value="{{$formdata->ifsc_code}}">

                                <div class="form-row mt-3"><!--start 1-->
                                    <div class="form-group col-md-4">
                                        <label for="inputBank">{{ trans('worker-registration/worker-bank-details.bankname') }}</label><span
                                            style="color:red;">*</span>
                                        <input type="text" class="form-control custom-bottom-border uc-text-smooth bank"
                                            id="bank_name" value="{{ $formdata->bank_name }}" name="bank_name"
                                            placeholder="{{ trans('worker-registration/worker-bank-details.enterbankname') }}" readonly>
                                        @if ($errors->has('bank_name'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('bank_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputBranch">{{ trans('worker-registration/worker-bank-details.branch') }}</label><span
                                            style="color:red;">*</span>
                                        <input type="text" class="form-control custom-bottom-border uc-text-smooth bank"
                                            id="branch_name" value="{{ $formdata->branch_name }}" name="branch_name"
                                            placeholder="{{ trans('worker-registration/worker-bank-details.enterbranchname') }}" readonly>
                                        @if ($errors->has('branch_name'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('branch_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputBankAddress">{{ trans('worker-registration/worker-bank-details.bankaddress') }}</label><span
                                            style="color:red;">*</span>
                                        <input type="text" class="form-control custom-bottom-border uc-text-smooth bank"
                                            id="bank_address" name="bank_address" value="{{ $formdata->bank_address }}"
                                            placeholder="{{ trans('worker-registration/worker-bank-details.enterbankaddress') }}" readonly>
                                        @if ($errors->has('bank_address'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('bank_address') }}</span>
                                        @endif
                                    </div>
                                </div><!--end-->
                                <div class="form-row mt-3"><!--start 1-->

                                    <div class="form-group col-md-4">
                                        <label for="inputAcc">{{ trans('worker-registration/worker-bank-details.accountnumber') }}</label><span
                                            style="color:red;">*</span>
                                        <input type="text" class="form-control custom-bottom-border" id="account_no"
                                            name="account_no" value="{{ $formdata->account_no }}" maxlength="20"
                                            placeholder="{{ trans('worker-registration/worker-bank-details.enteraccountnumber') }}">
                                        <span id="account_noError" class="error-message text-danger"></span>
                                        @if ($errors->has('account_no'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('account_no') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputAge">{{ trans('worker-registration/worker-bank-details.confirmaccountnumber') }}</label><span
                                            style="color:red;">*</span>
                                        <input type="text" class="form-control custom-bottom-border"
                                            id="account_no_confirmation" value="{{ $formdata->account_no }}"
                                            maxlength="20" placeholder="{{ trans('worker-registration/worker-bank-details.enterconfirm') }}"
                                            name="account_no_confirmation">
                                        <span id="accError" class="error"></span>
                                        @if ($errors->has('account_no_confirmation'))
                                            <span
                                                class="text-danger font-weight-normal error-message">{{ $errors->first('account_no_confirmation') }}</span>
                                        @endif
                                    </div>
                                </div><!--end-->
                                <div class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                                    <div class="ml-auto d-inline-block align-self-center mr-2">
                                        <a type="submit" href="{{ route('submit-basic-details') }}"
                                            class="btn btn-sm btn-warning"><i class="fa fa-backward"
                                                aria-hidden="true"></i>&nbsp;
                                                {{ trans('worker-registration/worker-bank-details.prevoius') }}</a>
                                        <button type="submit" class="btn btn-sm btn-primary"><i
                                                class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;
                                                {{ trans('worker-registration/worker-bank-details.updatebankaddress') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div><!-- End Left side columns -->
        </div>
    </div>

@endsection


@section('footer')

    <script src="{{ URL::asset('assets/template/js/jquery-3.7.0.js') }}"></script>
    <script>
        const forceKeyPressUppercase = (e) => {
            let el = e.target;
            let charInput = e.keyCode;
            if ((charInput >= 97) && (charInput <= 122)) { // lowercase
                if (!e.ctrlKey && !e.metaKey && !e.altKey) { // no modifier key
                    let newChar = charInput - 32;
                    let start = el.selectionStart;
                    let end = el.selectionEnd;
                    el.value = el.value.substring(0, start) + String.fromCharCode(newChar) + el.value.substring(end);
                    el.setSelectionRange(start + 1, start + 1);
                    e.preventDefault();
                }
            }
        };
        document.querySelectorAll(".uc-text-smooth").forEach(function(current) {
            current.addEventListener("keypress", forceKeyPressUppercase);
        });
    </script>
    <script>
        /** Bank No copy paste **/
        var inputField = document.getElementById('account_no_confirmation');

        // Disable copy and paste events
        inputField.addEventListener('copy', function(e) {
            e.preventDefault();
        });

        inputField.addEventListener('cut', function(e) {
            e.preventDefault();
        });

        inputField.addEventListener('paste', function(e) {
            e.preventDefault();
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const accountNo = document.getElementById('account_no');
            const accountConfirmation = document.getElementById('account_no_confirmation');
            const confirmationError = document.getElementById('accError');
            const form = document.getElementById('bankForm'); // Replace 'myForm' with the ID of your form

            // Function to allow only numbers
            function allowOnlyNumbers(inputField) {
                inputField.addEventListener('input', function() {
                    inputField.value = inputField.value.replace(/\D/g, '');
                });
            }

            // Call the function for both fields
            allowOnlyNumbers(accountNo);
            allowOnlyNumbers(accountConfirmation);

            // Function to validate confirmation
            accountConfirmation.addEventListener('input', function() {
                if (accountConfirmation.value !== accountNo.value) {
                    confirmationError.textContent = '⚠ Account numbers do not match';
                } else {
                    confirmationError.textContent = '';
                }
            });

            // Prevent form submission if there are validation errors
            form.addEventListener('submit', function(event) {
                const isValidAccountNo = accountConfirmation.value === accountNo.value;
                if (!isValidAccountNo) {
                    event.preventDefault();
                    if (!isValidAccountNo) {
                        confirmationError.textContent = '⚠ Please Check Your Account Number Again';
                    }
                    // Add validation for email and PAN here if needed
                }
            });
        });
    </script>



    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    {{--<script>--}}
        {{--$('#populateBank').click(function() {--}}
            {{--var ifsc = $('#ifsc').val()--}}
            {{--$.ajax({--}}
                {{--url: 'https://ifsc.razorpay.com/'+ifsc,--}}
                {{--type: 'GET',--}}
                {{--dataType: 'json',--}}
                {{--success: function(response) {--}}
                    {{--console.log(response)--}}
                    {{--if (response.ifsc === null) {--}}
                        {{--$('.bank').val('');--}}
                        {{--Swal.fire({--}}
                            {{--icon: 'error',--}}
                            {{--text: 'Please Check IFSC Code !'--}}
                        {{--});--}}
                        {{--return;--}}
                    {{--}--}}

                    {{--// Populate the input field with the retrieved data--}}
                    {{--$('#ifsc_pk').val(response.IFSC);--}}
                    {{--$('#bank_name').val(response.BANK);--}}
                    {{--$('#branch_name').val(response.BRANCH);--}}
                    {{--$('#bank_address').val(response.ADDRESS);--}}

                    {{--var ifsc = response;--}}

                {{--},--}}
                {{--error: function(xhr, status, error) {--}}
                    {{--console.error(error);--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}
    {{--</script>--}}
    <script>
        $('#populateBank').click(function () {
            var ifsc = $('#ifsc').val().trim();

            if (!ifsc) {
                Swal.fire({
                    icon: 'error',
                    text: 'Please enter IFSC code'
                });
                return;
            }

            // First attempt: Razorpay IFSC API
            $.ajax({
                url: 'https://ifsc.razorpay.com/' + ifsc,
                type: 'GET',
                dataType: 'json',
                success: function (response) {
//                    console.log(response)

                    if (response === null) {
                        fetchFromLocalDB(ifsc);
                        return;
                    }

                    populateBankFields(response);

                },
                error: function () {
                    // If Razorpay API fails, fallback to local DB
                    fetchFromLocalDB(ifsc);
                }
            });
        });

        function fetchFromLocalDB(ifsc) {
//            console.log(ifsc)
            $.ajax({
                url: '{{route('get-bank-details-ifsc')}}',
                type: 'POST',
                data: {
                    ifsc: ifsc,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function (response) {

                    if (!response || response.status === false) {
                        $('.bank').val('');
                        Swal.fire({
                            icon: 'error',
                            text: 'Please check IFSC Code!'
                        });
                        return;
                    }

                    populateBankFields(response.data);
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        text: 'Unable to fetch bank details'
                    });
                }
            });
        }

        function populateBankFields(data) {
            $('#ifsc_pk').val(data.IFSC ?? data.ifsc);
            $('#bank_name').val(data.BANK ?? data.bank_name);
            $('#branch_name').val(data.BRANCH ?? data.branch_name);
            $('#bank_address').val(data.ADDRESS ?? '');
        }
    </script>
    <script src="{{ URL::asset('assets/template/js/sweetAlert.js') }}"></script>
@endsection
