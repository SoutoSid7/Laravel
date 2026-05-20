<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Par o Impar</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>Par o Impar</h1>
    <p>Aciertos: {{ $aciertos }} | Fallos: {{ $fallos }}</p>

    @if ($numero)
        <h2>Último número: {{ $numero }}</h2>
    @endif

    <form action="{{ route('parimparsimple.jugar') }}" method="POST">
        @csrf
        <button type="submit" name="apuesta" value="par">Par</button>
        <button type="submit" name="apuesta" value="impar">Impar</button>
    </form>

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('parimparsimple.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>