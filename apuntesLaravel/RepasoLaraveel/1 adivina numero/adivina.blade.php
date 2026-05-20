<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Adivina el Número</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>Adivina el Número (1-100)</h1>
    <p>Intentos: {{ $intentos }} / {{ $max_intentos }}</p>

    @if (!$ganado && !$perdido)
        <form action="{{ route('adivina.jugar') }}" method="POST">
            @csrf
            <input type="number" name="numero" min="1" max="100" required>
            <button type="submit">Probar</button>
        </form>
    @endif

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    @if (count($historial) > 0)
        <p>Intentos: {{ implode(', ', $historial) }}</p>
    @endif

    <form action="{{ route('adivina.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>