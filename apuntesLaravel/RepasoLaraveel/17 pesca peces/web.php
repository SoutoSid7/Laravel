<?php
use App\Http\Controllers\PescaController;

Route::get('/', [PescaController::class, 'index'])->name('pesca.index');
Route::post('/lanzar', [PescaController::class, 'lanzar'])->name('pesca.lanzar');
Route::post('/reiniciar', [PescaController::class, 'reiniciar'])->name('pesca.reiniciar');