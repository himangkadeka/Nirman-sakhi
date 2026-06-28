@extends('layouts.user-app')

@section('title', ' Family Details')

@section('style')
    <style>
        .table th {
            font-size: 12px;
        }

        .table-container {
            overflow-x: auto;
        }

        .fixed-width {
            min-width: 200px;
            /* Adjust the width as needed */
        }

        .fixed {
            min-width: 100px;
            /* Adjust the width as needed */
        }

        .table thead th {
            border-bottom: 1px solid black;
        }

        .bold {
            font-weight: 600;
            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;
            font-size: 14px;
            /*color: #186cb8;*/
            color: #219fa4;
            /*color: #7ea1a2;*/
        }

        body {
            background-color: #f1f1f1;
        }

        * {

            font-family: "Montserrat Alternates", "Open Sans", Helvetica, Arial, sans-serif;

        }

        label.bold {
            font-weight: 600;
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
    </style>
@endsection


@section('content')
    <div class="container-fluid mb-4">
        <div class="row">
            <div class="col-md-12" style = "overflow-x:auto;">
                <nav class="custom-navbar navbar-light p-3" style="border-radius: 20px;">
                    <div class="custom-container">
                        <div class="custom-flex-container">
                            <div class="custom-left-content">
                                <h6 class="custom-heading">{{ trans('worker-registration/worker-family-details.reg') }}
                                </h6>
                                <h6 class="custom-bold">
                                    <i class="custom-icon fas fa-file-alt pr-2"></i>{{ trans('worker-registration/worker-family-details.appno') }} -
                                    {{ $application_no }}
                                </h6>
                            </div>
                            @include('components.session-timeout')
                        </div>
                    </div>
                </nav>
                <div class="card mt-1">
                    <div class="card-body">
                        <div class="container-fluid">
                            <div class="card rounded-card">
                                <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center"
                                     style="background-color: #248f8f;">
                                    <span>
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;
                                        {{ trans('worker-registration/worker-family-details.updatefamily') }}
                                    </span>
                                </div>
                                <div class="row ml-2 mr-2">
                                    <div class="col">
                                        <p class="text-danger"> <i class="fa fa-bullhorn"
                                                                   aria-hidden="true"></i>&nbsp;
                                            {{ trans('worker-registration/worker-family-details.mandatory') }} </p>
                                        <p style="background-color: rgb(211, 206, 206); width:50%; padding:12px">
                                            {{ trans('worker-registration/worker-family-details.familyhead') }} - {{ $getVaultData['name'] }} | {{ trans('worker-registration/worker-family-details.dateofbirth') }}
                                            - {{ $getVaultData['dob'] }}</p>
                                        <form method="post" id="dynamic_field"
                                              action="{{ route('update-family-details') }}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mt-3" style="overflow-x: auto">

                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col" class="bold">{{ trans('worker-registration/worker-family-details.serialno') }}</th>
                                                        <th scope="col" class="bold">{{ trans('worker-registration/worker-family-details.fname') }}<span
                                                                class="text-danger">*</span></th>
                                                        <th scope="col" class="bold">{{ trans('worker-registration/worker-family-details.lname') }}<span
                                                                class="text-danger">*</span></th>
                                                        <th scope="col" class="bold">{{ trans('worker-registration/worker-family-details.dob') }}<span
                                                                class="text-danger">*</span></th>
                                                        <th scope="col" class="bold">{{ trans('worker-registration/worker-family-details.age') }}</th>
                                                        <th scope="col" class="bold">{{ trans('worker-registration/worker-family-details.gname') }}</th>
                                                        <th scope="col" class="bold">{{ trans('worker-registration/worker-family-details.relation') }}
                                                            <span
                                                                class="text-danger">*</span></th>
                                                        <th scope="col" class="bold">{{ trans('worker-registration/worker-family-details.selectnominee') }}
                                                            <span class="text-danger">*</span></th>
                                                        <th scope="col" class="bold">{{ trans('worker-registration/worker-family-details.nomineeshare') }}
                                                        </th>
                                                        <th scope="col" class="bold">{{ trans('worker-registration/worker-family-details.alreadyreg') }}
                                                            <span class="text-danger">*</span></th>
                                                        <th scope="col" class="bold">BOCW ID</th>
                                                        <th scope="col" class="bold">Action</th>
                                                        <!-- Repeat headers as needed -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @php $count = count($formdata); @endphp
                                                    @foreach ($formdata as $key => $familyMember)
                                                        <tr>
                                                            <td>{{ $key + 1 }}</td>
                                                            {{--                            <input type="hidden" name="worker_id[]" value="{{$formdata->worker_id}}" class="form-control"/> --}}

                                                            <td class="fixed-width"><input type="text"
                                                                                           name="first_name[]"
                                                                                           value="{{ $familyMember->first_name }}"
                                                                                           class="form-control" />
                                                                <span class="text-danger success"
                                                                      id="first_name.0_error"></span>

                                                            </td>
                                                            <td class="fixed-width"><input type="text"
                                                                                           name="last_name[]"
                                                                                           value="{{ $familyMember->last_name }}"
                                                                                           class="form-control lastname" />

                                                                <span class="text-danger success"
                                                                      id="last_name.0_error"></span>
                                                            </td>

                                                            <td class="fixed-width"><input type="date" id="date_1"
                                                                                           data-id="1" name="dob[]"
                                                                                           class="form-control birthdate"
                                                                                           value="{{ $familyMember->dob }}"
                                                                                           onchange="calculateAge(this)"
                                                                                           max="@php echo date('Y-m-d'); @endphp" />
                                                                <span class="text-danger success"
                                                                      id="dob.0_error"></span>
                                                            </td>
                                                            <td class="fixed-width"><input type="text" data-id="1"
                                                                                           value="{{ $familyMember->age }}"
                                                                                           class="form-control age" id="age_1"
                                                                                           name="age[]" onchange="checkProf(this)"
                                                                                           readonly /></td>
                                                            <td class="fixed-width"> <input type="text"
                                                                                            name="guardain_name[]"
                                                                                            value="{{ $familyMember->guardain_name ?? '' }}"
                                                                                            class="form-control guardian-name"
                                                                    {{ $familyMember->age > 18 ? 'readonly' : '' }} />
                                                                <span class="text-danger success"
                                                                      id="guardain_name.0_error"></span>
                                                            </td>
                                                            <td class="fixed-width">
                                                                <select name="relation[]" class="form-control">
                                                                    <option value="{{ $familyMember->relation }}">
                                                                        {{ $familyMember->relation_name }}</option>
                                                                    @foreach ($relations as $index => $relation)
                                                                        <option
                                                                            value="{{ $relation->relation_code }}">
                                                                            {{ $relation->relation_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <span class="text-danger success"
                                                                      id="relation.0_error"></span>
                                                            </td>

                                                            <td class="fixed-width">
                                                                <select name="nominee[]" data-id="1"
                                                                        id="dropdown_{{ $loop->index + 1 }}"
                                                                        class="form-control nominee-input"
                                                                        onchange="togglePercentageInput({{ $loop->index + 1 }})">
                                                                    <option value="0"
                                                                            @if ($familyMember->nominee == 0) selected @endif>
                                                                        {{ trans('worker-registration/worker-family-details.no') }}</option>
                                                                    <option value="1"
                                                                            @if ($familyMember->nominee == 1) selected @endif>
                                                                        {{ trans('worker-registration/worker-family-details.yes') }}</option>
                                                                </select>
                                                                <span class="text-danger success"
                                                                      id="nominee.0_error"></span>
                                                            </td>
                                                            <td class="fixed-width">
                                                                <input type="text"
                                                                       id="percent_{{ $loop->index + 1 }}"
                                                                       name="nominee_percentage[]" data-id="1"
                                                                       value="{{ $familyMember->nominee_percentage }}"
                                                                       class="form-control percentage-input"{{ $familyMember->nominee == 0 ? 'readonly' : '' }} />
                                                                <span class="text-danger success"
                                                                      id="nominee_percentage.0_error"></span>

                                                            </td>

                                                            <td class="fixed-width">
                                                                <select name="already_registered[]"
                                                                        data-id="{{ $loop->index + 1 }}"
                                                                        id="registered_{{ $loop->index + 1 }}"
                                                                        class="form-control register-input"
                                                                        onchange="toggleBocwwbInput({{ $loop->index + 1 }})">
                                                                    <option value="0"
                                                                            @if ($familyMember->already_registered == 0) selected @endif>
                                                                        {{ trans('worker-registration/worker-family-details.no') }}</option>
                                                                    <option value="1"
                                                                            @if ($familyMember->already_registered == 1) selected @endif>
                                                                        {{ trans('worker-registration/worker-family-details.yes') }}</option>
                                                                </select>
                                                                <span class="text-danger success"
                                                                      id="already_registered.0_error"></span>
                                                            </td>
                                                            <td class="fixed-width">
                                                                <input type="text"
                                                                       class="form-control bocwwb-input"
                                                                       placeholder="BOCW ID"
                                                                       id="bocwwb_{{ $loop->index + 1 }}"
                                                                       value="{{ $familyMember->bocwwb_id ?? '' }}"
                                                                       data-id="1" name="bocwwb_id[]"
                                                                    {{ $familyMember->already_registered == 0 ? 'readonly' : '' }} />
                                                                <span class="text-danger success"
                                                                      id="bocwwb_id.0_error"></span>
                                                            </td>

                                                            <td>
                                                                <input type="hidden" name="id[]" value="1" class="record-id"><button type="button" name="remove" id=""
                                                                                                                                     class="btn btn-sm  remove"><i
                                                                        class="fa fa-trash text-danger"
                                                                        aria-hidden="true"></i></button></td>
                                                        </tr>
                                                    @endforeach
                                                    <!-- Additional rows -->
                                                    </tbody>
                                                </table>
                                            </div>
                                            <button type="button" name="add" id="add"
                                                    class="btn btn-sm btn-info mt-3"><i
                                                    class="fa fa-plus-circle"></i>&nbsp;Add New Row</button>
                                            {{--                <div class="row justify-content-center mt-3"> --}}

                                            {{--                    <div class="col-auto"> --}}
                                            {{--                        <a href="{{route('save-address')}}" class="btn btn-sm btn-warning"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp; Go To Previous</a> --}}
                                            {{--                    </div> --}}
                                            {{--                    <div class="col-auto"> --}}
                                            {{--                        <button type="submit" class="btn btn-sm btn-primary">Update & Next&nbsp;<i class="fa fa-forward" aria-hidden="true"></i></button> --}}
                                            {{--                    </div> --}}
                                            {{--                </div> --}}
                                            <div
                                                class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                                                <div class="ml-auto d-inline-block align-self-center mr-2">
{{--                                                    <a type="submit" href="{{ route('submit-worker-address-details') }}"--}}
{{--                                                       class="btn btn-sm btn-warning"><i class="fa fa-backward"--}}
{{--                                                                                         aria-hidden="true"></i>&nbsp;--}}
{{--                                                        Previous</a>--}}
                                                    <button type="submit" class="btn btn-sm btn-primary"><i
                                                            class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;
                                                        Update Family Details</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
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
    <script src="{{ URL::asset('assets/template/js/sweetAlert.js') }}"></script>
    {{-- <script src="{{URL::asset('assets/template/vendor/jquery/ajax-jquery-3.7.min.js')}}"></script> --}}
    <script>
        $(document).ready(function() {
            let count = `{{ $count }}`;
            let dynamicRowsData = @json($dynamicRowsData ?? []);

            // Function to add dynamic fields
            function dynamic_field(number, data = null) {
                let html = '<tr>';
                html += '<td>' + count + '</td>';
                html += '<input type="hidden" name="id[]" value="' + (data ? data.id : '') + '" class="row-id"/>'; // Hidden input with primary key
                html += '<td><input type="text" name="first_name[' + count + ']" value="" class="form-control" />' +
                    '<span class="text-danger success"  id="first_name.' + count + '_error"></span></td>';

                html += '<td><input type="text" name="last_name[' + count + ']" class="form-control" />' +
                    '<span class="text-danger success"  id="last_name.' + count + '_error"></span></td>';

                html += '<td><input type="date" name="dob[' + count +
                    ']" id="birthdate" class="form-control birthdate"   onchange="calculateAge(this)" max="' +
                    <?php echo json_encode(date('Y-m-d')); ?> + '" />' +
                    '<span class="text-danger success" id="dob.' + count + '_error"></span></td>';
                html += '<td><input type="text"  id="age" class="form-control age" name="age[' + count +
                    ']" readonly>' +
                    '<span class="text-danger success"  id="age.' + count + '_error"></span></td>';


                html += '<td><input type="text" name="guardain_name[' + count + ']" class="form-control"/>' +
                    '<span class="text-danger success"  id="guardain_name.' + count + '_error"></span></td>';

                html += `<td class="dropdown">
                         <select name="relation[` + count + `]" class="form-control">
                                <option value="">Select Relation</option>`;
                @foreach ($relations as $relation)
                    html +=
                    `<option value="{{ $relation->relation_code }}">{{ $relation->relation_name }}</option>`;
                @endforeach
                    html += '</select><span class="text-danger success"  id="relation.' + count +
                    '_error"></span></td>';

                html += '<td><select id="dropdown_' + number + '" name="nominee[' + count +
                    ']" class="form-control nominee-input" onchange="togglePercentageInput(' + number + ')">';
                html += '<option value="">Select</option>';
                html += '<option value="0">{{ trans('worker-registration/worker-family-details.no') }}</option>';
                html += '<option value="1">{{ trans('worker-registration/worker-family-details.yes') }}</option>';
                html += '</select><span class="text-danger success"  id="nominee.' + count + '_error"></span></td>';

                html += '<td><input type="text" id="percent_' + number + '" data-id="' + number +
                    '" name="nominee_percentage[' + count + ']" class="form-control percentage-input" readonly>' +
                    '<span class="text-danger success"  id="nominee_percentage.' + count + '_error"></span></td>';
                html += '<td><select id="registered_' + number + '" name="already_registered[' + count +
                    ']" class="form-control " onchange="toggleBocwwbInput(' + number + ')">';
                html += '<option value="">Select</option>';
                html += '<option value="0">{{ trans('worker-registration/worker-family-details.no') }}</option>';
                html += '<option value="1">{{ trans('worker-registration/worker-family-details.yes') }}</option>';
                html += '</select><span class="text-danger success"  id="already_registered.' + count +
                    '_error"></span></td>';

                html += '<td><input type="text"  name="bocwwb_id[' + count +
                    ']" placeholder="BOCW ID" class=" form-control" id="bocwwb_' + number + '" data-id="' + number +
                    '" readonly/>' +
                    '<span class="text-danger success"  id="bocwwb_id.' + count + '_error"></span></td>';
                html +=
                    '<td><button type="button" name="remove" id="" class="btn btn-sm  remove"><i class="fa fa-trash text-danger" aria-hidden="true"></i></button></td></tr>';
                $('tbody').append(html);
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
                        already_registered: $(element).find('input[name="already_registered[]"]').val(),

                    };
                    dynamicRowsData.push(rowData);
                });
                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('save-family') }}',
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            window.location.href = "{{ route('preview-renewal-application') }}";
                        } else {

                            if (response.msg === 'true') {
                                Toastify({
                                    text: 'BOCW Id already exists,cannot procced!',
                                    duration: 5000, // Duration in milliseconds
                                    close: true, // Show close button
                                    gravity: "top", // Position of the toast (top or bottom)
                                    position: "right", // Position on the screen (left, right, center)
                                    style: {
                                        background: "#FF4C4C" // Error color (e.g., red)
                                    },
                                }).showToast();
                            } else {
                                if (response.errors) {
                                    Toastify({
                                        text: 'Validation Error Found',
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
                                // console.log(response.errors.nominee_percentage)
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
                let rowId = $(this).data('id'); // Get the ID from the data attribute
                let rowElement = $(this).closest('tr'); // Reference to the table row

                if (rowId) {

                    if (confirm("Are you sure you want to delete this row?")) {
                        $.ajax({
                            url: '{{ route('delete-ex-family-member') }}',
                            method: 'POST',
                            data: {
                                id: rowId,
                                _token: '{{ csrf_token() }}' // Add CSRF token for security
                            },
                            success: function(response) {
                                if (response.success) {
                                    Toastify({
                                        text: response.message,
                                        duration: 5000, // Duration in milliseconds
                                        close: true, // Show close button
                                        gravity: "top", // Position of the toast (top or bottom)
                                        position: "right", // Position on the screen (left, right, center)
                                        style: {
                                            background: "#28a745" // Success color (e.g., green)
                                        },
                                    }).showToast();

                                    // Remove the row from the table
                                    rowElement.remove();
                                } else {
                                    Toastify({
                                        text: response.message,
                                        duration: 5000, // Duration in milliseconds
                                        close: true, // Show close button
                                        gravity: "top", // Position of the toast (top or bottom)
                                        position: "right", // Position on the screen (left, right, center)
                                        style: {
                                            background: "#FF4C4C" // Error color (e.g., red)
                                        },
                                    }).showToast();
                                }
                            },
                            error: function(xhr, status, error) {
                                Toastify({
                                    text: 'An error occurred while deleting the record.',
                                    duration: 5000, // Duration in milliseconds
                                    close: true, // Show close button
                                    gravity: "top", // Position of the toast (top or bottom)
                                    position: "right", // Position on the screen (left, right, center)
                                    style: {
                                        background: "#FF4C4C" // Error color (e.g., red)
                                    },
                                }).showToast();
                            }
                        });
                    }
                } else {
                    // If there's no ID (e.g., new row that hasn't been saved to the database yet), just remove it from the UI
                    if (confirm("Are you sure you want to remove this row?")) {
                        rowElement.remove();
                    }
                }
            });

            function updateRowNumbers() {
                $('tbody tr').each(function(index) {
                    $(this).find('td:first').text(index + 1); // Update the row number
                });
            }
        });

        $(document).on('keyup', '.percentage-input', function() {
            validatePercentages($(this).attr("id"));
        });

        function togglePercentageInput(number) {
            var dropdown = document.getElementById('dropdown_' + number);
            var percentInput = document.getElementById('percent_' + number);

            if (dropdown.value === '1') {
                percentInput.removeAttribute('readonly');
                percentInput.value = 100; // Set value to 100 when dropdown is 1
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
            console.log('Registered ID: ', 'registered_' + number);
            console.log('bocwwb Input ID: ', 'bocwwb_' + number);

            // Check if "Yes" is selected
            if (registered.value === '1') {
                bocwwbInput.removeAttribute('readonly');
            } else {
                bocwwbInput.setAttribute('readonly', 'true');
            }
        }


        document.addEventListener('DOMContentLoaded', function() {
            // Select all date input elements
            var dateInputs = document.querySelectorAll('input[type="date"]');

            // Execute calculateAge on each date input on page load
            dateInputs.forEach(function(input) {
                if (input.value) {
                    calculateAge({
                        value: input.value,
                        parentElement: input.parentElement
                    });
                }
            });

            // Attach event listener to each date input to execute calculateAge on select
            dateInputs.forEach(function(input) {
                input.addEventListener('change', function() {
                    calculateAge(input);
                });
            });
        });

        function calculateAge(input) {
            var dob = new Date(input.value);
            var currentDate = new Date();
            var age = currentDate.getFullYear() - dob.getFullYear();
            if (currentDate.getMonth() < dob.getMonth() || (currentDate.getMonth() === dob.getMonth() && currentDate
                .getDate() < dob.getDate())) {
                age--;
            }
            var ageInput = input.parentElement.nextElementSibling.querySelector('.age');
            ageInput.value = age;
            checkProf(ageInput);
            var guardianField = input.parentElement.nextElementSibling.nextElementSibling.querySelector('input');
            if (age <= 18) {
                guardianField.style.display = 'block';
                guardianField.setAttribute('required', 'required');
                guardianField.removeAttribute('disabled');
            } else {
                guardianField.style.display = 'block'; // Show the field
                guardianField.setAttribute('readonly', 'readonly');
                guardianField.value = '';
            }
        }

        function checkProf(element) {
            const age = parseInt(element.value, 10);
            console.log(age); // Debugging: Log the age value
            const parentRow = element.closest('tr');
            // const professionSelect = parentRow.querySelector('select[name^="profession"]');
            // console.log(professionSelect);

            // Disable or enable the profession field based on the age value

        }

        document.addEventListener('DOMContentLoaded', function() {
            var dobInputs = document.querySelectorAll('input[type="date"]');
            dobInputs.forEach(function(input) {
                calculateAge(input);
                input.addEventListener('change', function() {
                    calculateAge(input);
                });
            });
        });
    </script>
    <script src="{{ URL::asset('assets/template/js/toastr.min.js') }}"></script>

    <style>
        #checkbox {
            pointer-events: none;
        }
    </style>
@endsection
