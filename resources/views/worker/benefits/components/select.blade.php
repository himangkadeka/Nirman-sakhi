<select name="{{ $field->name }}" id="{{ $field->name }}"
    onchange="checkDependentField('{{ $field->id }}','{{ $field->name }}')"
    {{ $field->is_disabled ? 'disabled' : '' }}>
    <option value="">-- Select an Option --</option>
    @if ($field->use_masterdata)
        @php
            $query = DB::table("Masterdata.{$field->masterdata_table}");
            if (!empty($field->masterdata_table_condition)) {
                // This assumes the condition is a raw SQL string. Be cautious with this.
                $query->whereRaw($field->masterdata_table_condition);
            }
            $options = $query->get();
            $key = $field->masterdata_table_key ?? 'id';
            $val = $field->masterdata_table_value ?? 'name';
        @endphp
        @foreach ($options as $option)
            <option value="{{ $option->$key }}" @if ($finalValue == $option->$key) selected @endif>
                {{ $option->$val }}
            </option>
        @endforeach
    @else
        @php $options = json_decode($field->options, true) ?? []; @endphp
        @foreach ($options as $option)
            <option value="{{ $option }}" @if ($finalValue == $option) selected @endif>
                {{ $option }}
            </option>
        @endforeach
    @endif
</select>
