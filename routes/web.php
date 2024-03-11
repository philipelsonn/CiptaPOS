<?php

use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;


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
Route::get('/employee', function () {
    return view('employee.employeelist');
})->middleware(['auth', 'verified'])->name('employee');

Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction.store');

Route::get('/employees', [ProfileController::class, 'index'])->middleware(['auth', 'verified'])->name('employee.index');



Route::resource('payment-methods',PaymentMethodController::class)->except([
    'create', 'edit', 'show'
]);
Route::resource('product-categories',ProductCategoryController::class)->except([
    'create', 'edit', 'show'
]);

Route::resource('products',ProductController::class)->except([
    'create', 'edit', 'show'
]);

Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');

Route::get('transactions', [TransactionController::class, 'index']);



require __DIR__.'/auth.php';
