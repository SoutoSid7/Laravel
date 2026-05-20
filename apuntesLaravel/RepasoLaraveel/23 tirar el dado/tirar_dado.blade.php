<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Tirar Dado</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>🎲 Tirar Dado</h1>

    @if ($dado)
        <h1 style="font-size: 100px;">{{ $dado }}</h1>
    @endif

    <form action="{{ route('tirardado.tirar') }}" method="POST">
        @csrf
        <button type="submit" style="font-size: 20px; padding: 10px;">Tirar dado</button>
    </form>

    @if (count($historial) > 0)
        <h3>Historial: {{ implode(', ', $historial) }}</h3>
        <p>Total tiradas: {{ count($historial) }}</p>
    @endif

    <form action="{{ route('tirardado.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>