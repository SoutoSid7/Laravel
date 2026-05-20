<?php
use App\Http\Controllers\PiedraPapelController;

Route::get('/', [PiedraPapelController::class, 'index'])->name('ppt.index');
Route::post('/jugar', [PiedraPapelController::class, 'jugar'])->name('ppt.jugar');
Route::post('/reiniciar', [PiedraPapelController::class, 'reiniciar'])->name('ppt.reiniciar');