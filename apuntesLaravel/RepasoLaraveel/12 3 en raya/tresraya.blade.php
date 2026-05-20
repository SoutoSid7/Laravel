<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Tres en Raya</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>⭕❌ Tres en Raya</h1>

    <form action="{{ route('tres.jugar') }}" method="POST">
        @csrf
        <table style="margin: 20px auto; border-collapse: collapse;">
            @for ($f = 0; $f < 3; $f++)
                <tr>
                    @for ($c = 0; $c < 3; $c++)
                        @php $i = $f * 3 + $c; @endphp
                        <td style="border:2px solid #333; padding: 0;">
                            @if ($tablero[$i] !== '')
                                <div style="width:70px;height:70px;line-height:70px;font-size:40px;">{{ $tablero[$i] }}</div>
                            @elseif (!$fin)
                                <button type="submit" name="casilla" value="{{ $i }}" style="width:70px;height:70px;font-size:30px;"> </button>
                            @else
                                <div style="width:70px;height:70px;"></div>
                            @endif
                        </td>
                    @endfor
                </tr>
            @endfor
        </table>
    </form>

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('tres.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>