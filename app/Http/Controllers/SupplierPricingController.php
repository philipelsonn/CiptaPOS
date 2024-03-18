<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\SupplierPricing;
use Illuminate\Http\Request;

class SupplierPricingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('supplier-pricings.index',[
            'products' => Product::all(),
            'suppliers' => Supplier::all(),
            'supplierPricings' => SupplierPricing::all(),
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
            'price' => 'required|integer',
        ]);

        SupplierPricing::create([
            'product_id' => $request->product_id,
            'supplier_id' => $request->supplier_id,
            'price' => $request->price,
        ]);

        return redirect()->route("supplier-pricings.index");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SupplierPricing $supplierPricing)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'supplier_id' => 'required|integer',
            'price' => 'required|integer',
        ]);

        $supplierPricing->update([
            'product_id' => $request->product_id,
            'supplier_id' => $request->supplier_id,
            'price' => $request->price,
        ]);

        return redirect()->route('supplier-pricings.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupplierPricing $supplierPricing)
    {
        $supplierPricing->delete();

        return redirect()->route("supplier-pricings.index");
    }
}
