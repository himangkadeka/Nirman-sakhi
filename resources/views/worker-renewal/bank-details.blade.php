@extends('layouts.user-app')

@section('title',' Update | Bank Details')

@section('style')
    <style>
        body{
            background-color: #f1f1f1;
        }
        * {

            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

        }
        .btn-primary {
            background-color: #0f4547;
        }
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
    </style>
@endsection


@section('content')
    <div class="container-fluid mb-4">
        <div class="col-md-12">
            <nav class="custom-navbar navbar-light p-3">
                <div class="custom-container">
                    <div class="custom-flex-container">
                        <div class="custom-left-content">
                            <h6 class="custom-heading">{{ trans('worker-registration/worker-bank-details.registrationconstructionworker') }}</h6>
                            <h6 class="custom-bold">
                                <i class="custom-icon fas fa-file-alt pr-2"></i>{{ trans('worker-registration/worker-bank-details.applicationno') }} -
                                {{ $application_no }}
                            </h6>
                        </div>
                        @include('components.session-timeout')
                    </div>
                </div>
            </nav>
            <div class="card mt-1">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="card rounded-card">
                            <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center" style="background-color: #248f8f;">
                <span>
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;{{ trans('worker-registration/worker-bank-details.updatebankdetails') }}
                </span>

                            </div>
                            <div class="form-row mt-4 ml-2"><!--start 1-->
                                <div class="form-group col-md-3">
                                    <label for="inputIfsc" class="bold">{{ trans('worker-registration/worker-bank-details.ifsccode') }}</label><span style="color:red;">*</span>
                                    <input type="text" class="search-input custom-bottom-border form-control uc-text-smooth" name="ifsc" id="ifsc" value="" maxlength="11" placeholder="Enter IFSC Code" />
                                    <input type="button" value="Search Bank Details" id="populateBank" class=" btn btn-sm btn-danger proceed mt-1"/>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="inputIfsc" class="bold"></label>
                                </div>
                            </div><!--end-->
                            <form action="{{route('save-bank-details')}}" id="bankForm" class="form-group  ml-2" method="post">
                                @csrf
                                {{--                        <input type="hidden" name="worker_id" value="{{$formdata->worker_id}}" >--}}
                                <input type="hidden" name="ifsc_pk" class="bank" id="ifsc_pk" value="{{$ifsc->id}}">
                                <div class="form-row mt-3"><!--start 1-->
                                    <div class="form-group col-md-4">
                                        <label for="inputBank" class="bold">{{ trans('worker-registration/worker-bank-details.bankname') }}</label><span style="color:red;">*</span>
                                        <input type="text" class="form-control custom-bottom-border uc-text-smooth bank" id="bank_name" value="{{$formdata->bank_name}}" name="bank_name" placeholder="Enter Bank Name" readonly>
                                        @if ($errors->has('bank_name'))
                                            <span class="text-danger font-weight-normal error-message">{{ $errors->first('bank_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputBranch" class="bold">{{ trans('worker-registration/worker-bank-details.branch') }}</label><span style="color:red;">*</span>
                                        <input type="text" class="form-control custom-bottom-border uc-text-smooth bank" id="branch_name" value="{{$formdata->branch_name}}" name="branch_name" placeholder="Enter Branch Name" readonly>
                                        @if ($errors->has('branch_name'))
                                            <span class="text-danger font-weight-normal error-message">{{ $errors->first('branch_name') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputBankAddress" class="bold">{{ trans('worker-registration/worker-bank-details.bankaddress') }}</label><span style="color:red;">*</span>
                                        <input type="text" class="form-control custom-bottom-border uc-text-smooth bank" id="bank_address" name="bank_address" value="{{$formdata->bank_address}}" placeholder="Enter Bank Address" readonly>
                                        @if ($errors->has('bank_address'))
                                            <span class="text-danger font-weight-normal error-message">{{ $errors->first('bank_address') }}</span>
                                        @endif
                                    </div>
                                </div><!--end-->
                                <div class="form-row mt-4"><!--start 1-->

                                    <div class="form-group col-md-4">
                                        <label for="inputAcc" class="bold">{{ trans('worker-registration/worker-bank-details.accountnumber') }}</label><span style="color:red;">*</span>
                                        <input type="text" class="form-control custom-bottom-border" id="account_no" name="account_no" value="{{$formdata->account_no}}" maxlength="14" placeholder="Enter Account Number">
                                        <span id="account_noError" class="error-message text-danger"></span>
                                        @if ($errors->has('account_no'))
                                            <span class="text-danger font-weight-normal error-message">{{ $errors->first('account_no') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="inputAge" class="bold">{{ trans('worker-registration/worker-bank-details.confirmaccountnumber') }}</label><span style="color:red;">*</span>
                                        <input type="text" class="form-control custom-bottom-border" id="account_no_confirmation" value="{{$formdata->account_no}}" maxlength="14" placeholder="Confirm Account Number" name="account_no_confirmation" >
                                        <span id="accError" class="error"></span>
                                        @if ($errors->has('account_no_confirmation'))
                                            <span class="text-danger font-weight-normal error-message">{{ $errors->first('account_no_confirmation') }}</span>
                                        @endif
                                    </div>
                                </div><!--end-->
                                {{--                        <div class="row justify-content-center mt-3">--}}

                                {{--                            <div class="col-auto">--}}
                                {{--                                <a href="{{route('submit-existing-basic-details')}}" class="btn btn-sm btn-warning"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp; Go To Previous</a>--}}
                                {{--                            </div>--}}
                                {{--                            <div class="col-auto">--}}
                                {{--                                <button type="submit" class="btn btn-sm btn-primary">Save & Next Page&nbsp;<i class="fa fa-forward" aria-hidden="true"></i></button>--}}
                                {{--                            </div>--}}
                                {{--                        </div>--}}
                                <div class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                                    <div class="ml-auto d-inline-block align-self-center mr-2">
{{--                                        <a type="submit" href="{{route('submit-existing-basic-details')}}"--}}
{{--                                           class="btn btn-sm btn-warning"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;--}}
{{--                                            Previous</a>--}}
                                        <button type="submit"
                                                class="btn btn-sm btn-primary"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;
                                            Update Bank Details</button>
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
    <script src="{{URL::asset('assets/template/js/jquery-3.7.0.js')}}"></script>
    <script>
        const forceKeyPressUppercase = (e) => {
            let el = e.target;
            let charInput = e.keyCode;
            if((charInput >= 97) && (charInput <= 122)) { // lowercase
                if(!e.ctrlKey && !e.metaKey && !e.altKey) { // no modifier key
                    let newChar = charInput - 32;
                    let start = el.selectionStart;
                    let end = el.selectionEnd;
                    el.value = el.value.substring(0, start) + String.fromCharCode(newChar) + el.value.substring(end);
                    el.setSelectionRange(start+1, start+1);
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
        inputField.addEventListener('copy', function (e) {
            e.preventDefault();
        });

        inputField.addEventListener('cut', function (e) {
            e.preventDefault();
        });

        inputField.addEventListener('paste', function (e) {
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



    {{--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>--}}
    <script>
        $('#populateBank').click(function () {
            $.ajax({
                url: 'get-bank-details',
                type: 'GET',
                data: {
                    ifsc:$('#ifsc').val(),
                    _token: '{{csrf_token()}}'},
                dataType: 'json',
                success: function (response) {
                    console.log(response)
                    if(response.ifsc === null)
                    {
                        $('.bank').val('');
                        Swal.fire({
                            icon: 'error',
                            text: 'Please Check IFSC Code !'
                        });
                        return;
                    }

                    // Populate the input field with the retrieved data
                    $('#ifsc_pk').val(response.ifsc.id);
                    $('#bank_name').val(response.ifsc.bank_name);
                    $('#branch_name').val(response.ifsc.branch_name);
                    $('#bank_address').val(response.ifsc.state);

                    // Handle the unique value as needed
                    var ifsc = response.ifsc;
                    // You can use uniqueValue as needed
                },
                error: function (xhr, status, error) {
                    console.error(error);
                }
            });
        });
    </script>
    <script src="{{URL::asset('assets/template/js/sweetAlert.js')}}"></script>
    <script>
        @if(session('alert_shown'))

        Swal.fire({
            icon: 'success',
            title: 'Updated',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000
        });
        @endif
    </script>
@endsection

