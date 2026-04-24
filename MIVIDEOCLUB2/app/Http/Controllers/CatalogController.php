<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function getIndex()
    {
		$arrayPeliculas = Movie::all(); // Recupera todos los registros de la tabla asociada al modelo Movie

		return view('catalog.index', array(
			'arrayPeliculas' => $arrayPeliculas // Envia los datos a la vista
			/*
			* A la vista se le pasa una variable llamada arrayPeliculas
			* Con los datos de Movie::all();
			*/
		));
	}

    public function getShow($id)
    {
        $pelicula = Movie::findOrFail($id);

		return view('catalog.show', array(
			'pelicula' => $pelicula
		));
    }

	public function getEdit($id)
	{
		$pelicula = Movie::findOrFail($id);

		return view('catalog.edit', array(
			'pelicula' => $pelicula
		));
	}

    public function getCreate()
    {
        return view('catalog.create');
    }

	public function postCreate(Request $request)
	{
		$request->validate([
			'title' => 'required',
			'year' => 'required|integer',
			'director' => 'required',
			'poster' => 'nullable',
			'rented' => 'required|boolean',
			'synopsis' => 'required'
		]);

		// Guardar en la BD
		Movie::create([
			'title' => $request->title,
			'year' => $request->year,
			'director' => $request->director,
			'poster' => $request->poster,
			'rented' => $request->rented,
			'synopsis' => $request->synopsis,
		]);

		// Redirección
		return redirect('catalog');
	}
}
