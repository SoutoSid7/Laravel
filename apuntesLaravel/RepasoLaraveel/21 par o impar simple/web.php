<?php
use App\Http\Controllers\ParImparSimpleController;

Route::get('/', [ParImparSimpleController::class, 'index'])->name('parimparsimple.index');
Route::post('/jugar', [ParImparSimpleController::class, 'jugar'])->name('parimparsimple.jugar');
Route::post('/reiniciar', [ParImparSimpleController::class, 'reiniciar'])->name('parimparsimple.reiniciar');