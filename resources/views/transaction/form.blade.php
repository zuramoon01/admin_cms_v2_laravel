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

    @if (count(old()) > 0)
        @dd(old())
    @endif

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
                                @if ($name === 'status') @selected($data['value'] === '1') @else @selected($data['value'] == $value) @endif
                                value="{{ $data['value'] }}">
                                {{ $data['label'] }}</option>
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
                        <option value="{{ $voucher->id }}">
                            {{ Str::ucfirst($voucher->code) }}</option>
                    @endforeach
                </x-partials._input-select>

                <ul class="list-group list-group-flush" style="overflow-y: auto; max-height: 250px;">
                    <li class="list-group-item d-flex p-1">
                        <p class="col-md-10 m-0 p-0">Total Purchase Before Discount</p>
                        <p id="total-purchase-before-discount" class="col-md-2 m-0 p-0 text-right">0</p>
                    </li>
                    <li class="list-group-item d-flex p-1">
                        <p id="voucher-text" class="col-md-10 m-0 p-0">Voucher</p>
                        <p id="voucher-value" class="col-md-2 m-0 p-0 text-right">-</p>
                    </li>
                    <li class="list-group-item d-flex p-1">
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

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const selectProduct = document.querySelector('#product');
                let selectedProduct = "";
                const qtyProduct = document.querySelector('#qty');
                const addProductBtn = document.querySelector('#add-product');

                const listProduct = document.querySelector('#list-product');

                const selectVoucher = document.querySelector('#voucher');
                let selectedVoucher = "";

                const totalPurchaseBeforeDiscount = document.querySelector('#total-purchase-before-discount');
                const voucherText = document.querySelector('#voucher-text');
                const voucherValue = document.querySelector('#voucher-value');
                const totalPurchase = document.querySelector('#total-purchase');

                let total = 0;
                let products = [];
                let voucher = {};

                const setTransaction = () => {
                    if (products.length > 0) {
                        products.filter(product => {
                            const {
                                id,
                                name,
                                qty,
                                subTotal
                            } = product;

                            axios.get(`/api/product/${id}`)
                                .then(({
                                    data
                                }) => {
                                    if (data.status === 1) {
                                        listProduct.innerHTML += `
                                            <li class="list-group-item d-flex p-2">
                                                <p class="col-md-6 m-0 p-0 text-center">${name}</p>
                                                <p class="col-md-1 m-0 p-0 text-center">${qty}</p>
                                                <p class="col-md-3 m-0 p-0 text-center">${subTotal}</p>
                                                <p class="col-md-2 m-0 p-0 text-center">
                                                    <button class="btn btn-danger btn-circle btn-sm ml-1" onclick="deleteProduk(this)">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </p>
                                            </li>
                                        `

                                        return product
                                    }
                                })
                                .catch((err) => console.log(err))

                            setProducts();
                        });
                    }

                    if (Object.keys(voucher).length > 0) {
                        axios.get(`/api/voucher/${id}`)
                            .then(({
                                data
                            }) => {
                                if (data.status === 1) {
                                    voucherText.innerText = voucher.type === 1 ? 'Voucher | Flat Discount' :
                                        'Voucher | Percent Discount';
                                    voucherValue.innerText = voucher.disc_value

                                    voucher = {};
                                    setVoucher();
                                }
                            })
                            .catch((err) => console.log(err))
                    }
                }

                const getVoucher = () => {
                    voucher = JSON.parse(window.localStorage.getItem('voucher')) ? JSON.parse(window.localStorage
                        .getItem(
                            'voucher')) : {};

                    setTransaction()
                }

                const getProducts = () => {
                    products = JSON.parse(window.localStorage.getItem('products')) ? JSON.parse(window.localStorage
                        .getItem(
                            'products')) : [];

                    getVoucher();
                }
                getProducts();


                const setProducts = () => {
                    window.localStorage.setItem('products', JSON.stringify(products));
                }

                const setVoucher = () => {
                    window.localStorage.setItem('voucher', JSON.stringify(voucher));
                }

                addProductBtn.addEventListener('click', () => {
                    selectedProduct = selectProduct.selectedOptions[0].value;

                    if (selectedProduct !== "" && qtyProduct.value !== "" && parseInt(qtyProduct.value) > 0) {
                        axios.get(`/api/product/${selectedProduct}`)
                            .then(({
                                data
                            }) => {
                                listProduct.innerHTML += `
                                    <li class="list-group-item d-flex p-2">
                                        <p class="col-md-6 m-0 p-0 text-center">${data.name}</p>
                                        <p class="col-md-1 m-0 p-0 text-center">${qtyProduct.value}</p>
                                        <p class="col-md-3 m-0 p-0 text-center">${data.purchase_price * parseInt(qtyProduct.value)}</p>
                                        <p class="col-md-2 m-0 p-0 text-center">
                                            <button class="btn btn-danger btn-circle btn-sm ml-1" onclick="deleteProduk(this)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </p>
                                    </li>
                                `

                                total += (data.purchase_price * parseInt(qtyProduct.value));

                                products.push({
                                    id: data.id,
                                    name: data.name,
                                    qty: qtyProduct.value,
                                    subTotal: data.purchase_price * parseInt(qtyProduct.value),
                                });
                                setProducts()

                                getTotal()
                            })
                            .catch((err) => console.log(err))
                    }
                })

                selectVoucher.addEventListener('change', () => {
                    selectedVoucher = selectVoucher.selectedOptions[0].value;

                    if (selectedVoucher !== "")
                        axios.get(`/api/voucher/${selectedVoucher}`)
                        .then(({
                            data
                        }) => {
                            voucherText.innerText = data.type === 1 ? 'Voucher | Flat Discount' :
                                'Voucher | Percent Discount';
                            voucherValue.innerText = data.disc_value

                            voucher = data;
                            setVoucher();

                            getTotal()
                        })
                        .catch((err) => console.log(err))
                    else {
                        voucherText.innerText = 'Voucher';
                        voucherValue.innerText = "-"
                    }
                })

                const getTotal = () => {
                    const type = voucherText.innerText.split(" ")[2];

                    if (total > 0) {
                        totalPurchaseBeforeDiscount.innerText = total;

                        if (type === 'Flat') totalPurchase.innerText = total - parseFloat(voucherValue.innerText);
                        else if (type === 'Percent') totalPurchase.innerText = total - (total * (parseFloat(
                            voucherValue.innerText) / 100));
                        else totalPurchase.innerText = total
                    } else {
                        totalPurchaseBeforeDiscount.innerText = 0
                        totalPurchase.innerText = 0
                    }

                    console.log(products, voucher);
                }
            })
        </script>
    </x-slot:js>
</x-dashboard>
