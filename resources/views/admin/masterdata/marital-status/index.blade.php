@extends('layouts.admin-app')

@section('title', 'Admin | Marital Statuses')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Marital Statuses')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data px-5">MARITAL STATUSES</h4>
        @include('admin.masterdata.marital-status.create')
        @include('admin.masterdata.marital-status.edit')
        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                @can('create marital')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#marital-status-add-modal"><button type="button" class="btn btn-primary b-btn"
                                id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>S. no.</th>
                            <th>Marital Status Code</th>
                            <th>Marital Status Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($marital_statuses as $marital_status)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $marital_status->marital_code }}</td>
                                <td>{{ $marital_status->marital_status }}</td>
                                <td>{{ $marital_status->created_at }}</td>
                                <td>
                                    <span>
                                        @can('update marital')
                                            <button data-toggle="modal" data-target="#marital-status-edit-modal"
                                                aria-hidden="true"
                                                onclick="maritalStatusEditModal('{{ $marital_status->marital_code }}','{{ $marital_status->marital_status }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>
                                        @endcan
                                        @can('delete marital')
                                            <button
                                                onclick="confirmDelete('{{ $marital_status->marital_code }}','Marital Status')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-solid fa-trash" style="color: #ee1b1b; padding-left:5px;"></i>
                                            </button>
                                        @endcan
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <form id="deleteForm" action="{{ route('admin.marital-statuses.delete') }}" method="POST" style="display: none;"
        class="delete-form">
        @csrf
        <input type="hidden" name="marital_status_id" id="primary_code_input">
    </form>

@endsection
