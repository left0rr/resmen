<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\MenuitemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::controller(MenuitemController::class)->group(function () {
    Route::view('/', 'welcome');
    Route::get('/menu', [MenuitemController::class, 'index'])->name('menu');
    Route::get('/menu/{category}', [MenuitemController::class, 'show']);
    Route::post('/menu/{category}', [MenuitemController::class, 'store'])->name('menuitems.store');
    Route::delete('/menu/{menuitem}', [MenuitemController::class, 'destroy'])->name('menuitem.destroy');
    Route::patch('/menu/{menuitem}', [MenuitemController::class, 'update'])->name('menuitem.update');




});
Route::post('/api/discounts', [DiscountController::class, 'applyDiscount']);



Route::controller(CategoryController::class)->group(function () {
    Route::delete('menu/{category}', [CategoryController::class, 'destroy']);
    Route::post('/menu', [CategoryController::class, 'store'])->name('categories.store');
    Route::patch('/categories/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/category/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');

    });

Route::post('/apply-discount', [DiscountController::class, 'applyDiscount']);


Route::post('/checkout', [OrderController::class, 'store'])->name('orders.store');

Route::get('/orders', [OrderController::class, 'index'])->name('orders');
Route::patch('/orders/{order}/mark-served', [OrderController::class, 'markAsServed'])->name('orders.mark-served');


Route::get('/history', [OrderController::class, 'history'])->name('history');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
