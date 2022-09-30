@php
$url = request()
    ->route()
    ->getPrefix();
$codeValue = '';
$typeValue = '';
$discValueValue = '';
$startDateValue = '';
$endDateValue = '';
$statusValue = '';

if (count(old()) > 0) {
    $codeValue = old('code');
    $typeValue = old('type');
    $discValueValue = old('disc_value');
    $startDateValue = old('start_date');
    $endDateValue = old('end_date');
    $statusValue = old('status');
} elseif (isset($voucher)) {
    $codeValue = $voucher->code;
    $typeValue = $voucher->type;
    $discValueValue = $voucher->disc_value;
    $startDateValue = $voucher->start_date;
    $endDateValue = $voucher->end_date;
    $statusValue = $voucher->status;
}

if (isset($voucher)) {
    $url = "$url/$voucher->id";
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
            @isset($voucher)
                @method('put')
            @endisset
        </x-slot:method>

        @foreach ($formInputs as $i => $inputs)
            <div class="col-lg-6 @if ($i === 1) d-flex flex-column @endif">
                @foreach ($inputs as $input)
                    @php
                        $name = $input['name'];
                        $type = $input['type'];
                        if ($type !== 'radio') {
                            $label = $input['label'];
                        }
                        
                        if ($name === 'code') {
                            $value = $codeValue;
                        } elseif ($name === 'type') {
                            $value = $typeValue;
                        } elseif ($name === 'disc_value') {
                            $value = $discValueValue;
                        } elseif ($name === 'start_date') {
                            $value = $startDateValue;
                        } elseif ($name === 'end_date') {
                            $value = $endDateValue;
                        } elseif ($name === 'status') {
                            $value = $statusValue;
                        }
                    @endphp

                    @if ($type === 'text')
                        <x-partials._input-text :name="$name" :label="$label" :value="$value" />
                    @elseif($type === 'number')
                        <x-partials._input-number :name="$name" :label="$label" :value="$value" />
                    @elseif($type === 'radio')
                        <div class="form-group">
                            @foreach ($input['data'] as $i => $data)
                                <x-partials._input-radio :name="$name" :label="$data['label']" :no="$i"
                                    :value="$data['value']" :oldValue="$value" />
                            @endforeach
                        </div>
                    @elseif($type === 'date')
                        <x-partials._input-date :name="$name" :label="$label" :value="$value" />
                    @elseif($type === 'check')
                        <x-partials._input-check :name="$name" :label="$label" :value="$value" />
                    @endif
                @endforeach
            </div>
        @endforeach

        <button type="submit" class="btn btn-{{ $button['type'] }} btn-block mx-2">{{ $button['name'] }}</button>
    </x-partials._form>

    <x-slot:js>
        <script src="{{ asset('/js/voucher/index.js') }}"></script>
    </x-slot:js>
</x-dashboard>
