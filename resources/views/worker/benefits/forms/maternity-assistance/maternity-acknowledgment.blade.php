{{-- @include('layout.workerheader')
<div class="container py-5 text-center">
    <div class="card shadow p-5">
        <div class="text-success mb-3">
            <i class="fa fa-check-circle fa-5x"></i>
        </div>
        <h2 class="text-success">Application Submitted Successfully!</h2>
        <p class="lead">Your application for Educational Scholarship has been received.</p>

        <div class="row justify-content-center mt-4">
            <div class="col-md-6">
                <table class="table table-bordered">
                    <tr>
                        <th>Application No</th>
                        <td class="font-weight-bold">{{ $application->application_number }}</td>
                    </tr>
                    <tr>
                        <th>Date</th>
                        <td>{{ $application->updated_at->format('d-m-Y') }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><span class="badge badge-primary">Submitted to RO</span></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="mt-4">
            <!-- Print Acknowledgement -->
            <button onclick="window.print()" class="btn btn-info mr-2">
                <i class="fa fa-print"></i> Print Receipt
            </button>

            <!-- Print Full Application Form -->
            <a href="#" target="_blank" class="btn btn-dark">
                <i class="fa fa-file-pdf"></i> Download Application Form
            </a>

            <a href="{{ route('worker-dashboard') }}" class="btn btn-outline-secondary ml-2">Back to Dashboard</a>
        </div>
    </div>
</div> --}}



@include('layout.workerheader')

<style>
    .ack-container {
        max-width: 800px;
        margin: 50px auto;
        padding: 40px;
        background: #ffffff;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        text-align: center;
    }
    .ack-icon {
        color: #28a745; /* Green color for success */
        font-size: 80px;
        margin-bottom: 20px;
        animation: pop-in 0.5s ease-out;
    }
    .ack-container h2 {
        font-size: 28px;
        color: #343a40;
        margin-bottom: 15px;
    }
    .ack-container p {
        font-size: 16px;
        color: #6c757d;
        line-height: 1.6;
    }
    .ack-details {
        margin: 30px 0;
        padding: 20px;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        text-align: left;
    }
    .ack-details strong {
        display: inline-block;
        width: 150px;
    }
    .action-buttons {
        margin-top: 30px;
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    @keyframes pop-in {
        0% { transform: scale(0.5); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>

<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')
    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')

        <div class="ack-container">
            <div class="ack-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <h2>Application Submitted Successfully!</h2>
            <p>Your application has been sent to the office for review. You will be notified of any updates.</p>

            <div class="ack-details">
                <p><strong>Application ID:</strong> {{ $application->application_number }}</p>
                <p><strong>Benefit Name:</strong> {{ $submission->benefit->name }}</p>
                @if ($submission->benefit->benefit_code=='EA' || $submission->benefit->benefit_code=='MT' || $submission->benefit->benefit_code=='DB')
                    <p><strong>Applicant Name:</strong> {{ $application->applicant_name }}</p>
                @endif

                <p><strong>Worker Name:</strong> {{ $getVaultData['name'] }}</p>

                <p><strong>Office Name:</strong> {{ $workerData->officeName->office_name ?? 'N/A' }}</p>

                <p><strong>Submission Date:</strong> {{ \Carbon\Carbon::parse($application->submitted_at)->format('d F, Y h:i A') }}</p>
            </div>

            <div class="action-buttons">
                <a target="_blank" href="{{ route('worker.download-acknowledgment', $submission->id) }}" class="btn btn-primary">
                    <i class="fas fa-download me-2"></i>Download Acknowledgment
                </a>

                <a target="_blank" href="{{ route('worker.print-application', $submission->id) }}" class="btn btn-info">
                    <i class="fas fa-file-pdf me-2"></i>Download Application
                </a>

                <a href="{{ route('worker-dashboard') }}" class="btn btn-secondary">
                    <i class="fas fa-tachometer-alt me-2"></i>Go to Dashboard
                </a>
            </div>
        </div>
    </div>
</div>

@include('components.footer')
