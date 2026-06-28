<!DOCTYPE html>
<html>
<head>
    <title>ABOCWWB Admin District Wise Data</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; font-size: 12px; }
    </style>
</head>
<body>
    <h2>ABOCWWB | Admin | District Wise Data
</h2>
    <table>
    <thead>
        <tr>
            <th>Sno.</th>
            <th>District Name</th>
            <th>No. of Registered Workers</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $index => $district)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $district->district_name }}</td>
                <td>{{ $district->worker_count }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
