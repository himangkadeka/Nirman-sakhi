<div class="modal fade" id="amount-edit-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                {{-- <h4 class="modal-title">EDIT AMOUNT DESCRIPTION</h4> --}}
                <h4 class="text-light">EDIT AMOUNT DETAILS</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="role-msg"></div>
                <form id="amount-edit-form" action="{{Route('admin.amounts.update')}}" method="POST" class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf
                    <div class="form-group w-100">
                        <input type="hidden" id="amount_id" name="id">
                        <label for="amount_description">Amount Description<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="amount_description_edit" name="amount_description" placeholder="Enter Amount Description" value="{{ old('amount_description') }}" required>
                    </div>

                    <div class="form-group w-100">
                        <label for="amount">Amount <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="amount_edit" name="amount" placeholder="Enter Amount Description" value="{{ old('amount') }}" required>
                    </div>
                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" class="btn btn-primary b-btn">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
