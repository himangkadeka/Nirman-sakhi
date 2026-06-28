<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form No. XXXI - Identity Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        table {
            width: 80%;
            margin-bottom: 20px;
        }

        td {
            padding: 5px;
            vertical-align: top;
        }

        .section-title {
            text-align: center;
            font-weight: bold;
        }

        .photo-placeholder {}

        .photo {
            width: 120px;
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .fixed-width {
            min-width: 300px
        }

        .margin-top {
            margin-top: 60px
        }
    </style>
</head>

<body>

    @php
        use Carbon\Carbon;
    @endphp

    <h2 class="section-title">THE BUILDING AND OTHER CONSTRUCTION WORKERS<br>(REGU. OF EMPLY. AND COND. OF SERVICE) ASSAM
        RULES, 2007</h2>
    <h2 class="section-title">FORM NO. XXXI<br>FORM OF IDENTITY CARD<br>[See Rule 269(8)]</h2>

    <h3 class="section-title">Page - I</h3>
    <table>
        <tr>
            <td>Photo</td>
            <td>:</td>
            <td>
                <div class="photo">
                    <img src="data:image/jpeg;base64,{{ $base64Image }}" alt="User Photo">
                </div>
            </td>
        </tr>
    </table>

    <h3 class="section-title margin-top">Page - II</h3>
    <table>
        <tr>
            <td>Name of Member</td>
            <td>:</td>
            <td>{{ $getVaultData['name'] }}</td>
        </tr>
        <tr>
            <td>Address</td>
            <td>:</td>
            <td>{{ $getVaultData['village'] }}, {{ $getVaultData['street'] }}, {{ $getVaultData['postOffice'] }},
                {{ $getVaultData['subDistrict'] }}, {{ $getVaultData['district'] }}, {{ $getVaultData['state'] }} -
                {{ $getVaultData['pinCode'] }}
            </td>
        </tr>
        <tr>
            <td>Male/Female</td>
            <td>:</td>
            <td>
                @if ($getVaultData['gender'] == 'M')
                    Male
                @elseif($getVaultData['gender'] == 'F')
                    Female
                @else
                    Others
                @endif
            </td>
        </tr>
        <tr>
            <td>Profession</td>
            <td>:</td>
            <td>
                @if ($user->already_registered === 1)
                    @if ($profession_already->profession === 28)
                        {{ $profession_already->profession_others }}
                    @else
                        {{ $profession_already->profession_name }}
                    @endif
                @else
                    {{ $user->certificates[0]->professions->profession_name ?? 'NA' }}
                @endif
            </td>
        </tr>
        <tr>
            <td>Registration No.</td>
            <td>:</td>
            <td>{{ $user->id_card }}</td>
        </tr>
        <tr>
            <td>District</td>
            <td>:</td>
            <td>{{ $user->districtName->district_name }}</td>
        </tr>
        <tr>
            <td>Date of Registration</td>
            <td>:</td>
            <td>{{ Carbon::parse($user->id_card_created_at)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td>Name of Bank & Branch</td>
            <td>:</td>
            <td>{{ $bankDetails->bank_name }}, {{ $bankDetails->branch_name }}</td>
        </tr>
        <tr>
            <td>Subscription rate</td>
            <td>:</td>
            <td>20</td>
        </tr>
    </table>

    <h3 class="section-title">Page - III</h3>
    <table>
        <tr>
            <td>Date of Birth</td>
            <td>:</td>
            <td>{{ $getVaultData['dob'] }}</td>
        </tr>
        <tr>
            <td>Date of retirement</td>
            <td>:</td>
            <td>{{ Carbon::parse($basicDetails->date_of_retirement)->format('d-m-Y') }}</td>
        </tr>
        <tr>
            <td>Marital status</td>
            <td>:</td>
            <td>{{ $basicDetails->maritalStatus->marital_status }}</td>
        </tr>
        <tr>
            <td>Care of</td>
            <td>:</td>
            <td>{{ $getVaultData['careOf'] }}</td>
        </tr>
        <tr>
            <td>Address</td>
            <td>:</td>
            <td> {{ $add->c_area }}, {{ $add->c_city }}, {{ $add->c_road }},
                {{ $add->c_post_office }},{{ $add->c_circle }},{{ $add->district_name }},
                {{ $add->c_state }} -
                {{ $add->c_pin }}</td>
        </tr>
        <tr>
            <td>Whether wife/husband, a member of This board</td>
            <td>:</td>
            <td>
                <span class="row-light">
                    @if ($family)
                        Yes
                    @else
                        No
                    @endif
                </span>
            </td>
        </tr>
        <tr>
            <td>If so, Name & Registration No.</td>
            <td>:</td>
            <td>
                @if ($family)
                    {{ $family->first_name }} {{ $family->last_name }}, {{ $family->bocwwb_id }}
                @else
                    NA
                @endif
            </td>
        </tr>
        <tr>
            <td>Name of Nominees</td>
            <td>:</td>
            <td>
                @foreach ($workerDetails as $familyMember)
                    <span class="row-light">
                        @if ($familyMember->nominee == 1)
                            {{ $familyMember->first_name }} {{ $familyMember->last_name }}
                        @else
                            NA
                        @endif
                    </span>
                @endforeach
            </td>
        </tr>
        <tr>
            <td>Relationship with the member</td>
            <td>:</td>
            <td>
                @foreach ($workerDetails as $familyMember)
                    <span class="row-light">
                        @if ($familyMember->nominee == 1)
                            {{ $familyMember->relationDetails->relation_name }}
                        @else
                            NA
                        @endif
                    </span>
                @endforeach
            </td>
        </tr>
    </table>

</body>

</html>
