@include('layout.workerheader')
@php
    use Carbon\Carbon;
@endphp
<style>
    .card-title{
        border-bottom: 2px solid #1466ff;
    }
    .custom-form {
        background-color: #fdfdfd;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        margin-top: 2rem;
    }

    .custom-form .form-label {
        font-weight: 600;
        font-size: 0.95rem;
        color: #333;
    }

    .custom-form .form-control-sm {
        border-radius: 0.5rem;
        border: 1px solid #ccc;
        font-size: 0.9rem;
        transition: border-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    .custom-form .form-control-sm:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.1);
    }

    /* Optional max width for larger screens */
    .custom-form .container {
        max-width: 960px;
    }
    .row .col-md-4 {
        padding-right: 1rem; /* horizontal spacing */
    }


    /* Spacing between rows and columns (already applied via Bootstrap gx-4 gy-3) */

</style>
<div class="d-flex" id="wrapper" style="font-family: Roboto,Sans-Serif;">
    @include('worker.leftmenu')

    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')


        @if ($wmf->already_registered != 1 && $remaining_months_to_pay > 0)
            <div class="container mt-1">
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Subscription Payment</h5>

                    <!-- Card Body -->
                        <form action="{{ route('create-worker-subscriptions') }}" class="custom-form" id="defaultPaymentForm" method="post">
                        @csrf

                        <!-- Row 1 -->
                            <div class="container">
                                <div class="row gx-4 gy-3">
                                    <div class="col-12">
                                        <h5 class="form-header" style="color: #2c3e50; border-bottom: 2px solid #e9ecef; padding-bottom: 10px; margin-bottom: 20px;">
                                            Subscription Details
                                        </h5>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="period" class="form-label fw-bold">Select No of Months</label>
                                            <select name="subscription_type" id="period" class="form-control" onchange="updateDate()">
                                                <option value="" selected>Select an option</option>
                                                @if ($subscription !== null)
                                                    @for ($i = 1; $i <= $remaining_months_to_pay; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                @else
                                                    @for ($i = 3; $i <= 24; $i++)
                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                @endif
                                            </select>
                                        </div>

                                </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fromperiod" class="form-label fw-bold">Subscription From Date</label>
                                            <input type="text" name="from_period" id="fromperiod"
                                                   class="form-control" value="{{ $start_date }}" readonly>
                                        </div>

                                </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="toperiod" class="form-label fw-bold">Subscription To Date</label>
                                            <input type="text" name="to_period" id="toperiod" class="form-control" readonly>
                                        </div>
                                    </div>

                            <!-- Row 2 -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                    <label for="fine" class="form-label fw-bold">Late Fine (₹)</label>
                                    <input type="text" name="fine" id="fine" class="form-control text-center fine" readonly>
                                </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                    <label for="amount" class="form-label fw-bold">Amount (₹)</label>
                                    <input type="text" name="amount" id="amount" class="form-control text-center amount" readonly>
                                </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="total_amount" class="form-label fw-bold">Total Amount To Be Paid (₹)</label>
                                            <input type="text" name="amount_paid" id="total_amount"
                                                   class="form-control text-center" readonly>
                                        </div>
                                    </div>
                            </div>

                            <!-- Submit -->
                            <div class="text-center mt-4">
                                <button id="submitBtnDefault" class="btn btn-success px-5 py-2">
                                    <i class="fa fa-check-circle me-2"></i>Create Subscription
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
</div>


            <style>
                /* Ensure gaps between inputs */
                .row.g-4 > div {
                    padding-bottom: 0.5rem;
                }
                /* Stretch inputs fully on large screens */
                .form-control {
                    width: 100%;
                }
            </style>
        @endif





    </div>
        </div>
<!-- Modal -->
<!-- Confirm Subscription Modal -->
<div class="modal fade" id="confirmSubscriptionModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Confirm Subscription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Proceed to Pay Subscription?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="cancelSubmitBtn" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmSubmitBtn">Proceed</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="defaultSubscriptionModal" tabindex="-1" aria-labelledby="defaultModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="defaultModalLabel">Confirm Subscription</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Proceed to Pay Subscription?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Discard</button>
                <button type="button" class="btn btn-primary" id="confirmSubmit">Proceed</button>
            </div>
        </div>
    </div>
</div>


<!-- Signup Modal -->
@if ($amount != 0)
    @include('components.worker.payment.payment-initiation-form')

    @include('components.worker.payment.payment-verification-form')
@endif
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Payment</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to proceed with the payment?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="payment-submit" class="btn btn-primary">Pay Now</button>
            </div>
        </div>
    </div>
</div>

@include('components.footer')
<script src="{{ URL::asset('assets/template/js/bootstrap.bundle.min.js') }}"></script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('.fine').value = 0;
        document.getElementById('amount').value = 0;
        document.getElementById('total_amount').value = 0;
    });

    function updateDate() {
        const fromPeriod = document.getElementById('fromperiod').value;
        const monthsToAdd = parseInt(document.getElementById('period').value, 10);

        if (isNaN(monthsToAdd)) {
            document.getElementById('toperiod').value = '';
            document.getElementById('amount').value = '0';
            document.getElementById('total_amount').value = '';
            return;
        }

        const fromDate = new Date(fromPeriod);
        fromDate.setMonth(fromDate.getMonth() + monthsToAdd);
        fromDate.setDate(fromDate.getDate());

        fromDate.setDate(fromDate.getDate() - 1);

// Format the date and set the input value
        const toPeriod = fromDate.toISOString().split('T')[0];
        document.getElementById('toperiod').value = toPeriod;


        const amount = monthsToAdd * 20;
        document.getElementById('amount').value = amount;

        const fine = parseFloat(document.querySelector('.fine').value) || 0;
        const totalAmount = fine + amount;

        document.getElementById('total_amount').value = totalAmount;
    }
    document.querySelector('.fine').addEventListener('input', function() {
        const fine = parseFloat(this.value) || 0;
        const amount = parseFloat(document.getElementById('amount').value) || 0;

        const totalAmount = fine + amount;
        document.getElementById('total_amount').value = totalAmount;
    });
</script>
<script>
    document.getElementById('submitBtnAl').addEventListener('click', function(e) {
        e.preventDefault(); // Prevent form submission
        var confirmModal = new bootstrap.Modal(document.getElementById('confirmSubscriptionModal'));
        confirmModal.show(); // Show the confirmation modal
    });

    document.getElementById('confirmSubmitBtn').addEventListener('click', function() {
        document.getElementById('subscriptionForm').submit();
    });

    // Cancel button doesn't need JS if `data-bs-dismiss="modal"` is used

</script>

<script>
    document.getElementById('submitBtnDefault').addEventListener('click', function(e) {
        e.preventDefault();
        var confirmModal = new bootstrap.Modal(document.getElementById('defaultSubscriptionModal'));
        confirmModal.show(); // Show the confirmation modal
    });

    document.getElementById('confirmSubmit').addEventListener('click', function() {
        document.getElementById('defaultPaymentForm').submit(); // Submit the form if user confirms
    });
</script>


<script>
    function toggleAdvancedPayment(showAdvanced) {
        document.getElementById('defaultPaymentForm').style.display = showAdvanced ? 'none' : 'block';
        document.getElementById('advancedPaymentForm').style.display = showAdvanced ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const defaultPaymentRadio = document.getElementById('defaultPayment');
        const advancedPaymentRadio = document.getElementById('advancedPayment');

        // Check if the default payment radio button is selected on page load
        toggleAdvancedPayment(advancedPaymentRadio.checked);

        // Attach event listeners to radio buttons
        defaultPaymentRadio.addEventListener('click', function() {
            toggleAdvancedPayment(false);
        });

        advancedPaymentRadio.addEventListener('click', function() {
            toggleAdvancedPayment(true);
        });
    });
</script>


{{-- <script> --}}
{{--    @if ($wmf->already_registered === 1) --}}
{{--        var backendStartDate = "<?php echo $wrkr->subscription_validity_date; ?>"; --}}
{{--    @else --}}
{{--        var backendStartDate = "<?php echo $wmf->id_card_created_at; ?>"; --}}
{{--    @endif --}}
{{--    var subscription = @json($subscription); --}}

{{--    function updateEndDate() { --}}
{{--        var startDate = new Date(document.getElementById('startDate').value); --}}
{{--        var endDate; --}}
{{--        var period = document.getElementById('period').value; --}}

{{--        if (period === '' || period === null) {} else if (period === 'monthly') { --}}
{{--            endDate = new Date(startDate.getFullYear(), startDate.getMonth() + 1, startDate.getDate()); --}}
{{--        } else if (period === 'quarterly') { --}}
{{--            endDate = new Date(startDate.getFullYear(), startDate.getMonth() + 3, startDate.getDate()); --}}
{{--        } else if (period === 'halfyearly') { --}}
{{--            endDate = new Date(startDate.getFullYear(), startDate.getMonth() + 6, startDate.getDate()); --}}
{{--        } else if (period === 'yearly') { --}}
{{--            endDate = new Date(startDate.getFullYear() + 1, startDate.getMonth(), startDate.getDate()); --}}
{{--        } --}}

{{--        document.getElementById('endDate').setAttribute('min', startDate.toISOString().slice(0, 10)); --}}
{{--        document.getElementById('endDate').setAttribute('max', endDate.toISOString().slice(0, 10)); --}}
{{--        document.getElementById('endDate').value = endDate.toISOString().slice(0, 10); --}}
{{--    } --}}

{{--    function updateStartDate() { --}}
{{--        var endDate = new Date(document.getElementById('endDate').value); --}}
{{--        var startDate; --}}
{{--        var period = document.getElementById('period').value; --}}

{{--        if (period === '' || period === null) {} else if (period === 'monthly') { --}}
{{--            startDate = new Date(endDate.getFullYear(), endDate.getMonth() - 1, endDate.getDate()); --}}
{{--        } else if (period === 'quarterly') { --}}
{{--            startDate = new Date(endDate.getFullYear(), endDate.getMonth() - 3, endDate.getDate()); --}}
{{--        } else if (period === 'halfyearly') { --}}
{{--            startDate = new Date(endDate.getFullYear(), endDate.getMonth() - 6, endDate.getDate()); --}}
{{--        } else if (period === 'yearly') { --}}
{{--            startDate = new Date(endDate.getFullYear() - 1, endDate.getMonth(), endDate.getDate()); --}}
{{--        } --}}

{{--        document.getElementById('startDate').setAttribute('max', endDate.toISOString().slice(0, 10)); --}}
{{--        document.getElementById('startDate').setAttribute('min', startDate.toISOString().slice(0, 10)); --}}
{{--        document.getElementById('startDate').value = startDate.toISOString().slice(0, 10); --}}
{{--    } --}}

{{--    function updateDatePicker() { --}}
{{--        var period = document.getElementById('period').value; --}}
{{--        var startDate = new Date(subscription ? new Date(subscription.to_period + 1).getTime() + 86400000 + 86400000 : backendStartDate); --}}
{{--        var endDate; --}}

{{--        if (period === '' || period === null) {} else if (period === 'monthly') { --}}
{{--            endDate = new Date(startDate.getFullYear(), startDate.getMonth() + 1, startDate.getDate()); --}}
{{--        } else if (period === 'quarterly') { --}}
{{--            endDate = new Date(startDate.getFullYear(), startDate.getMonth() + 3, startDate.getDate()); --}}
{{--        } else if (period === 'halfyearly') { --}}
{{--            endDate = new Date(startDate.getFullYear(), startDate.getMonth() + 6, startDate.getDate()); --}}
{{--        } else if (period === 'yearly') { --}}
{{--            endDate = new Date(startDate.getFullYear() + 1, startDate.getMonth(), startDate.getDate()); --}}
{{--        } --}}

{{--        document.getElementById('startDate').setAttribute('min', startDate.toISOString().slice(0, 10)); --}}
{{--        document.getElementById('startDate').setAttribute('max', endDate.toISOString().slice(0, 10)); --}}
{{--        document.getElementById('endDate').setAttribute('min', startDate.toISOString().slice(0, 10)); --}}
{{--        document.getElementById('endDate').setAttribute('max', endDate.toISOString().slice(0, 10)); --}}

{{--        document.getElementById('startDate').value = startDate.toISOString().slice(0, 10); --}}
{{--        document.getElementById('endDate').value = endDate.toISOString().slice(0, 10); --}}
{{--    } --}}

{{--    window.onload = function() { --}}
{{--        updateDatePicker(); --}}
{{--    } --}}
{{-- </script> --}}

{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> --}}
<script>
    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>
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
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.rounded-card');

        // Add event listener to radio buttons
        document.querySelectorAll('input[name="subscription_type"]').forEach((radio, index) => {
            radio.addEventListener('change', function() {
                // Get the value of the selected radio button
                const selectedValue = this.value;
                // console.log(selectedValue)

                // Set the value of the hidden input field (total_amount) based on the selected radio button
                const amountInput = document.querySelector('input[name="total_amount"]');
                const selectedAmount = this.closest('.rounded-card').querySelector(
                    'input[type="hidden"][name="total_amount"][value="' + selectedValue +
                    '"]');
                console.log(selectedAmount)

                // If selectedAmount is found, update the value of the hidden input field
                if (selectedAmount) {
                    amountInput.value = selectedAmount.value;
                } else {
                    console.error('Amount input not found for selected value:', selectedValue);
                }

                // Add or remove blue border based on radio button selection
                cards.forEach((card, i) => {
                    if (i === index && this.checked) {
                        card.classList.add('border-blue');
                    } else {
                        card.classList.remove('border-blue');
                    }
                });
            });
        });
    });

    // $(document).ready(function() {
    //     $('#submitBtn').click(function() {
    //         var period = $('#period').val();
    //         var startDate = $('#startDate').val();
    //         var endDate = $('#endDate').val();


    //         if (period && startDate && endDate) {

    //             $.ajax({
    //                 type: "POST",
    //                 url: '{{ route('create-worker-subscriptions') }}', // Ensure this matches your route

    //                 data: {
    //                     _token: $('meta[name="csrf-token"]').attr('content'),
    //                     subscription_type: period,
    //                     from_period: startDate,
    //                     to_period: endDate
    //                 },
    //                 success: function(response) {
    //                     if (response.status == true) {
    //                         $('#result_table tbody').empty();
    //                         var newRow = "";
    //                         newRow = '<tr>' +
    //                             '<td>' + response.results.subscription_type + '</td>' +
    //                             '<td>' + response.results.from_period + '</td>' +
    //                             '<td>' + response.results.to_period + '</td>' +
    //                             '<td> <span class = "badge badge-danger"> Not Paid </span> </td>' +
    //                             '<td> <button type="button" id="submitPayment" class="btn btn-sm btn-danger b-btn text-white"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp; Pay Now </button> </td>' +
    //                             '</tr>';
    //                         $('#result_table tbody').append(newRow);
    //                         $('#result_table').show();
    //                         $("#submitPayment").on('click', function() {
    //                             $('#confirmationModal').modal('show');
    //                         });
    //                     }
    //                 },
    //                 error: function(xhr, status, error) {
    //                     alert('Error: ' + xhr.responseText);
    //                 }
    //             });
    //         } else {
    //             alert('Please fill all the fields');
    //         }
    //     });
    // });

    $("#submitPayment").on('click', function() {
        // Open the modal for confirmation
        $('#confirmationModal').modal('show');
    });

    // $("#payNow").on('click', function() {

    //     // Remove the trailing '|'
    //     plain_string = plain_string.slice(0, -1);
    //     event.preventDefault();
    //     $.ajax({
    //         type: 'POST',
    //         url: "{{ route('egrass-encrypt') }}",
    //         data: $("#payment-form").serialize(),
    //         success: function(response) {
    //             if (response.status == true) {
    //                 var enc = $("#enc_string").val(response.results)
    //                 if (enc != null) {
    //                     var form = document.getElementById('payment-submit-form');
    //                     form.submit();
    //                 }
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

@if ($payment_type == 'Pay Now')
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
    })


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
        document.querySelector('.overlay').style.display = 'block';
    }


    // $("#payment-submit").on('click', function() {

    // })
</script>
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


    window.onload = function() {

        var timer = document.getElementById("redirectTimer");
        if (timer) {
            countdown(); // Start the countdown immediately
        }
    };
</script>

@if ($time == true)
    <script>
        $(document).ready(function() {
            $("#payment_verify_button").attr('disabled', '{{ $disabled }}');
        });
    </script>
@endif
<script src="{{ URL::asset('assets/template/js/sweetAlert.js') }}"></script>
<script>
    @if (session('alert_shown'))

        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000
        });
    @endif
</script>

</body>

</html>
