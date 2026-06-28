<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $application->benefit->name }} - {{ $application->application_id }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .emblem img {
            width: 80px;
            height: auto;
        }

        .header h2 {
            margin: 5px 0;
            text-transform: uppercase;
        }

        .header h3 {
            margin: 5px 0;
            font-weight: normal;
            color: #555;
        }

        .section-title {
            background-color: #e9ecef;
            padding: 8px;
            font-weight: bold;
            margin-top: 20px;
            margin-bottom: 10px;
            border: 1px solid #dee2e6;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td,
        th {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            width: 30%;
        }

        .footer {
            margin-top: 40px;
            font-size: 11px;
            color: #777;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <div class="emblem"><img src="{{ $emblem }}"></div>
            <h2>Assam Building & Other Construction Workers' Welfare Board</h2>
            <h3>Government of Assam | Labour Welfare Department</h3>
            <br>
            <h2>{{ $application->benefit->name }}</h2>

        </div>

        <!-- Application Details -->
        <div class="section-title">APPLICATION DETAILS</div>
        <table>
            <tr>
                <th>Application ID</th>
                <td><strong>{{ $application->application_id }}</strong></td>
            </tr>
            <tr>
                <th>Benefit Name</th>
                <td>{{ $application->benefit->name }}</td>
            </tr>
            <tr>
                <th>Office Name</th>
                <td>{{ $workerData->officeName->office_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Submission Date</th>
                <td>{{ \Carbon\Carbon::parse($application->submitted_at)->format('d F, Y h:i A') }}</td>
            </tr>
        </table>

        <!-- Worker Details -->
        <div class="section-title">WORKER'S BASIC DETAILS</div>
        <table>
            <tr>
                <th>Worker's Name</th>
                <td>{{ $getVaultData['name'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Aadhaar Number</th>
                <td>{{ $getVaultData['uID'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Date of Birth</th>
                <td>{{ $getVaultData['dob'] ?? 'N/A' }}</td>
            </tr>
        </table>

        <!-- Submitted Form Data -->
        <div class="section-title">SUBMITTED APPLICATION DATA</div>
        <table>

                @if ($application->benefit->benefit_code=='EA')
                    <div class="container py-5">
                    <div class="card shadow border-primary">


                        <div class="card-body">
                            <!-- Warning Alert -->
                            {{-- <div class="alert alert-warning border-warning">
                        <i class="fa fa-exclamation-triangle mr-2"></i>
                        <strong>Attention:</strong> Please review your details carefully. You cannot edit the application after clicking "Final Submit".
                    </div> --}}

                            <!-- 1. BASIC & STUDENT DETAILS -->
                            <h5 class="text-primary border-bottom pb-2 mb-3">1. Applicant & Student Details</h5>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th class="w-25">Application Number</th>
                                        <td class="w-25 font-weight-bold">{{ $application_data->application_number }}</td>
                                        <th class="w-25">Application Date</th>
                                        <td>{{ $application_data->application_date ? \Carbon\Carbon::parse($application_data->application_date)->format('d-m-Y') : 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>District</th>
                                        <td>{{ $application_data->district->district_name }}</td>
                                        <th>Social Category</th>
                                        <td>{{ $application_data->socialCategory->category_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Student Name</th>
                                        <td class="font-weight-bold">{{ $application_data->student_name }}</td>
                                        <th>Date of Birth</th>
                                        <td>
                                            {{ \Carbon\Carbon::parse($application_data->student_dob)->format('d-m-Y') }}
                                            (Age: {{ $application_data->student_age }})
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Parent's Address</th>
                                        <td colspan="3">{{ $application_data->parent_address }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <!-- 2. COURSE DETAILS -->
                            <h5 class="text-primary border-bottom pb-2 mb-3 mt-4">2. Course Information</h5>
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr>
                                        <th class="w-25">College/Institution</th>
                                        <td class="w-25">{{ $application_data->college_name }}</td>
                                        <th class="w-25">University / Board</th>
                                        <td>{{ $application_data->university_board }}</td>
                                    </tr>
                                    <tr>
                                        <th>Course Name</th>
                                        <td class="font-weight-bold text-uppercase">{{ $application_data->course_name }}</td>
                                        <th>Course Duration</th>
                                        <td>{{ $application_data->course_duration_years }} Years</td>
                                    </tr>
                                    <tr>
                                        <th>Date of Admission</th>
                                        <td colspan="3">
                                            {{ \Carbon\Carbon::parse($application_data->admission_date)->format('d-m-Y') }}
                                        </td>
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
                                        <td>{{ $application_data->qualifying_exam_name }}</td>
                                        <td>{{ $application_data->qualifying_exam_board }}</td>
                                        <td>{{ $application_data->qualifying_exam_year }}</td>
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
                                            $marks = is_array($application_data->exam_marks)
                                                ? $application_data->exam_marks
                                                : json_decode($application_data->exam_marks, true);
                                            $grandTotal = 0;
                                            $grandObtained = 0;
                                        @endphp

                                        @if ($marks)
                                            @foreach ($marks as $mark)
                                                @if (!empty($mark['subject']))
                                                    <tr>
                                                        <td class="text-left">{{ $mark['subject'] }}</td>
                                                        <td>{{ $mark['total'] }}</td>
                                                        <td>{{ $mark['obtained'] }}</td>
                                                        <td>{{ $mark['percentage'] }}%</td>
                                                    </tr>
                                                    @php
                                                        $grandTotal += (float) $mark['total'];
                                                        $grandObtained += (float) $mark['obtained'];
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
                                            <tr>
                                                <td colspan="4">No marks data entered.</td>
                                            </tr>
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
                                        <td class="w-25">{{ $application_data->parents_are_beneficiaries ? 'Yes' : 'No' }}
                                        </td>
                                        <th class="w-25">Last Contribution Date</th>
                                        <td>{{ \Carbon\Carbon::parse($application_data->last_contribution_date)->format('d-m-Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Bank Name</th>
                                        <td>{{ $application_data->bank_name }}</td>
                                        <th>Branch Name</th>
                                        <td>{{ $application_data->branch_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>IFSC Code</th>
                                        <td>{{ $application_data->ifsc_code }}</td>
                                        <th>Account Number</th>
                                        <td class="font-weight-bold">{{ $application_data->account_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>Branch Address</th>
                                        <td colspan="3">{{ $application_data->branch_address ?? 'N/A' }}</td>
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
                                        'doc_affidavit' => 'Affidavit',
                                    ];
                                @endphp

                                @foreach ($docs as $key => $label)
                                    <div class="col-md-4 mb-3">
                                        <div class="card card-body p-2 bg-light border">
                                            <small class="text-muted">{{ $label }}</small>
                                            @if (!empty($application_data->$key))
                                                <a href="{{ route('view-scholarship-docs',['path'=> $application->$key]) }}" target="_blank"
                                                    class="text-primary font-weight-bold">
                                                    <i class="fa fa-file-pdf"></i> View Document
                                                </a>
                                            @else
                                                <span class="text-danger">Not Uploaded</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- ACTION FORM -->
                            {{-- <div class="border-top pt-4 mt-4">
                        <form action="{{route('final-submit-education-scholarship-application',$application->id)}}" method="POST">
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
                    </div> --}}

                        </div>
                    </div>
                </div>

                @endif
        </div>

    </body>

    </html>
