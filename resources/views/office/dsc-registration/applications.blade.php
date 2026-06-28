@extends('layouts.admin-app')

@section('title', 'Office | Application | '.ucfirst('Digital Signature'))
@section('breadcrumb_item_1', 'Applications')
@section('breadcrumb_item_2', 'Digital Signature')



@section('content')
<div class="container-fluid">
    <!-- <div class="my-5" id="b-homedb">
        <div class="container">
        </div>
    </div> -->
    <!-- show Latest Application -->
    <div class="row text-center pl-4" id="sortable-cards">
        <div class="col-lg-12 col-sm-12 p-3 b-customize">
            <div class="bg-light p-4 b-dbcard">
                <div class="">
                    <h5 class="text-left font-weight-light"><i class="fa fa-file-text text-dark" aria-hidden="true"></i> Applications {{ucfirst('Digital Signature')}} :</h5>
                    <div class="table-responsive mt-4">

                        <table class="table table-striped table-bordered text-sm-center table-sm" id="abaocTable">
                            <thead class="thead-dark">
                            <tr>
                                <th>Sl. no</th>
                                <th>Application No</th>
                                <th>Beneficiary Name</th>
                                <th>Profession</th>
                                <th>Beneficiary Address</th>
                                <th>Beneficiary Contact</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($applications as $application)
                                @php
                                    $vaultItem = $vaultData[$application->worker_id] ?? null;
                                    $profession = $professions[$application->worker_id] ?? null;
                                @endphp

                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $application->ack_no }}</td>

                                    <!-- Beneficiary Name -->
                                    <td>
                                        @if ($vaultItem)
                                            {{ is_object($vaultItem) ? ($vaultItem->name ?? 'N/A') : ($vaultItem['name'] ?? 'N/A') }}
                                        @else
                                            <span class="badge badge-warning">Not Found</span>
                                        @endif
                                    </td>

                                    <!-- Profession -->
                                    <td>
                                        {{ $profession ?? 'N/A' }}
                                    </td>

                                    <!-- Address -->
                                    <td>
                                        @if ($vaultItem)
                                            @php
                                                $addressParts = [];
                                                $fields = ['village', 'postOffice', 'subDistrict', 'district', 'state', 'pinCode'];
                                                foreach ($fields as $field) {
                                                    $value = is_object($vaultItem) ? ($vaultItem->$field ?? null) : ($vaultItem[$field] ?? null);
                                                    if (!empty($value)) {
                                                        $addressParts[] = $value;
                                                    }
                                                }
                                            @endphp
                                            {{ !empty($addressParts) ? implode(', ', $addressParts) : 'N/A' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>

                                    <td>{{ $application->phone_no }}</td>
                                    <td>
                                        @if(!$application->idcard)
                                            <span class="badge badge-primary">Approved</span>
                                        @elseif($application->idcard->signature_status == 1)
                                            <span class="badge badge-success">Signed</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if(!$application->idcard)
                                            <a href="{{ route('office.dsc.eSign', encrypt($application->worker_id)) }}" title="e-Sign">
                                                <i class="fa fa-file-signature" aria-hidden="true"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('office.dsc.download-id-card', encrypt($application->worker_id)) }}" title="Download">
                                                <i class="fa fa-file-pdf" aria-hidden="true"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No applications found to sign.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #abaocTable th, #abaocTable td {
            padding: 0.4rem; /* Reduced padding */
            font-size: 0.8rem; /* Smaller font size */
            vertical-align: middle;
        }
        #abaocTable .badge {
            font-size: 0.7rem; /* Smaller badge font size */
        }
        #abaocTable .fa {
            font-size: 1rem; /* Adjust icon size if needed */
        }
    </style>
</div>
@endsection

@section('footer')

@endsection
