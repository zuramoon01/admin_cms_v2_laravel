@php
$url = request()
    ->route()
    ->getPrefix();
$productCategoryIdValue = '';
$nameValue = '';
$codeValue = '';
$priceValue = '';
$purchasePriceValue = '';
$shortDescriptionValue = '';
$descriptionValue = '';
$statusValue = '';
$newProductValue = '';
$bestSellerValue = '';
$featuredValue = '';

if (count(old()) > 0) {
    $productCategoryIdValue = old('product_categories_id');
    $nameValue = old('name');
    $codeValue = old('code');
    $priceValue = old('price');
    $purchasePriceValue = old('purchase_price');
    $shortDescriptionValue = old('short_description');
    $descriptionValue = old('description');
    $statusValue = old('status');
    $newProductValue = old('newProduct');
    $bestSellerValue = old('bestSeller');
    $featuredValue = old('featured');
} elseif (isset($product)) {
    $productCategoryIdValue = $product->product_categories_id;
    $nameValue = $product->name;
    $codeValue = $product->code;
    $priceValue = $product->price;
    $purchasePriceValue = $product->purchase_price;
    $shortDescriptionValue = $product->short_description;
    $descriptionValue = $product->description;
    $statusValue = $product->status;
    $newProductValue = $product->new_product;
    $bestSellerValue = $product->best_seller;
    $featuredValue = $product->featured;
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

<x-dashboard>

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">{{ Str::ucfirst($routeType) . " $heading" }}</h1>

    <x-partials._form :action="url($url)">
        <x-slot:method>
            @isset($product)
                @method('put')
            @endisset
        </x-slot:method>

        @foreach ($formInputs as $i => $inputs)
            <div class="col-lg-6 @if ($i === 1) d-flex flex-column @endif">
                @foreach ($inputs as $input)
                    @php
                        $name = $input['name'];
                        $type = $input['type'];
                        $label = $input['label'];
                        
                        if ($name === 'product_categories_id') {
                            $value = $productCategoryIdValue;
                        } elseif ($name === 'name') {
                            $value = $nameValue;
                        } elseif ($name === 'code') {
                            $value = $codeValue;
                        } elseif ($name === 'price') {
                            $value = $priceValue;
                        } elseif ($name === 'purchase_price') {
                            $value = $purchasePriceValue;
                        } elseif ($name === 'short_description') {
                            $value = $shortDescriptionValue;
                        } elseif ($name === 'description') {
                            $value = $descriptionValue;
                        } elseif ($name === 'status') {
                            $value = $statusValue;
                        } elseif ($name === 'new_product') {
                            $value = $newProductValue;
                        } elseif ($name === 'best_seller') {
                            $value = $bestSellerValue;
                        } elseif ($name === 'featured') {
                            $value = $featuredValue;
                        }
                    @endphp

                    @if ($type === 'text')
                        <x-partials._input-text :name="$name" :label="$label" :value="$value" />
                    @elseif($type === 'number')
                        <x-partials._input-number :name="$name" :label="$label" :value="$value" />
                    @elseif($type === 'select')
                        <x-partials._input-select :name="$name" :label="$label" :routeType="$routeType">
                            @foreach ($productCategories as $category)
                                <option @selected($category->id == $value) value="{{ $category->id }}">
                                    {{ $category->category }}</option>
                            @endforeach
                        </x-partials._input-select>
                    @elseif($type === 'check')
                        <x-partials._input-check :name="$name" :label="$label" :value="$value" />
                    @elseif($type === 'textarea')
                        <x-partials._input-textarea :name="$name" :label="$label" :value="$value" />
                    @endif
                @endforeach
            </div>
        @endforeach

        <button type="submit" class="btn btn-{{ $button['type'] }} btn-block mx-2">{{ $button['name'] }}</button>
    </x-partials._form>

</x-dashboard>
