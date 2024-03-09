<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('product-categories.index',[
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
        ]);

        ProductCategory::create([
            'name' => $request->name,
        ]);

        return redirect()->route("product-categories.index");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        $request->validate([
            'name'=>'required|string',
        ]);

        $productCategory->update([
            'name'=>$request->name,
        ]);

        return redirect()->route('product-categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $productCategory)
    {
        $productCategory->delete();

        return redirect()->route("product-categories.index");
    }
}
