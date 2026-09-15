<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StyleCategoryController;
use App\Http\Controllers\StyleOptionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('dashboard'));

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.attempt');
});

Route::middleware('access')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('customers', CustomerController::class);
    Route::post('customers/{customer}/measurements', [CustomerController::class, 'storeMeasurement'])->name('customers.measurements.store');
    Route::resource('orders', OrderController::class)->except(['edit', 'update']);
    Route::patch('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::patch('/orders/{order}/assign', [OrderController::class, 'assignStaff'])->name('orders.assign');
    Route::get('/orders/{order}/invoice/create', [InvoiceController::class, 'create'])->name('invoices.create');
    Route::post('/orders/{order}/invoice', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::post('/invoices/{invoice}/payment', [InvoiceController::class, 'recordPayment'])->name('invoices.payment');

    Route::resource('staff', StaffController::class)->except('show');

    Route::resource('style-categories', StyleCategoryController::class)->except(['show']);
    Route::post('/style-categories/{styleCategory}/options', [StyleOptionController::class, 'store'])->name('style-options.store');
    Route::put('/style-options/{styleOption}', [StyleOptionController::class, 'update'])->name('style-options.update');
    Route::delete('/style-options/{styleOption}', [StyleOptionController::class, 'destroy'])->name('style-options.destroy');
    Route::resource('users', UserController::class)->except('show');
});
