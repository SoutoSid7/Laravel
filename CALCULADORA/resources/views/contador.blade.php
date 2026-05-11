<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Contador</title>
    <style>
        body {
            font-family: sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 80px;
        }

        h1 {
            font-size: 80px;
            margin-bottom: 20px;
            color: #333;
        }

        form { display: inline; }

        button {
            padding: 10px 24px;
            font-size: 18px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin: 4px;
        }

        .sumar {
            background-color: red;
            color: white;
        }

        .restar {
            background-color: blue;
            color: white;
        }


    </style>
</head>
<body>
    <h1>{{ $contador }}</h1>

    <form action="{{ route('contador.increment') }}" method="POST">
        @csrf
        <button type="submit" class="sumar">+</button>
    </form>

    <form action="{{ route('contador.decrement') }}" method="POST">
        @csrf
        <button type="submit" class="restar">-</button>
    </form>

    <form action="{{ route('contador.reset') }}" method="POST">
        @csrf
        <button type="submit">Limpiar</button>
    </form>
</body>
</html>