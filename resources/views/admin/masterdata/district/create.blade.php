<div class="mx-5 mt-3 w-50">

    <form action="{{ route('admin.districts.store') }}" method="POST" class="w-sm-50 w-auto mx-auto needs-validation" novalidate>

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

        <div class="form-group">

            <label for="district-code">District Code As per LGD: </label>

            <input type="text" class="form-control" id="district-code" name="district_code" placeholder="Enter District Code as per LGD" value="{{ old('statecode') }}" required>

            <div class="invalid-feedback">

                Please Enter a Valid District Code.

            </div>

            @if ($errors->has('district_code'))

            <span class="invalid-feedback">{{ $errors->first('district_code') }}</span>

            @endif

        </div>

        <div class="form-group">

            <label for="state-name">District Name:</label>

            <input type="text" class="form-control" id="district-name" name="district_name" placeholder="Enter District Name" value="{{ old('statename') }}" required>

            <div class="invalid-feedback">

                Please Enter a Valid District Name.

            </div>

            @if ($errors->has('district_name'))

            <span class="invalid-feedback">{{ $errors->first('district_name') }}</span>

            @endif

        </div>

        <div class="text-left py-4">

            <button type="submit" class="btn btn-primary b-btn">ADD</button>

        </div>


    </form>

</div>
