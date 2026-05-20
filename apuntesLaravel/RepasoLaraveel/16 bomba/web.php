<?php
use App\Http\Controllers\BombaController;

Route::get('/', [BombaController::class, 'index'])->name('bomba.index');
Route::post('/cortar', [BombaController::class, 'cortar'])->name('bomba.cortar');
Route::post('/desactivar', [BombaController::class, 'desactivar'])->name('bomba.desactivar');
Route::post('/reiniciar', [BombaController::class, 'reiniciar'])->name('bomba.reiniciar');