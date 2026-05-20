<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Adivina el Color</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>🎨 Adivina el Color</h1>
    <p>Aciertos: {{ $aciertos }} / {{ $intentos }}</p>

    <h3>¿Qué color estoy pensando?</h3>

    <form action="{{ route('adivinacolor.jugar') }}" method="POST">
        @csrf
        @foreach ($colores as $color)
            <button type="submit" name="color" value="{{ $color }}"
                    style="background:{{ $color }}; color:white; padding:15px; margin:5px;">
                {{ $color }}
            </button>
        @endforeach
    </form>

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('adivinacolor.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Reiniciar</button>
    </form>
</body>
</html>