<!DOCTYPE html>
<html>

<head>
    <title>ABOCWWB Admin PFC Data</title>
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
    <h2>ABOCWWB | Admin | PFC Data</h2>
    <table>
        <thead>
            <tr>
                <th>District</th>
                <th>PFC Name</th>
                <th>Address</th>
                <th>PIN</th>
                <th>Landmark</th>
                <th>Latitude</th>
                <th>Longitude</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->name_of_pfc }}</td>
                    <td>{{ $item->pfc_name }}</td>
                    <td>{{ $item->postal_address }}</td>
                    <td>{{ $item->pin_code }}</td>
                    <td>{{ $item->nearby_landmark }}</td>
                    <td>{{ $item->latitude }}</td>
                    <td>{{ $item->longitude }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
