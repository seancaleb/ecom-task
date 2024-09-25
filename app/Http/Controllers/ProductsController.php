<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\DataTables\ProductsDataTable;

class ProductsController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(ProductsDataTable $dataTable) {

        $products = Product::query()
            ->where('user_id', request()->user()->id)
            ->orderBy("created_at", "desc")
            ->paginate(5);

        return view('products.index', data: ['products' => $products]);
        // return $dataTable->render('products.index', data: ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
        ]);

        $data['user_id'] = $request->user()->id;
        $product = Product::create($data);

        return to_route('products.show', $product)->with('message', 'Product was created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product) {
        return view('products.show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product) {
        return view('products.edit', ['product' => $product]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product) {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric'],
        ]);

        $product->update($data);

        return to_route('products.show', $product)->with('message', 'Product was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product) {
        $product->delete();

        return to_route('products.index', $product)->with('message', 'Product was deleted');
    }
}
