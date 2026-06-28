<div class="modal fade" id="banks-add-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">ADD BANK</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="bank-add-form" action="{{route('admin.banks.store')}}" method="post" class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf
                    <div class="form-group w-100">
                        <label for="po-state">Select State<span style="color: red;">*</span>: </label>
                        <select class="form-control state_code_select" id="state_code_search_select" name="state_code" required>

                            <option value="">--Select State--</option>

                            @foreach($states as $state)

                            <option value="{{$state->state_name}}">{{$state->state_name}}</option>

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
                        <label for="po-name">IFSC Code<span style="color: red;">*</span>:</label>
                        <input type="text" class="form-control" id="ifsc-code" name="ifsc_code" placeholder="Enter IFSC Code" value="{{ old('ifsc_code') }}" required>
                    </div>

                    <div class="form-group w-100">
                        <label for="po-name">Branch Name<span style="color: red;">*</span>:</label>
                        <input type="text" class="form-control" id="branck-name" name="branch_name" placeholder="Enter Branch Name" value="{{ old('branch_name') }}" required>
                    </div>
                    <div class="form-group w-100">
                        <label for="pincode">Bank Name<span style="color: red;">*</span>:</label>
                        <input type="text" class="form-control" id="bank-name" name="bank_name" placeholder="Enter Bank Name" value="{{ old('bank_name') }}" required>
                    </div>
                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" id="poaddbutt" class="btn btn-primary b-btn">ADD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
