<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculadoraController;

// get cuando entra por primera vez
Route::get('/', [CalculadoraController::class, 'index'])->name('calculadora.index'); // da nombre especifico a la ruta te llama a la funcion

// post cada vez que el usuario aprieta un boton
Route::post('/', [CalculadoraController::class, 'calcular'])->name('calculadora.calcular');