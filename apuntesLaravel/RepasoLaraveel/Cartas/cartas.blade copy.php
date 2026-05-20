<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mayor o Menor</title>
</head>
<body>
    <div style="text-align: center; padding: 20px; font-family: sans-serif;">
        
        <h1>Mayor o Menor</h1>

        {{-- 
           LÍNEA DE LA IMAGEN DE LA CARTA:
           - De dónde sale $imagenes: Es el array con las 12 rutas de imágenes creado en el método privado del controlador.
           - De dónde sale $numero_actual: Es el número aleatorio (del 1 al 12) que se guardó en la sesión al inicializar o en la jugada anterior.
           
           ¿POR QUÉ RESTAMOS 1? ($numero_actual - 1)
           Los arrays en PHP empiezan en el índice 0. Por tanto:
           - La carta 1 está en $imagenes[0]
           - La carta 2 está en $imagenes[1]
           - La carta 12 está en $imagenes[11]
           Si $numero_actual vale 5, al restarle 1 pedimos $imagenes[4], que corresponde exactamente a 'img/carta5.png'.
           
           Las llaves dobles {{ }} equivalen al "echo" de PHP nativo (imprimen el texto en el HTML).
        --}}
        <img src="{{ $imagenes[$numero_actual - 1] }}"
             alt="Carta {{ $numero_actual }}"
             style="width: 180px; margin: 20px auto;">

        {{-- 
           MUESTRA DE RACHA:
           - De dónde sale $racha: Viene de session('racha') inyectado por el controlador. 
           - Qué hace: Pinta un texto dinámico en pantalla, por ejemplo: "Racha: 3 / 5".
        --}}
        <p>Racha: {{ $racha }} / 5</p>

        {{-- 
           CONDICIONAL DE CONTROL DE FLUJO (@if / @else):
           - De dónde sale $ganado: Es un booleano (true/false) que viene de la sesión.
           
           - Qué hace: Si $ganado es FALSE (el símbolo ! significa "NO"), se muestra el formulario para seguir jugando.
             Si es TRUE, el juego se "bloquea" ocultando los botones y mostrando el mensaje de victoria.
        --}}
        @if (!$ganado)
            {{-- 
               FORMULARIO DE APUESTA:
               - action="{{ route('juego.jugar') }}": Llama al "apodo" de la ruta POST que definiste en web.php. 
                 Laravel la convertirá en la URL real (ej: http://localhost:8000/cartas).
               - method="POST": Indica que vamos a enviar datos de forma segura para procesar lógica.
            --}}
            <form action="{{ route('juego.jugar') }}" method="POST" style="display:inline;">
                
                {{-- 
                   DIRECTIVA @csrf (Token de Seguridad):
                   - Qué hace: Genera un campo oculto <input type="hidden" name="_token" value="..."> con un código único y temporal.
                   - Por qué es obligatorio: Laravel exige esto en todos los formularios POST para evitar ataques de falsificación de peticiones en sitios cruzados.
                     Si se te olvida ponerlo en el examen, al pulsar el botón te dará un "Error 419 Page Expired".
                --}}
                @csrf
                
                {{-- 
                   BOTONES DE ACCIÓN:
                   - Ambos botones comparten el mismo name="apuesta".
                   - Al pulsar "Menor", el formulario viaja al controlador llevando el dato ['apuesta' => 'baja'].
                   - Al pulsar "Mayor", viaja llevando el dato ['apuesta' => 'alta'].
                   - En el controlador lo atrapas usando: $request->input('apuesta').
                --}}
                <button type="submit" name="apuesta" value="baja">Menor</button>
                <button type="submit" name="apuesta" value="alta">Mayor</button>
            </form>
        @else
            {{-- Si la racha llegó a 5, $ganado es true, entramos aquí y pintamos el h2 --}}
            <h2> ¡Ganaste!</h2>
        @endif

        {{-- 
           MENSAJE DE RETROALIMENTACIÓN:
           - De dónde sale $mensaje: Viene de session('mensaje'). Al principio está vacío ('').
           - Qué hace: Si contiene texto (porque acabas de acertar o fallar), evalúa como verdadero y lo pinta en un párrafo `<p>`.
             Si está vacío, Blade no pinta nada, evitando dejar un hueco en blanco feo.
        --}}
        @if ($mensaje)
            <p>{{ $mensaje }}</p>
        @endif

        {{-- 
           FORMULARIO DE REINICIO:
           - Qué hace: Un botón independiente que hace un POST a la ruta 'juego.reiniciar'.
           - Lleva su propio @csrf porque es un formulario POST independiente.
           - Al pulsarlo, el controlador destruirá la sesión o reescribirá los valores a 0 para empezar limpio.
        --}}
        <form action="{{ route('juego.reiniciar') }}" method="POST" style="margin-top: 20px;">
            @csrf
            <button type="submit">Reiniciar</button>
        </form>
    </div>
</body>
</html>