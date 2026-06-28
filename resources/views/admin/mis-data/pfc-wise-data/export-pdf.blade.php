<!DOCTYPE html>
<html>
<head>
    <title>ABOCWWB Admin PFC Wise Data</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; font-size: 12px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Nirman Sakhi | Admin | CSC Wise Data</h2>
    <table>
        <thead>
            <tr>
                <th>Sno</th>
                <th>CSC Name</th>
                <th>CSC ID</th>
                <th>User Type</th>
                <th>Total No. of Transactions</th>
                <th>Onboarding Registration</th>
                <th>New Worker Registration</th>
                <th>Worker Subscription</th>
                <th>Worker Renewal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['kiosk_name'] }}</td>
                    <td>{{ $item['kiosk_registration_id'] }}</td>
                    <td>{{ $item['user_type'] }}</td>
                    <td>{{ $item['total'] }}</td>
                    <td>{{ $item['onboarding'] }}</td>
                    <td>{{ $item['new_worker'] }}</td>
                    <td>{{ $item['subscription'] }}</td>
                    <td>{{ $item['renewal'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
