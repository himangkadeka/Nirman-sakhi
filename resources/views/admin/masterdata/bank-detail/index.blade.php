@extends('layouts.admin-app')

@section('title', 'Admin | Banks')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Banks')

@section('content')
    <div class="container-fluid">

        <h4 class="text-left mb-3 ml-5 b-latest-data">BANKS</h4>
        @include('admin.masterdata.bank-detail.search')
        @include('admin.masterdata.bank-detail.create')
        @include('admin.masterdata.bank-detail.edit')

        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                <h4>Banks::</h4>
                @can('create bank')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#banks-add-modal"><button type="button" class="btn btn-primary b-btn"
                                id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    @endcan </div>
                <table id="bank-table" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>State</th>
                            <th>IFSC Code</th>
                            <th>Branch Name</th>
                            <th>Bank Name</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <form id="deleteForm" action="{{ route('admin.banks.delete') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="bank_code" id="primary_code_input">
    </form>

@endsection


@section('footer')


@endsection
