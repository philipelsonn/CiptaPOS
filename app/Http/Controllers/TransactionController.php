<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\PaymentMethod;

class TransactionController extends Controller
{
    public function index()
    {
        $products = Product::paginate(2); // Menampilkan 10 produk per halaman
        $paymentMethods = PaymentMethod::all();
        return view('products-and-transactions.list', compact('products', 'paymentMethods'));
    }

    public function store(Request $request)
    {
        $transactionHeader = new TransactionHeader();
        $transactionHeader->cashier_id = auth()->id();
        $transactionHeader->payment_method_id = $request->payment_method_id;
        $transactionHeader->transaction_date = now();
        $transactionHeader->save();

        // Refresh transactionHeader to get the latest data, including the ID
        $transactionHeader->refresh();

        foreach ($request->cart as $item) {
            $transactionDetail = new TransactionDetail();
            $transactionDetail->transaction_header_id = $transactionHeader->id; // ID dari transaction_header yang baru saja disimpan
            $transactionDetail->product_id = $item['id'];
            $transactionDetail->quantity = $item['quantity'];
            $transactionDetail->price = $item['price'];
            $transactionDetail->save();
        }

        $request->session()->forget('cart');

        return response()->json(['message' => 'Transaction created successfully']);
    }
}
