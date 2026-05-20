<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Piedra Papel Tijera</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>Piedra, Papel o Tijera</h1>
    <h2>Tú: {{ $jugador }} - Máquina: {{ $maquina }}</h2>
    <p>Ronda: {{ $ronda }}</p>

    @if ($jugador < 5 && $maquina < 5)
        <form action="{{ route('ppt.jugar') }}" method="POST">
            @csrf
            <button type="submit" name="eleccion" value="piedra">🪨 Piedra</button>
            <button type="submit" name="eleccion" value="papel">📄 Papel</button>
            <button type="submit" name="eleccion" value="tijera">✂️ Tijera</button>
        </form>
    @endif

    @if ($eleccion_jugador)
        <p>Tú elegiste: <strong>{{ $eleccion_jugador }}</strong> | Máquina: <strong>{{ $eleccion_maquina }}</strong></p>
    @endif

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('ppt.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>