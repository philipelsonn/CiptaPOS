<?php

use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockoutController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierPricingController;
use App\Http\Controllers\SupplierTransactionController;
use App\Models\Product;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('register', [RegisteredUserController::class, 'store'])->name('employee.add');
});

Route::post('employee', [RegisteredUserController::class, 'destroy'])->name('employees.destroy');

Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction.store');

Route::get('/employees', [ProfileController::class, 'index'])->middleware(['auth', 'verified'])->name('employees.index');

Route::resource('payment-methods', PaymentMethodController::class)->except([
    'create', 'edit', 'show'
]);

Route::resource('product-categories', ProductCategoryController::class)->except([
    'create', 'edit', 'show'
]);

Route::resource('products', ProductController::class)->except([
    'create', 'edit', 'show'
]);

Route::resource('suppliers', SupplierController::class)->except([
    'create', 'edit', 'show'
]);

Route::resource('supplier-pricings', SupplierPricingController::class)->except([
    'create', 'edit', 'show'
]);

Route::resource('supplier-transactions', SupplierTransactionController::class)->except([
    'create', 'edit', 'show'
]);

Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

Route::get('transactions', [TransactionController::class, 'index']);

Route::get('transactions/history', [TransactionController::class, 'showHistory'])->name('transactions.history');
Route::delete('transactions/history', [TransactionController::class, 'destroy']);


Route::resource('/stockout',StockoutController::class)->except([
    'create', 'edit', 'show'
]);

Route::get('/search', function () {
    $query = request()->query('q');
    // Lakukan pencarian berdasarkan nilai $query
    // Misalnya, menggunakan model Product dan metode pencarian seperti where atau search
    $results = Product::where('name', 'like', '%'.$query.'%')->get();
    return response()->json($results);
});
Route::get('/product/search', [ProductController::class, 'search'])->name('product/search');

Route::get('/products/by_category', [ProductController::class, 'getByCategory'])->name('products.by_category');






require __DIR__.'/auth.php';
