<input type="file" name="{{ $field->name }}" id="{{ $field->name }}">
@if ($submittedValue)
    <div class="mt-1"><small class="text-success">Previously Uploaded: <a
                href="{{ asset('storage/' . $submittedValue) }}"
                target="_blank">{{ basename($submittedValue) }}</a></small></div>
@endif
