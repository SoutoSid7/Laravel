<?php

use App\Http\Controllers\BarajaController;
use Illuminate\Support\Facades\Route;


Route::get('/', [BarajaController::class, 'index'])->name('baraja.index');
Route::post('/jugar', [BarajaController::class, 'jugar'])->name('baraja.jugar');
Route::post('/reiniciar', [BarajaController::class, 'reiniciar'])->name('baraja.reiniciar');
