<?php
use App\Http\Controllers\TirarDadoController;

Route::get('/', [TirarDadoController::class, 'index'])->name('tirardado.index');
Route::post('/tirar', [TirarDadoController::class, 'tirar'])->name('tirardado.tirar');
Route::post('/reiniciar', [TirarDadoController::class, 'reiniciar'])->name('tirardado.reiniciar');