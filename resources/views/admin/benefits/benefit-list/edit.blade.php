<div class="modal fade" id="benefit-list-edit-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">EDIT BENEFIT/SCHEME</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                    data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="role-msg"></div>
                <form id="benefit-list-edit-form" action="{{ Route('admin.benefit-list.update') }}" method="POST"
                    class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf
                    <div class="form-group w-100">
                        <input type="hidden" id="benefit_id" name="benefit_id">
                        <label for="benefit_name">Benegfit/Scheme Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="benefit_name_edit" name="benefit_name"
                            placeholder="Enter Benefit Name" value="{{ old('benefit_name') }}" required>
                    </div>
                    <div class="form-group w-100">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="benefit_description_edit" placeholder="Enter Description"
                            cols="30" rows="5"></textarea>
                    </div>

                    {{-- ............................................... --}}

                    <div class="form-group w-100">
                        <label for="benefit_category_edit">Category <span class="text-danger">*</span></label>
                        <select class="form-control" id="benefit_category_edit" name="category" required>
                            <option value="" disabled selected>-- Select Category --</option>
                            <option value="1">Education</option>
                            <option value="2">Marriage</option>
                            <option value="3">Medical</option>
                            <option value="4">Others</option>
                        </select>
                    </div>

                    {{-- ............................................... --}}

                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" class="btn btn-primary b-btn">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- <script src="{{ asset('asset/vendor/template/jquery/jquery.min.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/summernote/summernote-lite.min.css') }}">
<script src="{{ asset('assets/summernote/summernote-lite.min.js') }}"></script>
<script>
    $(document).ready(function () {
    $('#benefit_description_edit').summernote({
        height: 200,
        placeholder: 'Enter Description'
    });
});
</script> --}}
