@include('layout.workerheader')
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
        }

        .btn-primary {
            color: white;
        }

        a.href {
            text-decoration: none;
            /* Remove the default underline */
            color: #219fa4;
            /* Set the link color */
            transition: color 0.2s;
            /* Smooth color transition on hover */
        }

        a.href:hover {
            color: #ff6b6b;
            /* Change the color on hover */
        }

        h5 {
            color: #076f6b;
            position: relative;
            display: inline-block;
        }

        h5.preview-color {
            color: #076f6b;
        }

        h5::after {
            content: "";
            display: block;
            width: 100%;
            height: 2px;
            background-color: #ffbf49;
            position: absolute;
            bottom: -5px;
            left: 0;
            transform: scaleX(1);
            transform-origin: bottom left;
            transition: transform 0.3s ease;
        }
        label.bold{
            font-weight: 600;
            font-size: 14px;
        }

        h5:hover::after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        i {
            margin-right: 5px;
        }

        .custom-form {
            border: 2px solid rgba(0, 0, 0, .075);
            /* Border color - a shade of blue */
            border-radius: 10px;
            /* Border radius for rounded corners */
            padding: 20px;
            /* Padding inside the form */
            margin-top: 10px;
            /* Margin to separate the form from other elements */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Add a subtle box shadow */
            /*background-color: #f4f4f4;*/
            /* Background color - a light gray */
        }

        .custom-form-1 {
            border: 1px solid rgba(0, 0, 0, .075);
            /* Border color - a shade of blue */
            border-radius: 10px;
            /* Border radius for rounded corners */
            padding: 20px;
            /* Padding inside the form */
            margin-top: 10px;
            /* Margin to separate the form from other elements */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Add a subtle box shadow */
            background-color: #f4f4f4;
            /* Background color - a light gray */
        }

        .form-group {
            margin-bottom: 15px;
            /* Margin between form groups */
        }

        .table th {
            font-size: 10px;
        }

        .table-container {
            overflow-x: auto;
        }

        .fixed-width {
            min-width: 200px;
            /* Adjust the width as needed */
        }

        .fixed {
            min-width: 200px;
            /* Adjust the width as needed */
        }

        .table thead th {
            border-bottom: 1px solid black;

        }
        body{
            background-color: #f1f1f1;
            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
        }
        .form-control {
            height: 30px;
            /* Adjust the height as needed */
        }
        .table input.form-control,
        .table select.form-select {
            min-width: 160px;
            padding: 6px 10px;
            font-size: 12px;
        }
        .fixed-width-up{
            min-width: 200px;
        }
        /* Table Header Style */
        .table thead th {
            font-size: 13px;
            font-weight: 600;
            color: #333;
            padding: 10px 8px;
            background-color: white;
            vertical-align: middle;
            white-space: nowrap;
            text-align: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            border-bottom: 1px solid #dee2e6;
        }


        /* Additional spacing for fields with conditional inputs */
        .table td {
            vertical-align: middle;
        }

        /* Conditional text fields like 'Other Profession' */
        .table input.d-none,
        .table input[type="text"].d-none {
            display: none !important;
        }

        /* Button adjustments */
        .table .btn-sm {
            padding: 4px 10px;
            font-size: 12px;
        }

        /* Input field placeholder styling */
        .table input::placeholder {
            color: #6c757d;
            font-size: 12px;
        }
        .bold {
            font-weight: 500;
            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
            font-size: 13px;
            /*color: #186cb8;*/
            color: #8b5050 !important;
            /*color: #7ea1a2;*/
        }
        .edit-icon {
            position: relative;
            top: 0;
            right: 0;
            text-decoration: none;

        }
        .edit-icon:hover {
            text-decoration: none; /* Ensures no underline on hover */

        }
        .app-photo{
            width: 122px;
            height: 200px;
            border-radius: 10px;
            box-shadow: -2px 2px #4b4a4a;
            filter: brightness(1.3);
            display: block;
            margin: 0 auto;
            margin-bottom: 15px;
        }
        .heading-with-photo{
            display: flex;
            flex-direction: column;
            justify-content: center;
            width: 100%;
            text-align: center;
        }

    body,.form-control-plaintext{font-size:14px;}
        .familydob{
            padding: 3px;
            display: flex;
            width:105px;
            height: 50px;
            align-items: center;
            justify-content: center;
        }
        .user-photo{
            position: relative;
            width: 100%;
            border-radius: 8px;
            object-fit: cover;
            display: block;
            box-shadow: -3px 3px #ccc;
        }

        .user-photo-box{
            background: #d6d9dd;
            border-radius: 8px;
            width: 110px;
            position: absolute;
            top: 78px;
            right: 30px;
        }

    </style>


<div class="d-flex" id="wrapper">
@include('worker.leftmenu')
<!-- Page Content -->
    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')

    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-md-12">
                <div id="application-content">
                    <div class="card-body" style="box-shadow:none">
                        <div class="heading-wrapper">
                            <h6 class="text-center font-weight-bold" style="    color: #1b8f8b;text-shadow: 1px 1px #cacaca;">{{ trans('worker-registration/worker-data-preview.apppreview') }}</h6>
                        </div>

                        <div class="">
                            <div class="custom-form">
                                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            Renewal Details
                                        </span>&nbsp; <div class="badge badge-success">
                                        {{ $worker_details->id_card ?? 'NA'}}
                                    </div>
                                </h5>

                                <div class="user-photo-box">

                                    <!-- Applicant Photo -->
                                    <img src="data:image/jpeg;base64,{{$aadhar_photo}}"
                                         alt="Applicant Photo"
                                         class="user-photo">

                                </div>

                                <div class="form-row mt-3">


                                    <div class="form-group col-md-3">
                                        <label class="bold">ID Card Validity Date</label>
                                        <span class="form-control-plaintext" id="card_validity_date_display">{{\Carbon\Carbon::parse($worker_details->id_card_expiry_date)->format('d-m-Y') ?? 'NA' }}</span>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">Renewal Date</label>
                                        <span class="form-control-plaintext">{{\Carbon\Carbon::parse($worker_details->renewal_date)->format('d-m-Y') ?? 'NA'}}</span>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">Date Of Retirement</label>
                                        <span class="form-control-plaintext" id="retirement_date_display">{{\Carbon\Carbon::parse($worker_details->basicDetail->date_of_retirement)->format('d-m-Y') ?? 'NA'}}</span>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">Renewed Upto</label>
                                        <span class="form-control-plaintext" id="renewed_upto_display"></span>
                                    </div>
                                    <input type="hidden" id="retirement_date" value="{{ $worker_details->basicDetail->date_of_retirement ?? 'NA' }}">
                                    <input type="hidden" id="card_validity_date" value="{{ $worker_details->id_card_expiry_date ?? 'NA'}}">
                                </div>
                                <div class="form-row">


                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label class="bold">Office of Application</label>
                                        <span class="form-control-plaintext">{{$worker_details->officeName->office_name ?? 'NA'}}</span>
                                    </div>
                                </div>


                            </div>
                            <div class="custom-form">

                                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
                                        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
                                            Basic Details
                                        </span>
                                </h5>

                                <div class="form-row mt-3">
                                    <div class="form-group col-md-3">
                                        <label class="bold">{{ trans('worker-registration/worker-data-preview.workerstatus') }}</label>
                                        @if ($worker_details->basicDetail->resident_type === 'rao' ?? 'NA')
                                            <span class="form-control-plaintext">Migrant Worker</span>
                                        @else
                                            <span class="form-control-plaintext">Resident Worker</span>
                                        @endif
                                    </div>
                                    @if ($worker_details->basicDetail->resident_type == 'rao' ?? 'NA')
                                        <div class="form-group col-md-3">
                                            <label class="bold">State</label>
                                            <span class="form-control-plaintext">{{ $worker_details->basicDetail->state->state_name ?? '' }}</span>
                                        </div>
                                    @endif


                                </div>

                                <div class="form-row mt-2">
                                    <div class="form-group col-md-3">
                                        <label for="inputFirstName" class="bold">{{ trans('worker-registration/worker-data-preview.name') }}</label>
                                        <span class="form-control-plaintext">{{ $getVaultData['name'] ?? 'NA'}}</span>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputLastName" class="bold">Care Of</label>
                                        <span class="form-control-plaintext">{{ $getVaultData['careOf'] ?? 'NA' }}</span>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="gender" class="bold">{{ trans('worker-registration/worker-data-preview.gender') }}</label>
                                        <span class="form-control-plaintext"> {{ $getVaultData['gender'] == 'M' ? 'Male' : ($getVaultData['gender'] == 'F' ? 'Female' : ($getVaultData['gender'] == 'T' ? 'Transgender' : 'Unknown')) }}
                                </span>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="inputDob" class="bold">{{ trans('worker-registration/worker-data-preview.dob') }}</label>
                                        <span class="form-control-plaintext" id="dob"  data-dob="{{ $getVaultData['dob'] }}">{{ $getVaultData['dob'] }}</span>
                                    </div>
                                </div>


                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="inputAdhaar" class="bold">{{ trans('worker-registration/worker-data-preview.aadhaar') }}</label>
                                        <span class="form-control-plaintext">{{ $getVaultDatauID ?? 'NA' }}</span>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputAge" class="bold">{{ trans('worker-registration/worker-data-preview.age') }}</label>
                                        <span class="form-control-plaintext" id="age"></span>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputPhone" class="bold">{{ trans('worker-registration/worker-data-preview.mobile') }}</label>
                                        <span class="form-control-plaintext">{{ $worker_details->phone_no ?? 'NA' }}</span>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="mStatus" class="bold">{{ trans('worker-registration/worker-data-preview.marital') }}</label>
                                        <span class="form-control-plaintext">{{ $worker_details->basicDetail->maritalStatus->marital_status ?? 'NA'}}</span>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label for="inputCategory" class="bold">{{ trans('worker-registration/worker-data-preview.category')}}</label>
                                        <span class="form-control-plaintext">{{ $worker_details->basicDetail->cateGory->category_name ?? 'NA'}}</span>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputPF" class="bold">{{ trans('worker-registration/worker-data-preview.eshram') }}</label>
                                        <span class="form-control-plaintext">{{ $worker_details->basicDetail->eshram_no ?? 'NA' }}</span>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputPF" class="bold">{{ trans('worker-registration/worker-data-preview.blood') }}</label>
                                        <span class="form-control-plaintext">{{ $worker_details->basicDetail->bloodGroup->blood_group ?? 'NA' }}</span>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputPhone" class="bold">{{ trans('worker-registration/worker-data-preview.education') }}</label>
                                        <span class="form-control-plaintext">{{ $worker_details->basicDetail->education->education_name ?? 'NA' }}</span>
                                    </div>
                                </div>


                                <div class="form-row">
                                    @if($worker_details->already_registered == 1)
                                        <div class="form-group col-md-3">
                                            <label for="inputCategory" class="bold">{{ trans('worker-registration/worker-data-preview.profession') }}</label>
                                            <span class="form-control-plaintext">{{ $temp_worker_details->basicDetail->Profession->profession_name ?? 'NA' }}</span>
                                        </div>
                                    @endif

                                    <div class="form-group col-md-3">
                                        <label for="inputEsic" class="bold">Email</label>
                                        <span class="form-control-plaintext">{{ $worker_details->basicDetail->email ?? __('N/A') }}</span>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputPhone" class="bold">{{ trans('worker-registration/worker-data-preview.panyes') }}</label>
                                        <span class="form-control-plaintext">{{ $worker_details->basicDetail->pan == 1 ? 'Yes' : 'No' }}</span>
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="inputPhone" class="bold">{{ trans('worker-registration/worker-data-preview.alreadyreg') }}</label>
                                        <span class="form-control-plaintext">{{ $worker_details->basicDetail->boc == 1 ? 'Yes' : 'No' }}</span>
                                    </div>
                                </div>

                                <div class="form-row">
                                    @if ($worker_details->basicDetail->pan == 1)
                                        <div class="form-group col-md-3">
                                            <label for="inputPhone" class="bold">{{ trans('worker-registration/worker-data-preview.pan') }}</label>
                                            <span class="form-control-plaintext">{{ $worker_details->basicDetail->pan_no ?? 'NA'}}</span>
                                        </div>
                                    @endif

                                    @if ($worker_details->basicDetail->boc == '1')
                                        <div class="form-group col-md-3">
                                            <label for="inputPhone" class="bold">{{ trans('worker-registration/worker-data-preview.boc') }}</label>
                                            <span class="form-control-plaintext">{{ $worker_details->basicDetail->boc_no ?? 'NA'}}</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="inputPF" class="bold">{{ trans('worker-registration/worker-data-preview.rationcardyes') }}</label>
                                        <span class="form-control-plaintext">{{ $worker_details->basicDetail->has_ration_card == 1 ? 'Yes' : 'No' }}</span>
                                    </div>

                                    @if ($worker_details->basicDetail->has_ration_card == 1)
                                        <div class="form-group col-md-3">
                                            <label for="inputPF" class="bold">{{ trans('worker-registration/worker-data-preview.rationcardno') }}</label>
                                            <span class="form-control-plaintext">{{ $worker_details->basicDetail->ration_no ?? 'NA'}}</span>
                                        </div>

                                        <div class="form-group col-md-3">
                                            <label for="inputPF" class="bold">{{ trans('worker-registration/worker-data-preview.rationcardtype') }}</label>
                                            <span class="form-control-plaintext">{{ $worker_details->basicDetail->rationType->name ?? 'NA'}}</span>
                                        </div>
                                    @endif
                                </div>

                            </div>

                            <div class="custom-form mt-4">
                                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
            Permanent Address
        </span>
                                </h5>

                                <div class="form-row mt-5">
                                    <div class="form-group col-md-3">
                                        <label class="bold">State</label>
                                        <div>{{ $getVaultData['state'] }}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">District</label>
                                        <div>{{ $getVaultData['district'] ?? 'NA'}}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">Subdistrict</label>
                                        <div>{{ $getVaultData['subDistrict'] ?? 'NA' }}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">Post Office</label>
                                        <div>{{ $getVaultData['postOffice'] ?? 'NA'}}</div>
                                    </div>
                                </div>

                                <div class="form-row mt-1">
                                    <div class="form-group col-md-3">
                                        <label class="bold">Village</label>
                                        <div>{{ $getVaultData['village'] }}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">Street</label>
                                        <div>{{ $getVaultData['street'] ?? 'NA'}}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">Locality</label>
                                        <div>{{ $getVaultData['locality'] ?? 'NA' }}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">Landmark</label>
                                        <div>{{ $getVaultData['landMark'] ?? 'NA' }}</div>
                                    </div>
                                </div>

                                <div class="form-row mt-1">
                                    <div class="form-group col-md-3">
                                        <label class="bold">Pincode</label>
                                        <div>{{ $getVaultData['pinCode'] ?? 'NA'}}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">Post Office</label>
                                        <div>{{ $getVaultData['postOffice'] ?? 'NA'}}</div>
                                    </div>
                                </div>

                                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
            Present Address
        </span>
                                </h5>

                                <div class="form-row mt-3">
                                    <div class="form-group col-md-3">
                                        <label class="bold">Residence Type</label>
                                        <div>{{ $worker_details->address?->currentResidence?->residence_name ?? 'NA' }}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">House Type</label>
                                        <div>{{ $worker_details->address?->currentHouse?->house_type ?? 'Na' }}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">House No</label>
                                        <div>{{ $worker_details->address?->c_house_no ?? 'NA' }}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">Area/Village</label>
                                        <div>{{ $worker_details->address?->c_area ?? 'NA'}}</div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label class="bold">City</label>
                                        <div>{{ $worker_details->address?->c_city ?? 'NA'}}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">Road</label>
                                        <div>{{ $worker_details->address?->c_road ?? 'NA' }}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">State</label>
                                        <div>{{ $worker_details->address?->c_state ?? 'NA' }}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">District</label>
                                        <div>{{ $worker_details->address?->currentDistrict?->district_name ?: 'NA' }}</div>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-md-3">
                                        <label class="bold">Revenue Circle</label>
                                        <div>{{ $worker_details->address?->c_circle ?? 'NA' }}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">Post Office</label>
                                        <div>{{ $worker_details->address?->c_post_office ?? 'NA'}}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">Pincode</label>
                                        <div>{{ $worker_details->address?->c_pin ?? 'NA'}}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">Landmark</label>
                                        <div>{{ $worker_details->address?->landmark ?? __('N/A') }}</div>
                                    </div>
                                </div>
                            </div>






                            <div class="custom-form">
                                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
            Bank Details
        </span>
                                </h5>


                                <div class="form-row mt-4"><!--start 1-->
                                    <div class="form-group col-md-3">
                                        <label class="bold">{{ trans('worker-registration/worker-bank-details.bankname') }}</label>
                                        <div>{{ $worker_details->bankDetail->bank_name ?? 'NA'}}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">{{ trans('worker-registration/worker-bank-details.branch') }}</label>
                                        <div>{{ $worker_details->bankDetail->branch_name ?? 'NA'}}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">{{ trans('worker-registration/worker-bank-details.bankaddress') }}</label>
                                        <div>{{ $worker_details->bankDetail->bank_address ?? 'NA'}}</div>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="bold">{{ trans('worker-registration/worker-bank-details.accountnumber') }}</label>
                                        <div>{{ $worker_details->bankDetail->account_no ?? 'NA'}}</div>
                                    </div>
                                </div><!--end-->

                            </div>

                            <div class="custom-form">
                                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
            Family Details
        </span>
                                </h5>

                                <div class="row">
                                    <div class="col">
                                        <div class="table-responsive">
                                            <table class="table  text-center align-middle">
                                                <thead class="table-light">
                                                <tr>
                                                    <th>#</th>
                                                    <th>{{ trans('worker-registration/worker-family-details.fname') }}</th>
                                                    <th>{{ trans('worker-registration/worker-family-details.lname') }}</th>
                                                    <th>{{ trans('worker-registration/worker-family-details.dob') }}</th>
                                                    <th>{{ trans('worker-registration/worker-family-details.gname') }}</th>
                                                    <th>{{ trans('worker-registration/worker-family-details.relation') }}</th>
                                                    <th>{{ trans('worker-registration/worker-data-preview.nominee') }} (Y/N)</th>
                                                    <th>{{ trans('worker-registration/worker-family-details.nomineeshare') }}</th>
                                                    <th>{{ trans('worker-registration/worker-family-details.fdetails') }}?</th>
                                                    <th>BOCW ID</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach ($worker_details->familyDetails as $familyMember)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $familyMember->first_name ?? 'NA'}}</td>
                                                        <td>{{ $familyMember->last_name ?? 'NA'}}</td>
                                                        <td class="familydob">{{ \Carbon\Carbon::parse($familyMember->dob)->format('d-m-Y') ?? 'NA' }}</td>
                                                        <td>{{ $familyMember->guardain_name ?? 'N/A' }}</td>
                                                        <td>{{ $familyMember->relationDetails->relation_name ?? 'NA'}}</td>
                                                        <td>{{ $familyMember->nominee == 1 ? 'Yes' : 'No' }}</td>
                                                        <td>{{ $familyMember->nominee_percentage ?? 'N/A' }}</td>
                                                        <td>{{ $familyMember->already_registered == 1 ? 'Yes' : 'No' }}</td>
                                                        <td>{{ $familyMember->bocwwb_id ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>


                                    </div>
                                </div>

                            </div>
@if ($worker_details->certificates->count()> 0)


                            <div class="custom-form">
                                {{--<div class="form-row justify-content-center mt-3">--}}
                                    {{--<a href="javascript:void(0)"--}}
                                       {{--class="btn btn-primary px-4 py-2 edit-icon"--}}
                                       {{--style="border-radius: 5px; font-weight: bold;"--}}
                                       {{--data-url="{{ route('certificate-details', $worker_details->worker_id) }}">--}}
                                        {{--<i class="fas fa-pencil-alt"></i>&nbsp;Edit Certificate Details--}}
                                    {{--</a>--}}
                                {{--</div>--}}
                                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
            Certificate Details
        </span>
                                </h5>
                                <div class="row">
                                    <div class="col">
                                        <div class="table-container">
                                            <table class="table table-bordered text-center align-middle">
                                                <thead>
                                                <tr>
                                                    {{-- <th scope="col">Serial No</th> --}}
                                                    <th scope="col" class="bold"> {{ trans('worker-registration/worker-employer-details.issuertype') }}</th>
                                                    <th scope="col" class="bold"> {{ trans('worker-registration/worker-employer-details.orgname') }}
                                                    </th>
                                                    <th scope="col" class="bold">Issue Number</th>
                                                    <th scope="col" class="bold"> {{ trans('worker-registration/worker-employer-details.issuedate') }}</th>
                                                    <th scope="col" class="bold">{{ trans('worker-registration/worker-employer-details.issuepersonname') }}</th>
                                                    <th scope="col" class="bold">{{ trans('worker-registration/worker-employer-details.issuepersoncontact') }}</th>

                                                    <th scope="col" class="bold">{{ trans('worker-registration/worker-employer-details.employername') }}</th>
                                                    <th scope="col" class="bold">{{ trans('worker-registration/worker-employer-details.employercontactname') }}</th>
                                                    <th scope="col" class="bold">{{ trans('worker-registration/worker-employer-details.employercontactno') }}</th>
                                                    <th scope="col" class="bold">{{ trans('worker-registration/worker-employer-details.startdate') }}</th>
                                                    <th scope="col" class="bold">{{ trans('worker-registration/worker-employer-details.enddate') }}</th>
                                                    {{--                                                <th scope="col" class="bold">No of Days / দিনৰ সংখ্যা<span--}}
                                                    {{--                                                        class="text-danger">*</span></th>--}}
                                                    <th scope="col" class="bold">{{ trans('worker-registration/worker-employer-details.employertype') }}</th>
                                                    <th scope="col" class="bold">{{ trans('worker-registration/worker-employer-details.90daysworkingcertificate') }}</th>
                                                    <!-- Repeat headers as needed -->
                                                </tr>
                                                @foreach ($worker_details->certificates as $certificate)
                                                    <tr>


                                                        <td class="fixed-width">
                                                            {{ $certificate->typeOfIssuer->issuer_name ?? 'NA'}}</td>
                                                        <td class="fixed-width">
                                                            {{ $certificate->issuing_org ?? 'NA'}}</td>

                                                        <td class="fixed-width">
                                                            {{ \Carbon\Carbon::parse($certificate->issue_date)->format('d-m-Y') ?? 'NA'}}</td>


                                                        <td class="fixed-width">
                                                            {{ $certificate->issuing_person ?? 'NA'}}</td>
                                                        <td class="fixed-width">
                                                            {{ $certificate->contact_issuing_person ?? 'NA' }}</td>
                                                        <td class="fixed-width">
                                                            {{ $certificate->employer_name ?? 'NA'}}</td>
                                                        <td class="fixed-width">
                                                            {{ $certificate->employer_contact_name ?? 'NA'}}</td>
                                                        <td class="fixed-width">
                                                            {{ $certificate->employer_contact_number ?? 'NA' }}</td>
                                                        <td class="fixed-width">
                                                            {{ \Carbon\Carbon::parse($certificate->from_date)->format('d-m-Y') ?? 'NA'}}
                                                        </td>
                                                        <td class="fixed-width">
                                                            {{ \Carbon\Carbon::parse($certificate->to_date)->format('d-m-Y') ?? 'NA'}}
                                                        </td>

                                                        <td class="fixed-width">{{ $certificate->typeOfEmployer->employer_name ?? 'NA'}}</td>
                                                        <td class="fixed-width">
                                                            <a href="{{ route('get-cert-proof', ['id' => $certificate->id]) }}" class="href" target="_blank">
                                                                <i class="fa fa-external-link" aria-hidden="true"></i>&nbsp;View Certificate
                                                            </a>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($worker_details->workbooks->count()> 0)

                                <div class="custom-form">
                                    <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
            Workbook Details
        </span>
                                    </h5>


                                    <div class="row">
                                        <div class="col">
                                            <div class="table-container">
                                                <table class="table table-bordered text-center align-middle myworkbook1">
                                                    <thead>
                                                    <tr id="firsttr">


                                                        <th>Type Of Construction Work</th>
                                                        <th>Start Date </th>
                                                        <th>End Date</th>
                                                        <th>Working Days</th>
                                                        <th>Employer Name </th>
                                                        <th>Contact Number </th>
                                                        <th>Employer Type </th>
                                                        <th>Profession </th>
                                                        <th>Workbook </th>
                                                        <!-- Repeat headers as needed -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($worker_details->workbooks as $workbook)
                                                        <tr>

                                                            <td class="fixed-width">
                                                                {{ $workbook->typeOfWork->work_type_name ?? 'NA' }}</td>

                                                            <td class="fixed-width">
                                                                {{ \Carbon\Carbon::parse($workbook->from_date)->format('d-m-Y') ?? 'NA'}}
                                                            </td>
                                                            <td class="fixed-width">
                                                                {{ \Carbon\Carbon::parse($workbook->to_date)->format('d-m-Y') ?? 'NA'}}
                                                            </td>
                                                            <td class="fixed-width">
                                                                {{$workbook->date_count ?? 'NA'}}
                                                            </td>
                                                            <td class="fixed-width">
                                                                {{ $workbook->employer_name ?? 'NA'}}</td>
                                                            <td class="fixed-width">
                                                                {{ $workbook->employer_contact_number ?? 'NA'}}</td>
                                                            <td class="fixed-width">
                                                                {{ $workbook->typeOfEmployer->employer_name ?? 'NA'}}</td>
                                                            <td class="fixed-width">
                                                                @if ($workbook->professions->profession_code == 28)
                                                                    {{ $workbook->profession_others ?? $workbook->professions->profession_name }}
                                                                @else
                                                                    {{ $workbook->professions->profession_name ?? 'NA'}}
                                                                @endif
                                                            </td>

                                                            @if($workbook->certificate_proof)
                                                            <td class="fixed-width">
                                                                <a href="{{ route('view-work-book', ['id' => $workbook->id]) }}"
                                                                   class="href" target="_blank">
                                                                    &nbsp;View <i class="fa fa-external-link"
                                                                                           aria-hidden="true"></i>
                                                                </a>
                                                            </td>
                                                                @else
                                                                <td class="fixed-width">
                                                                    Optional
                                                                </td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="custom-form">
                                <h5 class="mt-4 d-flex align-items-center" style="color: #007bff;">
        <span style="border-left: 4px solid #007bff; padding-left: 10px;">
            Scheme Details
        </span>
                                </h5>
                                <div class="row">
                                    <div class="col">
                                        <div class="table-container">
                                            @if ($worker_details->schemeDetails->isEmpty())
                                                <tr>
                                                    <td colspan="5">No Scheme Availed</td>
                                                </tr>
                                            @else
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col" class="bold">{{ trans('worker-registration/worker-data-preview.schemes') }}</th>
                                                        <th scope="col" class="bold">{{ trans('worker-registration/worker-schemes-details.regno') }}</th>
                                                        <th scope="col" class="bold">{{ trans('worker-registration/worker-schemes-details.regdate') }}</th>
                                                    </tr>

                                                    @foreach ($worker_details->schemeDetails as $schemes)
                                                        @if ($schemes->enrolled == '0')
                                                            <tr>
                                                                <td>No data to display</td>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td>{{ $schemes->scheme->scheme_name ?? 'NA'}}</td>
                                                                <td>{{ $schemes->registration_id ?? 'NA'}}</td>
                                                                <td>{{ \Carbon\Carbon::parse($schemes->date)->format('d-m-y') ?? 'NA'}}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    @endif
                                                    </thead>
                                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row justify-content-center mt-3">

                                <div class="col-auto mr-2">
                                    <a href="{{ route('renew-application') }}" class="btn btn-sm btn-success"><i
                                            class="fa fa-backward" aria-hidden="true"></i>Edit for Correction</a>
                                </div>
                                <div class="col-auto mr-2">
                                    <a href="{{ route('download-preview') }}" target="_blank" class="btn btn-sm btn-warning"><i
                                                class="fa fa-download" aria-hidden="true"></i>Download PDF</a>
                                </div>
                                <!-- Button trigger modal -->
    <!-- Submit Button (Triggers Modal) -->

                            <button class="btn btn-sm btn-primary" id="saveRenewal" data-toggle="modal" data-target="#exampleModal">
                                <i class="fa fa-check-circle"></i>&nbsp;Submit Renewal Application
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header text-center d-block bg-primary">
                                            <h3 class="modal-title text-white" id="exampleModalLabel">Warning</h3>
                                        </div>
                                        <div class="modal-body">
                                            <h3 class="text-center">Are you ready to submit?</h3>
                                            <h6 class="text-danger mt-3">Note: No changes can be made after the final submission. Check all details carefully!</h6>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
                                            <a href="{{ route('save-renewal') }}" class="btn btn-success">Yes</a>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                function printPage() {
                    window.print();
                }
            </script>
        </div>
    </div><!-- End Left side columns -->
    </div>
</div>




@include('components.footer')
    <script src="{{URL::asset('assets/template/js/getVaultData.js')}}"></script>
<script>
    function calculateRenewedUpto(cardValidityDateStr, retirementDateStr) {
        if (!cardValidityDateStr || !retirementDateStr) return 'NA';

//        const today = new Date();
        const today = new Date();
        let cardValidityDate = new Date(cardValidityDateStr);
        const retirementDate = new Date(retirementDateStr);

        // Keep adding 2 years until card date is in the future
        while (cardValidityDate < today) {
            cardValidityDate.setFullYear(cardValidityDate.getFullYear() + 2);
        }

        // Choose earlier of the two dates
        let renewedUptoDate = (retirementDate < cardValidityDate) ? retirementDate : cardValidityDate;

        // Format date as dd-mm-yyyy
        const day = ('0' + renewedUptoDate.getDate()).slice(-2);
        const month = ('0' + (renewedUptoDate.getMonth() + 1)).slice(-2);
        const year = renewedUptoDate.getFullYear();

        return `${day}-${month}-${year}`;
    }

    document.addEventListener('DOMContentLoaded', function() {
        const cardValidityDate = document.getElementById('card_validity_date').value;
        const retirementDate = document.getElementById('retirement_date').value;

        const renewedUpto = calculateRenewedUpto(cardValidityDate, retirementDate);

        document.getElementById('renewed_upto_display').innerText = renewedUpto;
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dobStr = document.getElementById('dob').dataset.dob;
        const age = calculateAgeFromDDMMYYYY(dobStr);
        document.getElementById('age').textContent = age;
    });

    function calculateAgeFromDDMMYYYY(dobString) {
        const parts = dobString.split("-");
        const day = parseInt(parts[0], 10);
        const month = parseInt(parts[1], 10) - 1;
        const year = parseInt(parts[2], 10);

        const dob = new Date(year, month, day);
        const today = new Date();

        let age = today.getFullYear() - dob.getFullYear();
        const m = today.getMonth() - dob.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        return age;
    }
</script>


    <script>
        $(document).ready(function() {
            $('.edit-icon').on('click', function() {
                var url = $(this).data('url');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to proceed with editing?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, proceed!',
                    cancelButtonText: 'No, cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = url;
                    }
                });
            });
        });
    </script>

