@extends('layouts.admin-app')

@section('title', 'Admin | Family Details |'. $worker->worker_id )
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', $worker->worker_id)
@section('style')
    <style>
        .bg-info {
            color: white;
        }

        .b-dbcard {
            width: 200px;
        }

        .pagination.float-start {
            float: none !important;
            justify-content: flex-end;
        }
    </style>


@endsection
@section('content')

    <div class="container-fluid">

        <div class="col-md-12 table-responsive">
            <table id="abaocTables" class="table table-bordered text-nowrap display nowrap">
                <thead class="thead-dark">
                    <tr>
                        <th>Sno.</th>
                        <th>Worker ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Guardain Name</th>
                        <th>DOB</th>
                        <th>Relation</th>
                        <th>Relation Others</th>
                        <th>Profession</th>
                        <th>Education</th>
                        <th>Nominee</th>
                        <th>is Already regitered</th>
                        <th>BOCW ID</th>
                        <th>Percentage</th>
                        <th>Created At</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->worker_id }}</td>
                            <td>{{ $data->first_name }}</td>
                            <td>{{ $data->last_name }}</td>
                            <td>{{ $data->guardain_name }}</td>
                            <td>{{ $data->dob }}</td>
                            <td>{{ $data->relationDetails->relation_name }}</td>
                            <td>{{$data->relation_others}}</td>
                            <td>{{ $data->profession }}</td>
                            <td>{{ $data->education }}</td>
                            <td>{{ $data->nominee }}</td>
                            <td>{{$data->already_registered}}</td>
                            <td>{{$data->bocwwb_id}}</td>
                            <td>{{$data->nominee_percentage}}</td>
                            <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }}
                            </td>
                            <td>
                                {{-- <a class="btn btn-secondary" href="{{ route('admin.dataupdate.edit', $data->id) }}"><i class="fa fa-pencil"></i></a> --}}
                                <a class="btn btn-danger" href="{{ route('admin.dataupdate.delete-family-details', $data->id) }}"
                                    onclick="return confirm('Are you sure you want to delete this record?')">
                                    <i class="fa fa-trash"></i>&nbsp;Delete
                                 </a>

                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>

                {{ $datas->links() }}

        </div>
    </div>

@endsection
