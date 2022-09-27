@php
$url = request()
    ->route()
    ->getPrefix();
$transactionIdValue = '';
$customerNameValue = '';
$customerEmailValue = '';
$customerPhoneValue = '';
$subTotalValue = '';
$totalValue = '';
$totalPurchaseValue = '';
$additonalRequestValue = '';
$paymentMethodValue = '';
$statusValue = '';

if (count(old()) > 0) {
    $transactionIdValue = old('transaction_id');
    $customerNameValue = old('customer_name');
    $customerEmailValue = old('customer_email');
    $customerPhoneValue = old('customer_phone');
    $subTotalValue = old('sub_total');
    $totalValue = old('total');
    $totalPurchaseValue = old('purchase_total');
    $additonalRequestValue = old('additional_request');
    $paymentMethodValue = old('payment_method');
    $statusValue = old('status');
} elseif (isset($transaction)) {
    $transactionIdValue = $transaction->transaction_id;
    $customerNameValue = $transaction->customer_name;
    $customerEmailValue = $transaction->customer_email;
    $customerPhoneValue = $transaction->customer_phone;
    $subTotalValue = $transaction->sub_total;
    $totalValue = $transaction->total;
    $totalPurchaseValue = $transaction->purchase_total;
    $additonalRequestValue = $transaction->additional_request;
    $paymentMethodValue = $transaction->payment_method;
    $statusValue = $transaction->status;
}

if (isset($product)) {
    $url = "$url/$product->id";
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
            @isset($product)
                @method('put')
            @endisset
        </x-slot:method>

        <div class="col-lg-6 d-flex flex-column">
            @foreach ($formInputs as $input)
                @php
                    $name = $input['name'];
                    $type = $input['type'];
                    $label = $input['label'];
                    
                    if ($name === 'transaction_id') {
                        $value = $transactionIdValue;
                    } elseif ($name === 'customer_name') {
                        $value = $customerNameValue;
                    } elseif ($name === 'customer_email') {
                        $value = $customerEmailValue;
                    } elseif ($name === 'customer_phone') {
                        $value = $customerPhoneValue;
                    } elseif ($name === 'sub_total') {
                        $value = $subTotalValue;
                    } elseif ($name === 'total') {
                        $value = $totalValue;
                    } elseif ($name === 'purchase_total') {
                        $value = $totalPurchaseValue;
                    } elseif ($name === 'additional_request') {
                        $value = $additonalRequestValue;
                    } elseif ($name === 'payment_method') {
                        $value = $paymentMethodValue;
                    } elseif ($name === 'status') {
                        $value = $statusValue;
                    }
                @endphp

                @if ($type === 'text')
                    <x-partials._input-text :name="$name" :label="$label" :value="$value" />
                @elseif($type === 'select')
                    <x-partials._input-select :name="$name" :label="$label" :routeType="$routeType">
                        @foreach ($input['data'] as $data)
                            <option
                                @if ($name === 'status' && $value === '') @selected($data['value'] === 1) @else @selected($data['value'] == $value) @endif
                                value="{{ $data['value'] }}">
                                {{ $data['label'] }}
                            </option>
                        @endforeach
                    </x-partials._input-select>
                @elseif($type === 'textarea')
                    <x-partials._input-textarea :name="$name" :label="$label" :value="$value" />
                @endif
            @endforeach
        </div>

        <div class="col-lg-6 border py-3 mb-3 d-flex flex-column justify-content-between">
            <div class="products">
                <x-partials._input-select name="product" label="Product" routeType="add" isLabel=false>
                    @foreach ($products->where('status', 1) as $product)
                        <option value="{{ $product->id }}">
                            {{ Str::ucfirst($product->name) }}</option>
                    @endforeach
                </x-partials._input-select>

                <x-partials._input-number name="qty" label="Quantity" value="" isLabel=false />

                <button type="button" class="btn btn-success btn-block" id="add-product">Add Product</button>

                <ul id="list-product" class="list-group list-group-flush my-3"
                    style="overflow-y: auto; max-height: 200px;">
                    <li class="list-group-item d-flex p-2">
                        <p class="col-md-6 m-0 p-0 text-center">Name</p>
                        <p class="col-md-1 m-0 p-0 text-center">Qty</p>
                        <p class="col-md-3 m-0 p-0 text-center">Sub Total</p>
                        <p class="col-md-2 m-0 p-0 text-center">Action</p>
                    </li>
                </ul>
            </div>

            <div>
                <x-partials._input-select name="voucher" label="Voucher" routeType="add" isLabel=false>
                    @foreach ($vouchers->where('status', 1) as $voucher)
                        <option value="{{ $voucher->id }}" @selected($voucher->id == old('voucher'))>
                            {{ Str::ucfirst($voucher->code) }}</option>
                    @endforeach
                </x-partials._input-select>

                <ul class="list-group list-group-flush" style="overflow-y: auto; max-height: 250px;">
                    <li class="list-group-item d-flex p-1">
                        <input type="hidden" id="sub-total-input" name="sub_total">
                        <p class="col-md-10 m-0 p-0">Total Purchase Before Discount</p>
                        <p id="total-purchase-before-discount" class="col-md-2 m-0 p-0 text-right">0</p>
                    </li>
                    <li class="list-group-item d-flex p-1">
                        <p id="voucher-text" class="col-md-10 m-0 p-0">Voucher</p>
                        <p id="voucher-value" class="col-md-2 m-0 p-0 text-right">-</p>
                    </li>
                    <li class="list-group-item d-flex p-1">
                        <input type="hidden" id="total-input" name="total">
                        <input type="hidden" id="total-purchase-input" name="total_purchase">
                        <p class="col-md-10 m-0 p-0">Total Purchase</p>
                        <p id="total-purchase" class="col-md-2 m-0 p-0 text-right">0</p>
                    </li>
                </ul>
            </div>
        </div>

        <button type="submit" class="btn btn-{{ $button['type'] }} btn-block ml-2">{{ $button['name'] }}</button>
    </x-partials._form>

    <x-slot:js>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <script src="{{ asset('js/transaction/create.js') }}"></script>
    </x-slot:js>
</x-dashboard>
