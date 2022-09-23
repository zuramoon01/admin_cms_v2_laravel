@props(['name', 'label', 'value'])

<div class="form-group">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" id="{{ $name }}" name="{{ $name }}" value="1"
            @if ($value === '' && $name === 'status') checked @else @checked($value) @endif>
        <label class="form-check-label" for="{{ $name }}">
            {{ $label }}
        </label>
    </div>
</div>
