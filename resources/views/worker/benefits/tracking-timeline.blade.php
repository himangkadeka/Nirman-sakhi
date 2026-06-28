<style>
    /* CSS for the vertical timeline */
    .timeline {
        position: relative;
        padding: 0;
        list-style: none;
    }

    .timeline:before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 20px;
        width: 2px;
        background-color: #e9ecef;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 30px;
    }

    .timeline-icon {
        position: absolute;
        left: 0;
        top: 0;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #fff;
        border: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
    }

    .timeline-body {
        margin-left: 60px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 6px;
        border: 1px solid #e9ecef;
    }

    .timeline-body h4 {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .timeline-meta {
        font-size: 13px;
        color: #6c757d;
        margin-bottom: 10px;
    }

    .timeline-comment {
        margin-top: 10px;
        padding-top: 10px;
        border-top: 1px dashed #ced4da;
        font-style: italic;
    }

    /* Icon Colors */
    .icon-submitted {
        color: #007bff;
        border-color: #007bff;
    }

    .icon-approved {
        color: #28a745;
        border-color: #28a745;
    }

    .icon-rejected {
        color: #dc3545;
        border-color: #dc3545;
    }

    .icon-remark {
        color: #ffc107;
        border-color: #ffc107;
    }
</style>

<ul class="timeline">
    <!-- First Event: The Initial Submission -->
    <li class="timeline-item">
        <div class="timeline-icon icon-submitted">
            <i class="fas fa-paper-plane"></i>
        </div>
        <div class="timeline-body">
            <h4>Application Submitted</h4>
            <div class="timeline-meta">
                <span>By: You ({{ $getVaultData['name'] }})</span> |
                <span>{{ \Carbon\Carbon::parse($application->submitted_at)->format('d M Y, h:i A') }}</span>
            </div>
            <p>Your application was successfully submitted to the office for review.</p>
        </div>
    </li>

    <!-- Loop through all subsequent logs -->
    @forelse ($application->logs as $log)
        @php
            // Determine icon and style based on the log's action/status
$iconClass = 'fas fa-info-circle';
$colorClass = 'icon-remark';
if (Str::contains(strtolower($log->to_status), 'approved')) {
    $iconClass = 'fas fa-check';
    $colorClass = 'icon-approved';
}  elseif (Str::contains(strtolower($log->to_status), 'rejected')) {
    $iconClass = 'fas fa-times';
    $colorClass = 'icon-rejected';
            }
        @endphp
        <li class="timeline-item">
            <div class="timeline-icon {{ $colorClass }}">
                <i class="{{ $iconClass }}"></i>
            </div>
            <div class="timeline-body">
                <h4>Status Updated to: <span class="text-success">{{ Str::headline($log->to_status) }}</span></h4>
                <div class="timeline-meta">
                    <span>By:
                        {{ $log->user->firstname ? $log->user->firstname . ' ' . $log->user->lastname : 'System' }}</span>
                    |
                    <span>{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y, h:i A') }}</span>
                </div>

                @if (Auth::check())
                    @if ($log->comment)
                        <div class="timeline-comment">
                            <p class="mb-0"><strong>Officer's Comment:</strong> {{ $log->comment }}</p>
                        </div>
                    @endif
                @endif
            </div>
        </li>
    @empty
        <li class="timeline-item">
            <div class="timeline-icon">
                <i class="fas fa-hourglass-start"></i>
            </div>
            <div class="timeline-body">
                <h4>Pending Review</h4>
                <p>Your application is awaiting its first review by an officer. Please check back later.</p>
            </div>
        </li>
    @endforelse
</ul>
