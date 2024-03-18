<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\SupplierPricing;
use App\Models\SupplierTransaction;

class SupplierTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('supplier-transactions.index',[
            'products' => Product::all(),
            'suppliers' => Supplier::all(),
            'supplierPricings' => SupplierPricing::all(),
            'supplierTransactions' => SupplierTransaction::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'quantity' => 'required|integer',
        ]);
 
        $supplierPricing = SupplierPricing::where('supplier_id', $request->supplier_id)
                            ->where('product_id', $request->product_id)->first();

        SupplierTransaction::create([
            'supplier_price_id' => $supplierPricing->id,
            'quantity' => $request->quantity,
            'transaction_date' => now()
        ]);

        $product = Product::findOrFail($request->product_id);
        $product->stock += $request->quantity;
        $product->save();

        return redirect()->route("supplier-transactions.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupplierTransaction $supplierTransaction)
    {
        $product = Product::findOrFail($supplierTransaction->supplierPricing->product_id);
        $product->stock -= $supplierTransaction->quantity;
        $product->save();

        $supplierTransaction->delete();

        return redirect()->route("supplier-transactions.index");
    }
}
