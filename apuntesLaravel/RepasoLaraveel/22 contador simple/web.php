<?php

use App\Http\Controllers\ContadorController;

Route::get('/', [ContadorController::class, 'index'])->name('contador.index');
Route::post('/sumar', [ContadorController::class, 'sumar'])->name('contador.sumar');
Route::post('/restar', [ContadorController::class, 'restar'])->name('contador.restar');
Route::post('/reiniciar', [ContadorController::class, 'reiniciar'])->name('contador.reiniciar');