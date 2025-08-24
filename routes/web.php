<?php

use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierController;



Route::resource('tasks', TaskController::class);
Route::get('/', [TaskController::class, 'index']); // হোম পেজ হিসেবে টাস্কের তালিকা দেখাবে
Route::resource('tasks', TaskController::class);

// টাস্কের অবস্থা পরিবর্তনের জন্য অতিরিক্ত রাউট
Route::put('/tasks/{task}/toggle-complete', [TaskController::class, 'toggleComplete'])->name('tasks.toggle');

Route::resource('suppliers', SupplierController::class);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
