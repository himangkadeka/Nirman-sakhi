@if ($benefit->benefit_code == 'EA' || $benefit->benefit_code == 'DB' || $benefit->benefit_code == 'FA')
    @if ($field->name == 'address')
        @php
            $addressParts = [
                $data['applicantVaultDetails']['careOf'],
                $data['applicantVaultDetails']['buildingName'],
                $data['applicantVaultDetails']['street'],
                $data['applicantVaultDetails']['locality'],
                $data['applicantVaultDetails']['subDistrict'],
                $data['applicantVaultDetails']['district'],
                $data['applicantVaultDetails']['state'],
                $data['applicantVaultDetails']['pinCode'],
            ];
        @endphp
        <textarea name="{{ $field->name }}" id="{{ $field->name }}" readonly>{{ implode(', ', array_filter($addressParts)) }}</textarea>
    @elseif ($field->name == 'full_address_of_deceased_worker')
        @php
            $addressParts = [
                $getVaultData['careOf'],
                $getVaultData['buildingName'],
                $getVaultData['street'],
                $getVaultData['locality'],
                $getVaultData['subDistrict'],
                $getVaultData['district'],
                $getVaultData['state'],
                $getVaultData['pinCode'],
            ];
        @endphp
        <textarea name="{{ $field->name }}" id="{{ $field->name }}" readonly>{{ implode(', ', array_filter($addressParts)) }}</textarea>
    @else
        <textarea name="{{ $field->name }}" id="{{ $field->name }}" {{ $field->is_readonly ? 'readonly' : '' }}>{{ $finalValue }}</textarea>
    @endif
@else
    <textarea name="{{ $field->name }}" id="{{ $field->name }}" {{ $field->is_readonly ? 'readonly' : '' }}>{{ $finalValue }}</textarea>
@endif
