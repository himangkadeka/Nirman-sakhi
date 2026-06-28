{{-- This view only contains the table rows (<tr>...</tr>) --}}
@forelse ($scrutinyApplications as $submission)
    <tr>
        <td><input type="checkbox" class="scrutiny-checkbox" data-id="{{ $submission->id }}"></td>
        <td>{{ $submission->application_id }}</td>
        <td>{{ $submission->worker->name ?? 'N/A' }}</td>
        <td>{{ $submission->benefit->name ?? 'N/A' }}</td>
        <td>{{ $submission->created_at->format('Y-m-d') }}</td>
        <td>
            @if ($submission->status == 'approved')
                <span class="badge bg-success">
                    Approved
                </span>
                @elseif($submission->status == 'rejected')
                <span class="badge bg-danger">
                    Rejected
                </span>
            @endif
        </td>
        <td class="text-center">
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm preview-button" data-id="{{ $submission->id }}"
                    data-bs-toggle="tooltip" title="Preview Application">
                    <i class="fas fa-eye"></i>
                </button>
                <button type="button" class="btn btn-info btn-sm view-log-btn" data-id="{{ $submission->id }}"
                    data-bs-toggle="tooltip" title="View Action Log">
                    <i class="fas fa-history"></i>
                </button>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center text-muted py-4">No approved applications are awaiting scrutiny.</td>
    </tr>
@endforelse
