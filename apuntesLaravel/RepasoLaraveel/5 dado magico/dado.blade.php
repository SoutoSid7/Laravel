<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Dado Mágico</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>🎲 Dado Mágico</h1>
    <p>Racha: {{ $racha }} / 3 | Tiradas totales: {{ $tiradas }}</p>

    @if ($dado)
        <h1 style="font-size: 80px;">{{ $dado }}</h1>
    @endif

    @if (!$ganado)
        <form action="{{ route('dado.jugar') }}" method="POST">
            @csrf
            <p>Apuesta a un número:</p>
            @for ($i = 1; $i <= 6; $i++)
                <button type="submit" name="apuesta" value="{{ $i }}">{{ $i }}</button>
            @endfor
        </form>
    @else
        <h2>🏆 ¡GANASTE!</h2>
    @endif

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('dado.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>