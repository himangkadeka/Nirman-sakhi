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
                <th>Worker ID</th>
                <th>Certificate Upload Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->worker_id }}</td>
                    <td>{{ $item->certificate_upload_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
