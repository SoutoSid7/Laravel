<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baraja</title>
</head>
<body>

    <h1>Juego Mayor o Menor</h1>

    @if(session('ganado'))
        <h2>¡Has ganado! 5 aciertos seguidos</h2>
    @endif

    @if(session('imagen_anterior'))
        <p>Carta anterior:</p>
        <img src="{{ asset('img/' . session('imagen_anterior')) }}" width="150">
    @endif

    <p>Carta actual:</p>
    <img src="{{ asset('img/' . session('imagen_actual')) }}" width="150">

    <p>Puntos: {{ session('puntos') }}</p>

    @if(!session('ganado'))
        <form action="{{ route('baraja.jugar') }}" method="POST">
            @csrf
            <button type="submit" name="eleccion" value="mayor">Mayor</button>
            <button type="submit" name="eleccion" value="menor">Menor</button>
        </form>
    @endif

    <form action="{{ route('baraja.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>

</body>
</html>