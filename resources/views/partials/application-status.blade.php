@php
    $status = $application->status ?? $application->application_status;
    $sender = $application->sender_role_id;
    $receiver = $application->application_receiver_role_id;
 $role = $user_details->role_id;
@endphp


@if($role == 2) {{-- HRO view --}}
@if($status == 'A')
    <span class="badge badge-danger">Pending</span>
@elseif($status == 'B' && $application->da_forward == null && $application->resubmit_status == '0')
    <span class="badge badge-danger">Pending</span>
@elseif($status == 'B' && $application->da_forward == 1)
    <span class="badge badge-primary">Application Reviewed</span>
@elseif($status == 'O'  && $application->pull_back==null)
    <span class="badge badge-warning">Forwarded To RO</span>
@elseif($status == 'O'  && $application->pull_back==1)
    <span class="badge badge-primary">Pending </span>
@elseif($status == 'B'  && $application->pull_back==1)
    <span class="badge badge-primary">Pending</span>
@elseif($status == 'C')
    <span class="badge badge-warning">Forwarded To DA</span>
@elseif($status == 'O' && $application->da_forward == 1)
    <span class="badge badge-warning">Reviewed By DA</span>
@elseif($status == 'B' && $application->resubmit_status == 1)
    <span class="badge badge-warning">Resubmitted By Applicant</span>
@elseif($status == 'F')
    <span class="badge badge-success">Approved</span>
@elseif($status == 'D')
    <span class="badge badge-danger">Rejected</span>
@elseif($status == 'G')
    <span class="badge badge-danger">Reverted to Applicant</span>
@endif

@endif

@if($role == 3) {{-- RO view --}}
@if($status == 'O' )
    <span class="badge badge-warning">Received from HRO</span>

@elseif($status == 'C' )
    <span class="badge badge-warning">Forwarded to DA</span>
@elseif($status == 'O' && $application->pull_back == 1)
    <span class="badge badge-warning">Pulled Back From DA</span>

@elseif($status == 'O' && $application->da_forward == 1)
    <span class="badge badge-warning">Reviewed By DA</span>
@elseif($status == 'O' && $application->resubmit_status == 1)
    <span class="badge badge-warning">Resubmitted By Applicant</span>
@elseif($status == 'F')
    <span class="badge badge-success">Approved</span>
@elseif($status == 'D')
    <span class="badge badge-danger">Rejected</span>
@elseif($status == 'G')
    <span class="badge badge-danger">Reverted to Applicant</span>
@endif
@endif

@if($role == 4) {{-- DA view --}}
@if($status == 'C' && $application->da_forward != 1)

    <span class="badge badge-danger">Forwarded By HRO</span>
@elseif($status == 'C'  && $application->da_forward != 1)
    <span class="badge badge-warning">Forwarded By RO</span>
@elseif($status == 'B'  && $application->da_forward = 1)
    <span class="badge badge-warning">Application Reviewed</span>
@elseif($status == 'C'  && $application->da_forward = 1)
    <span class="badge badge-warning">Application Reviewed</span>
@elseif($status == 'O' && $application->da_forward == 1)
    <span class="badge badge-primary">Application Reviewed</span>
@elseif($status == 'B' && $application->da_forward == 1)
    <span class="badge badge-primary">Application Reviewed</span>
@elseif($status == 'C' && $application->da_forward == 1)
    <span class="badge badge-primary">Application Reviewed</span>
@elseif($status == 'O' && $application->pull_back == 1)
    <span class="badge badge-primary">Application Pulled back</span>
@elseif($status == 'F')
    <span class="badge badge-success">Approved</span>
@elseif($status == 'D')
    <span class="badge badge-danger">Rejected</span>
@endif
@endif
