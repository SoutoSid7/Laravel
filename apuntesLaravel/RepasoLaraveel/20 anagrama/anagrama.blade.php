<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Anagrama</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>🔤 Anagrama</h1>
    <p>Aciertos: {{ $aciertos }} / 3 | Intentos: {{ $intentos }} / 3</p>

    @if (!$fin)
        <h2 style="letter-spacing:10px; font-size:40px;">{{ strtoupper($desordenada) }}</h2>
        <form action="{{ route('anagrama.jugar') }}" method="POST">
            @csrf
            <input type="text" name="intento" required autofocus>
            <button type="submit">Probar</button>
        </form>
    @endif

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('anagrama.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Nueva partida</button>
    </form>
</body>
</html>