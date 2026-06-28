<div class="modal fade" id="marital-status-add-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">ADD MARITAL STATUS</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="role-msg"></div>
                <form id="marital-status-add-form" action="{{Route('admin.marital-statuses.store')}}" method="POST" class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf
                    <div class="form-group w-100">
                        <label for="marital_status_name">Marital Status Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="marital_status_name" name="marital_status_name" placeholder="Enter Marital Status Name" value="{{ old('marital_status_name') }}" required>
                    </div>
                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" class="btn btn-primary b-btn">ADD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
