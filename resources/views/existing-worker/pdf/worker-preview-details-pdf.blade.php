<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        margin: 0;
        padding: 20px;
        box-sizing: border-box;
    }

    .container {
        width: 100%;
        max-width: 1200px;
        margin: auto;
    }

    .header {
        text-align: right;
        margin-bottom: 10px;
    }

    .emblem img {
        display: block;
        margin: 20px auto;
    }

    h2,
    h4 {
        margin: 10px 0;
    }

    h2 {
        text-align: center;
    }

    h4 {
        text-decoration: underline;
        text-align: left;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }

    td,
    th {
        border: 1px solid #000;
        padding: 10px;
        text-align: left;
    }

    .section-title {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: left;
    }

    .row-light {
        background-color: #faf0c3;
    }

    .row-dark {
        background-color: #c6e9f8;
    }

    .input-checkbox {
        display: block;
        margin: auto;
    }
</style>

<div class="container">
    <div class="header">
        <span>Date: {{ now()->format('d-m-Y') }}</span>
    </div>

    <div class="emblem">
        <img src={{ $emblem }} alt="National Emblem of India" title="emblem of india logo" />
    </div>

    <h2>FINAL APPLICATION ONBOARDING</h2>

    <!-- Basic Details -->
    <h4>Basic Details</h4>
    <table>
        <tr class="row-dark">
            <td>Name: {{ $getVaultData['name'] ?? 'NA' }}</td>
            <td>Name (as per old data): {{ $worker_details->basicDetail->old_name ?? 'NA' }}</td>
            <td>Care Of: {{ $getVaultData['careOf'] ?? 'NA' }}</td>
        </tr>
        <tr class="row-light">
            <td>Care Of (as per old data): {{ $worker_details->basicDetail->old_care_of ?? 'NA' }}</td>
            <td>Gender: {{ $getVaultData['gender'] ?? 'NA' }}</td>
            <td>Aadhar Number: {{ $getVaultData['uID'] ?? 'NA' }}</td>
        </tr>
        <tr class="row-dark">
            <td>Marital Status: {{ $worker_details->basicDetail->maritalStatus->marital_status ?? 'NA' }}</td>
            <td>Date of Birth: {{ $getVaultData['dob'] ?? 'NA' }}</td>
            <td>Date of Birth (as per old data): {{ $worker_details->basicDetail->old_dob ?? 'NA' }}</td>
        </tr>
        <tr class="row-light">
            <td>Category: {{ $worker_details->basicDetail->cateGory->category_name ?? 'NA' }}</td>
            <td>Phone Number: {{ $worker_details->phone_no ?? 'NA' }}</td>
            <td>eShram Number: {{ $worker_details->eshram_no ?? 'NA' }}</td>
        </tr>
        <tr class="row-dark">
            <td>Education Details: {{ $worker_details->basicDetail->education->education_name ?? 'NA' }}</td>
            <td>Email: {{ $worker_details->email }}</td>
            <td>PF/UAN: {{ $worker_details->pf_no ?? 'NA' }}</td>
        </tr>
        <tr class="row-light">
            <td>ESIC Number: {{ $worker_details->esic_no ?? 'NA' }}</td>
            <td>PAN Number: {{ $worker_details->pan_no ? $worker_details->pan_no : 'NA' }}</td>
            <td>Blood Group: {{ $worker_details->basicDetail->bloodgroup->blood_group ?? 'NA' }}</td>
        </tr>
        <tr class="row-dark">
            <td>Ration Card: {{ $worker_details->basicDetail->has_ration_card == 1 ? 'Yes' : 'No' }}</td>
            <td>Ration Card Number: {{ $worker_details->basicDetail->ration_no ?? 'NA' }}</td>
            <td>Ration Type: {{ $worker_details->basicDetail->rationType->name ?? 'NA' }}</td>
        </tr>
        <tr class="row-light">
            <td>
                Profession:
                @if ($worker_details->basicDetail->profession === 28)
                    {{ $worker_details->basicDetail->profession_others ?? 'NA' }}
                @else
                    {{ $worker_details->basicDetail->Profession->profession_name ?? 'NA' }}
                @endif
            </td>
        </tr>
    </table>

    <!-- Permanent Residential Address -->
    <h4>Permanent Residential Address:</h4>
    <table>
        <tr class="row-dark">
            <td>State: {{ $getVaultData['state'] ?? 'NA' }}</td>
            <td>District: {{ $getVaultData['district'] ?? 'NA' }}</td>
            <td>Sub-district: {{ $getVaultData['subDistrict'] ?? 'NA' }}</td>
        </tr>
        <tr class="row-light">
            <td>Area/Village:{{ $getVaultData['village'] ?? 'NA' }}</td>
            <td>Locality: {{ $getVaultData['locality'] ?? 'NA' }}</td>
            <td>Street: {{ $getVaultData['street'] ?? 'NA' }}</td>
        </tr>
        <tr class="row-dark">
            <td>Post Office: {{ $getVaultData['postOffice'] ?? 'NA' }}</td>
            <td>Pin Code: {{ $getVaultData['pinCode'] ?? 'NA' }}</td>
            <td>Landmark: {{ $getVaultData['landMark'] ?? 'NA' }}</td>
        </tr>
    </table>

    <!-- Current Residential Address -->
    <h4>Current Residential Address:</h4>
    <table>
        <tr class="row-dark">
            <td>Type of Residence: {{ $worker_details->address->currentResidence->residence_name ?? 'NA' }}</td>
            <td>Type of House: {{ $worker_details->address->currentHouse->house_type ?? 'NA' }}</td>
            <td>House/Building No.: {{ $worker_details->address->c_house_no ?? 'NA' }}</td>
        </tr>
        <tr class="row-light">
            <td>Area/Village:{{ $worker_details->address->c_area ?? 'NA' }}</td>
            <td>City: {{ $worker_details->address->c_city ?? 'NA' }}</td>
            <td>Road: {{ $worker_details->address->c_road ?? 'NA' }}</td>
        </tr>
        <tr class="row-dark">
            <td>State: {{ $worker_details->address->c_state ?? 'NA' }}</td>
            <td>District: {{ $worker_details->address->c_district ?? 'NA' }}</td>
            <td>Revenue Circle: {{ $worker_details->address->c_circle ?? 'NA' }}</td>
        </tr>
        <tr class="row-light">
            <td>Post Office: {{ $worker_details->address->c_post_office ?? 'NA' }}</td>
            <td>Pin Code: {{ $worker_details->address->c_pin ?? 'NA' }}</td>
        </tr>
    </table>

    <!-- Bank Details -->
    <h4>Bank Details</h4>
    <table>
        <tr class="row-dark">
            <td>Bank Name: {{ $worker_details->bankDetail->bank_name ?? 'NA' }}</td>
            <td>Branch Name: {{ $worker_details->bankDetail->branch_name ?? 'NA' }}</td>
            <td>Address: {{ $worker_details->bankDetail->bank_address ?? 'NA' }}</td>
        </tr>
        <tr class="row-light">
            <td>Account Number: {{ $worker_details->bankDetail->account_no ?? 'NA' }}</td>
        </tr>
    </table>

    <!-- Family Details -->
    <h4>Family Details</h4>
    <table>
        <thead>
            <tr class="row-dark">
                <th>First Name</th>
                <th>Last Name</th>
                <th>DOB</th>
                <th>Guardian Name</th>
                <th>Relation</th>
                <th>Nominee(Y/N)</th>
                <th>Nominee Share</th>
                <th>Nominee Bank Account</th>
                <th>Already Registered?</th>
                <th>BOCCW ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($worker_details->familyDetails as $familyMember)
                <tr class="row-light">
                    <td>{{ $familyMember->first_name }}</td>
                    <td>{{ $familyMember->last_name }}</td>
                    <td>{{ $familyMember->dob }}</td>
                    <td>{{ $familyMember->guardain_name ?? __('N/A') }}</td>
                    <td>{{ $familyMember->relationDetails->relation_name }}</td>
                    <td>{{ $familyMember->nominee == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $familyMember->nominee_percentage ?? __('N/A') }}</td>
                    <td>{{ $familyMember->nominee_account ?? __('N/A') }}</td>
                    <td>{{ $familyMember->already_registered == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $familyMember->bocwwb_id ?? 'NA' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Employer Details -->

@if($worker_details->already_registered != 1)

    <h4>90 Days Certificate Details</h4>
    <table>
        <thead>
            <tr class="row-dark">
                <th>Type of Employer</th>
                <th>Employer Name</th>
                <th>Employer Contact Number</th>
                <th>Issue Date</th>
                <th>Type Of Construction Work</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Profession</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($worker_details->certificates as $certificate)
                <tr class="row-light">
                    <td>{{ $certificate->typeOfEmployer->employer_name }}</td>
                    <td>{{ $certificate->employer_name }}</td>
                    <td>{{ $certificate->employer_contact_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($certificate->issue_date)->format('d-m-Y') }}</td>
                    <td>{{ $certificate->typeOfWork->work_type_name }}</td>
                    <td>{{ \Carbon\Carbon::parse($certificate->from_date)->format('d-m-Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($certificate->to_date)->format('d-m-Y') }}</td>
                    <td>{{ $certificate->professions->profession_name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @endif
    <h4>Schemes Availed</h4>
    @if ($worker_details->schemeDetails->isEmpty())
        <tr>
            <td>No Scheme Availed</td>
        </tr>
    @else
        <table>
            <thead>
                <tr class="row-dark">
                    <th>Schemes</th>
                    <th>Registration No</th>
                    <th>Date of Registration</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($worker_details->schemeDetails as $schemes)
                    @if ($schemes->enrolled == '0')
                        <tr class="row-light">
                            <td colspan="3">No data to display</td>
                        </tr>
                    @else
                        <tr class="row-light">
                            <td>{{ $schemes->scheme->scheme_name }}</td>
                            <td>{{ $schemes->registration_id }}</td>
                            <td>{{ \Carbon\Carbon::parse($schemes->date)->format('d-m-y') }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

    <h4>Documents Uploaded</h4>
    <table>
        <thead>
            <tr class="row-dark">

                <th>Uploaded Documents</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr class="row-light">
                <td>BOC ID Card</td>
                <td>Uploaded</td>

            </tr>
             @if ($worker_details->basicDetail->subscription_receipt == 1)
            <tr class="row-dark">
                <td>Subscription Receipt Copy</td>
                <td>Uploaded</td>
            </tr>
            @endif

            @if ($worker_details->address->do !== 1)
                <tr class="row-light">

                    <td> Present Address Proof</td>
                    <td>Uploaded</td>

                </tr>
            @endif
            <tr class="row-dark">

                <td>Aadhaar Linked Bank Copy</td>
                <td>Uploaded</td>

            </tr>

            @if ($worker_details->address->has_ration_card == 1)
                <tr class="row-light">

                    <td>Ration card</td>
                    <td>Uploaded</td>

                </tr>
            @endif
            @if ($worker_details->basicDetail->pan == 1)
                <tr class="row-dark">

                    <td>Pan card</td>
                    <td>Uploaded</td>

                </tr>
            @endif
        </tbody>

    </table>
</div>
