@extends('layouts.admin-app')


@section('title', 'Admin | Benefits | Form')
@section('breadcrumb_item_1', 'Form Fields')
@section('breadcrumb_item_2', $benefit_details->name)

@section('content')
    <div class="container-fluid">
        <h4 class="text-left mb-3 ml-5 b-latest-data">ADD FORM INPUT FIELD</h4>

        @include('admin.benefits.forms.create')

        <div class="col-md-12 p-5 table-responsive">
            <h4>Forms:: {{ $benefit_details->name }}</h4>
            <table id="abaocTable" class="table table-bordered text-nowrap display nowrap">
                <thead class="thead-dark">
                    <tr>
                        <th style="max-width: 10px">#</th>
                        <th>Input Field Name</th>
                        <th>Input Type</th>
                        <th>Validation</th>
                        <th>Error Messages</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="sortable">
                    @foreach ($fields as $field)
                        <tr data-id="{{ $field->id }}">
                            <td class="text-center"><i class="fas fa-grip-horizontal handle" style="cursor: grab;"></i></td>
                            <td>{{ $field->name }}</td>
                            <td>{{ $field->type }}</td>
                            <td>
                                @if ($field->validation_rules && ($decodedRules = json_decode($field->validation_rules, true)) !== null)
                                    @foreach ($decodedRules as $rule => $value)
                                        <span>&#8226;</span> {{ $rule }} =>
                                        {{ is_bool($value) ? ($value ? 'true' : 'false') : $value }}
                                        <br>
                                    @endforeach
                                @else
                                    N/A
                                @endif

                            </td>
                            <td>
                                @if ($field->error_messages && ($decodedErrors = json_decode($field->error_messages, true)) !== null)
                                    @foreach ($decodedErrors as $error => $messages)
                                        <span>&#8226;</span> {{ $error }} => {{ $messages }}
                                        <br>
                                    @endforeach
                                @else
                                    N/A
                                @endif

                            </td>
                            <td>{{ $field->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{ URL::asset('assets/template/vendor/jquery/jquery-1.12.1.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".sortable").sortable({
                handle: ".handle",
                update: function(event, ui) {
                    let orderData = [];
                    $(".sortable tr").each(function(index) {
                        orderData.push({
                            id: $(this).data("id"),
                            order: index + 1
                        });
                    });

                    $.ajax({
                        url: "{{ route('admin.benefit-form.updateOrder') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            orderData: orderData
                        },
                        success: function(response) {
                            if (response.success) {
                                // Optional: show a success message
                            } else {
                                alert("Error updating order.");
                            }
                        }
                    });
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            function toggleOptionsAndMasterdata() {
                let inputType = $('#input_type').val();
                let isSelectable = inputType === 'select' || inputType === 'checkbox' || inputType === 'radio';

                // Show or hide the options field for selectable inputs
                if (isSelectable) {
                    $('#options_container').removeClass('d-none');
                    $('#use_masterdata').closest('.form-group').show();
                } else {
                    $('#options_container').addClass('d-none');
                    $('#field_options').val('');
                    $('#use_masterdata').prop('checked', false).closest('.form-group').hide();
                    $('#masterdata_table_section, #masterdata_table_key_section, #masterdata_table_value_section, #masterdata_table_condition_section').hide();
                }

                // Enable or disable the "Use Masterdata" checkbox
                $('#use_masterdata').prop('disabled', !isSelectable);

                // --- NEW LOGIC FOR PREFILLED TABLE ---
                // Show or hide the Prefilled Table configuration section
                if (inputType === 'prefilled_table') {
                    $('#prefilled_table_config_section').show();
                } else {
                    $('#prefilled_table_config_section').hide();
                }
                // --- END OF NEW LOGIC ---
            }

            // On Input Type change, run the toggle function
            $('#input_type').on('change', function() {
                toggleOptionsAndMasterdata();
            });

            // On Masterdata checkbox change
            $('#use_masterdata').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#masterdata_table_section').show();
                    $('#masterdata_table_condition_section').show();
                    $('#options_container').addClass('d-none');
                    $('#field_options').val('');
                } else {
                    $('#masterdata_table_section, #masterdata_table_key_section, #masterdata_table_value_section, #masterdata_table_condition_section').hide();
                }
            });

            // Initial check on page load
            toggleOptionsAndMasterdata();

            // Fetch Masterdata keys/values
            $("#masterdata_table").on('change', function() {
                var table_name = $(this).val();

                if (!table_name) {
                    $("#masterdata_table_key").html('<option value="">-- Select Key --</option>').parent().hide();
                    $("#masterdata_table_value").html('<option value="">-- Select Value --</option>').parent().hide();
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.benefit-form.get-key-value') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        table_name: table_name
                    },
                    success: function(response) {
                        if (response.status) {
                            var keyOptions = '<option value="">-- Select Key --</option>';
                            var valueOptions = '<option value="">-- Select Value --</option>';

                            response.results.forEach(function(column) {
                                keyOptions += `<option value="${column}">${column}</option>`;
                                valueOptions += `<option value="${column}">${column}</option>`;
                            });

                            $("#masterdata_table_key").html(keyOptions).parent().show();
                            $("#masterdata_table_value").html(valueOptions).parent().show();

                        } else {
                            console.log(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const usePrefilledData = document.getElementById("use_prefilled_data");
            const prefilledDataTypeSection = document.getElementById("prefilled_data_type_section");
            const prefilledDataType = document.getElementById("prefilled_data_type");
            const vaultDataKeySection = document.getElementById("prefilled_vault_data_key_section");
            const workerDataTableSection = document.getElementById("prefilled_worker_data_table_section");
            const workerDataKeySection = document.getElementById("prefilled_worker_data_key_section");
            const useMasterDataValueSection = document.getElementById("use_masterdata_value_section");
            const useMasterDataValueCheckBox = document.getElementById("use_masterdata_value");

            function toggleSections() {
                if (usePrefilledData.checked) {
                    prefilledDataTypeSection.style.display = "block";
                } else {
                    prefilledDataTypeSection.style.display = "none";
                    vaultDataKeySection.style.display = "none";
                    workerDataTableSection.style.display = "none";
                    workerDataKeySection.style.display = "none";
                }
            }

            function toggleDataFields() {
                if (prefilledDataType.value === "1") { // Vault Data selected
                    vaultDataKeySection.style.display = "block";
                    workerDataTableSection.style.display = "none";
                    workerDataKeySection.style.display = "none";
                    useMasterDataValueSection.style.display = "none";
                    useMasterDataValueCheckBox.disabled = true;
                } else if (prefilledDataType.value === "2") { // Worker Data selected
                    vaultDataKeySection.style.display = "none";
                    workerDataTableSection.style.display = "block";
                    workerDataKeySection.style.display = "block";
                    useMasterDataValueSection.style.display = "block";
                    useMasterDataValueCheckBox.disabled = false;
                } else {
                    vaultDataKeySection.style.display = "none";
                    workerDataTableSection.style.display = "none";
                    workerDataKeySection.style.display = "none";
                    useMasterDataValueSection.style.display = "none";
                    useMasterDataValueCheckBox.disabled = true;
                }
            }

            // Event Listeners
            usePrefilledData.addEventListener("change", toggleSections);
            prefilledDataType.addEventListener("change", toggleDataFields);

            // Initialize on page load
            toggleSections();
            toggleDataFields();

            $("#prefilled_worker_data_table").on('change', function() {
                var table_name = $(this).val();
                if (!table_name) {
                    $("#prefilled_worker_data_key").html('<option value="">-- Select Worker Data Key --</option>').parent().hide();
                    return;
                }
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.benefit-form.get-worker-key-value') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        table_name: table_name
                    },
                    success: function(response) {
                        if (response.status) {
                            var keyOptions = '<option value="">-- Select Worker Data Key --</option>';
                            response.results.forEach(function(column) {
                                keyOptions += `<option value="${column}">${column}</option>`;
                            });
                            $("#prefilled_worker_data_key").html(keyOptions).parent().show();
                        } else {
                            console.log(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });

            $('#use_masterdata_value').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#masterdata_value_table_section').show();
                    $('#options_container').addClass('d-none');
                    $('#field_options').val('');
                } else {
                    $('#masterdata_value_table_section, #masterdata_table_prefilled_key_section, #masterdata_table_prefilled_value_section').hide();
                }
            });

            $("#masterdata_value_table").on('change', function() {
                var table_name = $(this).val();

                if (!table_name) {
                    $("#masterdata_table_prefilled_key").html('<option value="">-- Select Key --</option>').parent().hide();
                    $("#masterdata_table_prefilled_value").html('<option value="">-- Select Value --</option>').parent().hide();
                    return;
                }

                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.benefit-form.get-key-value') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        table_name: table_name
                    },
                    success: function(response) {
                        if (response.status) {
                            var keyOptions = '<option value="">-- Select Key --</option>';
                            var valueOptions = '<option value="">-- Select Value --</option>';
                            response.results.forEach(function(column) {
                                keyOptions += `<option value="${column}">${column}</option>`;
                                valueOptions += `<option value="${column}">${column}</option>`;
                            });
                            $("#masterdata_table_prefilled_key").html(keyOptions).parent().show();
                            $("#masterdata_table_prefilled_value").html(valueOptions).parent().show();
                        } else {
                            console.log(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>

    <script>
        document.getElementById("use_dependent_field").addEventListener("change", function() {
            let selectFieldContainer = document.getElementById("select_field_container");
            let selectFieldDetailsContainer = document.getElementById("select_field_details_container");
            var form_id = "{{ $benefit_details->id }}";
            if (this.checked) {
                $.ajax({
                    type: 'POST',
                    url: "{{ route('admin.benefit-form.get-field-have-options') }}",
                    data: {
                        _token: '{{ csrf_token() }}',
                        form_id: form_id
                    },
                    success: function(response) {
                        if (response.status == true) {
                            var keyOptions = '<option value="">-- Select Field Name --</option>';
                            response.results.forEach(function(column) {
                                keyOptions += `<option value="${column.id}">${column.name}</option>`;
                            });
                            $("#select_dependent_field").html(keyOptions).parent().show();
                        } else {
                            console.log(response.results)
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                    }
                });
                selectFieldContainer.style.display = "block";
            } else {
                selectFieldContainer.style.display = "none";
                selectFieldDetailsContainer.style.display = "none";
            }
        });

        document.getElementById("select_dependent_field").addEventListener("change", function() {
            let selectFieldDetailsContainer = document.getElementById("select_field_details_container");
            if ($("#select_dependent_field").val() !== null) {
                var field_id = ($("#select_dependent_field").val());
                $.ajax({
                        type: 'POST',
                        url: "{{ route('admin.benefit-form.get-field-options') }}",
                        data: {
                            _token: '{{ csrf_token() }}',
                            field_id: field_id
                        },
                        success: function(response) {
                            if (response.status == true) {
                                var keyOptions = '<option value="">-- Select Field Name --</option>';
                                response.results.forEach(function(column) {
                                    keyOptions += `<option value="${column.key}">${column.value}</option>`;
                                });
                                $("#select_dependent_field_details").html(keyOptions).parent().show();
                            } else {
                                console.log(response.results);
                            }
                        }
                    }),
                    selectFieldDetailsContainer.style.display = "block";
            } else {
                selectFieldDetailsContainer.style.display = "none";
            }
        });
    </script>
@endsection
