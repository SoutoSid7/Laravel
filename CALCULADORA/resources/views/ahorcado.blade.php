@php
    $palabra = session('palabra');
    $letras = session('letras', []);
    $errores = session('errores', 0);
    $maxErrores = 6;

    $oculta = '';
    $ganado = true;

    foreach (str_split($palabra) as $char) {
        if (in_array($char, $letras)) {
            $oculta .= strtoupper($char) . ' ';
        } else {
            $oculta .= '_ ';
            $ganado = false;
        }
    }

    $perdido = $errores >= $maxErrores;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ahorcado</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #1e293b;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .game {
            background: #334155;
            padding: 40px;
            border-radius: 20px;
            width: 700px;
            box-shadow: 0 20px 40px rgba(0,0,0,.3);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .layout {
            display: flex;
            gap: 40px;
            align-items: center;
        }

        .hangman {
            position: relative;
            width: 220px;
            height: 280px;
        }

        .base {
            position: absolute;
            bottom: 0;
            left: 20px;
            width: 120px;
            height: 6px;
            background: white;
        }

        .pole {
            position: absolute;
            bottom: 0;
            left: 70px;
            width: 6px;
            height: 240px;
            background: white;
        }

        .top {
            position: absolute;
            top: 40px;
            left: 70px;
            width: 90px;
            height: 6px;
            background: white;
        }

        .rope {
            position: absolute;
            top: 40px;
            left: 155px;
            width: 4px;
            height: 30px;
            background: white;
        }

        .part {
            display: none;
            position: absolute;
            background: white;
        }

        .head {
            top: 70px;
            left: 135px;
            width: 40px;
            height: 40px;
            border: 4px solid white;
            border-radius: 50%;
            background: transparent;
        }

        .body {
            top: 114px;
            left: 153px;
            width: 4px;
            height: 70px;
        }

        .arm-left {
            top: 130px;
            left: 130px;
            width: 35px;
            height: 4px;
            transform: rotate(-35deg);
            transform-origin: right;
        }

        .arm-right {
            top: 130px;
            left: 155px;
            width: 35px;
            height: 4px;
            transform: rotate(35deg);
            transform-origin: left;
        }

        .leg-left {
            top: 185px;
            left: 130px;
            width: 35px;
            height: 4px;
            transform: rotate(-45deg);
            transform-origin: right;
        }

        .leg-right {
            top: 185px;
            left: 155px;
            width: 35px;
            height: 4px;
            transform: rotate(45deg);
            transform-origin: left;
        }

        .show {
            display: block;
        }

        .word {
            font-size: 2rem;
            letter-spacing: 10px;
            margin: 20px 0;
        }

        input {
            padding: 12px;
            width: 60px;
            font-size: 1.5rem;
            text-align: center;
            border: none;
            border-radius: 10px;
        }

        button {
            padding: 12px 20px;
            border: none;
            background: #3b82f6;
            color: white;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1rem;
        }

        button:hover {
            background: #2563eb;
        }

        .used {
            color: #cbd5e1;
        }

        .message {
            font-size: 1.4rem;
            font-weight: bold;
        }

        .win {
            color: #22c55e;
        }

        .lose {
            color: #ef4444;
        }
    </style>
</head>
<body>
    <div class="game">
        <h1>Ahorcado Laravel</h1>

        <div class="layout">
            <div class="hangman">
                <div class="base"></div>
                <div class="pole"></div>
                <div class="top"></div>
                <div class="rope"></div>

                <div class="head part {{ $errores >= 1 ? 'show' : '' }}"></div>
                <div class="body part {{ $errores >= 2 ? 'show' : '' }}"></div>
                <div class="arm-left part {{ $errores >= 3 ? 'show' : '' }}"></div>
                <div class="arm-right part {{ $errores >= 4 ? 'show' : '' }}"></div>
                <div class="leg-left part {{ $errores >= 5 ? 'show' : '' }}"></div>
                <div class="leg-right part {{ $errores >= 6 ? 'show' : '' }}"></div>
            </div>

            <div>
                <p class="word">{{ $oculta }}</p>

                <p>Errores: {{ $errores }}/{{ $maxErrores }}</p>

                <p class="used">
                    Letras usadas:
                    {{ implode(', ', array_map('strtoupper', $letras)) }}
                </p>

                @if ($ganado)
                    <p class="message win">¡Ganaste!</p>
                @elseif ($perdido)
                    <p class="message lose">Perdiste. Era {{ strtoupper($palabra) }}</p>
                @else
                    <form method="POST" action="{{ route('ahorcado.letra') }}">
                        @csrf
                        <input type="text" name="letra" maxlength="1" required autofocus>
                        <button type="submit">Probar</button>
                    </form>
                @endif

                <br>

                <form method="POST" action="{{ route('ahorcado.reiniciar') }}">
                    @csrf
                    <button type="submit">Reiniciar</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>