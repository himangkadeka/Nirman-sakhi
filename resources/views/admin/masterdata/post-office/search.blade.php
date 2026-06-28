<div class="mx-5 mt-3">
    <form id="post-office-search" action="{{route('admin.post-offices.search')}}" class="w-sm-50 w-auto mx-auto">
        @csrf
        <div class="form-group w-50">

            <label for="state">Select State<span style="color: red;">*</span>: </label>

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

        <div class="form-group w-50">

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
        <div class="text-left py-4">
            <button type="submit" class="btn btn-primary b-btn" id="searchpo">SEARCH</button>
        </div>
    </form>
</div>