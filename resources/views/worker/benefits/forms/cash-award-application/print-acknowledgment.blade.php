<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Acknowledgment Slip - {{ $application->application_id }}</title>
    <style>
        body {
            font-family: 'dejavu sans', sans-serif;
            font-size: 12px;
            color: #333;
        }

        .slip-container {
            border: 2px solid #000;
            padding: 20px;
            width: 100%;
            box-sizing: border-box;
        }

        .header {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header img {
            width: 100px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 16px;
            text-transform: uppercase;
        }

        .header h3 {
            margin: 5px 0;
            font-size: 14px;
            font-weight: normal;
        }

        .content-table {
            width: 100%;
        }

        .content-table td {
            padding: 8px 0;
        }

        .label {
            font-weight: bold;
            width: 40%;
        }

        .footer {
            margin-top: 30px;
            padding-top: 10px;
            border-top: 1px dashed #000;
            font-size: 10px;
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="slip-container">
        <div class="header">
            <div class="emblem"><img src="{{ $emblem }}"></div>
            <h2>Assam Building & Other Construction Workers' Welfare Board</h2>
            <h3>Government of Assam | Labour Welfare Department</h3>
            <br>
            <h2>{{ $application->benefit->name }}</h2>
        </div>

        <table class="content-table">
            <tr>
                <td class="label">Application ID:</td>
                <td><strong>{{ $application->application_id }}</strong></td>
            </tr>
            <tr>
                <td class="label">Office Name:</td>
                <td>{{ $workerData->officeName->office_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Benefit Scheme:</td>
                <td>{{ $application->benefit->name }}</td>
            </tr>
            @if (
                $application->benefit->benefit_code == 'EA' ||
                    $application->benefit->benefit_code == 'FA' ||
                    $application->benefit->benefit_code == 'DB')
                <td class="label">Applicant's Name:</td>
                <td>{{ $applicantVaultDetails['name'] ?? 'N/A' }}</td>
            @endif
            <tr>
                <td class="label">Worker's Name:</td>
                <td>{{ $getVaultData['name'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Date & Time of Submission:</td>
                <td>{{ \Carbon\Carbon::parse($application->submitted_at)->format('d F, Y, h:i:s A') }}</td>
            </tr>
        </table>

        <div class="footer">
            <p>This is a computer-generated acknowledgment. Please keep your Application ID for future reference.</p>
            <p>Your application is now under review by the concerned authority.</p>
        </div>
    </div>

</body>

</html>
