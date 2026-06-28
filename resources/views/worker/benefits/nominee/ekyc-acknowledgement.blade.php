<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KYC Acknowledgment Slip - {{ $wmf->id_card }}</title>
    <style>
        /* Using the same styles you provided for consistency */
        body { font-family: 'dejavu sans', sans-serif; font-size: 12px; color: #333; }
        .slip-container { border: 2px solid #000; padding: 20px; width: 100%; box-sizing: border-box; }
        .header { text-align: center; border-bottom: 1px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header img { width: 80px; } /* Slightly smaller for balance */
        .header h2 { margin: 5px 0; font-size: 16px; text-transform: uppercase; }
        .header h3 { margin: 5px 0; font-size: 14px; font-weight: normal; }
        .header h4 { margin: 10px 0; font-size: 15px; font-weight: bold; background-color: #f0f0f0; padding: 5px;}
        .content-table { width: 100%; border-collapse: collapse; }
        .content-table td { padding: 10px 0; border-bottom: 1px solid #eee; }
        .label { font-weight: bold; width: 40%; }
        .footer { margin-top: 30px; padding-top: 10px; border-top: 1px dashed #000; font-size: 10px; text-align: center; }
    </style>
</head>
<body>

<div class="slip-container">
    <div class="header">
        @if($emblem)
            <img src="{{ $emblem }}" alt="Board Emblem">
        @endif
        <h2>Assam Building & Other Construction Workers' Welfare Board</h2>
        <h3>Government of Assam | Labour Welfare Department</h3>
        <h4>Acknowledgment of Aadhaar e-KYC Verification</h4>
    </div>

    <table class="content-table">
        @if ($nominee_detail!=null)
            <tr>
            <td class="label">Nominee ID:</td>
            <td>{{ $nominee_detail->nomine_id ?? 'N/A' }}</td>
        </tr>
        @endif
        <tr>
            <td class="label">Registered Nominee Name:</td>
            <td>{{ $applicantVaultDetails['name'] ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Relation With Worker:</td>
            <td>{{ $familyDetail->relationDetails->relation_name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Worker Name:</td>
            <td>{{ $getVaultData['name'] ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td class="label">Worker ID Card:</td>
            <td><strong>{{ $wmf->id_card ?? 'N/A' }}</strong></td>
        </tr>
        <tr>
            <td class="label">Date & Time of Verification:</td>
            <td>
                {{-- NOTE: Change 'kyc_verified_at' to the actual column name from your database --}}
                @if(!empty($familyDetail->aadhar_verified_at))
                    {{ \Carbon\Carbon::parse($wmf->aadhar_verified_at)->format('d F, Y, h:i:s A') }}
                @else
                    N/A
                @endif
            </td>
        </tr>
         <tr>
            <td class="label">Verification Status:</td>
            <td><strong style="color: green;">SUCCESSFUL</strong></td>
        </tr>
    </table>

    <div class="footer">
        <p>This is a computer-generated acknowledgment of your successful e-KYC verification.</p>
        <p>Your details have been updated as per your Aadhaar records.</p>
    </div>
</div>

</body>
</html>
