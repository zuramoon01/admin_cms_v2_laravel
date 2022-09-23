@props(['name', 'label', 'routeType'])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <select id="{{ $name }}" class="form-control" name="{{ $name }}">
        <option @selected($routeType === 'add')>Choose {{ $label }}</option>

        {{ $slot }}
    </select>
</div>
