@extends('layouts.admin-app')

@section('title', 'Admin | Users')
@section('breadcrumb_item_1', 'User Management')
@section('breadcrumb_item_2', 'Users')

@section('content')

    <style>
        body {
            /*font-family: 'Inter', sans-serif;*/
            background: #f4f7fb;
            font-size: 12px;
            color: #2c3e50;
        }
        .table-responsive {
            border-radius: 12px;
            overflow-x: auto;
            overflow-y: hidden;
            width: 100%;
            scrollbar-width: thin;
            scrollbar-color: #90caf9 #edf4ff;
        }

        /* Chrome Scrollbar */
        .table-responsive::-webkit-scrollbar {
            height: 10px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #edf4ff;
            border-radius: 20px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #42a5f5, #1e88e5);
            border-radius: 20px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #1e88e5, #1565c0);
        }

        #abaocTable {
            min-width: 1800px;
        }

        .page-title {
            font-size: 20px;
            font-weight: 700;
            color: #1d3557;
            letter-spacing: 0.3px;
        }

        .govt-card {
            border: none;
            border-radius: 14px;
            background: #ffffff;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.05);
        }

        .govt-badge {
            background: linear-gradient(135deg, #4e73df, #36b9cc);
            color: #fff;
            font-size: 11px;
            padding: 6px 14px;
            border-radius: 30px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .b-btn {
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            padding: 8px 16px;
            background: linear-gradient(135deg, #1e88e5, #42a5f5);
            border: none;
            color: #fff;
            box-shadow: 0 2px 6px rgba(30, 136, 229, 0.2);
            transition: 0.2s ease;
        }

        .b-btn:hover {
            background: linear-gradient(135deg, #1565c0, #1e88e5);
            transform: translateY(-1px);
        }

        #abaocTable {
            border-collapse: separate !important;
            border-spacing: 0;
            width: 100% !important;
            font-size: 11.5px;
            background: #fff;
        }

        #abaocTable thead th {
            background: linear-gradient(135deg, #edf4ff, #dfefff);
            color: #1e3a5f;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            border: none !important;
            padding: 12px 10px;
            vertical-align: middle;
            white-space: nowrap;
        }

        #abaocTable tbody td {
            border-top: 1px solid #edf2f7 !important;
            border-left: none !important;
            border-right: none !important;
            padding: 10px 8px;
            vertical-align: middle;
            white-space: nowrap;
            color: #34495e;
            background: #fff;
        }

        #abaocTable tbody tr {
            transition: all 0.2s ease;
        }

        #abaocTable tbody tr:hover td {
            background: #f6fbff;
        }

        .badge {
            padding: 5px 10px;
            font-size: 10px;
            border-radius: 30px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .bg-success {
            background: #22c55e !important;
        }

        .bg-danger {
            background: #ef4444 !important;
        }

        .bg-info {
            background: #0ea5e9 !important;
        }

        .bg-warning {
            background: #facc15 !important;
        }

        .table-action-icons i {
            font-size: 14px;
            margin: 0 5px;
            transition: 0.2s ease;
        }

        .table-action-icons i:hover {
            transform: scale(1.12);
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #dce6f1;
            border-radius: 8px;
            padding: 5px 10px;
            font-size: 12px;
            background: #fff;
            outline: none;
        }

        .dataTables_wrapper .dataTables_length select {
            border-radius: 6px;
            border: 1px solid #dce6f1;
            padding: 4px 8px;
            font-size: 12px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 6px !important;
            font-size: 11px;
            padding: 4px 10px !important;
            margin: 2px;
            border: none !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: linear-gradient(135deg, #1976d2, #42a5f5) !important;
            color: white !important;
        }

        .table-responsive {
            border-radius: 12px;
            overflow: hidden;
        }

        .minimal-text {
            color: #6b7280;
            font-size: 11px;
        }
    </style>

    <div class="container-fluid py-3">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="page-title mb-0">
                👥 User Management
            </h4>

            <span class="govt-badge">
            Total Users : {{ $users->count() }}
        </span>
        </div>

        @include('admin.user-management.users.create')
        @include('admin.user-management.users.edit')
        @include('admin.user-management.users.user-transfer')

        <div class="card govt-card">
            <div class="card-body">

                @can('create user')
                    <div class="mb-3">
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#user-add-modal">
                            <button type="button" class="btn b-btn" id="addpo">
                                ADD USER
                                <i class="fa fa-plus pl-2"></i>
                            </button>
                        </a>
                    </div>
                @endcan

                    <div class="table-responsive custom-scrollbar w-100"  style="overflow-x:auto; overflow-y:hidden; white-space:nowrap;">

                        <table id="abaocTable"
                               class="table align-middle display nowrap mb-0"
                               style="min-width:2200px; width:max-content;">

                        <thead>
                        <tr class="text-center">
                            <th>Sno.</th>
                            <th>User Id</th>
                            <th>Username</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Designation</th>
                            <th>Office</th>
                            <th>District</th>
                            <th>Role</th>
                            <th>In-Charge</th>
                            <th>Status</th>
                            <th>Password Status</th>
                            <th>Created</th>
                            <th>Updated</th>

                            @if (Auth::user()->role_id == 1)
                                <th>Action</th>
                            @endif
                        </tr>
                        </thead>

                        <tbody>

                        @foreach ($users as $user)

                            <tr>

                                <td class="text-center">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="text-center text-muted">
                                    {{ $user->id }}
                                </td>

                                <td>
                                    <strong>{{ $user->username }}</strong>
                                </td>

                                <td>{{ $user->firstname }}</td>

                                <td>{{ $user->lastname }}</td>

                                <td>{{ $user->phone }}</td>

                                <td class="minimal-text">
                                    {{ str_replace(['@', '.'], ['[at]', '[dot]'], $user->email) }}
                                </td>

                                <td>
                                    @if ($user->designation_id != null)
                                        {{ $user->designation->designation ?? '--' }}
                                    @else
                                        --
                                    @endif
                                </td>

                                <td>
                                    {{ $user->office->office_name ?? '--' }}
                                </td>

                                <td>
                                    {{ $user->districts->district_name ?? '--' }}
                                </td>

                                <td>
                                <span class="badge bg-info text-white">
                                    {{ $user->role->name }}
                                </span>
                                </td>

                                <td>
                               <span class="badge text-white {{ $user->is_incharge ? 'bg-success' : 'bg-secondary' }}">
    {{ $user->is_incharge ? 'In Charge' : 'Not In Charge' }}
</span>
                                </td>

                                <td class="text-center">
                                    @if ($user->status == '1')
                                        <span class="badge bg-success text-white">
                                        Active
                                    </span>
                                    @else
                                        <span class="badge bg-danger text-white">
                                        Deactivated
                                    </span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if ($user->password_change_first_attempt == true)
                                        <span class="badge bg-success text-white">
                                        Changed
                                    </span>
                                    @else
                                        <span class="badge bg-warning text-dark">
                                        Pending
                                    </span>
                                    @endif
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($user->created_at)->format('d-m-Y') }}
                                </td>

                                <td>
                                    {{ \Carbon\Carbon::parse($user->updated_at)->format('d-m-Y') }}
                                </td>

                                @if (Auth::user()->role_id == 1)

                                    <td class="text-center table-action-icons">

                                        @can('update user')

                                            {{-- Edit --}}
                                            <button
                                                    data-toggle="modal"
                                                    data-target="#user-edit-modal"
                                                    aria-hidden="true"

                                                    onclick="editUserData(
                                                            '{{ $user->id }}',
                                                            '{{ $user->username }}',
                                                            '{{ $user->firstname }}',
                                                            '{{ $user->lastname }}',
                                                            '{{ $user->phone }}',
                                                            '{{ $user->email }}',
                                                            '{{ $user->designation_id }}',
                                                            '{{ $user->office_id }}',
                                                            '{{ $user->role_id }}',
                                                            '{{ $user->district }}',
                                                            '{{ $user->is_incharge }}'
                                                            )"

                                                    style="border:none;background:none;padding:0;cursor:pointer;">

                                                <i class="fas fa-edit" style="color:#12d3d0;"></i>

                                            </button>

                                            {{-- Status --}}
                                            @if ($user->role_id != 1)

                                                <a href="javascript:void(0);"
                                                   onclick="confirmUserUpdate('{{ $user->id }}', '{{ $user->status }}')"
                                                   style="text-decoration:none;">

                                                    <i class="fas fa-toggle-{{ $user->status == 1 ? 'on' : 'off' }}"
                                                       style="color:{{ $user->status == 1 ? '#22c55e' : '#ef4444' }};"></i>

                                                </a>

                                            @endif

                                            {{-- Password --}}
                                            <a href="javascript:void(0);"
                                               onclick="confirmPasswordUpdate('{{ $user->id }}')"
                                               style="text-decoration:none;">

                                                <i class="fas fa-key" style="color:#4250dd;"></i>

                                            </a>

                                            {{-- Transfer --}}
                                            <button
                                                    data-toggle="modal"
                                                    data-target="#user-transfer-modal"
                                                    aria-hidden="true"

                                                    onclick="transferUpdateUsers(
                                                            '{{ $user->id }}',
                                                            '{{ $user->username }}',
                                                            '{{ $user->firstname }}',
                                                            '{{ $user->lastname }}',
                                                            '{{ $user->phone }}',
                                                            '{{ $user->email }}',
                                                            '{{ $user->designation_id }}',
                                                            '{{ $user->office_id }}',
                                                            '{{ $user->role_id }}',
                                                            '{{ $user->district }}'
                                                            )"

                                                    style="border:none;background:none;cursor:pointer;">

                                                <i class="fa fa-refresh" style="color:#f5b041;"></i>

                                            </button>

                                        @endcan

                                    </td>

                                @endif

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            </div>
        </div>

        {{-- Hidden Forms --}}
        <form id="updateUserForm"
              action="{{ route('admin.users.status') }}"
              method="POST"
              style="display:none;">

            @csrf

            <input type="hidden" name="id" id="user_id_input">

            <input type="hidden" name="status" id="status_input">

        </form>

        <form id="updatePasswordForm"
              action="{{ route('admin.users.reset-user-password') }}"
              method="POST"
              style="display:none;">

            @csrf

            <input type="hidden" name="id" id="user_id_input_pass">

        </form>

    </div>

@endsection