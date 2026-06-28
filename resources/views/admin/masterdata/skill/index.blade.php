@extends('layouts.admin-app')

@section('title', 'Admin | Skills')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Skills')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data px-5">SKILLS</h4>
        @include('admin.masterdata.skill.create')
        @include('admin.masterdata.skill.edit')
        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                @can('create skill')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#skills-add-modal"><button type="button" class="btn btn-primary b-btn"
                                id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Skill Code</th>
                            <th>Skill Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($skills as $skill)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $skill->skill_code }}</td>
                                <td>{{ $skill->skill_name }}</td>
                                <td>{{ $skill->created_at }}</td>
                                <td>
                                    <span>
                                        @can('update skill')
                                            <button data-toggle="modal" data-target="#skills-edit-modal" aria-hidden="true"
                                                onclick="skillEditModal('{{ $skill->skill_code }}','{{ $skill->skill_name }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>
                                        @endcan
                                        @can('delete skill')
                                        <button onclick="confirmDelete('{{ $skill->skill_code }}','Skill')"
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

    <form id="deleteForm" action="{{ route('admin.skills.delete') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="skill_id" id="primary_code_input">
    </form>

@endsection
