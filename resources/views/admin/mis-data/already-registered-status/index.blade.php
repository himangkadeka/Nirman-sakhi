@extends('layouts.admin-app')

@section('title', 'Admin | Already Registered Status')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Already Registered Status')

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 table-responsive">
            <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                <thead class="thead-dark">
                    <tr>
                        <th>Sno.</th>
                        <th>Acknowledgement Number</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workerdata as $worker)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$worker->ack_no}}</td>
                        <td>
                           @if ($worker->status === 'A')
                           Application Submitted
						   @elseif($worker->status == 'B')
                           Forwarded By DA
						   @elseif($worker->status == 'B' & $worker->da_forward == 1)
                           Sent By DA
						   @elseif($worker->status == 'B' && $worker->pull_back == 1)
                           Pulled Back
                           @elseif($worker->status == 'C')
                           Forwarded By RO
                           @elseif($worker->status == 'D')
                           Application Rejected
                           @elseif($worker->status == 'E')
                           Pulled Back from DA
                           @elseif($worker->status == 'F')
                           Application Approved
                           @elseif($worker->status == 'G')
                           Application Reverted
                           @endif
                    </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
