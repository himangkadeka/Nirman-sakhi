@extends('layouts.admin-app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5>Verified Vault Data</h5>
                <div class="d-flex gap-2">
                    {{-- <a href="{{ route('admin.vault.export') }}" class="btn btn-success btn-sm">Export All Verified (CSV)</a> --}}

                    <form method="GET" action="{{ route('admin.vault.export-migrant') }}"
                        class="form-inline d-flex align-items-center">
                        <select name="office" class="form-control form-control-sm mr-2">
                            <option value="">All Offices</option>
                            @foreach ($officeDetails as $office)
                                <option value="{{ $office->office_id }}">{{ $office->office_name }}</option>
                            @endforeach
                        </select>

                        <input type="number" name="offset" class="form-control form-control-sm mr-2" placeholder="Offset"
                            min="0">
                        <input type="number" name="limit" class="form-control form-control-sm mr-2" placeholder="Limit"
                            min="1">

                        <button type="submit" class="btn btn-primary btn-sm">Export Filtered</button>
                    </form>
                </div>
                <button id="startSync" class="btn btn-primary">Start Bulk Sync</button>
                <div id="syncStatus" class="mt-2">Status: Idle</div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Worker Info</th>
                            <th>Vault UID</th>
                            <th>Name</th>
                            <th>DOB/Gender</th>
                            <th>Address</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $row)
                            @php $vault = $row->vault_details; @endphp
                            <tr>
                                <td>
                                    {{ $loop->iteration }}
                                </td>
                                <td>
                                    {{-- <strong>ID:</strong> {{ $row->worker_id }}<br> --}}
                                    <strong>Phone:</strong> {{ $row->worker->phone_no ?? 'N/A' }}<br>
                                    <strong>Card:</strong> {{ $row->worker->id_card ?? 'N/A' }}
                                </td>
                                <td>{{ $vault->uID ?? 'N/A' }}</td>
                                <td>{{ $vault->name ?? 'N/A' }}</td>
                                <td>{{ $vault->dob ?? '' }} ({{ $vault->gender ?? '' }})</td>
                                <td>
                                    <small>
                                        {{ $vault->buildingName ?? '' }}, {{ $vault->locality ?? '' }},
                                        {{ $vault->district ?? '' }}, {{ $vault->state ?? '' }} -
                                        {{ $vault->pinCode ?? '' }}
                                    </small>
                                </td>
                                <td>{{$row->status}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-3">
                    {{ $data->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('startSync').addEventListener('click', function() {
            this.disabled = true;
            processBatch();
        });

        function processBatch() {
            const statusDiv = document.getElementById('syncStatus');
            statusDiv.innerHTML = "Processing batch... Please do not close this tab.";

            // Offset is 0 because your controller's WHERE NOT EXISTS
            // will always pick up the next set of unverified workers
            fetch('/bulk-migrant-api/500/0')
                .then(response => response.json())
                .then(res => {
                    if (res.status === 'success') {
                        const data = res.data;
                        statusDiv.innerHTML = `
                    Processed: ${data.batch_processed} |
                    Total Verified: ${data.total_verified} |
                    Remaining: ${data.total_left_to_do}
                `;

                        // If there are still records left to do, call the function again
                        if (data.total_left_to_do > 0) {
                            setTimeout(processBatch, 2000); // 2 second delay to be safe
                        } else {
                            statusDiv.innerHTML = "<strong>Complete! All records processed.</strong>";
                            document.getElementById('startSync').disabled = false;
                        }
                    } else {
                        statusDiv.innerHTML = "Error: " + res.message;
                    }
                })
                .catch(error => {
                    statusDiv.innerHTML = "Connection Error. Retrying in 5 seconds...";
                    setTimeout(processBatch, 5000);
                });
        }
    </script>
@endsection
