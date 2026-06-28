<!DOCTYPE html>
<html>

<head>
    <title>ABOCWWB Admin App History</title>
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
    <h2>ABOCWWB | Admin | App History
    </h2>
    <table>
        <thead>
            <tr>
                <th>Sno.</th>
                <th>Worker Id </th>
                <th>Ack No</th>
                <th>Sender Role ID</th>
                <th>Sender user ID</th>
                <th>Sender office ID</th>
                <th>Application from user</th>
                <th>Application receiver user ID</th>
                <th>Application receiver role ID</th>
                <th>Application Status</th>
               
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->worker_id }}</td>
                    <td>{{ $item->ack_no }}</td>
                    <td>{{ $item->sender_role_id }}</td>
                    <td>{{ $item->sender_user_id }}</td>
                    <td>{{ $item->sender_office_id }}</td>
                    <td>{{ $item->application_from_user }}</td>
                    <td>{{ $item->application_receiver_user_id }}</td>
                    <td>{{ $item->application_receiver_role_id }}</td>
                    <td>{{ $item->application_status }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
