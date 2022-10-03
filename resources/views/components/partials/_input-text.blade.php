@props(['name', 'label', 'value', 'isLabel'])

<div class="form-group">
    @if (!isset($isLabel))
        <label for="{{ $name }}">{{ $label }}</label>
    @endif
    <input type="text" class="form-control" id="{{ $name }}" name="{{ $name }}"
        value="{{ $value }}" @if (!$isLabel) placeholder="{{ $label }}" @endif>
</div>
