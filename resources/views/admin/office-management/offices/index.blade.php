@extends('layouts.admin-app')

@section('title', 'Admin | Offices')
@section('breadcrumb_item_1', 'Office Management')
@section('breadcrumb_item_2', 'Offices')

@section('content')
    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data">OFFICES</h4>
        @include('admin.office-management.offices.create')
        @include('admin.office-management.offices.edit')
        <div class="row">
            <div class="col-md-12 table-responsive">
                @can('create office')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#office-add-modal"><button type="button" class="btn btn-primary b-btn"
                                id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Office Code</th>
                            <th>Egras Office Code</th>
                            <th>District</th>
                            <th>Office</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($offices as $office)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $office->office_id }}</td>
                                <td>{{ $office->egrass_office_code }}</td>
                                <td>{{ $office->districts->district_name }}</td>
                                <td>{{ $office->office_name }}</td>
                                <td>
                                    @if ($office->status == '1')
                                        Active
                                    @else
                                        Deactived
                                    @endif
                                </td>
                                <td>{{ $office->created_at }}</td>
                                <td>
                                    <span>

                                        @can('update office')
                                            <button data-toggle="modal" data-target="#office-edit-modal" aria-hidden="true"
                                                onclick="editOfficeData('{{ $office->office_id }}','{{ $office->district_code }}','{{ $office->office_name }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>

                                            <a href="javascript:void(0);"
                                                onclick="confirmOfficeUpdate('{{ $office->office_id }}', '{{ $office->status }}')"
                                                style="text-decoration: none; color: '{{ $office->status == 1 ? '#28a745' : '#ee1b1b' }}'">
                                                <i class="fas fa-toggle-{{ $office->status == 1 ? 'on' : 'off' }}"
                                                    style="color: '{{ $office->office == 1 ? '#28a745' : '#ee1b1b' }}'; padding-left:5px;"></i>
                                            </a>
                                        @endcan

                                        @can('delete office')
                                            <button onclick="confirmDelete('{{ $office->office_id }}','Office')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-solid fa-trash" style="color: #ee1b1b; padding-left:5px;"></i>
                                            </button>
                                        @endcan
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <form id="deleteForm" action="{{ route('admin.offices.delete') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="office_code" id="primary_code_input">
    </form>

    <form id="updateOfficeForm" action="{{ route('admin.offices.status') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="id" id="office_id_input">
        <input type="hidden" name="status" id="status_input">
    </form>

@endsection
