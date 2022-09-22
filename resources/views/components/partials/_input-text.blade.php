@props(['name', 'label', 'value'])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="text" class="form-control" id="{{ $name }}" name="{{ $name }}"
        value="{{ $value }}">
</div>
