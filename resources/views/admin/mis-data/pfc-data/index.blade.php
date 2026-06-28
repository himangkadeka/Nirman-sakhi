@extends('layouts.admin-app')

@section('title', 'Admin | PFC Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'PFC Data')

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12 table-responsive">
                <form method="GET" action="{{ route('admin.pfcdata.index') }}" class="mb-3">
                    <div class="input-group my-3">
                        <div class="col-8"><a href="{{ route('admin.pfcdata.export', 'csv') }}"
                                class="btn btn-secondary btn-sm"> CSV</a>

                            <a href="{{ route('admin.pfcdata.export', 'xlsx') }}" class="btn btn-secondary btn-sm">
                                Excel</a>
                            <a href="{{ route('admin.pfcdata.export', 'pdf') }}" class="btn btn-secondary btn-sm"> PDF</a>
                        </div>
                        <div class="col-3">
                            <input type="text" name="search" class="form-control" placeholder="Search by Worker ID"
                                value="{{ request('search') }}" style="max-width:90%;">
                        </div>
                        <div class="col">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
                {{-- <div class="my-3">
                    <a href="{{ route('admin.pfcdata.export', 'csv') }}" class="btn btn-secondary btn-sm"> CSV</a>

                    <a href="{{ route('admin.pfcdata.export', 'xlsx') }}" class="btn btn-secondary btn-sm">
                        Excel</a>
                    <a href="{{ route('admin.pfcdata.export', 'pdf') }}" class="btn btn-secondary btn-sm"> PDF</a>
                </div> --}}
                <table id="" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>District</th>
                            <th>PFC Name</th>
                            <th>Address</th>
                            <th>PIN</th>
                            <th>Landmark</th>
                            <th>Latitude</th>
                            <th>Longitude</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pfcdata as $pfc)
                            <tr>
                                <td scope="row" class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="text-center align-middle">{{ $pfc->districts->district_name ?? 'N/A' }}</td>
                                <td class="text-center align-middle">{{ $pfc->pfc_name }}</td>
                                <td class="text-center align-middle">{{ $pfc->postal_address }}</td>
                                <td class="text-center align-middle">{{ $pfc->pin_code }}</td>
                                <td class="text-center align-middle">{{ $pfc->nearby_landmark }}</td>
                                <td class="text-center align-middle">{{ $pfc->latitude }}</td>
                                <td class="text-center align-middle">{{ $pfc->longitude }}</td>

                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
        {{ $pfcdata->links() }}
    </div>

@endsection
