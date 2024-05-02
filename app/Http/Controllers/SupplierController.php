<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();

        foreach ($suppliers as $supplier) {
            $supplier->company_address = Crypt::decryptString($supplier->company_address);
            $supplier->pic_name = Crypt::decryptString($supplier->pic_name);
            $supplier->pic_phone = Crypt::decryptString($supplier->pic_phone);
            $supplier->pic_email = Crypt::decryptString($supplier->pic_email);
        }

        return view('suppliers.index', ['suppliers' => $suppliers]);
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
            'company_address' => Crypt::encryptString($request->company_address),
            'pic_name' => Crypt::encryptString($request->pic_name),
            'pic_phone' => Crypt::encryptString($request->pic_phone),
            'pic_email' => Crypt::encryptString($request->pic_email),
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
            'company_address' => Crypt::encryptString($request->company_address),
            'pic_name' => Crypt::encryptString($request->pic_name),
            'pic_phone' => Crypt::encryptString($request->pic_phone),
            'pic_email' => Crypt::encryptString($request->pic_email),
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
