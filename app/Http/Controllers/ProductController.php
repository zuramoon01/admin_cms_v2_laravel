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
        return view('product.index', ['products' => Product::all()]);
    }

    public function search(Request $request)
    {
        $name = $request->name;
        $code = $request->code;
        $status = $request->status;

        if (!$name && !$code && $status === null) {
            return to_route('product.index.view');
        }

        $products = new Product;

        if ($name) {
            $products = $products->where('name', 'like', "%$name%");
        }
        if ($code) {
            $products = $products->where('code', 'like', "%$code%");
        }
        if ($status !== null) {
            $products = $products->where('status', $status);
        }

        return view('product.index', ['products' => $products->get()]);
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
        try {
            Product::destroy($product->id);

            return response()->json('success');
        } catch (\Throwable $th) {
            return response()->json("Can't delete product because it's in use in transaction detail!");
        }
    }

    public function getProduct(Product $product)
    {
        return response()->json($product);
    }
}
