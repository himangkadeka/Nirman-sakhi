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
                    <span class="badge badge-light text-primary">{{$application_name->name}}</span>
                </div>

                <div class="card-body">
                    <!-- Warning Alert -->
                    <div class="alert alert-warning border-warning">
                        <i class="fa fa-exclamation-triangle mr-2"></i>
                        <strong>Attention:</strong> Please review your details carefully. You cannot edit the application after clicking "Final Submit".
                    </div>

                    <!-- 1. BASIC & STUDENT DETAILS -->
                    <h5 class="text-primary border-bottom pb-2 mb-3">1. Applicant & Student Details</h5>
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
                                <td>{{ $application->district->district_name }}</td>
                                <th>Social Category</th>
                                <td>{{ $application->socialCategory->category_name }}</td>
                            </tr>
                            <tr>
                                <th>Student Name</th>
                                <td class="font-weight-bold">{{ $application->student_name }}</td>
                                <th>Date of Birth</th>
                                <td>
                                    {{ \Carbon\Carbon::parse($application->student_dob)->format('d-m-Y') }}
                                    (Age: {{ $application->student_age }})
                                </td>
                            </tr>
                            <tr>
                                <th>Parent's Address</th>
                                <td colspan="3">{{ $application->parent_address }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- 2. COURSE DETAILS -->
                    <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">2. Course Information</h5>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th class="w-25">College/Institution</th>
                                <td class="w-25">{{ $application->college_name }}</td>
                                <th class="w-25">University / Board</th>
                                <td>{{ $application->university_board }}</td>
                            </tr>
                            <tr>
                                <th>Course Name</th>
                                <td class="font-weight-bold text-uppercase">{{ $application->course_name }}</td>
                                <th>Course Duration</th>
                                <td>{{ $application->course_duration_years }} Years</td>
                            </tr>
                            <tr>
                                <th>Date of Admission</th>
                                <td colspan="3">{{ \Carbon\Carbon::parse($application->admission_date)->format('d-m-Y') }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- 3. ACADEMIC RECORD -->
                    <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">3. Academic Record (Qualifying Exam)</h5>
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Exam Name</th>
                                <th>Board</th>
                                <th>Passing Month/Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $application->qualifying_exam_name }}</td>
                                <td>{{ $application->qualifying_exam_board }}</td>
                                <td>{{ $application->qualifying_exam_year }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Marks Table -->
                    <h6>Marks Obtained Details:</h6>
                    <div class="table-responsive mb-3">
                        <table class="table table-sm table-bordered text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>Subject</th>
                                    <th>Total Marks</th>
                                    <th>Marks Obtained</th>
                                    <th>Percentage</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $marks = is_array($application->exam_marks) ? $application->exam_marks : json_decode($application->exam_marks, true);
                                    $grandTotal = 0;
                                    $grandObtained = 0;
                                @endphp

                                @if($marks)
                                    @foreach($marks as $mark)
                                        @if(!empty($mark['subject']))
                                        <tr>
                                            <td class="text-left">{{ $mark['subject'] }}</td>
                                            <td>{{ $mark['total'] }}</td>
                                            <td>{{ $mark['obtained'] }}</td>
                                            <td>{{ $mark['percentage'] }}%</td>
                                        </tr>
                                        @php
                                            $grandTotal += (float)$mark['total'];
                                            $grandObtained += (float)$mark['obtained'];
                                        @endphp
                                        @endif
                                    @endforeach
                                    <tr class="font-weight-bold bg-light">
                                        <td class="text-right">OVERALL AGGREGATE:</td>
                                        <td>{{ $grandTotal }}</td>
                                        <td>{{ $grandObtained }}</td>
                                        <td>
                                            {{ $grandTotal > 0 ? number_format(($grandObtained / $grandTotal) * 100, 2) : 0 }}%
                                        </td>
                                    </tr>
                                @else
                                    <tr><td colspan="4">No marks data entered.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- 4. BANK DETAILS -->
                    <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">4. Bank & Contribution Details</h5>
                    <table class="table table-bordered table-striped">
                        <tbody>
                            <tr>
                                <th class="w-25">Parents are Beneficiaries?</th>
                                <td class="w-25">{{ $application->parents_are_beneficiaries ? 'Yes' : 'No' }}</td>
                                <th class="w-25">Last Contribution Date</th>
                                <td>{{ \Carbon\Carbon::parse($application->last_contribution_date)->format('d-m-Y') }}</td>
                            </tr>
                            <tr>
                                <th>Bank Name</th>
                                <td>{{ $application->bank_name }}</td>
                                <th>Branch Name</th>
                                <td>{{ $application->branch_name }}</td>
                            </tr>
                            <tr>
                                <th>IFSC Code</th>
                                <td>{{ $application->ifsc_code }}</td>
                                <th>Account Number</th>
                                <td class="font-weight-bold">{{ $application->account_number }}</td>
                            </tr>
                            <tr>
                                <th>Branch Address</th>
                                <td colspan="3">{{ $application->branch_address ?? 'N/A' }}</td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- 5. ATTACHMENTS -->
                    <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">5. Uploaded Documents</h5>
                    <div class="row">
                        @php
                            $docs = [
                                'doc_bank_passbook' => 'Bank Passbook',
                                'doc_caste_certificate' => 'Caste Certificate',
                                'doc_pass_certificate' => 'Pass Certificate',
                                'doc_study_certificate' => 'Study Certificate',
                                'doc_admission_slip' => 'Admission Slip',
                                'doc_marksheet' => 'Exam Marksheet',
                                'doc_student_photo' => 'Student Photo',
                                'doc_student_signature' => 'Student Signature',
                                'doc_affidavit' => 'Affidavit'
                            ];
                        @endphp

                        @foreach($docs as $key => $label)
                            <div class="col-md-4 mb-3">
                                <div class="card card-body p-2 bg-light border">
                                    <small class="text-muted">{{ $label }}</small>
                                    @if(!empty($application->$key))
                                    <a href="{{ route('view-scholarship-docs',['path'=> $application->$key]) }}" target="_blank" class="text-primary font-weight-bold">
                                            <i class="fa fa-file-pdf"></i> View Document
                                        </a>
                                        {{-- <a href="{{ asset('storage/' . $application->$key) }}" target="_blank" class="text-primary font-weight-bold">
                                            <i class="fa fa-file-pdf"></i> View Document
                                        </a> --}}
                                    @else
                                        <span class="text-danger">Not Uploaded</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- ACTION FORM -->
                    <div class="border-top pt-4 mt-4">
                        <form action="{{route('submit-cash-award-application',$application->id,$application_name->benefit_code)}}" method="POST">
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
