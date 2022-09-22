<x-dashboard>

    <x-table>
        <x-slot:heading>{{ $heading }} </x-slot:heading>

        <x-slot:title>
            <div class="card-header py-3 d-flex">
                <select class="custom-select col-md-2" id="role">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{ Str::ucfirst($role->name) }}</option>
                    @endforeach
                </select>
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

        @foreach ($menus as $menu)
            <tr class='single-menu'>
                <td>{{ Str::ucfirst($menu->name) }}</td>
                @foreach ($authorizationTypes as $type)
                    <td class="text-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $type->id }}"
                                id="defaultCheck1" @if ($authorizations->where('menu_id', $menu->id)->where('authorization_type_id', $type->id)->first()->has_access) checked @endif>
                        </div>
                    </td>
                @endforeach
            </tr>
        @endforeach
    </x-table>

    <x-slot:js>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <script src="{{ asset('/js/authorization/index.js') }}"></script>
    </x-slot:js>
</x-dashboard>
