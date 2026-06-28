<!DOCTYPE html>
<html>

<head>
    <title>ABOCWWB Application Status Report</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <h2>ABOCWWB | Admin | Application Status Report
    </h2>
    <table>
        <thead>
            <tr>
                <th>Sno.</th>
                <th>Application No</th>
                <th>Registration Type</th>
                <th>Date of Received</th>
                <th>Duration (Days)	</th>
                <th>Rank in Received Order</th>
                <th>Action Taken Date</th>
                <th>Rank (Action Taken)</th>
                <th>FIFO Compliant</th>
                <th>Status</th>

            </tr>
        </thead>
       <tbody>
@foreach ($applications as $app)
<tr>
    <td>{{ $app->sno }}</td>
    <td>{{ $app->application_no ?? 'N/A' }}</td>
    <td>{{ $app->registration_type }}</td>
    <td>{{ $app->received_date->format('d-m-Y h:i A') }}</td>
    <td>{{ $app->duration_days }}</td>
    <td>{{ $app->received_rank }}</td>
    <td>
        {{ $app->action_taken_date
            ? $app->action_taken_date->format('d-m-Y h:i A')
            : 'Pending' }}
    </td>
    <td>{{ $app->action_taken_rank ?? '-' }}</td>
    <td>{{ $app->fifo }}</td>
    <td>{{ $app->status_text }}</td>
</tr>
@endforeach
</tbody>


 </table>
</body>
</html>

