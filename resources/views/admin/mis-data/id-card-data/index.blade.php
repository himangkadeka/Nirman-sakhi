@extends('layouts.admin-app')

@section('title', 'Admin | Id Card Data')
@section('breadcrumb_item_1', 'MIS Data')
@section('breadcrumb_item_2', 'Id Card Data')
@section('style')
    <style>
        .bg-info {
            color: white;
        }

        .b-dbcard {
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

                        <div class="" style="color: white;">
                            <p class="text-center font-weight-bold" style="font-size: 14px;">ID Cards Received</p>
                            <h3 class="text-center font-weight-bold" style="margin-top: -5px; font-size: 13px;">
                                {{ $count }}
                            </h3>
                            <div class="text-left" style="margin: 5px 0px 5px;">
                                <span class="badge badge-success"></span>
                                <span style="font-size:12px;"></span>
                            </div>
                        </div>
                    </div>
                </div>








                {{-- <div class="col-lg-4 col-sm-12 p-3 b-customize">
                    <div class="bg-info p-4 b-dbcard">

                        <div class="">
                            <p class="text-left font-weight-bold" style="font-size: 14px;">Onboarding Applications
                                Received</p>
                            <h3 class="text-left font-weight-bold" style="margin-top: -5px">
                            </h3>
                            <div class="text-left" style="margin: 10px 0px 5px;">
                                <span class="badge badge-success"></span>
                                <span style="font-size:13px;"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-12 p-3 b-customize">
                    <div class="bg-info p-4 b-dbcard">

                        <div class="">
                            <p class="text-left font-weight-bold" style="font-size: 14px;">New Applications Received
                            </p>
                            <h3 class="text-left font-weight-bold" style="margin-top: -5px"></h3>
                            <div class="text-left" style="margin: 10px 0px 5px;">
                                <span class="badge badge-success"></span>
                                <span style="font-size:13px;"></span>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="col-md-12 table-responsive">
                <form method="GET" action="{{ route('admin.idcarddata.index') }}" class="mb-3">
                    <div class="input-group my-3">
                        <div class="col-8"><a href="{{ route('admin.idcarddata.export', 'csv') }}"
                                class="btn btn-secondary btn-sm"> CSV</a>

                            <a href="{{ route('admin.idcarddata.export', 'xlsx') }}" class="btn btn-secondary btn-sm">
                                Excel</a>
                            <a href="{{ route('admin.idcarddata.export', 'pdf') }}" class="btn btn-secondary btn-sm"> PDF</a>
                        </div>
                        <div class="col-3">
                            <input type="text" name="search" class="form-control" placeholder="Search by Worker ID"
                                value="{{ request('search') }}" style="max-width:90%;">
                        </div>
                        <div class="col">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
{{--
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search by Worker ID"
                            value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div> --}}
                </form>
                {{-- <div class="my-3">
                    <a href="{{ route('admin.idcarddata.export', 'csv') }}" class="btn btn-secondary btn-sm"> CSV</a>

                    <a href="{{ route('admin.idcarddata.export', 'xlsx') }}" class="btn btn-secondary btn-sm">
                        Excel</a>
                    <a href="{{ route('admin.idcarddata.export', 'pdf') }}" class="btn btn-secondary btn-sm"> PDF</a>
                </div> --}}

                <table id="" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Application Number</th>
                            {{--                            <th>Office name</th> --}}
                            {{--                            <th>District</th> --}}
                            <th>Id Card Signed Date</th>
                            <th>Download Id Card</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($idCards as $idCard)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $idCard->worker_id }}</td>
                                {{--                                <td>{{ $idCard->getMainWorker->office_id }}</td> --}}
                                {{--                                <td>{{ $idCard->getMainWorker->districtName->district_name }}</td> --}}

                                <td>{{ $idCard->certificate_upload_date }}</td>
                                <td><a href="{{ route('office.dsc.download-id-card', encrypt($idCard->worker_id)) }}"><i
                                            class="fa fa-file-pdf" aria-hidden="true"></i></a>
                                    <button onclick="confirmDelete('{{ $idCard->worker_id }}','Id Card')"
                                        style="border: none; background: none; padding: 0; cursor: pointer;">
                                        <i class="fas fa-solid fa-trash" style="color: #ee1b1b; padding-left:5px;"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>{{ $idCards->links() }}
    </div>

    <form id="deleteForm" action="{{ route('admin.idcarddata.delete') }}" method="POST" style="display: none;"
        class="delete-form">
        @csrf
        <input type="hidden" name="worker_id" id="primary_code_input">
    </form>

@endsection
