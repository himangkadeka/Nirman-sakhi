<div class="modal fade" id="nature-of-work-edit-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">EDIT NATURE OF WORK</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="role-msg"></div>
                <form id="nature-of-work-edit-form" action="{{Route('admin.nature-of-works.update')}}" method="POST" class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf
                    <div class="form-group w-100">
                        <input type="hidden" id="nature_of_work_id" name="nature_of_work_code">
                        <label for="nature_of_work">Nature Of Work Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nature_of_work_name_edit" name="nature_of_work_name" placeholder="Enter Nature Of Work Name" value="{{ old('nature_of_work') }}" required>
                    </div>
                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" class="btn btn-primary b-btn">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
