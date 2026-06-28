<div class="mx-5 mt-3 w-50">

    <form action="{{ route('admin.benefit-form.store') }}" method="POST" class="w-sm-50 w-auto mx-auto needs-validation"
        novalidate>

        @csrf

        <input class="form-control" type="text" name="benefit_id" value="{{ $benefit_details->id }}" hidden>

        <div class="form-group">

            <label for="district-code">Input Field Name: </label>

            <input type="text" class="form-control" id="district-code" name="field_name"
                placeholder="Enter Input Field Name" value="{{ old('field_name') }}" required>

            <div class="invalid-feedback">

                Please Enter a Valid Field Name.

            </div>

            @if ($errors->has('field_name'))
                <span class="invalid-feedback">{{ $errors->first('field_name') }}</span>
            @endif

        </div>

        <div class="form-group">

            <label for="input_type">Input Type:</label>

            <select name="input_type" id="input_type" class="form-control">
                <option value="text">Text</option>
                <option value="number">Number</option>
                <option value="select">Select</option>
                <option value="textarea">Text Area</option>
                <option value="date">Date Picker</option>
                <option value="radio">Radio</option>
                <option value="checkbox">Checkbox</option>
                <option value="file">File</option>
                <option value="prefilled_table">Prefilled Table (Display Only)</option>
            </select>

            <div class="invalid-feedback">

                Please Enter a Valid Input Type.

            </div>

            @if ($errors->has('input_type'))
                <span class="invalid-feedback">{{ $errors->first('input_type') }}</span>
            @endif

            {{-- ADD THIS ENTIRE SECTION --}}
            <div id="prefilled_table_config_section" style="display: none;">
                <h5 class="mt-4 border-bottom">Prefilled Table Configuration</h5>

                <div class="form-group">
                    <label for="prefilled_table_name">Select Worker Data Table</label>
                    <select name="prefilled_table_name" id="prefilled_table_name" class="form-control">
                        <option value="">-- Select Worker Table --</option>
                        @foreach ($workerTables as $workerTable)
                            <option value="{{ $workerTable->tablename }}">
                                {{ ucfirst(str_replace('_', ' ', $workerTable->tablename)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="prefilled_table_columns">Database Columns to Display</label>
                    <input type="text" class="form-control" name="prefilled_table_columns"
                        id="prefilled_table_columns" placeholder="e.g., full_name,date_of_birth,relation">
                    <small class="form-text text-muted">Enter the exact database column names, separated by
                        commas.</small>
                </div>

                <div class="form-group">
                    <label for="prefilled_table_headers">Table Headers for Display</label>
                    <input type="text" class="form-control" name="prefilled_table_headers"
                        id="prefilled_table_headers" placeholder="e.g., Full Name,Date of Birth,Relation">
                    <small class="form-text text-muted">Enter the display text for each column header, separated by
                        commas, in the same order as the columns above.</small>
                </div>

                <div class="form-group">
                    <label for="prefilled_table_condition_column">Filtering Column</label>
                    <input type="text" class="form-control" name="prefilled_table_condition_column"
                        id="prefilled_table_condition_column" placeholder="e.g., worker_id">
                    <small class="form-text text-muted">Enter the column name in the source table that should be
                        filtered by the logged-in worker's ID.</small>
                </div>
            </div>

            <div class="form-group">
                <label for="use_masterdata">Use Masterdata Table?</label>
                <input type="checkbox" id="use_masterdata" name="use_masterdata" value="true">
            </div>

            <div class="form-group" id="masterdata_table_section" style="display: none;">
                <label for="masterdata_table">Select Masterdata Table</label>
                <select name="masterdata_table" id="masterdata_table" class="form-control">
                    <option value="">-- Select Table --</option>
                    @foreach ($tables as $table)
                        <option value="{{ $table->tablename }}">
                            {{ ucfirst(str_replace('_', ' ', $table->tablename)) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" id="masterdata_table_key_section" style="display: none;">
                <label for="masterdata_table_key">Select Masterdata Key</label>
                <select name="masterdata_table_key" id="masterdata_table_key" class="form-control">
                </select>
            </div>
            <div class="form-group" id="masterdata_table_value_section" style="display: none;">
                <label for="masterdata_table_value">Select Masterdata Value</label>
                <select name="masterdata_table_value" id="masterdata_table_value" class="form-control">
                </select>
            </div>
            <div class="form-group" id="masterdata_table_condition_section" style="display: none">
                <label for="masterdata_table_condition">Condition</label>
                <input type="text" name="masterdata_table_condition" id="masterdata_table_condition"
                    class="form-control">
                </select>
            </div>





        </div>



        <div class="form-group d-none" id="options_container">
            <label for="field_options">Enter Options (comma-separated):</label>
            <textarea class="form-control" name="field_options" id="field_options" placeholder="Option1, Option2, Option3"></textarea>

            <div class="invalid-feedback">Please Enter Valid Options.</div>

            @if ($errors->has('field_options'))
                <span class="invalid-feedback">{{ $errors->first('field_options') }}</span>
            @endif
        </div>


        <div class="form-group">
            <label for="validation_rules">Validation Rules (JSON Format):</label>
            <textarea class="form-control" name="validation_rules" id="validation_rules"
                placeholder='{"required": true, "min": 3}' required>{{ old('validation_rules') }}</textarea>
            <div class="invalid-feedback">Please enter valid JSON validation rules.</div>
            @error('validation_rules')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Error Messages Input -->
        <div class="form-group">
            <label for="error_messages">Error Messages (JSON Format):</label>
            <textarea class="form-control" name="error_messages" id="error_messages"
                placeholder='{"required": "This field is required", "min": "Minimum 3 characters required"}' required>{{ old('error_messages') }}</textarea>
            <div class="invalid-feedback">Please enter valid JSON error messages.</div>
            @error('error_messages')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror



            <div class="form-group">
                <label for="use_masterdata">Use Pre Filled Data?</label>
                <input type="checkbox" id="use_prefilled_data" name="use_prefilled_data" value="1">
            </div>

            <div class="container mt-4">
                <div class="form-group">
                    <label for="use_dependent_field">Use Field as Dependent</label>
                    <input type="checkbox" id="use_dependent_field" name="use_dependent_field" value="1">
                </div>

                <div class="form-group mt-3" id="select_field_container" style="display: none;">
                    <label for="select_dependent_field">Select Field</label>
                    <select name="select_dependent_field" id="select_dependent_field" class="form-control">
                    </select>
                </div>

                <div class="form-group" id="select_field_details_container" style="display:none">
                    <label for="select_dependent_field_details">Select Worker Data Key</label>
                    <select name="select_dependent_field_details" id="select_dependent_field_details" class="form-control">
                        <option value="">-- Select Field Data --</option>

                    </select>
                </div>


            </div>

            <div class="form-group" id="prefilled_data_type_section" style="">
                <label for="prefilled_data_type">Select Prefilled Data Type</label>
                <select name="prefilled_data_type" id="prefilled_data_type" class="form-control">
                    <option value="">-- Select Data Type --</option>
                    <option value="1">Vault Data</option>
                    <option value="2">Worker Data from Database</option>
                </select>
            </div>

            <div class="form-group" id="prefilled_vault_data_key_section" style="">
                <label for="prefilled_vault_data_key">Select Vault Data Key</label>
                <select name="prefilled_vault_data_key" id="prefilled_vault_data_key" class="form-control">
                    <option disabled selected>Select a key</option>
                    {{-- <option value="transactionID">transactionID</option>
                    <option value="uID">uID</option> --}}
                    <option value="buildingName">buildingName</option>
                    <option value="careOf">careOf</option>
                    <option value="district">district</option>
                    <option value="dob">dob</option>
                    <option value="gender">gender</option>
                    <option value="pinCode">pinCode</option>
                    <option value="state">state</option>
                    <option value="street">street</option>
                    <option value="photo">photo</option>
                    <option value="name">name</option>
                    <option value="landMark">landMark</option>
                    <option value="locality">locality</option>
                    <option value="subDistrict">subDistrict</option>
                    <option value="postOffice">postOffice</option>
                    {{-- <option value="pdf">pdf</option> --}}
                    <option value="village">village</option>
                </select>
            </div>

            <div class="form-group" id="prefilled_worker_data_table_section" style="">
                <label for="prefilled_worker_data_table">Select Worker Data Table</label>
                <select name="prefilled_worker_data_table" id="prefilled_worker_data_table" class="form-control">
                    <option value="">-- Select Worker Data Table --</option>
                    @foreach ($workerTables as $workerTable)
                        <option value="{{ $workerTable->tablename }}">
                            {{ ucfirst(str_replace('_', ' ', $workerTable->tablename)) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" id="prefilled_worker_data_key_section" style="">
                <label for="prefilled_worker_data_key">Select Worker Data Key</label>
                <select name="prefilled_worker_data_key" id="prefilled_worker_data_key" class="form-control">
                    <option value="">-- Select Worker Data Key --</option>

                </select>
            </div>



            <div class="form-group" id="use_masterdata_value_section" style="display: none">
                <label for="use_masterdata_value">Use Masterdata Table Value?</label>
                <input type="checkbox" id="use_masterdata_value" name="use_masterdata_value" value="1">
            </div>

            <div class="form-group" id="masterdata_value_table_section" style="display:none">
                <label for="masterdata_table">Select Masterdata Table</label>
                <select name="masterdata_value_table" id="masterdata_value_table" class="form-control">
                    <option value="">-- Select Table --</option>
                    @foreach ($tables as $table)
                        <option value="{{ $table->tablename }}">
                            {{ ucfirst(str_replace('_', ' ', $table->tablename)) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" id="masterdata_table_prefilled_key_section" style="display:none">
                <label for="masterdata_table_key">Select Masterdata Key</label>
                <select name="masterdata_table_prefilled_key" id="masterdata_table_prefilled_key"
                    class="form-control">
                </select>
            </div>
            <div class="form-group" id="masterdata_table_prefilled_value_section" style="display:none">
                <label for="masterdata_table_prefilled_value">Select Masterdata Value</label>
                <select name="masterdata_table_prefilled_value" id="masterdata_table_prefilled_value"
                    class="form-control">
                </select>
            </div>



            <div class="text-left py-4">

                <button type="submit" class="btn btn-primary b-btn">ADD</button>
                {{-- q --}}
            </div>
        </div>


    </form>

</div>
