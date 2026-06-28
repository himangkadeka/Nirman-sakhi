<div class="modal fade" id="user-edit-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">Edit User Details</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                    data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="usr-msg"></div>
                <form id="user-edit-form" action="{{ route('admin.users.update') }}" method="post"
                    class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf
                    <div class="form-group w-100">
                        <input type="hidden" id="user_id" name="id">
                        <label for="office-name">Username<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control" id="user-name-edit" name="user_name"
                            placeholder="Enter User Name" value="{{ old('username') }}" required>
                    </div>

                    <div class="form-group w-100 d-flex">
                        <div class="form-group w-50 mr-2 ">
                            <label for="first-name">Firstname<span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control" id="first-name-edit" name="firstname"
                                placeholder="Enter Firstname" value="{{ old('firstname') }}" required>
                        </div>
                        <div class="form-group w-50">
                            <label for="last-name">Lastname<span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control" id="last-name-edit" name="lastname"
                                placeholder="Enter Lastname" value="{{ old('lastname') }}" required>
                        </div>
                    </div>
                    <div class="form-group w-100">
                        <label for="phone">Phone No<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control" id="phone-edit" name="phone" maxlength="10"
                            placeholder="Enter 10 digit Phone Number" value="{{ old('phone') }}" required>
                    </div>
                    <div class="form-group w-100">
                        <label for="email">Email<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control" id="email-edit" name="email"
                            placeholder="Enter Email" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group w-100">
                        <label for="desig">Select Designation<span class="text-danger">*</span></label>
                        <select class="form-control" id="designation_id" name="designation" required>
                            <option value="">--Select Designation--</option>
                            @foreach ($designations as $designation)
                                <option value="{{ $designation->id }}">{{ $designation->designation }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group w-100">
                        <label for="desig">Select District<span class="text-danger">*</span></label>
                        <select class="form-control" id="district_code_edit" name="district" required>
                            <option value="">--Select District-- </option>
                            @foreach ($dists as $district)
                                <option value="{{ $district->district_code }}">
                                    {{ $district->district_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group w-100">
                        <label for="desig">Select Office<span class="text-danger">*</span></label>
                        <select name="office_id" class="form-control" id="office_id_edit">
                            <option value="">
                                {{ trans('worker-registration/worker_new_registration.select_office') }}
                            </option>
                        </select>
                    </div>

                    <div class="form-group w-100">
                        <label for="role-name">Select Role<span class="text-danger">*</span></label>
                        <select class="form-control" id="role-name-edit" name="role_name" required>
                            <option value="">--Select Role--</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Is Incharge? <span class="text-danger">*</span></label>
                        <select class="form-control"
                                id="is-incharge-edit"
                                name="is_incharge"
                                required>
                            <option value="">--Select--</option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" class="btn btn-primary b-btn">UPDATE</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


