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
    </div>
</div>

@endsection