<div class="modal fade" id="office-add-modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header text-center d-block p-2 border-bottom-0 bg-dark text-light">
                <h4 class="text-light">ADD OFFICE</h4>
                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form id="add-office" action="{{route('admin.offices.store')}}" method="POST" class="w-sm-100 w-auto mx-auto master-data-form">
                    @csrf

                    <div class="form-group w-100">
                        <label for="po-district">Select District<span style="color: red;">*</span></label>

                        <select class="form-control district_codes" id="district_search_id" name="district_code" required>

                        <option selected disabled value="">--Select District--</option>

                            @foreach($districts as $district)

                                <option value="{{$district->district_code}}">{{$district->district_name}}</option>

                            @endforeach

                        </select>

                        <div class="invalid-feedback">

                            Please Enter a Valid District Code.

                        </div>

                        @if ($errors->has('district_code'))

                        <span class="invalid-feedback">{{ $errors->first('district_code') }}</span>

                        @endif
                    </div>
                    <div class="form-group w-100">
                        <label for="po-name">Office Name<span style="color: red;">*</span>:</label>
                        <input type="text" class="form-control" id="po-name" name="office_name" placeholder="Enter Post Office Name" value="{{ old('office_name') }}" required>
                    </div>

                    <div class="form-group w-100">
                        <label for="egras">eGrass Office Code<span style="color: red;">*</span>:</label>
                        <input type="text" class="form-control" id="egras" name="egrass_office_name" placeholder="Enter eGras Office Code" value="{{ old('egrass_office_name') }}" required>
                    </div>

                    <div class="d-flex justify-content-center py-4">
                        <button type="submit" id="poaddbutt" class="btn btn-primary b-btn">ADD</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
