<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Ruleta</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>🎰 Ruleta de la Fortuna</h1>
    <h2>Puntos: {{ $puntos }} / 500</h2>
    <p>Tiradas: {{ $tiradas }}</p>

    @if ($color)
        <h2 style="color: {{ $color === 'rojo' ? 'red' : 'black' }};">Salió: {{ strtoupper($color) }}</h2>
    @endif

    @if ($puntos > 0 && $puntos < 500)
        <form action="{{ route('ruleta.jugar') }}" method="POST">
            @csrf
            <input type="number" name="cantidad" min="1" max="{{ $puntos }}" placeholder="Cantidad" required>
            <button type="submit" name="apuesta_color" value="rojo" style="background:red; color:white;">Rojo</button>
            <button type="submit" name="apuesta_color" value="negro" style="background:black; color:white;">Negro</button>
        </form>
    @endif

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('ruleta.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>