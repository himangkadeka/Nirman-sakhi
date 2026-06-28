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
        <img src={{ $emblem }} alt="National Emblem of India" title="emblem of india logo">
    </div>

    <h2>FINAL APPLICATION</h2>

    <!-- Basic Details -->
    <h4>Basic Details</h4>
    <table>
        <tr class="row-dark">
            <td>Name: {{ $getVaultData['name'] }}</td>
            <td>Care Of: {{ $getVaultData['careOf'] }}</td>
            <td>Gender: {{ $getVaultData['gender'] }}</td>
        </tr>
        <tr class="row-light">
            <td>Aadhaar Number: {{ $getVaultData['uID'] ?? 'NA' }}</td>
            <td>Marital Status: {{ $worker_details->basicDetail->maritalStatus->marital_status ?? 'NA' }}</td>
            <td>Date of Birth: {{ $getVaultData['dob'] ?? 'NA' }}</td>
        </tr>
        <tr class="row-dark">
            <td>Category: {{ $worker_details->basicDetail->cateGory->category_name ?? 'NA' }}</td>
            <td>Phone Number: {{ $worker_details->phone_no ?? 'NA' }}</td>
            <td>eShram Number: {{ $worker_details->eshram_no ?? 'NA' }}</td>
        </tr>
        <tr class="row-light">
            <td>Education Details: {{ $worker_details->basicDetail->education->education_name ?? 'NA' }}</td>
            <td>Email: {{ $worker_details->email ?? 'NA' }}</td>
            <td>PAN Number: {{ $worker_details->pan_no ? $worker_details->pan_no : 'NA' }}</td>
        </tr>
        <tr class="row-dark">

            <td>Blood Group: {{ $worker_details->basicDetail->bloodgroup->blood_group ?? 'NA' }}</td>
            <td>Ration Card: {{ $worker_details->basicDetail->has_ration_card == 1 ? 'Yes' : 'No' }}</td>
            <td>Ration Card Number: {{ $worker_details->basicDetail->ration_no ?? 'NA' }}</td>
        </tr>
        <tr class="row-light">

            <td>Ration Type: {{ $worker_details->basicDetail->rationType->name ?? 'NA' }}</td>
        </tr>
    </table>

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
            <td>District: {{ $worker_details->address->currentDistrict->district_name ?? 'NA' }}</td>
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
                    <td>
                        @if ($familyMember->relation === 17)
                            {{ $familyMember->relation_others ?? 'NA' }}
                        @else
                            {{ $familyMember->relationDetails->relation_name }}
                        @endif
                    </td>
                    <td>{{ $familyMember->nominee == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $familyMember->nominee_percentage ?? __('N/A') }}</td>
                    <td>{{ $familyMember->already_registered == 1 ? 'Yes' : 'No' }}</td>
                    <td>{{ $familyMember->bocwwb_id ?? 'NA' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Employer Details -->

    <h4>90 Days Certificate Details</h4>
    <table>
        <thead>
            <tr class="row-dark">
                <th>Type of Issuer</th>
                <th>Name of Issuing Organization</th>
                <th>Issue Date</th>
                <th>Name of Issuing Person</th>
                <th>Contact No of Issuing Person</th>
                <th>Employer Name (Contact Person)</th>
                <th>Employer Contact Number</th>
                <th>From Date</th>
                <th>To Date</th>
                <th>Type of Employer</th>
                <th>Profession</th>
                <th>90 Days Working Certificate</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($worker_details->certificates as $certificate)
                <tr class="row-light">
                    <td>{{ $certificate->typeOfIssuer->issuer_name }}</td>
                    <td>{{ $certificate->issuing_org }}</td>
                    <td>{{ \Carbon\Carbon::parse($certificate->issue_date)->format('d-m-y') }}</td>
                    <td>{{ $certificate->issuing_person }}</td>
                    <td>{{ $certificate->contact_issuing_person }}</td>
                    <td>{{ $certificate->employer_name }}</td>
                    <td>{{ $certificate->employer_contact_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($certificate->from_date)->format('d-m-y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($certificate->to_date)->format('d-m-y') }}</td>
                    <td>{{ $certificate->typeOfEmployer->employer_name }}</td>
                    <td>{{ $certificate->professions->profession_name }}</td>
                    <td>
                        @if ($certificate->certificate_proof)
                            Uploaded
                        @else
                            Not Uploaded
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

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
                            <td>{{ \Carbon\Carbon::parse($schemes->date)->format('d-m-Y') }}</td>
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

            @if ($worker_details->address->do !== 1)
                <tr class="row-light">

                    <td>Present Address Proof</td>
                    {{--                <td><a href="{{ route('get-res-proof', ['id' => mt_rand(1, 1000)]) }}" --}}
                    {{--                       class="href" target="_blank"><i class="fa fa-external-link" --}}
                    {{--                                                       aria-hidden="true"></i>&nbsp;View Present Address proof</a></td> --}}
                    <td>Uploaded</td>

                </tr>
            @endif

            <tr class="row-dark">

                <td>Worker Bank Photo Copy</td>
                {{--            <td><a href="{{ route('get-bank-copy', ['id' => mt_rand(1, 1000)]) }}" --}}
                {{--                   class="href" target="_blank"><i class="fa fa-external-link" --}}
                {{--                                                   aria-hidden="true"></i>&nbsp;View Worker bank Copy</a></td> --}}
                <td>Uploaded</td>

            </tr>

            <tr class="row-light">

                <td> Nominee Bank Photo Copy</td>
                {{--            <td><a href="{{ route('nominee_bank_copy', ['id' => mt_rand(1, 1000)]) }}" --}}
                {{--                   class="href" target="_blank"><i class="fa fa-external-link" --}}
                {{--                                                   aria-hidden="true"></i>&nbsp;View Nominee Bank Photo Copy</a></td> --}}
                <td>Uploaded</td>

            </tr>
            @if ($has_ration_card == 1)
                <tr class="row-dark">

                    <td>Ration card</td>
                    {{--                <td><a href="{{ route('get-ration_card', ['id' => mt_rand(1, 1000)]) }}" --}}
                    {{--                       class="href" target="_blank"><i class="fa fa-external-link" --}}
                    {{--                                                       aria-hidden="true"></i>&nbsp;View Ration Card</a></td> --}}
                    <td>Uploaded</td>

                </tr>
            @endif
            @if ($has_pan == 1)
                <tr class="row-light">

                    <td>Pan card</td>
                    {{--                <td><a href="{{ route('get-pan_card', ['id' => mt_rand(1, 1000)]) }}" --}}
                    {{--                       class="href" target="_blank"><i class="fa fa-external-link" --}}
                    {{--                                                       aria-hidden="true"></i>&nbsp;View Pan Card</a></td> --}}
                    <td>Uploaded</td>

                </tr>
            @endif
        </tbody>
    </table>
</div>
