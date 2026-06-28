<div class="modal fade" id="reason-add-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">ADD REASON</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="reason-msg"></div>
                <form id="reason-add-form" action="{{ route('admin.reasons.store') }}" method="POST" class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf
                    <div class="form-group w-100">
                        <label for="type">Type<span class="text-danger">*</span></label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="">-- Select Type --</option>
                            <option value="Revert" {{ old('type') == 'Revert' ? 'selected' : '' }}>Revert</option>
                            <option value="Reject" {{ old('type') == 'Reject' ? 'selected' : '' }}>Reject</option>
                        </select>
                    </div>

                    <div class="form-group w-100">
                        <label for="category">Category<span class="text-danger">*</span></label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="">-- Select Category --</option>
                            <option value="New Registration" {{ old('category') == 'New Registration' ? 'selected' : '' }}>New Registration</option>
                            <option value="Onboarding" {{ old('category') == 'Onboarding' ? 'selected' : '' }}>Onboarding</option>
                            <option value="Renewal" {{ old('category') == 'Renewal' ? 'selected' : '' }}>Renewal</option>
                        </select>
                    </div>

                    <div class="form-group w-100">
                        <label for="reason">Reason<span class="text-danger">*</span></label>
                        <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Enter Reason" required>{{ old('reason') }}</textarea>
                    </div>

                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" class="btn btn-primary b-btn">ADD</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
