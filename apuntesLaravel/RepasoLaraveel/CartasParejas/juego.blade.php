<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Juego de Cartas - Vista Única</title>
    <style>
        .cartas-container { display: flex; gap: 10px; margin-top: 20px; margin-bottom: 20px; }
        .carta { width: 100px; height: 150px; background-color: black; border: 2px solid black; display: inline-block; border-radius: 5px; }
        .carta.volteada { background-color: white; border: 2px solid #ccc; }
        .carta.volteada img { width: 100%; height: 100%; object-fit: contain; }
        .alerta { padding: 15px; margin: 20px 0; border-radius: 5px; font-weight: bold; width: 60%; }
        .acierto { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .fallo { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body style="font-family: sans-serif; padding: 20px;">

    {{-- El mensaje de bienvenida siempre se muestra arriba [cite: 60, 104] --}}
    <h1>Bienvenid@, {{ session('usuario') }}</h1>

    {{-- --- ESTADO 1: MOSTRAR RESULTADO --- --}}
    @if (session()->has('resultado'))
        @php $res = session('resultado'); @endphp

        <div class="alerta {{ $res['acierto'] ? 'acierto' : 'fallo' }}">
            @if ($res['acierto'])
                {{-- Mensaje de Acierto [cite: 74, 107] --}}
                ¡Acierto posiciones {{ $res['pos1'] }} y {{ $res['pos2'] }} después de {{ $res['intentos'] }} intentos!
                <p style="font-weight: normal; font-size: 14px; margin: 5px 0 0 0;">Se le sumará 1 punto, así como {{ $res['intentos'] }} intentos en la BD[cite: 75].</p>
            @else
                {{-- Mensaje de Fallo [cite: 74, 105] --}}
                Fallo posiciones {{ $res['pos1'] }} y {{ $res['pos2'] }} después de {{ $res['intentos'] }} intentos.
                <p style="font-weight: normal; font-size: 14px; margin: 5px 0 0 0;">Se le restará 1 punto, así como {{ $res['intentos'] }} intentos en la BD[cite: 76].</p>
            @endif
        </div>

        {{-- Botón para limpiar el resultado y volver a jugar --}}
        <form action="{{ route('juego.reiniciar') }}" method="POST">
            @csrf
            <button type="submit" style="padding: 10px 20px; font-size: 16px; cursor: pointer;">Volver a jugar</button>
        </form>


    {{-- --- ESTADO 2: JUGANDO --- --}}
    @else
        {{-- Caja indicadora de cartas levantadas [cite: 52, 54] --}}
        <div>
            <label>Cartas levantadas:</label>
            <input type="text" value="{{ session('intentos') ?: '' }}" readonly style="width: 50px; text-align: center;">
        </div>

        <br>

        {{-- Formulario dinámico de botones de levantar [cite: 51, 61] --}}
        <form action="{{ route('juego.levantar') }}" method="POST">
            @csrf
            @for ($i = 1; $i <= 6; $i++)
                <button type="submit" name="posicion" value="{{ $i }}">Levantar carta {{ $i }}</button>
            @endfor
        </form>

        <br>

        {{-- Formulario para introducir parejas y comprobar [cite: 52, 63] --}}
        <form action="{{ route('juego.comprobar') }}" method="POST">
            @csrf
            <label style="font-weight: bold; font-size: 20px;">Pareja:</label>
            <input type="number" name="pos1" min="1" max="6" required style="width: 40px;">
            <input type="number" name="pos2" min="1" max="6" required style="width: 40px;">
            <button type="submit">Comprobar</button>
        </form>

        {{-- Tablero de renderizado de cartas [cite: 66] --}}
        <div class="cartas-container">
            @php
                $baraja = session('baraja', []);
                $carta_volteada = session('carta_volteada');
            @endphp

            @for ($i = 1; $i <= 6; $i++)
                @if ($carta_volteada == $i)
                    {{-- Muestra la carta si coincide con el botón pulsado [cite: 51, 67] --}}
                    <div class="carta volteada">
                        <img src="{{ asset('img/' . $baraja[$i - 1]) }}" alt="Carta {{ $i }}">
                    </div>
                @else
                    {{-- El resto se mantienen/vuelven a poner boca abajo automáticamente [cite: 50, 68] --}}
                    <div class="carta"></div>
                @endif
            @endfor
        </div>

        {{-- Botón de reiniciar clásico siempre disponible en partida --}}
        <form action="{{ route('juego.reiniciar') }}" method="POST">
            @csrf
            <button type="submit">Reiniciar Partida</button>
        </form>
    @endif

</body>
</html>