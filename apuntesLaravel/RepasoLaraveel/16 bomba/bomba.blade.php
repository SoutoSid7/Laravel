<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Bomba</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>💣 Desactiva la Bomba</h1>
    <p>Cables cortados: {{ $cortes }}</p>

    @if ($estado === 'jugando')
        <h2 style="font-size:80px;">💣</h2>
        <form action="{{ route('bomba.cortar') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">✂️ Cortar cable</button>
        </form>
        <form action="{{ route('bomba.desactivar') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">🛑 Desactivar ahora</button>
        </form>
    @elseif ($estado === 'desactivada')
        <h2 style="font-size:80px;">✅</h2>
    @else
        <h2 style="font-size:80px;">💥</h2>
    @endif

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('bomba.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Nueva bomba</button>
    </form>
</body>
</html>