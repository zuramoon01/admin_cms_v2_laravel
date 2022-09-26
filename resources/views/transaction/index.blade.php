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

        @foreach ($transactions as $transaction)
            <tr class='single-menu'>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $transaction->transaction_id }}</td>
                <td>{{ $transaction->customer_name }}</td>
                <td>{{ $transaction->total_purchase }}</td>
                <td>{{ $transaction->additional_request }}</td>
                <td>{{ $transaction->payment_method }}</td>
                <td>
                    @if ($transaction->status)
                        <span class="badge badge-success">active</span>
                        @if ($transaction->new_product)
                            <span class="badge badge-warning text-white">new product</span>
                        @endif
                        @if ($transaction->best_seller)
                            <span class="badge badge-primary text-white">best seller</span>
                        @endif
                        @if ($transaction->featured)
                            <span class="badge badge-dark">featured</span>
                        @endif
                    @else
                        <span class="badge badge-danger">non active</span>
                    @endif
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center">
                        <a href="{{ url(request()->path() . "/$transaction->id") }}"
                            class="btn btn-warning btn-circle btn-sm mr-1">
                            <i class="fas fa-pen"></i>
                        </a>
                        <button data-url="{{ url(request()->path() . "/$transaction->id") }}"
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

        <script src="{{ asset('/js/all/index.js') }}"></script>
    </x-slot:js>
</x-dashboard>
