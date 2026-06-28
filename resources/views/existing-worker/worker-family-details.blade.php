@extends('layouts.user-app')

@section('title', ' Family Details')

@section('style')
    <style>
        body {
            background-color: #f1f1f1;
        }

        * {

            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

        }

        .btn-primary {
            background-color: #0f4547;
        }

        .bar1,
        .bar2,
        .bar3 {
            width: 25px;
            height: 3px;
            background-color: #fff;
            margin: 5px 0;
            transition: 0.4s;
        }


        .change .bar1 {
            -webkit-transform: rotate(-45deg) translate(-5px, 5px);
            transform: rotate(-45deg) translate(-5px, 5px);
        }

        .change .bar2 {
            opacity: 0;
        }

        .change .bar3 {
            -webkit-transform: rotate(45deg) translate(-5px, -7px);
            transform: rotate(45deg) translate(-5px, -7px);
        }

        .table th {
            font-size: 14px;
        }

        .table-container {
            overflow-x: auto;
        }

        .fixed-width {
            min-width: 220px;
            /* Adjust the width as needed */
        }

        .fixed {
            min-width: 100px;
            /* Adjust the width as needed */
        }

        .table thead th {
            border-bottom: 2px solid black;
        }


        .bold {
            font-weight: 500;
            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
            font-size: 15px;
            /*color: #186cb8;*/
            color: #219fa4;
            /*color: #7ea1a2;*/
        }

        .custom-navbar {
            border-bottom: 2px solid #eee;
        }

        .custom-container {
            max-width: 1200px;
        }

        .custom-flex-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .custom-left-content {
            display: flex;
            flex-direction: column;
        }

        .custom-heading {
            margin-bottom: 0.5rem;
            font-size: 11px;
        }

        .custom-bold {
            font-weight: bold;
        }

        .custom-icon {
            color: #007bff;
        }

        .white-background {
            background-color: #fff !important;
            color: #000;
            cursor: pointer;
        }

        .white-background[readonly] {
            background-color: #fff !important;
        }
    </style>
@endsection


@section('content')
    @include('components.multistep-existing')
    <div class="container-fluid mb-4">
        <div class="col-md-12" style="overflow-x:auto;">
            <nav class="custom-navbar navbar-light p-3">
                <div class="custom-container">
                    <div class="custom-flex-container">
                        <div class="custom-left-content">
                            @include('components.session-timeout')
                        </div>

                    </div>
                </div>
            </nav>
            <div class="card mt-2">
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="d-flex justify-content-center align-items-center mb-3">
                            <span>
                                <i class="fa fa-user" aria-hidden="true"></i>
                                {{ trans('worker-registration/worker-family-details.workername') }}
                                - {{ $getVaultData['name'] }}
                            </span>
                        </div>
                        <div class="card rounded-card">
                            <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center"
                                style="background-color: #2badee;">
                                <span>
                                    <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;
                                    {{ trans('worker-registration/worker-family-details.familydetails') }}
                                </span>
                            </div>
                            <div class="row ml-2 mr-2">
                                <div class="col">
                                    <form method="post" id="dynamic_field" action="{{ route('save-existing-family') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mr-2 mt-3 ml-2"
                                            style="background-color: #f9f9f9; padding: 10px; border-radius: 5px; border: 1px solid #ccc; color: #333;">
                                            <p style="margin: 0;">
                                                <strong>{{ trans('worker-registration/worker-documents-details.note') }}:</strong>
                                            </p>
                                            <p style="margin: 0;">
                                                <strong>{{ trans('worker-registration/worker-documents-details.1') }}</strong><span
                                                    class="text-danger">
                                                    {{ trans('worker-registration/worker-documents-details.mandatory') }}</span>
                                            </p>
                                            <p style="margin: 0;">
                                                <strong>{{ trans('worker-registration/worker-documents-details.2') }}</strong><span
                                                    class="text-danger">
                                                    {{ trans('worker-registration/worker-documents-details.mandatory2') }}
                                                </span>
                                            </p>
                                            <p style="margin: 0;">
                                                <strong>3.</strong><span class="text-danger">
                                                    Nominee Percentage should be 100% (mandatorily) if a single family
                                                    member of the applicant is recorded in the family details
                                                </span>
                                            </p>
                                            <p style="margin: 0;">
                                                <strong>4.</strong><span class="text-danger">
                                                    Nominee Percentage should add up to 100% for all family members when
                                                    distributed.
                                                </span>
                                            </p>
                                        </div>
                                        <div class="mt-3" style="overflow-x: auto">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="bold fixed">
                                                            {{ trans('worker-registration/worker-family-details.serialno') }}
                                                        </th>
                                                        <th scope="col" class="bold fixed-width">
                                                            {{ trans('worker-registration/worker-family-details.fname') }}<span
                                                                class="text-danger">*</span></th>
                                                        <th scope="col" class="bold fixed-width">
                                                            {{ trans('worker-registration/worker-family-details.lname') }}<span
                                                                class="text-danger">*</span></th>
                                                        <th scope="col" class="bold fixed-width">
                                                            {{ trans('worker-registration/worker-family-details.dob') }}<span
                                                                class="text-danger">*</span></th>
                                                        <th scope="col" class="bold fixed-width">
                                                            {{ trans('worker-registration/worker-family-details.age') }}
                                                        </th>
                                                        <th scope="col" class="bold fixed-width">
                                                            {{ trans('worker-registration/worker-family-details.selectnominee') }}
                                                            (Y/N)<span class="text-danger">*</span></th>
                                                        <th scope="col" class="bold fixed-width">
                                                            {{ trans('worker-registration/worker-family-details.gname') }}
                                                        </th>
                                                        <th scope="col" class="bold fixed-width">
                                                            {{ trans('worker-registration/worker-family-details.nomineeshare') }}
                                                            <span class="text-danger">*</span>
                                                        </th>
                                                        <th scope="col" class="bold fixed-width">
                                                            {{ trans('worker-registration/worker-family-details.relation') }}<span
                                                                class="text-danger">*</span></th>
                                                        <th scope="col" class="bold fixed-width">
                                                            {{ trans('worker-registration/worker-family-details.alreadyreg') }}
                                                            {{-- <span class="text-danger">*</span> --}}
                                                        </th>
                                                        <th scope="col" class=" bold fixed-width">
                                                            Select the state of the Board you are registered with
                                                            {{-- <span class="text-danger">*</span> --}}
                                                        </th>
                                                        <th scope="col" class="bold fixed-width">BOCW Membership ID</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @php $count = 1; @endphp
                                                    <tr>
                                                        {{-- <input type="hidden" name="worker_id[]" value="{{$formdata->worker_id}}" class="form-control"/> --}}
                                                        <td class=" font-weight-normal"><span class="badge badge-warning">{{ $count }}</span></td>

                                                        <td class="fixed-width"><input type="text" name="first_name[]"
                                                                value="{{ $firstName }}" class="form-control" placeholder="First Name"/>
                                                            <span class="text-danger success"
                                                                id="first_name.0_error"></span>

                                                        </td>
                                                        <td class="fixed-width"><input type="text" name="last_name[]"
                                                                value="{{ $lastName }}"
                                                                class="form-control lastname" placeholder="Last Name"/>

                                                            <span class="text-danger success" id="last_name.0_error"></span>
                                                        </td>

                                                        <td class="fixed-width"><input type="text" id="date_1"
                                                                placeholder="DD-MM-YYYY"
                                                                data-id="1" name="dob[]"
                                                                class="form-control birthdate white-background"
                                                                onchange="calculateAge(this, 1)"
                                                                max="@php echo date('Y-m-d'); @endphp" />
                                                            <span class="text-danger success" id="dob.0_error"></span>
                                                        </td>
                                                        <td class="fixed-width"><input type="text" data-id="1"
                                                                value="" class="form-control age" id="age_1"
                                                                name="age[]" onchange="checkProf(this); toggleGuardianName('age_1', 'dropdown_1', 'guardain_name_1');" readonly /></td>
                                                        <td class="fixed-width">
                                                            <select name="nominee[]" data-id="1" id="dropdown_1"
                                                                class="form-control nominee-input"
                                                                onchange="togglePercentageInput(1); toggleGuardianName('age_1', 'dropdown_1', 'guardain_name_1','dynamic_field');">
                                                                <option value="">Select</option>
                                                                <option value="0"
                                                                    {{ isset($apiResponse->share) && ($apiResponse->share < 1 || $apiResponse->share > 100) ? 'selected' : '' }}>
                                                                    {{ trans('worker-registration/worker-family-details.no') }}
                                                                </option>
                                                                <option value="1"
                                                                    {{ isset($apiResponse->share) && $apiResponse->share >= 1 && $apiResponse->share <= 100 ? 'selected' : '' }}>
                                                                    {{ trans('worker-registration/worker-family-details.yes') }}
                                                                </option>
                                                            </select>
                                                            <span class="text-danger success" id="nominee.0_error"></span>
                                                        </td>
                                                        <td class="fixed-width"><input type="text"
                                                                name="guardain_name[]" id="guardain_name_1" value=""
                                                                class="form-control " readonly placeholder="Guardian Name"/>
                                                            <span class="text-danger success"
                                                                id="guardain_name.0_error"></span>
                                                        </td>
                                                        <td class="fixed-width">
                                                            <input type="number" id="percent_1" min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"
                                                                name="nominee_percentage[]" value="" data-id="1" placeholder="Enter Nominee Share"
                                                                class="form-control percentage-input" readonly />
                                                            <span class="text-danger success"
                                                                id="nominee_percentage.0_error"></span>

                                                        </td>
                                                        <td class="fixed-width">
                                                            <div class="d-flex align-items-center"
                                                                style="min-width: 400px">
                                                                <select name="relation[]"
                                                                    class="form-control custom-bottom-border @if ($errors->has('relation[]')) is-invalid @endif"
                                                                    id="relation_1" onchange="checkOthers(1)">
                                                                    <option value="">
                                                                        {{ trans('worker-registration/worker-family-details.selectrelation') }}
                                                                    </option>
                                                                    @foreach ($relations as $index => $relation)
                                                                        <option value="{{ $relation->relation_code }}">
                                                                            {{ $relation->relation_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <input type="text" name="relation_others[]"
                                                                    id="others_1"
                                                                    class="ml-4 d-none fixed-width form-control"
                                                                    placeholder="Enter Other Relation" />
                                                            </div>
                                                            <span class="text-danger success"
                                                                id="relation.0_error"></span>
                                                        </td>
                                                        <td class="fixed-width">
                                                            <select name="already_registered[]" data-id="1"
                                                                id="registered_1"
                                                                class="form-control register-input @if ($errors->has('already_registered[]')) is-invalid @endif"
                                                                onchange="toggleBocwwbInput(1)" disabled>
                                                                <option value="">Select</option>
                                                                <option value="0">
                                                                    {{ trans('worker-registration/worker-family-details.no') }}
                                                                </option>
                                                                <option value="1">
                                                                    {{ trans('worker-registration/worker-family-details.yes') }}
                                                                </option>
                                                            </select>
                                                            <span class="text-danger success"
                                                                id="already_registered.0_error"></span>
                                                        </td>
                                                        <td>
                                                            <select name="already_registered_state[]" data-id="1"
                                                                id="already_registered_state_1"
                                                                onchange="validateBocwID()" disabled
                                                                class="form-control register-input @if ($errors->has('already_registered_state[]')) is-invalid @endif">
                                                                <option value="">
                                                                    Select State
                                                                </option>
                                                                @foreach ($states as $state)
                                                                    <option value="{{ $state->state_code }}">
                                                                        {{ $state->state_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td class="fixed-width">
                                                            <input type="text" class="form-control bocwwb-input"
                                                                placeholder="BOCW ID" id="bocwwb_1" data-id="1"
                                                                name="bocwwb_id[]" readonly />
                                                            <span class="text-danger success"
                                                                id="bocwwb_id.0_error"></span>
                                                        </td>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <button type="button" name="add" id="add"
                                            class=" btn-sm btn-danger mt-3"><i class="fa fa-plus-circle"></i>&nbsp;

                                            Add New Row</button>

                                        <div class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                                            <div class="ml-auto d-inline-block align-self-center mr-2">
                                                <a type="submit" href="{{ route('submit-worker-address-details') }}"
                                                    class="btn btn-sm btn-warning"><i class="fa fa-backward"
                                                        aria-hidden="true"></i>&nbsp;
                                                    Previous</a>
                                                    <button type="submit" class="btn btn-sm btn-primary" id="saveFamilyBtn">
                                                        <span id="saveBtnText">
                                                            <i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;
                                                            {{ trans('worker-registration/worker-family-details.savefamily') }}
                                                        </span>
                                                        <span id="saveBtnSpinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                                    </button>

                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Left side columns -->
            </div>
        </div>
    </div>


@endsection


@section('footer')
    <script src="{{ URL::asset('assets/template/js/worker-family-details-styles.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/session-timeout.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('assets/template/flatpickr/flatpickr.min.css') }}">
    <script src="{{ URL::asset('assets/template/flatpickr/flatpickr.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('dynamic_field');
            const saveBtn = document.getElementById('saveFamilyBtn');
            const saveBtnText = document.getElementById('saveBtnText');
            const saveBtnSpinner = document.getElementById('saveBtnSpinner');

            if (form && saveBtn) {
                form.addEventListener('submit', function(e) {
                     e.preventDefault();
                    if (saveBtn.disabled) return;
                    saveBtn.disabled = true;
                    saveBtnText.classList.add('d-none');
                    saveBtnSpinner.classList.remove('d-none');

                    const formData = new FormData(form);

                    fetch(form.action)
                        .then(response => response.json())
                        .then(data => {
                            saveBtn.disabled = false;
                            saveBtnText.classList.remove('d-none');
                            saveBtnSpinner.classList.add('d-none');

                            if (data.success) {
                                saveBtn.disabled = true;
                                saveBtnText.classList.add('d-none');
                                saveBtnSpinner.classList.remove('d-none');
                            } else {
                                if (data.errors) {
                                    console.error(data.errors);
                                }
                            }
                        })
                        .catch(error => {
                            console.error("Submission Error:", error);
                            saveBtn.disabled = false;
                            saveBtnText.classList.remove('d-none');
                            saveBtnSpinner.classList.add('d-none');
                        });
                });
            }
        });
    </script>

    <script>
        flatpickr("#date_1", {
            dateFormat: "d-m-Y", // ddmmyyyy format
            maxDate: new Date() // Restrict selection to today or earlier
        });
    </script>

    <script>
        function toggleGuardianName(ageId, nomineeId, guardianNameId) {
            const age = document.getElementById(ageId).value;
            const nominee = document.getElementById(nomineeId).value;
            const guardianNameField = document.getElementById(guardianNameId);

            // Check if age is under 18 and nominee is "1"
            if (age < 18 && nominee === "1") {
                guardianNameField.removeAttribute("readonly");
            } else {
                guardianNameField.setAttribute("readonly", "readonly");
                guardianNameField.value = "NA";
            }
        }

    </script>
    <script>
        $(document).ready(function() {
            let count = 1;
            let dynamicRowsData = []; // Array to store data for dynamically added rows

            // Function to add dynamic fields
            function dynamic_field(number, data = null) {
                const currentDate = new Date().toISOString().split("T")[0];
                const rowId = `row_${number}`;
                let html = `<tr id="${rowId}">`;

                html += `<td><span class="badge badge-warning">${number}</span></td>`;
                html += generateTextInputCell("first_name", number,
                    "{{ trans('worker-registration/worker-family-details.enterfname') }}");
                html += generateTextInputCell("last_name", number,
                    "{{ trans('worker-registration/worker-family-details.enterlname') }}");
                html += generateDateInputCell("dob", number, currentDate);
                html += generateAgeInputCell(number);
                html += generateNomineeDropdown(number);
                html += generateGuardianInputCell(number);
                html += generatePercentageInputCell(number);
                html += generateRelationDropdown(number);
                html += generateAlreadyRegisteredDropdown(number);
                html += generateStateDropdown(number);
                html += generateBocwIdInputCell(number);
                html += generateRemoveButtonCell(rowId);

                html += `</tr>`;

                $("tbody").append(html);
                flatpickr(`input[name="dob[${number}]"]`, {
                    dateFormat: "d-m-Y", // ddmmyyyy format
                    maxDate: new Date() // Restrict selection to today or earlier
                });
            }

        function generateTextInputCell(fieldName, index, placeholder) {
        return `
            <td>
                <input
                    type="text"
                    placeholder="${placeholder}"
                    name="${fieldName}[${index}]"
                    class="form-control"
                />
                <span class="text-danger success" id="${fieldName}.${index}_error"></span>
            </td>`;
        }

        function generateDateInputCell(fieldName, index, maxDate) {
        return `
            <td>
                <input
                    placeholder="DD-MM-YYYY"
                    type="text"
                    name="${fieldName}[${index}]"
                    class="form-control birthdate white-background"
                    max="${maxDate}"
                    onkeydown="return false;"
                    onchange="calculateAge(this, ${index})"
                />
                <span class="text-danger success" id="${fieldName}.${index}_error"></span>
            </td>`;
            }

            function generateAgeInputCell(index) {
            return `
            <td>
                <input
                    type="text"
                    id="age_${index}"
                    name="age[${index}]"
                    class="form-control age"
                    readonly
                    onchange="checkProf(this); toggleGuardianName('age_${index}', 'dropdown_${index}', 'guardain_name_${index}');"
                />
                <span class="text-danger success" id="age.${index}_error"></span>
            </td>`;
            }

            function generateNomineeDropdown(index) {
            return `
            <td>
                <select
                    id="dropdown_${index}"
                    name="nominee[${index}]"
                    class="form-control nominee-input"
                    onchange="togglePercentageInput(${index}); toggleGuardianName('age_${index}', 'dropdown_${index}', 'guardain_name_${index}');">
                    <option value="">{{ trans('worker-registration/worker-family-details.select') }}</option>
                    <option value="0">{{ trans('worker-registration/worker-family-details.no') }}</option>
                    <option value="1">{{ trans('worker-registration/worker-family-details.yes') }}</option>
                </select>
                <span class="text-danger success" id="nominee.${index}_error"></span>
            </td>`;
            }

            function generateGuardianInputCell(index) {
            return `
            <td>
                <input
                    type="text"
                    id="guardain_name_${index}"
                    name="guardain_name[${index}]"
                    class="form-control"
                    placeholder="{{ trans('worker-registration/worker-family-details.gname') }}"
                    readonly
                />
                <span class="text-danger success" id="guardain_name.${index}_error"></span>
            </td>`;
            }

            function generatePercentageInputCell(index) {
            return `
            <td>
                <input
                    type="number"
                    placeholder="Enter Nominee Share"
                    min="0" oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null"
                    id="percent_${index}"
                    name="nominee_percentage[${index}]"
                    class="form-control percentage-input"
                    readonly
                />
                <span class="text-danger success" id="nominee_percentage.${index}_error"></span>
            </td>`;
            }

            function generateRelationDropdown(index) {
            let options = `
            <option value="" selected>{{ trans('worker-registration/worker-family-details.selectrelation') }}</option>`;
                    @foreach ($relations as $relation)
                        options +=
                            `<option value="{{ $relation->relation_code }}">{{ $relation->relation_name }}</option>`;
                    @endforeach

                    return `
            <td>
                <select
                    id="relation_${index}"
                    name="relation[${index}]"
                    class="form-control"
                    onchange="checkOthers(${index})">
                    ${options}
                </select>
                <input
                    type="text"
                    id="others_${index}"
                    name="relation_others[${index}]"
                    class="form-control d-none"
                    placeholder="Enter Other Relation"
                />
                <span class="text-danger success" id="relation.${index}_error"></span>
            </td>`;
            }

            function generateAlreadyRegisteredDropdown(index) {
            return `
            <td>
                <select
                    id="registered_${index}"
                    name="already_registered[${index}]"
                    class="form-control"
                    onchange="toggleBocwwbInput(${index});"
                    disabled
                    >
                    <option value="">{{ trans('worker-registration/worker-family-details.select') }}</option>
                    <option value="0">{{ trans('worker-registration/worker-family-details.no') }}</option>
                    <option value="1">{{ trans('worker-registration/worker-family-details.yes') }}</option>
                </select>
                <span class="text-danger success" id="already_registered.${index}_error"></span>
            </td>`;
            }

            function generateStateDropdown(index) {
                let options = `<option value="">Select State</option>`;
                @foreach ($states as $state)
                    options += `<option value="{{ $state->state_code }}">{{ $state->state_name }}</option>`;
                @endforeach

                return `
                <td>
                    <select
                        id="already_registered_state_${index}"
                        name="already_registered_state[${index}]"
                        class="form-control"
                        disabled
                        onchange="validateBocwID(${index});">
                        ${options}
                    </select>
                </td>`;
            }

            function generateBocwIdInputCell(index) {
                return `
                <td>
                    <input
                        type="text"
                        id="bocwwb_${index}"
                        name="bocwwb_id[${index}]"
                        class="form-control"
                        placeholder="BOCW ID"
                        readonly
                    />
                    <span class="text-danger success" id="bocwwb_id.${index}_error"></span>
                </td>`;
            }

            function generateRemoveButtonCell(rowId) {
                return `
                <td>
                    <button
                        type="button"
                        class="btn btn-sm remove"
                        onclick="removeRow('${rowId}')">
                        <i class="fa fa-trash text-danger" aria-hidden="true"></i>
                    </button>
                </td>`;
            }

            function removeRow(rowId) {
                $(`#${rowId}`).remove();
            }

            // Event listener for form submission
            $('#dynamic_field').submit(function(event) {
                event.preventDefault();
                $('.success').html('');
                $('tbody tr').each(function(index, element) {
                    let rowData = {
                        firstName: $(element).find('input[name="first_name[]"]').val(),
                        lastName: $(element).find('input[name="last_name[]"]').val(),
                        dob: $(element).find('input[name="dob[]"]').val(),
                        age: $(element).find('input[name="age[]"]').val(),
                        guardianName: $(element).find('input[name="guardain_name[]"]').val(),
                        relation: $(element).find('input[name="relation[]"]').val(),
                        nominee: $(element).find('input[name="nominee[]"]').val(),

                        already_registered: $(element).find(
                            'input[name="already_registered[]"]').val(),

                    };
                    dynamicRowsData.push(rowData);
                });
                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('save-existing-family') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            Toastify({
                                text: "Family Details Submitted Successfully!",
                                duration: 3000,
                                gravity: "top",
                                position: "right",
                                style: { background: "#28a745" }
                            }).showToast();

                            // Redirect after a short delay so user sees the message
                            setTimeout(function() {
                                window.location.href = "{{ route('submit-existing-employers') }}";
                            }, 1500);

                        } else {

                            if (response.msg === 'true') {
                                // toastr.error('BOCW Id already exists,cannot procced!');
                                Toastify({
                                    text: 'BOCW Id already exists,cannot procced!',
                                    duration: 5000,
                                    close: true,
                                    gravity: "top",
                                    position: "right",
                                    style: {
                                        background: "#FF4C4C" // Error color (e.g., red)
                                    },
                                }).showToast();
                            } else {
                                if (response.errors) {
                                    Toastify({
                                        text: 'Validation Error Found, please fill up required fields',
                                        duration: 5000, // Duration in milliseconds
                                        close: true, // Show close button
                                        gravity: "top", // Position of the toast (top or bottom)
                                        position: "right", // Position on the screen (left, right, center)
                                        style: {
                                            background: "#FF4C4C" // Error color (e.g., red)
                                        },
                                    }).showToast();

                                    $.each(response.errors, function(field, messages) {
                                        var escapedKey = field.replace('.', '\\.');
                                        $("#" + escapedKey + '_error').html(messages[
                                            0]);
                                    });
                                    if (response.errors.name) {
                                        alert(response.errors.name);
                                    }
                                }
                            }
                            if (response.errors.nominee_percentage) {
                                console.log(response.errors.nominee_percentage)
                                Toastify({
                                    text: response.errors.nominee_percentage,
                                    duration: 5000, // Duration in milliseconds
                                    close: true, // Show close button
                                    gravity: "top", // Position of the toast (top or bottom)
                                    position: "right", // Position on the screen (left, right, center)
                                    style: {
                                        background: "#FF4C4C" // Error color (e.g., red)
                                    },
                                }).showToast();
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr.responseText); // Add this line
                        alert('An error occurred while processing your request.');
                    }
                });
            });
            // });

            // Re-add dynamically added rows after a failed validation
            function reAddDynamicRows() {
                for (let i = 0; i < dynamicRowsData.length; i++) {
                    dynamic_field(count, dynamicRowsData[i]);
                }
            }

            // Call reAddDynamicRows function after the page reloads if dynamicRowsData is not empty
            if (dynamicRowsData.length > 0) {
                reAddDynamicRows();
            }

            $(document).on('click', '#add', function() {
                count++;
                dynamic_field(count);
            });

            $(document).on('click', '.remove', function() {
                count--;
                $(this).closest("tr").remove();
            });
        });



        $(document).on('keyup', '.percentage-input', function() {
            validatePercentages($(this).attr("id"));
        });

        function togglePercentageInput(number) {
            var dropdown = document.getElementById('dropdown_' + number);
            var percentInput = document.getElementById('percent_' + number);

            if (dropdown.value === '1') {
                percentInput.removeAttribute('readonly');
                percentInput.value = ''; // Set value to 100 when dropdown is 1
            } else {
                percentInput.setAttribute('readonly', 'true');
                percentInput.value = ''; // Clear value when not selected
            }

            validatePercentages('percent_' + number); // Re-validate after setting the value
        }

        function validatePercentages(changedId) {
            var per = 0;
            $('.percentage-input').each(function() {
                var val = parseInt($(this).val());
                if (isNaN(val)) {
                    val = 0;
                }
                per += val;
            });

            if (per > 100) {
                Swal.fire({
                    icon: 'error',
                    text: 'Nominee Percentage Cannot Exceed 100',
                });

                $('#' + changedId).val('0'); // Reset only the last modified input
            }
        }

        function toggleBocwwbInput(number) {
            var registered = document.getElementById('registered_' + number);
            var bocwwbInput = document.getElementById('bocwwb_' + number);
            var alreadyRegistered = document.getElementById('already_registered_state_' + number)

            if (registered.value === '1') {
                bocwwbInput.removeAttribute('readonly');
                alreadyRegistered.disabled = false

            } else {
                bocwwbInput.setAttribute('readonly', 'true');
                bocwwbInput.value = 'NA';
//                alreadyRegistered.value = 'NA';
                console.log(alreadyRegistered);
                alreadyRegistered.disabled = true

            }
        }

        function checkOthers(number) {
            var othersSelect = document.getElementById('others_' + number);
            var professionType = document.getElementById('relation_' + number).value;
            console.log(professionType);

            if (professionType == 17) {
                othersSelect.classList.remove('d-none');
            } else {
                othersSelect.classList.add('d-none');
            }
        }


        function calculateAge(input, number) {
            // Ensure the input value is not empty
            if (!input.value) {
                Toastify({
                    text: "Please select a valid date of birth.",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#f00", // Red for error
                }).showToast();
                return;
            }

            // Split the input value into day, month, and year
            const parts = input.value.split("-");
            if (parts.length !== 3) {
                Toastify({
                    text: "Invalid date format. Please use DD-MM-YYYY.",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#f00", // Red for error
                }).showToast();
                return;
            }

            const day = parseInt(parts[0], 10);
            const month = parseInt(parts[1], 10) - 1; // JavaScript months are 0-based
            const year = parseInt(parts[2], 10);

            // Validate the parsed date
            const dob = new Date(year, month, day);
            if (dob.getFullYear() !== year || dob.getMonth() !== month || dob.getDate() !== day || isNaN(dob)) {
                Toastify({
                    text: "Invalid date. Please select a valid date of birth.",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "#f00", // Red for error
                }).showToast();
                return;
            }

            // Calculate age
            const currentDate = new Date();
            let age = currentDate.getFullYear() - dob.getFullYear();

            // Adjust age if the birthday hasn't occurred this year
            if (
                currentDate.getMonth() < dob.getMonth() ||
                (currentDate.getMonth() === dob.getMonth() && currentDate.getDate() < dob.getDate())
            ) {
                age--;
            }

            // Update the age field
            const ageInput = input.parentElement.nextElementSibling.querySelector('.age');
            if (ageInput) {
                ageInput.value = age;
            }

            const guardianField = input.parentElement.nextElementSibling.nextElementSibling.nextElementSibling
                .querySelector(
                    'input'
                );
            const registeredSelect = document.querySelector(`#registered_${number}`);

            // Logic for guardian and registration fields based on age
            if (age < 18) {
                guardianField.removeAttribute('disabled');
                registeredSelect.setAttribute('disabled', 'disabled');
                registeredSelect.value = ''; // Clear the selection
            } else {
                guardianField.style.display = 'block'; // Show the field
                guardianField.setAttribute('readonly', 'readonly');
                Toastify({
                    text: "Guardian name is required when age is more than 18!",
                    duration: 3000,
                    gravity: "top",
                    position: "right",
                    backgroundColor: "orange", // Green for success
                }).showToast();
                guardianField.value = 'NA';
                registeredSelect.removeAttribute('disabled');
                registeredSelect.value = ''; // Clear the selection
            }
        }

        function checkProf(element) {
            const age = parseInt(element.value, 10);
            console.log(age); // Debugging: Log the age value

            // Find the closest parent element (like a row) that contains both the age input and the profession select
            const parentRow = element.closest('tr');
            // Get the profession select element within the same parent element
            // const professionSelect = parentRow.querySelector('select[name^="profession"]');
            //
            // Debugging: Log the profession select element
            // console.log(professionSelect);
            //
            // Disable or enable the profession field based on the age value
            // if (age < 14) {
            //     professionSelect.disabled = true;
            // } else {
            //     professionSelect.disabled = false;
            // }
        }
    </script>

    <script src="{{ URL::asset('assets/template/js/toastr.min.js') }}"></script>
@endsection
