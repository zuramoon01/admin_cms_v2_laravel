<x-dashboard :menus="$menus">
    <x-table>
        <x-slot:heading>{{ $heading }} </x-slot:heading>

        <x-slot:title>
            <div class="card-header py-3 d-flex">
                <select class="custom-select col-md-2" id="role">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ Str::ucfirst($role->name) }}</option>
                    @endforeach
                </select>

                {{-- Save Button to Save Authorization --}}
                <button type="button" id="save" class="btn btn-warning ml-3">Save</button>
            </div>
        </x-slot:title>

        <x-slot:colgroup>
            @foreach ($colSizes as $size)
                <col class="col-md-{{ $size }}">
            @endforeach
        </x-slot:colgroup>

        <x-slot:head>
            <th>Menu</th>
            @foreach ($authorizationTypes as $type)
                <th class="text-center">{{ Str::ucfirst($type->name) }}</th>
            @endforeach
        </x-slot:head>
    </x-table>

    <x-slot:js>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <script src="{{ asset('/js/authorization/index.js') }}"></script>
    </x-slot:js>
</x-dashboard>
