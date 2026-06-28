@include('layout.workerheader')
<style>
    /* Custom styles */
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
<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')
    <!-- Page Content -->
    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')
        <ul class="breadcrumb">
            <li><a href="{{route('worker-dashboard')}}">Dashboard</a></li>
            <li>90 Days Certificate</li>

        </ul>
        <div class="container mt-5">
            <div class="card rounded-card">
                <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center" style="background-color: #248f8f;">
        <span>
            <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; All Certificates
        </span>
                    <a href="{{route('create-new-certificate')}}" class="btn btn-primary" >
                        Create New Certificates &nbsp;<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                    </a>
                </div>
            <div class="custom-form">
                <div class="row">
                    <div class="col">
                        <div class="table-container">
                            <table class="table" id="user_table">
                                <thead>
                                <tr>
                                    {{--                                        <th scope="col">Serial No</th> --}}
                                    <th scope="col" class="bold">Type of Issuer/ইছ্যুকাৰীৰ প্ৰকাৰ<span
                                            class="text-danger">*</span></th>
                                    <th scope="col" class="bold">Name of Issuing Organization/ইছ্যু কৰা
                                        সংস্থাৰ নাম<span class="text-danger">*</span></th>
                                    <th scope="col" class="bold">Issue Number/ইছ্যু নম্বৰ<span
                                            class="text-danger">*</span></th>
                                    <th scope="col" class="bold">Issue Date/ইছ্যুৰ তাৰিখ<span
                                            class="text-danger">*</span></th>
                                    <th scope="col" class="bold">Name of Issuing Person/ইছ্যু কৰা ব্যক্তিৰ নাম<span
                                            class="text-danger">*</span></th>
                                    <th scope="col" class="bold">Contact No of Issuing Person/ইছ্যু কৰা ব্যক্তিৰ যোগাযোগ নং<span
                                            class="text-danger">*</span></th>
                                    <th scope="col" class="bold">Employer Name/নিয়োগকৰ্তাৰ নাম<span
                                            class="text-danger">*</span></th>
                                    <th scope="col" class="bold">Employer Contact Name/নিয়োগকৰ্তাৰ যোগাযোগৰ নাম<span
                                            class="text-danger">*</span></th>
                                    <th scope="col" class="bold">Employer Contact Number/নিয়োগকৰ্তাৰ যোগাযোগ নম্বৰ<span
                                            class="text-danger">*</span></th>
                                    <th scope="col" class="bold">From Date/তাৰিখৰ পৰা<span
                                            class="text-danger">*</span></th>
                                    <th scope="col" class="bold">To Date/তাৰিখলৈকে<span
                                            class="text-danger">*</span></th>
{{--                                    <th scope="col" class="bold">No of Days/দিনৰ সংখ্যা<span--}}
{{--                                            class="text-danger">*</span></th>--}}
                                    <th scope="col" class="bold">Type of Employer/নিয়োগকৰ্তাৰ
                                        প্ৰকাৰ<span class="text-danger">*</span></th>

                                    <!-- Repeat headers as needed -->
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($worker_details as $worker_detail)
                                    @foreach ($worker_detail->certificates as $certificate)
                                    <tr>
                                        {{--                            <input type="hidden" name="worker_id[]" value="{{$formdata->worker_id}}" class="form-control"/> --}}
                                        {{--                                        <td class="bold font-weight-normal">1</td> --}}
                                        <td class="fixed-width">
                                            {{ $certificate->typeOfIssuer->issuer_name }}</td>

                                        <td class="fixed-width">
                                            {{ $certificate->issuing_org }}</td>

                                        <td class="fixed-width">{{ $certificate->issue_no }}</td>

                                        <td class="fixed-width">
                                            {{ \Carbon\Carbon::parse($certificate->issue_date)->format('d-m-y') }}</td>


                                        <td class="fixed-width">
                                            {{ $certificate->issuing_person }}</td>

                                        <td class="fixed-width">
                                            {{ $certificate->contact_issuing_person }}</td>
                                        <td class="fixed-width">
                                            {{ $certificate->employer_name }}</td>
                                        <td class="fixed-width">
                                            {{ $certificate->employer_contact_name }}</td>


                                        <td class="fixed-width">
                                            {{ $certificate->employer_contact_number }}</td>

                                        <td class="fixed-width">
                                            {{ \Carbon\Carbon::parse($certificate->from_date)->format('d-m-y') }}
                                        </td>
                                        <td class="fixed-width">
                                            {{ \Carbon\Carbon::parse($certificate->to_date)->format('d-m-y') }}
                                        </td>

                                        <td class="fixed-width">{{ $certificate->typeOfEmployer->employer_name }}</td>


                                    </tr>
                                @endforeach
                               @endforeach
                                <!-- Additional rows -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
</div>

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
</div>

<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Welcome to the dashboard!</h5>
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="{{URL::asset('assets/template/datepicker/jquery-ui.min.css')}}">
<script src="{{URL::asset('assets/template/datepicker/jquery-3.7.date.js')}}"></script>
<script src="{{URL::asset('assets/template/datepicker/jquery-ui.min.js')}}"></script>
<script src="{{URL::asset('assets/template/js/getVaultData.js')}}"></script>
<script src="{{URL::asset('assets/template/js/sweetAlert.js')}}"></script>
@include('layout.footer')
