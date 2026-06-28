<!-- resources/views/admin/content-management/index-notification/edit.blade.php -->
<div class="modal fade" id="indexnotification-edit-modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Notification</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="notification_id" id="notification_id">
                    <div class="form-group">
                        <label for="caption">Caption</label>
                        <input type="text" name="caption" id="caption" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="pdf">Upload New PDF</label>
                        <input type="file" name="pdf" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
