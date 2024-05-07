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
use App\Http\Controllers\DashboardController;
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

require __DIR__.'/auth.php';

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    //Transaction
    Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction.store');
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions', [TransactionController::class, 'index'])->name("transactions.dashboard");
    Route::get('/product-transactions/receipt/{id}', [TransactionController::class, 'showReceipt'])->name('product.transactions.receipt');


    //Product
    Route::get('/product/search', [ProductController::class, 'search'])->name('product/search');
    Route::get('/products/by_category', [ProductController::class, 'getByCategory'])->name('products.by_category');
    Route::get('/search', function () {
        $query = request()->query('q');
        $results = Product::where('name', 'like', '%'.$query.'%')->get();
        return response()->json($results);
    });

    Route::middleware(['check.admin'])->group(function () {
        //Employees
        Route::delete('/employees/{employee}', [ProfileController::class, 'destroy'])->name('employees.destroy');
        Route::post('register', [RegisteredUserController::class, 'store'])->name('employees.add');
        Route::get('/employees', [ProfileController::class, 'index'])->name('employees.index');
        Route::get('transactions/history', [TransactionController::class, 'showHistory'])->name('transactions.history');
        Route::delete('transactions/history', [TransactionController::class, 'destroy']);

        Route::resource('products', ProductController::class)->except(['create', 'edit', 'show']);
        Route::resource('suppliers', SupplierController::class)->except(['create', 'edit', 'show']);
        Route::resource('supplier-pricings', SupplierPricingController::class)->except(['create', 'edit', 'show']);
        Route::resource('supplier-transactions', SupplierTransactionController::class)->except(['create', 'edit', 'show']);
        Route::resource('/stockout', StockoutController::class)->except(['create', 'edit', 'show']);
        Route::resource('payment-methods', PaymentMethodController::class)->except(['create', 'edit', 'show']);
        Route::resource('product-categories', ProductCategoryController::class)->except(['create', 'edit', 'show']);
    });

});
