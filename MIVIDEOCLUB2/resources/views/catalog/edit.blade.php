@extends('layouts.master')
@section('content')

    <div class="container">
        <h2>Editar Pelicula</h2>

        <form action="{{ url('catalog/edit/' . $pelicula->id) }}" method="POST"> <!-- Envia a la ruta de web -->
            @csrf <!-- Obligatorio -->
            @method('PUT') 
            <div class="form-group">
                <label for="title">Titulo:</label>
                <input type="text" name="title" value=" {{$pelicula->title}} " readonly>
            </div>

            <div class="form-group">
                <label for="year">Año:</label>
                <input type="text" name="year" value=" {{$pelicula->year}} ">
            </div>

            <div class="form-group">
                <label for="director">Director:</label>
                <input type="text" name="director" value=" {{$pelicula->director}} ">
            </div>

            <div class="form-group">
                <label for="poster">Poster:</label>
                <input type="text" name="poster" value=" {{$pelicula->poster}} ">
            </div>

            <div class="form-group">
                <label for="rented">Alquilada:</label>
                <select name="rented">
                    <option value="1">Si</option>
                    <option value="0">No</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="synopsis">Synopsis:</label>
                <textarea name="synopsis">{{ $pelicula->synopsis }}</textarea>
            </div>
            <button type="submit">Guardar</button>
        </form>
    </div>

@endsection