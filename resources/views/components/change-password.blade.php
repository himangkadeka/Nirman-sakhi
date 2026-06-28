@extends('layouts.admin-app')

@section('title', ucfirst('Change Password'))
@section('breadcrumb_item_1', 'Password')
@section('breadcrumb_item_2', 'Change Password')


@section('content')
    <div class="mx-5 mt-5">

        <form action="{{ route('password.update') }}" method="POST" class="w-sm-50 w-auto mx-auto needs-validation"
            novalidate>

            @csrf

            <div class="form-group w-50">

                <label for="state-code">Old Password: </label>

                <input type="password" class="form-control" id="state-code" name="old_password"
                    placeholder="Enter Old Password" onblur="encryptPassword(this.id)" value="{{ old('old_password') }}" required>

                <div class="invalid-feedback">

                    Please Enter a Valid Old Password.

                </div>

                @if ($errors->has('old_password'))
                    <span class="text-danger font-weight-bold">

                        {{ $errors->first('old_password') }}

                    </span>
                @endif

            </div>

            <div class="form-group w-50">

                <label for="state-name">New password:</label>

                <input type="password" class="form-control" id="new_password" name="new_password"
                    placeholder="Enter New Password" onblur="encryptPassword(this.id)" value="{{ old('new_password') }}" required>
                <span id="password-policy" class="text-danger"></span>

                <div class="invalid-feedback">

                    Please Enter a Valid New Password.

                </div>

                @if ($errors->has('new_password'))
                    <span class="invalid-feedback">{{ $errors->first('new_password') }}</span>
                @endif

            </div>
            <div class="form-group w-50">

                <label for="state-name">Confirm password:</label>

                <input type="password" class="form-control" id="confirm_password" name="confirm_password"
                    placeholder="Enter New Password" onblur="encryptPassword(this.id)" value="{{ old('confirm_password') }}" required>

                <span id="conf-msg" class="text-danger"></span>
                <div class="invalid-feedback">

                    Please Enter a Valid New Password.

                </div>
                @if ($errors->has('confirm_password'))
                    <span class="invalid-feedback">{{ $errors->first('confirm_password') }}</span>
                @endif

            </div>

            <div class="text-left py-4">

                <button type="submit" class="btn btn-primary b-btn">Update</button>

            </div>

        </form>

    </div>
@endsection


@section('footer')
<script src="{{ URL::asset('assets/encrypt/crypto-js.min.js') }}"></script>
<script src="{{ URL::asset('assets/encrypt/Encryption.js') }}"></script>

    <script type="text/javascript">
        function encryptPassword(fieldId) {
        var password = document.getElementById(fieldId).value;
        var nonceValue = 'nonce_value'; // Replace with your actual nonce value

        let encryption = new Encryption();
        var passwordEncrypted = encryption.encrypt(password, nonceValue);

        // Update the value of the current password field with the encrypted value
        document.getElementById(fieldId).value = passwordEncrypted;
    }
    </script>


    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('new_password');
        const confirmPasswordInput = document.getElementById('confirm_password');
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
            fetch("{{route('password.update')}}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    password: password,
                    password_confirmation: passwordConfirmation
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.results.password) {
                    if (data.results.password) {
                        passwordPolicy.innerHTML = `<span class="text-danger">${data.results.new_password.join('<br>')}</span>`;
                    }
                    if (data.results.password_confirmation) {
                        confirmPasswordMsg.innerHTML = `<span class="text-danger">${data.results.confirm_password.join('<br>')}</span>`;
                    }
                } else {
                    passwordPolicy.innerHTML = '<span class="text-success">Password meets all requirements</span>';
                    confirmPasswordMsg.innerHTML = '';
                }
            });
        }
    });

    </script>
@endsection
