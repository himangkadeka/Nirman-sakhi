@php
                                        $checkedOptions = is_array($finalValue)
                                            ? $finalValue
                                            : json_decode($finalValue ?: '[]', true);
                                    @endphp
                                    <div class="form-check-group">
                                        @if ($field->use_masterdata)
                                            @php
                                                // Masterdata logic for checkbox...
                                                $options = DB::table("Masterdata.{$field->masterdata_table}")->get();
                                                $key = $field->masterdata_table_key ?? 'id';
                                                $val = $field->masterdata_table_value ?? 'name';
                                            @endphp
                                            @foreach ($options as $option)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="{{ $field->name }}[]"
                                                        id="{{ $field->name }}_{{ $option->$key }}"
                                                        value="{{ $option->$key }}"
                                                        @if (in_array($option->$key, $checkedOptions)) checked @endif
                                                        {{ $field->is_disabled ? 'disabled' : '' }}>
                                                    <label class="form-check-label"
                                                        for="{{ $field->name }}_{{ $option->$key }}">{{ $option->$val }}</label>
                                                </div>
                                            @endforeach
                                        @else
                                            @php $options = json_decode($field->options, true) ?? []; @endphp
                                            @foreach ($options as $option)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="{{ $field->name }}[]"
                                                        id="{{ $field->name }}_{{ $loop->index }}"
                                                        value="{{ $option }}"
                                                        @if (in_array($option, $checkedOptions)) checked @endif
                                                        {{ $field->is_disabled ? 'disabled' : '' }}>
                                                    <label class="form-check-label"
                                                        for="{{ $field->name }}_{{ $loop->index }}">{{ $option }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
