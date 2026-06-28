@extends('layouts.admin-app')


@section('title', 'Admin | Age Proofs')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Age Proofs')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data px-5">AGE PROOFS</h4>
        @include('admin.masterdata.age-proof.create')
        @include('admin.masterdata.age-proof.edit')
        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                @can('create age proof')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#age-proof-add-modal"><button type="button" class="btn btn-primary b-btn"
                                id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Age Proof Code</th>
                            <th>Age Proof Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($age_proofs as $age_proof)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $age_proof->age_proof_code }}</td>
                                <td>{{ $age_proof->age_proof_name }}</td>
                                <td>{{ $age_proof->created_at }}</td>
                                <td>
                                    <span>
                                        @can('update age proof')
                                            <button data-toggle="modal" data-target="#age_proof-edit-modal" aria-hidden="true"
                                                onclick="ageProofEditModal('{{ $age_proof->age_proof_code }}','{{ $age_proof->age_proof_name }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>
                                        @endcan
                                        @can('delete age proof')
                                            <button onclick="confirmDelete('{{ $age_proof->age_proof_code }}','Age Proof')"
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

    <form id="deleteForm" action="{{ route('admin.age-proofs.delete') }}" method="POST" style="display: none;"
        class="delete-form">
        @csrf
        <input type="hidden" name="age_proof_id" id="primary_code_input">
    </form>

@endsection
