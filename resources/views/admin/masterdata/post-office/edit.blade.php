<div class="modal fade" id="post-office-edit-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">EDIT POST OFFICE</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="edit-post-office" action="{{route('admin.post-offices.update')}}" method="post" class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf
                    <div class="form-group w-100">
                        <input type="hidden" id="edit-post-office-id" name="id">
                        <label for="po-state">State<span style="color: red;">*</span>: </label>
                        <input type="text" class="form-control" id="post-office-state-edit" name="edit_state_name" value="" disabled>

                    </div>
                    <div class="form-group w-100">
                        <label for="po-district">District<span style="color: red;">*</span></label>

                        <input type="text" class="form-control" id="post-office-district-edit" name="edit-district_name" disabled>

                    </div>
                    <div class="form-group w-100">
                        <label for="po-name">Postoffice Name<span style="color: red;">*</span>:</label>
                        <input type="text" class="form-control" id="edit-post-office-name" name="post_office_name" placeholder="Enter Post Office Name" value="{{ old('postofficename') }}" required>
                    </div>
                    <div class="form-group w-100">
                        <label for="pincode">Pincode<span style="color: red;">*</span>:</label>
                        <input type="text" class="form-control" id="edit_pin_code" name="pin_code" placeholder="Enter Pincode" value="{{ old('pincode') }}" required>
                    </div>
                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" id="poaddbutt" class="btn btn-primary b-btn">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
