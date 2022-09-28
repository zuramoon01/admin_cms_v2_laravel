<x-dashboard :menus="$menus">
    <x-table>
        <x-slot:heading>{{ $heading }}</x-slot:heading>

        <x-slot:title>
            <div class="card-header py-3 d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">DataTables {{ $heading }}</h6>
                <a href="{{ url(request()->path() . '/create') }}" id="save" class="btn btn-primary ml-3">
                    <i class="fas fa-plus"></i>
                    Create
                </a>
            </div>
        </x-slot:title>

        <x-slot:colgroup>
            @foreach ($colSizes as $size)
                <col class="col-md-{{ $size }}">
            @endforeach
        </x-slot:colgroup>

        <x-slot:head>
            <th class="text-center">No</th>
            @foreach ($titles as $title)
                <th>{{ Str::ucfirst($title) }}</th>
            @endforeach
            <th class="text-center">Actions</th>
        </x-slot:head>

        @foreach ($productCategories as $productCategory)
            <tr class='single-menu'>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $productCategory->category }}</td>
                <td>{{ $productCategory->description }}</td>
                <td class="text-center">
                    <div class="d-flex justify-content-center">
                        <a href="{{ url(request()->path() . "/$productCategory->id") }}"
                            class="btn btn-warning btn-circle btn-sm mr-1">
                            <i class="fas fa-pen"></i>
                        </a>
                        <button data-url="{{ url(request()->path() . "/$productCategory->id") }}"
                            class="btn btn-danger btn-circle btn-sm ml-1" onclick="deleteItem(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </td>
            </tr>
        @endforeach
    </x-table>

    <x-slot:js>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script src="{{ asset('/js/all/index.js') }}"></script>
    </x-slot:js>
</x-dashboard>
