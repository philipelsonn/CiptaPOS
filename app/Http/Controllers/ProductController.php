<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(2); // Menampilkan 10 produk per halaman
        $paymentMethods = PaymentMethod::all();
        return view('products-and-transactions.list', compact('products', 'paymentMethods'));
    }
}
