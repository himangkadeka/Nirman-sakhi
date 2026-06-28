@extends('layouts.admin-app')

@section('title', 'Admin | Permissions')
@section('breadcrumb_item_1', 'User Management')
@section('breadcrumb_item_2', 'Permissions')

@section('content')
    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data">PERMISSIONS</h4>
        @include('admin.user-management.permission.create')
        @include('admin.user-management.permission.edit')
        <div class="row">
            <div class="col-md-12 table-responsive">
                @can('create permission')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#role-add-modal"><button type="button" class="btn btn-primary b-btn">ADD<i
                                    class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Permission</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $permission->name }}</td>
                                <td>{{ $permission->created_at }}</td>

                                <td>
                                    <span>
                                        @can('update permission')
                                            <button data-toggle="modal" data-target="#permission-edit-modal" aria-hidden="true"
                                                onclick="editPermissionData('{{ $permission->id }}','{{ $permission->name }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>
                                        @endcan

                                        @can('delete permission')
                                            <button onclick="confirmDelete('{{ $permission->id }}','Permission')"
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

    <form id="deleteForm" action="{{ route('admin.permission.delete') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="permission_id" id="primary_code_input">
    </form>



@endsection
