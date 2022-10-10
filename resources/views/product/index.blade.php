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
            <form id="search-product" class="form-inline d-flex" style="padding: 1.25rem 1.25rem 0rem 1.25rem; gap: 10px;"
                action="{{ url(request()->route()->getPrefix()) . '/search' }}">
                <x-partials._input-hidden name="product_category" :value="request('product_category')" />
                <x-partials._input-text name="name" label="Name" :value="request('name')" :isLabel=false />
                <x-partials._input-text name="code" label="Code" :value="request('code')" :isLabel=false />
                <x-partials._input-select name="status" label="Status" routeType="add" isLabel="false">
                    <option @selected(request('status') === '0') value="0">Non Active</option>
                    <option @selected(request('status') === '1') value="1">Active</option>
                </x-partials._input-select>

                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ url(request()->route()->getPrefix()) }}" class="btn btn-warning">Reset</a>
            </form>
        </x-slot:search>

        <x-slot:colgroup>
            @foreach ($colSizes as $size)
                <col class="col-md-{{ $size }}">
            @endforeach
        </x-slot:colgroup>

        <x-slot:head>
            <th class="text-center">No</th>
            @foreach ($titles as $i => $title)
                @if ($title === 'Code')
                    @continue
                @endif
                <th>
                    @if ($title === 'Product Categories Id')
                        Category
                    @elseif($title === 'Name')
                        {{ $titles[$i + 1] . ' - ' . $title }}
                    @else
                        {{ $title }}
                    @endif
                </th>
            @endforeach
            <th class="text-center">Actions</th>
        </x-slot:head>

        @foreach ($products as $product)
            <tr class='single-menu'>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>
                    <a href="{{ url('/product-categories/search?product=' . $product->productCategory->id) }}"
                        style="text-decoration: underline;">
                        {{ $product->productCategory->category }}
                    </a>
                </td>
                <td>{{ "$product->code - $product->name" }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->purchase_price }}</td>
                <td>
                    @if ($product->status)
                        <span class="badge badge-success">active</span>
                        @if ($product->new_product)
                            <span class="badge badge-warning text-white">new product</span>
                        @endif
                        @if ($product->best_seller)
                            <span class="badge badge-primary text-white">best seller</span>
                        @endif
                        @if ($product->featured)
                            <span class="badge badge-dark">featured</span>
                        @endif
                    @else
                        <span class="badge badge-danger">non active</span>
                    @endif
                </td>
                <td class="text-center">
                    <div class="d-flex justify-content-center">
                        <a href="{{ url(request()->path() . "/$product->id") }}"
                            class="btn btn-warning btn-circle btn-sm mr-1">
                            <i class="fas fa-pen"></i>
                        </a>
                        <button data-url="{{ url(request()->path() . "/$product->id") }}"
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
