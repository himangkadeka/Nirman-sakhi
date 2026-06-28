@extends('layouts.admin-app')

@section('title', 'Office | Application | ' . ucfirst('Nominee List'))
@section('breadcrumb_item_1', 'Applications')
@section('breadcrumb_item_2', 'Nominee')
@section('header')
    {{-- header for file link --}}
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Registered Nominee List</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>SL No</th>
                            <th>Worker ID Card No</th>
                            <th>Nominee Id</th>
                            <th>Applicant's Name</th>
                            <th>Applicant's Phone</th>
                            <th>Applicant's Relation</th>
                            <th>Nominee Percentage</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($nominees as $nominee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $nominee->id_card_no ?? 'N/A' }}</td>
                                <td>{{ $nominee->nominee_id ?? 'N/A' }}</td>
                                <td>{{ $nominee->name ?? 'N/A' }}</td>
                                <td>{{ $nominee->phone ?? 'N/A' }}</td>
                                <td>{{ $nominee->relation ?? 'N/A' }}</td>
                                <td>{{ $nominee->nominee_percentage ?$nominee->nominee_percentage.' %': 'N/A' }}</td>
                                <td>{{ ucfirst($nominee->nominee_or_legal==0?'Nominee':'Legal Heir') }}</td>
                                <td>
                                    {{-- Example status display --}}
                                    @if ($nominee->status == 1)
                                        <span class="badge bg-success">Approved</span>
                                    @elseif ($nominee->status == 2)
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">

                                        {{-- 1. Preview Button --}}
                                        <a href="#" class="btn btn-sm btn-info" title="Preview">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        {{-- Only show Approve/Reject if status is pending (or similar logic) --}}
                                        @if($nominee->status == 0)

                                            {{-- 2. Approve Button (Triggers Modal) --}}
                                            <button type="button" class="btn btn-sm btn-success mx-2" title="Approve"
                                                    data-bs-toggle="modal" data-bs-target="#approveModal-{{ $nominee->id }}">
                                                <i class="fas fa-check"></i>
                                            </button>

                                            {{-- 3. Reject Button (Triggers Modal) --}}
                                            <button type="button" class="btn btn-sm btn-danger" title="Reject"
                                                    data-bs-toggle="modal" data-bs-target="#rejectModal-{{ $nominee->id }}">
                                                <i class="fas fa-times"></i>
                                            </button>

                                        @endif
                                    </div>
                                </td>
                            </tr>

                            {{-- Modals need to be inside the loop to associate them with the specific $nominee --}}

                            <!-- Approve Modal -->
                            <div class="modal fade" id="approveModal-{{ $nominee->id }}" tabindex="-1" aria-labelledby="approveModalLabel-{{ $nominee->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-success text-white">
                                            <h5 class="modal-title" id="approveModalLabel-{{ $nominee->id }}">Confirm Approval</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        {{-- Update the route name to match your application --}}
                                        <form action="{{route('office.nominee.approve',$nominee->id)}}" method="POST">
                                            @csrf
                                            @method('PATCH') {{-- Assuming approval is an update/PATCH --}}
                                            <div class="modal-body">
                                                Are you sure you want to approve the nominee application for <strong>{{ $nominee->applicant->name ?? 'this applicant' }}</strong>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-success">Yes, Approve</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal-{{ $nominee->id }}" tabindex="-1" aria-labelledby="rejectModalLabel-{{ $nominee->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-danger text-white">
                                            <h5 class="modal-title" id="rejectModalLabel-{{ $nominee->id }}">Confirm Rejection</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        {{-- Update the route name to match your application --}}
                                        <form action="{{route('office.nominee.reject',$nominee->id)}}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <div class="modal-body">
                                                <p>You are rejecting the nominee application for <strong>{{ $nominee->applicant->name ?? 'this applicant' }}</strong>.</p>

                                                <div class="mb-3">
                                                    <label for="rejection_reason-{{ $nominee->id }}" class="form-label">Rejection Reason (Required)</label>
                                                    <textarea class="form-control" id="rejection_reason-{{ $nominee->id }}" name="rejection_reason" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-danger">Submit Rejection</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No nominees found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Optional: Add pagination if you are paginating the results --}}
            {{-- <div class="mt-3">
                {{ $nominees->links() }}
            </div> --}}

        </div>
    </div>
@endsection
