@extends('layouts.admin-app')

@section('title', 'Admin | Nature Of Works')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Nature Of Works')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data px-5">NATURE OF WORKS</h4>
        @include('admin.masterdata.nature-of-work.create')
        @include('admin.masterdata.nature-of-work.edit')
        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                @can('create nature of work')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#nature-of-work-add-modal"><button type="button" class="btn btn-primary b-btn"
                                id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>S. no.</th>
                            <th>Nature Of Work Code</th>
                            <th>Nature Of Work Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nature_of_works as $nature_of_work)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $nature_of_work->nature_of_work_code }}</td>
                                <td>{{ $nature_of_work->nature_of_work }}</td>
                                <td>{{ $nature_of_work->created_at }}</td>
                                <td>
                                    <span>
                                        @can('update nature of work')
                                            <button data-toggle="modal" data-target="#nature-of-work-edit-modal"
                                                aria-hidden="true"
                                                onclick="natureOfWorkEditModal('{{ $nature_of_work->nature_of_work_code }}','{{ $nature_of_work->nature_of_work }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>
                                        @endcan
                                        @can('delete nature of work')
                                            <button
                                                onclick="confirmDelete('{{ $nature_of_work->nature_of_work_code }}','Nature Of Work')"
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

    <form id="deleteForm" action="{{ route('admin.nature-of-works.delete') }}" method="POST" style="display: none;"
        class="delete-form">
        @csrf
        <input type="hidden" name="nature_of_work_id" id="primary_code_input">
    </form>

@endsection
