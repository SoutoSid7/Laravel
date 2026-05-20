<?php
use App\Http\Controllers\DadoController;

Route::get('/', [DadoController::class, 'index'])->name('dado.index');
Route::post('/jugar', [DadoController::class, 'jugar'])->name('dado.jugar');
Route::post('/reiniciar', [DadoController::class, 'reiniciar'])->name('dado.reiniciar');