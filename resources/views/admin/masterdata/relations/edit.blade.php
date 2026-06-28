<div class="modal fade" id="gender-edit-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">EDIT GENDER</h4>
                <button type="button" class="close position-absolute"
                    style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.relation.update') }}" method="POST">
                    @csrf

                    {{-- Holds the relation_code to identify which row to update --}}
                    <input type="hidden" id="edit_relation_code" name="relation_code">

                    <div class="form-group w-100">
                        <label for="edit_gender">Gender</label>
                        <select class="form-control" id="edit_gender" name="gender">
                            <option value="">-- Select Gender --</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" class="btn btn-primary b-btn">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
