@include('layout.workerheader')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root {
        --govt-navy: #1e293b;
        --govt-blue: #0d6efd;
        --govt-bg: #f4f7fa;
        --border-color: #e2e8f0;
    }

    body {
        font-family: 'Inter', sans-serif;
        background-color: var(--govt-bg);
        color: #334155;
    }
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
    .worker-dashboard {
        width: 100% !important;
        max-width: 100% !important; /* This removes the 1200px limit */
        margin: 0;
        padding-top: 0px;

    }

    /* Spacing between rows and columns (already applied via Bootstrap gx-4 gy-3) */

</style>
<div class="d-flex" id="wrapper" style="font-family: Roboto,Sans-Serif;">
    @include('worker.leftmenu')

    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')


        <div class="container worker-dashboard">
            <!-- Card 1: Key Dates -->
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Pre Renewal Dues</h5>


                    <div class="alert alert-info border-left-primary shadow-sm p-3 mb-4 rounded">
                        <strong>Penalty Waiver Notice:</strong><br>
                        Penalty charges for subscription are waived from <strong>3rd July 2025</strong> to <strong>2nd July 2026</strong> as per ABOCWWB’s decision. No penalty will be applied during this period. Further updates will be notified by the Board.
                    </div>

                @if($no_of_month == 0 && $delayed_month == 0)

                        <div class="container-fluid" style="background: white; padding: 20px; border-left: 4px solid #28a745; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin: 20px 0;">
                            <h5 style="margin: 0; color: #333; font-size: 16px; display: flex; align-items: center;">
                                <span style="color: #28a745; font-size: 20px; margin-right: 10px;">✓</span> You have already cleared your dues upto {{$subscription_validity_date}}.
                            </h5>
                        </div>

                        @else
                        <form class="custom-form" method="post" action="{{route('create-worker-subscriptions-ex')}}" style="max-width: 1200px; margin: 0 auto;">
                            @csrf
                            <div class="container worker-dashboard">
                                <div class="row gx-4 gy-3">
                                    <!-- Form Header -->
                                    <div class="col-12">
                                        <h5 class="form-header" style="color: #2c3e50; border-bottom: 2px solid #e9ecef; padding-bottom: 10px; margin-bottom: 20px;">
                                            Subscription Renewal Details
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
                                            <label for="subscriptionValidity" class="form-label" style="font-weight: 500; color: #495057;">Subscription Valid Till</label>
                                            <input type="text" class="form-control form-control-sm input-field" id="subscriptionValidity"
                                                   value="{{ $subscription_validity_date }}" readonly onchange="setup()"
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="prevRenew" class="form-label" style="font-weight: 500; color: #495057;">Registration Date</label>
                                            <input type="date" class="form-control form-control-sm input-field" id="prevRenew"
                                                   value="{{ $last_renewal_date }}" readonly
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                        </div>
                                    </div>

                                    <!-- Second Row -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="penaltyFrom" class="form-label" style="font-weight: 500; color: #495057;">Subscription From</label>
                                            <input type="text" class="form-control form-control-sm input-field" id="penaltyFrom"
                                                   name="from_period" value="{{ $penalty_from ?? '' }}" readonly
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                        </div>
                                    </div>
                                    <input type="hidden" value="0" name="active_status">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="penaltyTo" class="form-label" style="font-weight: 500; color: #495057;">Subscription To</label>
                                            <input type="text" class="form-control form-control-sm input-field" id="penaltyTo"
                                                   name="" value="{{ $card_validity_date ?? '' }}" readonly
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                        </div>
                                        <input type="hidden" name="to_period" value="{{ $card_validity_date ?? ''  }}">
                                    </div>
                                    {{--<div class="col-md-4">--}}
                                        {{--<div class="form-group">--}}

                                            {{--<label for="totalMonths" class="form-label" style="font-weight: 500; color: #495057;">Payment Date</label>--}}
                                            {{--<input type="text" class="form-control form-control-sm input-field" id="totalMonths"--}}
                                                   {{--name="fine" value="{{ $penalty_to ?? '' }}" readonly--}}
                                                   {{--style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">--}}
                                        {{--</div>--}}
                                    {{--</div>--}}

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="penaltyMonths" class="form-label" style="font-weight: 500; color: #495057;">Due Subscription Months</label>
                                            <input type="text" class="form-control form-control-sm input-field" id="penaltyMonths"
                                                   name="penalty_months" value="{{ $no_of_month}}" readonly
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                        </div>
                                    </div>
                                    {{--<div class="col-md-4">--}}
                                    {{--<div class="form-group">--}}
                                        {{--<label for="penaltyMonths" class="form-label" style="font-weight: 500; color: #495057;">Delayed By(In Months)</label>--}}
                                        {{--<input type="text" class="form-control form-control-sm input-field" id="penaltyMonths"--}}
                                               {{--name="month_paid" value="{{ $delayed_month}}" readonly--}}
                                               {{--style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">--}}
                                    {{--</div>--}}
                                    {{--</div>--}}

                                    <!-- Third Row -->
                                    {{--<div class="col-md-4">--}}
                                        {{--<div class="form-group">--}}

                                            {{--<label for="totalMonths" class="form-label" style="font-weight: 500; color: #495057;">Penalty Amount</label>--}}
                                            <input type="hidden" class="form-control form-control-sm input-field" id="totalMonths"
                                                   name="fine" value="{{ $penalty_amount ?? '' }}" readonly
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                    <input type="hidden" class="form-control form-control-sm input-field" id="penaltyMonths"
                                           name="month_paid" value="{{ $no_of_month}}" readonly
                                           style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                    <input type="hidden" class="form-control form-control-sm input-field" id="penaltyMonths"
                                           name="no_of_delayed_months" value="{{ $delayed_month}}" readonly
                                           style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                        {{--</div>--}}
                                    {{--</div>--}}



                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="subscriptionAmount" class="form-label" style="font-weight: 500; color: #495057;">Subscription Payment Due</label>
                                            <input type="text" class="form-control form-control-sm input-field" id="subscriptionAmount"
                                                   value="{{ $subscription_amount ?? '' }}" readonly
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="penaltyAmount" class="form-label" style="font-weight: 500; color: #495057;">Amount to be Paid</label>
                                            <input type="text" class="form-control form-control-sm input-field" id="penaltyAmount"
                                                   name="total_amount" value="{{ $total_amount ?? '' }}" readonly
                                                   style="background-color: #f8f9fa; border: 1px solid #ced4da; padding: 8px 12px;">
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-12 mt-4 text-end">
                                        <button type="submit"
                                                class="btn btn-primary btn-sm d-inline-flex align-items-center justify-content-end"
                                                style="border-radius: 2px; font-weight: 500; transition: background-color 0.3s ease;">
                                            <i class="fa fa-plus-circle me-2"></i>&nbsp;
                                            Submit and Pay
                                        </button>
                                    </div>



                                </div>
                            </div>
                        </form>

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

                    @endif




                </div>
            </div>

            <!-- Card 2: Pre-Renewal Dues -->
            {{--<div class="card mb-4 shadow-sm">--}}
                {{--<div class="card-body">--}}
                    {{--<h5 class="card-title mb-3">Step 1: Pre-Renewal Dues</h5>--}}
                    {{--<form>--}}
                        {{--<div class="row g-3">--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="paidUp" class="form-label">Subscription Paid Up To</label>--}}
                                    {{--<input type="date" class="form-control form-control-sm" id="paidUp" value="{{$last_subscription_date}}" onchange="setup()">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="submitted" class="form-label">Application Submission Date</label>--}}
                                    {{--<input type="date" class="form-control form-control-sm" id="submitted" onchange="setup()">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="col-md-6">--}}
                                {{--<div class="form-group">--}}
                                    {{--<label for="retirement" class="form-label">Retirement Date <small class="text-muted">(optional)</small></label>--}}
                                    {{--<input type="date" class="form-control form-control-sm" id="retirement" onchange="setup()">--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}

                        {{--<button type="button" class="btn btn-sm btn-primary mt-3" onclick="promptDues()">--}}
                            {{--Calculate Pre-Renewal Dues--}}
                        {{--</button>--}}

                        {{--<div id="dueBox" class="alert alert-info mt-3 d-none">--}}
                            {{--<p id="duePrompt" class="mb-2"></p>--}}
                            {{--<button type="button" class="btn btn-sm btn-success" onclick="showPhase2()">Proceed to Renewal Payment</button>--}}
                        {{--</div>--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}

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