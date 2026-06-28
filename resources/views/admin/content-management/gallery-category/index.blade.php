@extends('layouts.admin-app')

@section('title', 'Admin | Gallery Category')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Gallery Category')

@section('content')

<div class="container-fluid">

    <h4 class="text-left mb-3 b-latest-data">GALLERY CATEGORY</h4>
    @include('admin.content-management.gallery-category.create')
    @include('admin.content-management.gallery-category.edit')
    <div class="row">
        <div class="col-md-12 table-responsive">
            <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal" data-target="#gallery-category-add-modal"><button type="button" class="btn btn-primary b-btn" id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
            </div>
            <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                <thead class="thead-dark">
                    <tr>
                        <th>Sno.</th>
                        <th>Category Name</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$category->category_name}}</td>
                        <td>{{$category->created_at}}</td>
                        <td>
                            <span>
                                <button data-toggle="modal" data-target="#gallery-category-edit-modal" aria-hidden="true" onclick="galleryCategoryEditModal('{{$category->id}}','{{$category->category_name}}')" style="border: none; background: none; padding: 0; cursor: pointer;">
                                    <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                </button>
                                <button onclick="confirmDelete('{{$category->id}}','Gallery Category')" style="border: none; background: none; padding: 0; cursor: pointer;">
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

<form id="deleteForm" action="{{ route('admin.gallery-categories.delete') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="gallery_category_id" id="primary_code_input">
</form>

@endsection
