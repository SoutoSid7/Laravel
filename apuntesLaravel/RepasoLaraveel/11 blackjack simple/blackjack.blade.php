<!DOCTYPE html>
<html lang="es">
<head><meta charset="UTF-8"><title>Blackjack 21</title></head>
<body style="text-align:center; font-family:sans-serif; padding:20px;">
    <h1>🃏 Blackjack 21</h1>

    <h2>Tus cartas: {{ implode(' | ', $cartas) }}</h2>
    <h3>Total: {{ $total }}</h3>

    @if ($plantado)
        <h2>Banca: {{ implode(' | ', $banca) }} → {{ $totalB }}</h2>
    @endif

    @if (!$fin)
        <form action="{{ route('bj.pedir') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Pedir carta</button>
        </form>
        <form action="{{ route('bj.plantar') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Plantarse</button>
        </form>
    @endif

    @if ($mensaje)<p><strong>{{ $mensaje }}</strong></p>@endif

    <form action="{{ route('bj.reiniciar') }}" method="POST">
        @csrf
        <button type="submit">Nueva partida</button>
    </form>
</body>
</html>