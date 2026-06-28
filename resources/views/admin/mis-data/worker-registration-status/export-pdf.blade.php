<!DOCTYPE html>
<html>

<head>
    <title>ABOCWWB Admin Worker Registration Status</title>
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
    <h2>ABOCWWB Admin Worker Registration Status</h2>
    <table>
        <thead>
            <tr>
                <th>Acknowledgement Number</th>
                <th>Status</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $item->ack_no }}</td>
                    {{-- <td>{{ $item->active_status }}</td> --}}
                    <td>
                        @if ($item->status === 'A')
                            Application Submitted
                        @elseif($item->status == 'B')
                            Forwarded By DA
                        @elseif(($item->status == 'B') & ($item->da_forward == 1))
                            Sent By DA
                        @elseif($item->status == 'B' && $item->pull_back == 1)
                            Pulled Back
                        @elseif($item->status == 'C')
                            Forwarded By RO
                        @elseif($item->status == 'D')
                            Application Rejected
                        @elseif($item->status == 'E')
                            Pulled Back from DA
                        @elseif($item->status == 'F')
                            Application Approved
                        @elseif($item->status == 'G')
                            Application Reverted
                        @endif
                    </td>


                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
