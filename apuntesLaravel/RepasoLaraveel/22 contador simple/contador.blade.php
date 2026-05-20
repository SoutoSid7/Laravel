<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Contador</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>Contador</h1>
    <h1 style="font-size: 80px;">{{ $contador }}</h1>

    <form action="{{ route('contador.sumar') }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit">+1</button>
    </form>

    <form action="{{ route('contador.restar') }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit">-1</button>
    </form>

    <form action="{{ route('contador.reiniciar') }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit">Reset</button>
    </form>
</body>
</html>