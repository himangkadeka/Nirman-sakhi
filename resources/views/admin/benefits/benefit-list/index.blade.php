@extends('layouts.admin-app')


@section('title', 'Admin | Benefits')
@section('breadcrumb_item_1', 'Benefits')
@section('breadcrumb_item_2', 'Benefit List')
@yield('style')

<style>
    /* Modern admin look for Benefits list (CSS only) */
    :root {
        --bg: #f4f7fb;
        --card: #ffffff;
        --glass: rgba(15, 23, 42, 0.04);
        --accent1: #667eea;
        --accent2: #764ba2;
        --muted: #6b7280;
        --success: #10b981;
        --danger: #ef4444;
    }

    .b-latest-data {
        font-size: 1.25rem;
        font-weight: 700;
        color: #0f1724;
        display: inline-block;
        margin-bottom: 12px;
        letter-spacing: 0.2px;
    }

    .add-butt {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 12px;
    }

    .b-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: linear-gradient(135deg, var(--accent1), var(--accent2));
        border: none;
        color: #fff;
        padding: 10px 14px;
        border-radius: 10px;
        font-weight: 700;
        box-shadow: 0 10px 30px rgba(102, 126, 234, 0.12);
        transition: transform .15s ease, box-shadow .15s ease;
    }

    .b-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 18px 36px rgba(102, 126, 234, 0.18);
    }

    /* Table container card */
    .table-responsive {
        background: var(--card);
        border-radius: 12px;
        padding: 12px;
        box-shadow: 0 8px 30px var(--glass);
        border: 1px solid rgba(99, 102, 241, 0.04);
    }

    /* DataTable styling */
    #abaocTable {
        width: 100% !important;
        border-collapse: separate;
        border-spacing: 0;
        overflow: visible;
    }

    #abaocTable thead th {
        background: #545454;
        color: #fff;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 13px;
        border: none !important;
        vertical-align: middle;
    }

    #abaocTable tbody tr {
        transition: transform .12s ease, background-color .12s ease;
        background: transparent;
    }

    #abaocTable tbody tr:hover {
        transform: translateY(-4px);
        background: linear-gradient(90deg, rgb(169 185 255 / 3%), rgb(206 159 255 / 0%));
    }

    #abaocTable tbody td {
        padding: 10px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
        color: #374151;
        font-size: 14px;
        background: transparent;
    }

    /* Description HTML from summernote should flow and stay readable */
    #abaocTable tbody td p,
    #abaocTable tbody td div {
        margin: 0;
        color: #475569;
        line-height: 1.45;
    }
    #abaocTable ul{padding-left:2px; margin-left: 5px;}
    #abaocTable ul li{margin-bottom:5px;}
    #abaocTable p u{color:#008fff;text-decoration: none;}
    #abaocTable b u{color:#008fff;text-decoration: none;}

    /* Badges */
    .badge {
        font-weight: 700;
        border-radius: 999px;
        padding: 6px 10px;
        font-size: 0.85rem;
    }

    .badge-success {
        background: rgba(16, 185, 129, 0.12);
        color: var(--success);
        border: 1px solid rgba(16, 185, 129, 0.14);
    }

    .badge-danger {
        background: rgba(239, 68, 68, 0.08);
        color: var(--danger);
        border: 1px solid rgba(239, 68, 68, 0.12);
    }

    /* Action icons */
    #abaocTable td a i,
    #abaocTable td button i {
        font-size: 1.05rem;
        transition: transform .12s ease, color .12s ease;
        color: #12d3d0;
    }

    #abaocTable td a i:hover,
    #abaocTable td button i:hover {
        transform: translateY(-3px) scale(1.05);
        color: #0ea5a4;
    }

    /* Buttons inside table */
    #abaocTable td button {
        background: transparent;
        border: none;
        padding: 0;
        cursor: pointer;
    }

    /* Responsive tweaks */
    @media (max-width: 991.98px) {
        .add-butt {
            justify-content: center;
        }

        .b-btn {
            width: 100%;
            justify-content: center;
        }

        #abaocTable thead th {
            font-size: 12px;
            padding: 10px;
        }

        #abaocTable tbody td {
            padding: 10px;
            font-size: 13px;
        }
    }

    @media (max-width: 575.98px) {
        .b-latest-data {
            font-size: 1.05rem;
        }

        .table-responsive {
            padding: 8px;
        }

        #abaocTable tbody td {
            font-size: 13px;
        }
    }

    /* Summernote toolbar subtle polish (keeps existing selectors) */
    .note-editor .note-toolbar {
        background-color: #f8fafc;
        border-bottom: 1px solid #eef2ff;
        border-radius: 8px 8px 0 0;
        padding: 6px;
    }

    .note-editor .note-editable {
        background: #ffffff;
        min-height: 160px;
        border-radius: 0 0 8px 8px;
        padding: 12px;
    }
    .addbenefits{display: flex;justify-content: center;gap:25px;align-items: center;}
    .addbenefits img{width:55px;transition: 0.3s linear;position: relative;}
    .addbenefits img:hover{transform: scale(1.4)}

    div.dataTables_wrapper {
    margin-bottom:25px;
    padding: 20px 12px;
    border-radius: 20px;
    box-shadow: 0px 0px 5px #ccc;
}
.dt-top-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
div.dataTables_wrapper div.dataTables_length label{
    box-shadow: 0px 0px 4px #cccccc87;
    padding: 5px 10px;
    border-radius: 50px;
    outline: 1px solid #cccccc6e;
}
</style>
<link rel="stylesheet" href="{{ asset('assets/summernote/summernote-lite.min.css') }}">
@section('content')

    <div class="container-fluid">

        @include('admin.benefits.benefit-list.create')
        @include('admin.benefits.benefit-list.edit')
        <div class="row">
            <div class="table-responsive shadow-none mb-2">
                {{-- @can('create age proof') --}}
                <div class="add-butt p-3 addbenefits">
                    {{-- <a href="javascript:void(0);" data-toggle="modal"
                        data-target="#benefit-list-add-modal"><button type="button" class="btn btn-primary b-btn"
                            id="addpo">ADD<i class="fa fa-plus pl-2" aria-hidden="true"></i></button></a> --}}
                        <a href="javascript:void(0);" onclick="openCreateModal()">
                        <button type="button" class="btn btn-primary b-btn" id="addpo">
                            ADD BENEFITS <i class="fa fa-plus pl-2" aria-hidden="true"></i>
                        </button>
                        </a>
                        <img src="{{ asset('assets/template/images/addbenefit.png') }}" alt="add benifits">

                </div>
                {{-- @endcan --}}
                <table id="abaocTable" class="table table-bordered display mt-4">
                    <thead class="">
                        <tr>
                            <th>Sno.</th>
                            <th>Benefit Code</th>
                            <th>Benefit/Scheme Name</th>
                            <th>Description</th>
                            <th>Can Apply By</th>
                            <th>Maximum Application per worker</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($benefits as $benefit)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $benefit->benefit_code }}</td>
                                <td>{{ $benefit->name }}</td>
                                <td>{!! $benefit->description !!}</td>
                                <td>{{ $benefit->role_names_string }}</td>
                                <td>{{ $benefit->maximum_applications_per_worker }}</td>
                                <td>
                                    @if ($benefit->status == true)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $benefit->created_at }}</td>
                                <td style="padding: 0px">
                                    <span class="d-flex">
                                        {{-- <a
                                            href="{{ route('admin.benefit-form.index', base64_encode(encrypt($benefit->id))) }}"><i
                                                class="fas fa-pencil" style="color: #12d3d0; "></i></a> --}}
                                        @can('update age proof')
                                            <button data-toggle="modal" data-target="#benefit-list-edit-modal"
                                                aria-hidden="true"
                                                onclick="benefitListEditModal('{{ $benefit->id }}','{{ $benefit->name }}','{{ $benefit->description }}', '{{ $benefit->category_id }}')"
                                                style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <i class="fas fa-edit" style="color: #12d3d0;padding-left:5px;"></i>
                                            </button>

                                            <a href="javascript:void(0);"
                                                onclick="confirmBenefitUpdate('{{ $benefit->id }}', '{{ $benefit->status }}')"
                                                style="text-decoration: none; color: '{{ $benefit->status == 1 ? '#28a745' : '#ee1b1b' }}'">
                                                <i class="fas fa-toggle-{{ $benefit->status == 1 ? 'on' : 'off' }}"
                                                    style="color: '{{ $benefit->status == 1 ? '#28a745' : '#ee1b1b' }}'; padding-left:5px;"></i>
                                            </a>
                                        @endcan
                                        @can('delete age proof')
                                            <button onclick="confirmDelete('{{ $benefit->id }}','Benefit/Scheme')"
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

    <form id="deleteForm" action="{{ route('admin.benefit-list.delete') }}" method="POST" style="display: none;"
        class="delete-form">
        @csrf
        <input type="hidden" name="benefit_code" id="primary_code_input">
    </form>

    <form id="updateBenefitForm" action="{{ route('admin.benefit-list.status') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="id" id="benefit_id_input">
        <input type="hidden" name="status" id="status_input">
    </form>





@endsection
@section('footer')

    <script>
        window.addEventListener('load', function() {
            var script = document.createElement('script');
            script.src = "{{ asset('assets/summernote/summernote-lite.min.js') }}";
            script.onload = function() {

                // ✅ Edit modal - existing
                $('#benefit-list-edit-modal').on('shown.bs.modal', function() {
                    if (!$('#benefit_description_edit').next().hasClass('note-editor')) {
                        $('#benefit_description_edit').summernote({
                            height: 200,
                            placeholder: 'Enter Description'
                        });
                    }
                });

                // ✅ Create modal - ADD THIS
                $('#benefit-list-add-modal').on('shown.bs.modal', function() {
                    if (!$('#description').next().hasClass('note-editor')) {
                        $('#description').summernote({
                            height: 200,
                            placeholder: 'Enter Description'
                        });
                    }
                });
            };
            document.body.appendChild(script);
        });

        function benefitListEditModal(id, name, description, category_id) {
            $('#benefit_id').val(id);
            $('#benefit_name_edit').val(name);
            $('#benefit_category_edit').val(category_id);

            if ($('#benefit_description_edit').next().hasClass('note-editor')) {
                $('#benefit_description_edit').summernote('destroy');
            }

            $('#benefit-list-edit-modal').modal('show');

            $('#benefit-list-edit-modal').one('shown.bs.modal', function() {
                $('#benefit_description_edit').summernote('code', description || '');
            });
        }
    </script>
    <script>
        function openCreateModal() {
            $('#benefit-list-add-modal').modal('show');

            $('#benefit-list-add-modal').one('shown.bs.modal', function() {
                if (!$('#description').next().hasClass('note-editor')) {
                    $('#description').summernote({
                        height: 200,
                        placeholder: 'Enter Description'
                    });
                }

                var oldValue = $('#description').val();
                if (oldValue) {
                    $('#description').summernote('code', oldValue);
                }
            });
        }
    </script>
@endsection
