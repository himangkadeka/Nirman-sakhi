@extends('layouts.admin-app')

@section('title', 'Admin | Migrant Worker')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Migrant Worker Data')
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
        <div class="row text-center py-4" id="sortable-cards" style="width: 100%;">
            <div class="b-customize">
                <div class="p-2 b-dbcard" style="background-color: #3dc6cb;">
                    <div class="" style="color:white;">
                        <p class="text-center font-weight-bold" style="font-size: 14px;">Total Count</p>
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
                        <th>Acknowledgment Number</th>
                        <th>Status</th>
                        <th>State</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workers as $worker)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ $worker->mainWorkerForm->ack_no }}</td>
                        <td>{{ $worker->mainWorkerForm->status  }}</td>
                        <td>{{$worker->getState($worker->state_id)}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
