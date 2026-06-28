<div class="modal fade" id="post-office-add-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">ADD POST OFFICE</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="add-post-office" action="{{route('admin.post-offices.store')}}" method="post" class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf
                    <div class="form-group w-100">
                        <label for="po-state">Select State<span style="color: red;">*</span>: </label>
                        <select class="form-control state_code_select" id="state_code__search_select" name="state_code" required>

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

                        <select class="form-control district_codes" id="district_search_id" name="district_code" required>

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
                        <label for="po-name">Postoffice Name<span style="color: red;">*</span>:</label>
                        <input type="text" class="form-control" id="po-name" name="post_office_name" placeholder="Enter Post Office Name" value="{{ old('postofficename') }}" required>
                    </div>
                    <div class="form-group w-100">
                        <label for="pincode">Pincode<span style="color: red;">*</span>:</label>
                        <input type="text" class="form-control" id="pincode" name="pin_code" placeholder="Enter Pincode" value="{{ old('pincode') }}" required>
                    </div>
                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" id="poaddbutt" class="btn btn-primary b-btn">ADD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
