@extends('layouts.admin-app')

@section('title', 'Admin | Issuer Types')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Issuer Types')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data px-5">ISSUER TYPES</h4>
        @include('admin.masterdata.issuer-type.create')
        @include('admin.masterdata.issuer-type.edit')
        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                @can('create issuer type')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#issuer-type-add-modal"><button type="button" class="btn btn-primary b-btn"
                                id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Issuer Type Code</th>
                            <th>Issuer Type Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($issuer_types as $issuer_type)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $issuer_type->issuer_code }}</td>
                                <td>{{ $issuer_type->issuer_name }}</td>
                                <td>{{ $issuer_type->created_at }}</td>
                                <td>
                                    <span>
                                        @can('update issuer type')
                                            <button data-toggle="modal" data-target="#issuer-type-edit-modal" aria-hidden="true"
                                                onclick="issuerTypeEditModal('{{ $issuer_type->issuer_code }}','{{ $issuer_type->issuer_name }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>
                                        @endcan
                                        @can('delete issuer type')
                                        <button onclick="confirmDelete('{{ $issuer_type->issuer_code }}','Issuer Type')"
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

    <form id="deleteForm" action="{{ route('admin.issuer-types.delete') }}" method="POST" style="display: none;"
        class="delete-form">
        @csrf
        <input type="hidden" name="issuer_type_id" id="primary_code_input">
    </form>

@endsection
