@extends('layouts.admin-app')

@section('title', 'Admin | Users')
@section('breadcrumb_item_1', 'User Management')
@section('breadcrumb_item_2', 'Transferred Users')
@section('content')
    <div class="container-fluid py-3">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0 text-primary">👥 Transferred Users</h4>
            <span class="badge bg-warning">Total: {{ $users->count() }}</span>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            {{--<div class="card-body p-2">--}}
                <div class="table-responsive">
                    <table id="abaocTable" class="table table-sm table-hover align-middle table-bordered text-nowrap display nowrap mb-0">
                        <thead class="table-light text-nowrap">
                        <tr class="text-center small text-secondary">
                            <th>#</th>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Designation</th>
                            <th>Role</th>
                            <th>Is Retired</th>
                            <th>Retired At</th>
                            <th>Was In Charge?</th>
                            <th>From District</th>
                            <th>From Office</th>
                            <th>To District</th>
                            <th>To Office</th>
                            <th>Document</th>
                        </tr>
                        </thead>
                        <tbody class="small">
                        @foreach ($users as $user)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center text-muted">{{ $user->id }}</td>
                                <td><span class="fw-semibold text-dark">{{ $user->username }}</span></td>
                                <td>{{ $user->firstname }}</td>
                                <td>{{ $user->lastname }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ str_replace(['@', '.'], ['[at]', '[dot]'], $user->email) }}</td>
                                <td>{{ $user->designations->designation ?? '-' }}</td>
                                <td><span class="badge bg-info text-white">{{ $user->roles->name ?? '-' }}</span></td>
                                <td class="text-center">
                                    @if ($user->is_retired)
                                        <span class="badge bg-danger text-white">Yes</span>
                                    @else
                                        <span class="badge bg-success text-white">No</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($user->is_retired)
                                        <span class="text-dark">{{ $user->retired_at}}</span>
                                    @else
                                        <span class="text-dark">--</span>
                                        @endif
                                     </td>
                                <td class="text-center">
                                    @if ($user->is_incharged)
                                        <span class="badge bg-primary text-white">Yes</span>
                                    @else
                                        <span class="badge bg-danger text-white">No</span>
                                    @endif
                                </td>
                                <td>{{ $user->districtsFrom->district_name ?? '-' }}</td>
                                <td>{{ $user->officeFrom->office_name ?? '-' }}</td>
                                <td>{{ $user->districtsTo->district_name ?? '-' }}</td>
                                <td>{{ $user->officeTo->office_name ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="d-inline-flex align-items-center">

                                        {{-- View --}}
                                        @if ($user->transfer_document)
                                            <a href="{{ route('admin.users.transfer-document-view', basename($user->transfer_document)) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-outline-primary mr-1">
                                                <i class="fa fa-file-text-o"></i>
                                            </a>
                                        @endif
                                        <button class="btn btn-sm btn-warning mr-1"
                                                data-toggle="modal"
                                                data-target="#updateDocModal{{ $user->id }}">
                                            <i class="fa fa-pencil"></i>
                                        </button>


                                        {{-- Update --}}




                                        {{-- Delete --}}
                                        @if($user->transfer_document)
                                            <form action="{{ route('admin.users.transfer-document-delete', $user->id) }}"
                                                  method="POST"
                                                  class="m-0 p-0"
                                                  onsubmit="return confirm('Delete this document?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif

                                    </div>
                                </td>





                            </tr>
                            <div class="modal fade" id="updateDocModal{{ $user->id }}" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Update Document</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>

                                        <form action="{{ route('admin.users.transfer-document-update', $user->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')

                                            <div class="modal-body">
                                                <label>Upload New Document</label>
                                                <input type="file" name="transfer_document" class="form-control" required>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <!-- Update Modal -->



    {{--</div>--}}
@endsection

@section('footer')

@endsection
