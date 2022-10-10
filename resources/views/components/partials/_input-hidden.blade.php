@props(['name', 'value'])

<div class="form-group">
    <input type="hidden" class="form-control" id="{{ $name }}" name="{{ $name }}"
        value="{{ $value }}">
</div>
