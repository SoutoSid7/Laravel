<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Mayor o Menor que 5</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>¿Mayor o Menor que 5?</h1>
    <p>Saldrá un número del 1 al 10. ¿Será mayor o menor que 5?</p>
    <p>Aciertos: {{ $aciertos }} | Fallos: {{ $fallos }}</p>

    @if ($numero)
        <h1 style="font-size: 80px;">{{ $numero }}</h1>
    @endif

    <form action="{{ route('mm5.jugar') }}" method="POST">
        @csrf
        <button type="submit" name="apuesta" value="menor">Menor que 5</button>
        <button type="submit" name="apuesta" value="mayor">Mayor que 5</button>
    </form>

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('mm5.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>