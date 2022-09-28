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
                <th>
                    {{ $title }}
                </th>
            @endforeach
            <th class="text-center">Actions</th>
        </x-slot:head>

        @foreach ($vouchers as $voucher)
            <tr class='single-menu'>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $voucher->code }}</td>
                <td>{{ $voucher->type }}</td>
                <td>
                    {{ $voucher->disc_value }}
                    @if ($voucher->type === 2)
                        %
                    @endif
                </td>
                <td>{{ $voucher->start_date }}</td>
                <td>{{ $voucher->end_date }}</td>
                <td>
                    @if ($voucher->status)
                        <span class="badge badge-success">active</span>
                    @else
                        <span class="badge badge-danger">non active</span>
                    @endif
                    @if (date('Y-m-d') > $voucher->end_date)
                        <span class="badge badge-secondary">expired</span>
                    @endif
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center">
                        <a href="{{ url(request()->path() . "/$voucher->id") }}"
                            class="btn btn-warning btn-circle btn-sm mr-1">
                            <i class="fas fa-pen"></i>
                        </a>
                        <button data-url="{{ url(request()->path() . "/$voucher->id") }}"
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
