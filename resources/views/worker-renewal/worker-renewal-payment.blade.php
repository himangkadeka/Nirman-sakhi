@extends('layouts.user-app')

@section('title', 'Renewal')

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
        .table th {
            font-size: 12px;
        }

        .table-container {
            overflow-x: auto;
        }

        .fixed-width {
            min-width: 200px;
            /* Adjust the width as needed */
        }

        .fixed {
            min-width: 100px;
            /* Adjust the width as needed */
        }

        .table thead tr {
            border-top: 2px solid #ffc0b4;
        }

        .table thead th {
            border-bottom: 2px solid black;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid mb-4">
        <div class="col-md-12">
            <nav class="custom-navbar navbar-light bg-light p-3" style="border-radius: 20px;">
                <div class="custom-container">
                    <div class="custom-flex-container">
                        <div class="custom-left-content">
                            <h6 class="custom-heading">Renewal - Construction Worker</h6>
                            <h6 class="custom-bold">
                                <i class="custom-icon fas fa-file-alt pr-2"></i>Application No -
                                {{ $application_no }}
                            </h6>
                        </div>
                        {{--                        <div class="custom-right-content">--}}
                        {{--                            <h6 class="custom-heading">--}}
                        {{--                                <i class="custom-icon fas fa-clock"></i> Session Uptime ---}}
                        {{--                            </h6>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
            </nav>
            <div class="card mt-3">
                <div class="card-body">
                    <div class="container mt-2">
                        <div class="card rounded-card">
                            <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center" style="background-color: #248f8f;">
                <span>
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; Update Certificates
                </span>
                            </div>
                            <form action="{{ route('pay-renewal-amount') }}" method="post">
                                @csrf
                                <div class="container">
                                    <span class="text-dark">No of months that lapse subscription&nbsp;:&nbsp;{{$no_of_penalty_month}}&nbsp;months.</span><br/>

                                    <div class="form-row mt-1"><!--start 1-->

                                        <div class="form-group col-md-3">
                                            <label class="bold">No of Lapse duration</label>
                                            <input type="text" class="form-control rounded" name=""
                                                   id="previousDue" value="{{ $no_of_penalty_month }} months" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="bold">Previous Due</label>
                                            <input type="text" class="form-control rounded" name="previous_dues"
                                                   id="previousDue" value="{{ $subscription_amount }}" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="bold">Late Fine</label>
                                            <input type="text" class="form-control rounded" name="fine" id="lateFine"
                                                   value="{{ $penalty_amount }}" readonly>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label class="bold">Renewal Fees</label>
                                            <input type="text" class="form-control rounded" name="renewal_fee" id="renewalfee"
                                                   value="25" readonly>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="bold">Total Amount</label>
                                            <input type="text" class="form-control rounded" name="total_amount"
                                                   id="totalAmount" value="" readonly>
                                        </div>
                                    </div><!--end-->
                                </div>
                                <div class="row mt-3 justify-content-center pass-buttons d-flex align-items-center">
                                    <button type="submit"  class="btn btn-primary d-flex align-items-center justify-content-center">Proceed to Payment<i class="fa fa-sign-in ml-1"
                                                                                                                                                         aria-hidden="true"></i></button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    {{--    <script src="{{URL::asset('assets/template/js/getVaultData.js')}}"></script>--}}
    <script src="{{ URL::asset('assets/template/js/toastr.min.js') }}"></script>
@endsection


