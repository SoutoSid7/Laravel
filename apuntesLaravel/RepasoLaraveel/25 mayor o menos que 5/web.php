<?php
use App\Http\Controllers\MayorMenor5Controller;

Route::get('/', [MayorMenor5Controller::class, 'index'])->name('mm5.index');
Route::post('/jugar', [MayorMenor5Controller::class, 'jugar'])->name('mm5.jugar');
Route::post('/reiniciar', [MayorMenor5Controller::class, 'reiniciar'])->name('mm5.reiniciar');