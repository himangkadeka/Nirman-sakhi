<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $application->benefit->name ?? 'Marriage Assistance' }} - {{ $application_data->application_number ?? '' }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #333;
            line-height: 1.5;
        }

        .container {
            width: 90%;
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
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
            font-size: 18px;
            text-transform: uppercase;
        }

        .header h3 {
            margin: 5px 0;
            font-size: 14px;
            font-weight: normal;
            color: #555;
        }

        .section-title {
            background-color: #e9ecef;
            padding: 8px;
            font-weight: bold;
            font-size: 14px;
            margin-top: 25px;
            margin-bottom: 10px;
            border: 1px solid #dee2e6;
            text-align: center;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        td, th {
            border: 1px solid #aaa;
            padding: 8px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            width: 25%;
        }

        .footer {
            margin-top: 50px;
            font-size: 11px;
            color: #777;
            text-align: center;
            border-top: 1px dashed #ccc;
            padding-top: 10px;
        }

        .signature-section {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
        }

        .signature-line {
            border-top: 1px solid #000;
            width: 250px;
            text-align: center;
            padding-top: 5px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="header">
            <div class="emblem"><img src="{{ $emblem ?? asset('images/emblem.png') }}" alt="Emblem"></div>
            <h2>Assam Building & Other Construction Workers' Welfare Board</h2>
            <h3>Government of Assam | Labour Welfare Department</h3>
            <br>
            <h2>Application for Marriage Assistance</h2>
        </div>

        <div class="section-title">APPLICATION DETAILS</div>
        <table>
            <tr>
                <th>Application ID</th>
                <td><strong>{{ $application_data->application_number }}</strong></td>
                <th>Date of Application</th>
                <td>{{ $application_data->application_date ? \Carbon\Carbon::parse($application_data->application_date)->format('d-m-Y') : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Submission Status</th>
                <td><strong>{{ $application_data->status }}</strong></td>
                <th>District</th>
                <td>{{ $application_data->district->district_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>Office Name</th>
                <td>{{ $workerData->officeName->office_name ?? 'N/A' }}</td>
            </tr>
        </table>

        <div class="section-title">WORKER'S BASIC DETAILS</div>
        <table>
            <tr>
                <th>Worker's Name</th>
                <td>{{ $application_data->applicant_name }}</td>
                <th>BOCW Reg. Number</th>
                <td>{{ $application_data->registration_id }}</td>
            </tr>
            <tr>
                <th>Date of Birth</th>
                <td>{{ $application_data->applicant_dob ? \Carbon\Carbon::parse($application_data->applicant_dob)->format('d-m-Y') : 'N/A' }} (Age: {{ $application_data->applicant_age }})</td>
                <th>Social Category</th>
                <td>{{ $application_data->social_category }}</td>
            </tr>
            <tr>
                <th>Applicant's Address</th>
                <td colspan="3">{{ $application_data->applicant_address }}</td>
            </tr>
            <tr>
                <th>Last Contribution Date</th>
                <td>{{ $application_data->last_contribution_date ? \Carbon\Carbon::parse($application_data->last_contribution_date)->format('d-m-Y') : 'N/A' }}</td>
                <th>Membership Duration</th>
                <td>{{ $application_data->membership_duration }}</td>
            </tr>
        </table>

        <div class="section-title">MARRIAGE DETAILS</div>
        <table>
            <tr>
                <th>Application For</th>
                <td colspan="3">
                    @if($application_data->is_for_son_daughter === 'Yes')
                        <strong>Marriage of Son / Daughter</strong>
                    @else
                        <strong>Marriage of Self (Female Worker)</strong>
                    @endif
                </td>
            </tr>

            @if($application_data->is_for_son_daughter === 'Yes')
                <tr>
                    <th>Child's Date of Birth</th>
                    <td>{{ $application_data->child_dob ? \Carbon\Carbon::parse($application_data->child_dob)->format('d-m-Y') : 'N/A' }}</td>
                    <th>Name of Bride/Groom</th>
                    <td>{{ $application_data->child_spouse_name }}</td>
                </tr>
                <tr>
                    <th>Date of Marriage</th>
                    <td>{{ $application_data->child_marriage_date ? \Carbon\Carbon::parse($application_data->child_marriage_date)->format('d-m-Y') : 'N/A' }}</td>
                    <th>Marriage Number</th>
                    <td>{{ $application_data->child_marriage_number }}</td>
                </tr>
                <tr>
                    <th>Address of Bride/Groom</th>
                    <td colspan="3">{{ $application_data->child_spouse_address }}</td>
                </tr>
                <tr>
                    <th>Spouse is Registered Beneficiary?</th>
                    <td>{{ $application_data->spouse_is_beneficiary }}</td>
                    <th>Spouse Applied for Assistance?</th>
                    <td>{{ $application_data->spouse_applied_assistance ?? 'N/A' }}</td>
                </tr>
                @if($application_data->spouse_is_beneficiary === 'Yes')
                <tr>
                    <th>Spouse Registration Details</th>
                    <td colspan="3">{{ $application_data->spouse_reg_details }}</td>
                </tr>
                @endif
                <tr>
                    <th>Marriage Cert. No.</th>
                    <td>{{ $application_data->child_marriage_cert_no ?? 'N/A' }}</td>
                    <th>Certificate Date</th>
                    <td>{{ $application_data->child_marriage_cert_date ? \Carbon\Carbon::parse($application_data->child_marriage_cert_date)->format('d-m-Y') : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Issuing Authority</th>
                    <td colspan="3">{{ $application_data->child_marriage_cert_authority ?? 'N/A' }} <br> <small>{{ $application_data->child_marriage_cert_auth_address ?? '' }}</small></td>
                </tr>
                <tr>
                    <th>Assistance for Other Child?</th>
                    <td colspan="3">{{ $application_data->other_child_assistance_details ?? 'No' }}</td>
                </tr>
            @else
                <tr>
                    <th>Name of Bridegroom</th>
                    <td>{{ $application_data->self_bridegroom_name }}</td>
                    <th>Date of Marriage</th>
                    <td>{{ $application_data->self_marriage_date ? \Carbon\Carbon::parse($application_data->self_marriage_date)->format('d-m-Y') : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Place of Marriage</th>
                    <td>{{ $application_data->self_marriage_place }}</td>
                    <th>Address of Bridegroom</th>
                    <td>{{ $application_data->self_bridegroom_address }}</td>
                </tr>
                <tr>
                    <th>Marriage Cert. No.</th>
                    <td>{{ $application_data->self_marriage_cert_no ?? 'N/A' }}</td>
                    <th>Certificate Date</th>
                    <td>{{ $application_data->self_marriage_cert_date ? \Carbon\Carbon::parse($application_data->self_marriage_cert_date)->format('d-m-Y') : 'N/A' }}</td>
                </tr>
                <tr>
                    <th>Issuing Authority</th>
                    <td colspan="3">{{ $application_data->self_marriage_cert_authority ?? 'N/A' }} <br> <small>{{ $application_data->self_marriage_cert_auth_address ?? '' }}</small></td>
                </tr>
            @endif
        </table>

        <div class="section-title">FINANCIAL & DOCUMENT DETAILS</div>
        <table>
            <tr>
                <th>Received Other Govt. Assistance?</th>
                <td colspan="3">{{ $application_data->received_other_assistance }}</td>
            </tr>
            <tr>
                <th>Photocopy of Passbook</th>
                <td>{{ $application_data->doc_bank_passbook ? 'Yes (Uploaded)' : 'No' }}</td>
                <th>Marriage Invitation Card</th>
                <td>{{ $application_data->doc_invitation_card ? 'Yes (Uploaded)' : 'No' }}</td>
            </tr>
            <tr>
                <th>Age Proof of Bride/Groom</th>
                <td>{{ $application_data->doc_age_proof ? 'Yes (Uploaded)' : 'No' }}</td>
                <th>Marriage Certificate</th>
                <td>{{ $application_data->doc_marriage_certificate ? 'Yes (Uploaded)' : 'No' }}</td>
            </tr>
            <tr>
                <th>Bride & Groom Photos</th>
                <td>{{ $application_data->doc_photographs ? 'Yes (Uploaded)' : 'No' }}</td>
                <th>Signatures / Thumb Impression</th>
                <td>{{ $application_data->doc_signatures ? 'Yes (Uploaded)' : 'No' }}</td>
            </tr>
        </table>

        

        <div class="footer">
            <p>This is a system-generated document and does not require a physical signature from the authority.</p>
        </div>
    </div>

</body>
</html>
