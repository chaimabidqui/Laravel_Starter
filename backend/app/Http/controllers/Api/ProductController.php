<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $product = new product();
        $product->title = $data['title'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->image = $data['image'];
        $product->client_id = $data['client_id'];
        $product->save();
        return $product;
       }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        return $product->client;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, product $product)
    {
        $data = $request->all();
        $product->title = $data['title'];
        $product->description = $data['description'];
        $product->price = $data['price'];
        $product->image = $data['image'];
        $product->client_id = $data['client'];
        $product->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(product $product)
    {
        //
    }
}
