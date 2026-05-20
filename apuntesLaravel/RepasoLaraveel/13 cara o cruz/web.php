<?php
use App\Http\Controllers\MonedaController;

Route::get('/', [MonedaController::class, 'index'])->name('moneda.index');
Route::post('/jugar', [MonedaController::class, 'jugar'])->name('moneda.jugar');
Route::post('/reiniciar', [MonedaController::class, 'reiniciar'])->name('moneda.reiniciar');