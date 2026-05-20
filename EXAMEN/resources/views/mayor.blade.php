<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mayor</title>
</head>
<body>
    <h1>La Carta Mayor</h1>

    <!-- Puntos -->
    <table>
        <thead>
            <tr>
                <th>Tus Puntos</th>
                <th>Puntos Maquina</th>
                <th>Mazo Restante</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>{{  session('puntos_jugador')  }}</th>
                <th>{{  session('puntos_maquina')  }}</th>
                <th>{{  session('mazo_restante')  }}</th>
            </tr>
        </tbody>
    </table>

    <!-- Imagenes -->
    <div>
        <h3>Tu Carta</h3>
        <img src="{{ '../img/card_back.svg' }}" width="150">

        <h3>Carta Maquina</h3>
        <img src="{{ '../img/card_back.svg' }}" width="150">
    </div>
    
    <!-- SI todavia no hay mazo muestra los botones -->
    @if(!session('mazo_restante' > 0))
        <form action="{{ route('mayor.jugar') }}" method="POST">
            @csrf
            <button type="submit" name="jugar_turno" value="jugar_turno">Jugar Turno</button>
        </form>
    @endif

    <form action="{{ route('mayor.reiniciar') }}" method="POST">
        @csrf
        <br><button type="submit">Reiniciar</button>
    </form>
</body>
</html>