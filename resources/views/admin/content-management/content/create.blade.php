<div class="modal fade" id="content-add-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">ADD CONTENT</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="role-msg"></div>
                <form id="gallery-category-add-form" action="{{Route('admin.contents.store')}}" method="POST" class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf
                    <div class="form-group w-100">
                        <label for="title">Title<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="{{ old('title') }}" required>
                    </div>
                    <div class="form-group w-100">
                        <label for="description">Description<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Enter Description" value="{{ old('description') }}" required>
                    </div>


                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" class="btn btn-primary b-btn">ADD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
