<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Ahorcado</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>Ahorcado</h1>
    <h2 style="letter-spacing: 5px;">{{ $mostrada }}</h2>
    <p>Fallos: {{ count($fallos) }} / {{ $max_fallos }}</p>
    <p>Letras falladas: {{ implode(', ', $fallos) }}</p>

    @if (!$ganado && !$perdido)
        <form action="{{ route('ahorcado.jugar') }}" method="POST">
            @csrf
            <input type="text" name="letra" maxlength="1" required style="width:40px; text-align:center;">
            <button type="submit">Probar</button>
        </form>
    @elseif ($ganado)
        <h2>🎉 ¡Ganaste! La palabra era: {{ $palabra }}</h2>
    @else
        <h2>💀 Perdiste. La palabra era: {{ $palabra }}</h2>
    @endif

    @if ($mensaje)<p>{{ $mensaje }}</p>@endif

    <form action="{{ route('ahorcado.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Nueva palabra</button>
    </form>
</body>
</html>