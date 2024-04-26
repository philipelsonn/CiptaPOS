<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\PaymentMethod;
use App\Models\ProductCategory;
use App\Models\SupplierTransaction;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function index()
    {
        $products = Product::paginate(5); // Menampilkan 10 produk per halaman
        $paymentMethods = PaymentMethod::all();
        $productCategories = ProductCategory::all();
        $selectedCategory = 'All Categories';
        return view('products-and-transactions.list', compact('products', 'paymentMethods', 'productCategories', 'selectedCategory'));
    }

    public function showHistory()
    {
        $transactionHeaders = TransactionHeader::with('transactionDetails')->get();
        $transactionDetails = TransactionDetail::all();
        $supplierTransactions = SupplierTransaction::all();
        $totalRevenue = $transactionDetails->sum(function ($transactionDetail) {
            return $transactionDetail->price * $transactionDetail->quantity;
        });

        $totalOutcome = $supplierTransactions->sum(function ($supplierTransaction) {
            return $supplierTransaction->price * $supplierTransaction->quantity;
        });
        $mostSoldProducts = TransactionDetail::select('product_id', DB::raw('SUM(quantity) as total_quantity'))
        ->whereHas('transactionHeader', function ($query) {
            $query->where('transaction_date', '>=', now()->subMonth()->startOfMonth())
                ->where('transaction_date', '<=', now()->endOfMonth());
        })
        ->groupBy('product_id')
        ->orderByDesc('total_quantity')
        ->limit(5) // Limit produk
        ->get();

        $mostSoldCategories = TransactionDetail::select('product_categories.name as category', DB::raw('SUM(transaction_details.quantity) as total_quantity'))
        ->join('products', 'transaction_details.product_id', '=', 'products.id')
        ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
        ->whereHas('transactionHeader', function ($query) {
        $query->where('transaction_date', '>=', now()->subMonth()->startOfMonth())
        ->where('transaction_date', '<=', now()->endOfMonth());
        })
        ->groupBy('product_categories.name')
        ->orderByDesc('total_quantity')
        ->get();

        $transactionDetailsTop5 = TransactionDetail::orderByDesc(DB::raw('price * quantity'))->take(5)->get();
        return view('products-and-transactions.transactionHistory',compact('transactionHeaders', 'transactionDetails', 'totalRevenue', 'mostSoldProducts', 'transactionDetailsTop5', 'mostSoldCategories', 'totalOutcome'));
    }

    public function store(Request $request)
    {
        $transactionHeader = new TransactionHeader();
        $transactionHeader->cashier_id = auth()->id();
        $transactionHeader->payment_method_id = $request->payment_method_id;
        $transactionHeader->transaction_date = now();
        $transactionHeader->card_number = $request->card_number ? Crypt::encrypt($request->card_number) : null; // Enkripsi hanya jika tidak null
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

            $product = Product::find($item['id']);
            if ($product) {
                $product->stock -= $item['quantity'];
                $product->save();
            }
        }

        $request->session()->forget('cart');

        return response()->json([
            'message' => 'Transaction created successfully',
            'redirect_url' => route('product.transactions.receipt', ['id' => $transactionHeader->id])
        ]);
    }

    public function showReceipt($id)
    {
        $transaction = TransactionHeader::findOrFail($id);

        return view('products-and-transactions.receipt', ['transaction' => $transaction]);
    }

    public function destroy(TransactionDetail $transactionDetail)
    {
        $transactionDetail->delete();
        return redirect()->route("transactions/history");
    }
}
