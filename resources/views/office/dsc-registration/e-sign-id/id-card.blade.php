<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>ID Card</title>
    <style>
        @font-face {
            font-family: 'Rohini';
            src: url(data:font/truetype;charset=utf-8;base64,{{ base64_encode(file_get_contents(public_path('assets/template/fonts/Asomiya_Rohini.ttf'))) }}) format('truetype');
            font-weight: normal;
            font-style: normal;

        }

        body {
            font-family: 'Rohini', Roboto, sans-serif;
        }

        .id-card {
            width: 258mm;
            height: 162mm;
            border: 2px solid #8c8c8c;
            border-radius: 32px;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
            position: relative;

        }

        .bgflag {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 888;
            overflow: hidden;
            border-radius: 30px;
        }

        .header {
            text-align: center;
            margin: 20px;
            position: relative;
        }

        .header img {
            position: absolute;
            top: 0;
            height: 100px;
        }

        .header .left {
            left: 40px;
        }

        .header .right {
            right: 40px;
        }

        .header h3,
        .header h4 {
            margin: 0;
        }

        .header h3 {
            font-size: 18px;
            font-weight: bold;
            background-color: #000;
            color: #fff;
            padding: 10px;
            margin-left: 160px;
            margin-right: 190px;
            border-radius: 4px;
        }

        .head-text {
            background-color: #000;
            color: #fff;
            font-size: 18px;
            padding: 12px
        }

        .header-margin {
            margin-top: 20px;
            text-align: center;
        }

        .header h4 {
            font-size: 18px;
            margin-top: 12px
        }

        .details-table {
            width: 100%;
            margin-bottom: 20px;
        }

        .details-table span {
            font-size: 14px
        }

        .details-table td {
            padding: 8px;
        }

        .reg-text {
            font-size: 18px
        }

        .line {
            font-size: 17px !important;
            letter-spacing: 2px;
        }

        .photo {
            width: 120px;
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            padding-top: 20px;
            padding-right: 60px;

        }

        .photo img {
            border-radius: 7px;
        }

        .qr {
            width: 120px;
            height: 160px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
            margin-bottom: 50px
        }

        .registration-no {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-top: -50px;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            margin-right: 20px
        }

        .footer p {
            margin-top: 100px;
            font-size: 10px;
        }

        .font-bold {
            font-size: 16px !important;
            font-weight: bold;
        }


        .id-card-back {
            width: 258mm;
            height: 162mm;
            border: 2px solid #8c8c8c;
            border-radius: 30px;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            margin-top: 60px;
            position: relative;
        }

        .border-line {
            border: 2px dashed #000;
            min-height: 35px;
            max-height: 35px;
            max-width: 550px;
            min-width: 550px;
            padding: 12px
        }

        .details-table1 {
            width: 90%;
            margin-bottom: 20px;
        }

        .details-table1 span {
            font-size: 14px
        }

        .details-table1 td {
            padding: 3px;
        }

        .footer1 p {
            font-size: 14px;
            position: absolute;
            right: 0;
            bottom: 33px;
            width: 300px;
            text-align: left;
            border-left: 1px solid #000;
            border-top: 1px solid #000;
            padding: 10px;
            box-sizing: border-box;
        }

        .custom-align {
            position: absolute;
            right: 40px;
        }

        .align1 {
            margin-right: 260px;
        }

        hr {
            display: block;
            height: 2px;
            border: 0;
            border-top: 1px solid #0e0e0e;
        }

        .thumb {
            width: 100px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hori-break {
            border-top: dotted 4px;
            margin-top: 60px;
            margin-left: 14px;
            position: relative;
        }

        .horizontal-line {
            margin-top: 110px
        }

        .abocw {
            font-weight: bold;
            padding-left: 35px;
            float: left;
            width: 40%;
            display: inline-block;
        }

        .abocw2 {
            font-weight: bold;
            padding-right: 35px;
            text-align: right;
            float: right;
            width: 40%;
            display: inline-block;
        }

        .red {
            box-sizing: border-box;
        }

        .text-bocw {
            font-size: 15px !important;
        }
    </style>
</head>

<body>

    @php
        use Carbon\Carbon;
    @endphp

    <div class="id-card">
        <img src="{{ $flag }}" alt="bg" class="bgflag">
        <div class="header" style="z-index: 999">
            <img src="{{ $emblem }}" alt="Govt. of Assam emblem" class="left">
            <div>
                <h3 style="background:#222222">ASSAM BUILDING & OTHER CONSTRUCTION WORKERS' WELFARE BOARD</h3>
                <h4>As per Assam BOCW Rules of RE&CS Act 1996</h4>
            </div>
            <img src="{{ $logo }}" alt="ABOCWWB Logo" class="right">
        </div>

        <div class="header-margin">
            <h4 class="head-text" style="z-index: 999999;position:relative;background:#222222 ">অসম BOCW কাৰ্ড / Assam
                BOCW Card</h4>
        </div>
        <table class="details-table" style="z-index: 999999;position:relative">
            <tr>
                <td colspan="3"><span class="font-bold text-size">নাম / Name:</span> <span
                        class="line">{{ $getVaultData['name'] }} </span></td>
                <td rowspan="7" style="text-align: center; vertical-align: middle;">
                    <div class="photo">
                        <img src="data:image/jpeg;base64,{{ $base64Image }}" alt="User Photo">
                    </div>
                    <div class="footer">
                        <p>Registering Officer, ABOCWWB <br>{{ Auth::user()->office->office_name }}</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2"><span class="font-bold">পিতৃৰ নাম / স্ত্ৰী নাম<br>Father's Name / Spouse
                        Name:</span>
                    <span class="line">{{ $getVaultData['careOf'] }}</span>
                </td>
            </tr>
            <tr>
                <td><span class="font-bold">জন্ম তাৰিখ / DOB:</span> <span
                        class="line">{{ $getVaultData['dob'] }}</span>
                </td>
                <td><span class="font-bold">লিংগ / Gender:</span> <span class="line">
                        @if ($getVaultData['gender'] == 'M')
                            Male
                        @elseif($getVaultData['gender'] == 'F')
                            Female
                        @else
                            Others
                        @endif
                    </span></td>
            </tr>
            @if ($user->already_registered === 1)
            <tr>
                <td><span class="font-bold">পঞ্জীয়নৰ তাৰিখ /<br>Date Of Registration:</span> <span
                        class="line">{{ Carbon::parse($last_reg_date)->format('d-m-Y') }}</span></td>
                <td><span class="font-bold">জাৰী কৰা তাৰিখ /<br>Date Of Issue:</span> <span
                        class="line">{{ Carbon::parse($today)->format('d-m-Y') }}</span>
                </td>
                <td><span class="font-bold">বৈধতা /<br> Valid till:</span> <span
                        class="line">{{ Carbon::parse($formatted_date)->format('d-m-Y') }}</span>
                </td>
            </tr>
            @else
                <tr>
                    <td><span class="font-bold">পঞ্জীয়নৰ তাৰিখ /<br>Date Of Registration:</span> <span
                            class="line">{{ Carbon::parse($today)->format('d-m-Y') }}</span></td>
                    <td><span class="font-bold">জাৰী কৰা তাৰিখ /<br>Date Of Issue:</span> <span
                            class="line">{{ Carbon::parse($today)->format('d-m-Y') }}</span></td>
                    <td><span class="font-bold">বৈধতা /<br> Valid till:</span> <span
                            class="line">{{ Carbon::parse($formatted_date)->format('d-m-Y') }}</span>
                    </td>
                </tr>
            @endif
            <tr>
                <td><span class="font-bold">অৱসৰৰ তাৰিখ /<br> Date of Retirement:</span> <span
                        class="line">{{ Carbon::parse($user->date_of_retirement)->format('d-m-Y') }}</span></td>
                <td><span class="font-bold">পেছা /<br> Profession:</span> <span class="line">
                        @if ($user->already_registered === 1)
                            @if ($profession_already->profession === 28)
                                {{ $profession_already->profession_others }}
                            @else
                            {{ $profession_already->profession_name}}
                            @endif
                        @else
                            @if ($user->certificates[0]->profession === 28)
                                {{ $user->certificates[0]->profession_others }}
                            @else
                            {{ $user->certificates[0]->professions->profession_name ?? 'NA' }}
                        @endif
                            @endif
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="3"><span class="font-bold">e-Shram UAN No.:</span> <span
                        class="line">{{ $user->basicDetail->eshram_no ?? 'NA' }}</span></td>
            </tr>
        </table>
        <div class="registration-no" style="z-index: 999999;position:relative">
            <span class="reg-text">Registration no. </span> <br> {{ $user->id_card }}
        </div>
    </div>

    <hr class="hori-break" />
    <svg xmlns="http://www.w3.org/2000/svg"
        style="position: absolute; top: 48.2%; left: 50%; transform: translate(-50%, -50%); fill: rgb(248, 248, 248);"
        width="40" height="40" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round"
            d="m7.848 8.25 1.536.887M7.848 8.25a3 3 0 1 1-5.196-3 3 3 0 0 1 5.196 3Zm1.536.887a2.165 2.165 0 0 1 1.083 1.839c.005.351.054.695.14 1.024M9.384 9.137l2.077 1.199M7.848 15.75l1.536-.887m-1.536.887a3 3 0 1 1-5.196 3 3 3 0 0 1 5.196-3Zm1.536-.887a2.165 2.165 0 0 0 1.083-1.838c.005-.352.054-.695.14-1.025m-1.223 2.863 2.077-1.199m0-3.328a4.323 4.323 0 0 1 2.068-1.379l5.325-1.628a4.5 4.5 0 0 1 2.48-.044l.803.215-7.794 4.5m-2.882-1.664A4.33 4.33 0 0 0 10.607 12m3.736 0 7.794 4.5-.802.215a4.5 4.5 0 0 1-2.48-.043l-5.326-1.629a4.324 4.324 0 0 1-2.068-1.379M14.343 12l-2.882 1.664" />
    </svg>


    <div class="id-card-back">
        <img src="{{ $flag }}" alt="bg" class="bgflag">
        <div class="header" style="z-index: 999;">
            <img src="{{ $emblem }}" alt="Govt. of Assam emblem" class="left">
            <div>
                <h3 style="z-index: 999">ASSAM BUILDING & OTHER CONSTRUCTION WORKERS' WELFARE BOARD</h3>
                <h4 style="z-index: 999">As per Assam BOCW Rules of RE&CS Act 1996</h4>
            </div>
            <img src="{{ $logo }}" alt="ABOCWWB Logo" class="right">
        </div>
        <div class="header-margin">
            <h4 class="head-text" style="z-index: 999;position: relative">অসম BOCW কাৰ্ড / Assam BOCW Card</h4>
        </div>
        <table class="details-table1" style="z-index: 999;position: relative">
            <tr>
                <td colspan="2"><span class="font-bold">স্থায়ী ঠিকনা / Permanent Address:</span></td>

                <td rowspan="5" style="text-align: center; vertical-align: middle;">
                    <div class="qr">
                        {!! $simple !!}
                        <h2 style="font-size:10px">Scan QR Code for verfification</h2>
                    </div>
                </td>

            </tr>



            <tr>
                <td colspan="2">
                    <div class="border-line">
                        {{ $getVaultData['village'] }}, {{ $getVaultData['street'] }},
                        {{ $getVaultData['postOffice'] }},
                        {{ $getVaultData['subDistrict'] }}, {{ $getVaultData['district'] }},
                        {{ $getVaultData['state'] }} -
                        {{ $getVaultData['pinCode'] }}
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="1"><span class="font-bold">বৰ্তমান ঠিকনা / Present Address:</span></td>
            </tr>
            <tr>

                <td colspan="1">
                    <div class="border-line">
                        {{ $add->c_area }}, {{ $add->c_city }}, {{ $add->c_road }},
                        {{ $add->c_post_office }},{{ $add->c_circle }},{{ $add->district_name }},
                        {{ $add->c_state }} -
                        {{ $add->c_pin }}
                    </div>
                </td>
            </tr>
            <tr>
                <td><span class="font-bold">Blood group:</span> <span
                        class="line">{{ $user->basicDetail->bloodGroup->blood_group ?? 'NA' }}</span></td>
            </tr>
            <tr>
                <td><span class="font-bold">Contact no.</span> <span class="line">{{ $user->phone_no }}</span></td>
            </tr>

        </table>
        <div class="footer1" style="z-index: 999;position:absolute;bottom:-2%;right:0px;">
            <p> <span class="font-bold">
                    If the card is lost / someone's lost card is found,
                    Please inform / return to:<br></span>
                <span class="text-bocw">Assam Building And Other Construction Workers' Welfare Board, Labour Welfare
                    Department, Government Of Assam, Gopinath Nagar, Guwahati-780016</span>
            </p>
        </div>
        <hr class="horizontal-line" style="z-index: 999;position: relative">
        {{--        <div> --}}
        {{--            <span class="font-bold custom-align align1"><i class="fa fa-globe" aria-hidden="true"></i> --}}
        {{--                abocwwb.assam.gov.in</span> <span class="font-bold custom-align">abocww.board@assam.gov.in</span> --}}
        {{--        </div> --}}
        <div class="red" style="z-index: 999;position: relative">
            <span class="abocw">Website : https://abocwwb.assam.gov.in</span>
            <span class="abocw2">Email : abocww.board@assam.gov.in</span>
        </div>
    </div>
</body>

</html>
