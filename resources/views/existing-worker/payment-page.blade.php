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


        .table {
            font-size: 0.9rem;
            /* Smaller font size for table */
        }

        th,
        td {
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
            /* Header background color */
            color: #333;
            /* Header text color */
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #f2f2f2;
            /* Even row background color */
        }

        tbody tr:hover {
            background-color: #e9ecef;
            /* Hover row background color */
        }

        /*td {*/
        /*    border: 1px solid black;*/
        /*}*/
    </style>
@endsection


@section('content')
{{--    @include('components.multistep-existing')--}}
    <div class="container-fluid mb-4">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-md-12">

                <nav class="custom-navbar navbar-light p-3" style="border-radius: 20px;">
                    <div class="custom-container">
                        <div class="custom-flex-container">
                            <div class="custom-left-content">
                                <h6 class="custom-heading">Registration - Construction Worker</h6>
                                <h6 class="custom-bold">
                                    <i class="custom-icon fas fa-file-alt pr-2"></i>Application No - {{ $application_no }}
                                </h6>
                            </div>
{{--                            <div class="custom-right-content">--}}
{{--                                <h6 class="custom-heading">--}}
{{--                                    <i class="custom-icon fas fa-clock"></i> Session Uptime ---}}
{{--                                </h6>--}}
{{--                            </div>--}}
                        </div>
                    </div>
                </nav>

                <div class="card mt-1">
                    <div class="card-body">
                        <div class="container">
                            <div class="card rounded-card">
                                <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center" style="background-color: #248f8f;">
                <span>
                    <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;Payment Details
                </span>
                                </div>

                        <form action="" class="form-group form needs-validation">
                            <div>
                                <div class="d-flex justify-content-center p-4 payment-container">
                                    <div class="card fee">
                                        <div class="bg-light text-dark text-center p-2  mb-2">
                                            Fee Details
                                        </div>
                                        <div class="table-responsive p-4">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Amount In Rupees</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td class="text-info">Application fee for Registration of new worker, BOCW Assam</td>
                                                    <td class="text-danger">{{ $amount }}.00</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="card ml-4 payment">
                                        <div class="bg-light text-dark text-center rounded-top p-2 mb-3">
                                            Payment Details
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex mb-3">
                                                <div class="mr-2">
                                                    <i class="fa fa-user"></i>
                                                </div>
                                                <div class="text-info">
                                                    {{ $getVaultData->name }}
                                                </div>
                                            </div>
                                            <div class="d-flex mb-3">
                                                <div class="mr-2">
                                                    <i class="fa fa-phone"></i>
                                                </div>
                                                <div class="text-info">
                                                    {{ $worker->phone_no }}
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between p-2 mb-4">
                                                <div class="text-info mr-2">Total Application Fee:</div>
                                                <div class="text-danger">Rs {{ $amount }}.00</div>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <a href="{{ route('home.index') }}"
                                                   class="btn btn-sm btn-danger mr-2">Cancel</a>
                                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                                                        data-target="#exampleModal" id="pay_button">
                                                    @if($payment_data==null)
                                                        Pay Now
                                                    @else
                                                        Retry Payment
                                                    @endif
                                                    <i class="fa fa-check-circle"></i>
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div><!-- End Left side columns -->
            </div>
        </div>
    </div>

        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">

                                <strong>{!! $message !!} </strong>

                            </div>
                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        {{-- @if ($message = Session::get('success')) --}}
                        {{-- <a href="{{route('generate-uan',['id'=>encrypt($id)])}}" target="_blank" class="btn btn-success">Print Acknowledgement</a> --}}

                        {{-- @endif --}}
                    </div>
                </div>
            </div>
        </div>

    @include('components.worker.payment.payment-initiation-form')
    <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center d-block">
                        <h3 class="modal-title text-white " id="exampleModalLabel">Warning</h3>


                    </div>
                    <div class="modal-body">
                        <h3 class="text-center">Are you ready to submit? </h3>
                        <h6 class="text-danger mt-3">Note: No changes can be made after the final Submission. Check all
                            details carefully!</h6>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                        <button type="button" id="payment-submit" class="btn btn-primary">Yes</button>

                    </div>
                </div>
            </div>
        </div>


@endsection


@section('footer')

    <script src="{{ URL::asset('assets/template/js/getVaultData.js') }}"></script>

    <script>
        $("#pay_button").on('click', function() {

            // Remove the trailing '|'
            plain_string = plain_string.slice(0, -1);
            event.preventDefault();
            $.ajax({
                type: 'POST',
                url: "{{ route('egrass-encrypt') }}",
                data: $("#payment-form").serialize(),
                success: function (response) {
                    if (response.status == true) {
                        console.log(response.results)
                        $("#enc_string").val(response.results)
                    } else {
                        alert(response.results)
                    }
                },
                error: function (xhr, status, error) {
                    console.error(response.results);
                }
            });
            console.log(plain_string);
        })

        $("#payment-submit-form").on('click', function(){
            var form = document.getElementById('payment-form');
            form.submit();
        })
    </script>
@endsection
