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

        .card {
            -webkit-box-shadow: -2px 2px 0px 1px rgba(15, 58, 71, 1);
            -moz-box-shadow: -2px 2px 0px 1px rgba(15, 58, 71, 1);
            box-shadow: -2px 2px 0px 1px rgba(15, 58, 71, 1);

        }

        /*box-shadow: rgba(50, 50, 93, 0.25) 0px 2px 5px -1px, rgba(0, 0, 0, 0.3) 0px 1px 3px -1px;*/



        .card-title {
            background-image: url("/assets/template/images/frombannercopy.jpg");
            height: 100px;
            background-repeat: no-repeat, no-repeat;
            background-position: center;
            text-align: center;
            color: white;
            /*width:;*/

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


.table {
    font-size: 0.9rem; /* Smaller font size for table */
}

th, td {
    text-align: center;
}

th {
    background-color: #f8f9fa; /* Header background color */
    color: #333; /* Header text color */
    font-weight: bold;
}

tbody tr:nth-child(even) {
    background-color: #f2f2f2; /* Even row background color */
}

tbody tr:hover {
    background-color: #e9ecef; /* Hover row background color */
}

        /*td {*/
        /*    border: 1px solid black;*/
        /*}*/
    </style>
@endsection


@section('content')
<div class="container mt-5">
    <div id="print_content" class="card mt-2" style="border-top-left-radius: 12px; border-top-right-radius: 12px">
        <div class="card-body">
            <h5>Payment Receipt Details</h5>
            <div class="mt-5">
                <div class="alert alert-success" role="alert">
                    <i class="fa fa-check" aria-hidden="true"></i> Payment is Successful
                </div>
                <div>

                </div>
                <div class="mt-5">
                    <p>Dear <span class="font-weight-bold">  {{ $getVaultData['name'] }}</span>, You have Successfully Paid the registration fees</p>
                    <p>Phone No : {{$wmf->phone_no}}</p>
                    <p>Application Id : {{$wmf->application_no}}</p>
                    <p>Transaction No : {{$paymentDetails->PRN ? $paymentDetails->PRN : 'NA' }}</p>
                    <p>Transaction Date : {{now()}}</p>
                    <p>GRN : {{$paymentDetails->GRN ? $paymentDetails->GRN : 'NA'}}</p>
                    <p>Amount : Rs {{$paymentDetails->GRN ? $paymentDetails->AMOUNT : '00'}}</p>
                    <p>Status : Paid</p>
                </div>
            </div>{{--                                <div class="" id="" style="display:flex; flex-direction:column; justify-content:center; align-items:center ">--}}
{{--                                    <div class="float-left d-flex h-100">--}}
{{--                                        <object class="align-self-center b-emblem-image" type="image/svg+xml" data={{URL::asset('assets/template/images/bocw-logo.svg')}} width="100" height="100">--}}
{{--                                            Your browser does not support SVG.--}}
{{--                                        </object>
--}}
{{--                                    </div>--}}

{{--                                    <div class="float-left d-flex h-100">--}}
{{--                                        <h4 class="align-self-center mt-3"><span class="font-weight-bold">Payment Acknowledgement Receipt </span></h4>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="text-left mt-4">--}}
{{--                                    <p>Dear <span class="font-weight-bold"> {{$wrkr->first_name}} {{$wrkr->last_name}}</span>, </p>--}}
{{--                                    <span class="font-weight-bold">The following fee payment has been received for subscription of your membership.</span>.--}}
{{--                                </div>--}}
{{--                                <div class="mt-4 " style="display: flex">--}}

{{--                                    <ul class="mr-4" style="list-style-type: none">--}}
{{--                                        <li>Membership subscription fee: <span class="font-weight-bold">Rs. {{$subscription->total_amount}}</span></li>--}}
{{--                                        <li>Payment date: <span class="font-weight-bold">{{now()}}</span></li>--}}
{{--                                        <li>Payment mode: <span class="font-weight-bold">Online – Debit card</span></li>--}}
{{--                                        <li>Registration ID: <span class="font-weight-bold">XXXXXXXXX</span></li>--}}
{{--                                        <li>Subscription validity (Till date) : <span class="font-weight-bold">{{$wmf->expiry_date}}</span></li>--}}
{{--                                        <li>Printout charges (if applicable): Rs. <span class="font-weight-bold">XX.XX</span></li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="text-left">--}}
{{--                                    <p class="justify-content-center">Thank You, <br> ABOCWWB </p>--}}
{{--                                </div>--}}
        </div>
    </div>

    <div class="row justify-content-center mt-3 mb-3">

        <div class="col-auto">
            <a href="{{ route('print-ack') }}" class="btn btn-success">Acknowledgement Page <i
                class="fa fa-forward" aria-hidden="true"></i></a>
        </div>

    </div>
</div>

@endsection


@section('footer')
    <script src="{{URL::asset('assets/template/js/getVaultData.js')}}"></script>
@endsection
