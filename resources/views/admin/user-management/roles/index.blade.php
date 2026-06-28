@extends('layouts.admin-app')

@section('title', 'Admin | Roles')
@section('breadcrumb_item_1', 'User Management')
@section('breadcrumb_item_2', 'Roles')

@section('content')
    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data">ROLES</h4>
        @include('admin.user-management.roles.create')
        @include('admin.user-management.roles.edit')
        <div class="row">
            <div class="col-md-12 table-responsive">
                @can('create role')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#role-add-modal"><button type="button" class="btn btn-primary b-btn" id="addpo">ADD<i
                                    class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan

                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Role Code</th>
                            <th>Role</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->created_at }}</td>
                                <td>
                                    <span>
                                        @can('update role')
                                            <button data-toggle="modal" data-target="#role-edit-modal" aria-hidden="true"
                                                onclick="editRoleData('{{ $role->id }}','{{ $role->name }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>
                                        @endcan
                                        {{-- <i class="fas fa-edit" style="color: #12d3d0;"></i> --}}
                                        @can('delete role')
                                            @if (Auth::user()->role_id != $role->id)
                                                <button onclick="confirmDelete('{{ $role->id }}','Role')"
                                                    style="border: none; background: none; padding: 0; cursor: pointer;">
                                                    <i class="fas fa-solid fa-trash"
                                                        style="color: #ee1b1b; padding-left:5px;"></i>
                                                </button>
                                            @endif
                                        @endcan

                                        {{-- <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal" data-target="#profession-add-modal"><button type="button" class="btn btn-primary b-btn" id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                                        </div> --}}
                                        @can('create role')
                                            {{-- @if ($role->id!=1) --}}
                                            <a href="{{ route('admin.roles.add-permission', $role->id) }}" aria-hidden="true"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-unlock-alt" style="color: #12d3d0;"></i>
                                            </a>
                                            {{-- @endif --}}
                                        @endcan

                                        {{-- <button data-toggle="modal" data-target="#permission-modal" aria-hidden="true"
                                            onclick=""
                                            style="border: none; background: none; padding: 0; cursor: pointer;">
                                            <i class="fas fa-unlock-alt" style="color: #12d3d0;"></i>
                                        </button> --}}


                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <form id="deleteForm" action="{{ route('admin.roles.delete') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="role_id" id="primary_code_input">
    </form>



@endsection
