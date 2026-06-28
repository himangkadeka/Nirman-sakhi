<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $application->benefit->name }} - {{ $application->application_number }}</title>
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

        .sub-title {
            color: #007bff;
            border-bottom: 1px solid #ccc;
            padding-bottom: 5px;
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 14px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        td, th {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            width: 25%;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-success { color: green; font-weight: bold; }
        .text-danger { color: red; font-weight: bold; }
        .bg-light { background-color: #f8f9fa; }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <div class="emblem"><img src="{{ $emblem ?? asset('assets/images/emblem.png') }}" alt="Emblem"></div>
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

        @if ($application->benefit->benefit_code == 'CE')

            <!-- 1. BASIC & STUDENT DETAILS -->
            <div class="sub-title">1. Applicant & Student Details</div>
            <table>
                <tbody>
                    <tr>
                        <th>Application Number</th>
                        <td><b>{{ $application_data->application_number }}</b></td>
                        <th>Application Date</th>
                        <td>{{ $application_data->application_date ? \Carbon\Carbon::parse($application_data->application_date)->format('d-m-Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>District</th>
                        <td>{{ $application_data->district->district_name ?? 'N/A' }}</td>
                        <th>Social Category</th>
                        <td>{{ $application_data->socialCategory->category_name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Student Name</th>
                        <td><b>{{ $application_data->student_name }}</b></td>
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
            <div class="sub-title">2. Course Information</div>
            <table>
                <tbody>
                    <tr>
                        <th>College/Institution</th>
                        <td>{{ $application_data->college_name }}</td>
                        <th>University / Board</th>
                        <td>{{ $application_data->university_board }}</td>
                    </tr>
                    <tr>
                        <th>Course Name</th>
                        <td><b>{{ strtoupper($application_data->course_name) }}</b></td>
                        <th>Course Duration</th>
                        <td>{{ $application_data->course_duration_years }} Years</td>
                    </tr>
                    <tr>
                        <th>Date of Admission</th>
                        <td colspan="3">{{ \Carbon\Carbon::parse($application_data->admission_date)->format('d-m-Y') }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- 3. ACADEMIC RECORD -->
            <div class="sub-title">3. Academic Record (Qualifying Exam)</div>
            <table>
                <thead>
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
            <p style="font-weight: bold; margin-bottom: 5px;">Marks Obtained Details:</p>
            <table>
                <thead class="bg-light text-center">
                    <tr>
                        <th style="width: 40%;">Subject</th>
                        <th style="width: 20%;">Total Marks</th>
                        <th style="width: 20%;">Marks Obtained</th>
                        <th style="width: 20%;">Percentage</th>
                    </tr>
                </thead>
                <tbody class="text-center">
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
                                    <td style="text-align: left;">{{ $mark['subject'] }}</td>
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
                        <tr class="bg-light" style="font-weight: bold;">
                            <td class="text-right">OVERALL AGGREGATE:</td>
                            <td>{{ $grandTotal }}</td>
                            <td>{{ $grandObtained }}</td>
                            <td>{{ $grandTotal > 0 ? number_format(($grandObtained / $grandTotal) * 100, 2) : 0 }}%</td>
                        </tr>
                    @else
                        <tr>
                            <td colspan="4">No marks data entered.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <!-- 4. BANK DETAILS -->
            <div class="sub-title">4. Bank & Contribution Details</div>
            <table>
                <tbody>
                    <tr>
                        <th>Parents are Beneficiaries?</th>
                        <td>{{ $application_data->parents_are_beneficiaries ? 'Yes' : 'No' }}</td>
                        <th>Last Contribution Date</th>
                        <td>{{ \Carbon\Carbon::parse($application_data->last_contribution_date)->format('d-m-Y') }}</td>
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
                        <td><b>{{ $application_data->account_number }}</b></td>
                    </tr>
                    <tr>
                        <th>Branch Address</th>
                        <td colspan="3">{{ $application_data->branch_address ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- 5. ATTACHMENTS -->
            <div class="sub-title">5. Uploaded Documents</div>
            <table>
                <thead>
                    <tr>
                        <th>Document Name</th>
                        <th>Upload Status</th>
                    </tr>
                </thead>
                <tbody>
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
                        <tr>
                            <td>{{ $label }}</td>
                            <td>
                                @if (!empty($application_data->$key))
                                    <span class="text-success">✔ Uploaded</span>
                                @else
                                    <span class="text-danger">✖ Not Uploaded</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    </div>

</body>
</html>
