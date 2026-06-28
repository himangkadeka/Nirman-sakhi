<div class="modal fade" id="gallery-category-edit-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">EDIT GALLERY CATEGORY DESCRIPTION</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="role-msg"></div>
                <form id="gallery-category-edit-form" action="{{Route('admin.gallery-categories.update')}}" method="POST" class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf
                    <div class="form-group w-100">
                        <input type="hidden" id="gallery_category_id" name="id">
                        <label for="gallery_category_description">Gallery Category Description<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="gallery_category_name_edit" name="gallery_category_name" placeholder="Enter Gallery Category Description" value="{{ old('gallery_category_description') }}" required>
                    </div>
                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" class="btn btn-primary b-btn">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
