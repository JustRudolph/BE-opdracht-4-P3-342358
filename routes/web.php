<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeverancierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AllergeenController;
use App\Http\Controllers\DeliveredProductsController;

Route::get('/', function () {
    return view('home');
});

// User Story 01: Overzicht Geleverde Producten
Route::get('/delivered-products', [DeliveredProductsController::class, 'index'])->name('delivered-products.index');
Route::get('/delivered-products/{productId}/specifications', [DeliveredProductsController::class, 'specifications'])->name('delivered-products.specifications');

// Allergen Overview Routes (User Story 1)
Route::get('/allergeens', [AllergeenController::class, 'index'])->name('allergeens.index');
Route::get('/allergeens/{productId}/supplier-details', [AllergeenController::class, 'supplierDetails'])->name('allergeens.supplier-details');

// User Story 1: Wijzigen Leverancier
Route::get('/leveranciers', [LeverancierController::class, 'index'])->name('leveranciers.index');
Route::get('/leveranciers/{id}', [LeverancierController::class, 'details'])->name('leveranciers.details');
Route::get('/leveranciers/{id}/edit', [LeverancierController::class, 'edit'])->name('leveranciers.edit');
Route::post('/leveranciers/{id}/update', [LeverancierController::class, 'update'])->name('leveranciers.update');
Route::get('/leveranciers/{id}/products', [LeverancierController::class, 'showProducts'])->name('leveranciers.products');

// (Existing) User Story: Product levering (left intact)
Route::get('/leveranciers/{leverancierId}/products/{productId}/levering', [ProductController::class, 'showLeveringForm'])->name('producten.levering.form');
Route::post('/leveranciers/{leverancierId}/products/{productId}/levering', [ProductController::class, 'storeLevering'])->name('producten.levering.store');
