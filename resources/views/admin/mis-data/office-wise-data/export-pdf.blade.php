<!DOCTYPE html>
<html>

<head>
    <title>ABOCWWB Admin Office Wise Data</title>
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
    <h2>ABOCWWB | Admin | Office Wise Data</h2>
    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Office Name</th>
                <th>Total Count</th>
                <th>New Registrations</th>
                <th>Onboarding</th>
                <th>Pending</th>
                <th>New Approved</th>
                <th>On Approved</th>
                <th>Approved</th>
                <th>Rejected</th>
                <th>Reverted</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach ($offices as $office)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>{{ isset($fromDate) ? $office->total_count : $office->getCount($office->office_id) }}
                    </td>
                    <td>{{ isset($fromDate) ? $office->new_registrations : $office->newRegistrationsCount($office->office_id) }}
                    </td>
                    <td>{{ isset($fromDate) ? $office->onboarding : $office->alreadyRegisteredCount($office->office_id) }}
                    </td>
                    <td>{{ isset($fromDate) ? $office->pending : $office->pendingApplicationCount($office->office_id) }}
                    </td>
                    <td>{{ isset($fromDate) ? $office->new_approved : $office->newApprovedApplicationCount($office->office_id) }}
                    </td>
                    <td>{{ isset($fromDate) ? $office->on_approved : $office->OnApprovedApplicationCount($office->office_id) }}
                    </td>
                    <td>{{ isset($fromDate) ? $office->new_approved + $office->on_approved : $office->approvedApplicationCount($office->office_id) }}
                    </td>
                    <td>{{ isset($fromDate) ? $office->rejected : $office->rejectedApplicationCount($office->office_id) }}
                    </td>
                    <td>{{ isset($fromDate) ? $office->reverted : $office->revertedApplicationCount($office->office_id) }}
                    </td>

                </tr>
            @endforeach --}}



            @foreach ($data as $index => $office)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $office->office_name }}</td>
                    <td>{{ $office->total_count }}</td>
                    <td>{{ $office->new_registrations }}</td>
                    <td>{{ $office->onboarding }}</td>
                    <td>{{ $office->pending }}</td>
                    <td>{{ $office->new_approved }}</td>
                    <td>{{ $office->on_approved }}</td>
                    <td>{{ $office->approved }}</td>
                    <td>{{ $office->rejected }}</td>
                    <td>{{ $office->reverted }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
