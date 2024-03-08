<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('payment-methods.index',[
            'paymentMethods' => PaymentMethod::all()
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

        PaymentMethod::create([
            "name" => $request->name,
        ]);

        return redirect()->route("payment-methods.index");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod)
    {
        $request->validate([
            'name'=>'required|string',
        ]);

        $paymentMethod->update([
            'name'=>$request->name,
        ]);

        return redirect()->route('payment-methods.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        $paymentMethod->delete();

        return redirect()->route("payment-methods.index");
    }
}
