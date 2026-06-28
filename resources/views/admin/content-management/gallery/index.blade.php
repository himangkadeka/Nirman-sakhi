@extends('layouts.admin-app')

@section('title', 'Admin | Gallery')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Gallery')

@section('content')

<div class="container-fluid">

    <h4 class="text-left mb-3 b-latest-data">GALLERY</h4>
    @include('admin.content-management.gallery.edit')
    <div class="row">
        <div class="col-md-12 table-responsive">
            <div class="add-butt p-3"><a href="{{ route('admin.galleries.create') }}"><button type="button" class="btn btn-primary b-btn" id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
            </div>
            <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                <thead class="thead-dark">
                    <tr>
                        <th>Sno.</th>
                        <th>Image Preview</th>
                        <th>Category</th>
                        <th>Caption</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($galleries as $gallery)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$gallery->image_path}}</td>
                        <td>
                            @foreach($gallery->categoryIds as $categoryId)
                            {{ \App\Models\GalleryCategory::find($categoryId)->category_name }}
                            @if(!$loop->last)
                            ,
                            @endif
                            @endforeach
                        </td>
                        <td>{{$gallery->caption}}</td>
                        <td>{{$gallery->created_at}}</td>
                        <td>
                            <span>
                                <button data-toggle="modal" data-target="#gallery-gallery-edit-modal" aria-hidden="true" onclick="galleryCategoryEditModal('{{$gallery->id}}','{{$gallery->gallery_name}}')" style="border: none; background: none; padding: 0; cursor: pointer;">
                                    <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                </button>
                                <button onclick="confirmDelete('{{$gallery->id}}','Gallery gallery')" style="border: none; background: none; padding: 0; cursor: pointer;">
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

<form id="deleteForm" action="{{ route('admin.galleries.delete') }}" method="POST" style="display: none;">
    @csrf
    <input type="hidden" name="gallery_id" id="primary_code_input">
</form>

@endsection