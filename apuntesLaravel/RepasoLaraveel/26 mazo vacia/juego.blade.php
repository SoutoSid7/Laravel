<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Juego Mazo Real</title>
    <style>
        body { text-align: center; font-family: sans-serif; padding: 20px; }
        .alerta { padding: 15px; margin: 10px auto; width: 50%; font-weight: bold; border-radius: 5px; }
        .exito { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .carta { font-size: 40px; font-weight: bold; border: 2px solid black; padding: 20px; display: inline-block; border-radius: 10px; margin: 20px; }
    </style>
</head>
<body>
    <h1>Mayor o Menor (Modo Extremo)</h1>

    {{-- ZONA DE MENSAJES FLASH --}}
    @if (session('exito'))
        <div class="alerta exito">{{ session('exito') }}</div>
    @endif

    @if (session('error'))
        <div class="alerta error">{{ session('error') }}</div>
    @endif

    {{-- ESTADO DEL JUEGO --}}
    <p><strong>Cartas restantes en el mazo:</strong> {{ count(session('mazo', [])) }}</p>
    <p><strong>Racha actual:</strong> {{ session('racha', 0) }} / 5</p>

    <div class="carta">
        {{ session('carta_actual') }}
    </div>

    {{-- BOTONES DE JUEGO (Solo si no ha ganado) --}}
    @if (!session('ganado'))
        <form action="{{ route('juego.jugar') }}" method="POST">
            @csrf
            <button type="submit" name="apuesta" value="mayor">La siguiente es MAYOR</button>
            <button type="submit" name="apuesta" value="menor">La siguiente es MENOR</button>
        </form>
    @endif

    <br><br>

    {{-- BOTÓN DE REINICIAR SIEMPRE VISIBLE --}}
    <form action="{{ route('juego.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar Partida</button>
    </form>

    <hr>

    {{-- TOP 3 RANKING --}}
    <h3>🏆 Top 3 Mejores Tiempos</h3>
    <ul style="list-style: none; padding: 0;">
        @forelse (session('ranking', []) as $indice => $tiempo)
            <li><strong>#{{ $indice + 1 }}</strong> - {{ $tiempo }} segundos</li>
        @empty
            <li>Aún no hay récords registrados.</li>
        @endforelse
    </ul>

</body>
</html>