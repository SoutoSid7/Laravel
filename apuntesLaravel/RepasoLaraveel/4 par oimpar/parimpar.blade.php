<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Par o Impar</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>Par o Impar</h1>
    <p>Aciertos: {{ $aciertos }} / 5 | Fallos: {{ $fallos }} / 3</p>

    @if ($numero !== null)
        <h2>Último número: {{ $numero }}</h2>
    @endif

    @if ($aciertos < 5 && $fallos < 3)
        <form action="{{ route('parimpar.jugar') }}" method="POST">
            @csrf
            <button type="submit" name="apuesta" value="par">Par</button>
            <button type="submit" name="apuesta" value="impar">Impar</button>
        </form>
    @endif

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('parimpar.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>