@extends('layouts.admin-app')

@section('title', 'Admin | Relations')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Relations')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data px-5">RELATIONS</h4>

        @include('admin.masterdata.relations.create')
        @include('admin.masterdata.relations.edit')

        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Relation Code</th>
                            <th>Relation Name</th>
                            <th>Gender</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($relations as $key => $relation)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $relation->relation_code }}</td>
                                <td>{{ $relation->relation_name }}</td>
                                <td>{{ $relation->gender ?? '-' }}</td>
                                <td>
                                    <button
                                        data-toggle="modal"
                                        data-target="#gender-edit-modal"
                                        onclick="openEditModal(
                                            '{{ $relation->relation_code }}',
                                            '{{ $relation->gender ?? '' }}'
                                        )"
                                        style="border:none; background:none; cursor:pointer;">
                                        <i class="fas fa-edit" style="color:#12d3d0;"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        function openEditModal(relationCode, gender) {
            document.getElementById('edit_relation_code').value = relationCode;
            document.getElementById('edit_gender').value = gender;
        }
    </script>

@endsection
