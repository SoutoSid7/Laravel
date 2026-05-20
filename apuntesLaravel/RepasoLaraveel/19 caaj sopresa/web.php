<?php
use App\Http\Controllers\CajasController;

Route::get('/', [CajasController::class, 'index'])->name('cajas.index');
Route::post('/abrir', [CajasController::class, 'abrir'])->name('cajas.abrir');
Route::post('/reiniciar', [CajasController::class, 'reiniciar'])->name('cajas.reiniciar');