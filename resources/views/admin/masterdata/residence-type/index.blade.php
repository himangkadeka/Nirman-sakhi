@extends('layouts.admin-app')

@section('title', 'Admin | Residence Types')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Residence Types')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data px-5">RESIDENCE TYPES</h4>
        @include('admin.masterdata.residence-type.create')
        @include('admin.masterdata.residence-type.edit')
        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                @can('create residence type')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#residence-type-add-modal"><button type="button" class="btn btn-primary b-btn"
                                id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Residence Type Code</th>
                            <th>Residence Type Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($residence_types as $residence_type)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $residence_type->residence_code }}</td>
                                <td>{{ $residence_type->residence_name }}</td>
                                <td>{{ $residence_type->created_at }}</td>
                                <td>
                                    <span>
                                        @can('update residence type')
                                            <button data-toggle="modal" data-target="#residence-type-edit-modal"
                                                aria-hidden="true"
                                                onclick="residenceTypeEditModal('{{ $residence_type->residence_code }}','{{ $residence_type->residence_name }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>
                                        @endcan
                                        @can('delete residence type')
                                            <button
                                                onclick="confirmDelete('{{ $residence_type->residence_code }}','Residence Type')"
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

    <form id="deleteForm" action="{{ route('admin.residence-types.delete') }}" method="POST" style="display: none;"
        class="delete-form">
        @csrf
        <input type="hidden" name="residence_type_id" id="primary_code_input">
    </form>

@endsection
