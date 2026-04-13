<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('login', function () {
    return 'Login Usuario';
});

Route::get('logout', function () {
    return 'Logout Usuario';
});

Route::get('catalog', function () {
    return 'Listado Películas';
});

Route::get('catalog/show/{id?}', function ($id = 0) {
    return 'Vista detalle película ' .$id;
});

Route::get('catalog/create', function () {
    return 'Añadir película';
});

Route::get('catalog/edit/{id?}', function ($id = 0) {
    return 'Modificar película ' .$id;
});