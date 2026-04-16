@extends('layouts.master')
@section('content')


<div class="row">
    <div class="col-sm-4">
        <img src="{{ $arrayPeliculas['poster'] }}" style="height:200px">
    </div>

    <div class="col-sm-8">
        <h2>{{ $arrayPeliculas['title'] }}</h2>
        <p><strong>Año:</strong>{{ $arrayPeliculas['year'] }}</p>
        <p><strong>Director:</strong>{{ $arrayPeliculas['director'] }}</p>
        <p><strong>Sinopsis:</strong>{{ $arrayPeliculas['synopsis'] }}</p>
    </div>
</div>
@endsection