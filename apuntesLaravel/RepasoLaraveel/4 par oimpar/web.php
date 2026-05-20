<?php

use App\Http\Controllers\ParImparController;

Route::get('/', [ParImparController::class, 'index'])->name('parimpar.index');
Route::post('/jugar', [ParImparController::class, 'jugar'])->name('parimpar.jugar');
Route::post('/reiniciar', [ParImparController::class, 'reiniciar'])->name('parimpar.reiniciar');