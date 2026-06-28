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
                        <th>Type Of Issuer</th>
                        <th>Issuing Organisation</th>
                        <th>Issuing Date</th>
                        <th>Issuing Person</th>
                        <th>Type Of Work</th>
                        <th>Issuing Person Contact</th>
                        <th>Is Same?</th>
                        <th>Employer Name</th>
                        <th>Employer Contact Number</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Date Count</th>
                        <th>Type Of Employer</th>
                        <th>Certificate Proof</th>
                        <th>Profession</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($datas as $data)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data->worker_id }}</td>
                            <td>{{ $data->type_of_issuer }}</td>
                            <td>{{ $data->issuing_org }}</td>
                            <td>{{ $data->issuing_date }}</td>
                            <td>{{ $data->issuing_person }}</td>
                            <td>{{ $data->type_of_work }}</td>
                            <td>{{$data->contact_issuing_person}}</td>
                            <td>{{ $data->is_same }}</td>
                            <td>{{ $data->employer_name }}</td>
                            <td>{{ $data->employer_contact_number }}</td>
                            <td>{{$data->from_date}}</td>
                            <td>{{$data->to_date}}</td>
                            <td>{{$data->date_count}}</td>
                            <td>{{$data->type_of_employer}}</td>
                            <td>{{$data->certificate_proof}}</td>
                            <td>{{$data->profession}}</td>
                            <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y') }}
                            </td>
                            <td>
                                {{-- <a class="btn btn-secondary" href="{{ route('admin.dataupdate.edit', $data->id) }}"><i class="fa fa-pencil"></i></a> --}}
                                <a class="btn btn-danger" href="{{ route('admin.dataupdate.delete-certificate-details', $data->id) }}"
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
