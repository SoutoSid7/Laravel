<?php
use App\Http\Controllers\TresRayaController;

Route::get('/', [TresRayaController::class, 'index'])->name('tres.index');
Route::post('/jugar', [TresRayaController::class, 'jugar'])->name('tres.jugar');
Route::post('/reiniciar', [TresRayaController::class, 'reiniciar'])->name('tres.reiniciar');