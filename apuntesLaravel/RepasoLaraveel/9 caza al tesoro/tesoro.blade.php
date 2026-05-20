<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Caza al Tesoro</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>🏴‍☠️ Caza al Tesoro</h1>
    <p>Intentos: {{ $intentos }} / {{ $max }}</p>

    <form action="{{ route('tesoro.jugar') }}" method="POST">
        @csrf
        <table style="margin: 20px auto; border-collapse: collapse;">
            @for ($f = 0; $f < 3; $f++)
                <tr>
                    @for ($c = 1; $c <= 3; $c++)
                        @php $n = $f * 3 + $c; @endphp
                        <td style="border:1px solid #333; padding: 0;">
                            @if (in_array($n, $probadas))
                                <div style="width:60px;height:60px;background:#ccc;line-height:60px;">
                                    {{ ($ganado || $perdido) && $n === $tesoro ? '💰' : '❌' }}
                                </div>
                            @elseif (!$ganado && !$perdido)
                                <button type="submit" name="casilla" value="{{ $n }}" style="width:60px;height:60px;">{{ $n }}</button>
                            @else
                                <div style="width:60px;height:60px;background:#eee;line-height:60px;">{{ $n }}</div>
                            @endif
                        </td>
                    @endfor
                </tr>
            @endfor
        </table>
    </form>

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('tesoro.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>