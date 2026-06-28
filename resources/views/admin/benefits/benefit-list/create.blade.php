<div class="modal fade" id="benefit-list-add-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">Add Benefit / Scheme</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;"
                    data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div id="role-msg"></div>
                <form id="benfit-list-add-form" action="{{ Route('admin.benefit-list.store') }}" method="POST"
                    class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf
                    <div class="form-group w-100">
                        <label for="benefit_name">Benefit/Scheme Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="benefit_name" name="benefit_name"
                            placeholder="Enter benefit/scheme Name" value="{{ old('benefit_name') }}" required>
                    </div>
                    <div class="form-group w-100">
                        <label for="benefit_code">Benefit/Scheme Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="benefit_code" name="benefit_code"
                            placeholder="Enter benefit/scheme Code" value="{{ old('benefit_code') }}" required>
                    </div>
                    <div class="form-group w-100">
                        <label>Who Can Apply <span class="text-danger">*</span></label>
                        <div class="mt-2">
                            @isset($roles)
                                @foreach ($roles as $role)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="role_ids[]"
                                            id="role_{{ $role->id }}" value="{{ $role->id }}">
                                        <label class="form-check-label"
                                            for="role_{{ $role->id }}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-danger">No roles found. Ensure $roles are passed to the view.</p>
                            @endisset
                        </div>
                    </div>
                    <div class="form-group w-100">
                        <label for="description">Description</label>
                        <textarea class="form-control" name="description" id="description" placeholder="Enter Description" cols="30"
                            rows="5">{{ old('description') }}</textarea>
                    </div>

                    {{-- ✅ Category Dropdown --}}
                    <div class="form-group w-100">
                        <label for="category">Category <span class="text-danger">*</span></label>
                        <select class="form-control" id="category" name="category" required>
                            <option value="" disabled selected>-- Select Category --</option>
                            <option value="1" {{ old('category') == 1 ? 'selected' : '' }}>Education</option>
                            <option value="2" {{ old('category') == 2 ? 'selected' : '' }}>Marriage</option>
                            <option value="3" {{ old('category') == 3 ? 'selected' : '' }}>Medical</option>
                            <option value="4" {{ old('category') == 4 ? 'selected' : '' }}>Others</option>
                        </select>
                    </div>
                    {{-- ✅ End Category Dropdown --}}

                    <!-- New Dropdown Field -->
                    <div class="form-group w-100">
                        <label for="maximum_applications_per_worker">Maximum Applications Per Worker <span class="text-danger">*</span></label>
                        <select class="form-control" id="maximum_applications_per_worker" name="maximum_applications_per_worker" required>
                            <option value="" disabled selected>Select a limit</option>
                            @for ($i = 0; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('maximum_applications_per_worker') == $i ? 'selected' : '' }}>
                                    {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <!-- End New Dropdown Field -->

                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" class="btn btn-primary b-btn">ADD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
