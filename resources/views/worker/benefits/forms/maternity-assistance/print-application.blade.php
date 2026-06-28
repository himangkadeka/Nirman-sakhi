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

        .text-success { color: green; font-weight: bold; }
        .text-danger { color: red; font-weight: bold; }
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

        @if ($application->benefit->benefit_code == 'MT')

            <!-- 1. APPLICANT DETAILS -->
            <div class="sub-title">1. Applicant Details</div>
            <table>
                <tbody>
                    <tr>
                        <th>Applicant Name</th>
                        <td><b>{{ $application_data->applicant_name }}</b></td>
                        <th>Application Date</th>
                        <td>{{ $application_data->application_date ? \Carbon\Carbon::parse($application_data->application_date)->format('d-m-Y') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>District</th>
                        <td>{{ $application_data->district->district_name ?? 'N/A' }}</td>
                        <th>BOCW Registration No.</th>
                        <td>{{ $workerData->id_card }}</td>
                    </tr>
                    <tr>
                        <th>Name of Applicant</th>
                        <td><b>{{ $application_data->applicant_name }}</b></td>
                        <th>Name of Husband</th>
                        <td>{{ $application_data->husband_name }}</td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td>
                            {{ \Carbon\Carbon::parse($application_data->applicant_dob)->format('d-m-Y') }}
                            (Age: {{ $application_data->applicant_age }})
                        </td>
                        <th>Applicant Address</th>
                        <td>{{ $application_data->applicant_address }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- 2. MATERNITY INFORMATION -->
            <div class="sub-title">2. Maternity Information</div>
            <table>
                <tbody>
                    <tr>
                        <th>Date of Confinement (Childbirth)</th>
                        <td><b>{{ \Carbon\Carbon::parse($application_data->date_of_confinement)->format('d-m-Y') }}</b></td>
                        <th>Hospital Name</th>
                        <td>{{ $application_data->hospital_name }}</td>
                    </tr>
                    <tr>
                        <th>Hospital Address</th>
                        <td colspan="3">{{ $application_data->hospital_address }}</td>
                    </tr>
                    <tr>
                        <th>Applied Earlier?</th>
                        <td colspan="3">{{ $application_data->applied_earlier }}</td>
                    </tr>
                    @if($application_data->applied_earlier == 'Yes')
                    <tr>
                        <th>Times Applied Earlier</th>
                        <td>{{ $application_data->times_applied_earlier }}</td>
                        <th>Previous Details</th>
                        <td>{{ $application_data->previous_application_details }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>

            <!-- 3. BANK DETAILS -->
            <div class="sub-title">3. Bank Account & Contribution Details</div>
            <table>
                <tbody>
                    <tr>
                        <th>Last Contribution Date</th>
                        <td colspan="3">{{ \Carbon\Carbon::parse($application_data->last_contribution_date)->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Bank Name</th>
                        <td>{{ $application_data->bank_name }}</td>
                        <th>IFSC Code</th>
                        <td>{{ $application_data->ifsc_code }}</td>
                    </tr>
                    <tr>
                        <th>Account Number</th>
                        <td><b>{{ $application_data->bank_account_number }}</b></td>
                        <th>Branch Address</th>
                        <td>{{ $application_data->branch_address }}</td>
                    </tr>
                </tbody>
            </table>

            <!-- 4. ATTACHMENTS -->
            <div class="sub-title">4. Uploaded Documents</div>
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
                            'doc_account_paybook' => 'Photocopy of Account Paybook',
                            'doc_medical_certificate' => 'Medical / Birth Certificate of Child'
                        ];
                    @endphp

                    @foreach($docs as $key => $label)
                        <tr>
                            <td>{{ $label }}</td>
                            <td>
                                @if(!empty($application_data->$key))
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
