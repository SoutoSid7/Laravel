<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Carrera de Caballos</title></head>
<body style="font-family:sans-serif; padding:20px;">
    <h1 style="text-align:center;">🐎 Carrera de Caballos</h1>
    <p style="text-align:center;">Meta: {{ $meta }} casillas</p>

    @foreach ($caballos as $id => $pos)
        <div style="margin:10px 0;">
            <strong>Caballo {{ $id }}:</strong>
            {{ str_repeat('🐎', min($pos, $meta)) }} ({{ $pos }})
            @if ($apuesta === $id) ⭐ @endif
        </div>
    @endforeach

    <div style="text-align:center; margin-top:20px;">
        @if (!$apuesta)
            <h3>Elige un caballo:</h3>
            <form action="{{ route('carrera.apostar') }}" method="POST">
                @csrf
                @for ($i = 1; $i <= 3; $i++)
                    <button type="submit" name="caballo" value="{{ $i }}">Caballo {{ $i }}</button>
                @endfor
            </form>
        @elseif (!$ganador)
            <form action="{{ route('carrera.avanzar') }}" method="POST">
                @csrf
                <button type="submit">Siguiente turno</button>
            </form>
        @endif

        @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

        <form action="{{ route('carrera.reiniciar') }}" method="POST" style="margin-top:20px;">
            @csrf
            <button type="submit">Reiniciar</button>
        </form>
    </div>
</body>
</html>