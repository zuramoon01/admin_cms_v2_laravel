@props(['name', 'label', 'routeType', 'isLabel'])

<div class="form-group">
    @if (!isset($isLabel))
        <label for="{{ $name }}">{{ $label }}</label>
    @endif
    <select id="{{ $name }}" class="form-control" name="{{ $name }}">
        <option @selected($routeType === 'add')>Choose {{ $label }}</option>

        {{ $slot }}
    </select>
</div>
