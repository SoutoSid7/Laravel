<?php

use App\Http\Controllers\GalletasController;

Route::get('/', [GalletasController::class, 'index'])->name('galletas.index');
Route::post('/meter', [GalletasController::class, 'meter'])->name('galletas.meter');
Route::post('/reiniciar', [GalletasController::class, 'reiniciar'])->name('galletas.reiniciar');