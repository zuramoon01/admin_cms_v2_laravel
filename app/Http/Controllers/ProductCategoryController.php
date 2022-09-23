<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductCategoryRequest;

use App\Models\ProductCategory;

class ProductCategoryController extends Controller
{
    public function index()
    {
        return view('product-category.index');
    }

    public function create()
    {
        return view('product-category.form');
    }

    public function store(ProductCategoryRequest $request)
    {
        $validated = $request->validated();

        ProductCategory::create($validated);

        return to_route('product-category.index.view');
    }

    public function edit(ProductCategory $productCategory)
    {
        return view('product-category.form', [
            'productCategory' => $productCategory,
        ]);
    }

    public function update(ProductCategoryRequest $request, ProductCategory $productCategory)
    {
        $validated = $request->validated();

        ProductCategory::where('id', $productCategory->id)
            ->update($validated);

        return to_route('product-category.index.view');
    }

    public function delete(ProductCategory $productCategory)
    {
        ProductCategory::destroy($productCategory->id);

        return response()->json('success');
    }
}
