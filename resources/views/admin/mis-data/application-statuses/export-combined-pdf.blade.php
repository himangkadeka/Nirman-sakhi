<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Application Status Report</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #111827;
        }

        .title {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            font-size: 10px;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        thead {
            background-color: #2563EB;
            color: #ffffff;
        }

        th, td {
            border: 1px solid #9CA3AF;
            padding: 6px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            font-weight: bold;
            font-size: 9.5px;
        }

        td {
            font-size: 9px;
        }

        .text-left {
            text-align: left;
        }

        .badge-yes {
            background-color: #16A34A;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }

        .badge-no {
            background-color: #DC2626;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }

        .badge-pending {
            background-color: #F97316;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #F9FAFB;
        }

        .footer {
            margin-top: 15px;
            font-size: 8px;
            text-align: right;
        }

        @page {
            margin: 20px 25px;
        }
    </style>
</head>

<body>

<div class="title">
    Application Status & FIFO Compliance Report
</div>

<div class="subtitle">
    {{-- Generated on {{ now()->format('d-m-Y h:i A') }} --}}
    Generated on {{ \Carbon\Carbon::now('Asia/Kolkata')->format('d-m-Y h:i A') }}
</div>

<table>
    <thead>
        <tr>
            <th>Office</th>
            <th>Role</th>
            <th>Officer</th>
            <th>Reg. Type</th>
            <th>Count</th>
            <th>Application No</th>
            <th>Received Date</th>
            <th>Duration</th>
            <th>Rank (Received)</th>
            <th>Action Taken Date</th>
            <th>Rank (Action)</th>
            <th>FIFO</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        @foreach($data as $row)
            <tr>
                <td class="text-left">{{ $row['office_name'] }}</td>
                <td>{{ $row['role'] }}</td>
                <td class="text-left">{{ $row['officer_name'] }}</td>
                <td>{{ $row['registration_type'] }}</td>
                <td>{{ $row['total_applications'] }}</td>
                <td>{{ $row['application_no'] }}</td>
                <td>{{ $row['received_date'] }}</td>
                <td>{{ $row['duration_days'] }}</td>
                <td>{{ $row['rank_in_received_order'] }}</td>
                <td>{{ $row['action_taken_date'] }}</td>
                <td>{{ $row['rank_action_taken'] }}</td>
                <td>
                    @if($row['fifo_compliant'] === 'Yes')
                        <span class="badge-yes">Yes</span>
                    @elseif($row['fifo_compliant'] === 'No')
                        <span class="badge-no">No</span>
                    @else
                        <span class="badge-pending">Pending</span>
                    @endif
                </td>
                <td>{{ $row['status'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    * FIFO compliance is evaluated based on received order vs action taken order.
</div>

</body>
</html>
