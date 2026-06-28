@extends('layouts.admin-app')

@section('title', 'Office | Application | Benefit Overview')
@section('breadcrumb_item_1', 'Applications')
@section('breadcrumb_item_2', 'Benefit Overview Dashboard')

{{-- Page-specific styles are placed in the 'header' section --}}
@section('header')
    <style>
        /* Scoping all styles to this specific component to avoid conflicts with the main admin layout. */
        .nirman-sahi-dashboard-container {
            font-family: Arial, sans-serif;
            color: #333;
            margin-top: 15px;
            /* Optional: Adjusts spacing if the admin layout has its own padding */

        }

        .nirman-sahi-dashboard-container .page-specific-header {
            background: #1466ff;
            color: #fff;
            padding: 20px;
            text-align: center;
            position: relative;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .nirman-sahi-dashboard-container .logout {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            background: #fff;
            color: #1466ff;
            border: 1px solid #1466ff;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .nirman-sahi-dashboard-container .search-bar {
            margin-bottom: 15px;
            text-align: right;
        }

        .nirman-sahi-dashboard-container .search-bar input {
            padding: 8px;
            width: 280px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .nirman-sahi-dashboard-container .tabs {
            display: flex;
            flex-wrap: wrap;
            border-bottom: 3px solid #1466ff;
            margin-bottom: 0;
        }

        .nirman-sahi-dashboard-container .tabs .tab-button {
            /* CHANGED from 'button' to '.tab-button' */
            flex-grow: 1;
            padding: 12px 10px;
            background: #f1f1f1;
            border: 1px solid #ddd;
            border-bottom: none;
            cursor: pointer;
            transition: background .3s, color .3s;
            font-size: 14px;
            margin-right: 4px;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;

            /* ADD these two lines to override default <a> tag styles */
            color: #333;
            /* Set default text color */
            text-decoration: none;
            /* Remove the underline */
        }

        .nirman-sahi-dashboard-container .tabs .tab-button.active {
            background: #1466ff;
            color: #fff;
            border-color: #1466ff;
        }

        .nirman-sahi-dashboard-container .tabs .tab-button:hover:not(.active) {
            background: #e0e0e0;
        }

        .nirman-sahi-dashboard-container .tab-content {
            display: none;
            background: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
            margin-bottom: 20px;
        }

        .nirman-sahi-dashboard-container .tab-content.active {
            display: block;
        }

        .nirman-sahi-dashboard-container table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 13px;
        }

        .nirman-sahi-dashboard-container th,
        .nirman-sahi-dashboard-container td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
        }

        .nirman-sahi-dashboard-container th {
            background: #f2f2f2;
            color: #333;
            font-weight: bold;
        }

        .nirman-sahi-dashboard-container tr:nth-child(even) {
            background: #f9f9f9;
        }

        .nirman-sahi-dashboard-container .btn {
            background-color: #1466ff;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
            margin: 2px;
        }

        .nirman-sahi-dashboard-container .btn:hover {
            background-color: #45a049;
        }

        .nirman-sahi-dashboard-container .btn.btn-revert {
            background-color: #f44336;
        }

        .nirman-sahi-dashboard-container .btn.btn-revert:hover {
            background-color: #d32f2f;
        }

        .nirman-sahi-dashboard-container .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .nirman-sahi-dashboard-container .summary-card {
            background: #fff;
            border: 1px solid #ddd;
            border-left: 5px solid #1466ff;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .nirman-sahi-dashboard-container .summary-card h3 {
            color: #555;
            margin-bottom: 8px;
            font-size: 1rem;
        }

        .nirman-sahi-dashboard-container .summary-card p {
            font-size: 24px;
            font-weight: bold;
            color: #1466ff;
        }

        .nirman-sahi-dashboard-container .pagination-container {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 15px 0;
            flex-wrap: wrap;
        }

        .nirman-sahi-dashboard-container .pagination-container a,
        .nirman-sahi-dashboard-container .pagination-container span {
            color: #1466ff;
            padding: 8px 12px;
            margin: 0 4px;
            border: 1px solid #ddd;
            text-decoration: none;
            transition: background-color .3s;
            border-radius: 4px;
            cursor: pointer;
        }

        .nirman-sahi-dashboard-container .pagination-container span.disabled {
            color: #aaa;
            cursor: not-allowed;
            background-color: #f9f9f9;
        }

        .nirman-sahi-dashboard-container .pagination-container a:hover:not(.active) {
            background-color: #f1f1f1;
        }

        .nirman-sahi-dashboard-container .pagination-container .active {
            background-color: #1466ff;
            color: white;
            border-color: #1466ff;
        }
    </style>
@endsection

@section('content')
    <div class="nirman-sahi-dashboard-container mx-5">
        @include('office.benefits.lc-lm-dashboard.tabs')

        <div id="accounts" class="tab-content active">

            {{-- NEW: PPA Signing Workflow Section --}}
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Signed PPA</h4>
                </div>
                <div class="card-body">
                    <p>The following batches are ready for Forwarding.</p>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Batch ID</th>
                                    <th>No. of Applications</th>
                                    <th>Date Arrived</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pendingSignatureBatches as $batch)
                                    <tr>
                                        <td><strong>{{ $batch->batch_id }}</strong></td>
                                        <td>{{ $batch->application_count }}</td>
                                        <td>{{ \Carbon\Carbon::parse($batch->arrived_at)->format('d-M-Y H:i A') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                {{-- Download the previously signed PPA --}}
                                                <a href="{{ route('office.lc-lm-dashboard.ppa.downloadForSigning', ['batch_id' => $batch->batch_id]) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="fas fa-download"></i> Download for Signing
                                                </a>
                                                {{-- Button to open the upload modal --}}
                                                <button class="btn btn-sm btn-success upload-final-signature-btn"
                                                    data-batch-id="{{ $batch->batch_id }}">
                                                    <i class="fas fa-upload"></i> Upload Signed PPA
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center p-3">There are no batches awaiting your
                                            signature.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{ $pendingSignatureBatches->links() }}
                </div>
            </div>
        </div>

        {{-- Your existing summary and applications tables --}}
        <h3>Budget Summary by Scheme</h3>
        <table id="accountsSummaryTable">
            <thead>
                <tr>
                    <th>Scheme</th>
                    <th>Total Sanctioned Amount</th>
                </tr>
            </thead>
            <tbody>
                {{-- Using number_format for consistency --}}
                @forelse ($budgetSummary as $summaryItem)
                    <tr>
                        <td>{{ $summaryItem->scheme_name }}</td>
                        <td>{{ number_format($summaryItem->total_budget, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2" style="text-align: center;">No budget summary available.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h3 style="margin-top:20px;">Applications List</h3>
        <table id="applicationsTable">
            <thead>
                <tr>
                    <th>App ID</th>
                    <th>Worker ID Card</th>
                    <th>Scheme</th>
                    <th>Sanctioned Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($applications as $app)
                    <tr>
                        <td>{{ $app->application_id }}</td>
                        <td>{{ $app->worker->id_card }}</td>
                        <td>{{ $app->benefit->name }}</td>
                        <td>{{ number_format($app->sanctioned_amount, 2) }}</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center;">No applications found in the accounts queue.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $applications->links() }}
        </div>
    </div>
    </div>
    <div class="modal fade" id="uploadFinalSignatureModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Your Signed PPA</h5>
                    <button type="button" class="btn-close" data-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('office.lc-lm-dashboard.ppa.uploadFinalSignature') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Batch ID</label>
                            <input type="text" class="form-control" id="modal_final_batch_id" name="batch_id" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="signed_ppa_file" class="form-label">Your Signed PPA File</label>
                            <input class="form-control" type="file" id="signed_ppa_file" name="signed_ppa_file" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Submit & Forward</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
document.addEventListener('DOMContentLoaded', function() {
    const uploadModalEl = document.getElementById('uploadFinalSignatureModal');
    const uploadModal = new bootstrap.Modal(uploadModalEl);

    document.body.addEventListener('click', function(event) {
        const uploadButton = event.target.closest('.upload-final-signature-btn');
        if (uploadButton) {
            const batchId = uploadButton.dataset.batchId;
            uploadModalEl.querySelector('#modal_final_batch_id').value = batchId;
            uploadModal.show();
        }
    });
});
</script>
@endsection
