@extends('layouts.admin-app')

@section('title', 'Admin | Reject Application')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Reject List')
@section('style')
    <style>
        .bg-info {
            color: white;
        }
        .b-dbcard{
            width: 200px;
        }


    </style>
@endsection
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="row text-center py-4" id="" style="width: 100%;">
                <div class="b-customize">
                    <div class="p-2" style="background-color: #3dc6cb;">
                        <div class="" style="color:white;">
                            <p class="text-center" style="font-size: 14px;">Total Applications</p>
                            <h3 class="text-center font-weight-bold" style="margin-top: -5px; font-size: 13px;">{{$count}}
                            </h3>
                            <div class="text-left" style="margin: 5px 0px 5px;">
                                <span class="badge badge-success"></span>
                                <span style="font-size:12px;"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 table-responsive">
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                    <tr>
                        <th>Sno.</th>
                        <th>Worker Id</th>
                        <th>Application Number</th>
                        <th>Phone No</th>
                        <th>Office</th>
                        <th>Onboarding</th>
                        <th>Reasons</th>
                        <th>Reason id</th>
                        <th>Remarks</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $worker)

                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$worker->worker_id}}</td>
                            <td>{{$worker->ack_no}}</td>
                            <td>{{$worker->phone_no}}</td>
                            <td>{{$worker->officeName->office_name}}</td>
                            <td>{{$worker->already_registered}}</td>
                            <td>
                                @if ($worker->workerStatus && $worker->workerStatus->mapped_remarks->isNotEmpty())
                                    <ol>
                                        @foreach ($worker->workerStatus->mapped_remarks as $reason)
                                            <li>{{ $reason }}</li>
                                        @endforeach
                                    </ol>
                                @else
                                    <span class="text-muted">No reasons</span>
                                @endif
                            </td>
                            <td>{{$worker->workerStatus->reasons}}</td>

                            <td>{{$worker->workerStatus->remarks}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
