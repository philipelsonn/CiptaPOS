<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransactionHeader;
use App\Models\TransactionDetail;
use App\Models\TransactionHeaderBatch;
use App\Models\TransactionDetailBatch;
use App\Models\Product;
use App\Models\PaymentMethod;
use App\Models\ProductCategory;
use App\Models\SupplierTransaction;
use Illuminate\Support\Facades\Auth;
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
        $totalExecution = 0;
        $count = 0;

        // foreach ($transactionHeaders as $transactionHeader) {
        //     $startTime = microtime(true);

        //     // AES
        //     // $transactionHeader->card_number = Crypt::decrypt($transactionHeader->card_number);

        //     // Triple DES
        //     // $transactionHeader->card_number = $this->threeDESDecryption($transactionHeader->card_number, env('APP_KEY'), $transactionHeader->iv);

        //     // RC4
        //     $transactionHeader->card_number = $this->rc4_decode($transactionHeader->card_number, env('APP_KEY'));
        //     $endTime = microtime(true);
        //     $executionTime = ($endTime - $startTime) * 1000; // Konversi ke milidetik
        //     Log::info("Decryption time for TransactionHeader ID {$transactionHeader->id}: " . $executionTime . " milliseconds");

        // }

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
        $startTime = microtime(true);
        $transactionHeader = new TransactionHeader();
        $transactionHeader->cashier_id = auth()->id();
        $transactionHeader->payment_method_id = $request->payment_method_id;
        $transactionHeader->transaction_date = now();
        $iv = $this->generateRandomIV();
        $transactionHeader->iv = $iv;
        $key = env('APP_KEY');
        Log::info('APP_KEY value: ' . $key);

        if ($request->card_number) {
            $transactionHeader->card_number = $request->card_number;
            // $startTime = microtime(true);

            // AES
            // $transactionHeader->card_number = Crypt::encrypt($request->card_number);

            //Triple DES
            // $transactionHeader->card_number = $this->threeDESEncryption($request->card_number, env('APP_KEY'), $iv);
            // $transactionHeader->card_number = $this->threeDESEncryption($request->card_number, env('APP_KEY'), $iv);

            // RC4
            // $transactionHeader->card_number = $this->rc4_encode($request->card_number, env('APP_KEY'));
            // $endTime = microtime(true);
            // $executionTime = ($endTime - $startTime) * 1000; // Konversi ke milidetik
            // Log::info("Encryption time for TransactionHeader ID {$transactionHeader->id}: " . $executionTime . " milliseconds");

        } else {
            $transactionHeader->card_number = null;
        }

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
        $endTime = microtime(true);
        $executionTime = ($endTime - $startTime) * 1000; // Konversi ke milidetik
        $user = Auth::user();
        Log::info("Encryption time for TransactionHeader ID {$transactionHeader->id} by user ID {$user->id}: " . $executionTime . " milliseconds");

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
        return redirect()->route("transactions.history");
    }

    public function exportTransaction()
    {
        $sourceHeaders = TransactionHeader::with('transactionDetails')
        ->where('is_exported', false)
        ->get();

        foreach ($sourceHeaders as $header) {
            
                //AES
                $card = Crypt::encrypt($header->card_number);
    
                // Triple DES
                // $card  = $this->threeDESEncryption($header->card_number, env('APP_KEY'), $header->iv);
    
                // RC4
                // $card  = $this->rc4_encode($header->card_number, env('APP_KEY'));

            $targetHeader = TransactionHeaderBatch::Create(
                [
                    'payment_method_id' => $header->payment_method_id,
                    'cashier_id' => $header->cashier_id,
                    'card_number' => $card,
                    'iv' => $header->iv,
                    'transaction_date' => $header->transaction_date,
                    'created_at' => $header->created_at,
                    'updated_at' => $header->updated_at,
                ]
            );

            foreach ($header->transactionDetails as $detail) {
                TransactionDetailBatch::Create(
                    [
                        'transaction_header_id' => $targetHeader->id,
                        'product_id' => $detail->product_id,
                        'quantity' => $detail->quantity,
                        'price' => $detail->price,
                        'created_at' => $detail->created_at,
                        'updated_at' => $detail->updated_at,
                    ]
                );
            }

            $header->update(['is_exported' => true]);
        }

        return redirect()->route("transactions.history");
    }

    function generateRandomIV() {
        $randomBytes = random_bytes(4);
        $iv = bin2hex($randomBytes);

        return $iv;
    }

    function threeDESEncryption($data, $secret, $iv)
    {
        $key = $secret;
        $data2 = $data;
        $key .= substr($key, 0, 8);
        $encData = openssl_encrypt($data2, 'des-ede3-cbc', $key, OPENSSL_RAW_DATA, $iv);

        return urlencode(base64_encode($encData));
    }

    function threeDESDecryption($data, $secret, $iv)
    {
        $data2 = urldecode($data);
        $key = $secret;
        $key .= substr($key, 0, 8);
        $data3 = base64_decode($data2);

        return openssl_decrypt($data3, 'des-ede3-cbc', $key, OPENSSL_RAW_DATA, $iv);
    }

    private function rc4_encode(string $string, string $key): string
    {
        $res = $this->rc4($string, $key);
        return bin2hex($res);
    }

    private function rc4_decode(string $string, string $key): string
    {
        // Check if the input string is a valid hex string
        if (!ctype_xdigit($string)) {
            return '';
        }

        // Convert hex to binary
        $binaryData = hex2bin($string);
        return $this->rc4($binaryData, $key);
    }

    private function rc4(string $str, string $key): string
    {
        // Initialize the state array
        $s = range(0, 255);
        $j = 0;

        // Key scheduling algorithm (KSA)
        $keyLength = strlen($key);
        for ($i = 0; $i < 256; $i++) {
            $j = ($j + $s[$i] + ord($key[$i % $keyLength])) % 256;
            // Swap s[$i] and s[$j]
            [$s[$i], $s[$j]] = [$s[$j], $s[$i]];
        }

        // Pseudo-random generation algorithm (PRGA)
        $i = 0;
        $j = 0;
        $output = '';

        for ($y = 0; $y < strlen($str); $y++) {
            $i = ($i + 1) % 256;
            $j = ($j + $s[$i]) % 256;

            // Swap s[$i] and s[$j]
            [$s[$i], $s[$j]] = [$s[$j], $s[$i]];

            // Calculate the key stream and XOR with the input string
            $keyStream = chr($s[($s[$i] + $s[$j]) % 256]);
            $output .= $str[$y] ^ $keyStream;
        }

        return $output;
    }
}
