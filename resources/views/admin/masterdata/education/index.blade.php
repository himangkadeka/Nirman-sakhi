@extends('layouts.admin-app')

@section('title', 'Admin | Educations')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Educations')

@section('content')

<div class="container-fluid">

    <h4 class="text-left mb-3 b-latest-data px-5">EDUCATIONS</h4>
    @include('admin.masterdata.education.create')
    @include('admin.masterdata.education.edit')
    <div class="row">
        <div class="col-md-12 table-responsive px-5">
            @can('create education')
            <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal" data-target="#education-add-modal"><button type="button" class="btn btn-primary b-btn" id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
            </div>
            @endcan
            <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                <thead class="thead-dark">
                    <tr>
                        <th>Sno.</th>
                        <th>Education Code</th>
                        <th>Education Name</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($educations as $education)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$education->education_code}}</td>
                        <td>{{$education->education_name}}</td>
                        <td>{{$education->created_at}}</td>
                        <td>
                            <span>
                                @can('update education')
                                <button data-toggle="modal" data-target="#education-edit-modal" aria-hidden="true" onclick="educationEditModal('{{$education->education_code}}','{{$education->education_name}}')" style="border: none; background: none; padding: 0; cursor: pointer;">
                                    <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                </button>
                                @endcan
                                @can('delete education')
                                <button onclick="confirmDelete('{{$education->education_code}}','Education')" style="border: none; background: none; padding: 0; cursor: pointer;">
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

<form id="deleteForm" action="{{ route('admin.educations.delete') }}" method="POST" style="display: none;" class="delete-form">
    @csrf
    <input type="hidden" name="education_id" id="primary_code_input">
</form>

@endsection
