@extends('layouts.admin-app')

@section('title', 'Admin | Ration Types')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Ration Types')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data px-5">REASONS</h4>
        @include('admin.masterdata.reasons.create')
        @include('admin.masterdata.reasons.edit')
        <div class="row">
            <div class="col-md-12 table-responsive px-5">
                @can('create reasons')
                    <div class="add-butt p-3"><a href="javascript:void(0);" data-toggle="modal"
                            data-target="#reason-add-modal"><button type="button" class="btn btn-primary b-btn"
                                id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a>
                    </div>
                @endcan
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>Reason Type</th>
                            <th>Reason Category</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reasons as $reason)
                            <tr>
                                <td>{{ $reason->id }}</td>
                                <td>{{ $reason->type }}</td>
                                <td>{{ $reason->category }}</td>
                                <td>{{ $reason->reason }}</td>
                                <td>
                                    @if ($reason->status == '1')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Deactived</span>
                                    @endif
                                </td>
                                <td>
                                    <span>
                                        @can('update reasons')
                                            <button data-toggle="modal" data-target="#reason-edit-modal"
                                                onclick="editReasonModal('{{ $reason->id }}', '{{ $reason->type }}', '{{ $reason->category }}', '{{ $reason->reason }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                            </button>
                                        @endcan
                                        @can('delete reasons')
                                            <button onclick="confirmDelete('{{ $reason->id }}','Reason')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-solid fa-trash" style="color: #ee1b1b; padding-left:5px;"></i>
                                            </button>
                                        @endcan
                                        <a href="javascript:void(0);"
                                            onclick="confirmReasonUpdate('{{ $reason->id }}', '{{ $reason->status }}')"
                                            style="text-decoration: none; color: '{{ $reason->status == 1 ? '#28a745' : '#ee1b1b' }}'">
                                            <i class="fas fa-toggle-{{ $reason->status == 1 ? 'on' : 'off' }}"
                                                Reasstyle="color: '{{ $reason->status == 1 ? '#28a745' : '#ee1b1b' }}'; padding-left:5px;"></i>
                                        </a>
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- Activation/ Deactivation -->
    <form id="updateReasonForm" action="{{ route('admin.reasons.status') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="id" id="reason_id_input">
        <input type="hidden" name="status" id="reason_status_input">
    </form>

    <form id="deleteForm" action="{{ route('admin.reasons.delete') }}" method="POST" style="display: none;"
        class="delete-form">
        @csrf
        <input type="hidden" name="id" id="primary_code_input">
    </form>

    <script>
        function editReasonModal(id, type, category, reasonText) {
            document.getElementById('reason_id').value = id;
            document.getElementById('reason_type_edit').value = type;
            document.getElementById('reason_category_edit').value = category;
            document.getElementById('reason_text_edit').value = reasonText;
            $('#reason-edit-modal').modal('show');
        }
    </script>
@endsection
