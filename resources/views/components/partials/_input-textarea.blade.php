@props(['name', 'label', 'value'])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <textarea class="form-control" id="{{ $name }}" rows="3" name="{{ $name }}">{{ $value }}</textarea>
</div>
