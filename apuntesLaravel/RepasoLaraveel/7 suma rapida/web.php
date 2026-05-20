<?php
use App\Http\Controllers\SumaController;

Route::get('/', [SumaController::class, 'index'])->name('suma.index');
Route::post('/jugar', [SumaController::class, 'jugar'])->name('suma.jugar');
Route::post('/reiniciar', [SumaController::class, 'reiniciar'])->name('suma.reiniciar');