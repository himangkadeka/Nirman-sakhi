<!-- Edit Reason Modal -->
<div class="modal fade" id="reason-edit-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">EDIT REASON</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="role-msg"></div>
                <form id="reason-edit-form" action="{{ route('admin.reasons.update') }}" method="POST" class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf
                    <input type="hidden" id="reason_id" name="id">

                    <div class="form-group w-100">
                        <label for="reason_type_edit">Reason Type<span class="text-danger">*</span></label>
                        <select class="form-control" id="reason_type_edit" name="type" required>
                            <option value="">-- Select Type --</option>
                            <option value="Revert">Revert</option>
                            <option value="Reject">Reject</option>
                        </select>
                    </div>

                    <div class="form-group w-100">
                        <label for="reason_category_edit">Reason Category<span class="text-danger">*</span></label>
                        <select class="form-control" id="reason_category_edit" name="category" required>
                            <option value="">-- Select Category --</option>
                            <option value="New Registration">New Registration</option>
                            <option value="Onboarding">Onboarding</option>
                            <option value="Renewal">Renewal</option>
                        </select>
                    </div>

                    <div class="form-group w-100">
                        <label for="reason_text_edit">Reason<span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reason_text_edit" name="reason" rows="3" maxlength="2000" placeholder="Enter Reason" required></textarea>
                    </div>

                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" class="btn btn-primary b-btn">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
