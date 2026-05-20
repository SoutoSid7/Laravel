<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JuegoCartasController;

Route::get('/juego', [JuegoCartasController::class, 'index'])->name('juego.index');
Route::post('/juego/levantar', [JuegoCartasController::class, 'levantar'])->name('juego.levantar');
Route::post('/juego/comprobar', [JuegoCartasController::class, 'comprobar'])->name('juego.comprobar');
Route::post('/juego/reiniciar', [JuegoCartasController::class, 'reiniciar'])->name('juego.reiniciar');