<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('ruta1', function () {
    return 'Ruta1';
});

Route::get('ruta/{id?}', function ($id = 0) {
    return $id;
});


