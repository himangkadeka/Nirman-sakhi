@include('layout.workerheader')
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


        <div class="container mt-1">
            <!-- Card 1: Key Dates -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Subscription Dues</h5>
                    <div class="alert alert-info border-left-primary shadow-sm p-3 mb-4 rounded">
                        <strong>Penalty Waiver Notice:</strong><br>
                        Penalty charges for subscription are waived from <strong>3rd July 2025</strong> to <strong>2nd July 2026</strong> as per ABOCWWB’s decision. No penalty will be applied during this period. Further updates will be notified by the Board.
                    </div>
                    {{--@if($no_of_month == 0 && $delayed_month == 0)--}}

                    {{--<div class="container" style="background: white; padding: 20px; border-left: 4px solid #28a745; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin: 20px 0;">--}}
                    {{--<h5 style="margin: 0; color: #333; font-size: 16px; display: flex; align-items: center;">--}}
                    {{--<span style="color: #28a745; font-size: 20px; margin-right: 10px;">✓</span> You have already cleared your dues upto {{$subscription_validity_date}}.--}}
                    {{--</h5>--}}
                    {{--</div>--}}

                    {{--@else--}}
                    @if($is_retired)
                        <form class="custom-form" method="post" action="{{route('create-worker-subscriptions-ex')}}" style="max-width: 1200px; margin: 0 auto;">
                            @csrf
                            <div class="container">
                                <div class="row gx-4 gy-3">
                                    <!-- Form Header -->
                                    <div class="col-12">
                                        <h5 class="form-header" style="color: #2c3e50; border-bottom: 2px solid #e9ecef; padding-bottom: 10px; margin-bottom: 20px;">
                                            Subscription Payment Details
                                        </h5>
                                    </div>

                                    <!-- First Row -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="cardValidity" class="form-label" style="font-weight: 500; color: #495057;">Existing ID Card Validity Date</label>
                                            <input type="text" class="form-control form-control-sm input-field" id="cardValidity"
                                                   value="{{ $card_validity_date }}" readonly onchange="setup()"
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="subscriptionValidity" class="form-label" style="font-weight: 500; color: #495057;">Subscription Paid Upto</label>
                                            <input type="text" class="form-control form-control-sm input-field" id="subscriptionValidit"
                                                   value="{{ $subscription_validity_date }}" readonly onchange="setup()"
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="prevRenew" class="form-label" style="font-weight: 500; color: #495057;">Previous Renewal Date</label>
                                            <input type="date" class="form-control form-control-sm input-field" id="prevRenew"
                                                   value="{{ $last_renewal_date }}" readonly
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                        </div>
                                    </div>

                                    <!-- Second Row -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="penaltyFrom" class="form-label" style="font-weight: 500; color: #495057;">Payment From</label>
                                            <input type="text" class="form-control form-control-sm input-field" id="penaltyFro"
                                                   name="from_period" value="{{ $penalty_from ?? '' }}" readonly
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="penaltyMonths" class="form-label" style="font-weight: 500; color: #495057;">No of months</label>
                                            <input type="text" class="form-control" value="{{$remaining_months}}" name="month_paid" readonly>


                                            {{--@else--}}
                                            {{--<select name="month_paid" class="form-control">--}}
                                                {{--<option value="">Select</option>--}}
                                                {{--@if($adv)--}}
                                                    {{--@for ($i = $delayed_month+3 ; $i <= $remaining_months; $i++)--}}

                                                        {{--<option value="{{ $i }}" {{ $remaining_months == $i }}>--}}
                                                            {{--{{ $i }}--}}
                                                        {{--</option>--}}
                                                    {{--@endfor--}}
                                                {{--@else--}}
                                                    {{--@for ($i = $delayed_month ; $i <= $remaining_months; $i++)--}}

                                                        {{--<option value="{{ $i }}" {{ $remaining_months == $i }}>--}}
                                                            {{--{{ $i }}--}}
                                                        {{--</option>--}}
                                                    {{--@endfor--}}
                                                {{--@endif--}}


                                            {{--</select>--}}
                                            {{--@endif--}}
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="penaltyTo" class="form-label" style="font-weight: 500; color: #495057;">Payment To</label>
                                            {{--@if($is_retired)--}}
                                            {{--<input type="text" class="form-control form-control-sm input-field" id=""--}}
                                            {{--name="to_period" value="{{$penalty_to}}" readonly--}}
                                            {{--style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">--}}
                                            {{--<input type="hidden" class="form-control form-control-sm input-field" id="penaltyTo"--}}
                                            {{--name="to_period" value="{{$penalty_to}}" readonly--}}
                                            {{--style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">--}}
                                            {{--@else--}}
                                            <input type="text" class="form-control form-control-sm input-field" id=""
                                                   name="to_period" value="{{$penalty_to}}" readonly
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                            {{--@endif--}}

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="penaltyMonths" class="form-label" style="font-weight: 500; color: #495057;">Remaining Months</label>
                                            <input type="text" class="form-control form-control-sm input-field" id="penaltyMonths"
                                                   name="penalty_months" value="{{ $remaining_months}}" readonly
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                        </div>
                                    </div>


                                    <input type="hidden" name="active_status" value="{{$active_status}}">

                                    @if($delayed_month > 0)
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="penaltyMonths" class="form-label" style="font-weight: 500; color: #495057;">No of Delayed Months</label>
                                                <input type="text" class="form-control form-control-sm input-field"
                                                       id="penaltyMonths" value="{{ $delayed_month }}" readonly
                                                       style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">

                                                {{--<small class="text-danger">Note: Please clear dues for delayed months with 3 months in advance</small>--}}
                                            </div>
                                        </div>
                                    @else
                                        <input type="hidden" class="form-control form-control-sm input-field"
                                               id="penaltyMonths" value="{{ $delayed_month }}" readonly>
                                    @endif

                                <!-- Third Row -->
                                    {{--<div class="col-md-4">--}}
                                    {{--<div class="form-group">--}}

                                    {{--<label for="totalMonths" class="form-label" style="font-weight: 500; color: #495057;">Penalty Amount</label>--}}
                                    <input type="hidden" class="form-control form-control-sm input-field" id=""
                                           name="fine" value="0" readonly
                                           style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                    {{--</div>--}}
                                    {{--</div>--}}

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="subscriptionAmount" class="form-label" style="font-weight: 500; color: #495057;">Subscription Payment Due</label>
                                            <input type="text" class="form-control form-control-sm input-field" id="subscriptionAmoun" name="amount_paid"
                                                   value="{{$remaining_months*20}}" readonly
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="penaltyAmount" class="form-label" style="font-weight: 500; color: #495057;">Total Amount</label>
                                            <input type="text" class="form-control form-control-sm input-field" id="penaltyAmoun"
                                                   name="total_amount" value="{{$remaining_months*20}}" readonly
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-12 mt-4 text-end">
                                        <button type="submit" class="btn btn-primary btn-sm d-inline-flex align-items-center"
                                                style="border-radius: 2px; font-weight: 500;">
                                            <i class="fa fa-plus-circle me-2"></i>&nbsp;
                                            Submit & Pay
                                        </button>
                                    </div>


                                </div>
                            </div>
                        </form>
                        @else
                    <form class="custom-form" method="post" action="{{route('create-worker-subscriptions-ex')}}" style="max-width: 1200px; margin: 0 auto;">
                        @csrf
                        <div class="container">
                            <div class="row gx-4 gy-3">
                                <!-- Form Header -->
                                <div class="col-12">
                                    <h5 class="form-header" style="color: #2c3e50; border-bottom: 2px solid #e9ecef; padding-bottom: 10px; margin-bottom: 20px;">
                                        Subscription Payment Details
                                    </h5>
                                </div>

                                <!-- First Row -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="cardValidity" class="form-label" style="font-weight: 500; color: #495057;">Existing ID Card Validity Date</label>
                                        <input type="text" class="form-control form-control-sm input-field" id="cardValidity"
                                               value="{{ $card_validity_date }}" readonly onchange="setup()"
                                               style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="subscriptionValidity" class="form-label" style="font-weight: 500; color: #495057;">Subscription Paid Upto</label>
                                        <input type="text" class="form-control form-control-sm input-field" id="subscriptionValidity"
                                               value="{{ $subscription_validity_date }}" readonly onchange="setup()"
                                               style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="prevRenew" class="form-label" style="font-weight: 500; color: #495057;">Previous Renewal Date</label>
                                        <input type="date" class="form-control form-control-sm input-field" id="prevRenew"
                                               value="{{ $last_renewal_date }}" readonly
                                               style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                    </div>
                                </div>

                                <!-- Second Row -->
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="penaltyFrom" class="form-label" style="font-weight: 500; color: #495057;">Payment From</label>
                                        <input type="text" class="form-control form-control-sm input-field" id="penaltyFrom"
                                               name="from_period" value="{{ $penalty_from ?? '' }}" readonly
                                               style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="penaltyMonths" class="form-label" style="font-weight: 500; color: #495057;">Select no of months</label>
                                        {{--@if($is_retired)--}}
                                        {{--<select name="month_paid" class="form-control">--}}
                                            {{--<option value="{{$remaining_months}}">{{$remaining_months}}</option>--}}
                                        {{--</select>--}}

                                                {{--@else--}}
                                                <select name="month_paid" class="form-control">
                                                    <option value="">Select</option>
                                            @if($adv)
                                            @for ($i = $delayed_month+3 ; $i <= $remaining_months; $i++)

                                                <option value="{{ $i }}" {{ $remaining_months == $i }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                                @else
                                                @for ($i = $remaining_months ; $i <= $remaining_months; $i++)

                                                    <option value="{{ $i }}" {{ $remaining_months == $i }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                                @endif


                                        </select>
                                        {{--@endif--}}
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="penaltyTo" class="form-label" style="font-weight: 500; color: #495057;">Payment To</label>

                                            <input type="text" class="form-control form-control-sm input-field" id="penaltyTo"
                                                   name="to_period" value="" readonly
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                            {{--@endif--}}

                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="penaltyMonths" class="form-label" style="font-weight: 500; color: #495057;">Remaining Months</label>
                                        <input type="text" class="form-control form-control-sm input-field" id="penaltyMonths"
                                               name="penalty_months" value="{{ $remaining_months}}" readonly
                                               style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                    </div>
                                </div>


                                <input type="hidden" name="active_status" value="{{$active_status}}">

                                @if($delayed_month > 0)
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="penaltyMonths" class="form-label" style="font-weight: 500; color: #495057;">Delayed Months</label>
                                            <input type="text" class="form-control form-control-sm input-field"
                                                   id="penaltyMonths" value="{{ $delayed_month }}" readonly
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">

                                            <small class="text-danger">Note: Please clear dues for delayed months with 3 months in advance</small>
                                        </div>
                                    </div>
                                    @else
                                    <input type="hidden" class="form-control form-control-sm input-field"
                                           id="penaltyMonths" value="{{ $delayed_month }}" readonly>
                                @endif

                                <!-- Third Row -->
                                {{--<div class="col-md-4">--}}
                                    {{--<div class="form-group">--}}

                                        {{--<label for="totalMonths" class="form-label" style="font-weight: 500; color: #495057;">Penalty Amount</label>--}}
                                        <input type="hidden" class="form-control form-control-sm input-field" id="totalMonths"
                                               name="fine" value="0" readonly
                                               style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                    {{--</div>--}}
                                {{--</div>--}}

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="subscriptionAmount" class="form-label" style="font-weight: 500; color: #495057;">Subscription Payment Due</label>
                                        <input type="text" class="form-control form-control-sm input-field" id="subscriptionAmount" name="amount_paid"
                                               value="" readonly
                                               style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="penaltyAmount" class="form-label" style="font-weight: 500; color: #495057;">Total Amount</label>
                                        <input type="text" class="form-control form-control-sm input-field" id="penaltyAmount"
                                               name="total_amount" value="" readonly
                                               style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="col-12 mt-4 text-end">
                                    <button type="submit" class="btn btn-primary btn-sm d-inline-flex align-items-center"
                                            style="border-radius: 2px; font-weight: 500;">
                                        <i class="fa fa-plus-circle me-2"></i>&nbsp;
                                        Submit & Pay
                                    </button>
                                </div>


                            </div>
                        </div>
                    </form>
                    @endif

                    <style>
                        .form-header {
                            font-size: 1.25rem;
                            font-weight: 600;
                        }

                        .form-group {
                            margin-bottom: 1rem;
                        }

                        .input-field {
                            border-radius: 4px;
                            transition: border-color 0.15s ease-in-out;
                        }

                        .input-field:focus {
                            border-color: #80bdff;
                            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
                        }

                        .btn-submit:hover {
                            background-color: #227dc7 !important;
                            transform: translateY(-1px);
                        }
                    </style>






                </div>
            </div>

            <!-- Card 3: Renewal Payment -->
            <div id="phase2" class="card mb-4 shadow-sm d-none">
                <div class="card-body">
                    <!-- You can insert the next step of the form here -->
                </div>
            </div>
        </div>




    </div>
</div>
@include('components.footer')
<script src="{{ URL::asset('assets/template/js/bootstrap.bundle.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fromInput = document.getElementById('penaltyFrom');
        const toInput = document.getElementById('penaltyTo');

        const monthSelect = document.querySelector('select[name="month_paid"]');
        const subscriptionAmountInput = document.getElementById('subscriptionAmount');
        const penaltyAmountInput = 0;
        const totalAmountInput = document.getElementById('penaltyAmount');

        const delayedMonths = parseInt(`{{ $delayed_month ?? 0 }}`); // Injected from backend
        const monthlySubscriptionRate = 20;
        const monthlyPenaltyRate = 0;

        function calculateAll() {
            const fromDateStr = fromInput.value;
            const months = parseInt(monthSelect.value);

            if (fromDateStr && !isNaN(months)) {

                const parts = fromDateStr.split('-');
                const formattedDate = `${parts[2]}-${parts[1]}-${parts[0]}`;
                const fromDate = new Date(formattedDate);
                const toDate = new Date(fromDate);
                toDate.setMonth(toDate.getMonth() + months);
                toDate.setDate(toDate.getDate() - 1); // Subtract one day

                const day = ('0' + toDate.getDate()).slice(-2);
                const month = ('0' + (toDate.getMonth() + 1)).slice(-2);
                const year = toDate.getFullYear();
                toInput.value = `${day}-${month}-${year}`;


                const totalSubscription = months * monthlySubscriptionRate;
                subscriptionAmountInput.value = totalSubscription;


                let penaltyAmount = 0;

                if (delayedMonths > 0) {
                    penaltyAmount = monthlyPenaltyRate * (delayedMonths * (delayedMonths + 1)) / 2;
                }

                penaltyAmountInput.value = penaltyAmount;


                const total = totalSubscription + penaltyAmount;
                totalAmountInput.value = total;
            }
        }

        monthSelect.addEventListener('change', calculateAll);
        calculateAll();
    });
</script>


