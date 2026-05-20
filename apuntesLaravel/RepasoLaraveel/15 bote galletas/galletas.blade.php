<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Bote de Galletas</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>🍪 Bote de Galletas</h1>
    <h2>{{ $galletas }} / {{ $meta }}</h2>
    <p>Clicks: {{ $clicks }}</p>
    @if ($mejor)<p>🥇 Mejor récord: {{ $mejor }} clicks</p>@endif

    <div style="width:300px; margin:20px auto; background:#eee; height:30px;">
        <div style="width:{{ min(100, ($galletas/$meta)*100) }}%; background:brown; height:100%;"></div>
    </div>

    @if ($galletas < $meta)
        <form action="{{ route('galletas.meter') }}" method="POST">
            @csrf
            <button type="submit" style="font-size:30px; padding:20px;">🍪 Meter</button>
        </form>
    @endif

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('galletas.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>