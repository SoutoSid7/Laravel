<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Pesca</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>🎣 Pesca de Peces</h1>
    <h2>Puntos: {{ $puntos }}</h2>
    <p>Lanzamientos: {{ $lanzamientos }} / {{ $max }}</p>

    @if ($lanzamientos < $max)
        <form action="{{ route('pesca.lanzar') }}" method="POST">
            @csrf
            <button type="submit" style="font-size:25px; padding:15px;">🎣 Lanzar anzuelo</button>
        </form>
    @endif

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    @if (count($pesca) > 0)
        <h3>Historial:</h3>
        <ul style="list-style:none; padding:0;">
            @foreach ($pesca as $p)
                <li>{{ $p }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('pesca.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>