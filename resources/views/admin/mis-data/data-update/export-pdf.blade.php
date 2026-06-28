<!DOCTYPE html>
<html>

<head>
    <title>ABOCWWB Admin Id Card Data</title>
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
    <h2>ABOCWWB | Admin | Id Card Data
    </h2>
    <table>
        <thead>
            <tr>
                <th>Sno.</th>
                <th>Application Number</th>
                <th>Ack No</th>
                <th>Office Code</th>
                <th>Application Receiver User ID</th>
                <th>Application Sender User ID</th>
                <th>Id Card</th>
                <th>Download Id Card</th>
                <th>Status</th>
                <th>RTPS Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->worker_id }}</td>
                    <td>{{ $item->ack_no }}</td>
                    <td>{{ $item->office_id }}</td>
                    <td>{{ $item->application_receiver_user_id }}</td>
                    <td>{{ $item->application_sender_user_id }}</td>
                    <td>{{ $item->id_card }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->rtps_trans_id }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
