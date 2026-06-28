@extends('layouts.admin-app')

@section('title', 'Admin | Index Notification')
@section('breadcrumb_item_1', 'Master Data')
@section('breadcrumb_item_2', 'Pdf Uploads')

@section('content')

    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data">Pdf Uploads</h4>

        {{-- @include('admin.content-management.index-notification.edit') --}}
        <div class="row">
            <div class="col-md-12 table-responsive">
                <div class="add-butt p-3"><a href="{{ route('admin.index_notification.create') }}"><button type="button"
                            class="btn btn-primary b-btn" id="addpo">ADD<i class="fa fa-plus pl-2"
                                aria-hidden="true"></i></button></a>
                </div>
                <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                    <thead class="thead-dark">
                        <tr>
                            <th>Sno.</th>
                            <th>pdf preview</th>

                            <th>Caption</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($index_notification as $notification)
                            <tr>
                                <td>{{ $notification->id }}</td>
                                <td>
                                    <button class="btn btn-info btn-sm"
                                        onclick="openPdf('{{ asset($notification->pdf_path) }}')">
                                        <i class="fas fa-file-pdf"></i> View PDF
                                    </button>
                                </td>
                                {{-- <td>{{ $notification->pdf_path }}</td> --}}
                                <td>{{ $notification->caption }}</td>
                                <td>{{ $notification->created_at }}</td>
                                <td>
                                    {{-- <button data-toggle="modal"
                                        onclick="indexNotificationEditModal('{{ $notification->id }}', '{{ $notification->caption }}')">
                                        <i class="fas fa-edit" style="color: #12d3d0;"></i>
                                    </button> --}}
                                    <button type="button" class="btn btn-sm btn-warning"
                                        onclick="indexNotificationEditModal('{{ $notification->id }}', '{{ $notification->caption }}')">
                                        <i class="fas fa-edit"></i>
                                    </button>


                                    <button
                                        onclick="confirmDelete('{{ $notification->id }}','IndexNotification index_notification')"
                                        style="border: none; background: none; padding: 0; cursor: pointer;">
                                        <i class="fas fa-solid fa-trash" style="color: #ee1b1b; padding-left:5px;"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>

                </table>
            </div>
        </div>
    </div>




    <form id="deleteForm" action="{{ route('admin.index_notification.delete') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="index_notification_id" id="primary_code_input">
    </form>
    @include('admin.content-management.index-notification.edit')


@endsection
@section('footer')

    <script>
        function indexNotificationEditModal(id, caption) {
            var modal = document.getElementById('indexnotification-edit-modal');
            var bootstrapModal = new bootstrap.Modal(modal);

            document.getElementById("notification_id").value = id;
            document.getElementById("caption").value = caption;
            document.getElementById("editForm").action = "{{ route('admin.index_notification.update', '') }}/" + id;

            bootstrapModal.show();
        }
    </script>
    <script>
        $(document).on("click", ".edit-notification-btn", function() {
            let id = $(this).data("id");

            // Fetch notification data using AJAX (if needed)
            $.ajax({
                url: "/index_notification/edit/" + id, // Ensure this route exists
                type: "GET",
                success: function(response) {
                    $("#notification_id").val(response.id);
                    $("#caption").val(response.caption);
                    $("#indexnotification-edit-modal").modal("show");
                },
                error: function() {
                    alert("Something went wrong. Please try again.");
                },
            });
        });
    </script>

    <script>
        function openPdf(pdfUrl) {
            window.open(pdfUrl, '_blank');
        }
    </script>



@endsection
