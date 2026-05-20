<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Escalera</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>🪜 Escalera Peligrosa</h1>
    <h2>Escalón: {{ $escalon }} / {{ $meta }}</h2>
    <p>Caídas: {{ $caidas }} | Intentos: {{ $subidas }}</p>

    <div style="margin:20px;">
        @for ($i = $meta; $i >= 0; $i--)
            <div>{{ $i }} {{ $escalon === $i ? '🧗' : '' }}</div>
        @endfor
    </div>

    @if (!$ganado)
        <form action="{{ route('escalera.subir') }}" method="POST">
            @csrf
            <button type="submit">⬆️ Subir</button>
        </form>
    @endif

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('escalera.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>