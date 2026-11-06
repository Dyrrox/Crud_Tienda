<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CustomersController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class, 'verLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/products', function () {
    return view('products');
});

Route::get('/products', [ProductsController::class, 'index']);
Route::post('/products', [ProductsController::class, 'store'])->name('products.store');
Route::put('/products/{product}', [ProductsController::class, 'update'])->name('products.update');
Route::delete('/products/{product}', [ProductsController::class, 'destroy'])->name('products.destroy');

Route::get('/clientes', [CustomersController::class, 'index']);
Route::post('/clientes', [CustomersController::class, 'store'])->name('customers.store');
Route::put('/clientes/{customer}', [CustomersController::class, 'update'])->name('customers.update');
Route::delete('/clientes/{customer}', [CustomersController::class, 'destroy'])->name('customers.destroy');

