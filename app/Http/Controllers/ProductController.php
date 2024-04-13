<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Supplier;
use App\Models\SupplierPricing;
use App\Models\SupplierTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('products.index',[
            'products' => Product::all(),
            'productCategories' => ProductCategory::all(),
            'suppliers' => Supplier::all()
        ]);
    }

     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate( [
            'name' => 'required|string',
            'price' => 'required|integer',
            'description' => 'required|string',
            'image' => 'image|required|mimes:jpg,png,jpeg',
            'category_id' => 'required|integer',
            'discount' => 'required|integer|max:100',
            'initial_stock' => 'required|integer|min:1',
            'price_per_piece'=> 'required|integer',
        ]);
        if ($request->hasFile('image')) {
            $file_name = 'productImage/' . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/', $file_name);
        }

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'stock' => $request->initial_stock,
            'image' => $file_name,
            'category_id' => $request->category_id,
            'discount' => $request->discount,
        ]);
        $product->refresh();
        $supplierPricing = SupplierPricing::create([
            'product_id' => $product->id,
            'supplier_id' => $request->supplier_id,
            'price' => $request->price_per_piece,
        ]);
        $supplierPricing->refresh();
        SupplierTransaction::create([
            'supplier_price_id' => $supplierPricing->id,
            'quantity' => $request->initial_stock,
            'price' => $request->price_per_piece,
            'transaction_date' => now(),
        ]);
        return redirect()->route("products.index")->with(['success' => 'Product added successfully', 'action' => 'add']);
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
            'discount' => 'required|integer|max:100',
        ]);

        if ($request->hasFile('image_new')) {
            $file_name = 'productImage/' . $request->file('image_new')->getClientOriginalName();
            $request->file('image_new')->storeAs('public/', $file_name);
        } else {
            $file_name = request('image_old');
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $file_name,
            'category_id' => $request->category_id,
            'discount' => $request->discount,
        ]);

        return redirect()->route("products.index")->with(['success' => 'Product edited successfully', 'action' => 'edit']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }
        $product->delete();

        return redirect()->route("products.index")->with(['success' => 'Product deleted successfully', 'action' => 'delete']);
    }
    public function search(Request $request)
    {
        $query = $request->input('q');

        if ($query) {
             // Lakukan pencarian berdasarkan query
            $products = Product::where('name', 'like', '%' . $query . '%')->paginate(5);;
        }
        else{
            $products = Product::paginate(5);;
        }
        $paymentMethods = PaymentMethod::all();
        $selectedCategory = 'All Categories';
        $productCategories = ProductCategory::all();
        return view('products-and-transactions.list', compact('products', 'paymentMethods', 'selectedCategory', 'productCategories'));
    }

    public function getByCategory(Request $request)
    {
        $categoryId = $request->input('category_id');
        if (empty($categoryId)) {
            $products = Product::paginate(5); // Ambil semua produk jika kategori kosong
        } else {
            $products = Product::where('category_id', $categoryId)->paginate(5); // Ambil produk berdasarkan kategori
        }
        $category = ProductCategory::find($categoryId);
        $selectedCategory = $category ? $category->name : 'All Categories';
        $paymentMethods = PaymentMethod::all();
        $productCategories = ProductCategory::all();
        return view('products-and-transactions.list', compact('products', 'paymentMethods', 'productCategories', 'selectedCategory'));
    }
}
