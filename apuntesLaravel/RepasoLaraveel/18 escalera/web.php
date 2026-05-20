<?php
use App\Http\Controllers\EscaleraController;

Route::get('/', [EscaleraController::class, 'index'])->name('escalera.index');
Route::post('/subir', [EscaleraController::class, 'subir'])->name('escalera.subir');
Route::post('/reiniciar', [EscaleraController::class, 'reiniciar'])->name('escalera.reiniciar');