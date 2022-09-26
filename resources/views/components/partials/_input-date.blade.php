@props(['name', 'label', 'value'])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="date" class="form-control" id="{{ $name }}" name="{{ $name }}"
        value="{{ $value }}">
</div>
