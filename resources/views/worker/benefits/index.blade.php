@include('layout.workerheader')

{{-- 1. Using the improved CSS for a better look --}}
<style>
    .benefit-heading {
        margin: 15px 30px 0;
        background: #38393a;
        padding: 15px 30px;
        border-radius: 15px 15px 0 0;
        color: white;
    }

    .benefit-heading h3 {
        margin: 0;
        font-size: 21px;
        font-weight: 500;
    }

    .benefits-sec {
        background: #f8f9fa;
        padding: 20px 30px 30px;
        margin: 0px 30px 30px;
        border-radius: 0 0 15px 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        border: 1px solid #dee2e6;
    }

    .myrow {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 25px;
    }

    .form_control {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form_control label {
        font-size: 15px;
        font-weight: 500;
        color: #495057;
    }

    .form_control label .required-star {
        color: #dc3545;
        font-weight: bold;
    }

    .myrow input[type="text"],
    .myrow input[type="number"],
    .myrow input[type="date"],
    .myrow input[type="file"],
    .myrow textarea,
    .myrow select {
        width: 100%;
        height: 45px;
        padding: 10px 15px;
        font-size: 16px;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 6px;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }

    .myrow textarea {
        height: auto;
        min-height: 90px;
    }

    .myrow input:focus,
    .myrow textarea:focus,
    .myrow select:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, .25);
    }

    .myrow input[readonly] {
        background-color: #e9ecef;
        opacity: 1;
    }

    .form-check-group {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        padding: 10px 0;
        border-bottom: 1px solid #ced4da;
        min-height: 45px;
        align-items: center;
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .form-check input[type="radio"],
    .form-check input[type="checkbox"] {
        width: 1.15em;
        height: 1.15em;
        cursor: pointer;
    }

    .form-check label {
        margin-bottom: 0;
        font-weight: normal;
        cursor: pointer;
    }

    #benefit-btn {
        padding-top: 20px;
        border-top: 1px solid #dee2e6;
        margin-top: 30px;
        display: flex;
        justify-content: center;
        gap: 20px;
    }

    #benefit-btn button {
        min-width: 180px;
        padding: 12px;
        font-size: 16px;
        font-weight: bold;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease-in-out;
    }

    #benefit-btn button:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    }
</style>

<div class="d-flex" id="wrapper">
    @include('worker.leftmenu')
    <div id="page-content-wrapper">
        @include('components.worker.ui.navbar')

        <div class="benefit-heading">
            <h3>{{ $benefit->name }} - {{ $submission->application_id }}</h3>

        </div>

        <section class="benefits-sec">
            @if ($errors->any())
                <div class="alert alert-danger" style="font-size: 14px; padding: 10px; margin: 10px 0;">
                    Please fix the errors marked below.
                    {{ $errors->first() }}
                </div>
            @endif
            <form action="{{ route('worker.submit-form', [$benefit->id, $submission->application_id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="myrow">
                    @foreach ($benefit->formFields as $field)
                        @php
                            $submittedValue = $submittedData[$field->id] ?? null;
                            $prefilledValue = '';
                            if ($field->use_prefilled_data) {
                                if ($field->prefilled_data_type == 1) {
                                    $prefilledValue = $getVaultData[$field->prefilled_vault_data_key] ?? '';
                                } else {
                                    // This logic was flawed, it needs to check for existence first
                                    $workerRecord = DB::table("Worker.{$field->prefilled_worker_data_table}")
                                        ->where('worker_id', $wmf->worker_id)
                                        ->first();
                                    if ($workerRecord) {
                                        $val = $workerRecord->{$field->prefilled_worker_data_key};
                                        if ($field->use_masterdata_value) {
                                            $masterVal = DB::table("Masterdata.{$field->masterdata_value_table}")
                                                ->where($field->masterdata_value_table_key, $val)
                                                ->first();
                                            $val = $masterVal
                                                ? $masterVal->{$field->masterdata_value_table_value}
                                                : $val;
                                        }
                                        $prefilledValue = $val;
                                    }
                                }
                            }
                            $finalValue = old($field->name, $submittedValue ?? $prefilledValue);
                        @endphp

                        <div class="form_control" style="display: {{ $field->is_dependent_field ? 'none' : 'block' }};"
                            id="fc_{{ $field->name }}">
                            <label for="{{ $field->name }}">
                                {{ Str::headline($field->name) }}
                                @if ($field->is_required)
                                    <span class="required-star">*</span>
                                @endif
                            </label>

                            @switch($field->type)
                                @case('text')
                                    @include('worker.benefits.components.text')
                                @break

                                @case('number')
                                @case('date')
                                    @include('worker.benefits.components.date')
                                @break

                                @case('textarea')
                                   @include('worker.benefits.components.textarea')
                                @break

                                @case('select')
                                    @include('worker.benefits.components.select')
                                @break

                                @case('radio')
                                    @include('worker.benefits.components.radio')
                                @break

                                @case('checkbox')
                                    @include('worker.benefits.components.checkbox')
                                @break

                                @case('file')
                                    @include('worker.benefits.components.file')
                                @break

                                {{-- ========================================================= --}}
                                {{-- == START: NEW CASE FOR PREFILLED TABLE                  == --}}
                                {{-- ========================================================= --}}
                                @case('prefilled_table')
                                    @include('worker.benefits.components.table')
                                @break

                                {{-- ========================================================= --}}
                                {{-- == END: NEW CASE FOR PREFILLED TABLE                    == --}}
                                {{-- ========================================================= --}}
                            @endswitch
                            @error($field->name)
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <div class="row d-flex justify-content-center" id="benefit-btn">
                    <button type="submit" name="action" value="draft" class="btn btn-secondary">Save as
                        Draft</button>
                    <button type="submit" name="action" value="preview" class="btn btn-primary">Save and
                        Preview</button>
                </div>
            </form>
        </section>
    </div>
</div>

<script>
    function checkDependentField(fieldId, fieldName) {
        let selectedValue = null;

        const element = document.querySelector(`[name="${fieldName}"]`);

        if (!element) return;

        if (element.type === 'radio') {
            const checkedRadio = document.querySelector(`input[name="${fieldName}"]:checked`);
            selectedValue = checkedRadio ? checkedRadio.value : null;
        } else if (element.type === 'checkbox') {
            // Get all checked values for checkboxes with the same name
            const checkedBoxes = document.querySelectorAll(`input[name="${fieldName}"]:checked`);
            selectedValue = Array.from(checkedBoxes).map(cb => cb.value);
        } else if (element.tagName === 'SELECT') {
            selectedValue = element.value;
        } else {
            selectedValue = element.value;
        }

        if (!selectedValue || (Array.isArray(selectedValue) && selectedValue.length === 0)) return;

        $.ajax({
            url: "{{ route('worker.get-dependent-field') }}",
            type: "POST",
            data: {
                fieldId: fieldId,
                selectedValue: selectedValue,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.status) {
                    response.results.forEach(function(result) {
                        if (result.dependent_field_value == selectedValue || (Array.isArray(
                                selectedValue) && selectedValue.includes(result
                                .dependent_field_value))) {
                            $("#" + result.name).closest('.form_control').show();
                        } else {
                            $("#" + result.name).closest('.form_control').hide();
                        }
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    }
</script>

@include('components.footer')

<script src="{{ asset('assets/template/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/template/js/getVaultData.js') }}"></script>
<script src="{{ asset('assets/template/js/sweetAlert.js') }}"></script>
