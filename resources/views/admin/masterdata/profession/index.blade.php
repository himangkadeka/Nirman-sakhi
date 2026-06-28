@extends('layouts.admin-app')

@section('title', 'Admin | Professions')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Professions')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data px-5">PROFESSIONS</h4>
        @include('admin.masterdata.profession.create')
        @include('admin.masterdata.profession.edit')
        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                @can('create profession')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#profession-add-modal"><button type="button" class="btn btn-primary b-btn"
                                id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Profession Code</th>
                            <th>Profession Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($professions as $profession)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $profession->profession_code }}</td>
                                <td>{{ $profession->profession_name }}</td>
                                <td>{{ $profession->created_at }}</td>
                                <td>
                                    <span>
                                        @can('update profession')
                                            <button data-toggle="modal" data-target="#profession-edit-modal" aria-hidden="true"
                                                onclick="professionEditModal('{{ $profession->profession_code }}','{{ $profession->profession_name }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>
                                        @endcan
                                        @can('delete profession')
                                            <button onclick="confirmDelete('{{ $profession->profession_code }}','Profession')"
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

    <form id="deleteForm" action="{{ route('admin.professions.delete') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="profession_id" id="primary_code_input">
    </form>

@endsection
