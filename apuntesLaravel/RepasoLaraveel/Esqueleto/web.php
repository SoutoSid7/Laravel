<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JuegoController;

Route::get('/', [JuegoController::class, 'index'])->name('juego.index');
Route::post('/jugar', [JuegoController::class, 'jugar'])->name('juego.jugar');
Route::post('/reiniciar', [JuegoController::class, 'reiniciar'])->name('juego.reiniciar');