<?php
use App\Http\Controllers\AhorcadoController;

Route::get('/', [AhorcadoController::class, 'index'])->name('ahorcado.index');
Route::post('/jugar', [AhorcadoController::class, 'jugar'])->name('ahorcado.jugar');
Route::post('/reiniciar', [AhorcadoController::class, 'reiniciar'])->name('ahorcado.reiniciar');