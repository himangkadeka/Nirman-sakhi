@if ($benefit->benefit_code == 'EA' && $field->name == 'date_of_birth_of_student')
    <input type="{{ $field->type }}" name="{{ $field->name }}" id="{{ $field->name }}"
        value="{{ \Carbon\Carbon::parse($data['applicantVaultDetails']['dob'])->format('Y-m-d') }}" readonly>
@else
    <input type="{{ $field->type }}" name="{{ $field->name }}" id="{{ $field->name }}" value="{{ $finalValue }}"
        {{ $field->is_readonly || $field->use_prefilled_data ? 'readonly' : '' }}>
@endif
