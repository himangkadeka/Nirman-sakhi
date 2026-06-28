<div class="table-responsive">
    <table class="table table-striped table-hover table-bordered">
        <thead class="thead-light">
            <tr>
                <th style="width: 35%;">Field</th>
                <th>Submitted Value</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($application->formSubmissionData as $data)
                @php
                    $field = $data->formField;
                    $value = $data->value;
                @endphp

                {{-- Skip this iteration if the field definition is missing or the value is empty/null --}}
                @if (!$field || is_null($value))
                    @continue
                @endif

                {{-- ================================================================ --}}
                {{--  This is the complete, merged logic from your second file      --}}
                {{-- ================================================================ --}}
                @if ($field->use_masterdata)
                    @php
                        // Handle multi-select checkboxes which store a JSON array of IDs
                        $decoded_values = json_decode($value, true);
                        if (is_array($decoded_values)) {
                            $displayValues = DB::table("Masterdata.{$field->masterdata_table}")
                                               ->whereIn($field->masterdata_table_key, $decoded_values)
                                               ->pluck($field->masterdata_table_value)
                                               ->toArray();
                            $value = implode(', ', $displayValues);
                        } else {
                            // It's a single value (from select, radio)
                            $displayValue = DB::table("Masterdata.{$field->masterdata_table}")
                                              ->where($field->masterdata_table_key, $value)
                                              ->value($field->masterdata_table_value);
                            // Fallback to the original ID if no matching display value is found
                            $value = $displayValue ?? $value;
                        }
                    @endphp
                @endif
                {{-- ================================================================ --}}
                {{--                       End of merged logic                      --}}
                {{-- ================================================================ --}}

                <tr>
                    <th scope="row" style="vertical-align: middle;">
                        {{ Str::headline($field->name) }}
                    </th>
                    <td style="vertical-align: middle;">
                        @switch($field->type)
                            @case('file')
                                <a href="{{ route('office.dashboard.file.show', ['data' => $data->id]) }}" target="_blank"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-2"></i>View Uploaded File
                                </a>
                                @break

                            @case('textarea')
                                <div style="white-space: pre-wrap;">{!! nl2br(e($value)) !!}</div>
                                @break

                            @case('date')
                                {{-- Added a check for valid date string before parsing --}}
                                @if(strtotime($value))
                                    {{ \Carbon\Carbon::parse($value)->format('d F, Y') }}
                                @else
                                    {{ $value ?? 'N/A' }}
                                @endif
                                @break

                            @default
                                {{-- This now correctly handles text, numbers, and the pre-formatted --}}
                                {{-- values from select, radio, and checkbox fields. --}}
                                {{ $value ?? 'N/A' }}
                        @endswitch
                    </td>
                </tr>
            @empty
                {{-- This part is shown if $application->formSubmissionData is empty --}}
                <tr>
                    <td colspan="2" class="text-center text-muted py-4">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <p class="mb-0">No submission data found for this application.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
