<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('suppliers.index',[
            'suppliers' => Supplier::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string',
            'company_address' => 'required|string',
            'pic_name' => 'required|string',
            'pic_phone' => 'required|string',
            'pic_email' => 'required|string',
        ]);

        Supplier::create([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'pic_name' => $request->pic_name,
            'pic_phone' => $request->pic_phone,
            'pic_email' => $request->pic_email,
        ]);

        return redirect()->route("suppliers.index");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'company_name' => 'required|string',
            'company_address' => 'required|string',
            'pic_name' => 'required|string',
            'pic_phone' => 'required|string',
            'pic_email' => 'required|string',
        ]);

        $supplier->update([
            'company_name' => $request->company_name,
            'company_address' => $request->company_address,
            'pic_name' => $request->pic_name,
            'pic_phone' => $request->pic_phone,
            'pic_email' => $request->pic_email,
        ]);

        return redirect()->route("suppliers.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return redirect()->route("suppliers.index");
    }
}
