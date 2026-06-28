<div class="modal fade" id="bank-edit-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">EDIT BANK</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="bank-edit-form" action="{{route('admin.banks.update')}}" method="post" class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf
                    <input type="hidden" name="id" id="bank_id">
                    <div class="form-group w-100">
                    <label for="po-name">State<span style="color: red;">*</span>:</label>
                        <input type="text" class="form-control" id="state-code-edit" name="state_code" placeholder="" value="{{ old('state') }}" required>
                    </div>
                    <div class="form-group w-100">
                        <label for="po-name">IFSC Code<span style="color: red;">*</span>:</label>
                        <input type="text" class="form-control" id="ifsc-code-edit" name="ifsc_code" placeholder="Enter IFSC Code" value="{{ old('ifsc_code') }}" required>
                    </div>

                    <div class="form-group w-100">
                        <label for="po-name">Branch Name<span style="color: red;">*</span>:</label>
                        <input type="text" class="form-control" id="branch-name-edit" name="branch_name" placeholder="Enter Branch Name" value="{{ old('branch_name') }}" required>
                    </div>
                    <div class="form-group w-100">
                        <label for="pincode">Bank Name<span style="color: red;">*</span>:</label>
                        <input type="text" class="form-control" id="bank-name-edit" name="bank_name" placeholder="Enter Bank Name" value="{{ old('bank_name') }}" required>
                    </div>
                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" id="poaddbutt" class="btn btn-primary b-btn">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
