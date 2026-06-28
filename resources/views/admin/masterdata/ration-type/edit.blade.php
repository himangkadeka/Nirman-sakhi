<div class="modal fade" id="ration-type-edit-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">EDIT RATION TYPE</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="role-msg"></div>
                <form id="ration-type-edit-form" action="{{Route('admin.ration-types.update')}}" method="POST" class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf
                    <div class="form-group w-100">
                        <input type="hidden" id="ration_type_id" name="id">
                        <label for="ration_type">Ration Type<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="ration_type_edit" name="ration_type" placeholder="Enter Ration Type" value="{{ old('ration_type') }}" required>
                    </div>

                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" class="btn btn-primary b-btn">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
