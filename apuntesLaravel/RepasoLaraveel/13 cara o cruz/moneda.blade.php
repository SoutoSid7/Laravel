<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Cara o Cruz</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>🪙 Cara o Cruz</h1>
    <h2>Monedas: {{ $monedas }} / 20</h2>
    <p>Tiradas: {{ $tiradas }}</p>

    @if ($resultado)
        <h2>Salió: {{ strtoupper($resultado) }}</h2>
    @endif

    @if ($monedas > 0 && $monedas < 20)
        <form action="{{ route('moneda.jugar') }}" method="POST">
            @csrf
            <button type="submit" name="apuesta" value="cara">Cara</button>
            <button type="submit" name="apuesta" value="cruz">Cruz</button>
        </form>
    @endif

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('moneda.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>