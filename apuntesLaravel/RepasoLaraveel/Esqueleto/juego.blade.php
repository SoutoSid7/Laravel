<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Juego Laravel</title>
</head>
<body>
    <div style="text-align: center; padding: 20px; font-family: sans-serif;">
        
        <h1>Título del Juego</h1>

        {{-- 1. ZONA DE INFORMACIÓN Y ESTADO --}}
        {{-- Aquí muestras imágenes, números secretos, puntos, rachas... --}}
        <p>Puntos / Racha: {{ $puntos }}</p>
        
        {{-- Ejemplo por si necesitas mostrar una imagen (comentado) --}}
        {{-- <img src="{{ $imagen_actual }}" style="width: 150px; margin: 10px;"> --}}

        <hr style="margin: 20px 0;">

        {{-- 2. ZONA DE JUEGO (Se oculta si ya ha terminado) --}}
        @if (!$fin_partida)
            
            <form action="{{ route('juego.jugar') }}" method="POST" style="display:inline;">
                @csrf
                
                {{-- OPCIÓN A: Si el juego es de escribir algo (Adivina número, ahorcado) --}}
                {{-- <label>Introduce tu jugada:</label>
                <input type="text" name="jugada" required autofocus>
                <button type="submit">Enviar</button> --}}

                {{-- OPCIÓN B: Si el juego es de pulsar botones (Mayor/Menor, Piedra/Papel) --}}
                <button type="submit" name="apuesta" value="opcion_1">Botón 1</button>
                <button type="submit" name="apuesta" value="opcion_2">Botón 2</button>
                
            </form>

        @else
            {{-- Mensaje grande de victoria o derrota --}}
            <h2>¡Partida Finalizada!</h2>
        @endif

        <br><br>

        {{-- 3. ZONA DE MENSAJE DEL CONTROLADOR --}}
        {{-- Muestra "Has acertado", "Fallaste", etc., solo si el controlador envía texto --}}
        @if ($mensaje)
            <p style="font-size: 18px; font-weight: bold;">{{ $mensaje }}</p>
        @endif

        {{-- 4. BOTÓN DE REINICIAR (Siempre visible) --}}
        <form action="{{ route('juego.reiniciar') }}" method="POST" style="margin-top: 20px;">
            @csrf
            <button type="submit" style="padding: 5px 15px;">Reiniciar Partida</button>
        </form>

    </div>
</body>
</html>


<!--
¿Qué tiene que devolver tu Controlador para que esta vista no falle?
Para que esta vista funcione a la perfección, el return view() de tu método index() en el Controlador siempre debe pasarle estas variables base:

PHP
return view('juego', [
    'puntos'      => session('puntos', 0),
    'fin_partida' => session('fin_partida', false),
    'mensaje'     => session('mensaje', ''), // Vacío por defecto para que no de error
    // 'imagen_actual' => session('imagen_actual') // Si el juego usa imágenes
]);
-->