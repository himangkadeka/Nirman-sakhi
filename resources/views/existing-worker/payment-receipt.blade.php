@extends('layouts.user-app')

@section('title', 'Worker | Payment Receipt')
@section('breadcrumb_item_1', 'Worker')
@section('breadcrumb_item_2', 'Payment Receipt')

@section('style')

@endsection

@section('content')
    <div class="container-fluids" id="wrapper">
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="d-flex justify-content-end">
                    <div class="add-butt p-3"><button type="button" class="btn btn-primary b-btn" id="download_pdf">Download<i class="fa fa-print pl-2" aria-hidden="true"></i></button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="print_content" class="card mt-2" style="border-top-left-radius: 12px; border-top-right-radius: 12px">
                            <div class="card-body">
                                    <div class="" id="" style="display:flex; flex-direction:column; justify-content:center; align-items:center ">
                                        <div class="float-left d-flex h-50">
                                            <img src="{{URL::asset('assets/template/images/emblem-dark.png')}}" class="align-self-center b-emblem-image" title="National Emblem of India" alt="emblem of india logo">
                                        </div>

                                        <div class="float-left d-flex h-100">
                                            <h2 class="align-self-center pl-3 b-appname"><span class="font-weight-bold">Assam Building & Other Construction Worker's Welfare Board </span></h2>
                                        </div>
                                    </div>
                                    <div class="alert alert-success" role="alert">
                                        <i class="fa fa-check" aria-hidden="true"></i> Payment is Successful
                                    </div>
                                    <div>

                                    </div>
                                    <div class="mt-5">
                                        <p>Dear <span class="font-weight-bold">{{ $getVaultData->name }}</span>, </p>
                                        <p>The fee payment has been completed</p>

                                        <p>Phone No: {{$wmf->phone_no}}</p>
                                        <p>Application Id: {{$wmf->application_no}}</p>
                                        <p>Transaction No: TXN000033DEMO</p>
                                        <p>Transaction Date: {{now()}}</p>
                                        <p>GRN : AS000000012DEMO</p>
                                        <p>Amount: Rs. {{$subscription->total_amount}}</p>
                                        <p>Status : Paid</p>
                                    </div>
{{--                                <div class="" id="" style="display:flex; flex-direction:column; justify-content:center; align-items:center ">--}}
{{--                                    <div class="float-left d-flex h-100">--}}
{{--                                        <object class="align-self-center b-emblem-image" type="image/svg+xml" data={{URL::asset('assets/template/images/bocw-logo.svg')}} width="100" height="100">--}}
{{--                                            Your browser does not support SVG.--}}
{{--                                        </object>--}}
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
                                <a href="{{ route('print-acknowledgement') }}" class="btn btn-success">Acknowledgement Page <i
                                        class="fa fa-forward" aria-hidden="true"></i></a>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection


@section('footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.5/jspdf.debug.js"></script>

<script type="text/javascript">
    $('#download_pdf').click(function () {
        var pdf = new jsPDF('p', 'pt', 'letter');
        source = $('#print_content')[0];
        margins = {
            top: 80,
            bottom: 60,
            left: 40,
            width: 522
        };
        pdf.fromHTML(
        source, // HTML string or DOM elem ref.
        margins.left, // x coord
        margins.top, { // y coord
            'width': margins.width, // max width of content on PDF
        },

        function (dispose) {
            pdf.save('Test.pdf');
        }, margins);

    });
</script>

@endsection

