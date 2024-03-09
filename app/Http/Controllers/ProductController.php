<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('products.index',[
            'products' => Product::all(),
            'productCategories' => ProductCategory::all()
        ]);
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|integer',
            'description' => 'required|string',
            'image' => 'image|required|mimes:jpg,png,jpeg',
            'category_id' => 'required|integer',
            'stock' => 'required|integer',
            'discount' => 'required|integer|max:100',
        ]);

        if ($request->hasFile('image')) {
            $extension = $request->file('image')->getClientOriginalExtension();
            $file_name = $request->name . time() . '.' . $extension;
            $request->file('image')->storeAs('public/images/product', $file_name);
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $file_name,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'discount' => $request->discount,
        ]);

        return redirect()->route("products.index");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name'=>'required|string',
            'price' => 'required|integer',
            'description' => 'required|string',
            'image_new' => 'image|required|mimes:jpg,png,jpeg',
            'category_id' => 'required|integer',
            'stock' => 'required|integer',
            'discount' => 'required|integer|max:100',
        ]);

        if ($request->hasFile('image_new')) {
            $extension = $request->file('image_new')->getClientOriginalExtension();
            $file_name = $request->name . time() . '.' . $extension;
            $request->file('image_new')->storeAs('public/images/product', $file_name);
        } else {
            $file_name = request('image_old');
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $file_name,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
            'discount' => $request->discount,
        ]);

        return redirect()->route('products.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route("products.index");
    }
}
