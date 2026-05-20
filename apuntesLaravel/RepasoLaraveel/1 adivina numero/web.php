<?php

use App\Http\Controllers\AdivinaNumeroController;

Route::get('/', [AdivinaNumeroController::class, 'index'])->name('adivina.index');
Route::post('/jugar', [AdivinaNumeroController::class, 'jugar'])->name('adivina.jugar');
Route::post('/reiniciar', [AdivinaNumeroController::class, 'reiniciar'])->name('adivina.reiniciar');