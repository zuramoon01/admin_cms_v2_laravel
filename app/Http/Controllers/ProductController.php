<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    private $checks = ['status', 'new_product', 'best_seller', 'featured'];

    private function fillCheck($validated)
    {
        foreach ($this->checks as $check) {
            $validated[$check] = request()->exists($check) ? request($check) : '0';
        }

        return $validated;
    }

    public function index()
    {
        return view('product.index');
    }

    public function create()
    {
        return view('product.form');
    }

    public function store(ProductRequest $request)
    {
        $validated = $this->fillCheck($request->validated());

        Product::create($validated);

        return to_route('product.index.view');
    }

    public function edit(Product $product)
    {
        return view('product.form', ['product' => $product]);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $validated = $this->fillCheck($request->validated());

        Product::where('id', $product->id)
            ->update($validated);

        return to_route('product.index.view');
    }

    public function destroy(Product $product)
    {
        Product::destroy($product->id);

        return response()->json('success');
    }

    public function getProduct(Product $product)
    {
        return response()->json($product);
    }
}
