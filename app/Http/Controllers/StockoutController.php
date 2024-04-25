<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stockout;
use App\Models\Product;

class StockoutController extends Controller
{
    public function index()
    {

        return view('stockout.index',[
            'stockouts' => Stockout::all(),
            'products' => Product::all(),
        ]);
    }
    public function store(Request $request)
    {

        // Buat entri baru dalam tabel stockout
        $stockout = Stockout::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'description' => $request->description,
            'date'=> now(),
        ]);

        $product = Product::findOrFail($request->product_id);
        $product->stock -= $request->quantity;
        $product->save();

        return redirect()->route('stockout.index');
    }
    public function destroy(Stockout $stockout)
    {
        // Simpan kuantitas produk sebelumnya
        $previousQuantity = $stockout->product->stock;

         // Hapus stockout
         $stockout->delete();

        // Hitung selisih kuantitas
        $quantityDifference = $stockout->quantity;

        // Mengembalikan kuantitas produk
        $product = $stockout->product;
        $product->stock += $quantityDifference;
        $product->save();

        return redirect()->route('stockout.index');
    }

}
