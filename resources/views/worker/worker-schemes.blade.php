@extends('layouts.user-app')

@section('title', ' Schemes')

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
            border-bottom: 2px solid black;
        }


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
    @include('components.multistep')
    <div class="container-fluid mb-4">
            <div class="col-md-12" style="overflow-x:auto;">
                <nav class="custom-navbar navbar-light" style="border-radius: 20px;">
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
                                <div class="card-header card-header-bg text-white d-flex justify-content-between align-items-center" style="background-color: #2badee;">
                                    <span>
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp; {{ trans('worker-registration/worker-schemes-details.otherschemes') }} &nbsp;|&nbsp;({{ trans('worker-registration/worker-schemes-details.appno') }} -
                                {{ $application_no }})
                                    </span>

                                </div>
                        <form method="post" id="dynamic_field" class="form-group mr-2 ml-2" action="{{ route('save-schemes-details') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-row mt-4"><!--start 1-->

                                <div class="form-group col-md-12">
                                    <label class="ml-4 bold" style="margin-bottom: 10px;font-size: 15px;"><i class="fa fa-bullhorn"
                                            aria-hidden="true"></i>&nbsp; {{ trans('worker-registration/worker-schemes-details.question') }}
                                         <i
                                            class="fa fa-question-circle" aria-hidden="true"></i></label>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="enrolled_yes" name="enrolled" value="1"
                                            class="form-check-input ml-4 @if ($errors->has('enrolled')) is-invalid @endif">
                                        <label for="enrolled_yes" class="form-check-label"
                                            style="padding-left: 5px;">{{ trans('worker-registration/worker-schemes-details.yes') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" id="enrolled_no" name="enrolled" value="0"
                                            class="form-check-input @if ($errors->has('enrolled')) is-invalid @endif">
                                        <label for="enrolled_no" class="form-check-label"
                                            style="padding-left: 5px;">{{ trans('worker-registration/worker-schemes-details.no') }}</label>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>

                            <!-- Table Section -->
                            <div id="schemeTableSection" style="display: none;" class="table-container">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="bold" >{{ trans('worker-registration/worker-schemes-details.mentionscheme') }}</th>
                                            <th scope="col" class="bold">{{ trans('worker-registration/worker-schemes-details.regno') }}</th>
                                            <th scope="col" class="bold">{{ trans('worker-registration/worker-schemes-details.regdate') }}
                                                </th>
                                            <th scope="col" class="bold">Action</th>
                                        </tr>
                                        <tr>
                                            <!-- Scheme Name field -->
                                            <td class="dropdown">
                                                <select name="scheme_name[]" class="form-control @if ($errors->has('scheme_name[]')) is-invalid @endif" id="Schemes">
                                                    <option value="">{{ trans('worker-registration/worker-schemes-details.selectscheme') }}</option>
                                                    @foreach ($schemes as $index => $scheme)
                                                        <option value="{{ $scheme->scheme_code }}">
                                                            {{ $scheme->scheme_name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-danger success" id="scheme_name.0_error"></span>
                                            </td>

                                            <!-- Registration ID field -->
                                            <td>
                                                <input type="text" name="registration_id[]" id="registrationid"
                                                    value="{{ old('registration_id.' . $index) }}" class="form-control @if ($errors->has('registration_id[]')) is-invalid @endif" />
                                                <span class="text-danger success" id="registration_id.0_error"></span>
                                            </td>

                                            <!-- Date field -->
                                            <td>
                                                <input type="date" name="date[]" id="date" value="{{ old('date.' . $index) }}"
                                                    class="form-control @if ($errors->has('date[]')) is-invalid @endif" />
                                                <span class="text-danger success" id="date.0_error"></span>
                                            </td>
                                            <td>
                                                <button type="button" name="remove" id=""
                                                    class="btn btn-sm btn-danger remove"><i class="fa fa-trash"
                                                        aria-hidden="true"></i></button>
                                            </td>

                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>

                                </table>
                                <button type="button" name="add" id="add" class="btn btn-sm btn-info mt-3"><i
                                        class="fa fa-plus-circle"></i>&nbsp;{{ trans('worker-registration/worker-schemes-details.addnew') }}</button>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-between align-items-center mb-1 clearfix mt-4">
                                <div class="ml-auto d-inline-block align-self-center mr-2">
                                    <a type="submit" href="{{route('submit-family-details')}}"
                                       class="btn btn-sm btn-warning"><i class="fa fa-backward" aria-hidden="true"></i>&nbsp;
                                       {{ trans('worker-registration/worker-schemes-details.previous') }}</a>
                                    <button type="submit"
                                            class="btn btn-sm btn-primary"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;
                                            {{ trans('worker-registration/worker-schemes-details.saveschemes') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>


@endsection


@section('footer')

    <script src="{{ URL::asset('assets/template/vendor/jquery/ajax-jquery-3.7.min.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/worker-schemes-styles.js') }}"></script>
    <script src="{{ URL::asset('assets/template/js/session-timeout.js') }}"></script>
    <script>
        function updateMaxAttribute() {
            var today = new Date().toISOString().split('T')[0];
            $('input[type="date"]').each(function() {
                $(this).attr('max', today);
            });
        }
        updateMaxAttribute();
    </script>

    <script>
        $(document).ready(function() {
            const currentDate = '<?php echo date('Y-m-d'); ?>';
            let count = 1;
            let dynamicRowsData = [];

            function dynamic_field(data = null)  {
                html = '<tr>';
                html += `<td class="dropdown">
            <select name="scheme_name[` + count + `]" class="form-control">
                <option value="">{{ trans('worker-registration/worker-schemes-details.selectscheme') }}</option>`;

                @foreach ($schemes as $scheme)
                    html += ` <option value="{{ $scheme->scheme_code }}">{{ $scheme->scheme_name }}</option>`;
                @endforeach

                html += '</select><span class="text-danger success"  id="scheme_name.' + count +
                    '_error"></span>' +
                    '</td>';
                html += ' <td><input type="text" name="registration_id[' + count + ']"  id="registration_id[]" class="form-control " />' +
                    '<span class="text-danger success"  id="registration_id.' + count + '_error"></span></td>\';</td>'


                    html += '<td><input type="date" name="date[' + count + ']" id="date' + count + '" data-id="' + count + '" class="form-control" max="' + currentDate + '" />' +
                    '<span class="text-danger success"  id="date.' + count + '_error"></span></td>';

                html +=
                    '<td><button type="button" name="remove" id="" class="btn btn-sm btn-danger remove"><i class="fa fa-trash" aria-hidden="true"></i></button></td></tr>';
                $('tbody').append(html);
                count++;
            }
            $('#dynamic_field').submit(function(event) {
                event.preventDefault();
                $('.success').html('');
                const formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('save-schemes-details') }}",
                    method: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            console.log(response.success)
                            window.location.href = "{{ route('submit-schemes-details') }}";
                        }  else{
                            console.log(response)
                                    $.each(response.errors, function(field, messages) {
                                        var escapedKey = field.replace('.', '\\.');
                                        console.log(escapedKey)
                                        $("#" + escapedKey + '_error').html(messages[
                                            0]);
                                    });
                                }
                    },
                    error: function (xhr, status, error) {

                        alert('An error occurred while processing your request.');
                    }
                });
            });

            $(document).on('click', '#add', function() {

                dynamic_field(count);
            });

            $(document).on('click', '.remove', function() {
                // count--;
                $(this).closest("tr").remove();
            });
        });
        $('input[name="enrolled"]').on('change', function() {
            if ($(this).val() == '1') {
                $('#schemeTableSection').show();
            } else {
                $('#schemeTableSection').hide();
            }
        });

    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const enrolledRadioYes = document.getElementById('enrolled_yes');
            const enrolledRadioNo = document.getElementById('enrolled_no');
            const schemeTableSection = document.getElementById('schemeTableSection');
            const schemeNameInputs = document.querySelectorAll('select[name="scheme_name[]"]');
            const registrationIdInputs = document.querySelectorAll('input[name="registration_id[]"]');
            const dateInputs = document.querySelectorAll('input[name="date[]"]');

            // Function to populate the form with old values
            function populateFormWithOldValues() {
                // Get old values from localStorage if available
                const oldValues = JSON.parse(localStorage.getItem('formValues')) || {};

                // Populate scheme name, registration ID, and date fields with old values
                schemeNameInputs.forEach(function(input, index) {
                    input.value = oldValues.schemeNames ? oldValues.schemeNames[index] : '';
                });
                registrationIdInputs.forEach(function(input, index) {
                    input.value = oldValues.registrationIds ? oldValues.registrationIds[index] : '';
                });
                dateInputs.forEach(function(input, index) {
                    input.value = oldValues.dates ? oldValues.dates[index] : '';
                });
            }

            // Check if user selected "Yes" previously and populate the form with old values
            if (enrolledRadioYes.checked) {
                schemeTableSection.style.display = 'block';
                populateFormWithOldValues();
            }

            // Event listener for "Yes" radio button
            enrolledRadioYes.addEventListener('change', function() {
                if (this.checked) {
                    schemeTableSection.style.display = 'block';
                    populateFormWithOldValues();
                } else {
                    schemeTableSection.style.display = 'none';
                    // Clear saved form values when "No" is selected
                    localStorage.removeItem('formValues');
                }
            });

            // Event listener for "No" radio button
            enrolledRadioNo.addEventListener('change', function() {
                schemeTableSection.style.display = 'none';
                // Clear saved form values when "No" is selected
                localStorage.removeItem('formValues');
            });

            // Event listener to save form values when input fields change
            [...schemeNameInputs, ...registrationIdInputs, ...dateInputs].forEach(function(input) {
                input.addEventListener('change', saveFormValuesToLocalStorage);
            });

            // Remove saved form values when the form is submitted successfully
            document.getElementById('dynamic_field').addEventListener('submit', function() {
                localStorage.removeItem('formValues');
            });

            // Function to save current form values to localStorage
            function saveFormValuesToLocalStorage() {
                const schemeNames = [];
                const registrationIds = [];
                const dates = [];

                // Save scheme name, registration ID, and date values
                schemeNameInputs.forEach(function(input) {
                    schemeNames.push(input.value);
                });
                registrationIdInputs.forEach(function(input) {
                    registrationIds.push(input.value);
                });
                dateInputs.forEach(function(input) {
                    dates.push(input.value);
                });

                // Save values to localStorage
                localStorage.setItem('formValues', JSON.stringify({
                    schemeNames: schemeNames,
                    registrationIds: registrationIds,
                    dates: dates
                }));
            }
        });
    </script>


    <script src="{{ URL::asset('assets/template/js/sweetAlert.js') }}"></script>


@endsection
