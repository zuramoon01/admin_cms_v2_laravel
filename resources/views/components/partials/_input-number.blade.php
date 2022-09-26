@props(['name', 'label', 'value', 'isLabel'])

<div class="form-group">
    @if (!isset($isLabel))
        <label for="{{ $name }}">{{ $label }}</label>
    @endif
    <input type="number" class="form-control" id="{{ $name }}" name="{{ $name }}" min="0"
        value="{{ $value }}" @if (isset($isLabel)) placeholder="{{ $label }}" @endif>
</div>
