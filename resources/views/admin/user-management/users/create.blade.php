<div class="modal fade" id="user-add-modal">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">ADD USER</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                        data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <div id="usr-msg"></div>
                <form id="user-add-form" action="{{ route('admin.users.store') }}" method="post"
                      class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf
                    <div class="form-group w-100">
                        <label for="office-name">Username<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control" id="user-name" name="user_name"
                               placeholder="Enter User Name" value="{{ old('username') }}" required>
                    </div>
                    <div class="form-group w-100 d-flex">
                        <div class="form-group w-50 mr-2">
                            <label for="pwd">Password<span class="text-danger">*</span>:</label>
                            <input type="password" class="form-control" id="pwd" name="password"
                                   placeholder="Enter Password" value="{{ old('password') }}" required autocomplete="off">
                            <span id="password-policy" class="text-danger"></span>
                        </div>
                        <div class="form-group w-50">
                            <label for="confpwd">Confirm Password<span class="text-danger">*</span>:</label>
                            <input type="password" class="form-control" id="confpwd" name="password_confirmation"
                                   placeholder="Confirm Password" value="{{ old('password_confirmation') }}" required autocomplete="off">
                            <span id="conf-msg" class="text-danger"></span>
                        </div>


                    </div>
                    <div class="form-group w-100 d-flex">
                        <div class="form-group w-50 mr-2 ">
                            <label for="first-name">Firstname<span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control" id="first-name" name="firstname"
                                   placeholder="Enter Firstname" value="{{ old('firstname') }}" required>
                        </div>
                        <div class="form-group w-50">
                            <label for="last-name">Lastname<span class="text-danger">*</span>:</label>
                            <input type="text" class="form-control" id="last-name" name="lastname"
                                   placeholder="Enter Lastname" value="{{ old('lastname') }}" required>
                        </div>
                    </div>
                    <div class="form-group w-100">
                        <label for="phone">Phone No<span class="text-danger">*</span>:</label>
                        <input maxlength="10" type="text" class="form-control" id="phone" name="phone"
                               placeholder="Enter 10 digit Phone Number" value="{{ old('phone') }}" required>
                    </div>
                    <div class="form-group w-100">
                        <label for="email">Email<span class="text-danger">*</span>:</label>
                        <input type="text" class="form-control" id="email" name="email"
                               placeholder="Enter Email" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group w-100">
                        <label for="desig">Select Designation<span class="text-danger">*</span></label>
                        <select class="form-control" id="desig" name="designation" required>
                            <option value="">--Select Designation--</option>
                            @foreach ($designations as $designation)
                                <option value="{{ $designation->id }}">{{ $designation->designation }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group w-100">
                        <label for="desig">Select District<span class="text-danger">*</span></label>
                        <select name="district"
                                class="form-control custom-bottom-border  @if ($errors->has('district')) is-invalid @endif"
                                id="district_code">
                            <option value="">--Select District-- </option>
                            @foreach ($dists as $district)
                                <option value="{{ $district->district_code }}">
                                    {{ $district->district_name }}
                                </option>
                            @endforeach
                        </select>
                        <p class="error text-danger" id="districtError"></p>
                        @if ($errors->has('district'))
                            <span class="text-warning font-weight-normal">{{ $errors->first('district') }}</span>
                        @endif

                    </div>
                    <div class="form-group w-100">
                        <label for="desig">Select Office<span class="text-danger">*</span></label>
                        <select name="office_id"
                                class="form-control custom-bottom-border  @if ($errors->has('office_id')) is-invalid @endif"
                                id="office_id">
                            <option value="">--Select Office-- </option>
                        </select>
                        <p class="error text-danger" id="office_idError"></p>
                        @if ($errors->has('office_id'))
                            <span class="text-warning font-weight-normal">{{ $errors->first('office_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group w-100">
                        <label for="role-name">Select Role<span class="text-danger">*</span></label>
                        <select class="form-control" id="role-name" name="role_name" required>
                            <option value="">--Select Role--</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" class="btn btn-primary b-btn">ADD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('pwd');
        const confirmPasswordInput = document.getElementById('confpwd');
        const passwordPolicy = document.getElementById('password-policy');
        const confirmPasswordMsg = document.getElementById('conf-msg');

        passwordInput.addEventListener('input', function() {
            validatePassword();
        });

        confirmPasswordInput.addEventListener('input', function() {
            validatePassword();
        });

        function validatePassword() {
            const password = passwordInput.value;
            const passwordConfirmation = confirmPasswordInput.value;

            // AJAX call to the Laravel backend
            fetch("{{ route('admin.users.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    password: password,
                    password_confirmation: passwordConfirmation
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.results.password) {
                        if (data.results.password) {
                            passwordPolicy.innerHTML =
                                `<span class="text-danger">${data.results.password.join('<br>')}</span>`;
                        }
                        if (data.results.password_confirmation) {
                            confirmPasswordMsg.innerHTML =
                                `<span class="text-danger">${data.results.password_confirmation.join('<br>')}</span>`;
                        }
                    } else {
                        passwordPolicy.innerHTML =
                            '<span class="text-success">Password meets all requirements</span>';
                        confirmPasswordMsg.innerHTML = '';
                    }
                });
        }
    });
</script>