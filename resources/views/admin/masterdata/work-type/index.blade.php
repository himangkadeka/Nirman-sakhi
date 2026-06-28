@extends('layouts.admin-app')

@section('title', 'Admin | Work Types')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Work Types')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data px-5">WORK TYPES</h4>
        @include('admin.masterdata.work-type.create')
        @include('admin.masterdata.work-type.edit')
        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                @can('create work type')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#work-type-add-modal"><button type="button" class="btn btn-primary b-btn"
                                id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Work Type Code</th>
                            <th>Work Type Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($work_types as $work_type)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $work_type->work_type_code }}</td>
                                <td>{{ $work_type->work_type_name }}</td>
                                <td>{{ $work_type->created_at }}</td>
                                <td>
                                    <span>
                                        @can('update work type')
                                            <button data-toggle="modal" data-target="#work-type-edit-modal" aria-hidden="true"
                                                onclick="workTypeEditModal('{{ $work_type->work_type_code }}','{{ $work_type->work_type_name }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>
                                        @endcan
                                        @can('delete work type')
                                            <button onclick="confirmDelete('{{ $work_type->work_type_code }}','Work Type')"
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

    <form id="deleteForm" action="{{ route('admin.work-types.delete') }}" method="POST" style="display: none;"
        class="delete-form">
        @csrf
        <input type="hidden" name="work_type_id" id="primary_code_input">
    </form>

@endsection
