@extends('layouts.admin-app')

@section('title', 'Admin | Categories')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Categories')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data px-5">CATEGORIES</h4>
        @include('admin.masterdata.category.create')
        @include('admin.masterdata.category.edit')
        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                @can('create category')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#category-add-modal"><button type="button" class="btn btn-primary b-btn"
                                id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sl. no.</th>
                            <th>Category Code</th>
                            <th>Category Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->category_code }}</td>
                                <td>{{ $category->category_name }}</td>
                                <td>{{ $category->created_at }}</td>
                                <td>
                                    <span>
                                        @can('update category')
                                            <button data-toggle="modal" data-target="#category-edit-modal" aria-hidden="true"
                                                onclick="categoryEditModal('{{ $category->category_code }}','{{ $category->category_name }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>
                                        @endcan
                                        @can('delete category')
                                            <button onclick="confirmDelete('{{ $category->category_code }}','Category')"
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

    <form id="deleteForm" action="{{ route('admin.categories.delete') }}" method="POST" style="display: none;"
        class="delete-form">
        @csrf
        <input type="hidden" name="category_id" id="primary_code_input">
    </form>

@endsection
