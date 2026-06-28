@include('layout.workerheader')

<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')

    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')

        <div class="container py-5">
            <div class="card shadow border-primary">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Preview Application</h4>
                    <span class="badge badge-light text-primary">{{ $application_name->name ?? 'Marriage Assistance' }}</span>
                </div>

                <div class="card-body">
                    <div class="alert alert-warning border-warning">
                        <i class="fa fa-exclamation-triangle mr-2"></i>
                        <strong>Attention:</strong> Please review your details carefully. You cannot edit the application after clicking "Final Submit".
                    </div>

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
                                <th>Applicant Name</th>
                                <td class="font-weight-bold">{{ $application->applicant_name }}</td>
                                <th>Registration ID</th>
                                <td>{{ $application->worker->id_card }}</td>
                            </tr>
                            <tr>
                                <th>District</th>
                                <td>{{ $application->district->district_name ?? 'N/A' }}</td>
                                <th>Social Category</th>
                                <td>{{ $application->socialCategory->category_name }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth</th>
                                <td>
                                    {{ $application->applicant_dob ? \Carbon\Carbon::parse($application->applicant_dob)->format('d-m-Y') : 'N/A' }}
                                    (Age: {{ $application->applicant_age }})
                                </td>
                                <th>Applicant Address</th>
                                <td>{{ $application->applicant_address }}</td>
                            </tr>
                            <tr>
                                <th>Last Contribution Date</th>
                                <td>{{ $application->last_contribution_date ? \Carbon\Carbon::parse($application->last_contribution_date)->format('d-m-Y') : 'N/A' }}</td>
                                <th>Membership Duration</th>
                                <td>{{ $application->membership_duration }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">2. Marriage Information</h5>

                    @if($application->is_for_son_daughter === 'Yes')
                        <h6 class="font-weight-bold text-secondary mb-2">Application for Marriage of: Son / Daughter</h6>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th class="w-25">Date of Birth (Son/Daughter)</th>
                                    <td class="w-25">{{ $application->child_dob ? \Carbon\Carbon::parse($application->child_dob)->format('d-m-Y') : 'N/A' }}</td>
                                    <th class="w-25">Name of Bride/Groom</th>
                                    <td>{{ $application->child_spouse_name ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Date of Marriage</th>
                                    <td>{{ $application->child_marriage_date ? \Carbon\Carbon::parse($application->child_marriage_date)->format('d-m-Y') : 'N/A' }}</td>
                                    <th>Marriage Number</th>
                                    <td>{{ $application->child_marriage_number ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Address of Bride/Groom</th>
                                    <td colspan="3">{{ $application->child_spouse_address ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Is Spouse a Registered Beneficiary?</th>
                                    <td>{{ $application->spouse_is_beneficiary ?? 'N/A' }}</td>
                                    <th>Has Spouse Applied for Assistance?</th>
                                    <td>{{ $application->spouse_applied_assistance ?? 'N/A' }}</td>
                                </tr>
                                @if($application->spouse_is_beneficiary === 'Yes')
                                <tr>
                                    <th>Spouse Registration Details</th>
                                    <td colspan="3">{{ $application->spouse_reg_details ?? 'N/A' }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <th>Marriage Certificate No.</th>
                                    <td>{{ $application->child_marriage_cert_no ?? 'N/A' }}</td>
                                    <th>Certificate Date</th>
                                    <td>{{ $application->child_marriage_cert_date ? \Carbon\Carbon::parse($application->child_marriage_cert_date)->format('d-m-Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Issuing Authority</th>
                                    <td>{{ $application->child_marriage_cert_authority ?? 'N/A' }}</td>
                                    <th>Authority Address</th>
                                    <td>{{ $application->child_marriage_cert_auth_address ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Other Son/Daughter Assistance Details</th>
                                    <td colspan="3">{{ $application->other_child_assistance_details ?? 'None' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <h6 class="font-weight-bold text-secondary mb-2">Application for Marriage of: Self (Female Worker)</h6>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th class="w-25">Name of Bridegroom</th>
                                    <td class="w-25">{{ $application->self_bridegroom_name ?? 'N/A' }}</td>
                                    <th class="w-25">Date of Marriage</th>
                                    <td>{{ $application->self_marriage_date ? \Carbon\Carbon::parse($application->self_marriage_date)->format('d-m-Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Place of Marriage</th>
                                    <td>{{ $application->self_marriage_place ?? 'N/A' }}</td>
                                    <th>Address of Bridegroom</th>
                                    <td>{{ $application->self_bridegroom_address ?? 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Marriage Certificate No.</th>
                                    <td>{{ $application->self_marriage_cert_no ?? 'N/A' }}</td>
                                    <th>Certificate Date</th>
                                    <td>{{ $application->self_marriage_cert_date ? \Carbon\Carbon::parse($application->self_marriage_cert_date)->format('d-m-Y') : 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Issuing Authority</th>
                                    <td>{{ $application->self_marriage_cert_authority ?? 'N/A' }}</td>
                                    <th>Authority Address</th>
                                    <td>{{ $application->self_marriage_cert_auth_address ?? 'N/A' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @endif

                    <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">3. Financial Details</h5>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th class="w-50">Are You in Receipt of Any Financial Assistance for this Purpose from Govt/Other Institution?</th>
                                <td>
                                    @if($application->received_other_assistance === 'Yes')
                                        <span class="badge badge-danger px-3 py-2 text-uppercase">Yes</span>
                                    @else
                                        <span class="badge badge-success px-3 py-2 text-uppercase">No</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">4. Uploaded Documents</h5>
                    <div class="row">
                        @php
                            $docs = [
                                'doc_bank_passbook' => 'Photocopy of A/c paybook',
                                'doc_invitation_card' => 'Marriage Invitation Card',
                                'doc_age_proof' => 'Age Proof of Bride/Groom',
                                'doc_marriage_certificate' => 'Marriage Certificate',
                                'doc_photographs' => 'Bride & Groom Photograph',
                                'doc_signatures' => 'Thumb Impression/Signature'
                            ];
                        @endphp

                        @foreach($docs as $key => $label)
                            <div class="col-md-4 mb-3">
                                <div class="card card-body p-2 bg-light border">
                                    <small class="text-muted">{{ $label }}</small>
                                    @if(!empty($application->$key))
                                        <div class="mt-1">
                                            <a href="{{ route('view-scholarship-docs',['path'=> $application->$key]) }}" target="_blank" class="text-primary font-weight-bold">
                                                <i class="fa fa-file-pdf"></i> View Document
                                            </a>
                                        </div>
                                    @else
                                        <div class="mt-1">
                                            <span class="text-danger"><i class="fa fa-times-circle"></i> Not Uploaded</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-top pt-4 mt-4">
                        {{-- Make sure to update the route to point to your final submit controller method --}}
                        <form action="{{ route('submit-marriage-assistance-application', [$application->id, $application_name->benefit_code ?? '']) }}" method="POST">
                            @csrf

                            <div class="form-check mb-4 p-3 bg-light border rounded">
                                <input class="form-check-input ml-2" type="checkbox" required id="declare" style="transform: scale(1.5);">
                                <label class="form-check-label ml-4 font-weight-bold" for="declare">
                                    &nbsp;I hereby declare that the details furnished above are true and correct to the best of my knowledge.
                                    I understand that providing false information will lead to rejection of my application.
                                </label>
                            </div>

                            <div class="text-center">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary btn-lg mr-3 px-4">
                                    <i class="fa fa-edit"></i> Edit Details
                                </a>

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
