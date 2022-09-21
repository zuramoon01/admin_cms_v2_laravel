<x-dashboard>
    @php
        $url = request()
            ->route()
            ->getPrefix();
        $categoryValue = '';
        $descriptionValue = '';
        
        if (count(old()) > 0) {
            $categoryValue = old('category');
            $descriptionValue = old('description');
        } elseif (isset($productCategory)) {
            $categoryValue = $productCategory->category;
            $descriptionValue = $productCategory->description;
        }
        
        if (isset($productCategory)) {
            $url = "$url/$productCategory->id";
        }
    @endphp

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Buttons</h1>

    <form class="row" action="{{ url($url) }}" method="post">
        @isset($productCategory)
            @method('put')
        @endisset
        @csrf

        <div class="col-lg-6 d-flex flex-column">
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" class="form-control" id="category" name="category" value="{{ $categoryValue }}">
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" rows="3" name="description">{{ $descriptionValue }}</textarea>
            </div>

            <button type="submit" class="btn btn-warning align-self-end">Primary</button>
        </div>
    </form>
</x-dashboard>
