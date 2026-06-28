@include('layout.workerheader')

<div class="d-flex" id="wrapper">
    <!-- Include Left Menu -->
    @include('worker.leftmenu')

    <div id="page-content-wrapper">
        <!-- Include Navbar -->
        @include('components.worker.ui.navbar')

        <div class="container py-5">
            <div class="card shadow border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Preview Application</h4>
                    <span class="badge badge-light text-primary">{{$application_name->name ?? 'Maternity Assistance'}}</span>
                </div>

                <div class="card-body">
                    <!-- Warning Alert -->
                    <div class="alert alert-warning border-warning">
                        <i class="fa fa-exclamation-triangle mr-2"></i>
                        <strong>Attention:</strong> Please review your details carefully. You cannot edit the application after clicking "Final Submit".
                    </div>

                    <!-- 1. APPLICANT DETAILS -->
                    <h5 class="text-primary border-bottom pb-2 mb-3">1. Applicant Details</h5>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th class="w-25">Application Number</th>
                                <td class="w-25 font-weight-bold">{{ $application->application_number }}</td>
                                <th class="w-25">Application Date</th>
                                <td>{{ $application->application_date ? \Carbon\Carbon::parse($application->application_date)->format('d-m-Y') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>District</th>
                                <td>{{ $application->district->district_name ?? 'N/A' }}</td>
                                <th>BOCW Registration No.</th>
                                <td>{{ $application->bocw_registration_number }}</td>
                            </tr>
                            <tr>
                                <th>Name of Applicant</th>
                                <td class="font-weight-bold">{{ $application->applicant_name }}</td>
                                <th>Name of Husband</th>
                                <td>{{ $application->husband_name }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>
                                    {{ \Carbon\Carbon::parse($application->applicant_dob)->format('d-m-Y') }}
                                    (Age: {{ $application->applicant_age }})
                                </td>
                                <th>Date of Last Contribution</th>
                                <td>{{ \Carbon\Carbon::parse($application->last_contribution_date)->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <th>Applicant Address</th>
                                <td colspan="3">{{ $application->applicant_address }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- 2. MATERNITY INFORMATION -->
                    <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">2. Maternity Information</h5>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th class="w-25">Date of Confinement (Childbirth)</th>
                                <td class="w-25 font-weight-bold">{{ \Carbon\Carbon::parse($application->date_of_confinement)->format('d-m-Y') }}</td>
                                <th class="w-25">Name of Hospital</th>
                                <td>{{ $application->hospital_name }}</td>
                            </tr>
                            <tr>
                                <th>Hospital Address</th>
                                <td colspan="3">{{ $application->hospital_address }}</td>
                            </tr>
                            <tr>
                                <th>Applied Earlier?</th>
                                <td colspan="3">
                                    <span class="badge {{ $application->applied_earlier == 'Yes' ? 'badge-warning' : 'badge-success' }}">
                                        {{ $application->applied_earlier }}
                                    </span>
                                </td>
                            </tr>
                            @if($application->applied_earlier == 'Yes')
                            <tr>
                                <th>Times Applied Earlier</th>
                                <td>{{ $application->times_applied_earlier }}</td>
                                <th>Previous Application Details</th>
                                <td>{{ $application->previous_application_details }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>

                    <!-- 3. BANK DETAILS -->
                    <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">3. Bank Account Details</h5>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th class="w-25">Bank Name</th>
                                <td class="w-25">{{ $application->bank_name }}</td>
                                <th class="w-25">IFSC Code</th>
                                <td>{{ $application->ifsc_code }}</td>
                            </tr>
                            <tr>
                                <th>Account Number</th>
                                <td class="font-weight-bold">{{ $application->bank_account_number }}</td>
                                <th>Branch Address</th>
                                <td>{{ $application->branch_address }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- 4. ATTACHMENTS -->
                    <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">4. Uploaded Documents</h5>
                    <div class="row">
                        @php
                            $docs = [
                                'doc_account_paybook' => 'Photocopy of Account Paybook',
                                'doc_medical_certificate' => 'Medical / Birth Certificate of Child'
                            ];
                        @endphp

                        @foreach($docs as $key => $label)
                            <div class="col-md-6 mb-3">
                                <div class="card card-body p-3 bg-light border align-items-center flex-row justify-content-between">
                                    <span class="font-weight-bold text-secondary">{{ $label }}</span>
                                    @if(!empty($application->$key))
                                        <a href="{{ asset('storage/' . $application->$key) }}" target="_blank" class="btn btn-outline-primary btn-sm">
                                            <i class="fa fa-file-pdf"></i> View
                                        </a>
                                    @else
                                        <span class="text-danger font-weight-bold"><i class="fa fa-times-circle"></i> Not Uploaded</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- ACTION FORM -->
                    <div class="border-top pt-4 mt-4">
                        <form action="{{ route('submit-maternity-assistance-application', [$application->id, $application_name->benefit_code ?? '']) }}" method="POST">
                            @csrf

                            <div class="form-check mb-4 p-3 bg-light border rounded">
                                <input class="form-check-input ml-2" type="checkbox" required id="declare" style="transform: scale(1.5);">
                                <label class="form-check-label ml-4 font-weight-bold" for="declare">
                                    I hereby declare that the details furnished above are true and correct to the best of my knowledge.
                                    I understand that providing false information will lead to rejection of my application.
                                </label>
                            </div>

                            <div class="text-center">
                                <!-- Back/Edit Button -->
                                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-lg mr-3 px-4">
                                    <i class="fa fa-edit"></i> Edit Details
                                </a>

                                <!-- Final Submit Button -->
                                <button type="submit" class="btn btn-success btn-lg px-5">
                                    Final Submit <i class="fa fa-check-circle ml-1"></i>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
