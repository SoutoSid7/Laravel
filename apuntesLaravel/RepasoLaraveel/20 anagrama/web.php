<?php
use App\Http\Controllers\AnagramaController;

Route::get('/', [AnagramaController::class, 'index'])->name('anagrama.index');
Route::post('/jugar', [AnagramaController::class, 'jugar'])->name('anagrama.jugar');
Route::post('/reiniciar', [AnagramaController::class, 'reiniciar'])->name('anagrama.reiniciar');