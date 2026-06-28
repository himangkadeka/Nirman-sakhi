@forelse ($submittedApplications as $submission)
    <tr>
        @if (isset($showCheckboxes) && $showCheckboxes && Auth::user()->role_id != 4)
            <td><input type="checkbox" class="app-checkbox" data-id="{{ $submission->id }}"></td>
        @endif
        <td>{{ $submission->application_id }}</td>

        {{-- NOTE: You will need to implement logic to get Name, Contact, etc. --}}
        <td>{{ $submission->getApplicantDetails()->name }}</td>
        <td>{{ $submission->created_at->format('Y-m-d') }}</td>
        <td>{{ $submission->worker->phone_no }}</td>
        <td><small class="text-muted">{{ $submission->getApplicantDetails()->account_no }}<br>
                {{ $submission->getApplicantDetails()->bank_name }} <br>
                IFSC: {{ $submission->getApplicantDetails()->ifsc }}</small>
        </td>
        <td class="text-center">
            <div class="btn-group">
                <button class="btn btn-primary btn-sm shadow-sm preview-button"
                    data-id="{{ $submission->application_id }}" data-bs-toggle="tooltip" title="Preview Application">
                    <i class="fas fa-eye"></i>
                </button>
                @if ((Auth::user()->role_id == 2 || Auth::user()->role_id == 3) && !in_array($submission->status, ['approved', 'rejected','reverted']))
                    <button class="btn btn-success btn-sm shadow-sm forward-single-btn" data-id="{{ $submission->id }}"
                        data-bs-toggle="tooltip" title="Forward">
                        <i class="fas fa-share"></i>
                    </button>
                @endif

                @if ((Auth::user()->role_id == 3 || Auth::user()->role_id == 4) && !in_array($submission->status, ['approved', 'rejected','reverted']))
                    <button type="button" class="btn btn-warning btn-sm shadow-sm send-back-single-btn"
                        data-id="{{ $submission->id }}" {{-- Call the accessor as if it's a property. Laravel runs the function in the background. --}}
                        data-previous-user-id="{{ $submission->forwarded_by_user_log->user->id ?? '' }}"
                        data-previous-user-name="{{ $submission->last_log_from_lower_role->user->username ?? 'the original sender' }}"
                        data-bs-toggle="tooltip" title="Send Back to Previous Officer">
                        <i class="fas fa-reply"></i>
                    </button>
                @endif
                {{-- <button class="btn btn-primary btn-sm shadow-sm preview-button" data-id="{{ $submission->id }}"
                    data-bs-toggle="tooltip" title="Preview Application">
                    <i class="fas fa-eye"></i>
                </button> --}}
                <button type="button" class="btn btn-info btn-sm shadow-sm view-log-btn"
                    data-id="{{ $submission->id }}" data-bs-toggle="tooltip" title="View Action Log">
                    <i class="fas fa-history"></i>
                </button>
            </div>
        </td>

        @if (!in_array($submission->status, ['approved', 'rejected','reverted']))
            <td class="text-center">
                <div class="btn-group">
                    {{-- Change onclick to open the new modal, passing the single ID --}}
                    @if (
                        (Auth::user()->role_id == 2 && !in_array($submission->status, ['forwarded_to_ro', 'forwarded_to_da'])) ||
                            (Auth::user()->role_id == 3 && in_array($submission->status, ['forwarded_to_ro', 'forwarded_to_da'])))
                        <button type="button" class="btn btn-danger btn-sm shadow-sm reject-single-btn"
                            {{-- Use this specific class --}} data-id="{{ $submission->id }}" data-bs-toggle="tooltip"
                            title="Reject Application">
                            <i class="fas fa-times"></i>
                    @endif
                    @if (
                        (Auth::user()->role_id == 2 && !in_array($submission->status, ['forwarded_to_ro', 'forwarded_to_da'])) ||
                            (Auth::user()->role_id == 3 && in_array($submission->status, ['forwarded_to_ro', 'forwarded_to_da'])))
                        <button type="button" class="btn btn-warning btn-sm shadow-sm revert-single-btn"
                            data-id="{{ $submission->id }}" data-bs-toggle="tooltip" title="Revert to Applicant">
                            <i class="fas fa-undo"></i>
                        </button>
                    @endif

                    @if (Auth::user()->role_id == 2 &&
                            in_array($submission->status, ['forwarded_to_ro', 'forwarded_to_da', 'send_back_to_ro']))
                        <button class="btn btn-dark btn-sm shadow-sm pull-back-btn" data-id="{{ $submission->id }}"
                            data-bs-toggle="tooltip" title="Pull Back Application">
                            <i class="fas fa-file-import"></i>
                        </button>
                    @endif

                    @if (
                        !in_array($submission->status, ['approved', 'rejected','reverted']) &&
                            (Auth::user()->role_id == 3 ||
                                (Auth::user()->role_id == 2 && !in_array($submission->status, ['forwarded_to_ro', 'forwarded_to_da']))))
                        <button type="button" class="btn btn-success btn-sm shadow-sm approve-single-btn"
                            data-id="{{ $submission->id }}" data-bs-toggle="tooltip" title="Approve Application">
                            <i class="fas fa-check"></i>
                        </button>
                    @endif

                </div>
            </td>
        @endif
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center text-muted py-4">
            No submitted applications found.
        </td>
    </tr>
@endforelse
