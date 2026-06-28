@extends('layouts.admin-app')

@section('title', 'Admin | Schemes')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Schemes')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data px-5">SCHEMES</h4>
        @include('admin.masterdata.scheme.create')
        @include('admin.masterdata.scheme.edit')
        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                @can('create scheme')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#schemes-add-modal"><button type="button" class="btn btn-primary b-btn"
                                id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Scheme Code</th>
                            <th>Scheme Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($schemes as $scheme)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $scheme->scheme_code }}</td>
                                <td>{{ $scheme->scheme_name }}</td>
                                <td>{{ $scheme->created_at }}</td>
                                <td>
                                    <span>
                                        @can('update scheme')
                                            <button data-toggle="modal" data-target="#scheme-edit-modal" aria-hidden="true"
                                                onclick="schemeEditModal('{{ $scheme->scheme_code }}','{{ $scheme->scheme_name }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>
                                        @endcan
                                        @can('delete scheme')
                                            <button onclick="confirmDelete('{{ $scheme->scheme_code }}','Scheme')"
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

    <form id="deleteForm" action="{{ route('admin.schemes.delete') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="scheme_id" id="primary_code_input">
    </form>

@endsection
