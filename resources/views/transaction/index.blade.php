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

        <x-slot:search>
            <form id="search-product" class="form-inline d-flex flex-column align-items-start"
                style="padding: 1.25rem 1.25rem 0rem 1.25rem; gap:10px;"
                action="{{ url(request()->route()->getPrefix()) . '/search' }}">
                <div class="d-flex" style="gap:10px;">
                    <x-partials._input-text name="transaction_id" label="Transaction Id" :value="request('transaction_id')"
                        :isLabel=false />
                    <x-partials._input-text name="customer_name" label="Customer Name" :value="request('customer_name')"
                        :isLabel=false />
                    <x-partials._input-text name="customer_email" label="Customer Email" :value="request('customer_email')"
                        :isLabel=false />
                    <x-partials._input-select name="status" label="Status" routeType="add" isLabel="false">
                        <option @selected(request('status') === '0') value="0">Cancelled</option>
                        <option @selected(request('status') === '1') value="1">Pending</option>
                        <option @selected(request('status') === '2') value="2">Done / Paid</option>
                    </x-partials._input-select>
                    <x-partials._input-date name="date" label="" :value="request('date')" :isLabel=false />
                </div>

                <div class="d-flex" style="gap:10px;">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="{{ url(request()->route()->getPrefix()) }}" class="btn btn-warning">Reset</a>
                </div>
            </form>
        </x-slot:search>

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
                    @if ($transaction->status === 2)
                        <span class="badge badge-success">Done / Paid</span>
                    @elseif($transaction->status === 1)
                        <span class="badge badge-warning">Pending</span>
                    @elseif($transaction->status === 0)
                        <span class="badge badge-danger">Cancelled</span>
                    @endif
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center">
                        @if ($transaction->status === 1)
                            <a href="{{ url(request()->path() . "/$transaction->id") }}"
                                class="btn btn-warning btn-circle btn-sm mr-1">
                                <i class="fas fa-pen"></i>
                            </a>
                        @endif
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
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.localStorage.clear()
            })
        </script>
    </x-slot:js>
</x-dashboard>
