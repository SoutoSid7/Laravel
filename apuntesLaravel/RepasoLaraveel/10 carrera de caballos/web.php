<?php

use App\Http\Controllers\CarreraController;

Route::get('/', [CarreraController::class, 'index'])->name('carrera.index');
Route::post('/apostar', [CarreraController::class, 'apostar'])->name('carrera.apostar');
Route::post('/avanzar', [CarreraController::class, 'avanzar'])->name('carrera.avanzar');
Route::post('/reiniciar', [CarreraController::class, 'reiniciar'])->name('carrera.reiniciar');