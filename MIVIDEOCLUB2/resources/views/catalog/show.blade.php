@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-sm-4">
        <img src="{{ $pelicula['poster'] }}" style="height:200px">
    </div>

    <div class="col-sm-8">
        <h2>{{ $pelicula['title'] }}</h2>
        <p><strong>Año:</strong>{{ $pelicula['year'] }}</p>
        <p><strong>Director:</strong>{{ $pelicula['director'] }}</p>
        <p><strong>Sinopsis:</strong>{{ $pelicula['synopsis'] }}</p>

        {{-- Boton para editar la pelicula --}}
        <a href="{{ url('/catalog/edit/' .$pelicula->id) }}" class="btn btn-warning mt-3">Editar Pelicula</a> 

        {{-- Boton para volver atras --}}
        <a href="{{ url('/catalog/') }}" class="btn btn-primary mt3">Volver al Listado</a>
    </div>
</div>

@endsection