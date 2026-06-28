@include('layout.workerheader')

<style>
    /* A more professional and modern style for the preview page */
    .preview-container {
        max-width: 900px;
        margin: 30px auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        border: 1px solid #e9ecef;
    }
    .preview-header {
        text-align: center;
        border-bottom: 1px solid #dee2e6;
        padding-bottom: 20px;
        margin-bottom: 30px;
    }
    .preview-header h2 {
        margin-bottom: 5px;
        color: #343a40;
    }
    .preview-header p {
        color: #6c757d;
        font-size: 16px;
    }
    .section-title {
        background-color: #f8f9fa;
        padding: 10px 15px;
        font-weight: bold;
        color: #495057;
        margin-top: 25px;
        margin-bottom: 15px;
        border-radius: 4px;
        border: 1px solid #dee2e6;
    }
    table {
        width: 100%;
        border-collapse: collapse;
    }
    td, th {
        border: 1px solid #dee2e6;
        padding: 12px;
        text-align: left;
        vertical-align: top;
    }
    th {
        background-color: #f8f9fa;
        font-weight: 600;
        width: 35%;
    }
    .worker-details-grid {
        display: flex;
        gap: 30px;
        align-items: flex-start;
    }
    .worker-details-grid .details-table {
        flex: 1;
    }
    .worker-details-grid .photo-container {
        flex-basis: 150px;
        text-align: center;
    }
    .worker-details-grid img {
        width: 130px;
        height: 170px;
        object-fit: cover;
        border: 3px solid #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-radius: 4px;
    }
    .action-buttons {
        text-align: center;
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid #dee2e6;
        display: flex;
        justify-content: center;
        gap: 15px;
    }
</style>

<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')
    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')

        <div class="preview-container">
            <div class="preview-header">
                <h2>Application Preview</h2>
                <p>Please review your details carefully before final submission.</p>
            </div>

            <div class="section-title">Worker & Application Details</div>
            <div class="worker-details-grid">
                <div class="details-table">
                    <table>
                        <tr><th>Application ID</th><td><strong>{{ $submission->application_id }}</strong></td></tr>
                        <tr><th>Benefit Name</th><td>{{ $submission->benefit->name }}</td></tr>
                        @if($submission->benefit->benefit_code=='EA')
                        <tr><th>Student Name</th><td>{{$data['applicantVaultDetails']['name']}}</td></tr>
                        <tr><th>Student Aadhaar Number</th><td>{{ $data['applicantVaultDetails']['uID'] ?? 'N/A' }}</td></tr>
                        @elseif($submission->benefit->benefit_code=='FA' || $submission->benefit->benefit_code=='DB')
                        <tr><th>Applicant Name</th><td>{{$data['applicantVaultDetails']['name']}}</td></tr>
                        <tr><th>Applicant Aadhaar Number</th><td>{{ $data['applicantVaultDetails']['uID'] ?? 'N/A' }}</td></tr>
                        @endif
                        <tr><th>Worker Name</th><td>{{ $getVaultData['name'] ?? 'N/A' }}</td></tr>
                        <tr><th>Worker Aadhaar Number</th><td>{{ $getVaultData['uID'] ?? 'N/A' }}</td></tr>
                    </table>
                </div>
                <div class="photo-container">
                    @if ($submission->benefit->benefit_code=='EA' || $submission->benefit->benefit_code=='DB' || $submission->benefit->benefit_code=='FA')
                    <img src="data:image/jpeg;base64,{{ $data['applicantVaultDetails']['photo'] }}" alt="Applicant Photo">
                    <p>Applicant Image</p>
                        {{-- <img src="data:image/jpeg;base64,{{ $getVaultData['photo'] }}" alt="Applicant Photo"> --}}
                    @else
                        <div style="width: 130px; height: 170px; border: 1px dashed #ccc; display: flex; align-items: center; justify-content: center; text-align:center; font-size:12px;">No Photo Available</div>
                    @endif
                </div>
            </div>

            <div class="section-title">Your Submitted Information</div>
<table>
    @forelse($submission->formSubmissionData as $data)
        @php
            $field = $data->formField;
            $value = $data->value;
        @endphp

        {{-- Skip this iteration if the field definition is missing or the value is empty --}}
        @if (!$field || is_null($value)) @continue @endif

        {{-- This is the full logic to handle master data for selects, radios, and checkboxes --}}
        @if ($field->use_masterdata)
            @php
                // Handle multi-select checkboxes which store a JSON array of IDs
                $decoded_values = json_decode($value, true);
                if (is_array($decoded_values)) {
                    $displayValues = DB::table("Masterdata.{$field->masterdata_table}")
                                       ->whereIn($field->masterdata_table_key, $decoded_values)
                                       ->pluck($field->masterdata_table_value)
                                       ->toArray();
                    $value = implode(', ', $displayValues);
                } else {
                    // It's a single value (from select, radio)
                    $displayValue = DB::table("Masterdata.{$field->masterdata_table}")
                                      ->where($field->masterdata_table_key, $value)
                                      ->value($field->masterdata_table_value);
                    $value = $displayValue ?? $value; // Fallback to ID if not found
                }
            @endphp
        @endif

        <tr>
            <th>{{ Str::headline($field->name) }}</th>
            <td>
                {{-- Use a switch to render different field types appropriately --}}
                @switch($field->type)
                    @case('file')
                        {{-- Create a button that links to the secure file download route --}}
                        <a href="{{ route('file.show', ['data' => $data->id]) }}"
                           target="_blank"
                           class="btn btn-outline-primary btn-sm">
                           <i class="fas fa-eye me-2"></i>View Uploaded File
                        </a>
                        @break

                    @case('textarea')
                        {{-- Use nl2br to respect line breaks in textareas --}}
                        {!! nl2br(e($value)) !!}
                        @break

                    @case('date')
                        {{-- Format the date for better readability --}}
                        {{ \Carbon\Carbon::parse($value)->format('d F, Y') }}
                        @break

                    @default
                        {{-- This handles text, number, select, radio, checkbox (already formatted) --}}
                        {{ $value ?? 'N/A' }}
                @endswitch
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="2" class="text-center text-muted">No additional data was submitted.</td>
        </tr>
    @endforelse
</table>
            <div class="action-buttons">
                <!-- "Edit" button is a simple link back to the form -->
                <a href="{{ route('worker.edit-now', $submission->application_id) }}" class="btn btn-secondary">
                    <i class="fas fa-edit me-2"></i>Edit Application
                </a>

                <!-- "Final Submit" button TRIGGERS the modal -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmationModal">
                    <i class="fas fa-check-circle me-2"></i>Confirm & Final Submit
                </button>
            </div>
        </div>
    </div>
</div>


<!-- ======================================================= -->
<!--                  CONFIRMATION MODAL                     -->
<!-- ======================================================= -->
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirm Final Submission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to submit this application to the office?</p>
                <p class="text-danger"><strong>This action cannot be undone.</strong> You will not be able to edit the application after this point.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

                <!-- The REAL submit button is inside this form -->
                <form action="{{ route('worker.final-submit', $submission->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Yes, Submit Now</button>
                </form>
            </div>
        </div>
    </div>
</div>

@include('components.footer')
