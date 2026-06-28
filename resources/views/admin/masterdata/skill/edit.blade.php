<div class="modal fade" id="skills-edit-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">EDIT SKILLS</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="role-msg"></div>
                <form id="skills-edit-form" action="{{Route('admin.skills.update')}}" method="POST" class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf

                       <input type="hidden" name="skill_code" id="skill_id">

                    <div class="form-group w-100">
                        <label for="skill_name">Skill Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="skill_name_edit" name="skill_name" placeholder="Enter Skill Name" value="{{ old('skill_name') }}" required>
                    </div>
                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" class="btn btn-primary b-btn">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
