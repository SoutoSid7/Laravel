<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CatalogController; 

Route::get('/', [HomeController::class, 'getHome']);

Route::get('catalog', [CatalogController::class, 'getIndex']);

Route::get('catalog/show/{id}', [CatalogController::class, 'getShow']);

Route::get('catalog/create', [CatalogController::class, 'getCreate']);

/**
 * Solo responde a peticiones POST
 * CatalogController::class, 'postCreate' --> Cuando alguien haga POST a esa URL 'postCreate'
 * name('catalog.create') --> Le pone nombre a la ruta
 */
Route::post('catalog/create', [CatalogController::class, 'postCreate'])->name('catalog.create');

Route::get('catalog/edit/{id}', [CatalogController::class, 'getEdit']);
Route::put('catalog/edit/{id}', [CatalogController::class, 'putEdit'])->name('catalog.edit.{id}');