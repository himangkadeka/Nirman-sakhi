@extends('layouts.admin-app')

@section('title', 'Admin | Ration Types')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Ration Types')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data px-5">RATION TYPES</h4>
        @include('admin.masterdata.ration-type.create')
        @include('admin.masterdata.ration-type.edit')
        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                @can('create ration type')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#ration-type-add-modal"><button type="button" class="btn btn-primary b-btn"
                                id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Ration Type ID</th>
                            <th>Ration Type</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rationTypes as $rationType)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rationType->ration_code }}</td>
                                <td>{{ $rationType->name }}</td>
                                <td>{{ $rationType->created_at }}</td>
                                <td>
                                    <span>
                                        @can('update ration type')
                                            <button data-toggle="modal" data-target="#ration-type-edit-modal" aria-hidden="true"
                                                onclick="editRationTypeModal('{{ $rationType->ration_code }}','{{ $rationType->name }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>
                                        @endcan
                                        @can('delete ration type')
                                            <button onclick="confirmDelete('{{ $rationType->ration_code }}','Ration-Type')"
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

    <form id="deleteForm" action="{{ route('admin.ration-types.delete') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="ration_type_id" id="primary_code_input">
    </form>

@endsection
