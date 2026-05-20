<?php

use App\Http\Controllers\JuegoController;
use Illuminate\Support\Facades\Route;

Route::get('/juego', [JuegoController::class, 'inicializacion'])->name('mayor.inicializacion');
Route::post('/juego/turno', [JuegoController::class, 'jugar'])->name('mayor.jugar');
Route::post('/juego/reiniciar', [JuegoController::class, 'reiniciar'])->name('mayor.reiniciar');