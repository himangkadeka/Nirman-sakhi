<div class="form-check-group">
                                        @if ($field->use_masterdata)
                                            @php
                                                // Masterdata logic for radio...
                                                $options = DB::table("Masterdata.{$field->masterdata_table}")->get();
                                                $key = $field->masterdata_table_key ?? 'id';
                                                $val = $field->masterdata_table_value ?? 'name';
                                            @endphp
                                            @foreach ($options as $option)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="{{ $field->name }}"
                                                        id="{{ $field->name }}_{{ $option->$key }}"
                                                        value="{{ $option->$key }}"
                                                        @if ($finalValue == $option->$key) checked @endif
                                                        {{ $field->is_disabled ? 'disabled' : '' }}>
                                                    <label class="form-check-label"
                                                        for="{{ $field->name }}_{{ $option->$key }}">{{ $option->$val }}</label>
                                                </div>
                                            @endforeach
                                        @else
                                            @php $options = json_decode($field->options, true) ?? []; @endphp
                                            @foreach ($options as $option)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="{{ $field->name }}"
                                                        id="{{ $field->name }}_{{ $loop->index }}"
                                                        value="{{ $option }}"
                                                        @if ($finalValue == $option) checked @endif
                                                        {{ $field->is_disabled ? 'disabled' : '' }}>
                                                    <label class="form-check-label"
                                                        for="{{ $field->name }}_{{ $loop->index }}">{{ $option }}</label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
