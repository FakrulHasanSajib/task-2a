<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseOrderController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// টাস্ক ম্যানেজমেন্টের জন্য রুট
Route::resource('tasks', TaskController::class);

// হোম পেজ
Route::get('/', [TaskController::class, 'index']);

// টাস্কের অবস্থা পরিবর্তনের জন্য অতিরিক্ত রুট
Route::put('/tasks/{task}/toggle-complete', [TaskController::class, 'toggleComplete'])->name('tasks.toggle');

// সাপ্লাইয়ার ম্যানেজমেন্টের জন্য রুট
Route::resource('suppliers', SupplierController::class);

// প্রোডাক্ট ম্যানেজমেন্টের জন্য রুট
Route::resource('products', ProductController::class);

// পারচেজ ম্যানেজমেন্টের জন্য রুট
Route::resource('purchases', PurchaseController::class);

// পারচেজ অর্ডারের জন্য Laravel Resource Controller ব্যবহার করা হচ্ছে
// এটি স্বয়ংক্রিয়ভাবে index, create, store, show, edit, update, destroy রুট তৈরি করবে
Route::resource('purchase-orders', PurchaseOrderController::class);

// ড্যাশবোর্ড রুট
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// প্রোফাইল ম্যানেজমেন্টের জন্য রুট
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';