<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculadoraController;
use App\Http\Controllers\SesionController;
use App\Http\Controllers\AhorcadoController;

Route::get('/',           [CalculadoraController::class, 'index'])->name('calculadora');
Route::post('/digito',    [CalculadoraController::class, 'digito'])->name('digito');
Route::post('/operacion', [CalculadoraController::class, 'operacion'])->name('operacion');
Route::post('/calcular',  [CalculadoraController::class, 'calcular'])->name('calcular');
Route::post('/unaria',    [CalculadoraController::class, 'unaria'])->name('unaria');
Route::post('/activar',   [CalculadoraController::class, 'activar'])->name('activar');
Route::post('/borrar',    [CalculadoraController::class, 'borrar'])->name('borrar');
Route::post('/limpiar',   [CalculadoraController::class, 'limpiar'])->name('limpiar');

//Sesion
Route::get('/sesion',            [SesionController::class, 'index'])->name('contador.index');
Route::post('/sesion/increment', [SesionController::class, 'increment'])->name('contador.increment');
Route::post('/sesion/decrement', [SesionController::class, 'decrement'])->name('contador.decrement');
Route::post('/sesion/reset',     [SesionController::class, 'reset'])->name('contador.reset');

//Ahorcado
Route::get('/ahorcado', [AhorcadoController::class, 'index'])->name('ahorcado.index');
Route::post('/ahorcado/letra', [AhorcadoController::class, 'probarLetra'])->name('ahorcado.letra');
Route::post('/ahorcado/reiniciar', [AhorcadoController::class, 'reiniciar'])->name('ahorcado.reiniciar');