@php
$url = request()
    ->route()
    ->getPrefix();
$categoryValue = '';
$descriptionValue = '';

if (count(old()) > 0) {
    $categoryValue = old('category');
    $descriptionValue = old('description');
} elseif (isset($productCategory)) {
    $categoryValue = $productCategory->category;
    $descriptionValue = $productCategory->description;
}

if (isset($productCategory)) {
    $url = "$url/$productCategory->id";
}

$routeName = explode(
    '.',
    request()
        ->route()
        ->getName(),
);
$routeType = $routeName[count($routeName) - 1];

if ($routeType === 'add') {
    $button = [
        'name' => 'Create',
        'type' => 'primary',
    ];
} elseif ($routeType === 'edit') {
    $button = [
        'name' => 'Edit',
        'type' => 'warning',
    ];
}
@endphp

<x-dashboard :menus="$menus">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ Str::ucfirst($routeType) . " $heading" }}</h1>

    <x-partials._form :action="url($url)">
        <x-slot:method>
            @isset($productCategory)
                @method('put')
            @endisset
        </x-slot:method>

        <div class="col-lg-6 d-flex flex-column">
            @foreach ($formInputs as $input)
                @php
                    if ($input['name'] === 'category') {
                        $value = $categoryValue;
                    } elseif ($input['name'] === 'description') {
                        $value = $descriptionValue;
                    }
                @endphp

                @if ($input['type'] === 'text')
                    <x-partials._input-text :name="$input['name']" :label="$input['label']" :value="$value" />
                @elseif($input['type'] === 'textarea')
                    <x-partials._input-textarea :name="$input['name']" :label="$input['label']" :value="$value" />
                @endif
            @endforeach

            <button type="submit" class="btn btn-{{ $button['type'] }} align-self-end">{{ $button['name'] }}</button>
        </div>
    </x-partials._form>

</x-dashboard>
