<?php
use App\Http\Controllers\MemoriaController;

Route::get('/', [MemoriaController::class, 'index'])->name('memoria.index');
Route::post('/jugar', [MemoriaController::class, 'jugar'])->name('memoria.jugar');
Route::post('/ocultar', [MemoriaController::class, 'ocultar'])->name('memoria.ocultar');
Route::post('/reiniciar', [MemoriaController::class, 'reiniciar'])->name('memoria.reiniciar');