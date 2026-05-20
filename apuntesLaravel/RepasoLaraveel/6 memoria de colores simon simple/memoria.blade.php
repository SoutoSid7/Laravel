<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Memoria de Colores</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>🎨 Memoria de Colores</h1>
    <p>Nivel: {{ $nivel }}</p>

    @if ($mostrar)
        <h2>Memoriza la secuencia:</h2>
        <div style="font-size: 24px;">{{ implode(' → ', $secuencia) }}</div>
        <form action="{{ route('memoria.ocultar') }}" method="POST">
            @csrf
            <button type="submit">Ya la memoricé</button>
        </form>
    @else
        <h2>Repite la secuencia:</h2>
        <form action="{{ route('memoria.jugar') }}" method="POST">
            @csrf
            @foreach ($colores as $c)
                <button type="submit" name="color" value="{{ $c }}" style="background:{{ $c }}; color:white; padding:15px;">{{ $c }}</button>
            @endforeach
        </form>
    @endif

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('memoria.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>