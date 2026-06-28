@if ($benefit->benefit_code == 'EA')
    @if ($field->name == 'name_of_student')
        <input type="{{ $field->type }}" name="{{ $field->name }}" id="{{ $field->name }}"
            value="{{ $data['applicantVaultDetails']['name'] }}" readonly>
    @elseif($field->name == 'age_of_student')
        <input type="{{ $field->type }}" name="{{ $field->name }}" id="{{ $field->name }}"
            value="{{ \Carbon\Carbon::parse($data['applicantVaultDetails']['dob'])->age }}" readonly>
    @else
        <input type="{{ $field->type }}" name="{{ $field->name }}" id="{{ $field->name }}"
            value="{{ $finalValue }}" {{ $field->is_readonly || $field->use_prefilled_data ? 'readonly' : '' }}>
    @endif


@elseif($benefit->benefit_code == 'DB' || $benefit->benefit_code == 'FA')
    @if ($field->name == 'name_of_the_applicant')
        <input type="{{ $field->type }}" name="{{ $field->name }}" id="{{ $field->name }}"
            value="{{ $data['applicantVaultDetails']['name'] }}" readonly>
    @elseif($field->name == 'age_of_deceased_worker')
        <input type="{{ $field->type }}" name="{{ $field->name }}" id="{{ $field->name }}"
            value="{{ \Carbon\Carbon::parse($getVaultData['dob'])->age }}" readonly>
    @else
        <input type="{{ $field->type }}" name="{{ $field->name }}" id="{{ $field->name }}"
            value="{{ $finalValue }}" {{ $field->is_readonly || $field->use_prefilled_data ? 'readonly' : '' }}>
    @endif



@else
    <input type="{{ $field->type }}" name="{{ $field->name }}" id="{{ $field->name }}"
        value="{{ $finalValue }}" {{ $field->is_readonly || $field->use_prefilled_data ? 'readonly' : '' }}>
@endif
