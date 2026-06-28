@extends('layouts.admin-app')

@section('title', 'Application Status - ' . $role->name)

@section('content')
    <div class="container mt-3">
        <h4>Applications for Role: {{ $role->name }}</h4>
        {{-- <form method="GET" action="{{ route('admin.get-application-status-by-role', ['role' => $roles->id]) ) }}"></form> --}}
        <form method="GET" action="{{ route('admin.get-application-status-by-role', ['role' => $role->id]) }}"></form>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Sno</th>
                    <th>Officer Name</th>
                    <th>Designation</th>
                    <th>Role</th>
                    <th>Total Application</th>
                    <th>View</th>
                </tr>
            </thead>
            <tbody id="modalData">

               @forelse ($officers as $officeName => $officeUsers)
                @foreach ($officeUsers as $officer)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $officeName ?? 'N/A' }}</td>
                        <td>{{ $officer->firstname . ' ' . $officer->lastname }}</td>
                        {{-- <td>{{ $officer->designation->designation_name ?? 'N/A' }}</td> --}}
                        <td>{{ $role->name }}</td>
                        {{-- <td>{{ $officer->getCount($officer->office_id, $officer->id, $officer->role_id) }}</td> --}}
                        <td>{{ $officer->getReceivedApplicationsCount() }}</td>

                        <td>
                               <a href="{{ route('admin.officer-applications') }}"
                                                    style="text-decoration:none; color:black;">
                                                    {{ $role->name }}
                                                </a>
                                                {{-- <button type="submit" class="btn btn-sm btn-primary">View</button> --}}

                        </td>
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="7">No Data Found</td>
                </tr>
            @endforelse


            </tbody>
        </table>        </form>
    </div>
@endsection
