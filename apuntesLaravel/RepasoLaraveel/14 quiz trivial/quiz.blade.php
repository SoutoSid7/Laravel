<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Quiz</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>❓ Quiz</h1>
    <p>Pregunta {{ $actual + ($fin ? 0 : 1) }} / {{ $total }} | Aciertos: {{ $aciertos }}</p>

    @if (!$fin)
        <h2>{{ $pregunta['pregunta'] }}</h2>
        <form action="{{ route('quiz.responder') }}" method="POST">
            @csrf
            @foreach ($pregunta['opciones'] as $i => $opcion)
                <button type="submit" name="opcion" value="{{ $i }}" style="display:block; margin:10px auto; padding:10px;">{{ $opcion }}</button>
            @endforeach
        </form>
    @else
        <h2>🎯 Resultado final: {{ $aciertos }} / {{ $total }}</h2>
        @if ($aciertos === $total)
            <h3>🏆 ¡PERFECTO!</h3>
        @elseif ($aciertos >= $total / 2)
            <h3>👍 Aprobado</h3>
        @else
            <h3>👎 Suspenso</h3>
        @endif
    @endif

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('quiz.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>