<div class="mx-5 mt-3">
    <form id="bank-search" action="{{route('admin.banks.search')}}" class="w-sm-50 w-auto mx-auto">
        @csrf
        <div class="form-group w-50">

            <label for="state">Select Bank<span style="color: red;">*</span>: </label>

            <select class="form-control bank_name_select" id="bank_name_search_select" name="bank_name" required>

                <option value="" selected disabled>--Select Bank--</option>

                @foreach($banks as $bank)

                <option value="{{$bank->bank_name}}">{{$bank->bank_name}}</option>

                @endforeach

            </select>
            
            <div class="invalid-feedback" id="bank_name_error">

                Please Select a Valid Bank Name.

            </div>

            @if ($errors->has('bank_name'))

            <span class="text-danger font-weight-bold">

                {{ $errors->first('bank_name') }}

            </span>

            @endif

        </div>

        
        <div class="text-left py-4">
            <button type="submit" class="btn btn-primary b-btn" id="">SEARCH</button>
        </div>
    </form>
</div>