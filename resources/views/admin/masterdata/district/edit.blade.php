<div class="modal fade" id="edit-district-modal">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center d-block p-2 border-bottom-0" style="background-color: white; color: black;">


                <h4 class="text-light">EDIT DISTRICT</h4>

                <button type="button" class="close position-absolute" style="right: 15px; top: 8px;" data-dismiss="modal">&times;</button>

            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <!-- Placeholder for editdistrictform.blade.php content -->

                <form action="{{route('admin.districts.update')}}" id="edit-district-form" method="POST" class="w-sm-100 w-auto mx-auto needs-validation master-data-form" novalidate>
                    @csrf

                    <div class="form-group">

                        <label for="state">Select State<span style="color: red;">*</span>: </label>

                        <select class="form-control" id="state_code_select" name="state_code" onchange="showDistrict()" required>

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

                        <label for="edit-district-code">District Code*:</label>

                        <input type="text" class="form-control" id="edit-district-code" name="district_code" value="" readonly>

                    </div>

                    <div class="form-group w-100">

                        <label for="edit-district-name">District Name*:</label>

                        <input type="text" class="form-control" id="edit-district-name" name="district_name" value="" required>

                    </div>

                    <div class="d-flex justify-content-center py-4">

                        <button type="submit" class="btn btn-primary b-btn">UPDATE</button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>
