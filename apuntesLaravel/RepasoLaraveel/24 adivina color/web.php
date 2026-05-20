<?php

use App\Http\Controllers\AdivinaColorController;

Route::get('/', [AdivinaColorController::class, 'index'])->name('adivinacolor.index');
Route::post('/jugar', [AdivinaColorController::class, 'jugar'])->name('adivinacolor.jugar');
Route::post('/reiniciar', [AdivinaColorController::class, 'reiniciar'])->name('adivinacolor.reiniciar');