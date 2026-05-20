<?php
use App\Http\Controllers\RuletaController;

Route::get('/', [RuletaController::class, 'index'])->name('ruleta.index');
Route::post('/jugar', [RuletaController::class, 'jugar'])->name('ruleta.jugar');
Route::post('/reiniciar', [RuletaController::class, 'reiniciar'])->name('ruleta.reiniciar');