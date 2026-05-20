<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Suma Rápida</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>➕ Suma Rápida</h1>
    <p>Racha: {{ $racha }}/5 | Fallos: {{ $fallos }}/3</p>

    @if (!$ganado && $fallos < 3)
        <h1>{{ $num1 }} + {{ $num2 }} = ?</h1>
        <form action="{{ route('suma.jugar') }}" method="POST">
            @csrf
            <input type="number" name="respuesta" required autofocus>
            <button type="submit">Enviar</button>
        </form>
    @endif

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('suma.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>