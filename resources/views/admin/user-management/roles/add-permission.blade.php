@extends('layouts.admin-app')

@section('title', 'Admin | Roles | Permission')
@section('breadcrumb_item_1', 'User Management')
@section('breadcrumb_item_2', 'Roles / Permissions')

@section('content')
    <div class="container-fluid">

        <h4 class="text-left mb-3 b-latest-data">Add Permission</h4>

        <div class="card my-x">
            <div class="content">
                <div class="card-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                    <h4 class="text-light">ROLE NAME: {{ $role->name }}</h4>
                </div>

                <form action="{{ route('admin.roles.give-permission', $role->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-body my-5">
                        <!-- Select All Checkbox -->
                        <div class="mb-3">
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">
                                    Select All
                                </label>
                            </div>
                        </div>

                        <!-- Begin row for permissions -->
                        <div class="row text-gray-600 fw-semibold">
                            @foreach ($permissions as $permission)
                                <div class="col-md-3 mb-3">
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input permission-checkbox" type="checkbox" name="permission[]"
                                            value="{{ $permission->name }}"
                                            {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }} />
                                        <label class="form-check-label text-gray-800">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!-- End row for permissions -->

                        <button type="submit" class="btn btn-primary mt-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
{{-- @endsection

@section('scripts') --}}
    <script>
        document.getElementById('selectAll').addEventListener('change', function () {
            console.log('ssss');

            // Get the current state of the select-all checkbox
            var isChecked = this.checked;
            // Get all checkboxes with the class 'permission-checkbox'
            var checkboxes = document.querySelectorAll('.permission-checkbox');
            // Set the checked state of each checkbox to match the select-all checkbox
            checkboxes.forEach(function (checkbox) {
                checkbox.checked = isChecked;
            });
        });
    </script>
@endsection
