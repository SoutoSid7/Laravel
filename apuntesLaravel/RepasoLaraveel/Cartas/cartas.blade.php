<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mayor o Menor</title>
</head>
<body>
    <div style="text-align: center; padding: 20px; font-family: sans-serif;">
        <h1>Mayor o Menor</h1>

        {{-- Imagen actual: usamos el array y restamos 1 porque empieza en 0 --}}
        <img src="{{ $imagenes[$numero_actual - 1] }}"
             alt="Carta {{ $numero_actual }}"
             style="width: 180px; margin: 20px auto;">

        <p>Racha: {{ $racha }} / 5</p>

        @if (!$ganado)
            <form action="{{ route('juego.jugar') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" name="apuesta" value="baja">Menor</button>
                <button type="submit" name="apuesta" value="alta">Mayor</button>
            </form>
        @else
            <h2> ¡Ganaste!</h2>
        @endif

        @if ($mensaje)
            <p>{{ $mensaje }}</p>
        @endif

        <form action="{{ route('juego.reiniciar') }}" method="POST" style="margin-top: 20px;">
            @csrf
            <button type="submit">Reiniciar</button>
        </form>
    </div>
</body>
</html>