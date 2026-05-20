<?php
use App\Http\Controllers\TesoroController;

Route::get('/', [TesoroController::class, 'index'])->name('tesoro.index');
Route::post('/jugar', [TesoroController::class, 'jugar'])->name('tesoro.jugar');
Route::post('/reiniciar', [TesoroController::class, 'reiniciar'])->name('tesoro.reiniciar');