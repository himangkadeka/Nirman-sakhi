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
                <th>Worker ID</th>
                <th>Party Name</th>
                <th>Transaction ID</th>
                <th>Payment Type</th>
                <th>Status</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Bank Name</th>
                <th>GRN</th>
                <th>PRN</th>
                <th>Date</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->worker_id }}</td>
                    <td>{{ $item->PARTYNAME }}</td>
                    <td>{{ $item->DEPARTMENT_ID }}</td>
                    <td>
                        @if ($item->payment_type == 1)
                            <span class="badge badge-primary">Registration</span>
                        @else
                            <span class="badge badge-warning">Subscription</span>
                        @endif
                    </td>
                    <td>
                        @if ($item->STATUS == 'Y')
                            <span class="badge badge-success">Success</span>
                        @elseif($item->STATUS == 'N')
                            <span class="badge badge-danger">Failed</span>
                        @elseif($item->STATUS == 'A')
                            <span class="badge badge-warning">Aborted</span>
                        @else
                            <span class="badge badge-info">Pending</span>
                        @endif
                    </td>
                    <td>
                        {{ $item->status }}
                    </td>

                    <td>{{ $item->AMOUNT }}</td>
                    <td>{{ $item->BANKNAME }}</td>
                    <td>{{ $item->GRN }}</td>
                    <td>{{ $item->PRN }}</td>

                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}
                    </td>
                  
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
