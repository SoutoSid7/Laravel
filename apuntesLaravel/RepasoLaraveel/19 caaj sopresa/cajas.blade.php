<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Caja Sorpresa</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>🎁 Caja Sorpresa</h1>
    <p>Premios: {{ $premios }} / 3 | Rondas: {{ $rondas }} / {{ $max }}</p>

    @if (!$ganado && $rondas < $max)
        <h3>Elige una caja:</h3>
        <form action="{{ route('cajas.abrir') }}" method="POST">
            @csrf
            @for ($i = 1; $i <= 3; $i++)
                <button type="submit" name="caja" value="{{ $i }}" style="font-size:60px; padding:10px;">📦</button>
            @endfor
        </form>
    @endif

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('cajas.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>