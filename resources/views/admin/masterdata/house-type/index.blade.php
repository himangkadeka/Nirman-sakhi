@extends('layouts.admin-app')

@section('title', 'Admin | House Types')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'House Types')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data px-5">HOUSE TYPES</h4>
        @include('admin.masterdata.house-type.create')
        @include('admin.masterdata.house-type.edit')
        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                @can('create housetype')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#house-type-add-modal"><button type="button" class="btn btn-primary b-btn"
                                id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>House Type Code</th>
                            <th>House Type Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($house_types as $house_type)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $house_type->house_code }}</td>
                                <td>{{ $house_type->house_type }}</td>
                                <td>{{ $house_type->created_at }}</td>
                                <td>
                                    <span>
                                        @can('update housetype')
                                            <button data-toggle="modal" data-target="#house-type-edit-modal" aria-hidden="true"
                                                onclick="houseTypeEditModal('{{ $house_type->house_code }}','{{ $house_type->house_type }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>
                                        @endcan
                                        @can('delete housetype')
                                            <button onclick="confirmDelete('{{ $house_type->house_code }}','House Type')"
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

    <form id="deleteForm" action="{{ route('admin.house-types.delete') }}" method="POST" style="display: none;"
        class="delete-form">
        @csrf
        <input type="hidden" name="house_type_id" id="primary_code_input">
    </form>

@endsection
