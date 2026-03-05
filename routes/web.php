<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeverancierController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('home');
});

// User Story 1: Wijzigen Leverancier
Route::get('/leveranciers', [LeverancierController::class, 'index'])->name('leveranciers.index');
Route::get('/leveranciers/{id}', [LeverancierController::class, 'details'])->name('leveranciers.details');
Route::get('/leveranciers/{id}/edit', [LeverancierController::class, 'edit'])->name('leveranciers.edit');
Route::post('/leveranciers/{id}/update', [LeverancierController::class, 'update'])->name('leveranciers.update');
Route::get('/leveranciers/{id}/products', [LeverancierController::class, 'showProducts'])->name('leveranciers.products');

// (Existing) User Story: Product levering (left intact)
Route::get('/leveranciers/{leverancierId}/products/{productId}/levering', [ProductController::class, 'showLeveringForm'])->name('producten.levering.form');
Route::post('/leveranciers/{leverancierId}/products/{productId}/levering', [ProductController::class, 'storeLevering'])->name('producten.levering.store');
