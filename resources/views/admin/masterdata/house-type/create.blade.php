<div class="modal fade" id="house-type-add-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">ADD HOUSE TYPE</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="role-msg"></div>
                <form id="house-type-add-form" action="{{Route('admin.house-types.store')}}" method="POST" class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf
                    <div class="form-group w-100">
                        <label for="house_type_name">House Type Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="house_type_name" name="house_type_name" placeholder="Enter House Type Name" value="{{ old('house_type_name') }}" required>
                    </div>
                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" class="btn btn-primary b-btn">ADD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
