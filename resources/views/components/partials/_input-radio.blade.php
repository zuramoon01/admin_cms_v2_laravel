@props(['name', 'label', 'no', 'value', 'oldValue'])

<div class="form-check form-check-inline">
    <input class="form-check-input" type="radio" name="{{ $name }}" id="{{ $name }}{{ $no }}"
        value="{{ $value }}" @checked($value == $oldValue) onclick="changeDiscType(this)">
    <label class="form-check-label" for="{{ $name }}{{ $no }}">{{ $label }}</label>
</div>
