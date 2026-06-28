@extends('layouts.admin-app')

@section('title', 'Admin | Designations')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Designations')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data px-5">DESIGNATIONS</h4>
        @include('admin.masterdata.designation.create')
        @include('admin.masterdata.designation.edit')
        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                @can('create designation')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#designation-add-modal"><button type="button" class="btn btn-primary b-btn"
                                id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Designation Code</th>
                            <th>Designation Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($designations as $designation)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $designation->id }}</td>
                                <td>{{ $designation->designation }}</td>
                                <td>{{ $designation->created_at }}</td>
                                <td>
                                    <span>
                                        @can('update designation')
                                            <button data-toggle="modal" data-target="#designation-edit-modal" aria-hidden="true"
                                                onclick="ageDesignationEditModal('{{ $designation->id }}','{{ $designation->designation }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>
                                        @endcan
                                        @can('delete designation')
                                            <button onclick="confirmDelete('{{ $designation->id }}','Designation')"
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

    <form id="deleteForm" action="{{ route('admin.designations.delete') }}" method="POST" style="display: none;"
        class="delete-form">
        @csrf
        <input type="hidden" name="designation_id" id="primary_code_input">
    </form>

@endsection
