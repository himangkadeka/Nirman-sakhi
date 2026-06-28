@extends('layouts.admin-app')

@section('title', 'Admin | Portal User Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Portal User Data')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Username</th>
                            <th>Designation</th>
                            <th>Office Address</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $userSerial = 0;
                            $pfcSerial = count($users); // Start PFC serial after user serials
                        @endphp

                        @foreach ($users as $user)
                            <tr>
                                <td>{{ ++$userSerial }}</td>
                                <td>{{ $user->username }}</td>
                                <td>
                                    @if ($user->designation_id != null)
                                        {{ $user->designation->designation }}
                                    @else
                                        --
                                    @endif
                                </td>
                                <td>{{ $user->office->office_name }}</td>
                                <td>{{ $user->role->name }}</td>
                            </tr>
                        @endforeach
                        @foreach ($pfcdata as $pfc)
                            <tr>
                                <td>{{ ++$pfcSerial }}</td>
                                <td>{{ $pfc->kiosk_email }}</td>
                                <td>{{ $pfc->user_type }}</td>
                                <td>{{ $pfc->office_address }}</td>
                                <td>{{ $pfc->user_type }}</td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

@endsection
