@extends('layouts.admin-app')

@section('title', 'Admin | Amounts')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Amounts')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data px-5">AMOUNTS</h4>
        @include('admin.masterdata.amounts.create')
        @include('admin.masterdata.amounts.edit')
        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                @can('create amount')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#amount-add-modal"><button type="button" class="btn btn-primary b-btn"
                                id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Amount Description</th>
                            <th>Amount</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($amounts as $amount)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $amount->amount_description }}</td>
                                <td>{{ $amount->amount }}</td>
                                <td>{{ $amount->created_at }}</td>
                                <td>
                                    <span>
                                        @can('update amount')
                                            <button data-toggle="modal" data-target="#amount-edit-modal" aria-hidden="true"
                                                onclick="amountEditModal('{{ $amount->id }}','{{ $amount->amount_description }}','{{ $amount->amount }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>
                                        @endcan
                                        @can('delete amount')
                                            <button onclick="confirmDelete('{{ $amount->id }}','Amount')"
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

    <form id="deleteForm" action="{{ route('admin.amounts.delete') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="amount_id" id="primary_code_input">
    </form>

@endsection
