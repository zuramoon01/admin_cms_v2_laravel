<x-dashboard :menus="$menus">
    @foreach ($details as $detail)
        <x-table>
            @if ($detail['heading'])
                <x-slot:heading>
                    {{ "$heading $transaction->transaction_id" }}
                </x-slot:heading>
            @endif

            <x-slot:title>
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $detail['tableHeading'] }}</h6>
                    <a href="{{ url('/transactions') }}" class="btn btn-info ml-3">
                        Back to menu transaction
                    </a>
                </div>
            </x-slot:title>

            <x-slot:colgroup>
                @foreach ($detail['colSizes'] as $size)
                    <col class="col-md-{{ $size }}">
                @endforeach
            </x-slot:colgroup>

            <x-slot:head>
                @foreach ($detail['tableTitle'] as $title)
                    <th>
                        {{ $title }}
                    </th>
                @endforeach
            </x-slot:head>

            @if ($detail['tableHeading'] === 'Customer')
                <tr class='single-menu'>
                    <td>{{ $transaction->customer_name }}</td>
                    <td>{{ $transaction->customer_email }}</td>
                    <td>{{ $transaction->customer_phone }}</td>
                    <td>{{ $transaction->additional_request }}</td>
                    <td>{{ $transaction->payment_method }}</td>
                </tr>
            @elseif($detail['tableHeading'] === 'Transaction Detail')
                @foreach ($transactionDetails as $transactionDetail)
                    <tr class='single-menu'>
                        <td>{{ $transactionDetail->product->name }}</td>
                        <td>{{ $transactionDetail->qty }}</td>
                        <td>{{ $transactionDetail->price_purchase_satuan }}</td>
                        <td>{{ $transactionDetail->price_purchase_total }}</td>
                    </tr>
                @endforeach
                <tr class='single-menu'>
                    <td class="font-weight-bold" colspan="3">Total Purchase</td>
                    <td>{{ $transaction->total }}</td>
                </tr>
            @elseif($detail['tableHeading'] === 'Voucher Usage')
                @foreach ($voucherUsages as $voucherUsage)
                    <tr class='single-menu'>
                        <td>{{ $voucherUsage->voucher->code }}</td>
                        <td>{{ $voucherUsage->discounted_value }}</td>
                    </tr>
                @endforeach
            @endif
        </x-table>
    @endforeach

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
