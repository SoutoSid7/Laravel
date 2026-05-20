<?php
use App\Http\Controllers\BlackjackController;

Route::get('/', [BlackjackController::class, 'index'])->name('bj.index');
Route::post('/pedir', [BlackjackController::class, 'pedir'])->name('bj.pedir');
Route::post('/plantar', [BlackjackController::class, 'plantar'])->name('bj.plantar');
Route::post('/reiniciar', [BlackjackController::class, 'reiniciar'])->name('bj.reiniciar');