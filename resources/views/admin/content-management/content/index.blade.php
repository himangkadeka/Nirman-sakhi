@extends('layouts.admin-app')

@section('title', 'Admin | content')
@section('breadcrumb_item_1', 'Content Management')
@section('breadcrumb_item_2', 'content')

@section('content')

<div class="container-fluid">

    <h4 class="text-left mb-3 b-latest-data">content</h4>
    @include('admin.content-management.content.create')
    @include('admin.content-management.content.edit')
    <div class="row">
        <div class="col-md-12 table-responsive">
            <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal" data-target="#content-add-modal"><button type="button" class="btn btn-primary b-btn" id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
            </div>
            <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                <thead class="thead-dark">
                    <tr>
                        <th>Sno.</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contents as $content)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$content->title}}</td>
                        <td>{{$content->description}}</td>
                        <td>{{$content->created_at}}</td>
                        <td>
                            <span>
                                <button data-toggle="modal" data-target="#content-edit-modal" aria-hidden="true" onclick="galleryCategoryEditModal('{{$content->id}}','{{$content->cm_speech}}')" style="border: none; background: none; padding: 0; cursor: pointer;">
                                    <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                </button>
                                <button onclick="confirmDelete('{{$content->id}}','Gallery Category')" style="border: none; background: none; padding: 0; cursor: pointer;">
                                    <i class="fas fa-solid fa-trash" style="color: #ee1b1b; padding-left:5px;"></i>
                                </button>
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>

<form id="deleteForm" action="{{ route('admin.contents.delete') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="content_id" id="primary_code_input">
</form>

@endsection
