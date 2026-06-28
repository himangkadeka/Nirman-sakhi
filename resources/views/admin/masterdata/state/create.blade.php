
<div class="mx-5 mt-3">

    <form action="{{ route('admin.states.store') }}" method="POST" class="w-sm-50 w-auto mx-auto needs-validation"
        novalidate>

        @csrf

        <div class="form-group w-50">

            <label for="state-code">State Code As per LGD: </label>

            <input type="text" class="form-control @if ($errors->has('statecode')) is-invalid @endif" id="state-code"
                name="statecode" pattern="[0-9]+" placeholder="Enter State Code as per LGD"
                value="{{ old('statecode') }}" required>

            <div class="invalid-feedback">

                Please Enter a Valid State Code.

            </div>

            @if ($errors->has('statecode'))
                <span class="text-danger font-weight-bold">

                    {{ $errors->first('statecode') }}

                </span>
            @endif

        </div>

        <div class="form-group w-50">

            <label for="state-name">State Name:</label>

            <input type="text"
                class="form-control custom-bottom-border uc-text-smooth @if ($errors->has('statename')) is-invalid @endif"
                id="state-name" name="statename" pattern="[A-Za-z]+" placeholder="Enter State Name"
                value="{{ old('statename') }}" required>

            <div class="invalid-feedback">

                Please Enter a Valid State Name.

            </div>
            @if ($errors->has('statename'))
                <span class="invalid-feedback">{{ $errors->first('statename') }}</span>
            @endif

        </div>

        <div class="text-left py-4">

            <button type="submit" class="btn btn-primary b-btn">ADD</button>

        </div>

    </form>

</div>

