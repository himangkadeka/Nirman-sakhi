<div class="modal fade" id="sub-district-add-modal">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">

                <h4 class="text-light">ADD SUB DISTRICT</h4>

                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>

            </div>

            <div class="modal-body">

                <form action="{{route('admin.sub-districts.store')}}" id="add-sub-district-form" method="POST" class="w-sm-100 w-auto mx-auto needs-validation master-data-form" novalidate>

                    @csrf

                    <div class="form-group">

                        <label for="state">Select State<span style="color: red;">*</span>: </label>

                        <select class="form-control state_code_select" id="state_code_select" name="state_code"  required>

                            <option value="">--Select State--</option>

                            @foreach($states as $state)

                            <option value="{{$state->state_code}}">{{$state->state_name}}</option>

                            @endforeach

                        </select>

                        <div class="invalid-feedback" id="state_name_error">

                            Please Select a Valid State Name.

                        </div>

                        @if ($errors->has('state_name'))

                        <span class="text-danger font-weight-bold">

                            {{ $errors->first('state_name') }}

                        </span>

                        @endif

                    </div>

                    <div class="form-group w-100">

                        <label for="po-district">Select District<span style="color: red;">*</span></label>

                        <select class="form-control district_codes" id="district_id" name="district_code" required>

                            <option value="">--Select District--</option>

                        </select>

                        <div class="invalid-feedback">

                            Please Enter a Valid District Code.

                        </div>

                        @if ($errors->has('district_code'))

                        <span class="invalid-feedback">{{ $errors->first('district_code') }}</span>

                        @endif

                    </div>

                    <div class="form-group w-100">

                        <label for="edit-district-code">Sub District Code<span style="color: red;">*</span>:</label>

                        <input type="text" class="form-control" id="edit-district-code" pattern="[0-9]+" name="subdistrict_code" value="{{ old('subdistrict_code')}}" required>

                        <div class="invalid-feedback">

                            Please Select a Valid Sub District Code.

                        </div>

                        @if ($errors->has('state_name'))

                        <span class="text-danger font-weight-bold">

                            {{ $errors->first('state_name') }}

                        </span>

                        @endif

                    </div>

                    <div class="form-group w-100">

                        <label for="edit-district-name">Sub District Name<span style="color: red;">*</span></label>

                        <input type="text" class="form-control" id="edit-district-name" name="subdistrict_name" value="{{ old('subdistrict_name') }}" required>

                        <div class="invalid-feedback" id="state_name_error">

                            Please Select a Valid Sub District.

                        </div>

                        @if ($errors->has('state_name'))

                        <span class="text-danger font-weight-bold">

                            {{ $errors->first('state_name') }}

                        </span>

                        @endif

                    </div>

                    <div class="d-flex justify-content-center py-4">

                        <button type="submit" class="btn btn-primary b-btn">Add</button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>
